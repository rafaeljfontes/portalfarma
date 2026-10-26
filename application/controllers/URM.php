<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class URM  extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		require_once FCPATH . 'vendor/autoload.php';		
		$dados = array();
        $this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
	}

	public function index()
	{
		// 1. Busca os dados do seminário ativo
		$urm_resultado = $this->capacifar_model->listaCursosPortalFarma('tpf.tipo_evento = 3 AND tpf.status = 1');
		
		
		// Verifica se retornou algum registro
		if (!empty($urm_resultado)) {
			// 2. Extrai o ID do primeiro registro (índice 0)
			$id = $urm_resultado[0]->courseid; 
			
			// 3. Define as outras querys usando o $id extraído
			$qryProg = "SELECT tpp.data_hora_inicial, tpp.hora_final, tpp.descricao, tpp.palestra  
						FROM web_site.tbl_portalfarma_programacao AS tpp  
						WHERE tpp.status = 1 AND tpp.courseid = '" . $id . "'
						ORDER BY tpp.data_hora_inicial ASC;"; // Ordena do horário mais cedo para o mais tarde

			$queryPalestrantes = "SELECT 
									p.id_palestrante,
									p.nome,
									p.curriculo,
									p.foto,
									p.link
								FROM tbl_portalfarma_palestrantes p
								INNER JOIN tbl_portalfarma_palestrantes_curso pc
									ON pc.id_palestrante = p.id_palestrante
								WHERE pc.courseid = '" . $id ."' 
								ORDER BY p.nome;";

			// 4. Alimenta o array final
			$arrayDados['urm']    = $urm_resultado;
			$arrayDados['programacao']  = $this->capacifar_model->query($qryProg);
			$arrayDados['tblpalestrantes'] = $this->capacifar_model->query($queryPalestrantes);
			
			
		} else {
			// Caso não encontre nenhum seminário ativo
			$arrayDados['urm']    			= [];
			$arrayDados['programacao']  	= [];
			$arrayDados['tblpalestrantes'] 	= [];
		}
		
		$campoCidade = $this->db->field_exists('cidade', 'tbl_portalfarma') ? 'cidade' : 'local';
		$arrayDados['locais_urm'] = $this->db
			->select('l.*, pf.data_inicio AS data_evento, pf.'.$campoCidade.' AS cidade_evento')
			->join('tbl_portalfarma pf', 'pf.courseid COLLATE utf8mb4_unicode_ci = l.courseid COLLATE utf8mb4_unicode_ci AND pf.tipo_evento = 3', 'left', false)
			->order_by('pf.data_inicio', 'DESC')
			->order_by('l.id', 'DESC')
			->get('tbl_portalfarma_urm_local l')
			->result();

		foreach ($arrayDados['locais_urm'] as $local) {
			$local->imagem_arquivo = $this->localizar_imagem_local($local->imagem);
		}

		$this->carregarCabecalho($arrayDados);
		$this->load->view('urm');
		$this->load->view('fixo/rodape');
	}

	private function localizar_imagem_local($nomeArquivo)
	{
		$nomeArquivo = basename((string) $nomeArquivo);
		$pasta = FCPATH . 'uploads/urm_locais/';

		if ($nomeArquivo === '' || !is_dir($pasta) || is_file($pasta . $nomeArquivo)) {
			return $nomeArquivo;
		}

		$arquivos = glob($pasta . '*' . $nomeArquivo);
		return empty($arquivos) ? $nomeArquivo : basename($arquivos[0]);
	}

	public function Inscricao()
	{
		$arrayDados = [];
		
		$arrayDados['id']  = $this->uri->segment('3');
		
		$query 	= "SELECT pf.* FROM tbl_portalfarma pf WHERE pf.status = 1 AND pf.courseid = '".$arrayDados['id']."'";

		$arrayDados['urm'] = $this->capacifar_model->query($query);

		$this->carregarCabecalho($arrayDados);
		$this->load->view('urm_inscricao');
		$this->load->view('fixo/rodape');
	}

	public function verificar_cadastro_moodle() {
		$cpf = preg_replace('/[^0-9]/', '', (string) $this->input->post('cpf'));
		if (strlen($cpf) !== 11) {
			echo json_encode(['status' => 'error', 'message' => 'CPF inválido.']);
			return;
		}
		$courseid = $this->input->post('courseid');
		$evento = $this->evento_inscricao($courseid);
		if (!$evento) {
			echo json_encode(['status' => 'error', 'message' => 'Evento URM indisponível.']);
			return;
		}
		if (isset($evento->exigir_curso54) && (int) $evento->exigir_curso54 === 0) {
			echo json_encode(['status' => 'ja_inscrito']);
			return;
		}

		// 1. Primeiro verifica se o usuário EXISTE no Moodle
		$usuario_moodle = $this->Moodle_api->get_user_by_cpf($cpf);
		
		//print_r($usuario_moodle[0]->id);exit;

		//if (!$usuario_moodle[0]->id) {
		if (!empty($usuario_moodle) && isset($usuario_moodle[0]->id)) {
			echo json_encode(['status' => 'ja_inscrito']);
			return;
		} else {
			echo json_encode(['status' => 'nao_cadastrado']);
			return;
		}
	}
	
	private function evento_inscricao($courseid) {
		return $this->db->where('courseid', $courseid)->where('tipo_evento', 3)
			->where('status', 1)->get('tbl_portalfarma')->row();
	}

	public function processar_inscricao() {
		// 1. Recebe os dados do POST
		$dados = $this->input->post();

		// 2. Validação básica (Campos obrigatórios)
		if (empty($dados['cpf']) || empty($dados['courseid']) || empty($dados['nome'])) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Preencha todos os campos obrigatórios.'
			]);
			return;
		}

		// Limpa o CPF para manter apenas números no banco (opcional, mas recomendado)
		$cpf_limpo = preg_replace('/[^0-9]/', '', $dados['cpf']);
		$evento = $this->evento_inscricao($dados['courseid']);
		if (!$evento || strlen($cpf_limpo) !== 11) {
			echo json_encode(['status' => 'error', 'message' => 'Evento indisponível ou CPF inválido.']);
			return;
		}
		if ((!isset($evento->exigir_curso54) || (int) $evento->exigir_curso54 === 1)
			&& !$this->Moodle_api->get_user_by_cpf($cpf_limpo)) {
			echo json_encode(['status' => 'error', 'message' => 'Você precisa estar cadastrado no Curso Preparatório (curso 54) para se inscrever neste URM.']);
			return;
		}

		// 3. Verifica se já existe inscrição para este CPF neste curso específico
		$this->db->where('cpf', $cpf_limpo); // ou $cpf_limpo
		$this->db->where('urm_evento', $dados['courseid']);
		$existe = $this->db->get('urm_inscricao')->num_rows();

		if ($existe > 0) {
			echo json_encode([
				'status'  => 'warning',
				'message' => 'Este CPF já possui uma inscrição realizada para este seminário.'
			]);
			return;
		}

		// 4. Prepara os dados para inserção
		$data_insert = [
			
			'nome'              => mb_strtoupper($dados['nome']),
			'cpf'               => $cpf_limpo,
			'email'             => strtolower($dados['email']),
			'telefone'          => $dados['telefone'],
			'instituicao'       => mb_strtoupper($dados['instituicao']),
			'urm_evento'	    => $dados['courseid'],
			'data_inscricao'    => date('Y-m-d H:i:s'),
		];

		// 5. Insere no banco
		if ($this->db->insert('urm_inscricao', $data_insert)) {
    
			// Tenta enviar o e-mail, mas não trava o processo se falhar
			$this->enviar_email($dados['nome'], $dados['email'], $dados['titulo']);

			echo json_encode([
				'status'  => 'success',
				//'message' => 'Inscrição realizada com sucesso! Um e-mail de confirmação foi enviado.'
				'message' => 'Inscrição realizada com sucesso!'
			]);
		} else {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Erro interno ao salvar inscrição. Tente novamente mais tarde.'
			]);
		}
	}
	
	private function enviar_email($nome, $email, $tema) {

        $this->email->from('noreply@crfmg.org.br', 'Portal Farma');
        $this->email->to($email);

        $this->email->subject('Inscrição do Seminário em Saúde');

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
						Sua inscrição foi realizada com sucesso no Uso Racional de Medicamentos no:  <strong class='title-curse'>{$tema}</strong>
					</div>

					<div class='texto' style='margin-top:15px;'>
						Acesse o <a hfer='https://portalfarma.crfmg.org.br/moodle/'>portalfarma - Aulas</a> para visualizar o conteúdo dos cursos
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

	public function ConfirmarPresenca()
	{

		$this->load->database();
		$this->load->model('capacifar_model', 'capacitacao', TRUE);

		$solicitacao = array();

		$solicitacao = $this->input->post();

		if (empty($solicitacao['cpf'])) {
			$response['type']   = "danger";
			$response['title']  = "Falha ao buscar cadastro";
			$response['message'] = "CPF é obrigatório";
			echo json_encode($response);
			exit;
		}


		// Consulta os dados do participante duplicados?
		$query 	= "SELECT cpf FROM urm_inscricao  WHERE urm_evento = '" . $solicitacao['id_evento'] . "' AND cpf = '" . $solicitacao['cpf'] . "';";

		$res	= $this->capacitacao->query($query);

		if (!$res) {
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Falha ao buscar inscrição.';
			$retorno['message'] = 'Usuário sem CPF cadastrado.';

			echo json_encode($retorno);
			exit;
		}

		$update = $this->capacitacao->PresencaURM($solicitacao);

		if (!empty($update)) {

			$retorno['type']    = 'success';
			$retorno['title']   = 'Tudo certo.';
			$retorno['message'] = '✅ Presença confirmada!';
			echo json_encode($retorno);
			exit;
		} else {
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Falhou!';
			$retorno['message'] = '❌ Algo deu Errado!';
			echo json_encode($retorno);
			exit;
		}
	}

	public function gerarCertificado_old()
	{

		$retorno = [];

		// Validar e-mail
		$dados = $this->input->post('email');

		$contString = strlen($dados);

		if ($contString > 11) {
			$email = $dados;

			if (!$email || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {

				$retorno['type']    = 'danger';
				$retorno['title']   = 'Falha ao gerar certificado.';
				$retorno['message'] = 'E-mail inválido, verifique os dados informados.';

				echo json_encode($retorno);
				exit;
			}

			$where = "spi.email = '$email'";
		} else {

			$cpf = preg_replace('/[^0-9]/', '', $dados);

			$where = "spi.cpf = '$cpf'";
		}



		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		// Consulta os dados do participante
		$query 	= "SELECT spi.id, spi.nome, spi.email, spi.urm_evento, spi.data FROM urm_inscricao spi WHERE $where AND spi.presenca = 1 ;";
		$res	= $this->capacifar_model->query($query);

		if (!$res) {
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Usuário não encontrado';
			$retorno['message'] = 'Verifique os dados informados, Caso contrário entre em contato com o Capacifar';

			echo json_encode($retorno);
			exit;
		}


		$pdf_css = <<<PDF_CSS
					<style type="text/css">
						#nome_participante {
							position: absolute;
							top: 320px;
							left: 40px;
							font-size: 34px;
							text-transform: uppercase;
							color: #e61c72;
							font-weight: bold;
						}
						#evento {
							position: absolute;
							top: 400px;
							left: 40px;
							font-size: 18px;
							color: #2d6ca2;
							line-height: 24px;
						}
						#carga_horaria {
							position: absolute;
							top: 470px;
							left: 40px;
							font-size: 16px;
							color: #e61c72;
						}
						#data {
							position: absolute;
							top: 500px;
							left: 40px;
							font-size: 16px;
							color: #e61c72;
						}
						#qrCodeImage {
							position: absolute;
							top: 600px;
							left: 1080px;
						}
					</style>
				PDF_CSS;

		$html = " $pdf_css ";

		foreach ($res as $r) {
			$id 			= $r->id;
			$nome 			= $r->nome;
			$evento 		= $r->urm_evento;
			$dtevento 		= $r->data;


			$hoje = date('Y-m-d');
			$data_extenso 	= $this->capacifar_model->data_extenso($dtevento);
			$data_atual 	= $this->capacifar_model->data_extenso($hoje);


			// Formata o nome do participante em maiúsculas e quebra de linha a cada 30 caracteres
			$nome_participante = wordwrap(mb_strtoupper($nome), 30, "<br>");


			switch ($evento) {
				case 'Divinopolis':
					$titulo_evento = "USO RACIONAL DE MEDICAMENTOS";
					$local = "Praça dos Ferroviários, Divinópolis";
					break;
				case 'Uberlândia':
					$titulo_evento = "USO RACIONAL DE MEDICAMENTOS";
					$local = "Parque do Sabiá, Uberlândia";
					break;
				case 'Belo Horizonte':
					$titulo_evento = "USO RACIONAL DE MEDICAMENTOS";
					$local = "Rodoviária, Belo Horizonte";
					break;
				case 'Juiz de Fora':
					$titulo_evento = "USO RACIONAL DE MEDICAMENTOS";
					$local = "Parque Halfeld, Juiz de Fora";
					break;
				case 'Montes Claros':
					$titulo_evento = "USO RACIONAL DE MEDICAMENTOS";
					$local = "Praça Doutor Carlos Versiani , Montes Claros";
					break;
				case 'Ipatinga':
					$titulo_evento = "USO RACIONAL DE MEDICAMENTOS";
					$local = " , Ipatinga";
					break;
				case 'Pouso Alegre':
					$titulo_evento = "USO RACIONAL DE MEDICAMENTOS";
					$local = " , Pouso Alegre";
					break;
			}

			// Gera a URL de validação com CPF codificado
			$url_validacao = "https://crfmg.org.br/portalfarma/URM/validarCertificado/=" . base64_encode($id);

			// Cria o QR Code como imagem base64
			$result = Builder::create()
				->writer(new PngWriter())
				->data($url_validacao)
				->size(250)
				->margin(10)
				->build();

			$qrCodeBase64 = base64_encode($result->getString());

			$qrCodeImage = '
					<div style="position: absolute; right: 40px; bottom: 0px; z-index: 0;">
						<img src="data:image/png;base64,' . $qrCodeBase64 . '" width="80">
					</div>';



			if ($dtevento == '2025-04-25') {
				// Monta o HTML do certificado
				$html .= <<<HTML_PDF
						<page orientation="L" backimg="assets/certificado/certificado-urm-2025-vazio.png">
							<div id="nome_participante">$nome_participante</div>
							<div id="evento">participou do 1º Simpósio de Uso Seguro de Medicamentos, na Missão Sal da Terra, <br> realizado em $evento, em $data_extenso</div>
							<div id="carga_horaria">Carga horaria: 6 horas</div>
							
							<div id="data">Local: Missão Sal da Terra, $evento</div>
							
							<div id="qrCodeImage">$qrCodeImage</div>
						</page>
					HTML_PDF;
			} else if ($dtevento == '2025-04-26') {
				// Monta o HTML do certificado
				$html .= <<<HTML_PDF
						<page orientation="L" backimg="assets/certificado/certificado-urm-2025-vazio.png">
							<div id="nome_participante">$nome_participante</div>
							<div id="evento">como voluntário no atendimento à população durante a campanha do Uso Racional de Medicamentos, <br>realizada  em $evento, em $data_extenso</div>
							<div id="carga_horaria">Carga horaria: 6 horas</div>
							
							<div id="data">Local: $local</div>
							
							<div id="qrCodeImage">$qrCodeImage</div>
						</page>
					HTML_PDF;
			} else {
				// Monta o HTML do certificado
				$html .= <<<HTML_PDF
						<page orientation="L" backimg="assets/certificado/certificado-urm-2025-vazio.png">
							<div id="nome_participante">$nome_participante</div>
							<div id="evento">como voluntário no atendimento à população durante a campanha do Uso Racional de Medicamentos, <br>realizada  em $evento, em $data_extenso</div>
							<div id="carga_horaria">Carga horaria: 6 horas</div>
							
							<div id="data">Local: $local</div>
							
							<div id="qrCodeImage">$qrCodeImage</div>
						</page>
					HTML_PDF;
			}


			// Gera e salva o PDF no servidor
			$html2pdf = new Html2Pdf();
			$html2pdf->writeHTML($html);
		}
		ob_end_clean();

		$path = FCPATH . "certificados/" . md5($id) . ".pdf";
		$html2pdf->output($path, 'F');

		$retorno['type']    = 'success';
		$retorno['title']   = 'Tudo certo.';
		$retorno['message'] = '✅ Certificado gerado com sucesso!';
		$retorno['url'] = base_url('certificados/' . md5($id) . '.pdf');

		echo json_encode($retorno);
		exit;
	}

	public function validarCertificado()
	{

		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = base64_decode($this->uri->segment('3'));
		//$id = 1;
		//print_r($id);exit;
		$query 	= "SELECT spi.id, spi.nome, spi.urm_evento, spi.email, spi.urm_evento, spi.data FROM urm_inscricao spi WHERE spi.id = '$id' LIMIT 1 ;";
		$res		= $this->capacifar_model->query($query);


		if (!$res) {
			$arrayDados['type']    = 'danger';
			$arrayDados['title']   = 'Falha ao gerar certificado.';
			$arrayDados['message'] = 'Usuário não encontrado, verifique os dados informados.';
		} else {

			foreach ($res as $r) {
				$id 		= $r->id;
				$nome 		= $r->nome;
				$evento 	= $r->urm_evento;
				$dtevento 	= $r->data;
				$saldaterra = $r->data == '2025-04-25' ? ", Missão Sal da Terra" : "";
			}

			$data_extenso 	= $this->capacifar_model->data_extenso($dtevento);

			$arrayDados['type']    = 'success';
			$arrayDados['title']   = 'Tudo certo.';
			$arrayDados['message'] = 'O <b>' . $nome . '</b> participou do <b>USO RACIONAL DE MEDICAMENTOS</b> ' . $saldaterra . ' <br>realizado em <b>' . $evento . '</b>, <br> em ' . $data_extenso . '';
		}

		$this->carregarCabecalho();
		$this->load->view('validar_certificado', $arrayDados);
		$this->load->view('fixo/rodape');
	}
	
	/**/
	
	public function buscarInscricoes()
	{
		$cpf = preg_replace('/[^0-9]/', '', (string) $this->input->post('cpf'));

		if (strlen($cpf) !== 11) {
			$this->_json_response([]);
		}

		$sql = "
			SELECT 
				u.id as inscricao_id,
				pf.titulo as evento_nome,
				u.instituicao,
				u.presenca,
				pf.courseid,
				pf.presenca_liberada,
				DATE_FORMAT(pf.data_inicio, '%d/%m/%Y') as data_evento_formatada,
				DATE_FORMAT(u.data_inscricao, '%d/%m/%Y') as data_inscricao_formatada,
				pf.data_inicio as data_evento			
			FROM urm_inscricao u
			JOIN tbl_portalfarma pf ON u.urm_evento = pf.courseid
			WHERE REPLACE(
				REPLACE(
					REPLACE(
						REPLACE(TRIM(u.cpf), '.', ''),
					'-', ''),
				'/', ''),
			' ', '') = ?
			ORDER BY pf.data_inicio DESC, u.id DESC
		";

		$resultados = $this->db->query($sql, [$cpf])->result();

		// Define o cabeçalho como JSON para o navegador entender a resposta
		header('Content-Type: application/json');

		// Converte os dados e imprime
		echo json_encode($resultados);
		exit;
	}

	public function gerarCertificado($id_inscricao) {
		// 1. Busca os dados do participante e do evento
		$dados = $this->db->select('u.*, pf.titulo, pf.data_inicio, pf.local, pf.courseid')
						  ->from('urm_inscricao u')
						  ->join('tbl_portalfarma pf', 'u.urm_evento = pf.courseid')
						  ->where('u.id', $id_inscricao)
						  ->get()
						  ->row();

		// Validação de segurança: Só gera se tiver presença confirmada
		if (!$dados || $dados->presenca != 1) {
			die("Certificado não disponível ou presença não confirmada.");
		}

		// 2. Preparação das variáveis para o Template
		$nome 				= mb_convert_case(trim($dados->nome), MB_CASE_UPPER, 'UTF-8');
		$nome_participante 	= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
		$titulo 			= htmlspecialchars($dados->titulo, ENT_QUOTES, 'UTF-8');
		$local_evento 		= trim((string) $dados->local);
		$local_evento_html 	= htmlspecialchars($local_evento ?: 'Local não informado', ENT_QUOTES, 'UTF-8');
		$cidade_evento 		= $local_evento;
		
		if (preg_match('/\bBelo\s+Horizonte\b/ui', $local_evento)) {
			$cidade_evento = 'Belo Horizonte';
		} else {
			$posicao_de = mb_stripos($local_evento, ' de ', 0, 'UTF-8');
			if ($posicao_de !== false) {
				$cidade_evento = trim(mb_substr($local_evento, $posicao_de + 4, null, 'UTF-8'));
			}

			$posicao_endereco = mb_strpos($cidade_evento, ' - ', 0, 'UTF-8');
			if ($posicao_endereco !== false) {
				$cidade_evento = trim(mb_substr($cidade_evento, 0, $posicao_endereco, 'UTF-8'));
			}
		}

		$cidade_evento_html = htmlspecialchars($cidade_evento ?: 'Minas Gerais', ENT_QUOTES, 'UTF-8');

		$meses = [
			1 => 'janeiro', 2 => 'fevereiro', 3 => 'março', 4 => 'abril',
			5 => 'maio', 6 => 'junho', 7 => 'julho', 8 => 'agosto',
			9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro'
		];
		$data_evento = strtotime($dados->data_inicio);
		$dia_evento = (int) date('d', $data_evento);
		$mes_evento = $meses[(int) date('n', $data_evento)];
		$ano_evento = date('Y', $data_evento);
		$data_extenso = $dia_evento.' de '.$mes_evento.' de '.$ano_evento;
		$mes_ano_evento = $mes_evento.' de '.$ano_evento;
		$fonte_nome = mb_strlen($nome, 'UTF-8') > 45 ? 27 : 32;

		$token = base64_encode($dados->id."-".$dados->courseid);
		
		// 3. Lógica do QR Code (Endroid QR Code)
		$url_validacao = base_url("validar-certificado/" . $token);
		
		$url_validacao_qr = htmlspecialchars($url_validacao, ENT_QUOTES, 'UTF-8');
		$qrCodeImage = '
				<div style="position: absolute; right: 75px; bottom: 55px; z-index: 0;">
					<qrcode value="' . $url_validacao_qr . '" ec="H" style="width: 70px; background-color: white; color: black; border: none;"></qrcode>
				</div>';

		// 4. CSS e HTML do PDF
		$pdf_css = "
		<style type='text/css'>
			#nome_participante {
				position: absolute; top: 360px; left: 100px; width: 920px;
				color: #e3251e; font-size: {$fonte_nome}px; font-weight: bold; text-align: center;
			}
			#descricao_evento {
				position: absolute; top: 438px; left: 115px; width: 890px;
				color: #00599c; font-size: 20px; line-height: 1.35; text-align: center;
			}
			#dados_evento {
				position: absolute; top: 525px; left: 125px; width: 870px;
				color: #00599c; font-size: 15px; text-align: center;
			}
			#data_evento {
				position: absolute; top: 558px; left: 125px; width: 870px;
				color: #00599c; font-size: 15px; text-align: center;
			}
			.destaque { font-weight: bold; }
		</style>";

		// 1. Caminho para exibição no HTML/Navegador (URL)
			$certificado_url = base_url('assets/certificado/certificado-URM-2026-branco.png');

		// 2. Caminho para o servidor processar o arquivo (Físico)
			$img_path_fisico = FCPATH . 'assets/certificado/certificado-URM-2026-branco.png';

			$html = "
			<page orientation='L' backimg='{$img_path_fisico}'>
				{$pdf_css}
				<div id='nome_participante'>{$nome_participante}</div>
				<div id='descricao_evento'>
					como voluntário durante a campanha pelo <span class='destaque'> {$titulo} </span>,<br>
					realizada em {$cidade_evento_html}, em {$mes_ano_evento}.
				</div>
				<div id='dados_evento'>
					<span class='destaque'>Carga horária:</span> 5 horas &nbsp;|&nbsp;
					<span class='destaque'>Local:</span> {$local_evento_html}
				</div>
				<div id='data_evento'>{$cidade_evento_html}, {$data_extenso}.</div>
				$qrCodeImage
			</page>";

		// 5. Inicialização e Saída do Html2Pdf
		try {
			$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'pt');
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($html);
			$html2pdf->output('Certificado_'.$dados->id.'.pdf');
		} catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
			die($e->getMessage());
		}
	}
	
	public function setPresenca() {
		$id = $this->input->post('id');
		
		// 1. Busca os dados do evento antes de atualizar
		$inscricao = $this->db->select('u.id, u.presenca, pf.presenca_liberada')
							  ->from('urm_inscricao u')
							  ->join('tbl_portalfarma pf', 'u.urm_evento = pf.courseid')
							  ->where('u.id', $id)
							  ->get()
							  ->row();

		if (!$inscricao) {
			$this->_json_response(['status' => 'error', 'message' => 'Inscrição não encontrada.'], 404);
		}

		if ((int) $inscricao->presenca_liberada !== 1) {
			$this->_json_response([
				'status' => 'error',
				'message' => 'A marcação de presença ainda não foi liberada para este evento URM.'
			], 403);
		}

		if ((int) $inscricao->presenca === 1) {
			$this->_json_response([
				'status' => 'success',
				'message' => 'Sua presença já estava confirmada.'
			]);
		}

		// 3. Executa o Update
		$this->db->where('id', $id);
		$this->db->where('presenca', 0);
		$atualizado = $this->db->update('urm_inscricao', ['presenca' => 1]);

		if (!$atualizado) {
			$this->_json_response([
				'status' => 'error',
				'message' => 'Não foi possível marcar a presença. Tente novamente.'
			], 500);
		}

		$this->_json_response(['status' => 'success', 'message' => 'Presença marcada com sucesso!']);
	}

	private function _json_response($dados, $codigo = 200) {
		header('Content-Type: application/json');
		http_response_code($codigo);
		echo json_encode($dados);
		exit;
	}
	
	
	
}
