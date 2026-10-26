<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ACESSO RESTRITO / LOGIN

class Plenaria extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		require_once FCPATH . 'vendor/autoload.php';
		$this->dados 	= array();
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->dados['menu_ativo'] = "inicio";
		$this->load->model('Plenarias_model');
        $this->load->helper(['url', 'form']);
		
		
		// verifica se existe usuário logado
        if(!$this->session->userdata('usuario_logado')){
            redirect('login');
        }

        $controller = 'capacifar';

        $permissoes = $this->session->userdata('permissao');
        $permissoes = str_replace('permissão: ', '', $permissoes);
        $permissoes = array_map('trim', explode(',', $permissoes));

       /* if(!in_array($controller, $permissoes)){
            show_error('Sem permissão para acessar esta página',403);
        }*/
	}

	/**
     * Abre o formulário (Novo ou Edição)
     * @param int $id - Opcional
     */
    public function formulario($id = null) {
        $dados = [];

        if ($id) {
            // Se existe ID, buscamos os dados para EDITAR
            $busca = $this->Plenarias_model->getById($id);
            
            if ($busca) {
                $dados['edit'] = $busca; // Passa o objeto para a View
            } else {
                // Se o ID for inválido, redireciona com erro
                $this->session->set_flashdata('retorno', ['status' => 'error', 'mensagem' => 'Plenária não encontrada.']);
                redirect('restrito/Plenarias');
            }
        }

        // Carregamento das views
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/plenaria_form', $dados);
        $this->load->view('restrito/fixo/rodape');
    }

    /**
     * Processa os dados via AJAX (Insert ou Update)
     */
    public function salvar() {
        // Captura os dados do formulário
        $id    = $this->input->post('id');
        $dados = [
            'titulo'        => $this->input->post('titulo'),
            'link_youtube'  => $this->input->post('link_youtube'),
            'data_plenaria' => $this->input->post('data_plenaria'),
        ];

        // Validação básica de segurança no servidor
        if (empty($dados['titulo']) || empty($dados['data_plenaria'])) {
            echo json_encode(['status' => 'error', 'mensagem' => 'Preencha todos os campos obrigatórios.']);
            exit;
        }

        $this->db->trans_start(); // Inicia transação

        if ($id) {
            // Se tem ID, faz UPDATE
            $this->Plenarias_model->update($id, $dados);
			$idRegistro = (int) $id;
			$idAcao = 18;
            $msg = "Plenária atualizada com sucesso!";
        } else {
            // Se não tem ID, faz INSERT
			$idRegistro = (int) $this->Plenarias_model->insert($dados);
			$idAcao = 16;
            $msg = "Plenária cadastrada com sucesso!";
        }

        $this->db->trans_complete();

        ob_clean(); // Limpa buffer
        header('Content-Type: application/json');

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao salvar no banco de dados.']);
        } else {
			registrar_historico($idAcao, $idRegistro);
            echo json_encode(['status' => 'success', 'mensagem' => $msg]);
        }
        exit;
    }
	
	public function listar() {
	
		$dados = array();
		
		$sql = "SELECT
							tpp.*							
						FROM web_site.tbl_portalfarma_plenaria_tecnica tpp
						ORDER BY tpp.data_plenaria DESC;";
		
		$this->dados['tabela'] 		= $this->capacifar_model->query($sql);

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/plenarias', $this->dados);
		$this->load->view('restrito/fixo/rodape');
    }
	
	
	public function excluir($id = null) {
		// Verifica se o ID foi passado e se a requisição é AJAX (opcional, por segurança)
		if (!$id) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'error', 'mensagem' => 'ID não informado.']);
			exit;
		}
		
		//print_r($id);

		$this->db->trans_start();

		// Chama o método de exclusão no Model
		$deletado = $this->Plenarias_model->delete($id);

		$this->db->trans_complete();

		// Prepara a resposta JSON
		ob_clean(); 
		header('Content-Type: application/json');

		if ($this->db->trans_status() === FALSE) {
			echo json_encode([
				'status' => 'error', 
				'mensagem' => 'Não foi possível excluir o registro no banco de dados.'
			]);
		} else {
			registrar_historico(17, $id);
			echo json_encode([
				'status' => 'success', 
				'mensagem' => 'Plenária excluída com sucesso!'
			]);
		}
		exit;
	}
	
}
