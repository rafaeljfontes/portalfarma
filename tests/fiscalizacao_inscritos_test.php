<?php
error_reporting(E_ALL & ~E_DEPRECATED);
define('BASEPATH', __DIR__);
class CI_Controller { public $input, $session, $output, $db, $load; }
function show_404() { throw new RuntimeException('404'); }
function base_url($path = '') { return 'https://example.test/'.$path; }
require __DIR__.'/../application/controllers/restrito/Fiscalizacao.php';
class FiscalInput {
    public $raw_input_stream, $verb = 'post';
    function method() { return $this->verb; }
}
class FiscalSession {
    public $values = ['fiscalizacao_presencas_csrf' => 'token'];
    function userdata($key) { return $this->values[$key] ?? NULL; }
    function set_userdata($key, $value) { $this->values[$key] = $value; }
}
class FiscalOutput {
    public $status = 200, $body;
    function set_content_type($type) { return $this; }
    function set_status_header($status) { $this->status = $status; return $this; }
    function set_output($body) { $this->body = json_decode($body, TRUE); return $this; }
}
class FiscalDB {
    public $filters = [], $writes = [], $failed = FALSE, $committed = FALSE, $rolledBack = FALSE;
    function get_where($table, $where) {
        $this->filters = $where;
        return $this;
    }
    function row() {
        return $this->filters === ['courseid'=>'FH0126', 'tipo_evento'=>4]
            ? (object) ['courseid'=>'FH0126','titulo'=>'Fiscalização <teste>', 'nome_curto'=>'teste'] : NULL;
    }
    function select($fields) { return $this; }
    function from($table) { $this->filters = []; return $this; }
    function where($key, $value) { $this->filters[$key] = $value; return $this; }
    function order_by($key, $direction) { return $this; }
    function get() { return $this; }
    function result() {
        if (($this->filters['id_evento'] ?? NULL) !== 'FH0126') throw new Exception('Curso incorreto na consulta');
        return [(object) ['id_inscricao'=>7, 'nome_completo'=>'Ana <script>', 'cpf'=>'123', 'email'=>'ana@example.test', 'telefone'=>NULL, 'data_inscricao'=>'2026-10-15 10:00:00', 'presenca'=>1]];
    }
    function trans_begin() {}
    function update($table, $data) { $this->writes[] = [$table, $this->filters, $data]; }
    function trans_status() { return !$this->failed; }
    function trans_commit() { $this->committed = TRUE; }
    function trans_rollback() { $this->rolledBack = TRUE; }
}
class FiscalLoader {
    public $data;
    function view($path, $data = []) { if ($path === 'restrito/fiscalizacao_inscritos') $this->data = $data; }
}
function controller() {
    $c = (new ReflectionClass('Fiscalizacao'))->newInstanceWithoutConstructor();
    $c->input = new FiscalInput(); $c->session = new FiscalSession();
    $c->output = new FiscalOutput(); $c->db = new FiscalDB(); $c->load = new FiscalLoader();
    return $c;
}
function check($condition, $message) { if (!$condition) throw new Exception($message); }
$c = controller(); $c->fiscalizacao_inscritos('FH0126');
check($c->load->data['courseid'] === 'FH0126' && $c->load->data['presencas'] === [7], 'Lista/presença incorreta');
extract($c->load->data);
ob_start(); include __DIR__.'/../application/views/restrito/fiscalizacao_inscritos.php'; $html = ob_get_clean();
check(strpos($html, 'lista_inscritos/FH0126?orientacao=landscape') !== FALSE, 'Impressão não está em paisagem');
check(strpos($html, 'ANA &lt;SCRIPT&gt;') !== FALSE && strpos($html, 'Ana <script>') === FALSE, 'Dados não escapados');
check(strpos($html, 'value="7" checked') !== FALSE, 'Presença não carregada');
$inscritos = []; ob_start(); include __DIR__.'/../application/views/restrito/fiscalizacao_inscritos.php'; $empty = ob_get_clean();
check(strpos($empty, 'Nenhum estudante encontrado') !== FALSE, 'Estado vazio ausente');
foreach (['119', '../FH0126', 'FH0126\' OR 1=1', NULL] as $id) {
    try { controller()->fiscalizacao_inscritos($id); throw new Exception('Curso indevido aceito'); }
    catch (RuntimeException $e) { check($e->getMessage() === '404', 'Erro inesperado'); }
}
$cases = [
    ['post', ['csrf'=>'token','alteracoes'=>[7=>TRUE]], 200, FALSE],
    ['post', ['csrf'=>'token','alteracoes'=>[7=>FALSE]], 200, FALSE],
    ['get', [], 405, FALSE],
    ['post', ['csrf'=>'wrong','alteracoes'=>[7=>TRUE]], 403, FALSE],
    ['post', ['csrf'=>'token','alteracoes'=>[99=>TRUE]], 400, FALSE],
    ['post', ['csrf'=>'token','alteracoes'=>[7=>'true']], 400, FALSE],
    ['post', ['csrf'=>'token','alteracoes'=>[7=>TRUE]], 503, TRUE]
];
foreach ($cases as [$verb, $payload, $status, $failed]) {
    $c = controller(); $c->input->verb = $verb; $c->input->raw_input_stream = json_encode($payload); $c->db->failed = $failed;
    $c->salvar_presencas('FH0126');
    check($c->output->status === $status, 'Status de presença incorreto');
    check($c->db->committed === ($status === 200), 'Transação incorreta');
    if ($status === 200) {
        $write = $c->db->writes[0];
        check($write[0] === 'fiscalizacao_humanizada_inscricao' && $write[1] === ['id_evento'=>'FH0126','id'=>7], 'Gravação fora do inscrito/curso');
        check($write[2]['presenca'] === ($payload['alteracoes'][7] ? 1 : 0), 'Presença incorreta');
    }
    if ($status === 400 || $status === 403 || $status === 405) check(!$c->db->writes, 'Gravação indevida');
    if ($failed) check($c->db->rolledBack, 'Rollback ausente');
}
echo "OK: listagem, curso FH, impressão paisagem, escape, vazio, POST, CSRF, marcar/desmarcar, isolamento e rollback.\n";
