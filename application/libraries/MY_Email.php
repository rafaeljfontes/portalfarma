<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Email extends CI_Email
{
    const REMETENTE = 'noreply@crfmg.org.br';
    public $falha_envio;
    public $ids_fila = array();
    public $transporte;
    private $ci;
    private $configuracao = array();
    private $assunto_fila = '';

    public function __construct(array $config = array())
    {
        $this->ci =& get_instance();
        $this->ci->config->load('email', true);
        $this->configuracao = (array) $this->ci->config->item('email');
        $this->transporte = $this->configuracao['portal_transport'] ?? 'direto';
        parent::__construct($config);
    }

    public function initialize(array $config = array())
    {
        return parent::initialize(array_merge($config, $this->configuracao));
    }

    public function from($from, $name = '', $return_path = null)
    {
        $remetente = getenv('MAIL_FROM_ADDRESS') ?: self::REMETENTE;
        return parent::from($remetente, getenv('MAIL_FROM_NAME') ?: 'Portal Farma', $remetente);
    }

    public function subject($subject)
    {
        $this->assunto_fila = preg_replace('/[\r\n]+/', ' ', (string) $subject);
        return parent::subject($subject);
    }

    public function clear($clear_attachments = false)
    {
        $this->assunto_fila = '';
        return parent::clear($clear_attachments);
    }

    public function send($auto_clear = true)
    {
        $enviado = false;
        $this->falha_envio = null;
        $this->ids_fila = array();
        $nivel = ob_get_level();
        ob_start();
        set_error_handler(function ($gravidade, $mensagem, $arquivo, $linha) {
            $this->falha_envio = $this->classificar_falha($mensagem);
            throw new ErrorException('Falha no transporte de e-mail.', 0, $gravidade, $arquivo, $linha);
        }, E_WARNING | E_USER_WARNING);
        try {
            $this->from(self::REMETENTE);
            $enviado = $this->transporte === 'fila' ? $this->enviar_para_fila() : parent::send($auto_clear);
            if ($enviado && $this->transporte === 'fila' && $auto_clear) $this->clear();
        } catch (Throwable $erro) {
            log_message('error', 'Portal Farma: falha no transporte de e-mail (' . get_class($erro) . ').');
        } finally {
            restore_error_handler();
            while (ob_get_level() > $nivel) ob_end_clean();
        }
        if (!$enviado) {
            if ($this->falha_envio === null) $this->falha_envio = $this->classificar_falha(implode("\n", $this->_debug_msg));
            log_message('error', 'Portal Farma: e-mail não enviado (' . $this->falha_envio . '). Verifique application/config/email.php.');
        }
        return $enviado;
    }

    protected function enviar_para_fila()
    {
        if ($this->_attachments) { $this->falha_envio = 'anexos_nao_suportados'; return false; }
        $destinatarios = is_array($this->_recipients) ? $this->_recipients : $this->_str_to_array($this->_recipients);
        // A fila do site não possui cabeçalho CC: cada cópia recebe um registro próprio.
        $destinatarios = array_merge($destinatarios, $this->_cc_array, $this->_bcc_array);
        $assunto = $this->assunto_fila;
        $conteudo = $this->mailtype === 'html' ? $this->_body : nl2br(htmlspecialchars($this->_body, ENT_QUOTES, 'UTF-8'));
        $this->ci->load->library('Portal_email_fila');
        $ok = $this->ci->portal_email_fila->registrar($destinatarios, $assunto, $conteudo);
        $this->ids_fila = $this->ci->portal_email_fila->ids;
        $this->falha_envio = $this->ci->portal_email_fila->falha;
        return $ok;
    }

    private function classificar_falha($mensagem)
    {
        if (preg_match('/535|534|authentication|authenticate|auth_failed|username and password|5\.7\.8/i', $mensagem)) return 'autenticacao';
        if (preg_match('/certificate|crypto|STARTTLS|TLS|SSL/i', $mensagem)) return 'seguranca';
        if (preg_match('/connect|connection|socket|timed out|network|unreachable|refused|conex/i', $mensagem)) return 'conexao';
        if (preg_match('/550|553|sender|5\.7\.1/i', $mensagem)) return 'remetente_ou_destinatario';
        return 'transporte';
    }

    public function mySendMail($email, $subject, $body, $template = 'default', $cc = null, $bcc = null, $replyto = null)
    {
        $this->clear(true);
        $this->from(self::REMETENTE);
        $this->to($email);
        if ($cc) $this->cc($cc);
        if ($bcc) $this->bcc($bcc);
        if ($replyto) $this->reply_to($replyto);
        $this->subject($subject);
        $this->set_mailtype('html');
        $this->message($this->ci->load->view('emails/' . $template, $body, true));
        return $this->send();
    }
}
