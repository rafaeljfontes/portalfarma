<?php
// Executar com PHP CLI; usa dados sintéticos e não acessa bancos reais.
define('BASEPATH', __DIR__);
class MY_Controller { public $input; public $output; public $db; public $load; public $Certificados_model; public $certificado_capacifar; }
require __DIR__ . '/../application/controllers/Pesquisa.php';
require __DIR__ . '/../application/helpers/certificados_helper.php';
class NpsInput {
    public $data;
    public function post() { return $this->data; }
    public function method() { return 'post'; }
}
class NpsOutput { public function set_content_type($type) { return $this; } }
class NpsDb {
    public $inserted = null;
    public $exists = false;
    public function where($key, $value) { return $this; }
    public function count_all_results($table) { return 1; }
    public function get($table) { return $this; }
    public function num_rows() { return $this->exists ? 1 : 0; }
    public function insert($table, $data) { $this->inserted = $data; return true; }
}
function check($condition, $message) { if (!$condition) throw new Exception($message); }
$controller = (new ReflectionClass('Pesquisa'))->newInstanceWithoutConstructor();
$controller->input = new NpsInput();
$controller->output = new NpsOutput();
$controller->db = new NpsDb();
$base = ['courseid'=>'74', 'email'=>'TEST@example.test', 'escala'=>'0', 'perguntaA'=>'Teste', 'perguntaB'=>'Teste', 'perguntaC'=>'Teste', 'perguntaD'=>'sim', 'perguntaE'=>''];
foreach (['0'=>'success', '10'=>'success', '11'=>'error', '-1'=>'error', ''=>'error', '1.5'=>'error'] as $score=>$expected) {
    $controller->input->data = array_merge($base, ['escala'=>(string) $score]);
    ob_start(); $controller->nps_cadastrar(); $response = json_decode(ob_get_clean(), true);
    check($response['status'] === $expected, 'Falha na validação da nota ' . $score);
}
$controller->input->data = $base;
$controller->db->exists = true;
ob_start(); $controller->nps_cadastrar(); $response = json_decode(ob_get_clean(), true);
check($response['status'] === 'warning', 'Resposta duplicada não deve ser inserida');
foreach (['52998224725'=>true, '529.982.247-25'=>true, '11111111111'=>false, '52998224726'=>false, '123'=>false, 'abc52998224725'=>false] as $cpf=>$expected) {
    check(certificados_cpf_valido((string) $cpf) === $expected, 'Validação de CPF');
}
echo "PASS: NPS aceita 0 e 10, rejeita notas inválidas, detecta duplicidade e valida CPF.\n";

define('FCPATH', dirname(__DIR__) . '/');
require __DIR__ . '/../application/controllers/Certificados.php';
class CertificateInput { public function method() { return 'post'; } public function post($key) { return '529.982.247-25'; } }
class CertificateDb {
    public function where($key, $value) { return $this; }
    public function get($table) { return $this; }
    public function row() { return (object) ['courseid'=>74, 'tipo_evento'=>1, 'titulo'=>'Curso de teste', 'carga_horaria'=>120]; }
}
class CertificateOutput {
    public $body; public $status = 200;
    public function set_content_type($type) { return $this; }
    public function set_header($value) { return $this; }
    public function set_status_header($status) { $this->status = $status; return $this; }
    public function set_output($body) { $this->body = $body; return $this; }
}
class CertificateLoad { public function helper($name) {} public function model($name) {} public function library($name) {} }
class CertificateParticipants {
    public $eligible = false;
    public function palestrantes_curso($id) { return []; }
    public function participante_concluinte($course, $cpf) { return $this->eligible ? (object) ['nome'=>'Participante de Teste'] : null; }
}
$certificate = (new ReflectionClass('Certificados'))->newInstanceWithoutConstructor();
require __DIR__ . '/../application/libraries/Certificado_capacifar.php';
$certificate->certificado_capacifar = new Certificado_capacifar();
$certificate->input = new CertificateInput();
$certificate->db = new CertificateDb();
$certificate->output = new CertificateOutput();
$certificate->load = new CertificateLoad();
$certificate->Certificados_model = new CertificateParticipants();
$certificate->baixar('74');
check($certificate->output->status === 422, 'Não emitir sem conclusão');
$certificate->Certificados_model->eligible = true;
$certificate->output = new CertificateOutput();
$certificate->baixar('74');
check(strpos($certificate->output->body, '%PDF-') === 0, 'Emitir PDF para participante elegível');
echo "PASS: bloqueia participante inelegível e gera PDF com participante simulado.\n";
