<?php
define('BASEPATH', __DIR__);
class CI_Controller { public $input; public $session; public $output; public $capacifar_model; }
function log_message($level, $message) {}
require __DIR__.'/../application/controllers/restrito/Capacifar.php';
class PresenceInput {
    public $raw_input_stream;
    public $method = 'post';
    function method() { return $this->method; }
}
class PresenceSession {
    function userdata($key) { return ['presencas_csrf'=>'token', 'presencas_alunos_95'=>[7,8]][$key] ?? NULL; }
}
class PresenceOutput {
    public $status = 200;
    public $body;
    function set_content_type($type) { return $this; }
    function set_status_header($status) { $this->status=$status; return $this; }
    function set_output($body) { $this->body=json_decode($body, TRUE); return $this; }
}
class PresenceModel {
    public $saved;
    public $fail = FALSE;
    function salvar_presencas_curso($id, $changes) {
        if ($this->fail) throw new RuntimeException('test');
        $this->saved=[$id,$changes];
    }
}
$cases = [
    ['post',95,['csrf'=>'token','alteracoes'=>[7=>TRUE,8=>FALSE]],200,FALSE],
    ['get',95,[],405,FALSE],
    ['post',95,['csrf'=>'wrong','alteracoes'=>[7=>TRUE]],403,FALSE],
    ['post',96,['csrf'=>'token','alteracoes'=>[7=>TRUE]],400,FALSE],
    ['post',95,['csrf'=>'token','alteracoes'=>[99=>TRUE]],400,FALSE],
    ['post',95,['csrf'=>'token','alteracoes'=>[7=>'true']],400,FALSE],
    ['post',95,['csrf'=>'token','alteracoes'=>[7=>TRUE]],503,TRUE],
];
foreach ($cases as [$method,$course,$payload,$expected,$fail]) {
    $c=(new ReflectionClass('Capacifar'))->newInstanceWithoutConstructor();
    $c->input=new PresenceInput(); $c->input->method=$method; $c->input->raw_input_stream=json_encode($payload);
    $c->session=new PresenceSession(); $c->output=new PresenceOutput(); $c->capacifar_model=new PresenceModel();
    $c->capacifar_model->fail=$fail;
    $c->salvar_presencas($course);
    if ($c->output->status !== $expected) throw new Exception('Status incorreto');
    if ($expected===200 && $c->capacifar_model->saved!==[95,[7=>TRUE,8=>FALSE]]) throw new Exception('Gravacao incorreta');
    if ($expected!==200 && $c->capacifar_model->saved!==NULL) throw new Exception('Gravacao indevida');
}
echo "OK: marcar/desmarcar, POST, CSRF, curso, aluno, tipos e falha de gravacao.\n";
