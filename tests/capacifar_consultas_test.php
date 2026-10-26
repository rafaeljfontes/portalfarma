<?php
define('BASEPATH', __DIR__);
class CI_Model { public $db; }
require __DIR__ . '/../application/models/Capacifar_model.php';
require __DIR__ . '/../application/models/Moodle_api.php';
class ConsultaTeste {
    public $db_debug = true;
    public $calls = [];
    public $fail = false;
    public function query($sql, $params = []) {
        $this->calls[] = [$sql, $params];
        if ($this->fail) return false;
        return new ResultadoTeste();
    }
}
class ResultadoTeste { public function result() { return []; } }
function verificarConsulta($ok, $mensagem) { if (!$ok) throw new Exception($mensagem); }
$moodle = (new ReflectionClass('Moodle_api'))->newInstanceWithoutConstructor();
$property = new ReflectionProperty('Moodle_api', 'moodle');
$property->setAccessible(true);
$db = new ConsultaTeste(); $property->setValue($moodle, $db);
verificarConsulta($moodle->totais_inscritos_cursos([]) === [] && count($db->calls) === 0, 'Lista vazia não deve consultar Moodle');
$moodle->totais_inscritos_cursos([74, 34, 74, 0, -1]);
list($sql, $params) = $db->calls[0];
verificarConsulta($params === [74, 34], 'IDs devem ser únicos, positivos e parametrizados');
verificarConsulta(strpos($sql, 'COUNT(DISTINCT ue.userid)') !== false && strpos($sql, 'ue.status = 0') !== false && strpos($sql, 'ra.roleid = 5') !== false, 'Preservar regras da contagem');
verificarConsulta(strpos($sql, 'ra_prof') === false && strpos($sql, 'IN (?,?)') !== false, 'Contagem restrita sem professores');
verificarConsulta($db->db_debug === true, 'Restaurar db_debug');
$db->fail = true;
try { $moodle->totais_inscritos_cursos([74]); throw new Exception('Falha não detectada'); }
catch (RuntimeException $e) { verificarConsulta($db->db_debug === true, 'Restaurar db_debug após erro'); }
$portal = new Capacifar_model(); $portal->db = new ConsultaTeste();
$portal->listaCursosAdministracao('tpf.status = 1 AND tpf.tipo_evento = 2');
$sql = $portal->db->calls[0][0];
verificarConsulta(strpos($sql, 'tpf.status = 1 AND tpf.tipo_evento = 2') !== false, 'Preservar filtro');
verificarConsulta(strpos($sql, 'tbl_categoria_eventos') === false && strpos($sql, 'AS palestrantes') !== false, 'Evitar categorias sem perder palestrantes');
echo "PASS: consultas filtradas, deduplicação, ausência de consultas vazias, regras de contagem e tratamento de falhas.\n";
