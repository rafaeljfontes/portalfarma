<?php
define('BASEPATH', __DIR__);
require __DIR__ . '/../application/libraries/Sessao_inatividade.php';
class SessionFake {
    public $data = array(); public $regenerated = false;
    function userdata($key) { return $this->data[$key] ?? null; }
    function set_userdata($key, $value) { $this->data[$key] = $value; }
    function unset_userdata($keys) { foreach ($keys as $key) unset($this->data[$key]); }
    function sess_regenerate($destroy) { $this->regenerated = $destroy; }
}
class ConfigFake { function item($key) { return $key === 'sess_expiration' ? 3600 : 'portalfarma_session'; } }
$ci = (object) array('session' => new SessionFake(), 'config' => new ConfigFake());
function &get_instance() { global $ci; return $ci; }
class IdleTest extends Sessao_inatividade {
    public static $now = 10000; public static $expires;
    protected function agora() { return self::$now; }
    protected function renovar_cookie($ci, $expires) { self::$expires = $expires; }
}
function verify($value, $message) { if (!$value) throw new RuntimeException($message); }
$ci->session->data = array('usuario_logado' => array('id' => 1), 'ultima_atividade_restrito' => 6401);
new IdleTest();
verify(isset($ci->session->data['usuario_logado']), '3599 segundos mantém login');
verify($ci->session->data['ultima_atividade_restrito'] === 10000 && IdleTest::$expires === 13600, 'Atividade renova sessão e cookie');
IdleTest::$now = 13000; new IdleTest();
verify(isset($ci->session->data['usuario_logado']) && IdleTest::$expires === 16600, 'Navegação prolonga prazo');
IdleTest::$now = 16600;
$ci->session->data['permissao'] = 'BJHP'; $ci->session->data['bjhp_csrf'] = 'token';
new IdleTest();
foreach (array('usuario_logado', 'permissao', 'bjhp_csrf', 'ultima_atividade_restrito') as $key) {
    verify(!isset($ci->session->data[$key]), '3600 segundos remove ' . $key);
}
verify($ci->session->regenerated, 'Sessão expirada troca identificador');
$ci->session->data = array(); new IdleTest(); verify(!$ci->session->data, 'Visitante não ganha sessão autenticada');
echo "OK: sessão ativa, renovação a cada requisição e expiração após 1h de inatividade.\n";
