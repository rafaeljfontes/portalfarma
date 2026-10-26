<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doc_tecnico extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Doc_tecnico_model', 'documentos');
        $this->load->helper(['url', 'form']);
        if (!$this->session->userdata('usuario_logado')) redirect('login');
    }

    public function index() { $this->listar(); }

    public function listar() {
        $dados['documentos'] = $this->documentos->listar();
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/doc_tecnico_listar', $dados);
        $this->load->view('restrito/fixo/rodape');
    }

    public function criar() { $this->formulario(); }
    public function editar($id) { $this->formulario($id); }

    private function formulario($id = null) {
        $dados['documento'] = $id ? $this->documentos->buscar($id) : null;
        if ($id && !$dados['documento']) show_404();
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/doc_tecnico_form', $dados);
        $this->load->view('restrito/fixo/rodape');
    }

    public function salvar() {
        $id = (int) $this->input->post('id');
        $atual = $id ? $this->documentos->buscar($id) : null;
        $titulo = trim((string) $this->input->post('titulo'));
        if ($titulo === '') return $this->voltar_com_erro('Informe o título.');

        $pasta = FCPATH . 'uploads/doc_tecnico/';
        if (!is_dir($pasta)) mkdir($pasta, 0755, true);
        $dados = ['titulo' => $titulo];
        foreach (['capa' => 'jpg|jpeg|png|webp', 'arquivo' => 'pdf'] as $campo => $tipos) {
            if (!empty($_FILES[$campo]['name'])) {
                $config = ['upload_path' => $pasta, 'allowed_types' => $tipos, 'encrypt_name' => true, 'max_size' => 20480];
                $this->load->library('upload');
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($campo)) return $this->voltar_com_erro(strip_tags($this->upload->display_errors()));
                $nomeRetornado = $this->upload->data('file_name');
                $arquivosCriados = glob($pasta . '*' . $nomeRetornado);
                if (!empty($arquivosCriados)) {
                    usort($arquivosCriados, function ($a, $b) {
                        return filemtime($b) - filemtime($a);
                    });
                    $dados[$campo] = basename($arquivosCriados[0]);
                } else {
                    $dados[$campo] = $nomeRetornado;
                }
            }
        }
        if (!$atual && (empty($dados['capa']) || empty($dados['arquivo']))) {
            return $this->voltar_com_erro('Envie a capa e o documento PDF.');
        }
        if ($this->documentos->salvar($dados, $id ?: null)) {
            $this->session->set_flashdata('doc_sucesso', 'Documento salvo com sucesso.');
            redirect('restrito/doc_tecnico/listar');
        }
        $this->voltar_com_erro('Não foi possível salvar o documento.');
    }

    public function excluir($id) {
        $doc = $this->documentos->buscar($id);
        if (!$doc) show_404();
        if ($this->documentos->excluir($id)) {
            foreach ([$doc->capa, $doc->arquivo] as $nome) {
                $caminho = FCPATH . 'uploads/doc_tecnico/' . $nome;
                if (is_file($caminho)) unlink($caminho);
            }
            $this->session->set_flashdata('doc_sucesso', 'Documento excluído.');
        }
        redirect('restrito/doc_tecnico/listar');
    }

    private function voltar_com_erro($mensagem) {
        $this->session->set_flashdata('doc_erro', $mensagem);
        $referencia = $this->input->server('HTTP_REFERER');
        redirect($referencia ?: 'restrito/doc_tecnico/criar');
    }
}
