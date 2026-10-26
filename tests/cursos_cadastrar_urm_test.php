<?php
define('BASEPATH', __DIR__);
class CI_Controller { public $dados = []; public $load; public $Moodle_api; public $capacifar_model; public $input; public $db; }
class CI_Model { public $db; }
function log_message($level, $message) {}
function registrar_historico($acao, $id, &$erro = null) { return true; }
function base_url($path = '') { return '/'.$path; }
require __DIR__.'/../application/controllers/restrito/Cursos.php';
require __DIR__.'/../application/models/Capacifar_model.php';
function checkUrm($ok, $message) { if (!$ok) throw new RuntimeException($message); }
class UrmDb {
    public $maior = 11; public $sql; public $params; public $db_debug = true;
    public function query($sql, $params) { $this->sql = $sql; $this->params = $params; return $this; }
    public function row() { return (object) ['maior_sequencial'=>$this->maior]; }
    public function error() { return ['message'=>'']; }
}
$model = new Capacifar_model();
$model->db = new UrmDb();
$sugerido = 'URM12'.date('y');
checkUrm($model->proximoCourseIdUrm() === $sugerido, 'Sequencial 11 deve sugerir URM12 seguido do ano atual');
checkUrm($model->db->params === [3], 'A sequência deve filtrar o tipo URM');
checkUrm(strpos($model->db->sql, 'MAX(CAST(SUBSTRING(courseid, 4, CHAR_LENGTH(courseid) - 5) AS UNSIGNED))') !== false, 'Extrair e comparar apenas o sequencial, sem prefixo e ano');
checkUrm(strpos($model->db->sql, "REGEXP '^URM[0-9]+[0-9]{2}$'") !== false, 'Somente códigos URM com sequencial e ano participam');
$model->db->maior = 0;
checkUrm($model->proximoCourseIdUrm() === 'URM1'.date('y'), 'Sem códigos URM, iniciar no sequencial 1');
$model->db->maior = 99;
checkUrm($model->proximoCourseIdUrm() === 'URM100'.date('y'), 'Sequencial pode ultrapassar dois dígitos');
$model->db->maior = 11;
class UrmLoader {
    public $views = [];
    public function helper($name) {}
    public function view($name, $data = []) { $this->views[$name] = $data; }
}
class UrmMoodle { public function lista_cursos() { return []; } }
foreach ([null, 'urm', 'outro'] as $contexto) {
    $controller = (new ReflectionClass('Cursos'))->newInstanceWithoutConstructor();
    $controller->load = new UrmLoader();
    $controller->Moodle_api = new UrmMoodle();
    $controller->capacifar_model = $model;
    $controller->cadastrar($contexto);
    $data = $controller->load->views['restrito/curso_cadastrar'];
    checkUrm($data['preenchimento_urm'] === ($contexto === 'urm'), 'Pré-preenchimento depende da rota URM');
    if ($contexto === 'urm') {
        checkUrm($data['tipo_evento_padrao'] === 3 && $data['courseid_padrao'] === $sugerido, 'Controller fornece defaults antes de carregar a view');
    } else {
        checkUrm(!isset($data['tipo_evento_padrao'], $data['courseid_padrao']), 'Cadastro comum mantém seus defaults');
    }
}
class UrmInput {
    public $courseid;
    public function post() {
        return ['tipo_evento'=>3, 'courseid'=>$this->courseid, 'titulo'=>'Teste URM', 'nome_curto'=>'teste',
            'data_inicio'=>'2026-10-20', 'publico_alvo'=>'1', 'topicos'=>'Teste'];
    }
}
class UrmSaveModel {
    public $dados;
    public function inserircurso($dados) { $this->dados = $dados; return 42; }
}
foreach ([$sugerido, 'URM20'.date('y'), 'URM0126'] as $courseid) {
    $controller = (new ReflectionClass('Cursos'))->newInstanceWithoutConstructor();
    $controller->input = new UrmInput(); $controller->input->courseid = $courseid;
    $controller->db = new UrmDb(); $controller->load = new UrmLoader();
    $controller->capacifar_model = new UrmSaveModel();
    ob_start(); $controller->salvar(); $retorno = json_decode(ob_get_clean(), true, 512, JSON_THROW_ON_ERROR);
    checkUrm($retorno['status'] === 'success', 'Cadastro URM salvo');
    checkUrm($controller->capacifar_model->dados['courseid'] === $courseid, 'Respeitar sugestão, alteração manual e códigos URM existentes');
}
function renderUrmForm($data) {
    extract($data);
    ob_start();
    require __DIR__.'/../application/views/restrito/curso_cadastrar.php';
    return ob_get_clean();
}
$defaults = ['preenchimento_urm'=>true, 'tipo_evento_padrao'=>3, 'courseid_padrao'=>$sugerido, 'cursos'=>[]];
$html = renderUrmForm($defaults);
checkUrm(strpos($html, '<option value="3" selected>URM</option>') !== false, 'URM selecionado no HTML');
checkUrm(preg_match('/id="courseid_input"[^>]*value="'.preg_quote($sugerido, '/').'"/', $html) === 1, 'CourseID formatado sugerido no HTML');
$registro = (object) array_fill_keys(['id', 'tipo_evento', 'courseid', 'titulo', 'nome_curto', 'topicos', 'descricao',
    'local', 'data_inicio', 'data_fim', 'dificuldade', 'carga_horaria', 'publico_alvo', 'link'], '');
$registro->id = 9; $registro->tipo_evento = 1; $registro->courseid = 88;
$html = renderUrmForm($defaults + ['tabela'=>[$registro]]);
checkUrm(strpos($html, '<option value="1" selected>Presencial</option>') !== false, 'Edição preserva tipo cadastrado');
checkUrm(preg_match('/id="courseid_input"[^>]*value="88"/', $html) === 1, 'Edição preserva CourseID cadastrado');
echo "OK: formato URM + sequencial + ano atual, defaults por rota, formulário, salvamento e edição.\n";
