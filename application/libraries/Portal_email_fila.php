<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal_email_fila
{
    public $ids = array();
    public $falha;

    protected function conectar()
    {
        $arquivo = APPPATH . 'config/email_fila.php';
        if (!is_file($arquivo)) throw new RuntimeException('Configuração da fila ausente.');
        $parametros = require $arquivo;
        $ci =& get_instance();
        return $ci->load->database($parametros, true);
    }

    public function registrar($destinatarios, $assunto, $conteudo)
    {
        $this->ids = array(); $this->falha = null;
        $destinatarios = array_values(array_unique($destinatarios));
        if (!$destinatarios) { $this->falha = 'destinatario'; return false; }
        foreach ($destinatarios as $email) {
            if (!is_string($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $this->falha = 'destinatario'; return false; }
        }
        $db = null;
        try {
            $db = $this->conectar();
            if (!$db || !$db->trans_begin()) { $this->falha = 'banco'; return false; }
            $agora = date('Y-m-d H:i:s');
            $ids = array();
            foreach ($destinatarios as $email) {
                // Mesmo contrato utilizado pelos controllers do site-crfmg.
                $linha = array('modulo' => 'portalfarma', 'id_modulo' => 0, 'tipo' => 'notificacao',
                    'pessoa' => 'PF', 'crfmg' => '', 'email_destinatario' => $email, 'email_cco' => '',
                    'assunto' => $assunto, 'conteudo' => $conteudo, 'anexos' => '[]',
                    'status' => 'pendente', 'tentativas' => 0, 'max_tentativas' => 3, 'retorno_erro' => '',
                    'login_created' => 'portalfarma', 'created_at' => $agora,
                    'login_updated' => '', 'updated_at' => $agora, 'login_deleted' => '');
                if (!$db->insert('tb_disparo_email', $linha)) { $db->trans_rollback(); $this->falha = 'banco'; return false; }
                $ids[] = (int) $db->insert_id();
            }
            if (!$db->trans_status() || !$db->trans_commit()) { $db->trans_rollback(); $this->falha = 'banco'; return false; }
            $this->ids = $ids;
            return true;
        } catch (Throwable $erro) {
            if ($db) $db->trans_rollback();
            $this->falha = 'banco';
            log_message('error', 'Portal Farma: falha ao registrar disparo na fila crftech (' . get_class($erro) . ').');
            return false;
        }
    }

    public function consultar($ids)
    {
        try {
            $db = $this->conectar();
            $consulta = $db->select('id, status, tentativas')->where_in('id', $ids)->get('tb_disparo_email');
            return $consulta ? $consulta->result_array() : null;
        } catch (Throwable $erro) { return null; }
    }
}
