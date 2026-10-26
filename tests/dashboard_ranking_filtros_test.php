<?php
define('BASEPATH', __DIR__);
class MY_Controller { public $load; public $input; public $capacifar_model; public $Moodle_api; public $designacoes_model; }
class CI_Model { public $load; public $designacoes_model; }
require __DIR__.'/../application/models/Capacifar_model.php';
require __DIR__.'/../application/controllers/restrito/Inicio.php';
function base_url($path = '') { return '/'.$path; }
function checkRanking($ok, $message) { if (!$ok) throw new RuntimeException($message); }
class RankingInput { public $value; public function get($key) { return $this->value; } }
class RankingLoader {
    public $dados;
    public function model(...$args) {}
    public function view($nome, $dados = []) { if ($nome === 'restrito/inicio') $this->dados = $dados; }
}
class RankingMoodle {
    public $rows = [];
    public function total_alunos() { return $this->rows; }
    public function media_inscricoes_mensal_por_cursos(...$args) { return 0; }
    public function __call($name, $args) { return []; }
}
class RankingDesignacoes {
    public function disponivel() { return true; }
    public function usuario_sessao() { return 42; }
    public function condicao_usuario($alias, $id) { return 'EXISTS (SELECT 1 FROM tbl_portalfarma_func_designado fd_usuario WHERE fd_usuario.courseid = '.$alias.'.courseid AND fd_usuario.id_usuario = '.(int) $id.')'; }
}
class RankingPortal extends Capacifar_model {
    public $rows = []; public $sql;
    public function query($sql) {
        if (strpos($sql, 'END AS total_inscritos_local') === false) return [];
        $this->sql = $sql;
        checkRanking(strpos($sql, 'fd_usuario.id_usuario = 42') !== false, 'Escopo do usuário da sessão aplicado no Model');
        preg_match('/c.tipo_evento = (\d+)/', $sql, $matches);
        return array_values(array_filter($this->rows, function ($row) use ($matches) {
            return !$matches || (int) $row->tipo_evento === (int) $matches[1];
        }));
    }
}
function renderRanking($dados) {
    extract($dados);
    ob_start(); require __DIR__.'/../application/views/restrito/inicio.php'; return ob_get_clean();
}
$portal = new RankingPortal(); $moodle = new RankingMoodle();
$portal->load = new RankingLoader(); $portal->designacoes_model = new RankingDesignacoes();
foreach ([1,2,3,4,5,7] as $tipo) {
    for ($i = 1; $i <= 12; $i++) {
        $id = $tipo === 3 ? 'URM'.$i.'26' : $tipo * 100 + $i;
        $local = in_array($tipo, [3,4,7], true);
        $portal->rows[] = (object) ['courseid'=>$id, 'tipo_evento'=>$tipo, 'titulo'=>'Curso T'.$tipo.' N'.$i,
            'total_inscritos_local'=>$local ? $i * 10 + $tipo : null, 'palestrantes'=>'Palestrante teste'];
        if ($tipo !== 3) $moodle->rows[] = (object) ['courseid'=>$id, 'total_estudantes'=>$local ? 9999 : $i * 10 + $tipo];
    }
}
foreach ([null, '1', '2', '3', '4', '5', '7', '6', '3 OR 1=1', ['3']] as $filtro) {
    $controller = (new ReflectionClass('Inicio'))->newInstanceWithoutConstructor();
    $controller->input = new RankingInput(); $controller->input->value = $filtro;
    $controller->load = new RankingLoader(); $controller->capacifar_model = $portal; $controller->Moodle_api = $moodle;
    $controller->designacoes_model = new RankingDesignacoes();
    $controller->index();
    $dados = $controller->load->dados;
    $tipo = is_string($filtro) && in_array($filtro, ['1','2','3','4','5','7'], true) ? (int) $filtro : null;
    checkRanking($dados['tipo_evento_ranking'] === $tipo, 'Validar filtro GET e rejeitar valores inválidos');
    checkRanking(count($dados['cursos_mais_requisitados']) === ($tipo ? 12 : 72), 'Filtrar antes do limite de dez');
    foreach ($dados['cursos_mais_requisitados'] as $curso) {
        checkRanking($curso->total_estudantes < 9999, 'Eventos locais devem ignorar contagens conflitantes do Moodle');
        if ($tipo) checkRanking((int) $curso->tipo_evento === $tipo, 'Ranking contém apenas o tipo selecionado');
    }
    $html = renderRanking($dados);
    $card = substr($html, strpos($html, 'id="ranking-cursos"'));
    preg_match('/<tbody>(.*?)<\/tbody>/s', $card, $tbody);
    checkRanking(substr_count($tbody[1], '<tr>') === 10, 'Exibir no máximo dez cursos');
    preg_match_all('/class="dashboard-count">(\d+)/', $tbody[1], $counts);
    $values = array_map('intval', $counts[1]); $ordenados = $values; rsort($ordenados);
    checkRanking($values === $ordenados && $values[0] === 120 + ($tipo ?: 7), 'Ordenar por inscritos decrescente');
    checkRanking(substr_count($card, 'aria-current="true"') === 1, 'Destacar exatamente um filtro');
    checkRanking(strpos($card, 'Capacifar Online') !== false && strpos($card, 'Seminário de Vigilância') !== false, 'Exibir filtros solicitados');
    if ($tipo) checkRanking(strpos($card, 'escopo=designados&amp;tipo_evento='.$tipo) !== false, 'Ver todos mantém escopo e filtro selecionado');
}
foreach (['FROM urm_inscricao', 'i.urm_evento = c.courseid', 'FROM fiscalizacao_humanizada_inscricao',
    'i.id_evento = c.courseid', 'FROM tbl_seminario_inscricao', 'i.seminario = c.courseid'] as $trecho) {
    checkRanking(strpos($portal->sql, $trecho) !== false, 'Consulta a origem correta: '.$trecho);
}
echo "OK: filtros GET, origem das contagens, ranking decrescente, top 10 e botão ativo.\n";
