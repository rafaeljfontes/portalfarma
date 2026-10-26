<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class FiscalizacaoHumanizada  extends MY_Controller
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
		$arrayDados = []; 
		
		$qryativo = "SELECT
							tpf.*,
							GROUP_CONCAT(
								DISTINCT tcp.descricao
								ORDER BY tcp.descricao
								SEPARATOR ', '
							) AS categorias,
							 GROUP_CONCAT(
								DISTINCT tcp.icon
								ORDER BY tcp.icon
								SEPARATOR ', '
							) AS icones,
							GROUP_CONCAT(tpp.nome SEPARATOR ', ') AS palestrantes
						FROM web_site.tbl_portalfarma tpf
						LEFT JOIN tbl_tipo_portalfarma ttp 
							   ON ttp.tipo = tpf.tipo_evento
						LEFT JOIN tbl_categoria_eventos tce 
							  ON tce.courseid = tpf.courseid
						LEFT JOIN tbl_categorias_portalfarma tcp 
							   ON tcp.id = tce.id_categoria
						left join tbl_portalfarma_palestrantes_curso tppc 
								ON tppc.courseid = tpf.courseid 
						LEFT JOIN tbl_portalfarma_palestrantes tpp 
							   ON tpp.id_palestrante = tppc.id_palestrante 
						WHERE tpf.tipo_evento = 4 AND tpf.status = 1
						GROUP BY tpf.id
						ORDER BY tpf.data_cadastro DESC, tpf.data_fim DESC;";
		
		
		// 1. Busca os dados do seminário ativo
		$resultado = $this->capacifar_model->query($qryativo);
		
		
		// Verifica se retornou algum registro
		if (!empty($resultado)) {
			// 2. Extrai o ID do primeiro registro (índice 0)
			$id = $resultado[0]->courseid; 
			
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
			$arrayDados['fiscalizacao'] = $resultado;
			$arrayDados['programacao']  = $this->capacifar_model->query($qryProg);
			$arrayDados['tblpalestrantes'] = $this->capacifar_model->query($queryPalestrantes);
			
			
		} else {
			// Caso não encontre nenhum seminário ativo
			$arrayDados['fiscalizacao']    = [];
			$arrayDados['programacao']  = [];
			$arrayDados['tblpalestrantes'] = [];
		}

		$this->carregarCabecalho($arrayDados);
		$this->load->view('fiscalizacaohumanizada');
		$this->load->view('fixo/rodape');
	}

	public function Inscricao()
	{
		
		$arrayDados = [];
		
		$arrayDados['id']  = $this->uri->segment('3');
		
		$query 	= "SELECT pf.* FROM tbl_portalfarma pf WHERE pf.status = 1 AND pf.courseid = '".$arrayDados['id']."'";

		$arrayDados['fiscalizacao'] = $this->capacifar_model->query($query);

		$this->carregarCabecalho($arrayDados);
		$this->load->view('fiscalizacaohumanizada_inscricao');
		$this->load->view('fixo/rodape');
		
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
		$query 	= "SELECT fh.cpf FROM fiscalizacao_humanizada_inscricao fh WHERE fh.id_evento = '" . $solicitacao['id_evento'] . "' AND fh.cpf = '" . $solicitacao['cpf'] . "';";

		$res	= $this->capacitacao->query($query);

		if (!$res) {
			$retorno['type']    = 'danger';
			$retorno['title']   = 'Falha ao buscar inscrição.';
			$retorno['message'] = 'Usuário sem CPF cadastrado.';

			echo json_encode($retorno);
			exit;
		}

		$update = $this->capacitacao->PresencaFiscalizacaoHumanizada($solicitacao);

		if (!empty($update)) {

			$retorno['type']    = 'success';
			$retorno['title']   = 'Tudo certo.';
			$retorno['message'] = '✅ Presença confirmada!';
			echo json_encode($retorno);
			exit;
		}
	}
	
	public function processar_inscricao() {
		// 1. Recebe os dados do POST
		$dados = $this->input->post();

		// 2. Validação básica (Campos obrigatórios)
		if (empty($dados['cpf']) || empty($dados['courseid'])) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Preencha todos os campos obrigatórios.'
			]);
			return;
		}

		// Limpa o CPF para manter apenas números no banco (opcional, mas recomendado)
		$cpf_limpo = preg_replace('/[^0-9]/', '', $dados['cpf']);
		$crfmg_limpo = preg_replace('/[^0-9]/', '', $dados['crf']);

		// 3. Verifica se já existe inscrição para este CPF neste curso específico
		$this->db->where('cpf', $cpf_limpo); // ou $cpf_limpo
		$this->db->where('id_evento', $dados['courseid']);
		$existe = $this->db->get('fiscalizacao_humanizada_inscricao')->num_rows();

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
			'crfmg'             => $crfmg_limpo ?? '',
			'email'             => strtolower($dados['email']),
			'telefone'          => $dados['telefone'],
			'municipio'         => $dados['cidade'],
			'local_trabalho'    => $dados['ocupacao'],
			'data_inscricao'    => date('Y-m-d H:i:s'),
			'id_evento'	        => $dados['courseid']
		];

		// 5. Insere no banco
		if ($this->db->insert('fiscalizacao_humanizada_inscricao', $data_insert)) {
    
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
						Sua inscrição foi realizada com sucesso no Fiscalização Humanizada, Tema:  <strong class='title-curse'>{$tema}</strong>
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

	public function buscarInscricoes()
	{
		$dados = $this->input->post();

		// Limpa o CPF para manter apenas números no banco
		$cpf = preg_replace('/[^0-9]/', '', $dados['cpf']);

		
		$sql = "
			SELECT 
				f.id as inscricao_id,
				pf.titulo as evento_nome,
				f.municipio,
				f.presenca,
				pf.courseid,
				DATE_FORMAT(pf.data_inicio, '%d/%m/%Y') as data_evento_formatada,
				DATE_FORMAT(f.data_inscricao, '%d/%m/%Y') as data_inscricao_formatada,
				pf.data_inicio as data_evento			
			FROM fiscalizacao_humanizada_inscricao f
			JOIN tbl_portalfarma pf ON f.id_evento = pf.courseid
			WHERE f.cpf = '".$cpf."' 
			ORDER BY pf.data_inicio DESC
		";
		
		//print_r($sql);
		
		$resultados = $this->capacifar_model->query($sql);
		
		//var_dump($resultados);

		// Define o cabeçalho como JSON para o navegador entender a resposta
		header('Content-Type: application/json');

		// Converte os dados e imprime
		echo json_encode($resultados);
		exit;
	}
	
	
	/*  GERAR CERTIFICADO */
	public function gerarCertificado($id_inscricao) {
		// 1. Busca os dados do participante e do evento
		$dados = $this->db->select('f.*, pf.titulo, pf.data_inicio, pf.courseid')
						  ->from('fiscalizacao_humanizada_inscricao f')
						  ->join('tbl_portalfarma pf', 'f.id_evento = pf.courseid')
						  ->where('f.id', $id_inscricao)
						  ->get()
						  ->row();

		// Validação de segurança: Só gera se tiver presença confirmada
		if (!$dados || $dados->presenca != 1) {
			die("Certificado não disponível ou presença não confirmada.");
		}

		// 2. Preparação das variáveis para o Template
		$nome = mb_convert_case($dados->nome, MB_CASE_UPPER, "UTF-8");
		$nome_participante = wordwrap($nome, 30, "<br>");
		//$tipo_inscricao = $dados->tipo_participacao;
		
		// Formatação da data por extenso
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
		$data_extenso = strftime('%d de %B de %Y', strtotime($dados->data_inicio));
		
		$token = base64_encode($dados->id."-".$dados->courseid);
		
		// 3. Lógica do QR Code (Endroid QR Code)
		$url_validacao = base_url("validar-certificado/" . $token);
		
		// Usando a biblioteca Endroid/QrCode (conforme seu snippet)
		$result = \Endroid\QrCode\Builder\Builder::create()
			->writer(new \Endroid\QrCode\Writer\PngWriter())
			->data($url_validacao)
			->size(150)
			->margin(10)
			->build();
		$qrCodeBase64 = base64_encode($result->getString());
		
		/*foreach ($res as $r) {
			$id 		= $r->id;
			$nome 		= $r->nome;
			$evento 	= $r->evento;
			$dtevento 	= $r->data_evento;
		}*/
		
		$id 		= $dados->id;
		$nome 		= $dados->nome;
		$evento 	= str_replace("Edição - ", "", $dados->titulo);
		$dtevento 	= $dados->data_inicio;

		$hoje 		= date('Y-m-d');
		$hojehora 	= date('Y-m-d H:i:s');
		$data_atual 	= $this->capacifar_model->data_extenso($hoje);

		// 4. CSS e HTML do PDF
		$pdf_css = <<<PDF_CSS
				<style type="text/css">
					#nome_participante {
						position: absolute;
						top: 280px;
						left: 58px;
						font-size: 34px;
						text-transform: uppercase;
						color: #213a77;
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
						top: 460px;
						left: 50px;
						font-size: 16px;
						color: #213a77;
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
						color: #047960;			
					}
				</style>
			PDF_CSS;

			$qrCodeImage = '
				<div style="position: absolute; right: 40px; bottom: 160px; z-index: 0;">
					<img src="data:image/png;base64,' . $qrCodeBase64 . '" width="80">
				</div>';

		// 5. Caminho para o servidor processar o arquivo (Físico)
			$img_path_fisico = FCPATH . 'assets/certificado/Certificado_Fiscalizacao_humanizada.png';

			$html = <<<HTML_PDF
				$pdf_css
				<page orientation="L" backimg="assets/certificado/Certificado_Fiscalizacao_humanizada.png">
					<div id="nome_participante">$nome_participante</div>
					<div id="evento">o Conselho Regional de Farmácia do Estado de Minas Gerais agradece sua participação no encontro do projeto<br> <span class="fischum"> "FISCALIZAÇÃO HUMANIZADA"</span> realizado na cidade de <span class="fischum">$evento</span>, e parabeniza-o por fazer a diferença na sua comunidade.</div>
					<div id="carga_horaria">CARGA HORARIA: 4 HORAS</div>
					
					<div id="data">$evento, $data_extenso</div>
					
					$qrCodeImage
				</page>
			HTML_PDF;

		// 6. Inicialização e Saída do Html2Pdf
		try {
			$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'pt');
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($html);
			$html2pdf->output('Certificado_'.$dados->id.'.pdf');
		} catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
			die($e->getMessage());
		}
	}

	public function validarCertificado()
	{

		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = base64_decode($this->uri->segment('3'));
		//$id = 1;
		//print_r($id);exit;
		$query 	= "SELECT fh.id, fh.nome, fhe.evento, fhe.data_evento FROM fiscalizacao_humanizada_inscricao fh INNER JOIN fiscalizacao_humanizada_evento fhe ON fhe.id_evento = fh.id_evento WHERE fh.id = '$id' LIMIT 1 ;";
		$res		= $this->capacifar_model->query($query);


		if (!$res) {
			$arrayDados['type']    = 'danger';
			$arrayDados['title']   = 'Falha ao gerar certificado.';
			$arrayDados['message'] = 'Usuário não encontrado, verifique os dados informados.';
		} else {

			foreach ($res as $r) {
				$id 		= $r->id;
				$nome 		= $r->nome;
				$evento 	= $r->evento;
				$dtevento 	= $r->data_evento;
			}

			$data_extenso 	= $this->capacifar_model->data_extenso($dtevento);

			$arrayDados['type']    = 'success';
			$arrayDados['title']   = 'Tudo certo.';
			$arrayDados['message'] = 'O <b>' . $nome . '</b> participou do evento <br><b>FISCALIZAÇÃO HUMANIZADA</b> <br>realizado em <b>' . $evento . '</b>, <br> em ' . $data_extenso . '';
		}



		$this->carregarCabecalho($arrayDados);
		$this->load->view('validar_certificado', $arrayDados);
		$this->load->view('fixo/rodape');
	}

	public function validarCPF($cpf)
	{
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
