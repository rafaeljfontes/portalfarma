<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificado extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		require_once FCPATH . 'vendor/autoload.php';
		$dados = array();
		$arrayDados = array();
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
        $this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
		
	}
	
	public function certificado_palestrantes (){
		$arrayDados = [];
		
		//Mostrando na View
		$this->carregarCabecalho($arrayDados);
		$this->load->view('certificado_palestrantes');
		$this->load->view('fixo/rodape');
	}
	
	public function busca_certificado_palestrantes (){
		echo "aqui";
	}
	

	// O parâmetro $hash receberá o "NDUyLWZoMDEyNg=="
    public function validar($hash = NULL)
    {
		$data = [];
		$arrayDados = [];
		
				// Se o "=" ainda vier grudado no hash por causa da regex, limpamos aqui:
        $hash = str_replace('=', '', $hash);

        if (empty($hash)) {
            // Se não houver hash, redireciona ou mostra erro 404
            redirect('sua_home_ou_pagina_de_erro');
        }

        // Decodifica o Base64
        $hash_decodificado = base64_decode($hash);

        // Divide a string onde houver o "-"
		$partes = explode('-', $hash_decodificado);

		// Agora você isola cada valor
		$id_inscricao = $partes[0]; // 452
		$id_evento    = $partes[1]; // fh0126
		
		// Consulta no Banco de Dados (Curso)
		$query = "SELECT pf.* FROM tbl_portalfarma pf WHERE pf.courseid = '".$id_evento."'";
		$portalfarma_result = $this->capacifar_model->query($query);
		
		// Inicializamos as variáveis para evitar o erro de "Undefined variable"
		$tabela = "";
		$where  = "";
		$tipo_evento = null;

		// Verificamos se retornou alguma linha antes de prosseguir
		if (!empty($portalfarma_result)) {
			
			$linha = $portalfarma_result[0]; 
			$tipo_evento = isset($linha->tipo_evento) ? $linha->tipo_evento : $linha['tipo_evento'];

			switch ($tipo_evento) {
				case 3:
					$tabela = "urm_inscricao";
					$where = "AND urm_evento = '".$id_evento."'";
					break;
				case 4:
					$tabela = "fiscalizacao_humanizada_inscricao";
					$where = "AND id_evento = '".$id_evento."'";
					break;          
				case 7:
					$tabela = "tbl_seminario_inscricao";
					$where = "AND seminario = '".$id_evento."'";
					break;
			}
		}
		
		if (stripos($id_inscricao, 'p') !== false) {
    
			// 1. Extrai a letra PRIMEIRO, enquanto ela ainda existe na string
			$id_somente_letra   = preg_replace('/[^pP]/', '', $id_inscricao);   // Retorna 'p'

			// 2. Só DEPOIS remove tudo o que não for número
			$id_inscricao       = preg_replace('/[^0-9]/', '', $id_inscricao); // Retorna '36'
			
		} else {
			// Caso não contenha a letra 'p'
			$id_inscricao       = $id_inscricao;
			$id_somente_letra   = null;
		}

		// Agora o echo vai funcionar perfeitamente!
		//echo $id_somente_letra;
		
		// Se for Certificado Palestrante
		if(!empty($id_somente_letra)){
			$tabela = null;
			$sql 	= "SELECT 
							tp.*,
							tpp.nome, tpp.id_palestrante
						FROM tbl_portalfarma tp
						INNER JOIN tbl_portalfarma_palestrantes_curso tppc ON tppc.courseid = tp.courseid
						INNER JOIN tbl_portalfarma_palestrantes tpp ON tpp.id_palestrante = tppc.id_palestrante
						WHERE tpp.status = 1 and tpp.id_palestrante = '".$id_inscricao."' AND tppc.courseid = '".$id_evento."' ";
			$data['inscricao'] = $this->capacifar_model->query($sql);
			//print_r($data['inscricao'][0]);
		}
		
		// Se for Certificado Palestrante
		if(!empty($tabela)){
			//Consulta a inscrição se existe
			$sql 	= "SELECT * FROM ".$tabela." WHERE presenca = 1 ".$where." AND id = '".$id_inscricao."'";
			$data['inscricao'] = $this->capacifar_model->query($sql);
		}
		
		if (!empty($data['inscricao']) && !empty($portalfarma_result)) {

			// Extraímos o primeiro objeto de cada array
			$pessoa = $data['inscricao'][0];
			$curso = $portalfarma_result[0];
			
			// Exemplo: 510 minutos / 60 = 8.5
			$carga_decimal = $curso->carga_horaria / 60; 

			// Pega apenas a parte inteira (8)
			$horas = floor($carga_decimal); 

			// Pega o resto da divisão por 60 (30)
			$minutos = ($curso->carga_horaria % 60); 

			// Exibe o resultado formatado
			$carga_horaria = $horas . "h" . str_pad($minutos, 2, "0", STR_PAD_LEFT) . "min";

			// Criamos um array único com os dados que você precisa
			$data['certificado'] = [
				'nome'          	=> $pessoa->nome,
				'tipo_evento'   	=> $curso->tipo_evento,
				'palestrante_tipo'  => $id_somente_letra,
				'titulo'        	=> $curso->titulo,
				'carga_horaria' 	=> ($carga_horaria),
				'data_fim'      	=> date('d/m/Y', strtotime($curso->data_fim))
			];

		}
		
		//var_dump($data['certificado']);
		
			// Carrega a view de validação
			$this->carregarCabecalho($arrayDados);
			$this->load->view('validar_certificado', $data);
			$this->load->view('fixo/rodape');
	}
	
	public function buscar_palestrante_id() {
		$email = $this->input->post('email');

		if (empty($email)) {
			echo json_encode(['status' => 'error', 'message' => 'ID vazio']);
			return;
		}

		// Busca o palestrante na tabela informada
		$this->db->where('email', $email);
		$palestrante = $this->db->get('tbl_portalfarma_palestrantes')->row();

		if ($palestrante) {
			// Monta o HTML do botão que chama a sua função JS existente
			// Passando o ID do palestrante e o nome dele (opcional, caso sua função use)
			// Monta o HTML com o Nome do Palestrante em destaque e o Botão logo abaixo ou ao lado
			$botao_html = '<div class="card p-3 border-light-subtle shadow-sm text-start">';
			$botao_html .= '    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">';
			$botao_html .= '        <div>';
			$botao_html .= '            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Palestrante Encontrado</small>';
			$botao_html .= '            <h5 class="mb-0 text-dark fw-semibold">' . mb_strtoupper($palestrante->nome) . '</h5>';
			$botao_html .= '        </div>';
			$botao_html .= '        <button type="button" class="btn btn-primary" onclick="btn_gerar_certificados('.$palestrante->id_palestrante.')">';
			$botao_html .= '            <i class="fa-solid fa-certificate me-1"></i> IMPRIMIR CERTIFICADOS';
			$botao_html .= '        </button>';
			$botao_html .= '    </div>';
			$botao_html .= '</div>';

			echo json_encode([
				'status' => 'success',
				'html' => $botao_html
			]);
		} else {
			echo json_encode([
				'status' => 'empty',
				'message' => 'Nenhum registro encontrado'
			]);
		}
	}
	
	public function gerar_certificado_palestrantes($id_palestrante = null) {
		// Se o ID vier via POST (caso queira manter suporte), ou via segmento de URL
		if (!$id_palestrante) {
			$id_palestrante = $this->input->post('id_palestrante');
		}
		
		// inicializando a função do model
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
	
		// 1. Busca os dados (Query similar à anterior)
		$sql = "SELECT 
					tp.*,
					tpp.nome as palestrante, tpp.id_palestrante
				FROM tbl_portalfarma tp
				INNER JOIN tbl_portalfarma_palestrantes_curso tppc ON tppc.courseid = tp.courseid
				INNER JOIN tbl_portalfarma_palestrantes tpp ON tpp.id_palestrante = tppc.id_palestrante
				WHERE tpp.status = 1 and tpp.id_palestrante = '".$id_palestrante."'";
		$cursos 	= $this->capacifar_model->query($sql);

		if (empty($cursos)) {
			die("<script>alert('Nenhum curso vinculado a este palestrante.'); window.close();</script>");
		}
		
		// 2. Monta o HTML usando as tags da biblioteca
		
		
		// Formatação da data por extenso
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
		
		// Gerando as páginas dos certificados
		foreach ($cursos as $c) {
			// --- Lógica do QR Code ---
			$token = base64_encode("p".$id_palestrante."-".$c->courseid);
			$url_validacao = base_url("validar-certificado/" . $token);
			
			$result = \Endroid\QrCode\Builder\Builder::create()
				->writer(new \Endroid\QrCode\Writer\PngWriter())
				->data($url_validacao)
				->size(150)
				->margin(10)
				->build();
			
			$qrCodeBase64 = base64_encode($result->getString());
			// -------------------------
			
			// Preparação das variáveis para o Template (Nome palestrante)
			$nome = mb_convert_case($c->palestrante, MB_CASE_UPPER, "UTF-8");
			$nome_palestrante = wordwrap($nome, 30, "<br>");
	
			$carga_h = ($c->carga_horaria / 60);
			$data_extenso = strftime('%d de %B de %Y', strtotime($c->data_fim));
			$local_exibir = (trim(strtolower($c->local)) == 'online') ? 'Portal do Aluno (Online)' : $c->local;
			
			switch ($c->tipo_evento) {
				case '1':
					$template 	= FCPATH . 'public/Certificados/certificado-capacifar-2026_presencial.png';// Caminho da imagem
					$color		= '#e52641';
					break;
				case '2':
					$template 	= FCPATH . 'public/Certificados/certificado-capacifar-2026_online.png';// Caminho da imagem
					$color		= '#009cae';
					break;
				case '3':
					$template	= FCPATH . 'public/Certificados/certificado-capacifar-2026_online.png';// Caminho da imagem
					$color		= '#009cae';
					break;			
				case '4':
					$template 	= FCPATH . 'public/Certificados/certificado-capacifar-2026_online.png';// Caminho da imagem
					$color		= '#009cae';
					break;
				case '5':
					$template 	= FCPATH . 'public/Certificados/certificado-capacifar-2026_presencial.png';// Caminho da imagem
					$color		= '#e52641';
					break;
				case '7':
					$template 	= FCPATH . 'public/Certificados/Seminario_de_Vigilancia_em_Saude_sem_textos.png';// Caminho da imagem
					$color		= '#e52641';
					break;
			}
			
			// Cada <page> vira um certificado novo
			if($c->tipo_evento == 7){
				$html = '<style>
					.texto-topo { position: absolute; top: 160px; left: 80px; width: 900px; text-align: center; font-size: 18pt; font-weight: bold; line-height: 1.5; color: #5f6574; }
					.nome-palestrante { position: absolute; top: 260px; left: 360px; width: 100%; text-align: left; font-size: 35pt; font-weight: bold; text-transform: uppercase; }
					.texto-corpo 	{ position: absolute; top: 370px; left: 360px; width: 700px; text-align: left; font-size: 16pt; line-height: 1.5; color: #18557c; }
					.data-local 	{ position: absolute; top: 500px; left: 360px; width: 100%; text-align: left; font-size: 14pt; color: #18557c; }
					
					.qrcode-container { position: absolute; bottom: 100px; right: 20px; width: 120px; text-align: center; }
					.qrcode-img { width: 100px; height: 100px; }
					.qrcode-text { font-size: 7pt; color: #999; margin-top: 2px; }
				</style>';
								
				$html .= '<page backtop="0" backbottom="0" backleft="0" backright="0" backimg="'.$template.'">
												
						<div class="nome-palestrante" style="color:'.$color.';">'.$nome_palestrante.'</div>
						
						<div class="texto-corpo">
							ministrou a palestra no Seminário de Vigilância em Saúde com o tema: "<strong>'.$c->titulo.'</strong>", com carga horária de '.$carga_h.' horas, realizado no '.$local_exibir.'.
						</div>

						<div class="data-local">
							Belo Horizonte, '.$data_extenso.'
						</div>
						
						<div class="qrcode-container">
							<img src="data:image/png;base64,'.$qrCodeBase64.'" class="qrcode-img">
						</div>
					  </page>';	
			} else {
				$html = '<style>
					.texto-topo { position: absolute; top: 160px; left: 80px; width: 900px; text-align: center; font-size: 18pt; font-weight: bold; line-height: 1.5; color: #5f6574; }
					.nome-palestrante { position: absolute; top: 280px; width: 100%; text-align: center; font-size: 35pt; font-weight: bold; text-transform: uppercase; }
					.texto-corpo { position: absolute; top: 380px; left: 80px; width: 900px; text-align: center; font-size: 16pt; line-height: 1.5; color: #5f6574; }
					.data-local { position: absolute; top: 500px; width: 100%; text-align: center; font-size: 14pt; color: #5f6574; }
					
					.qrcode-container { position: absolute; bottom: 100px; right: 20px; width: 120px; text-align: center; }
					.qrcode-img { width: 100px; height: 100px; }
					.qrcode-text { font-size: 7pt; color: #999; margin-top: 2px; }
				</style>';
				
				$html .= '<page backtop="0" backbottom="0" backleft="0" backright="0" backimg="'.$template.'">
						<div class="texto-topo">
							O CONSELHO REGIONAL DE FARMÁCIA DO ESTADO DE MINAS GERAIS <br> certifica que
						</div>
						
						<div class="nome-palestrante" style="color:'.$color.';">'.mb_strtoupper($c->palestrante).'</div>
						
						<div class="texto-corpo">
							ministrou palestra do curso "<strong>'.$c->titulo.'</strong>", com carga horária de '.$carga_h.' horas, realizado no '.$local_exibir.'.
						</div>

						<div class="data-local">
							Belo Horizonte, '.$data_extenso.'
						</div>
						
						<div class="qrcode-container">
							<img src="data:image/png;base64,'.$qrCodeBase64.'" class="qrcode-img">
						</div>
					  </page>';
			}
			
					  
			
			
		}

		// 3. Saída Direta (Inline)
		try {
			$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'pt');
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($html);
			
			// 'I' envia o arquivo para o navegador abrir na tela
			$html2pdf->output('Certificados_palestrante_'.$id_palestrante.'.pdf', 'I');
		} catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
			die($e->getMessage());
		}
	}
	
	function validaCPF() {
		$cpf = $this->input->post('cpf');

		// 1. Remove caracteres não numéricos (pontos, traços, espaços)
		$cpf = preg_replace('/[^0-9]/', '', $cpf);

		// 2. Verifica se tem 11 dígitos ou se é uma sequência repetida conhecida
		if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
			echo json_encode(['status' => 'error', 'message' => 'O número de CPF informado não é válido.']);
			return;
		}

		// 3. Algoritmo de validação dos dígitos verificadores
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
				echo json_encode(['status' => 'error', 'message' => 'Os dígitos verificadores do CPF não conferem.']);
				return;
			}
		}

		// 4. Se passou em todos os testes, retorna sucesso
		echo json_encode(['status' => 'success', 'message' => 'Este CPF é válido para cadastro.']);
	}

}
