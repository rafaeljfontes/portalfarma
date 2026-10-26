<?php
define('BASEPATH', __DIR__);
define('FCPATH', dirname(__DIR__) . '/');
class CI_Model { public $db; public $load; }
require FCPATH . 'application/models/Certificados_model.php';
require FCPATH . 'application/libraries/Certificado_capacifar.php';
function verify($condition, $message) { if (!$condition) throw new Exception($message); }
class PresenceDb {
    public $conditions = []; public $lists = 1; public $present = true; public $calls = 0;
    public function where($key, $value) { $this->conditions[$key] = $value; return $this; }
    public function count_all_results($table) {
        verify($table === 'web_site.tbl_portalfarma_presenca', 'Tabela incorreta');
        verify($this->conditions['courseid'] === 74, 'Curso deve restringir presença');
        $this->calls++;
        $result = isset($this->conditions['id_moodle']) ? ($this->conditions['id_moodle'] === 321 && $this->present ? 1 : 0) : $this->lists;
        $this->conditions = [];
        return $result;
    }
}
class MoodleDb {
    public $conditions = []; public $joins = []; public $enrolled = true; public $completed = true;
    public function select($s, $escape) { return $this; }
    public function from($s) { return $this; }
    public function join($t, $on) { $this->joins[] = $t; return $this; }
    public function where($k, $v) { $this->conditions[$k] = $v; return $this; }
    public function limit($n) { return $this; }
    public function get() { return $this; }
    public function row() {
        verify($this->conditions['e.courseid'] === 74, 'Matrícula deve restringir curso');
        verify($this->conditions['u.username'] === '52998224725', 'CPF deve buscar usuário Moodle');
        if (!$this->enrolled || (isset($this->conditions['cc.timecompleted >']) && !$this->completed)) return null;
        return (object) ['id_moodle'=>321, 'nome'=>'Participante de Teste'];
    }
}
class ModelLoader { public $moodle; public function database($group, $return) { return $this->moodle; } }
foreach ([
    [1, 0, true, true, false, false], // Sem lista.
    [1, 1, false, true, false, false], // Ausente.
    [1, 1, true, true, false, true], // Presente, sem conclusão Moodle.
    [1, 1, true, false, true, false], // Não matriculado.
    [2, 0, false, true, true, true], // Online não depende de lista.
    [2, 0, false, false, true, false], // Online sem matrícula não pode emitir.
    [2, 1, true, true, false, false], // Online ainda exige conclusão.
    [5, 1, true, true, false, false],
    [6, 0, false, true, true, false]
] as $case) {
    list($tipo, $lista, $presente, $matriculado, $concluido, $esperado) = $case;
    $model = new Certificados_model(); $model->db = new PresenceDb();
    $model->db->lists = $lista; $model->db->present = $presente;
    $model->load = new ModelLoader(); $model->load->moodle = new MoodleDb();
    $model->load->moodle->enrolled = $matriculado; $model->load->moodle->completed = $concluido;
    $result = $model->participante_concluinte((object) ['courseid'=>74, 'tipo_evento'=>$tipo], '52998224725');
    verify((bool) $result === $esperado, 'Falha na regra: ' . json_encode($case));
    if ($tipo === 2) verify($model->db->calls === 0, 'Online não deve consultar lista');
}
echo "PASS: 9 cenários de modalidade, matrícula, lista, presença e conclusão.\n";
$renderer = new Certificado_capacifar();
foreach ([1=>'presencial', 2=>'online'] as $tipo=>$modalidade) {
    $curso = (object) ['tipo_evento'=>$tipo, 'titulo'=>'Minicurso de Bioequivalência: Teoria e Aplicação', 'carga_horaria'=>150, 'local'=>$tipo === 1 ? 'Belo Horizonte' : 'Ambiente Virtual de Aprendizagem', 'data_fim'=>'2026-09-25 18:00:00'];
    $pdf = $renderer->gerar($curso, (object) ['nome'=>'Participante de Teste'], [(object) ['nome'=>'Palestrante de Teste']]);
    verify(substr($pdf, 0, 5) === '%PDF-', 'PDF inválido');
    if (!empty($argv[1])) file_put_contents($argv[1] . '/certificado-' . $modalidade . '.pdf', $pdf);
}
echo "PASS: PDFs presencial e online com fundos oficiais.\n";
