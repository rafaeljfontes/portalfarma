<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MeritoAcademico  extends MY_Controller
{

	public function index()
	{

		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCursos('MeritoAcademico');

		$this->carregarCabecalho();
		$this->load->view('merito_academico', $arrayDados);
		$this->load->view('fixo/rodape');
	}


	public function salvar()
	{
		$solicitacao = array();

		$solicitacao = $this->input->post();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);
		$insert = $this->capacitacao->InsertMeritoAcademico($solicitacao);

		if (!empty($insert)) {
			$retorno['tipo'] = "success";
			$retorno['msg'] = utf8_encode("Obrigado por convidar o CRF/MG para estar junto de sua institui&ccedil;&atilde;o durante este momento especial e importante. <br>Faremos o poss&iacute;vel para atend&ecirc;-los e estar com voc&ecirc;s na data solicitada.<br>
			Em at&eacute; 7 dias, o nosso setor de capacita&ccedil;&otilde;es entrar&aacute; em contato sobre o atendimento de sua solicita&ccedil;&atilde;o.
			Caso precise, entre em contato conosco pelo telefone: 31 3218 1026.<br>
			<br>
			At&eacute; breve!

			");
			$this->session->set_flashdata($retorno);

			//$this->_enviarEmail($dados['email'], $dados['nome']);
			//redirect('Capacitacao/Inscricao');
			redirect('MeritoAcademico');
		} else {
			$retorno['tipo'] = "danger";
			$retorno['msg'] = utf8_encode("Msg[025]: Poss&iacute;vel erro entre em contato com suporte t&eacute;cnico");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('MeritoAcademico');
		}
	}

	private function _enviarEmail($emailUsuario, $nome)
	{
		$this->email->clear(true);

		$this->email->from('noreply@crfmg.org.br', 'Sistema');

		// 📩 e-mail do usuário que preencheu o formulário
		$this->email->to($emailUsuario);

		// 👀 cópia oculta (não aparece para o usuário)
		

		$this->email->subject('Cadastro realizado com sucesso');
		$this->email->message("
			<h3>Olá, {$nome}!</h3>
			<p>Seu cadastro foi realizado com sucesso.</p>
			<p>Em breve entraremos em contato.</p>
		");

		return $this->email->send();
	}
}
