<?php
define('BASEPATH', __DIR__);
class CI_Model { public $db; public $session; }
require __DIR__.'/../application/models/Designacoes_model.php';
function checkDesignacao($ok, $mensagem) { if (!$ok) throw new RuntimeException($mensagem); }
class DesignacoesResultado {
    public $rows;
    public function __construct($rows) { $this->rows = $rows; }
    public function row() { return $this->rows[0] ?? null; }
    public function result() { return $this->rows; }
}
class DesignacoesDb {
    public $db_debug = true; public $disponivel = true; public $existeCurso = true;
    public $vinculos = [3]; public $snapshot; public $commit = 0; public $rollback = 0; public $falhar = false;
    public $querys = [];
    public function table_exists($table) { return $this->disponivel; }
    public function field_exists(...$args) { return false; }
    public function trans_begin() { $this->snapshot = $this->vinculos; return true; }
    public function trans_status() { return true; }
    public function trans_commit() { $this->commit++; return true; }
    public function trans_rollback() { $this->rollback++; $this->vinculos = $this->snapshot; return true; }
    public function query($sql, $params) {
        $this->querys[] = [$sql, $params];
        if (strpos($sql, 'SELECT courseid') === 0) return new DesignacoesResultado($this->existeCurso ? [(object) ['courseid'=>$params[0]]] : []);
        if (strpos($sql, 'SELECT id FROM') === 0) return new DesignacoesResultado(array_map(function ($id) { return (object) ['id'=>$id]; }, array_values(array_intersect($params, [1,2]))));
        if (strpos($sql, 'DELETE') === 0) { $this->vinculos = array_values(array_intersect($this->vinculos, array_slice($params, 1))); return true; }
        if (strpos($sql, 'INSERT') === 0) {
            if ($this->falhar && $params[1] === 2) return false;
            $this->vinculos = array_values(array_unique(array_merge($this->vinculos, [$params[1]]))); return true;
        }
        throw new RuntimeException('Consulta inesperada.');
    }
}
$model = new Designacoes_model(); $model->db = new DesignacoesDb();
$model->salvar('URM1226', [1,2,2]);
checkDesignacao($model->db->vinculos === [1,2] && $model->db->commit === 1, 'Adicionar múltiplos, remover anteriores e impedir duplicação');
checkDesignacao(strpos($model->db->querys[0][0], 'FOR UPDATE') !== false && $model->db->querys[0][1] === ['URM1226'], 'Bloqueio por curso e CourseID alfanumérico parametrizado');
$model->salvar('URM1226', []);
checkDesignacao($model->db->vinculos === [], 'Seleção vazia remove todos');
$model->db->vinculos = [3]; $model->db->falhar = true;
try { $model->salvar('111', [1,2]); throw new LogicException('Deveria falhar.'); }
catch (RuntimeException $e) { checkDesignacao($model->db->vinculos === [3], 'Rollback preserva vínculos após falha parcial'); }
$model->db->falhar = false;
try { $model->salvar('111', [99]); throw new LogicException('Deveria rejeitar usuário.'); }
catch (InvalidArgumentException $e) { checkDesignacao($model->db->vinculos === [3], 'Usuário inexistente ou inativo rejeitado'); }
checkDesignacao($model->db->db_debug === true, 'Restaurar configuração do banco após erros');
checkDesignacao($model->condicao_usuario('tpf', 0) === '1 = 0', 'Sem identidade não exibir todos');
checkDesignacao(strpos($model->condicao_usuario('tpf', 42), 'fd_usuario.id_usuario = 42') !== false, 'Escopo aplicado por ID');
$ausente = new Designacoes_model(); $ausente->db = new DesignacoesDb(); $ausente->db->disponivel = false;
checkDesignacao($ausente->condicao_usuario('tpf', 42) === '1 = 0', 'Sem tabela, escopo permanece fechado');
checkDesignacao(strpos($model->join_listagem(), 'LEFT JOIN tbl_portalfarma_user') !== false, 'Join de usuários na consulta da listagem');

class CI_Controller { public $input; public $session; public $load; public $output; public $designacoes_model; }
require __DIR__.'/../application/controllers/restrito/Capacifar.php';
function log_message(...$args) {}
class DesignacoesInput {
    public $raw_input_stream; public $metodo = 'POST';
    public function method($upper = false) { return $this->metodo; }
}
class DesignacoesOutput {
    public $status = 200; public $body;
    public function set_status_header($status) { $this->status = $status; return $this; }
    public function set_content_type($type) { return $this; }
    public function set_output($body) { $this->body = json_decode($body, true); return $this; }
}
class DesignacoesEndpointModel {
    public $id = 42; public $salvou = false;
    public function usuario_sessao() { return $this->id; }
    public function salvar($courseid, $ids) { $this->salvou = true; }
}
foreach ([['POST','token',[1,2],42,200], ['GET','token',[],42,405], ['POST','errado',[],42,403], ['POST','token',[0],42,400], ['POST','token',[],0,403], ['POST','token',[],42,200]] as [$metodo,$token,$ids,$usuario,$http]) {
    $controller = (new ReflectionClass('Capacifar'))->newInstanceWithoutConstructor();
    $controller->input = new DesignacoesInput(); $controller->input->metodo = $metodo;
    $controller->input->raw_input_stream = json_encode(['csrf'=>$token, 'usuarios'=>$ids, 'courseid'=>'111']);
    $controller->session = new class { public function userdata($key) { return 'token'; } };
    $controller->load = new class { public function model(...$args) {} };
    $controller->output = new DesignacoesOutput(); $controller->designacoes_model = new DesignacoesEndpointModel();
    $controller->designacoes_model->id = $usuario;
    $controller->salvar_designacoes();
    checkDesignacao($controller->output->status === $http && $controller->designacoes_model->salvou === ($http === 200), 'Validar método, CSRF, sessão e usuários antes de alterar dados');
}
echo "OK: designações atômicas, remoção, duplicatas, usuários ativos, escopo fechado e validação do endpoint.\n";
