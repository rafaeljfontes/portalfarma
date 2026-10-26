<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Universitario  extends MY_Controller
{


	public function index()
	{
		$arrayDados = [];

		$this->carregarCabecalho($arrayDados);
		$this->load->view('universitario');
		//$this->load->view('embreve');
		$this->load->view('fixo/rodape');
	}

	public function salvar()
	{
		$solicitacao = array();

		$solicitacao = $this->input->post();
		$solicitacao['acesso'] = (($solicitacao['acesso'] ?? '0') === '1') ? 1 : 0;

		$dataEvento = DateTime::createFromFormat('Y-m-d\TH:i', (string) ($solicitacao['data'] ?? ''));
		$dataMinima = new DateTime('today');
		$dataMinima->modify('+15 days');
		$dataValida = $dataEvento
			&& $dataEvento->format('Y-m-d\TH:i') === (string) ($solicitacao['data'] ?? '')
			&& $dataEvento >= $dataMinima;

		if (!$dataValida) {
			$retorno = [
				'tipo' => 'danger',
				'msg' => 'A data do evento deve ser marcada com antecedência mínima de 15 dias.'
			];
			$this->session->set_flashdata($retorno);
			redirect('Universitario#universitario');
			return;
		}

		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);
		$insert = $this->capacitacao->InsertModelUniversity($solicitacao);

		if (!empty($insert)) {

			$retorno['tipo'] = "success";
			$retorno['msg'] = utf8_encode("Obrigado por convidar o CRF/MG para estar junto de sua institui&ccedil;&atilde;o. Faremos o poss&iacute;vel para atend&ecirc;-los com o tema escolhido.<br>
			<br>Em at&eacute; 7 dias nosso setor de capacita&ccedil;&otilde;es entrar&aacute; em contato sobre o atendimento de sua solicita&ccedil;&atilde;o.<br>
			<br>Caso precise, entre em contato conosco pelo Telefone: 31 3218 1026.<br>
			<br>
			At&eacute; breve!
			");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('Universitario');
		} else {

			$retorno['tipo'] = "danger";
			$retorno['msg'] = utf8_encode("Msg[025]: Poss&iacute;vel erro entre em contato com suporte t&eacute;cnico");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('Universitario');
		}
	}
}
