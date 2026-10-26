<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesquisa  extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
        $this->load->helper(['url', 'form']);
	}

	public function nps($id = null){
	
		$dados = [];
		
		$dados['id'] = $id !== null ? $id : $this->uri->segment('3');
		if ($dados['id'] === null || $dados['id'] === '') {
			show_404();
			return;
		}
		
		$query = "SELECT pf.* FROM tbl_portalfarma pf WHERE pf.courseid = " . $this->db->escape($dados['id']) . " LIMIT 1";

		$dados['portalfarma'] = $this->capacifar_model->query($query);
		if (empty($dados['portalfarma'])) {
			show_404();
			return;
		}

		$dados['embedded'] = $this->input->get('embedded') === '1';
        if ($dados['embedded']) {
            $this->load->view('pesquisa_embed', $dados);
            return;
        }
		$this->carregarCabecalho($dados);
		$this->load->view('pesquisa', $dados);
		$this->load->view('fixo/rodape');
	
	}
	
	public function nps_cadastrar(){
	
		// 1. Recebe os dados do POST
		$dados = $this->input->post();
        if ($this->input->method() !== 'post') { show_error('Método não permitido.', 405); return; }
        foreach (['courseid', 'email', 'escala', 'perguntaA', 'perguntaB', 'perguntaC', 'perguntaD', 'perguntaE'] as $campo) {
            $dados[$campo] = isset($dados[$campo]) && is_string($dados[$campo]) ? trim($dados[$campo]) : '';
        }
        $this->output->set_content_type('application/json');
        $dados['email'] = strtolower($dados['email']);
		
		// 2. Validação básica (Campos obrigatórios)
		if (empty($dados['courseid']) || empty($dados['email']) || !preg_match('/^(?:[0-9]|10)$/D', $dados['escala']) || empty($dados['perguntaA']) || empty($dados['perguntaB']) || empty($dados['perguntaC']) || !filter_var($dados['email'], FILTER_VALIDATE_EMAIL) || !in_array($dados['perguntaD'], ['sim', 'não', 'talvez'], true) || !$this->db->where('courseid', $dados['courseid'])->count_all_results('tbl_portalfarma')) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Preencha todos os campos obrigatórios.'
			]);
			return;
		}

		// 3. Verifica se já existe inscrição para este CPF neste curso específico
		$this->db->where('email', $dados['email']); // ou $cpf_limpo
		$this->db->where('courseid', $dados['courseid']);
		$existe = $this->db->get('tbl_portalfarma_nps')->num_rows();

		if ($existe > 0) {
			echo json_encode([
				'status'  => 'warning',
				'message' => 'Você já respondeu essa pesquisa.'
			]);
			return;
		}

		// 4. Prepara os dados para inserção
		$data_insert = [
			
			'courseid'          => $dados['courseid'],
			'email'             => strtolower($dados['email']),
			'escala'            => $dados['escala'],
			'perguntaA'         => mb_strtoupper($dados['perguntaA']),
			'perguntaB'         => mb_strtoupper($dados['perguntaB']),
			'perguntaC'         => mb_strtoupper($dados['perguntaC']),
			'perguntaD'         => mb_strtoupper($dados['perguntaD']),
			'perguntaE'         => mb_strtoupper($dados['perguntaE']),
			'data_cadastro'     => date('Y-m-d H:i:s')
		];

		// 5. Insere no banco
		if ($this->db->insert('tbl_portalfarma_nps', $data_insert)) {
    
			echo json_encode([
				'status'  => 'success',
				//'message' => 'Inscrição realizada com sucesso! Um e-mail de confirmação foi enviado.'
				'message' => 'Respostas salvas com sucesso!'
			]);
		} else {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Erro interno ao salvar suas respostas. Tente novamente mais tarde.'
			]);
		}
	
	}

}	
