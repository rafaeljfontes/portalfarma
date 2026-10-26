<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capacitacao extends MY_Controller {
    private $diagnosticoConsultaRegistro = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function inscricao()
	{

		//$nome_curto = $this->input->post('txtnomecurto');
		//$courseid = $this->input->post('txtcourseid');
		//$menuid = $this->input->post('txtmenuid');
		//$publicoalvo = $this->input->post('txtpublicoalvo');

		//echo $publicoalvo;
		$dados = array();
		$session = array();

		$session['curso'] 	= $this->input->post('txtCurso');
		$session['nomecurto'] 	= $this->input->post('txtnomecurto');
		$session['courseid'] 		= $this->input->post('txtcourseid');
		$session['menuid'] 		= $this->input->post('txtmenuid');
		$session['publicoalvo'] 	= $this->input->post('txtpublicoalvo');

		
		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = $this->uri->segment('3');
		//$id = 1;
		//print_r($id);exit;
		
		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCourseId($id);

		$this->load->view('fixo/cabecalho');
		$this->load->view('inscricao', $arrayDados);
		$this->load->view('fixo/rodape');
	}
	
	public function inscricao_teste()
	{
		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = $this->uri->segment('3');
		//$id = 1;
		//print_r($id);exit;
		
		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCourseId($id);

		//print_r($arrayDados);exit;	
		$this->load->view('fixo/cabecalho');
		$this->load->view('inscricao_teste',$arrayDados);
		$this->load->view('fixo/rodape');
	}

	public function Interativo()
	{

		$solicitacao = array();

		$solicitacao = $this->input->post();

		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'http://api.crfmg.org.br/api/buscar/BuscarSeccional' );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'cidade' => $solicitacao['naturalidade'],
				'uf' => $solicitacao['uf_natural'],
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
		//var_dump($response["dados"]);exit;
		@$solicitacao["seccionalId"] = $response["dados"][0]['SeccionalId'];

		//var_dump($solicitacao);exit;
		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);
		$insert = $this->capacitacao->InsertInterativo($solicitacao);

		if(!empty($insert)){
			$retorno['tipo'] = "success";
			$retorno['msg'] = utf8_encode ("Obrigado por nos ajudar a fazer o melhor para todos estudantes e formados em farmácia.
			Caso precise, entre em contato conosco pelo telefone: 31 3218 1026.<br>
			<br>
			At&eacute; breve!
			");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('Interativo');
		}	else {
			$retorno['tipo'] = "danger";
			$retorno['msg'] = utf8_encode ("Msg[025]: Poss&iacute;vel erro entre em contato com suporte t&eacute;cnico");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('Interativo');
		}
	}

	public function InscricaoMeritoAcademico(){
		$solicitacao = array();

		$solicitacao = $this->input->post();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);
		$insert = $this->capacitacao->InsertMeritoAcademico($solicitacao);

		if(!empty($insert)){
			$retorno['tipo'] = "success";
			$retorno['msg'] = utf8_encode ("Obrigado por convidar o CRF/MG para estar junto de sua institui&ccedil;&atilde;o durante este momento especial e importante. <br>Faremos o poss&iacute;vel para atend&ecirc;-los e estar com voc&ecirc;s na data solicitada.<br>
			Em at&eacute; 7 dias, o nosso setor de capacita&ccedil;&otilde;es entrar&aacute; em contato sobre o atendimento de sua solicita&ccedil;&atilde;o.
			Caso precise, entre em contato conosco pelo telefone: 31 3218 1026.<br>
			<br>
			At&eacute; breve!

			");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('MeritoAcademico');
		}	else {
			$retorno['tipo'] = "danger";
			$retorno['msg'] = utf8_encode ("Msg[025]: Poss&iacute;vel erro entre em contato com suporte t&eacute;cnico");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('MeritoAcademico');
		}

	}

	public function InscricaoCasaESua(){
		$solicitacao = array();

		$solicitacao = $this->input->post();
		//print_r($solicitacao);exit;
		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);
		$insert = $this->capacitacao->InsertCasaESua($solicitacao);

		if(!empty($insert)){
			$retorno['tipo'] = "success";
			$retorno['msg'] = utf8_encode ("Sua inscri&ccedil;&atilde;o foi realizada com sucesso.<br>
				Sua visita acontecer&aacute; na data escolhida, de 14 &agrave;s 17 horas. <br>
				Fique atento! Com at&eacute; uma semana de anteced&ecirc;ncia nosso setor de capacita&ccedil;&otilde;es encaminhar&aacute; para o email registrado as orienta&ccedil;&otilde;es sobre nosso encontro.<br>
				Caso n&atilde;o possa comparecer, pedimos que nos informe com anteced&ecirc;ncia no email: capacifar@crfmg.org.br<br>
				Caso precise, entre em contato conosco pelo telefone: 31 3218 1026.<br>
				<br>
				At&eacute; breve!

			");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('aCasaeSua');
		}	else {
			$retorno['tipo'] = "danger";
			$retorno['msg'] = utf8_encode ("Msg[025]: Poss&iacute;vel erro entre em contato com suporte t&eacute;cnico");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('aCasaeSua');
		}

	}
	public function InsertUniversity(){
		$solicitacao = array();

		$solicitacao = $this->input->post();
		
		//print_r($solicitacao['g-recaptcha-response']);exit;
		if(empty($solicitacao['g-recaptcha-response'])){
			$retorno['tipo'] = "danger";
			$retorno['msg'] = utf8_encode ("Msg[026]: Você não marcou que não é um Robô!");
			$this->session->set_flashdata($retorno);
			redirect('Universitario');
		} else {
			unset($solicitacao["g-recaptcha-response"]);
		}
		
		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);
		$insert = $this->capacitacao->InsertModelUniversity($solicitacao);

		if(!empty($insert)){
			
			$retorno['tipo'] = "success";
			$retorno['msg'] = utf8_encode ("Obrigada por convidar o CRF/MG para estar junto de sua institui&ccedil;&atilde;o. Faremos o poss&iacute;vel para atend&ecirc;-los com o tema escolhido.<br>
			Em até 7 dias nosso setor de capacita&ccedil;&otilde;es entrar&aacute; em contato sobre o atendimento de sua solicita&ccedil;&atilde;o.<br>
			Caso precise, entre em contato conosco pelo telefone: 31 3218 1026.<br>
			<br>
			At&eacute; breve!
			");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('Universitario');
		}	else {
			
			$retorno['tipo'] = "danger";
			$retorno['msg'] = utf8_encode ("Msg[025]: Poss&iacute;vel erro entre em contato com suporte t&eacute;cnico");
			$this->session->set_flashdata($retorno);
			//redirect('Capacitacao/Inscricao');
			redirect('Universitario');
		}
	}

	public function inscricaoAva()
	{

		$dados 	= array();
		$ret 	= array();

		$dados['post'] = $this->input->post();
		
		if($dados['post']['course_id'] == '138'){
			if(empty($dados['post']['crfmg'])){
				$retorno['type']    = 'warning';
				$retorno['title']   = 'Campos em branco ';
				$retorno['message'] = 'Preencha os campo de CRFMG corretamente (Curso exclusivo para farmacêuticos)';
					
				echo json_encode($retorno);
				exit;
			}			
		}
		
		
		//print_r($dados['post']['course_id']);exit;

		/*
		$this->load->library('form_validation');

		$this->form_validation->set_rules('cpf', 'CPF', 'required|min_length[11]|max_length[11]');
		$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[10]|max_length[200]');
		$this->form_validation->set_rules('telefone', 'Telefone', 'required|min_length[10]|max_length[200]');
		$this->form_validation->set_rules('cidade', 'Cidade', 'required|min_length[4]|max_length[200]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$erros = array('mensagens' => validation_errors());
			$this->load->view('Capacitacao/Inscricao', $erros);
		} else {
			echo "Formulário enviado com sucesso.";
		}
		*/
		
			
			
		if(empty($dados['post'])){
			$retorno['type']    = 'warning';
			$retorno['title']   = 'Campos em branco ';
			$retorno['message'] = 'Preencha os campos corretamente';
				
           	echo json_encode($retorno);
			exit;
			/*
			$retorno['tipo'] = "warning";
			$retorno['msg'] = utf8_encode ("Preencha os campos.");
			$this->session->set_flashdata($retorno);
			redirect('Capacitacao/Inscricao');
			*/
		}

		if($dados['post']['publicoalvo'] == '5'){
			///API Lucas *** VERIFICA SE É FARMACÊUTICO
			$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'http://api.crfmg.org.br/api/check/pf-existe' );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'cpf' => $dados['post']['cpf'],
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
				//var_dump($response);

				if($response['message'] == "nenhum registro encontrado"){
					/*
					$retorno['tipo'] = "warning";
					$retorno['msg'] = utf8_encode ("Voc&ecirc; n&atilde;o &eacute; um farmaceutico vinculado ao CRF. Este curso &eacute; apenas para Farmac&ecirc;uticos vinculados.");
					$this->session->set_flashdata($retorno);
					//redirect('Capacitacao/Inscricao_teste/'.$dados['post']['course_id']);
					redirect('Capacitacao/Inscricao/'.$dados['post']['course_id']);
					*/
					$retorno['type']    = 'warning';
					$retorno['title']   = 'Você não é um farmaceutico vinculado ao CRF.';
					$retorno['message'] = 'Este curso é apenas para Farmacêuticos do CRFMG';
						
					echo json_encode($retorno);
					exit;
					
				}
		}

		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);

		$enrolid = $this->session->flashdata('course_id');//pegando o id do courso no AVA
		$enrolid2 = $dados['post']['course_id'];//pegando o id do courso no AVA

		if(empty($enrolid)){
			$enrolid = $enrolid2;//forçando pegar o códgo do curso no Ava
		}

		$retUser = $this->capacitacao->verificaUsuarioAva($enrolid, $dados['post']);

		
			/* Busca Link Whatsapp */
			/*
				$select 	= 'whatsapp';
				$courseid 	= $dados['post']['course_id'];
				$this->load->database();
				$this->load->model('capacifar_model', 'capacitacao', TRUE);
				$tabline = $this->capacitacao->listaCourseId($courseid, $select);
				
				foreach($tabline as $line){
					$whatsapp = $line->whatsapp;
				}
		
				//print_r($whatsapp);
			*/
		
		/*if(!empty($retUser)){

			
			$retorno['tipo'] = "warning";
			
			$retorno['msg'] = utf8_encode ("Voc&ecirc; j&aacute; est&aacute; inscrito no AVA! Acesse o Ava no link <a href='https://ava.crfmg.org.br/' target='_blank'>https://ava.crfmg.org.br/</a> para ter acesso ao curso.");
			$this->session->set_flashdata($retorno);
			if($dados['post']['menuid'] == '1'){
				redirect('Presencial');
			} else {
				redirect('Online');
			}
			
			
			$retorno['type']    = 'warning';
					$retorno['title']   = 'Você já está inscrito no AVA.';
					$retorno['message'] = 'Acesse o AVA no link abaixo para conferir o curso. <br> <a href="https://ava.crfmg.org.br" target="_blank">acesse o portal de cursos aqui</a> ';
						
					echo json_encode($retorno);
					exit;
		}*/

		//if(empty($enrolid)){
		//	$enrolid = $this->input->post('txtcourseid');
		//}

		if(empty($enrolid)){
			/*$retorno['tipo'] = "danger";
			$retorno['msg'] = utf8_encode ("error [420] N&atilde;o conseguimos encontrar o curso selecinado, Favor entrar em contato com o suporte t&eacute;cnico!");
			$this->session->set_flashdata($retorno);
			if($dados['post']['menuid'] == '1'){
				redirect('Presencial');
			} else {
				redirect('Online');
			}*/
			
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Erro';
			$retorno['message'] = 'Erro ao tentar inscrição no curso';
				
           	echo json_encode($retorno);
			exit;
		}



		$retFinal = $this->capacitacao->enrolUser($enrolid, $dados['post']);


			/*$retorno['tipo'] = "success";
			$retorno['msg'] = utf8_encode ("Voc&ecirc; foi inscrito com sucesso! Acesse o AVA no link abaixo para conferir o curso.");
			$retorno['link'] = $whatsapp;
			$this->session->set_flashdata($retorno);
			if($dados['post']['menuid'] == '1'){
				redirect('Presencial');
			} else {
				redirect('Online');
			}*/
			
			$retorno['type']    = 'success';
			$retorno['title']   = '✅ Tudo Certo!';
			$retorno['message'] = 'Você foi inscrito com sucesso! <br> Acesse o AVA no link abaixo para conferir o curso. <br> <a href="https://ava.crfmg.org.br" target="_blank">acesse o portal de cursos aqui</a> ';
				
           	echo json_encode($retorno);
			exit;


	}
			




	public function preController()
	{
	 //echo "boa tarde";
	 //$dados = array();

	  $dados = $this->input->post('cpf');

	 ///API BUSCA DADOS PELO CPF
	 $curl = curl_init();
	 curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_busca_cpf.php'  );
	 curl_setopt( $curl, CURLOPT_POST, true );
	 curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
	     'username' 	=> $dados,
	 ));
	 curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	 $response = json_decode( curl_exec( $curl ), true);
	 curl_close($curl);

	 echo json_encode($response);
	    exit;
	}

	public function PF_Existe(){

		///API Lucas *** VERIFICA SE É FARMACÊUTICO
			$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'http://api.crfmg.org.br/api/check/pf-existe' );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'inscricao' => $this->input->post('crfmg'),
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
				curl_setopt($curl, CURLOPT_TIMEOUT, 20);
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
				//var_dump($response);

		if ($this->responderConsultaAtitude($response, 'farmaceutico')) return;
		echo json_encode($response);
	    exit;
	}

	public function ConsultaPF(){
		$response = $this->consultarRegistroApi('pf');

		if ($this->responderConsultaAtitude($response, 'farmaceutico')) return;
		echo json_encode($response ?? $this->erroConsultaRegistro(), JSON_UNESCAPED_UNICODE);
	    exit;
	}

	public function ConsultaPJ(){
		$response = $this->consultarRegistroApi('pj');

		if ($this->responderConsultaAtitude($response, 'empresa')) return;
		echo json_encode($response ?? $this->erroConsultaRegistro(), JSON_UNESCAPED_UNICODE);
	    exit;
	}

    private function consultarRegistroApi($tipo)
    {
        $this->diagnosticoConsultaRegistro = array();
        $registro = $this->input->post('crfmg');
        if (!is_string($registro) || !preg_match('/\A[0-9]{1,50}\z/', trim($registro))) {
            return array('type' => 'danger', 'text' => 'Informe um registro válido.');
        }
        $parametro = $tipo === 'pf' ? 'InscricaoPFId' : 'InscricaoPJId';
        $url = 'https://v2api.crfmg.org.br/publico/' . $tipo . '/consultar-' . $tipo . '?' . http_build_query(array($parametro => trim($registro)));
        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_HTTPGET => true, CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10, CURLOPT_TIMEOUT => 20,
            CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_HTTPHEADER => array('Accept: application/json')
        ));
        $corpo = curl_exec($curl);
        $pacoteCa = APPPATH . 'certificates/cacert.pem';
        // Preserva a configuração do servidor; o pacote Mozilla é uma alternativa para PHP sem CA configurada.
        if (curl_errno($curl) === 60 && trim((string) ini_get('curl.cainfo')) === '' && is_readable($pacoteCa)) {
            curl_setopt($curl, CURLOPT_CAINFO, $pacoteCa);
            $corpo = curl_exec($curl);
        }
        $codigoCurl = curl_errno($curl);
        $erroCurl = curl_error($curl);
        $http = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $dados = is_string($corpo) ? json_decode($corpo, true) : null;
        $erroJson = is_string($corpo) ? json_last_error_msg() : 'Sem resposta da API';
        if ($codigoCurl !== 0 || $http < 200 || $http >= 300 || !is_array($dados)) {
            $this->diagnosticoConsultaRegistro = array('curl_codigo' => $codigoCurl, 'http_status' => $http, 'json_erro' => $erroJson);
            log_message('error', 'Consulta CRFMG ' . strtoupper($tipo) . ': ' . json_encode($this->diagnosticoConsultaRegistro) . '; cURL: ' . $erroCurl);
            return null;
        }
        return $dados;
    }

    private function erroConsultaRegistro()
    {
        return array('type' => 'danger', 'status' => false,
            'message' => 'Não foi possível consultar a base do CRF/MG. Tente novamente antes de continuar a inscrição.',
            'diagnostico' => $this->diagnosticoConsultaRegistro);
    }

    private function responderConsultaAtitude($resposta, $tipo)
    {
        if ($this->input->post('contexto') !== 'atitude_farmaceutica') return false;
        $this->session->unset_userdata('atitude_solicitante_verificado');
        $this->load->library('Atitude_solicitante');
        $registro = $this->input->post('crfmg');
        $dados = $this->atitude_solicitante->extrair($resposta, $tipo);
        $sucesso = is_string($registro) && preg_match('/\A[0-9]{1,50}\z/', trim($registro)) === 1 && $dados !== null;
        $http = $sucesso ? 200 : ($resposta === null ? 503 : 404);
        $retorno = array('type' => $sucesso ? 'success' : 'error', 'status' => $sucesso,
            'message' => $sucesso ? 'Cadastro localizado na base do CRF/MG.' : ($resposta === null ? 'Não foi possível consultar a base do CRF/MG. Tente novamente antes de continuar a inscrição.' : Atitude_solicitante::NAO_ENCONTRADO),
            'csrf_name' => $this->security->get_csrf_token_name(), 'csrf_hash' => $this->security->get_csrf_hash());
        if ($resposta === null && $this->diagnosticoConsultaRegistro) $retorno['diagnostico'] = $this->diagnosticoConsultaRegistro;
        if ($sucesso) {
            $dados['registro'] = trim($registro);
            $this->session->set_userdata('atitude_solicitante_verificado', $dados);
            $retorno[$tipo === 'empresa' ? 'RazaoSocial' : 'Nome'] = $dados['nome'];
            $retorno['Cidade'] = $dados['cidade'];
            $retorno['cidade_manual'] = $dados['cidade'] === '';
        }
        $this->output->set_status_header($http)->set_content_type('application/json', 'utf-8')->set_output(json_encode($retorno, JSON_UNESCAPED_UNICODE));
        return true;
    }
	
	public function RecuperarSenha(){
		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		//print_r($arrayDados);exit;	
		$this->load->view('fixo/cabecalho');
		$this->load->view('resetar_senha_ava');
		$this->load->view('fixo/rodape');
	}
	
	public function ResetarSenha(){
		
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		$retorno = [];
		$res = '';

		// Validar e-mail
		$dados = $this->input->post();

		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_busca_email_cpf.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'email' 	=> $dados['email'],
				'cpf' 		=> $dados['cpf'],
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
			
			
			/*$retorno['type']    = 'danger';
			$retorno['title']   = 'Falha .'.$response['id'];
			$retorno['message'] = 'Usuário do AVA não encontrado.';
			echo json_encode($retorno);
			exit;*/
			
			foreach($response as $value) {
				$res = $value['id'];
			}
			
			
		

		if(!$res){
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Falha ao encontrar usuário.';
			$retorno['message'] = 'Usuário não encontrado, verifique os dados informados.';
		
			echo json_encode($retorno);
			exit;
		} else {
			
			/* ALERAR A SENHA */
			$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_reset_pass.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'username' 	=> $dados['cpf'],
				'password' 		=> $dados['cpf'],
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
			
			
			$retorno['type']    = 'success';
			$retorno['title']   = 'Tudo certo.';
			$retorno['message'] = 'Senha alterada com sucesso! <br> entre com seu CPF nos campos de usuário e senha (Somente números) <br> Exemplo: <br> Identificação de usuário: CPF do inscrito Ex.: 01234567899 <br> Senha: CPF do inscrito Ex.: 01234567899 <br>';
		
			echo json_encode($retorno);
			exit;
		}

		
		
		
		
	}
}
