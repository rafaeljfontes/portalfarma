<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PesquisaCientifica extends MY_Controller
{
	public function index()
	{
		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		//$filtro  = $this->uri->segment('5');
		//echo $filtro;

		$arrayDados['tabelaCientifica'] = $this->capacifar_model->listaPesquisas();

		# print_r($arrayDados['tabelaCientifica']);	

		$this->carregarCabecalho($arrayDados);
		$this->load->view('pesquisa_cientifica', $arrayDados);
		$this->load->view('fixo/rodape');
	}
	
	public function formulario()
    {
		$arrayDados = array();
		
        $this->carregarCabecalho($arrayDados);
		$this->load->view('form_pesquisa_cientifica', $arrayDados);
		$this->load->view('fixo/rodape');
    }

    public function enviar()
    {
	
		$dados = $this->input->post();
		
		$dados['autores'] 		= $this->converter_para_lista($dados['autores']);

			// Diretório de upload
			$upload_path = FCPATH . 'uploads/pesquisas/';

			// Garante que a pasta exista
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0755, true);
			}

			// Config padrão
			$config = [
				'upload_path'   => $upload_path,
				'allowed_types' => 'pdf',
				'max_size'      => 5120, // 5MB (em KB)
				'encrypt_name'  => true  // evita conflito de nomes
			];

			$this->load->library('upload');

			// Campos de arquivo
			$campos = ['projeto', 'etica'];

			foreach ($campos as $campo) {

				if (!empty($_FILES[$campo]['name'])) {

					// Reaplica config para cada arquivo
					$this->upload->initialize($config);

					if (!$this->upload->do_upload($campo)) {

						// Erro de upload
						$erro = $this->upload->display_errors('', '');
						echo json_encode([
							'status' => false,
							'msg'    => "Erro no arquivo {$campo}: {$erro}"
						]);
						return;
					}

					// Upload OK
					$fileData = $this->upload->data();

					// Salva apenas o nome no array
					$dados[$campo] = $fileData['file_name'];
				}
			}

			// Inserção no banco
			$insert = $this->capacifar_model->insert(
				'tbl_capacifar_trabalhocientifico',
				$dados
			);
			
			// envia email
			//$this->enviar_email($nome, $email, $username, $senhaTemp, $curso, $evento);

			if ($insert) {
				echo json_encode([
					'status' => true,
					'msg'=>'Sua solicitação foi enviada com sucesso! <br> Aguarde a aprovação do setor resposável'
				]);
			} else {
				echo json_encode([
					'status' => false,
					'msg' => 'Erro ao salvar no banco'
				]);
			}
    }
	
	private function enviar_email($nome, $email, $usuario, $senha, $curso, $evento) {

        $this->email->from('noreply@crfmg.org.br', 'Portal Farma');
        $this->email->to($email);

        $this->email->subject('Acesso ao curso');

        $this->email->message("
            <style>

			body{
				margin:0;
				padding:0;
				background:#f2f2f2;
				font-family: Arial, Helvetica, sans-serif;
			}

			.container{
				width:800px;
				margin:auto;
				background:#ffffff;
				border:1px solid #dcdcdc;
				border-radius:8px;
			}

			.header{
				padding:20px;
				border-bottom:1px solid #e5e5e5;
			}

			.header-table{
				width:100%;
			}

			.logo-left{
				text-align:left;
				max-height: 40px !important;
			}

			.logo-right{
				text-align:right;
				max-height:30px !important;
			}

			.content{
				padding:40px 60px;
				text-align:center;
			}

			.titulo{
				font-size:22px;
				font-weight:bold;
				margin-bottom:15px;
			}

			.texto{
				font-size:14px;
				color:#333;
			}

			.codigo-box{
				display:inline-block;
				margin:30px 0;
				padding:20px 40px;
				font-size:32px;
				letter-spacing:6px;
				color:#1e6bd6;
				border:2px solid #1e6bd6;
				border-radius:10px;
				font-weight:bold;
			}

			.codigo-texto{
				font-size:14px;
				color:#1e6bd6;
			}
			
			
			.title-curse{
				color: #12455e;
				font-size:14px;
			}

			.importante{
				color:#d80000;
				font-size:13px;
				margin-top:10px;
			}

			.footer{
				margin-top:40px;
				padding:30px;
				background:#f7f7f7;
				text-align:center;
				font-size:13px;
				color:#555;
			}

			.footer strong{
				display:block;
				margin-bottom:8px;
			}

			</style>
			<div class='container'>

				<!-- HEADER -->
				<div class='header'>
					<table class='header-table'>
						<tr>
							<td class='logo-left'>
								<img src='https://www.crfmg.org.br/portalfarma/assets/img/logo/logo_portalfarma_60.png' alt='Portal Farma' style='max-height: 40px !important'>
							</td>

							<td class='logo-right'>
								<img src='https://www.crfmg.org.br/portalfarma/assets/img/logo/logo_crfmg_comprido_80.png' alt='Logo CRFMG' style='max-height: 40px !important'>
							</td>
						</tr>
					</table>
				</div>


				<!-- CONTEÚDO -->
				<div class='content'>

					<div class='titulo'>
						Olá, {$nome}
					</div>

					<div class='texto'>
						Sua inscrição foi realizada com sucesso no curso  <strong class='title-curse'>{$curso}</strong>
					</div>

					<div class='texto' style='margin-top:15px;'>
						Acesse o <a hfer='https://portalfarma.crfmg.org.br/moodle/'>portalfarma - Aulas</a> para visualizar o conteúdo dos cursos
						</div>
					
					<div class='importante'>
						<strong>Importante:</strong>
						<p><strong>Usuário:</strong> {$usuario}<br>
						<strong>Senha temporária:</strong> {$senha}</p>
					</div>

					<div class='texto' style='margin-top:20px;'>
						Atenciosamente,<br>
						<strong>CRFMG</strong>
					</div>

				</div>


				<!-- FOOTER -->
				<div class='footer'>

					<strong>Conselho Regional de Farmácia de Minas Gerais</strong>

					Rua Rodrigues Caldas, 493 &nbsp; CEP 30190-120 &nbsp; Belo Horizonte/MG<br><br>

					Telefone: (31) 3218-1026 |
					E-mail: capacifar@crfmg.org.br<br><br>

					Horário: segunda a sexta, das 08h às 17h

				</div>

			</div>
        ");

        $this->email->set_mailtype("html");
        return $this->email->send();
    }
	
	private function converter_para_lista($texto)
	{
		$linhas = preg_split('/\r\n|\r|\n/', trim($texto));

		$html = "<ul>";

		foreach ($linhas as $linha) {
			if (!empty(trim($linha))) {
				$html .= "<li>" . htmlspecialchars(trim($linha)) . "</li>";
			}
		}

		$html .= "</ul>";

		return $html;
	}
}
