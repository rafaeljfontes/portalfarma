<?php
define('BASEPATH', __DIR__);
class CI_Model { public $db; public $load; public $Moodle_api; }
class CI_Controller { public $capacifar_model; public $input; public $load; }
require __DIR__.'/../application/models/Capacifar_model.php';
require __DIR__.'/../application/controllers/restrito/Capacifar.php';
function checkInscricoes($ok, $message) { if (!$ok) throw new Exception($message); }
function base_url($path) { return '/'.$path; }
function html_escape($value) { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
class InscricoesDb {
    public $sql; public $params; public $rows = [];
    public function query($sql, $params) { $this->sql = $sql; $this->params = $params; return $this; }
    public function result() { return $this->rows; }
}
class InscricoesLoader {
    public $models = []; public $views = [];
    public function model($name) { $this->models[] = $name; }
    public function view($name, $data = []) { $this->views[$name] = $data; }
}
class InscricoesMoodle {
    public $ids;
    public function totais_inscritos_cursos($ids) {
        $this->ids = $ids;
        return [(object) ['courseid'=>101, 'total_estudantes'=>12]];
    }
}
$model = new Capacifar_model();
$model->db = new InscricoesDb(); $model->load = new InscricoesLoader(); $model->Moodle_api = new InscricoesMoodle();
foreach ([1,2,3,4,5,7,9] as $tipo) {
    $model->db->rows[] = (object) ['id'=>$tipo, 'courseid'=>100+$tipo, 'tipo_evento'=>$tipo,
        'titulo'=>'Curso '.$tipo, 'palestrantes'=>'Ana, Bia', 'status'=>1,
        'total_estudantes'=>in_array($tipo, [3,4,7]) ? $tipo : 0];
}
$rows = $model->relatorio_inscricoes_cursos();
$byTipo = [];
foreach ($rows as $row) $byTipo[$row->tipo_evento] = $row->total_estudantes;
checkInscricoes($byTipo === [1=>12,7=>7,4=>4,3=>3,2=>0,5=>0,9=>0], 'Origem, zeros e ordenação dos totais');
checkInscricoes($model->Moodle_api->ids === [101,102,105,109], 'Moodle recebe apenas os demais tipos');
foreach (['WHEN 3', 'i.urm_evento = tpf.courseid', 'WHEN 4', 'i.id_evento = tpf.courseid', 'WHEN 7',
    'i.seminario = tpf.courseid', 'GROUP_CONCAT(DISTINCT p.nome', 'pc.courseid = tpf.courseid'] as $sql) {
    checkInscricoes(strpos($model->db->sql, $sql) !== false, 'Relacionamento SQL: '.$sql);
}
checkInscricoes(strpos($model->db->sql, 'WHERE tpf.status') === false, 'Todos os status incluídos');
$model->db->rows = [(object) ['tipo_evento'=>3, 'courseid'=>103, 'titulo'=>'URM', 'total_estudantes'=>0]];
$model->load->models = [];
$model->relatorio_inscricoes_cursos(3);
checkInscricoes($model->db->params === [3] && strpos($model->db->sql, 'WHERE tpf.tipo_evento = ?') !== false, 'Filtro parametrizado');
checkInscricoes($model->load->models === [], 'Relatório local não depende do Moodle');
class InscricoesInput { public $value; public function get($key) { return $this->value; } }
class InscricoesReport { public $tipo; public function relatorio_inscricoes_cursos($tipo) { $this->tipo = $tipo; return []; } }
$controller = (new ReflectionClass('Capacifar'))->newInstanceWithoutConstructor();
$controller->input = new InscricoesInput(); $controller->load = new InscricoesLoader();
$controller->capacifar_model = new InscricoesReport();
foreach (['3'=>3, '7'=>7, '1 OR 1=1'=>null, ''=>null, '6'=>null] as $input=>$expected) {
    $controller->input->value = (string) $input;
    $controller->inscricoescursos();
    checkInscricoes($controller->capacifar_model->tipo === $expected, 'Validação do filtro');
}
$controller->input->value = ['3']; $controller->inscricoescursos();
checkInscricoes($controller->capacifar_model->tipo === null, 'Rejeitar filtro em array');
$data = $controller->load->views['restrito/inscricoescursos'];
extract($data);
$tipoEventoSelecionado = 3;
$total_alunos_cursos = [(object) ['courseid'=>103,'tipo_evento'=>3,'titulo'=>'<script>x</script>',
    'palestrantes'=>'<b>Ana</b>', 'total_estudantes'=>0, 'status'=>1]];
ob_start(); require __DIR__.'/../application/views/restrito/inscricoescursos.php'; $html = ob_get_clean();
checkInscricoes(strpos($html, '<script>x') === false && strpos($html, '&lt;b&gt;Ana') !== false, 'Escape dos dados');
checkInscricoes(strpos($html, 'value="3" selected') !== false && strpos($html, 'Seminário de Vigilância') !== false, 'Filtro preservado e opções');
$total_alunos_cursos = [];
ob_start(); require __DIR__.'/../application/views/restrito/inscricoescursos.php'; $html = ob_get_clean();
checkInscricoes(strpos($html, 'Nenhum curso/evento encontrado.') !== false, 'Estado vazio');
echo "OK: origens, chaves, zeros, filtro, independência do Moodle, escape e estado vazio.\n";
