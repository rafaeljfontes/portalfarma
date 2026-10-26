<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_inscricoes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('usuario_logado')) {
            redirect('login');
            exit;
        }
        if (!in_array('admin', portalfarma_permissoes($this->session->userdata('permissao')), true)) {
            $this->output->set_status_header(403);
            $this->load->view('restrito/acesso_negado');
            exit;
        }
        // O cabeçalho compartilhado consulta os contadores do menu no banco.
        $this->load->database();
        $this->load->model('Inscricao_logs_model', 'logs_model');
    }

    public function index()
    {
        $busca = $this->input->get('busca');
        $busca = is_string($busca) ? mb_substr(trim($busca), 0, 200) : '';
        $pagina = $this->input->get('pagina');
        $pagina = is_scalar($pagina) ? max(1, (int) $pagina) : 1;
        $dados = $this->logs_model->consultar($busca, $pagina);
        $dados['busca'] = $busca;
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/logs_inscricoes', $dados);
        $this->load->view('restrito/fixo/rodape');
    }
}
