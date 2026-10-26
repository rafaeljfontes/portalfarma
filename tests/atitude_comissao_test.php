<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__ . '/../system/');
require __DIR__ . '/../application/libraries/Atitude_avaliacao.php';
function conferir_comissao($ok, $mensagem) { if (!$ok) throw new RuntimeException($mensagem); }
$regra = new Atitude_avaliacao();
function notas_comissao($nota) { return array_fill_keys(array('relevancia', 'impacto', 'pessoas', 'duracao', 'beneficios'), $nota); }
$validas = array(10 => notas_comissao('1'), 20 => notas_comissao('5'));
$linhas = $regra->preparar($validas, array(10, 20));
conferir_comissao($linhas[0]['nota_final'] == 1 && $linhas[1]['nota_final'] == 5, 'Extremos incorretos.');
$mistas = array(10 => array('relevancia' => '5', 'impacto' => '4', 'pessoas' => '3', 'duracao' => '2', 'beneficios' => '1'));
conferir_comissao($regra->preparar($mistas, array(10))[0]['nota_final'] == 3.3, 'Ponderação incorreta.');
foreach (array(null, array(), array(10 => notas_comissao(2)), $validas + array(30 => notas_comissao(3))) as $invalida) {
    conferir_comissao($regra->preparar($invalida, array(10, 20)) === null, 'Aceitou seleção incompleta ou extra.');
}
foreach (array(0, 6, '1.0', '2e0', '01', true, array(3), null) as $nota) {
    $invalida = $validas; $invalida[10]['impacto'] = $nota;
    conferir_comissao($regra->preparar($invalida, array(10, 20)) === null, 'Aceitou nota inválida.');
}
$invalida = $validas; unset($invalida[20]['duracao']);
conferir_comissao($regra->preparar($invalida, array(10, 20)) === null, 'Aceitou critério ausente.');
$invalida = $validas; $invalida[20]['peso'] = 100;
conferir_comissao($regra->preparar($invalida, array(10, 20)) === null, 'Aceitou critério extra.');
class CI_Model {}
function log_message($nivel, $mensagem) {}
require __DIR__ . '/../application/models/Atitude_comissao_model.php';
class BancoComissaoTeste {
    public $db_debug = true, $rollback = 0, $commit = 0, $modo = '', $linhas, $email;
    public function trans_begin() { return true; }
    public function query($sql, $params = array()) {
        $encontrado = strpos($sql, 'WHERE id_membro') !== false ? $this->modo === 'duplicado' : $this->modo !== 'nao_autorizado';
        return new class($encontrado) {
            private $encontrado;
            public function __construct($e) { $this->encontrado = $e; }
            public function num_rows() { return $this->encontrado ? 1 : 0; }
            public function row() { return (object) array('id' => 7); }
            public function result() { return array((object) array('id' => 10), (object) array('id' => 20)); }
        };
    }
    public function insert($tabela, $dados) { $this->email = $dados['email']; return $this->modo !== 'duplicado'; }
    public function insert_id() { return 7; }
    public function insert_batch($tabela, $linhas) { $this->linhas = $linhas; return $this->modo !== 'falha'; }
    public function trans_status() { return true; }
    public function trans_commit() { $this->commit++; return true; }
    public function trans_rollback() { $this->rollback++; }
    public function error() { return array('code' => $this->modo === 'duplicado' ? 1062 : 999); }
}
#[AllowDynamicProperties]
class ModeloComissaoTeste extends Atitude_comissao_model {}
foreach (array('' => null, 'duplicado' => 'duplicado', 'falha' => 'banco', 'incompleto' => 'notas', 'nao_autorizado' => 'autorizacao') as $modo => $esperado) {
    $model = new ModeloComissaoTeste(); $model->db = new BancoComissaoTeste();
    $model->db->modo = $modo;
    $model->load = new class { public function library($nome) {} };
    $model->atitude_avaliacao = $regra;
    $resultado = $model->registrar('eleitor@example.com', $modo === 'incompleto' ? array(10 => notas_comissao(3)) : $validas);
    conferir_comissao($resultado === $esperado, 'Retorno incorreto: ' . $modo);
    conferir_comissao($model->db->db_debug === true, 'Não restaurou debug.');
    conferir_comissao($model->db->commit === ($esperado === null ? 1 : 0), 'Commit parcial.');
    conferir_comissao($model->db->rollback === ($esperado === null ? 0 : 1), 'Rollback ausente.');
    if ($esperado === null) conferir_comissao(count($model->db->linhas) === 2 && $model->db->linhas[0]['id_membro'] === 7 && !isset($model->db->linhas[0]['id_eleitor']), 'Persistência incompleta.');
}
echo "OK: ponderação, extremos, notas inválidas, critérios/projetos incompletos, duplicidade e transações.\n";
