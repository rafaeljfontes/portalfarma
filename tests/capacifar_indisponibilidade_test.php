<?php
define('BASEPATH', __DIR__);
class CI_Controller { public $capacifar_model; public $load; public $output; public $db; public $session; }
function log_message($level, $message) {}
require __DIR__ . '/../application/controllers/restrito/Capacifar.php';
class InscritosModelStub {
    public $fail = TRUE;
    public function query($sql) { return []; }
    public function presencas_curso($id) { return []; }
    public function listaInscritosCurso($id) {
        if ($this->fail) throw new mysqli_sql_exception('Host blocked', 1130);
        return [];
    }
}
class InscritosLoaderStub {
    public $views = [];
    public function view($name, $data = []) { $this->views[$name] = $data; }
}
class InscritosOutputStub {
    public $status = 200;
    public function set_status_header($code) { $this->status = $code; }
}
class InscritosSessionStub {
    public function userdata($key) { return 'test-token'; }
    public function set_userdata($key, $value) {}
}
class InscritosDbStub {
    public function select($s) { return $this; }
    public function from($t) { return $this; }
    public function where($k, $v) { return $this; }
    public function get($t = NULL) { return $this; }
    public function row() { return (object) ['titulo' => 'Curso teste']; }
}
foreach (['lista_inscritos', 'exportar_excel'] as $action) {
    $c = (new ReflectionClass('Capacifar'))->newInstanceWithoutConstructor();
    $c->capacifar_model = new InscritosModelStub();
    $c->load = new InscritosLoaderStub();
    $c->output = new InscritosOutputStub();
    $c->db = new InscritosDbStub();
    ob_start(); $c->$action(95); $body = ob_get_clean();
    if ($c->output->status !== 503 || !isset($c->load->views['restrito/inscritos_indisponiveis']) || $body !== '') {
        throw new Exception('Falha no tratamento de '.$action);
    }
    if (isset($c->load->views['restrito/lista_inscritos_view'])) throw new Exception('Exibiu lista vazia na falha');
}
$c->capacifar_model->fail = FALSE;
$c->session = new InscritosSessionStub();
$c->load = new InscritosLoaderStub();
$c->output = new InscritosOutputStub();
$c->lista_inscritos(95);
if ($c->output->status !== 200 || !isset($c->load->views['restrito/lista_inscritos_view'])) throw new Exception('Lista normal alterada');
echo "OK: falha na lista e exportacao, lista vazia valida preservada.\n";
