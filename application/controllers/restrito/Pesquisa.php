<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ACESSO RESTRITO / LOGIN

class Pesquisa extends CI_Controller {
	private function justificativa_com_usuario($motivo) {
		$usuarioLogado = $this->session->userdata('usuario_logado');
		$nomeUsuario = is_array($usuarioLogado) ? ($usuarioLogado['nome'] ?? 'Usuário não identificado') : 'Usuário não identificado';
		return json_encode(['motivo' => trim((string) $motivo), 'usuario' => $nomeUsuario, 'data' => date('Y-m-d H:i:s')], JSON_UNESCAPED_UNICODE);
	}
	
	public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->load->model('Moodle_model');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
		
		// verifica se existe usuário logado
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
	
	public function listar() {
		$statusLista = $this->input->get('status');
		$statusLista = in_array((string) $statusLista, ['0', '1', '2'], true) ? (int) $statusLista : 0;
		$lista = "SELECT tct.* FROM web_site.tbl_capacifar_trabalhocientifico AS tct WHERE tct.status = " . $statusLista . " ORDER BY tct.id_pesquisa DESC";
		
		$arrayDados['tabela'] 		= $this->capacifar_model->query($lista);
		$arrayDados['statusLista'] = $statusLista;
		$arrayDados['totaisStatus'] = [
			0 => $this->db->where('status', 0)->from('web_site.tbl_capacifar_trabalhocientifico')->count_all_results(),
			1 => $this->db->where('status', 1)->from('web_site.tbl_capacifar_trabalhocientifico')->count_all_results(),
			2 => $this->db->where('status', 2)->from('web_site.tbl_capacifar_trabalhocientifico')->count_all_results()
		];

$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/pesquisa_cientifica', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
    }
	
	
	
	public function alterar_status() {
		$id = (int) $this->input->post('id');
		$status = (int) $this->input->post('status');
		$motivo = trim((string) $this->input->post('descricao'));

		header('Content-Type: application/json');

		if ($id <= 0 || !in_array($status, [1, 2], true) || $motivo === '') {
			echo json_encode(['type' => 'error', 'message' => 'Informe o motivo da decisão.']);
			return;
		}

		$this->db->trans_begin();

		$salvouPesquisa = $this->db
			->where('id_pesquisa', $id)
			->where('status', 0)
			->update('web_site.tbl_capacifar_trabalhocientifico', [
				'status' => $status,
				'motivo' => $motivo
			]);

		$salvouPesquisa = $salvouPesquisa && $this->db->affected_rows() > 0;
		$salvouHistorico = $salvouPesquisa
			? registrar_historico($status === 1 ? 14 : 15, $id)
			: false;

		if ($salvouPesquisa && $salvouHistorico && $this->db->trans_status()) {
			$this->db->trans_commit();
			
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
				
			echo json_encode([
				'type' => 'sucess',
				'message' => $status === 1
					? 'Pesquisa aceita e motivo salvo com sucesso!'
					: 'Pesquisa recusada e motivo salvo com sucesso!'
			]);
			return;
		} else {
			$this->db->trans_rollback();
			echo json_encode([
				'type' => 'error',
				'message' => 'Não foi possível salvar a decisão e o histórico. Verifique se a pesquisa ainda está pendente.'
			]);
			return;
		}
	}

	public function voltar_acao() {
		if (!$this->input->is_ajax_request() || $this->input->server('REQUEST_METHOD') !== 'POST') show_404();
		$id = (int) $this->input->post('id');
		$salvou = $id > 0 && $this->db->where('id_pesquisa', $id)->where_in('status', [1, 2])->update('web_site.tbl_capacifar_trabalhocientifico', [
			'status' => 0, 'motivo' => null
		]);
		$salvou = $salvou && $this->db->affected_rows() > 0;
		header('Content-Type: application/json');
		echo json_encode($salvou ? ['status' => 'success', 'message' => 'Ação desfeita. A pesquisa voltou para pendente.'] : ['status' => 'error', 'message' => 'Não foi possível voltar a ação.']);
	}

	public function historico($id = null) {
		header('Content-Type: application/json; charset=UTF-8');
		$id = (int) $id;

		$pesquisa = $id > 0
			? $this->db
				->select('id_pesquisa, motivo')
				->where('id_pesquisa', $id)
				->get('web_site.tbl_capacifar_trabalhocientifico')
				->row()
			: null;

		if (!$pesquisa) {
			echo json_encode(['status' => 'error', 'message' => 'Pesquisa científica não encontrada.', 'historico' => []]);
			return;
		}

		$historico = $this->db
			->select('h.id, h.data_hora, h.id_acao, a.descricao AS acao, u.user AS usuario')
			->from('tbl_portalfarma_historico h')
			->join('tbl_portalfarma_auditoria_acoes a', 'a.id = h.id_acao', 'inner')
			->join('tbl_portalfarma_user u', 'u.id = h.id_usuario', 'left')
			->where('h.id_registro', $id)
			->where_in('h.id_acao', [14, 15])
			->order_by('h.data_hora', 'DESC')
			->order_by('h.id', 'DESC')
			->get()
			->result();

		foreach ($historico as $indice => $registro) {
			$registro->data_formatada = date('d/m/Y H:i:s', strtotime($registro->data_hora));
			$registro->usuario = $registro->usuario ?: 'Usuário não localizado';
			$registro->motivo = $indice === 0 ? (string) $pesquisa->motivo : '';
			unset($registro->data_hora);
		}

		echo json_encode(['status' => 'success', 'historico' => $historico]);
	}
    
	
}
