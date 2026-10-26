<?php
// PHP CLI, dados sinteticos; nao acessa o Moodle.
define('BASEPATH', __DIR__);
class CI_Model {}
require __DIR__ . '/../application/models/Moodle_api.php';
function check($condition, $message) { if (!$condition) throw new Exception($message); }
class GroupsDb {
    public $db_debug = TRUE;
    public $rows = [];
    public $fail = FALSE;
    public $exception = FALSE;
    public $bindings;
    public function query($sql, $bindings) {
        $this->bindings = $bindings;
        if ($this->exception) throw new RuntimeException('Falha simulada');
        return $this->fail ? FALSE : $this;
    }
    public function result() { return $this->rows; }
}
$model = (new ReflectionClass('Moodle_api'))->newInstanceWithoutConstructor();
$property = new ReflectionProperty('Moodle_api', 'moodle');
$property->setAccessible(TRUE);
$db = new GroupsDb();
$property->setValue($model, $db);
check($model->grupos_do_curso(42) === [], 'Curso sem grupos');
$db->rows = [
    (object) ['grupo_id'=>1, 'grupo_nome'=>'Turma A', 'usuario_id'=>7, 'usuario_nome'=>'Ana'],
    (object) ['grupo_id'=>1, 'grupo_nome'=>'Turma A', 'usuario_id'=>8, 'usuario_nome'=>'Bruno'],
    (object) ['grupo_id'=>2, 'grupo_nome'=>'Turma B', 'usuario_id'=>7, 'usuario_nome'=>'Ana'],
    (object) ['grupo_id'=>3, 'grupo_nome'=>'Vazio', 'usuario_id'=>NULL, 'usuario_nome'=>NULL],
];
$groups = $model->grupos_do_curso(42);
check(count($groups) === 3 && count($groups[0]['membros']) === 2, 'Agrupamento dos membros');
check($groups[1]['membros'][0]['id'] === 7, 'Usuario em mais de um grupo');
check($groups[2]['membros'] === [], 'Grupo vazio preservado');
check($db->bindings === [42] && $db->db_debug === TRUE, 'Parametro e restauracao do debug');
foreach (['fail', 'exception'] as $mode) {
    $db->$mode = TRUE;
    try { $model->grupos_do_curso(42); throw new LogicException('Falha nao detectada'); }
    catch (RuntimeException $e) { check($db->db_debug === TRUE, 'Debug restaurado apos falha'); }
    $db->$mode = FALSE;
}
foreach ([0, -1, '42 OR 1=1', NULL] as $id) {
    try { $model->grupos_do_curso($id); throw new LogicException('ID invalido aceito'); }
    catch (InvalidArgumentException $e) {}
}
function base_url($path) { return '/'.$path; }
$curso = (object) ['titulo'=>'Curso <teste>', 'courseid'=>42];
$grupos = [['id'=>1, 'nome'=>'<script>grupo</script>', 'membros'=>[['id'=>7, 'nome'=>'<b>Ana</b>']]]];
$indisponivel = FALSE;
ob_start(); require __DIR__ . '/../application/views/restrito/curso_grupos.php'; $html = ob_get_clean();
check(strpos($html, '&lt;b&gt;Ana&lt;/b&gt;') !== FALSE && strpos($html, '<script>grupo') === FALSE, 'Escape de nomes');
$indisponivel = TRUE;
$grupos = [];
ob_start(); require __DIR__ . '/../application/views/restrito/curso_grupos.php'; $html = ob_get_clean();
check(strpos($html, 'Não foi possível') !== FALSE && strpos($html, 'Nenhum grupo criado') === FALSE, 'Falha nao representa curso sem grupos');
echo "OK: grupos, membros, grupo vazio, validacao, falhas e escape HTML.\n";
