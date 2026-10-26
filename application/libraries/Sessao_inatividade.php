<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Carregada logo após session, antes das verificações dos controllers.
class Sessao_inatividade
{
    public function __construct()
    {
        $ci =& get_instance();
        if (!$ci->session->userdata('usuario_logado')) return;

        $now = $this->agora();
        $last = (int) $ci->session->userdata('ultima_atividade_restrito');
        $timeout = (int) $ci->config->item('sess_expiration');
        if ($last > 0 && $now - $last >= $timeout) {
            $ci->session->unset_userdata(array('usuario_logado', 'permissao', 'bjhp_csrf', 'ultima_atividade_restrito'));
            $ci->session->sess_regenerate(true);
            return;
        }

        $ci->session->set_userdata('ultima_atividade_restrito', $now);
        // O CI nem sempre renova o cookie em toda navegação. Mantém a janela
        // deslizante também no navegador, inclusive nas requisições AJAX.
        $this->renovar_cookie($ci, $now + $timeout);
    }

    protected function agora() { return time(); }

    protected function renovar_cookie($ci, $expires)
    {
        if (headers_sent() || session_status() !== PHP_SESSION_ACTIVE) return;
        $params = session_get_cookie_params();
        setcookie($ci->config->item('sess_cookie_name'), session_id(), array(
            'expires' => $expires, 'path' => $params['path'], 'domain' => $params['domain'],
            'secure' => $params['secure'], 'httponly' => true,
            'samesite' => $params['samesite'] ?? 'Lax'
        ));
    }
}
