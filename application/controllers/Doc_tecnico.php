<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doc_tecnico extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Doc_tecnico_model', 'documentos');
        $this->load->helper('url');
    }

    public function index() {
        $dados['documentos'] = $this->documentos->listar();
        foreach ($dados['documentos'] as $documento) {
            $documento->capa = $this->corrigir_nome_arquivo($documento, 'capa');
        }
        $this->carregarCabecalho($dados);
        $this->load->view('doc_tecnico', $dados);
        $this->load->view('fixo/rodape');
    }

    public function abrir($id) {
        $documento = $this->documentos->buscar($id);
        if (!$documento) show_404();
        $documento->arquivo = $this->corrigir_nome_arquivo($documento, 'arquivo');

        $documentosAcessados = $this->session->userdata('doc_tecnico_acessados');
        if (!is_array($documentosAcessados)) $documentosAcessados = [];

        if (!in_array((int) $documento->id, $documentosAcessados, true)) {
            $this->documentos->incrementar_acesso($documento->id);
            $documentosAcessados[] = (int) $documento->id;
            $this->session->set_userdata('doc_tecnico_acessados', $documentosAcessados);
        }

        redirect(base_url('uploads/doc_tecnico/' . rawurlencode($documento->arquivo)));
    }

    private function corrigir_nome_arquivo($documento, $campo) {
        $nome = basename((string) $documento->$campo);
        $pasta = FCPATH . 'uploads/doc_tecnico/';
        if ($nome === '' || is_file($pasta . $nome)) return $nome;

        $encontrados = glob($pasta . '*' . $nome);
        if (empty($encontrados)) return $nome;

        $nomeReal = basename($encontrados[0]);
        $this->documentos->salvar([$campo => $nomeReal], $documento->id);
        return $nomeReal;
    }
}
