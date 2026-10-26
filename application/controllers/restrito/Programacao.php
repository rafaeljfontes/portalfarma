<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ACESSO RESTRITO / LOGIN

class Programacao extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		
		$this->dados 	= array();
		$dados 			= array();
		$programacoes 	= array();
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->dados['menu_ativo'] = "inicio";
		$this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
		
		
		// verifica se existe usuário logado
        if(!$this->session->userdata('usuario_logado')){
            redirect('login');
        }

        $controller = 'capacifar';

        $permissoes = $this->session->userdata('permissao');
        $permissoes = str_replace('permissão: ', '', $permissoes);
        $permissoes = array_map('trim', explode(',', $permissoes));

        if(!in_array($controller, $permissoes)){
            show_error('Sem permissão para acessar esta página',403);
        }
	}
	
	public function index()
    {
        $listar = "SELECT	c.* FROM tbl_portalfarma c;";
		
		$this->dados['cursos'] 		= $this->capacifar_model->query($listar);
        
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/programacao_view', $this->dados);
		$this->load->view('restrito/fixo/rodape');
    }

    public function buscarProgramacao()
    {
        $courseid = $this->input->post('courseid');
		
		
		$qry1 	= "SELECT c.* FROM tbl_portalfarma c WHERE c.courseid = '".$courseid."';";
		$qry2 	= "SELECT p.* FROM tbl_portalfarma_programacao p WHERE p.status = 1 AND p.courseid = '".$courseid."';";
		

        $curso 			= $this->capacifar_model->query($qry1);
        $programacao 	= $this->capacifar_model->query($qry2);

        echo json_encode([
            'curso' => $curso,
            'programacao' => $programacao
        ]);
    }
	
	public function cadastrar()
	{
		$dados = array();
		
		$listar = "SELECT	c.* FROM tbl_portalfarma c;";
		
		$this->dados['cursos'] 		= $this->capacifar_model->query($listar);

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/programacao_cadastrar', $this->dados);
		$this->load->view('restrito/fixo/rodape');
	}
	
	public function salvar() 
	{
		
		$curso_id     = $this->input->post('curso_id');
        $programacoes = $this->input->post('programacao');

        if (!$curso_id || empty($programacoes)) {
            show_error('Dados inválidos.');
        }

        $salvou = $this->capacifar_model->inserir_programacoes($curso_id, $programacoes);

        if ($salvou) {
				foreach ($salvou as $idProgramacao) {
					registrar_historico(5, $idProgramacao);
				}
				$retorno['type'] = 'sucess';
				$retorno['message'] = 'Sua Programa&ccedil;&atilde;o foi feita com sucesso!';
				echo json_encode($retorno);
				exit;
		} else {
			$retorno['type'] = 'darger';
			$retorno['message'] = 'Algo deu errado, entre em contato com suporte.';
			echo json_encode($retorno);
			exit;
		}
		
    }
	
	public function atualizar() {
	
	 $data = [];
		
		$data = [
			'id'          		 => $this->input->post('prog_id'),
			'palestra'           => $this->input->post('palestra'),
			'data_hora_inicial'  => $this->input->post('data_hora_inicial'),
			'hora_final'         => $this->input->post('hora_final'),
			'descricao'          => $this->input->post('descricao')
		];

		$update = $this->capacifar_model->updateprogramacao($data);
		
		
		if($update) {
			registrar_historico(6, $data['id']);
			echo json_encode(['status' => 'success'] );
		} else {
			echo json_encode(['status' => 'error']);
		}
		
	}
	
	public function excluir_item() {
		// Verifica se é uma requisição AJAX
		if (!$this->input->is_ajax_request()) {
			exit('Acesso direto não permitido');
		}

		$id = $this->input->post('id');

		if ($id) {
			//$this->load->model('Programacao_model');
			
			// Executa a exclusão lógica (status = 0)
			$update = $this->capacifar_model->alterar_status_prog($id, 0);

			if ($update) {
				echo json_encode(['type' => 'success', 'message' => 'Item removido da programação!']);
			} else {
				echo json_encode(['type' => 'danger', 'message' => 'Erro ao tentar excluir no banco de dados.']);
			}
		} else {
			echo json_encode(['type' => 'danger', 'message' => 'ID inválido.']);
		}
	}
    
}
