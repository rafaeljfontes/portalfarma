<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class Palestrantes extends MY_Controller {

	private $dados;

	public function __construct() {
        parent::__construct();
		require_once FCPATH . 'vendor/autoload.php';
		$dados = array();
        $this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->load->model('palestrantes_model');
		$this->load->model('Moodle_model');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
		
		//Verificando permissões
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

	public function index()
	{
		$statusLista = (int) $this->input->get('status');
		$statusLista = $statusLista === 0 && $this->input->get('status') !== null ? 0 : 1;
		
		$listaPalestrantes = "SELECT 
								tpp.*,
								GROUP_CONCAT(tp.titulo SEPARATOR ', ') AS cursos
							FROM tbl_portalfarma_palestrantes tpp
							LEFT JOIN tbl_portalfarma_palestrantes_curso tppc 
								ON tppc.id_palestrante = tpp.id_palestrante
							LEFT JOIN tbl_portalfarma tp 
								ON tp.courseid = tppc.courseid
							WHERE tpp.status = ". $statusLista ."
							GROUP BY tpp.id_palestrante
							ORDER BY tpp.nome ASC;";
		
		$arrayDados['tabelaPalestrantes'] = $this->capacifar_model->query($listaPalestrantes);
		$arrayDados['statusLista'] = $statusLista;
		$arrayDados['totaisStatus'] = [
			1 => $this->db->where('status', 1)->from('tbl_portalfarma_palestrantes')->count_all_results(),
			0 => $this->db->where('status', 0)->from('tbl_portalfarma_palestrantes')->count_all_results()
		];
		
		$this->load->view('restrito/fixo/cabecalho', $this->dados);
		$this->load->view('restrito/palestrantes', $arrayDados);
		$this->load->view('restrito/fixo/rodape', $this->dados);
	}

	public function formulario($id_palestrante = null) 
	{
	
		$id_palestrante  = $this->uri->segment('4');
		
		if(!is_null($id_palestrante)){
			$this->dados['edit'] = $this->palestrantes_model->list(['id_palestrante' => $id_palestrante]);
		}
		
		$this->load->view('restrito/fixo/cabecalho', $this->dados);
		$this->load->view('restrito/form_palestrantes', $this->dados);
		$this->load->view('restrito/fixo/rodape', $this->dados);
	}
	
	public function palestrante_curso(){
		
		$listaPalestrantes = "SELECT 
				tp.titulo AS curso_nome,
				tp.courseid,
				GROUP_CONCAT(CONCAT(tpp.nome, ':', tpp.id_palestrante) SEPARATOR '|') AS palestrantes_info
			FROM tbl_portalfarma tp
			INNER JOIN tbl_portalfarma_palestrantes_curso tppc ON tppc.courseid = tp.courseid
			INNER JOIN tbl_portalfarma_palestrantes tpp ON tpp.id_palestrante = tppc.id_palestrante
			WHERE tpp.status = 1
			GROUP BY tp.courseid, tp.titulo
			ORDER BY tp.titulo ASC;";
		
		
		$qry_palestrantes = "SELECT * FROM tbl_portalfarma_palestrantes WHERE status = 1;";
		$qry_cursos = "SELECT tp.courseid, tp.titulo FROM web_site.tbl_portalfarma AS tp;";
		
		$data['tabelaPalestrantes']	= $this->capacifar_model->query($listaPalestrantes);
		$data['palestrantes'] 		= $this->palestrantes_model->query($qry_palestrantes);
        $data['cursos'] 			= $this->palestrantes_model->query($qry_cursos);

        $this->load->view('restrito/fixo/cabecalho', $this->dados);
		$this->load->view('restrito/palestrantes_curso', $data);
		$this->load->view('restrito/fixo/rodape', $this->dados);
		
	}
	
	public function vincular_palestrante_curso()
    {
			$courseid 		= $this->input->post('courseid');
			$palestrantes 	= $this->input->post('palestrantes'); // Isso será um array

			if (!$courseid || empty($palestrantes)) {
				echo "Selecione curso e pelo menos um palestrante.";
				return;
			}

			$idsVinculos = [];
			$this->db->trans_start();
			foreach ($palestrantes as $palestrante_id) {
				$this->db->insert('tbl_portalfarma_palestrantes_curso', [
					'courseid' => $courseid,
					'id_palestrante' => $palestrante_id
				]);
				$idsVinculos[] = (int) $this->db->insert_id();
			}
			
			
			$this->db->trans_complete(); // finaliza transação

			// verifica status
			if ($this->db->trans_status() === FALSE) {
				$this->session->set_flashdata('retorno', [
					'status' => 'ok',
					'mensagem' => 'Erro ao salvar no banco.'
				]);
			} else {
				foreach ($idsVinculos as $idVinculo) {
					registrar_historico(11, $idVinculo);
				}
				$this->session->set_flashdata('retorno', [
					'status' => 'ok',
					'mensagem' => 'Palestrantes vinculados com sucesso!'
				]);
			}
			
			
			redirect('restrito/palestrantes/curso');
    }
	
	public function excluir_vinculo_palestrante() {
		// Verifica se é uma requisição POST
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			show_404();
		}

		$id_palestrante = $this->input->post('id_palestrante');
		$courseid       = $this->input->post('courseid');

		if (!$id_palestrante || !$courseid) {
			echo json_encode(['status' => 'error', 'message' => 'Dados incompletos.']);
			return;
		}

		// Executa a exclusão na tabela de vínculo
		$this->db->where('id_palestrante', $id_palestrante);
		$this->db->where('courseid', $courseid);
		$delete = $this->db->delete('tbl_portalfarma_palestrantes_curso');

		if ($delete) {
			echo json_encode(['status' => 'success', 'message' => 'Palestrante desvinculado com sucesso.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir vínculo no banco de dados.']);
		}
	}

	public function salvar() {
		// Este endpoint e consumido exclusivamente pelo formulario via AJAX.
		// Portanto, inclusive os erros precisam retornar JSON (e nunca redirect/HTML).
		$responder = function ($status, $mensagem, $httpCode = 200) {
			// Envia a resposta imediatamente. Assim, nenhuma rotina executada depois
			// desta ação consegue acrescentar HTML ou substituir o JSON do AJAX.
			if (ob_get_level() > 0) {
				ob_clean();
			}
			http_response_code($httpCode);
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode([
					'status' => $status,
					'mensagem' => $mensagem
				], JSON_UNESCAPED_UNICODE);
			exit;
		};

		$config_validacao = array(
			array(
				'field' => 'nome',
				'label' => 'nome',
				'rules' => 'required',
				'errors' => array('required' => 'Campo obrigatório.'),
			),
			array(
				'field' => 'curriculo',
				'label' => 'curriculo',
				'rules' => 'required',
				'errors' => array('required' => 'Campo obrigatório.'),
			),
		);
		
		$this->form_validation->set_rules($config_validacao);

		if ($this->form_validation->run() == FALSE) {
			$responder('error', trim(strip_tags(validation_errors(' ', ' '))), 422);
			return;
		}

		$id_palestrante = $this->input->post('id');
		$nome_palestrante = $this->input->post('nome');

		// ==========================================
		// VERIFICAÇÃO DE DUPLICIDADE DE NOME
		// ==========================================
		$this->db->where('nome', $nome_palestrante);
		
		// Se for uma EDIÇÃO, ignora o próprio ID do palestrante atual na busca
		$edicao = !empty($id_palestrante);
		if ($edicao) {
			$this->db->where('id_palestrante !=', $id_palestrante);
		}
		
		$ja_existe = $this->db->get('tbl_portalfarma_palestrantes')->row();

		if ($ja_existe) {
			$responder('error', 'Este palestrante já está cadastrado no sistema.', 409);
			return;
		}
		// ==========================================

		// Inicia a transação no banco de dados
		$this->db->trans_begin();
		$arquivoEnviado = null;

		$palestrante['nome']      = $nome_palestrante;
		$palestrante['curriculo'] = $this->input->post('curriculo');
		$palestrante['link']      = $this->input->post('link');
		$palestrante['email']     = $this->input->post('email');

		if (!empty($id_palestrante)) {
			// Modo Edição
			$salvouDados = $this->palestrantes_model->update($palestrante, $id_palestrante);
			$mensagem_sucesso = 'Dados do palestrante atualizados com sucesso!';
		} else {
			// Modo Novo Registro
			$id_palestrante = $this->palestrantes_model->insert($palestrante);
			$salvouDados = !empty($id_palestrante);
			$mensagem_sucesso = 'Palestrante cadastrado com sucesso!';
		}

		if (!$id_palestrante || !$salvouDados) {
			$this->db->trans_rollback();
			$responder('error', 'Não foi possível salvar os dados no banco.', 500);
		}

		// Processamento da FOTO (Se houver upload)
		if (!empty($_FILES['foto']['tmp_name'])) {
			$nomeTratado = str_replace(' ', '_', $palestrante['nome']);
			$nomeTratado = preg_replace('/[^A-Za-z0-9_\-]/', '', $nomeTratado);
			
			$config_upload['upload_path']   = FCPATH . 'uploads/palestrantes/';
			$config_upload['allowed_types'] = 'gif|jpg|png|jpeg';
			$config_upload['max_size']      = 5120;
			$config_upload['file_name']     = $nomeTratado . '_' . time(); 
			$config_upload['overwrite']     = TRUE;
			
			$this->load->library('upload');
			$this->upload->initialize($config_upload);

			if ($this->upload->do_upload('foto')) {
				$dadosUpload = $this->upload->data();
				$arquivoEnviado = $dadosUpload['full_path'];
				$urlCompleta = base_url('uploads/palestrantes/' . $dadosUpload['file_name']);
				if (!$this->palestrantes_model->update(['foto' => $urlCompleta], $id_palestrante)) {
					$this->db->trans_rollback();
					@unlink($arquivoEnviado);
					$responder('error', 'A foto foi enviada, mas não foi possível vinculá-la ao cadastro.', 500);
					return;
				}
			} else {
				$this->db->trans_rollback();
				$responder('error', 'Erro no envio da foto: ' . trim(strip_tags($this->upload->display_errors())), 422);
				return;
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			if ($arquivoEnviado && is_file($arquivoEnviado)) {
				@unlink($arquivoEnviado);
			}
			$responder('error', 'Erro ao salvar os dados no banco.', 500);
		} else {
			$this->db->trans_commit();
			registrar_historico($edicao ? 8 : 7, $id_palestrante);
			$responder('success', $mensagem_sucesso);
		}
	}
	
	public function certificado_palestrantes($id_palestrante = null) {
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
				WHERE tpp.id_palestrante = '".$id_palestrante."'";
		$cursos 	= $this->capacifar_model->query($sql);

		if (empty($cursos)) {
			die("<script>alert('Nenhum curso vinculado a este palestrante.'); window.close();</script>");
		}
		
		// 2. Monta o HTML usando as tags da biblioteca
		
		
		// Formatação da data por extenso
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
		
		// Gerando as páginas dos certificados
			// 1. Inicializa a variável HTML vazia ANTES do laço
			$html = '';

			// 2. Define os estilos CSS globais apenas UMA vez para evitar duplicidade de tags de estilo
			$html .= '<style>
				.texto-topo { position: absolute; top: 160px; left: 80px; width: 900px; text-align: center; font-size: 18pt; font-weight: bold; line-height: 1.5; color: #5f6574; }
				.nome-palestrante { position: absolute; top: 280px; width: 100%; text-align: center; font-size: 30pt; font-weight: bold; text-transform: uppercase; }
				.texto-corpo { position: absolute; top: 370px; left: 80px; width: 900px; text-align: center; font-size: 14pt; line-height: 1.5; color: #5f6574; }
				.data-local { position: absolute; top: 510px; width: 100%; text-align: center; font-size: 12pt; color: #5f6574; }
				
				/* Estilos específicos para o Tipo 7 (alinhados à esquerda) */
				.topo-7 { position: absolute; top: 160px; left: 80px; width: 900px; text-align: center; font-size: 18pt; font-weight: bold; line-height: 1.5; color: #5f6574; }
				.nome-7 { position: absolute; top: 260px; left: 360px; width: 100%; text-align: left; font-size: 34pt; font-weight: bold; text-transform: uppercase; }
				.corpo-7 { position: absolute; top: 370px; left: 360px; width: 700px; text-align: left; font-size: 16pt; line-height: 1.5; color: #18557c; }
				.data-7 { position: absolute; top: 500px; left: 360px; width: 100%; text-align: left; font-size: 14pt; color: #18557c; }
				
				.qrcode-container { position: absolute; bottom: 100px; right: 20px; width: 120px; text-align: center; }
				.qrcode-img { width: 100px; height: 100px; }
				.qrcode-text { font-size: 7pt; color: #999; margin-top: 2px; }
			</style>';

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
					case '5':
						$template = FCPATH . 'public/Certificados/certificado-capacifar-2026_presencial.png';
						$color    = '#e52641';
						break;
					case '2':
					case '3':
					case '4':
						$template = FCPATH . 'public/Certificados/certificado-capacifar-2026_online.png';
						$color    = '#009cae';
						break;
					case '7':
						$template = FCPATH . 'public/Certificados/Seminario_de_Vigilancia_em_Saude_sem_textos.png';
						$color    = '#e52641';
						break;
				}
				
				// ATENÇÃO: Agora usamos ".=" para ADICIONAR páginas ao HTML sem apagar as anteriores
				if($c->tipo_evento == 7){
					$html .= '<page backtop="0" backbottom="0" backleft="0" backright="0" backimg="'.$template.'">
							<div class="nome-7" style="color:'.$color.';">'.$nome_palestrante.'</div>
							<div class="corpo-7">
								ministrou a palestra no Seminário de Vigilância em Saúde com o tema: "<strong>'.$c->titulo.'</strong>", com carga horária de '.$carga_h.' horas, realizado no '.$local_exibir.'.
							</div>
							<div class="data-7">
								Belo Horizonte, '.$data_extenso.'
							</div>
							<div class="qrcode-container">
								<img src="data:image/png;base64,'.$qrCodeBase64.'" class="qrcode-img">
							</div>
						  </page>';	
				} else {
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

			// 3. Saída Direta (Inline) do PDF com todas as páginas unidas
			try {
				$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'pt');
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($html);
				$html2pdf->output('Certificados_palestrante_'.$id_palestrante.'.pdf', 'I');
			} catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
				die($e->getMessage());
			}
	}
	
	public function excluir($id) {
		if (!$this->input->is_ajax_request()) {
		   exit('Nenhum acesso direto ao script permitido');
		}

		$this->load->model('Palestrantes_model');
		
		// Chamamos a função de alteração de status
		$resultado = $this->Palestrantes_model->desativar($id);

		if ($resultado) {
			registrar_historico(9, $id);
			echo json_encode(['status' => 'success', 'mensagem' => 'Palestrante desativado com sucesso!']);
		} else {
			echo json_encode(['status' => 'error', 'mensagem' => 'Erro ao tentar desativar o palestrante.']);
		}
	}

	private function dados_exportacao() {
		$sql = "SELECT
				tpp.id_palestrante,
				tpp.foto,
				tpp.nome,
				tpp.curriculo,
				tpp.email,
				tpp.link,
				tpp.status,
				GROUP_CONCAT(DISTINCT tp.titulo ORDER BY tp.titulo SEPARATOR ', ') AS cursos
			FROM tbl_portalfarma_palestrantes tpp
			LEFT JOIN tbl_portalfarma_palestrantes_curso tppc
				ON tppc.id_palestrante = tpp.id_palestrante
			LEFT JOIN tbl_portalfarma tp
				ON tp.courseid = tppc.courseid
			GROUP BY tpp.id_palestrante
			ORDER BY tpp.nome ASC";

		return $this->db->query($sql)->result();
	}

	private function xml_excel($valor) {
		$valor = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', (string) $valor);
		return htmlspecialchars($valor, ENT_QUOTES | ENT_XML1, 'UTF-8');
	}

	public function exportar_excel() {
		$palestrantes = $this->dados_exportacao();
		$arquivo = 'palestrantes_' . date('Y-m-d_H-i-s') . '.xls';

		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment; filename="' . $arquivo . '"');
		header('Cache-Control: max-age=0, no-cache, must-revalidate');

		$colunas = ['ID', 'Foto', 'Nome', 'Currículo', 'E-mail', 'Lattes / Link', 'Cursos', 'Status'];
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<?mso-application progid="Excel.Sheet"?>';
		$xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" '
			. 'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';
		$xml .= '<Styles>'
			. '<Style ss:ID="Cabecalho"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#0468AA" ss:Pattern="Solid"/><Alignment ss:Vertical="Center"/></Style>'
			. '<Style ss:ID="Texto"><Alignment ss:Vertical="Top" ss:WrapText="1"/></Style>'
			. '<Style ss:ID="Icone"><Font ss:FontName="Segoe UI Emoji" ss:Size="14"/><Alignment ss:Horizontal="Center" ss:Vertical="Center"/></Style>'
			. '<Style ss:ID="Ativo"><Font ss:Color="#198754" ss:Bold="1"/><Alignment ss:Vertical="Top"/></Style>'
			. '<Style ss:ID="Inativo"><Font ss:Color="#DC3545" ss:Bold="1"/><Alignment ss:Vertical="Top"/></Style>'
			. '</Styles>';
		$xml .= '<Worksheet ss:Name="Palestrantes"><Table>';
		$larguras = [45, 210, 180, 360, 180, 220, 320, 80];
		foreach ($larguras as $largura) {
			$xml .= '<Column ss:Width="' . $largura . '"/>';
		}
		$xml .= '<Row ss:Height="24">';
		foreach ($colunas as $coluna) {
			$xml .= '<Cell ss:StyleID="Cabecalho"><Data ss:Type="String">' . $this->xml_excel($coluna) . '</Data></Cell>';
		}
		$xml .= '</Row>';

		foreach ($palestrantes as $palestrante) {
			$status = (int) $palestrante->status === 1 ? 'Ativo' : 'Inativo';
			$valores = [
				$palestrante->id_palestrante,
				!empty($palestrante->foto) ? '📷' : '⊘',
				$palestrante->nome ?: '',
				$palestrante->curriculo ?: '',
				$palestrante->email ?: '',
				$palestrante->link ?: '',
				$palestrante->cursos ?: '',
				$status
			];
			$xml .= '<Row>';
			foreach ($valores as $indice => $valor) {
				$tipo = $indice === 0 ? 'Number' : 'String';
				$estilo = $indice === 1 ? 'Icone' : ($indice === 7 ? ($status === 'Ativo' ? 'Ativo' : 'Inativo') : 'Texto');
				$xml .= '<Cell ss:StyleID="' . $estilo . '"><Data ss:Type="' . $tipo . '">' . $this->xml_excel($valor) . '</Data></Cell>';
			}
			$xml .= '</Row>';
		}

		$xml .= '</Table><WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel"><FreezePanes/><FrozenNoSplit/><SplitHorizontal>1</SplitHorizontal><TopRowBottomPane>1</TopRowBottomPane><AutoFilter x:Range="R1C1:R1C8" xmlns:x="urn:schemas-microsoft-com:office:excel"/></WorksheetOptions></Worksheet></Workbook>';
		echo $xml;
		exit;
	}

	public function exportar_pdf() {
		$palestrantes = $this->dados_exportacao();
		$esc = function($valor) {
			return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
		};
		$quebra = function($valor, $limite = 34) use ($esc) {
			return nl2br(wordwrap($esc($valor), $limite, "\n", true));
		};
		$totalAtivos = 0;
		foreach ($palestrantes as $palestrante) {
			if ((int) $palestrante->status === 1) {
				$totalAtivos++;
			}
		}
		$totalInativos = count($palestrantes) - $totalAtivos;

		$html = '<page orientation="L" format="A4" backtop="30mm" backbottom="14mm" backleft="8mm" backright="8mm">'
			. '<style>
				body { font-family: helvetica, sans-serif; color: #344054; }
				.header { width: 100%; border-collapse: collapse; }
				.header td { border: 0; vertical-align: middle; }
				.marca { color: #ffffff; background: #004761; padding: 9px 12px; font-size: 13pt; font-weight: bold; }
				.marca-subtitulo { color: #d7edf5; font-size: 7pt; font-weight: normal; }
				.data-geracao { color: #e9f5f8; font-size: 7pt; text-align: right; }
				.resumo { width: 100%; margin-top: 5px; border-collapse: separate; }
				.resumo td { padding: 5px 8px; border: 1px solid #d0d5dd; font-size: 8pt; vertical-align: middle; }
				.resumo-label { color: #667085; font-size: 6.5pt; text-transform: uppercase; }
				.resumo-valor { color: #101828; font-size: 11pt; font-weight: bold; }
				.resumo-ativo { color: #067647; }
				.resumo-inativo { color: #b42318; }
				.relatorio { width: 100%; border-collapse: collapse; table-layout: fixed; }
				.relatorio th { padding: 7px 4px; color: #ffffff; background: #004761; border: 1px solid #00394e; font-size: 7pt; font-weight: bold; text-transform: uppercase; vertical-align: middle; }
				.relatorio td { padding: 6px 4px; border: 1px solid #d0d5dd; font-size: 7pt; line-height: 1.35; vertical-align: top; }
				.linha-alternada { background: #f8fafc; }
				.id { color: #475467; text-align: center; font-weight: bold; }
				.nome { color: #101828; font-size: 7.5pt; font-weight: bold; }
				.ausente { color: #98a2b3; font-style: italic; }
				.foto { font-family: dejavusans; color: #004761; font-size: 13pt; text-align: center; }
				.foto-ausente { font-family: dejavusans; color: #98a2b3; font-size: 14pt; text-align: center; }
				.status { text-align: center; font-size: 6.5pt; font-weight: bold; }
				.status-ativo { color: #067647; background: #ecfdf3; }
				.status-inativo { color: #b42318; background: #fef3f2; }
				.footer { width: 100%; color: #667085; border-top: 1px solid #d0d5dd; font-size: 7pt; }
				.footer td { padding-top: 5px; border: 0; }
				.pagina { text-align: right; }
			</style>'
			. '<page_header><table class="header"><tr><td class="marca" style="width:70%">CRFMG<br><span class="marca-subtitulo">PortalFarma &nbsp;|&nbsp; Área restrita</span></td>'
			. '<td class="marca data-geracao" style="width:30%">RELATÓRIO DE PALESTRANTES<br>Gerado em ' . date('d/m/Y \à\s H:i') . '</td></tr></table>'
			. '<table class="resumo"><tr>'
			. '<td style="width:34%"><span class="resumo-label">Total de palestrantes</span><br><span class="resumo-valor">' . count($palestrantes) . '</span></td>'
			. '<td style="width:33%"><span class="resumo-label">Ativos</span><br><span class="resumo-valor resumo-ativo">' . $totalAtivos . '</span></td>'
			. '<td style="width:33%"><span class="resumo-label">Inativos</span><br><span class="resumo-valor resumo-inativo">' . $totalInativos . '</span></td>'
			. '</tr></table></page_header>'
			. '<page_footer><table class="footer"><tr><td>PortalFarma — Relatório administrativo</td><td class="pagina">Página [[page_cu]] de [[page_nb]]</td></tr></table></page_footer>'
			. '<table class="relatorio"><thead><tr>'
			. '<th style="width:4%">ID</th><th style="width:5%">Foto</th><th style="width:14%">Palestrante</th><th style="width:23%">Currículo</th>'
			. '<th style="width:13%">E-mail</th><th style="width:14%">Perfil / Lattes</th><th style="width:21%">Cursos vinculados</th><th style="width:6%">Status</th>'
			. '</tr></thead><tbody>';

		foreach ($palestrantes as $indice => $palestrante) {
			$statusAtivo = (int) $palestrante->status === 1;
			$possuiFoto = !empty($palestrante->foto);
			$html .= '<tr class="' . ($indice % 2 ? 'linha-alternada' : '') . '">'
				. '<td class="id">#' . (int) $palestrante->id_palestrante . '</td>'
				. '<td class="' . ($possuiFoto ? 'foto' : 'foto-ausente') . '">' . ($possuiFoto ? '&#128247;' : '&#8856;') . '</td>'
				. '<td class="nome">' . $quebra($palestrante->nome ?: 'Sem nome', 24) . '</td>'
				. '<td>' . ($palestrante->curriculo ? $quebra($palestrante->curriculo, 46) : '<span class="ausente">Não informado</span>') . '</td>'
				. '<td>' . ($palestrante->email ? $quebra($palestrante->email, 28) : '<span class="ausente">Não informado</span>') . '</td>'
				. '<td>' . ($palestrante->link ? $quebra($palestrante->link, 30) : '<span class="ausente">Não informado</span>') . '</td>'
				. '<td>' . ($palestrante->cursos ? $quebra($palestrante->cursos, 42) : '<span class="ausente">Sem curso vinculado</span>') . '</td>'
				. '<td class="status ' . ($statusAtivo ? 'status-ativo' : 'status-inativo') . '">' . ($statusAtivo ? 'ATIVO' : 'INATIVO') . '</td>'
				. '</tr>';
		}
		$html .= '</tbody></table></page>';

		try {
			$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'pt');
			$html2pdf->setDefaultFont('helvetica');
			$html2pdf->writeHTML($html);
			$html2pdf->output('palestrantes_' . date('Y-m-d_H-i-s') . '.pdf', 'D');
		} catch (\Throwable $e) {
			show_error('Não foi possível gerar o PDF: ' . $e->getMessage(), 500);
		}
	}

	public function reativar($id) {
		if (!$this->input->is_ajax_request() || $this->input->server('REQUEST_METHOD') !== 'POST') {
			show_404();
		}

		$id = (int) $id;
		if ($id <= 0) {
			echo json_encode(['status' => 'error', 'mensagem' => 'Palestrante inválido.']);
			return;
		}

		$reativado = $this->db
			->where('id_palestrante', $id)
			->where('status', 0)
			->update('tbl_portalfarma_palestrantes', ['status' => 1]);
		$reativado = $reativado && $this->db->affected_rows() > 0;

		header('Content-Type: application/json');
		echo json_encode($reativado
			? ['status' => 'success', 'mensagem' => 'Palestrante reativado com sucesso!']
			: ['status' => 'error', 'mensagem' => 'Não foi possível reativar o palestrante.']
		);
	}
	
}
