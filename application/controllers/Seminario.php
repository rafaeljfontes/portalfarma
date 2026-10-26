<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seminario  extends MY_Controller
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
		
		$seminario_ativo = "SELECT
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
						WHERE tpf.tipo_evento = 7 AND tpf.status = 1
						GROUP BY tpf.id
						ORDER BY tpf.data_cadastro DESC, tpf.data_fim DESC;";
		
		
		// 1. Busca os dados do seminário ativo
		$seminario_resultado = $this->capacifar_model->query($seminario_ativo);
		
		
		// Verifica se retornou algum registro
		if (!empty($seminario_resultado)) {
			// 2. Extrai o ID do primeiro registro (índice 0)
			$id = $seminario_resultado[0]->courseid; 
			
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
			$arrayDados['seminario']    = $seminario_resultado;
			$arrayDados['programacao']  = $this->capacifar_model->query($qryProg);
			$arrayDados['tblpalestrantes'] = $this->capacifar_model->query($queryPalestrantes);
			
			
		} else {
			// Caso não encontre nenhum seminário ativo
			$arrayDados['seminario']    = [];
			$arrayDados['programacao']  = [];
			$arrayDados['tblpalestrantes'] = [];
		}
		
		//print_r($arrayDados['palestrantes']);
		
		//Mostrando na View
		$this->carregarCabecalho($arrayDados);
		$this->load->view('seminario');
		$this->load->view('fixo/rodape');
	}
	
	public function inscrever()
	{
		$arrayDados = [];
		
		$arrayDados['id']  = $this->uri->segment('3');
		
		$query 	= "SELECT pf.* FROM tbl_portalfarma pf WHERE pf.status = 1 AND pf.courseid = '".$arrayDados['id']."'";
		$sql = "SELECT COUNT(*) as total FROM tbl_seminario_inscricao 
        WHERE seminario = '".$arrayDados['id']."'
        AND tipo_participacao = 'presencial'";

		$arrayDados['seminario'] 		= $this->capacifar_model->query($query);
		$arrayDados['total_presencial'] = $this->capacifar_model->query($sql);

		$this->carregarCabecalho($arrayDados);
		$this->load->view('seminario_inscricao');
		$this->load->view('fixo/rodape');
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
		$this->db->where('seminario', $dados['courseid']);
		$existe = $this->db->get('tbl_seminario_inscricao')->num_rows();

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
			'UF'                => $dados['uf'],
			'cidade'            => $dados['cidade'],
			'ocupacao'          => $dados['ocupacao'],
			'tipo_participacao'	=> $dados['tipo_participacao'],
			'data_inscricao'    => date('Y-m-d H:i:s'),
			'seminario'	        => $dados['courseid']
		];

		// 5. Insere no banco
		if ($this->db->insert('tbl_seminario_inscricao', $data_insert)) {
    
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
						Sua inscrição foi realizada com sucesso no Seminário em Saúde com o Tema:  <strong class='title-curse'>{$tema}</strong>
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
	
	public function nps(){
	
		$arrayDados = [];
		
		$arrayDados['id']  = $this->uri->segment('3');
		
		$query 	= "SELECT pf.* FROM tbl_portalfarma pf WHERE pf.status = 1 AND pf.courseid = '".$arrayDados['id']."'";

		$arrayDados['portalfarma'] = $this->capacifar_model->query($query);

		$this->carregarCabecalho($arrayDados);
		$this->load->view('nps');
		$this->load->view('fixo/rodape');
	
	}
	
	public function nps_cadastrar(){
	
		// 1. Recebe os dados do POST
		$dados = $this->input->post();
		
		// 2. Validação básica (Campos obrigatórios)
		if (empty($dados['courseid']) || empty($dados['email']) || empty($dados['escala']) || empty($dados['perguntaA']) || empty($dados['perguntaB']) || empty($dados['perguntaC'])) {
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
	
	public function buscarInscricoes()
	{
		$dados = $this->input->post();

		// Limpa o CPF para manter apenas números no banco
		$cpf = preg_replace('/[^0-9]/', '', $dados['cpf']);
		
		$sql = "
			SELECT 
				s.id as inscricao_id,
				pf.titulo as evento_nome,
				s.tipo_participacao  as modalidade,
				s.presenca,
				pf.courseid,
				pf.presenca_liberada,
				DATE_FORMAT(s.data_inscricao, '%d/%m/%Y') as data_inscricao_formatada,
				DATE_FORMAT(pf.data_inicio, '%d/%m/%Y') as data_evento_formatada,
				pf.data_inicio as data_evento,
				s.data_inscricao as data_inscricao				
			FROM tbl_seminario_inscricao s
			JOIN tbl_portalfarma pf ON s.seminario = pf.courseid
			WHERE s.cpf = '".$cpf."' 
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

	public function gerarCertificado($id_inscricao) {
		// 1. Busca os dados do participante e do evento
		$dados = $this->db->select('s.*, pf.titulo, pf.data_inicio, pf.courseid')
						  ->from('tbl_seminario_inscricao s')
						  ->join('tbl_portalfarma pf', 's.seminario = pf.courseid')
						  ->where('s.id', $id_inscricao)
						  ->get()
						  ->row();

		// Validação de segurança: Só gera se tiver presença confirmada
		if (!$dados || $dados->presenca != 1) {
			die("Certificado não disponível ou presença não confirmada.");
		}

		// 2. Preparação das variáveis para o Template
		$nome = mb_convert_case($dados->nome, MB_CASE_UPPER, "UTF-8");
		$nome_participante = wordwrap($nome, 30, "<br>");
		$tipo_inscricao = $dados->tipo_participacao;
		
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
		
		//var_dump($dados->seminario);exit;
		
		switch ($dados->seminario) {
			case 'sv0124':
				$certificado_template = "Seminario_de_Vigilancia_em_Saude_Certificado_28_de_Junho.png";
				break;
			case 'sv0225':
				$certificado_template = "Seminario_de_Vigilancia_em_Saude_Certificado_04_de_Abril.png";
				break;
			case 'sv0325':
				$certificado_template = "Seminario_de_Vigilancia_em_Saude_Certificado_27_de_Junho.png";
				break;			
			case 'sv0425':
				$certificado_template = "Seminario_de_Vigilancia_em_Saude_Certificado_23_de_Julho.png";
				break;
			case 'sv0525':
				$certificado_template = "Seminario_de_Vigilancia_em_Saude_Certificado_21_de_Agosto.png";
				break;
			case 'sv0126':
				$certificado_template = "Seminario_de_Vigilancia_em_Saude_Certificado_20_de_Maio.png";
				break;
		}

		// Caminho da Imagem do Certificado
		$img_path = FCPATH . "public/Certificados/" . $certificado_template; // Caminho físico no servidor
		
		// Define o caminho apenas se o TCPDF ou outra classe já não o tiver feito
		/*$font_path = FCPATH . 'vendor/tecnickcom/tcpdf/fonts/';

		if (!defined('K_PATH_FONTS')) {
			define('K_PATH_FONTS', $font_path);
		}*/

		try {
			if (ob_get_contents()) ob_end_clean();
		
			// 2. Inicialização (Mova para antes de adicionar a fonte)
			$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'pt');

			$path_fonte = FCPATH . 'public/fonts/saira.php';

			// Mudamos o primeiro parâmetro para 'sairacertificado' para forçar o componente a criar um índice do zero
			//$html2pdf->addFont('saira', '', $path_fonte);
			//$html2pdf->setDefaultFont('saira');
			
			$html2pdf->setDefaultFont('helvetica');
			
			/*$path_regular = FCPATH . 'public/fonts/montserrat.php';
			$html2pdf->addFont('montserrat', '', $path_regular);
			$html2pdf->setDefaultFont('montserrat');*/

			// 4. CSS e HTML (Ajustado)
			$pdf_css = "
			<style type='text/css'>
				/* Use font-family sem aspas simples dentro do style se der conflito */
				div, span, p { font-family: saira; }
				
				#conselho { position:absolute; top: 180px; left: 350px; font-size: 24px; color:#069; }
				#nome_participante { 
					position:absolute; top: 275px; left: 358px; 
					font-size: 34px; color:#d91a32; 
					font-weight: bold; 
				}
				#evento {
					position: absolute; top: 360px; left: 350px; 
					width: 650px; font-size: 18px; color: #069; line-height: 1.4; 
				}
				#carga_horaria { 
					position:absolute; top: 469px; left: 470px; 
					font-size: 16px; color:#069; font-weight:bold; letter-spacing: -0.3px;
				}
				#data { position:absolute; top: 485px; left: 350px; font-size: 16px; color:#069; }
			</style>";

			$html = "
			<page orientation='L' backimg='{$img_path}'>
				{$pdf_css}
				<div id='nome_participante'>{$nome_participante}</div>
				<div id='carga_horaria'> 8h30 minutos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Modalidade: {$tipo_inscricao}</div>
				<div style='position: absolute; right: 40px; bottom: 120px;'>
					<img src='data:image/png;base64,{$qrCodeBase64}' width='100'>
				</div>
			</page>";
			
			
			$html2pdf->writeHTML($html);
			//$html2pdf->output('Certificado_'.$dados->id.'.pdf');
			// Altera o destino para I (In browser) para testarmos se ele exibe direto na tela sem travar no download
			$html2pdf->output('Certificado_'.$dados->id.'.pdf', 'I');

		} catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
			die($e->getMessage());
		}
	}
	
	public function setPresenca() {
		$id = $this->input->post('id');
		
		// 1. Busca os dados do evento antes de atualizar
		$inscricao = $this->db->select('s.id, s.presenca, pf.presenca_liberada')
							  ->from('tbl_seminario_inscricao s')
							  ->join('tbl_portalfarma pf', 's.seminario = pf.courseid')
							  ->where('s.id', $id)
							  ->get()
							  ->row();

		if (!$inscricao) {
			$this->_json_response(['status' => 'error', 'message' => 'Inscrição não encontrada.'], 404);
		}

		if ((int) $inscricao->presenca_liberada !== 1) {
			$this->_json_response([
				'status' => 'error',
				'message' => 'A marcação de presença ainda não foi liberada para este seminário.'
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
		$this->db->update('tbl_seminario_inscricao', ['presenca' => 1]);

		$this->_json_response(['status' => 'success', 'message' => 'Presença confirmada!']);
	}

	/**
	 * Função auxiliar para padronizar o retorno JSON no CI3
	 */
	private function _json_response($data, $code = 200) {
		header('Content-Type: application/json');
		http_response_code($code);
		echo json_encode($data);
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
