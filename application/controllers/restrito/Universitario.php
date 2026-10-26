<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Universitario extends CI_Controller {

	private function justificativa_com_usuario($motivo) {
		$usuarioLogado = $this->session->userdata('usuario_logado');
		$nomeUsuario = is_array($usuarioLogado) ? ($usuarioLogado['nome'] ?? 'Usuário não identificado') : 'Usuário não identificado';

		return json_encode([
			'motivo' => trim((string) $motivo),
			'usuario' => $nomeUsuario,
			'data' => date('Y-m-d H:i:s')
		], JSON_UNESCAPED_UNICODE);
	}

    public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->load->model('Moodle_model');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
		
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
	
	public function index() {
		$statusLista = $this->input->get('status');
		$statusLista = in_array((string) $statusLista, ['0', '1', '2'], true) ? (int) $statusLista : 0;

		$listaCursos = "SELECT tcu.* FROM web_site.tbl_capacifar_universitario AS tcu WHERE tcu.status = " . $statusLista . " ORDER BY tcu.id DESC";
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->query($listaCursos);
		$arrayDados['statusLista'] = $statusLista;
		$arrayDados['totaisStatus'] = [
			0 => $this->db->where('status', 0)->from('web_site.tbl_capacifar_universitario')->count_all_results(),
			1 => $this->db->where('status', 1)->from('web_site.tbl_capacifar_universitario')->count_all_results(),
			2 => $this->db->where('status', 2)->from('web_site.tbl_capacifar_universitario')->count_all_results()
		];

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/universitario_listar', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
    }
		
	public function alterar_status(){

		$id = (int) $this->input->post('id');
		$motivo = trim((string) $this->input->post('motivo'));

		if ($id <= 0 || $motivo === '') {
			echo json_encode([
				"status" => "error",
				"message" => "Informe o motivo do aceite."
			]);
			return;
		}

		$salvou = $this->capacifar_model->updateuni([
			'status' => 1,
			'recusa' => $this->justificativa_com_usuario($motivo)
		],$id);

		if($salvou){
			registrar_historico(21, $id);

			echo json_encode([
				"status"=>"success",
				"message"=>"Status alterado com sucesso."
			]);

		}else{

			echo json_encode([
				"status"=>"error",
				"message"=>"Erro ao alterar status."
			]);

		}

	}

	public function voltar_acao() {
		if (!$this->input->is_ajax_request() || $this->input->server('REQUEST_METHOD') !== 'POST') {
			show_404();
		}

		$id = (int) $this->input->post('id');
		if ($id <= 0) {
			echo json_encode(['status' => 'error', 'message' => 'Registro inválido.']);
			return;
		}

		$salvou = $this->db
			->where('id', $id)
			->where_in('status', [1, 2])
			->update('web_site.tbl_capacifar_universitario', [
				'status' => 0,
				'recusa' => null
			]);
		$salvou = $salvou && $this->db->affected_rows() > 0;
		if ($salvou) {
			registrar_historico(23, $id);
		}

		header('Content-Type: application/json');
		echo json_encode($salvou
			? ['status' => 'success', 'message' => 'Ação desfeita. O evento voltou para pendente.']
			: ['status' => 'error', 'message' => 'Não foi possível voltar a ação.']
		);
	}
	
	public function recusar() {
	
		$dados = array();
		
		$dados = $this->input->post();
		$motivoRecusa = trim((string) ($dados['descricao'] ?? ''));
		if (empty($dados['id']) || $motivoRecusa === '') {
			echo json_encode([
				'type' => 'error',
				'message' => 'Informe o motivo da recusa.'
			]);
			return;
		}
		$dados['descricao'] = $this->justificativa_com_usuario($motivoRecusa);
		//var_dump($dados);
		
		//$data = json_decode(file_get_contents('php://input'), true);
		
		
		$insert = $this->capacifar_model->UniversitarioRecusar($dados);
			
		if(!empty($insert)){
				registrar_historico(22, $dados['id']);
			
				// Enviar email

				/*$this->load->library('email');

				$texto_email = <<<EMAIL
				$cssmail
				<html>
				<body>
					<div class="container">
						<div class="header">
							<a href="https://crfmg.org.br" class="header-logo">
								<img src="https://crfmg.org.br/servicos/assets/img/logo/logoPrincipal.png" alt="CRFMG">
							</a>
						</div>
						<div class="body">
							<h2>Olá, $nome!</h2>
							<p>Agradecemos por sua inscrição no FiscalizacaoHumanizada.</b></p>
							<p>Informamos que recebemos sua inscrição</b>. Em breve, entraremos em contato através deste e-mail com mais informações sobre a confirmação de sua participação no evento.</p>
							<p>Agradecemos seu interesse e aguardamos ansiosamente sua presença.</p>
							<p>Em caso de dúvidas ou mais informações, nos envie uma mensagem para capacifar@crfmg.org.br ou no Whatsapp (31) 98869-0218.</p>
							<p>Atenciosamente,</p>
							<p>CRFMG</p>
						</div>
						<div class="footer">
							<p>Conselho Regional de Farmácia de Minas Gerais</p>
							<p>Rua Rua Rodrigues Caldas, 493 | CEP 30190-120 | Santo Agostinho
								<br> Belo Horizonte | Minas Gerais</p>
							<p>Telefone: 31 98869-0218 | E-mail: capacifar@crfmg.org.br</p>
						</div>
					</div>
				</body>
			</html>				
		EMAIL;

				$mail['body'] = $texto_email;
				$mail['user'] = $this->input->post('nome');
				$mail['text_align'] = "left";
				$bcc = $this->input->post('chk_email_cc') != '' ? $this->input->post('destinatario_cc') : null; 
				
				// enviar email
				$sendMail = $this->email->mySendMail($this->input->post('email'), "Recebimento de Inscrição - Fiscalização Humanizada - CRF/MG", $mail, 'default', null, null, null);
				*/
				
				$retorno['type'] = 'sucess';
				$retorno['message'] = 'Sua altera&ccedil;&atilde;o foi feita com sucesso!';
				echo json_encode($retorno);
				exit;
		} else {
			$retorno['type'] = 'darger';
			$retorno['message'] = 'Algo deu errado, entre em contato com suporte.';
			echo json_encode($retorno);
			exit;
		}
	}

	public function historico($id = null) {
		header('Content-Type: application/json; charset=UTF-8');
		$id = (int) $id;

		if ($id <= 0 || $this->db->where('id', $id)->count_all_results('web_site.tbl_capacifar_universitario') === 0) {
			echo json_encode(['status' => 'error', 'message' => 'Evento universitário não encontrado.', 'historico' => []]);
			return;
		}

		$historico = $this->db
			->select('h.id, h.data_hora, a.descricao AS acao, u.user AS usuario')
			->from('tbl_portalfarma_historico h')
			->join('tbl_portalfarma_auditoria_acoes a', 'a.id = h.id_acao', 'inner')
			->join('tbl_portalfarma_user u', 'u.id = h.id_usuario', 'left')
			->where('h.id_registro', $id)
			->where_in('h.id_acao', [21, 22, 23])
			->order_by('h.data_hora', 'DESC')
			->order_by('h.id', 'DESC')
			->get()
			->result();

		foreach ($historico as $registro) {
			$registro->data_formatada = date('d/m/Y H:i:s', strtotime($registro->data_hora));
			unset($registro->data_hora);
			$registro->usuario = $registro->usuario ?: 'Usuário não localizado';
		}

		echo json_encode(['status' => 'success', 'historico' => $historico]);
	}
	
	
}
