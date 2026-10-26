<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);
function log_message($nivel, $mensagem) {}
function verificar($ok, $msg) { if (!$ok) throw new RuntimeException($msg); }
require __DIR__ . '/../application/libraries/Portal_email_fila.php';
class BancoFilaTeste {
    public $linhas = array(), $falharEm = 0, $commit = false, $rollback = false;
    public function trans_begin() { return true; }
    public function insert($tabela, $linha) { $this->linhas[] = $linha; return count($this->linhas) !== $this->falharEm; }
    public function insert_id() { return 100 + count($this->linhas); }
    public function trans_status() { return true; }
    public function trans_commit() { $this->commit = true; return true; }
    public function trans_rollback() { $this->rollback = true; }
}
class FilaTeste extends Portal_email_fila {
    public $banco, $indisponivel = false;
    protected function conectar() { if ($this->indisponivel) throw new RuntimeException('Falha simulada'); return $this->banco; }
}
$fila = new FilaTeste(); $fila->banco = new BancoFilaTeste();
verificar($fila->registrar(array('principal@example.com', 'copia@example.com', 'principal@example.com'), 'Assunto', '<p>123456</p>'), 'Registra destinatário e cópia');
verificar($fila->ids === array(101, 102) && $fila->banco->commit, 'Sem duplicatas e confirmação em transação');
foreach ($fila->banco->linhas as $linha) {
    verificar($linha['status'] === 'pendente' && $linha['tentativas'] === 0 && $linha['max_tentativas'] === 3, 'Contrato da fila do site');
    verificar($linha['anexos'] === '[]' && $linha['modulo'] === 'portalfarma', 'Metadados da fila');
}
$fila = new FilaTeste(); $fila->banco = new BancoFilaTeste(); $fila->banco->falharEm = 2;
verificar(!$fila->registrar(array('principal@example.com', 'copia@example.com'), 'Assunto', 'Conteúdo') && $fila->banco->rollback && !$fila->banco->commit && !$fila->ids, 'Falha na cópia desfaz todo o registro');
$fila = new FilaTeste(); $fila->banco = new BancoFilaTeste();
verificar(!$fila->registrar(array('invalido'), 'Assunto', 'Conteúdo') && !$fila->banco->linhas, 'E-mail inválido não entra na fila');
$fila->indisponivel = true;
verificar(!$fila->registrar(array('principal@example.com'), 'Assunto', 'Conteúdo') && $fila->falha === 'banco', 'Banco indisponível retorna falha');
echo "OK: fila crftech, destinatário/cópia, deduplicação, transação e falhas.\n";
