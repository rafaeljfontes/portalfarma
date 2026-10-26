<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class SaudedaMulher  extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		require_once FCPATH .'vendor/autoload.php';
	}
	
	public function index()
	{
	//echo "aqui";exit;
		$this->load->view('fixo/cabecalho');
		$this->load->view('saudedamulher');
		$this->load->view('fixo/rodape');
	}
	
	public function Inscricao()
	{	
		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);
			
		$solicitacao = array();

		$solicitacao = $this->input->post();
		
		// Consulta os dados do participante duplicados?
		$query 	= "SELECT sm.cpf FROM saude_da_mulher_inscricao sm WHERE sm.id_evento = '".$solicitacao['id_evento']."' AND sm.cpf = '".$solicitacao['cpf']."';";
			
			//$retorno['message'] = $query;		echo json_encode($retorno);		exit;
			
			
		$res	= $this->capacitacao->query($query);

		if($res){
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Falha ao fazer inscrição.';
			$retorno['message'] = 'Usuário com CPF já cadastrado.';
		
			echo json_encode($retorno);
			exit;
		}
		
		//print_r($solicitacao);exit;
		
		if (empty($solicitacao['id_evento'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro";
			$response['message'] = "Selecione qual seminário você quer ir.";
			echo json_encode( $response ); exit;
		}

		if (empty($solicitacao['nome'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro";
			$response['message'] = "NOME é obrigatório";
			echo json_encode( $response ); exit;
		}

		if (empty($solicitacao['cpf'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro";
			$response['message'] = "CPF é obrigatório";
			echo json_encode( $response ); exit;
		}

		/*if( !validarCPF($cpf) ){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro";
			$response['message'] = "CPF inválido, insira o CPF correto.";
			echo json_encode( $response ); exit;
		}*/

		if (empty($solicitacao['email'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro";
			$response['message'] = "EMAIL é obrigatório";
			echo json_encode( $response ); exit;
		}

		if (empty($solicitacao['telefone'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro";
			$response['message'] = "TELEFONE é obrigatório";
			echo json_encode( $response ); exit;
		}

		if (empty($solicitacao['municipio'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro";
			$response['message'] = "MUNICIPIO é obrigatório";
			echo json_encode( $response ); exit;
		}
		
		if (empty($solicitacao['tipo_inscricao'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro".$solicitacao['tipo_inscricao'];
			$response['message'] = "Você irá participar Online ou Presencial";
			echo json_encode( $response ); exit;
		}
		
		/*if (empty($solicitacao['local_trabalho'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao realizar cadastro";
			$response['message'] = "Local de trabalho é Obrigatório";
			echo json_encode( $response ); exit;
		}*/
		
			$nome 			= $solicitacao['nome'];
			$tipo_inscricao = $solicitacao['tipo_inscricao'];
			
			$insert = $this->capacitacao->InsertSaudedaMulher($solicitacao);
			
			if(!empty($insert)){
			
				$retorno['type']    = 'success';
				$retorno['title']   = 'Tudo certo.';
				$retorno['message'] = 'Sua inscrição foi feita com sucesso!';
				echo json_encode($retorno);
				exit;
		/*	
				if($tipo_inscricao == 'ONLINE'){
					$local  = "link que iremos te enviar no email";
				} else {
					$local  = "<b>Local:</b> R. Rodrigues Caldas, 493 - Santo Agostinho, Belo Horizonte - MG";
				}
			
				// Enviar email

				$this->load->library('email');

				$texto_email = <<<EMAIL
				Prezado(a) $nome,
				<br>
				Agradecemos por sua inscrição no Saúde da Mulher & Gestante.
				<br>
				Sua inscrição foi confirmada de forma <b>$tipo_inscricao</b> no evento.<br><br>O evento ocorrerá no dia <b>17 de Julho de 2025 às 19hrs</b>.
                <br><br>
				<b>Local:</b> R. Rodrigues Caldas, 493 - Santo Agostinho, Belo Horizonte - MG
				<br><br>
				Em caso de dúvidas ou mais informações, nos envie uma mensagem para capacifar@crfmg.org.br ou no Whatsapp (31) 98869-0218
				<br><br>
				<a href='https://www.crfmg.org.br/portalfarma/SaudedaMulher'> veja aqui a programacao</a>
				<br><br>
				Atenciosamente,
				<br>
				CRF/MG
		EMAIL;

				$mail['body'] = $texto_email;
				$mail['user'] = $this->input->post('nome');
				$mail['text_align'] = "left";
				$bcc = $this->input->post('chk_email_cc') != '' ? $this->input->post('destinatario_cc') : null; 
				
				// enviar email
				$sendMail = $this->email->mySendMail($this->input->post('email'), "Recebimento de Inscrição - Saúde da Mulher & Gestante - CRF/MG", $mail, 'default', null, null, null);
				
				$retorno['type']    = 'success';
				$retorno['title']   = 'Tudo certo.';
				$retorno['message'] = 'Sua inscrição foi feita com sucesso!';
				echo json_encode($retorno);
				exit;
			
			} else {
				
				$retorno['type']    = 'danger';
				$retorno['title']   = 'Algo deu errado.';
				$retorno['message'] = 'Favor verificar seus dados ou entre em contato com suporte.';
				echo json_encode($retorno);
				exit;
		*/		
			}
			
		
	}
	
	public function ConfirmarPresenca()
	{
	
		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);
			
		$solicitacao = array();

		$solicitacao = $this->input->post();
		
		if (empty($solicitacao['cpf'])){
			$response['type']   = "danger";
			$response['title']  = "Falha ao buscar cadastro";
			$response['message'] = "CPF é obrigatório";
			echo json_encode( $response ); exit;
		}
		
		
		// Consulta os dados do participante duplicados?
		$query 	= "SELECT sm.cpf FROM saude_da_mulher_inscricao sm WHERE sm.id_evento = '".$solicitacao['id_evento']."' AND sm.cpf = '".$solicitacao['cpf']."';";
		
		$res	= $this->capacitacao->query($query);

		if(!$res){
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Falha ao buscar inscrição.';
			$retorno['message'] = 'Usuário sem CPF cadastrado.';
		
			echo json_encode($retorno);
			exit;
		}
		
		$update = $this->capacitacao->PresencaSaudedaMulher($solicitacao);
		
		if(!empty($update)){
		
			$retorno['type']    = 'success';
			$retorno['title']   = 'Tudo certo.';
			$retorno['message'] = '✅ Presença confirmada!';
			echo json_encode($retorno);
			exit;
		}
	
	}
	
	
	public function gerarCertificado(){
		
		//INICIALIZAÇÕES...
		$retorno = [];
		
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		// Validar CPF
		$cpf = $this->input->post('cpf');
		
		
			
		//if (!$cpf || filter_var($cpf, FILTER_VALIDATE_EMAIL) === false) {
		if (!$cpf){
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Falha ao gerar certificado.';
			$retorno['message'] = 'CPF inválido, verifique os dados informados.';
		
			echo json_encode($retorno);
			exit;
		}

		
		
		// Consulta os dados do participante
		$query 	= "SELECT nome FROM saude_da_mulher_inscricao WHERE cpf = '$cpf' AND presenca = 1 ;";
		$res	= $this->capacifar_model->query($query);

		
			
		if(!$res){
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Falha ao gerar certificado.';
			$retorno['message'] = 'Usuário não encontrado, verifique os dados informados.';
		
			echo json_encode($retorno);
			exit;
		}

		foreach($res as $r){
			$nome 		= $r->nome;
		}
		
			
			
		$hoje = date('Y-m-d');
		$hojehora = date('Y-m-d H:i:s');
		$data_extenso 	= $this->capacifar_model->data_extenso($hoje);
		//$data_atual 	= $this->capacifar_model->data_extenso($hoje);
				
				
			
				
		try {
			// Define o CSS do certificado
			$pdf_css = <<<PDF_CSS
				<style type="text/css">
					#nome_participante {
						position: absolute;
						top: 210px;
						left: 380px;
						font-size: 34px;
						text-transform: uppercase;
						color: #71a6a2;
						font-weight: bold;
					}
					#evento {
						position: absolute;
						top: 360px;
						left: 50px;
						font-size: 20px;
						color: #575859;
						line-height: 24px;
					}
					#carga_horaria {
						position: absolute;
						top: 450px;
						left: 50px;
						font-size: 16px;
						color: #d85284;
					}
					#data {
						position: absolute;
						top: 500px;
						left: 50px;
						font-size: 16px;
						color: #575859;
					}
					
					.fischum {
						font-weight: bold;
						text-transform: uppercase;
						color: #d85284;
					}
				</style>
			PDF_CSS;
		
			// Formata o nome do participante em maiúsculas e quebra de linha a cada 30 caracteres
			$nome_participante = wordwrap(mb_strtoupper($nome), 30, "<br>");
		
			// Gera a URL de validação com CPF codificado
			$url_validacao = "https://crfmg.org.br/portalfarma/SaudedaMulher/validarCertificado/=" . base64_encode($cpf);
		
			// Cria o QR Code como imagem base64
			$result = Builder::create()
				->writer(new PngWriter())
				->data($url_validacao)
				->size(250)
				->margin(10)
				->build();
		
			$qrCodeBase64 = base64_encode($result->getString());

			$qrCodeImage = '
				<div style="position: absolute; right: 40px; bottom: 120px; z-index: 0;">
					<img src="data:image/png;base64,' . $qrCodeBase64 . '" width="80">
				</div>'; 
				
				
			// Monta o HTML do certificado
			$html = <<<HTML_PDF
				$pdf_css
				<page orientation="L" backimg="assets/certificado/Certificado-saude-da-mulher.png">
					<div id="nome_participante">$nome_participante</div>
					
					$qrCodeImage
				</page>
			HTML_PDF;
		
			// Gera e salva o PDF no servidor
			$html2pdf = new Html2Pdf();
			$html2pdf->writeHTML($html);
			ob_end_clean(); 
		
			$path = FCPATH."certificados/" . md5($cpf) . ".pdf";
			$html2pdf->output($path, 'F');

			$retorno['type']    = 'success';
			$retorno['title']   = 'Tudo certo.';
			$retorno['message'] = '✅ Certificado gerado com sucesso!';
			$retorno['url'] = base_url('certificados/' . md5($cpf) . '.pdf');
		
			echo json_encode($retorno);
			exit;
		
		} catch (Exception $e) {
			echo json_encode([
				'type' => 'danger',
				'message' => 'Erro ao gerar o PDF: ' . $e->getMessage()
			]);
		}
	
	}
	
	public function validarCertificado(){
		
		$arrayDados = array();
		
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		$cpf  = base64_decode($this->uri->segment('3'));
		//$id = 1;
		//print_r($id);exit;
		$query 	= "SELECT nome FROM saude_da_mulher_inscricao WHERE cpf = '$cpf' LIMIT 1 ;";
		$res		= $this->capacifar_model->query($query);
		
		
		if(!$res){
			$arrayDados['type']    = 'danger';
			$arrayDados['title']   = 'Falha ao gerar certificado.';
			$arrayDados['message'] = 'Usuário não encontrado, verifique os dados informados.';

		} else {
			
			foreach($res as $r){
				$nome 		= $r->nome;
			}
			
			$arrayDados['type']    = 'success';
			$arrayDados['title']   = 'Tudo certo.';
			$arrayDados['message'] = 'O <b>'.$nome.'</b> participou do evento <br><b>Saúde da Mulher & Gestante </b> <br>realizado em <b>Belo Horizonte</b>, <br> em 17 de Julho de 2025';
		}

		
		
		$this->load->view('fixo/cabecalho');
		$this->load->view('validar_certificado',$arrayDados);
		$this->load->view('fixo/rodape');
	}
	
	public function validarCPF($cpf) {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Elimina CPFs inválidos conhecidos
        if (preg_match('/^(.)\1*$/', $cpf)) {
            return false;
        }

        // Calcula e valida os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += $cpf[$i] * (($t + 1) - $i);
            }
            $digito = ($soma * 10) % 11;
            if ($digito == 10) {
                $digito = 0;
            }
            if ($cpf[$t] != $digito) {
                return false;
            }
        }

        return true;
    }
	
	
}

