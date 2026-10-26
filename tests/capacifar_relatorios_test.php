<?php
define('BASEPATH', __DIR__);
class CI_Model {}
function log_message($level, $message) {}
function base_url($path) { return '/'.$path; }
require __DIR__.'/../application/models/Moodle_api.php';
class ReportDb {
    public $db_debug = TRUE;
    public $failLogs = FALSE;
    public $failCertificates = FALSE;
    public $failCourseCertificates = FALSE;
    public $sql;
    public $bindings;
    public function table_exists($name) { return TRUE; }
    public function query($sql, $bindings) {
        $this->sql = $sql;
        $this->bindings = $bindings;
        if (strpos($sql, 'mdl_tool_certificate_issues') !== FALSE && $this->failCourseCertificates) return FALSE;
        if (strpos($sql, 'logstore') !== FALSE && $this->failLogs) return FALSE;
        if (strpos($sql, 'certificate_issues') !== FALSE && $this->failCertificates) return FALSE;
        return $this;
    }
    public function row() {
        if (strpos($this->sql, 'logstore') !== FALSE) return (object) ['ativos'=>3, 'acessos'=>8, 'atividades'=>12];
        return (object) ['total'=>strpos($this->sql, '_issues') !== FALSE ? 2 : 4];
    }
}
function check($ok, $message) { if (!$ok) throw new Exception($message); }
$model = (new ReflectionClass('Moodle_api'))->newInstanceWithoutConstructor();
$property = new ReflectionProperty('Moodle_api', 'moodle');
$property->setAccessible(TRUE);
$db = new ReportDb();
$property->setValue($model, $db);
$indicadores = $model->relatorio_curso(117);
check($indicadores === ['inscritos'=>4,'ativos'=>3,'acessos'=>8,'atividades'=>12,'certificados'=>6], 'Indicadores e soma das três fontes de emissões');
check($db->bindings === [117, 'mod_coursecertificate'] && $db->db_debug === TRUE, 'Curso, componente e restauração do debug');
$db->failCourseCertificates = TRUE;
check($model->relatorio_curso(101)['certificados'] === NULL, 'Falha do módulo não exibe total incompleto');
$db->failCourseCertificates = FALSE;
$db->failLogs = TRUE; $db->failCertificates = TRUE;
$partial = $model->relatorio_curso(117);
check($partial['inscritos'] === 4 && $partial['ativos'] === NULL && $partial['certificados'] === NULL, 'Falhas parciais não são zero');
foreach ([NULL, 0, -1, '117 OR 1=1'] as $id) {
    try { $model->relatorio_curso($id); throw new LogicException('ID aceito'); }
    catch (InvalidArgumentException $e) {}
}
$curso = (object) ['titulo'=>'<script>teste</script>', 'courseid'=>117, 'tipo_evento'=>1];
$presencas = [7,8]; $grupos_indisponiveis = FALSE;
$grupo_selecionado = ['id'=>1, 'nome'=>'<b>Presença</b>', 'membros'=>[['id'=>8],['id'=>9]]];
$grupos = [$grupo_selecionado];
ob_start(); require __DIR__.'/../application/views/restrito/curso_relatorios.php'; $html = ob_get_clean();
check(strpos($html, '75,0%') !== FALSE, 'Taxa de engajamento');
check(strpos($html, 'sem duplicar pessoas): <strong>3</strong>') !== FALSE, 'União de presenças');
check(strpos($html, '<script>teste') === FALSE && strpos($html, '&lt;b&gt;Presença') !== FALSE, 'Escape HTML');
$curso->tipo_evento = 2;
$indicadores = array_fill_keys(array_keys($indicadores), 0);
ob_start(); require __DIR__.'/../application/views/restrito/curso_relatorios.php'; $html = ob_get_clean();
check(strpos($html, '0,0%') !== FALSE && strpos($html, 'Presença no evento presencial') === FALSE, 'Curso vazio e modalidade online');
echo "OK: indicadores, falhas parciais, IDs, taxa, presenças e escape.\n";
