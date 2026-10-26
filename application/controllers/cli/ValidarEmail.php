<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ValidarEmail extends CI_Controller
{
    public function index($destinatario = '')
    {
        if (PHP_SAPI !== 'cli') { show_404(); return; }
        if ($destinatario === '') $destinatario = getenv('PORTALFARMA_EMAIL_TEST_TO') ?: '';
        if (!filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
            fwrite(STDERR, "Informe um destinatário válido.\n"); exit(1);
        }
        $copia = getenv('PORTALFARMA_EMAIL_TEST_CC') ?: '';
        if ($copia !== '' && !filter_var($copia, FILTER_VALIDATE_EMAIL)) {
            fwrite(STDERR, "Informe um destinatário de cópia válido.\n"); exit(1);
        }
        $this->load->library('email');
        $this->email->clear(true);
        $this->email->to($destinatario);
        if ($copia !== '') $this->email->cc($copia);
        $this->email->subject('Portal Farma — teste do serviço de e-mail');
        $this->email->set_mailtype('text');
        $this->email->message('Teste do transporte compartilhado dos serviços Portal Farma. Remetente: ' . MY_Email::REMETENTE . '. Nenhuma inscrição ou voto foi registrado por este teste.');
        $ok = $this->email->send();
        echo json_encode(array('enviado' => $this->email->transporte === 'fila' ? null : $ok,
            'registrado_na_fila' => $this->email->transporte === 'fila' ? $ok : null, 'ids_fila' => $this->email->ids_fila,
            'remetente' => MY_Email::REMETENTE,
            'destinatario' => $destinatario, 'copia' => $copia, 'protocolo' => $this->email->transporte === 'fila' ? 'fila' : $this->email->protocol, 'falha' => $this->email->falha_envio), JSON_UNESCAPED_UNICODE) . "\n";
        exit($ok ? 0 : 1);
    }

    public function estado()
    {
        if (PHP_SAPI !== 'cli') { show_404(); return; }
        $texto = getenv('PORTALFARMA_EMAIL_TEST_IDS') ?: '';
        if (!preg_match('/\A[1-9][0-9]*(,[1-9][0-9]*){0,19}\z/', $texto)) { fwrite(STDERR, "Informe os IDs do teste.\n"); exit(1); }
        $this->load->library('Portal_email_fila');
        $estado = $this->portal_email_fila->consultar(array_map('intval', explode(',', $texto)));
        echo json_encode(array('fila' => $estado), JSON_UNESCAPED_UNICODE) . "\n";
        exit($estado === null ? 1 : 0);
    }
}
