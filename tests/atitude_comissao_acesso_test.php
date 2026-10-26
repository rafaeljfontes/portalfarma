<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__ . '/../system/');
class CI_Controller {}
require __DIR__ . '/../application/controllers/atitude-farmaceutica/AtitudeFarmaceutica.php';
#[AllowDynamicProperties]
class ControladorComissaoAcesso extends AtitudeFarmaceutica {}
function verificar_acesso($ok, $msg) { if (!$ok) throw new RuntimeException($msg); }
function controlador_acesso($email, $membro) {
    $c = new ControladorComissaoAcesso();
    $c->input = new class($email) {
        private $email;
        public function __construct($email) { $this->email = $email; }
        public function method() { return 'post'; }
        public function post($key) { return array('token' => '', 'email' => $this->email, 'notas' => array(1 => array()))[$key] ?? null; }
    };
    $c->session = new class {
        public $dados = array('atitude_comissao_token' => 'segredo');
        public function userdata($key) { return $this->dados[$key] ?? null; }
        public function set_userdata($key, $value) { $this->dados[$key] = $value; }
        public function unset_userdata($key) { unset($this->dados[$key]); }
    };
    $c->load = new class { public function database() {} public function model($name, $alias) {} };
    $c->comissao = new class($membro) {
        public $email, $salvos = 0; private $membro;
        public function __construct($membro) { $this->membro = $membro; }
        public function membro($email) { $this->email = $email; return $this->membro; }
        public function registrar($email, $notas) { $this->salvos++; return null; }
    };
    $c->security = new class { public function get_csrf_token_name() { return 'csrf'; } public function get_csrf_hash() { return 'novo'; } };
    $c->output = new class {
        public $code, $data;
        public function set_status_header($code) { $this->code = $code; return $this; }
        public function set_content_type($type, $charset) { return $this; }
        public function set_output($json) { $this->data = json_decode($json, true); return $this; }
    };
    return $c;
}
foreach (array(array('invalido', false, 422), array('nao@example.com', false, 403), array('erro@example.com', null, 503), array(' MEMBRO@EXAMPLE.COM ', (object) array('id' => 1, 'nome' => 'Membro'), 200)) as $caso) {
    list($email, $membro, $status) = $caso;
    $c = controlador_acesso($email, $membro); $c->identificar_comissao();
    verificar_acesso($c->output->code === $status, 'Identificação incorreta.');
    verificar_acesso(($c->session->userdata('atitude_comissao_email') !== null) === ($status === 200), 'Liberou cadastro inválido.');
    if ($status === 200) verificar_acesso($c->comissao->email === 'membro@example.com', 'Não normalizou e-mail.');
}
$c = controlador_acesso('membro@example.com', (object) array('id' => 1));
$c->salvar_comissao();
verificar_acesso($c->output->code === 403 && $c->comissao->salvos === 0, 'Aceitou envio direto sem identificação.');
$c->session->set_userdata('atitude_comissao_email', 'outra@example.com'); $c->salvar_comissao();
verificar_acesso($c->output->code === 403 && $c->comissao->salvos === 0, 'Aceitou troca de identidade.');
$c->session->set_userdata('atitude_comissao_email', 'membro@example.com'); $c->salvar_comissao();
verificar_acesso($c->output->code === 200 && $c->comissao->salvos === 1, 'Bloqueou membro identificado.');
echo "OK: cadastro obrigatório, e-mail normalizado, sessão identificada, troca de identidade e falha de consulta.\n";
