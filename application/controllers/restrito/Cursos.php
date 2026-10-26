<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cursos extends CI_Controller {
	private function prefixoCourseIdEspecial($tipoEvento) {
		$prefixos = [3 => 'URM', 4 => 'FH', 7 => 'SV'];
		return $prefixos[(int) $tipoEvento] ?? null;
	}

	private function calcularProximoCourseId($tipoEvento, $ano) {
		$prefixo = $this->prefixoCourseIdEspecial($tipoEvento);
		$ano = (int) $ano;
		if ($prefixo === null || $ano < 2000 || $ano > 2099) return null;

		$sufixoAno = substr((string) $ano, -2);
		$registros = $this->db->select('courseid')->from('tbl_portalfarma')->like('courseid', $prefixo, 'after')->get()->result();
		$maiorSequencia = 0;
		$expressao = '/^' . preg_quote($prefixo, '/') . '(\d{2})' . preg_quote($sufixoAno, '/') . '$/i';

		foreach ($registros as $registro) {
			if (preg_match($expressao, trim((string) $registro->courseid), $partes)) {
				$maiorSequencia = max($maiorSequencia, (int) $partes[1]);
			}
		}

		return $prefixo . str_pad((string) ($maiorSequencia + 1), 2, '0', STR_PAD_LEFT) . $sufixoAno;
	}

    public function __construct() {
        parent::__construct();
        require_once FCPATH . 'vendor/autoload.php';		
		$dados = array();
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
		
		// verifica se existe usuário logado
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
	
	public function cadastrar($contexto = null)
    {
		$this->dados['preenchimento_urm'] = strtolower((string) $contexto) === 'urm';
		if ($this->dados['preenchimento_urm']) {
			$this->dados['tipo_evento_padrao'] = 3;
			$this->dados['courseid_padrao'] = $this->capacifar_model->proximoCourseIdUrm();
		}
		// Lista de cursos cadastrados no Moodle (Portal do Aluno)
		$this->dados['cursos'] 	= $this->Moodle_api->lista_cursos();
	
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/curso_cadastrar',$this->dados);
		$this->load->view('restrito/fixo/rodape');
    }
	
	public function editar()
    {
		$id  = $this->uri->segment('4');
		
		$listar = "SELECT c.* FROM tbl_portalfarma c WHERE id = ".$id.";";
		
		$this->dados['tabela'] 	= $this->capacifar_model->query($listar);
		
		// Lista de cursos cadastrados no Moodle (Portal do Aluno)
		$this->dados['cursos'] 	= $this->Moodle_api->lista_cursos();
	
        $this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/curso_cadastrar',$this->dados);
		$this->load->view('restrito/fixo/rodape');
    }

    public function salvar()
	{
		header('Content-Type: application/json; charset=UTF-8');
		
		$error = "";
		$dados = $this->input->post();
		$imagemAlterada = !empty($_FILES['imagem']['name']);
		$camposAlterados = false;
		$courseIdUrmInformado = (int) ($dados['tipo_evento'] ?? 0) === 3
			&& trim((string) ($dados['courseid'] ?? '')) !== '';
		if (empty($dados['id']) && !$courseIdUrmInformado && $this->prefixoCourseIdEspecial($dados['tipo_evento'] ?? null) !== null) {
			$timestampInicio = strtotime((string) ($dados['data_inicio'] ?? ''));
			$anoEvento = $timestampInicio ? (int) date('Y', $timestampInicio) : 0;
			$courseIdAutomatico = $this->calcularProximoCourseId($dados['tipo_evento'], $anoEvento);
			if ($courseIdAutomatico === null) {
				echo json_encode(['status' => 'error', 'message' => 'Não foi possível gerar o CourseID para o evento.']);
				return;
			}
			$dados['courseid'] = $courseIdAutomatico;
		}
		
		//json_encode($dados);exit;

		if(empty($dados['tipo_evento']) || empty($dados['courseid']) || empty($dados['titulo']) || empty($dados['nome_curto']) || empty($dados['data_inicio']) || empty($dados['publico_alvo'])){
			echo json_encode([
				"status" => "error",
				"message" => "Preencha os campos obrigatórios."
			]);
			return;
		}

		$dados['topicos'] 		= $this->converter_para_lista($dados['topicos']);
		$dados['data_inicio'] 	= date('Y-m-d H:i:s', strtotime($dados['data_inicio']));

		// ----------------------
		// UPLOAD DA IMAGEM
		// ----------------------
		if ($imagemAlterada) {

			// O nome-base da imagem deve ser exatamente o mesmo valor salvo em nome_curto.
			$nome_curto = (string) $dados['nome_curto'];
			if (preg_match('/[\\x00-\\x1F\\x7F\\\\\/:*?"<>|]/u', $nome_curto)
				|| preg_match('/[. ]$/u', $nome_curto)) {
				echo json_encode([
					"status" => "error",
					"message" => "O Nome Curto possui caracteres que não podem ser usados no nome da imagem."
				]);
				return;
			}

			$config['upload_path']   = './uploads/cursos/';
			$config['allowed_types'] = 'jpg|jpeg|png|webp';
			$config['file_name']     = $nome_curto;
			$config['overwrite']     = TRUE;
			$config['remove_spaces'] = FALSE;

			$this->load->library('upload', $config);

			// VERIFICAÇÃO DA IMAGEM 
			if (!$this->upload->do_upload('imagem')) {

				echo json_encode([
					"status" => "error",
					"message" => $this->upload->display_errors()
				]);
				exit;

			} else {

				$upload_data = $this->upload->data();

				$caminho_original = $upload_data['full_path'];
				$ext = strtolower($upload_data['file_ext']);

				// caminho final sempre PNG
				$novo_arquivo = $upload_data['file_path'].$nome_curto.'.png';

				// Arquivos PNG já estão no formato final e não dependem da extensão GD.
				if ($ext !== '.png') {
					$funcaoLeitura = in_array($ext, ['.jpg', '.jpeg'], true)
						? 'imagecreatefromjpeg'
						: ($ext === '.webp' ? 'imagecreatefromwebp' : null);

					if (!$funcaoLeitura || !function_exists($funcaoLeitura) || !function_exists('imagepng')) {
						echo json_encode([
							"status" => "error",
							"message" => "Envie a imagem no formato PNG. A conversão de JPG/WEBP não está disponível no servidor."
						]);
						return;
					}

					$imagem = $funcaoLeitura($caminho_original);
					if (!$imagem || !imagepng($imagem, $novo_arquivo)) {
						if ($imagem) imagedestroy($imagem);
						echo json_encode([
							"status" => "error",
							"message" => "Não foi possível processar a imagem enviada."
						]);
						return;
					}

					imagedestroy($imagem);
					if ($caminho_original !== $novo_arquivo) unlink($caminho_original);
				}
			}
		}// FIM UPLOAD DA IMAGEM
		
		
		$edicao = !empty($dados['id']);
		$dbDebugOriginal = $this->db->db_debug;
		$this->db->db_debug = false;
		if ($edicao){
			$id 	= $dados['id'];	
			$registroAtual = $this->db->where('id', $id)->get('tbl_portalfarma')->row_array();
			foreach ($dados as $campo => $valor) {
				if ($campo !== 'id' && array_key_exists($campo, (array) $registroAtual) && (string) $registroAtual[$campo] !== (string) $valor) {
					$camposAlterados = true;
					break;
				}
			}
			$salvou = $this->capacifar_model->updatecurso( $dados, $id);
		}else{
			$salvou = $this->capacifar_model->inserircurso($dados);
			$id = $salvou ? (int) $salvou : 0;
		}
		$erroBanco = $this->db->error();
		$this->db->db_debug = $dbDebugOriginal;
		
		// verifica status
		if($salvou){
			$aviso = null;
			try {
				$this->load->helper('auditoria');
				if (!registrar_historico($edicao ? 2 : 1, $id, $aviso) && !$aviso) {
					$aviso = 'Não foi possível registrar o histórico. Consulte o log do servidor.';
				}
			} catch (\Throwable $e) {
				log_message('error', 'Curso #' . $id . ' salvo, mas a auditoria falhou: ' . $e->getMessage());
				$aviso = 'Não foi possível registrar o histórico. Consulte o log do servidor.';
			}
			$mensagem = $edicao ? "Curso editado com sucesso!" : "Curso salvo com sucesso!";
			echo json_encode([
				"status" => "success",
				"message" => $mensagem,
				"id" => (int) $id,
				"warning" => $aviso ? 'Erro no histórico de auditoria: ' . $aviso : null
			]);
			return;
			
		} else {
		
			$detalheErro = trim((string) ($erroBanco['message'] ?? ''));
			if ($detalheErro !== '') {
				log_message('error', 'Erro ao salvar curso: ' . $detalheErro);
			}
			echo json_encode([
				"status" => "error",
				"message" => "Não foi possível salvar o curso."
			]);
			exit;
		}
	}
	
	public function alterar_status(){

		$id = $this->input->post('id');
		$status = $this->input->post('status');

		$novo_status = ($status == 1) ? 0 : 1;

		$salvou = $this->capacifar_model->updatecurso([
			'status'=>$novo_status
		],$id);

		if($salvou){
			// O histórico é secundário e não compõe o retorno da alteração de status.
			registrar_historico($novo_status === 1 ? 19 : 20, $id);

			echo json_encode([
				"success"=>true,
				"status"=>$novo_status,
				"message"=>"Status alterado com sucesso."
			]);

		}else{

			echo json_encode([
				"success"=>false,
				"message"=>"Erro ao alterar status."
			]);

		}

	}
	
	public function categorias()
    {
	
		$listar 		= "SELECT c.* FROM tbl_categorias_portalfarma c;";
		$qry_vinculados = "SELECT
								ce.id,
								ce.courseid,
								ce.principal,
								pf.titulo AS nome_curso,
								pf.tipo_evento,
								pf.status,
								cp.descricao AS categoria,
								cp.icon
							FROM tbl_categoria_eventos ce
							INNER JOIN tbl_portalfarma pf ON ce.courseid = pf.courseid
							INNER JOIN tbl_categorias_portalfarma cp ON ce.id_categoria = cp.id
							ORDER BY pf.titulo ASC, ce.principal DESC, cp.descricao ASC";

		$this->dados['tabela'] = $this->capacifar_model->query($listar);
		$vinculos = $this->capacifar_model->query($qry_vinculados);
		$cursosVinculados = [];
		foreach ($vinculos as $vinculo) {
			$courseid = (string) $vinculo->courseid;
			if (!isset($cursosVinculados[$courseid])) {
				$cursosVinculados[$courseid] = [
					'courseid' => $courseid,
					'nome_curso' => $vinculo->nome_curso,
					'tipo_evento' => (int) $vinculo->tipo_evento,
					'status' => (int) $vinculo->status,
					'principal' => null,
					'outras' => []
				];
			}

			$categoria = [
				'id' => (int) $vinculo->id,
				'nome' => $vinculo->categoria,
				'icon' => $vinculo->icon
			];
			if ((int) $vinculo->principal === 1) {
				$cursosVinculados[$courseid]['principal'] = $categoria;
			} else {
				$cursosVinculados[$courseid]['outras'][] = $categoria;
			}
		}
		$this->dados['vinculados'] = array_values($cursosVinculados);
		
        $this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/categorias', $this->dados);
		$this->load->view('restrito/fixo/rodape');
    }

	public function proximo_courseid() {
		$tipoEvento = (int) $this->input->get('tipo_evento');
		$ano = (int) $this->input->get('ano');
		$courseid = $this->calcularProximoCourseId($tipoEvento, $ano);

		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($courseid !== null
			? ['status' => 'success', 'courseid' => $courseid]
			: ['status' => 'error', 'message' => 'Tipo de evento ou ano inválido.']
		);
	}

	public function historico($id = null)
	{
		header('Content-Type: application/json; charset=UTF-8');
		$id = (int) $id;

		if ($id <= 0) {
			echo json_encode(['status' => 'error', 'message' => 'Curso inválido.', 'historico' => []]);
			return;
		}

		$cursoExiste = $this->db->where('id', $id)->count_all_results('tbl_portalfarma') > 0;
		if (!$cursoExiste) {
			echo json_encode(['status' => 'error', 'message' => 'Curso não encontrado.', 'historico' => []]);
			return;
		}

		$historico = $this->db
			->select('h.id, h.data_hora, a.descricao AS acao, u.user AS usuario')
			->from('tbl_portalfarma_historico h')
			->join('tbl_portalfarma_auditoria_acoes a', 'a.id = h.id_acao', 'inner')
			->join('tbl_portalfarma_user u', 'u.id = h.id_usuario', 'left')
			->where('h.id_registro', $id)
			->where_in('h.id_acao', [1, 2, 19, 20])
			->order_by('h.data_hora', 'DESC')
			->order_by('h.id', 'DESC')
			->get()
			->result();

		foreach ($historico as $registro) {
			$registro->data_formatada = date('d/m/Y H:i:s', strtotime($registro->data_hora));
			unset($registro->data_hora);
			$registro->usuario = $registro->usuario ?: 'Usuário não localizado';
		}

		echo json_encode(['status' => 'success', 'historico' => $historico]);
	}

	public function buscar_titulos() {
		$termo = trim((string) $this->input->get('q', true));
		$idAtual = (int) $this->input->get('id');

		header('Content-Type: application/json; charset=UTF-8');
		if (mb_strlen($termo, 'UTF-8') < 3) {
			echo json_encode([]);
			return;
		}

		$this->db
			->select('id, courseid, titulo, data_inicio, status')
			->from('tbl_portalfarma')
			->group_start()
				->like('titulo', $termo)
				->or_like('nome_curto', $termo);

		$palavras = array_slice(array_values(array_filter(preg_split('/\s+/u', $termo), function ($palavra) {
			return mb_strlen($palavra, 'UTF-8') >= 2;
		})), 0, 6);
		if (count($palavras) > 1) {
			$this->db->or_group_start();
			foreach ($palavras as $palavra) {
				$this->db->like('titulo', $palavra);
			}
			$this->db->group_end();
		}
		$this->db->group_end();

		if ($idAtual > 0) {
			$this->db->where('id !=', $idAtual);
		}

		$cursosSemelhantes = $this->db
			->order_by('titulo', 'ASC')
			->limit(6)
			->get()
			->result();

		echo json_encode($cursosSemelhantes, JSON_UNESCAPED_UNICODE);
	}

	private function dados_exportacao_categorias() {
		$categorias = $this->db
			->select('id, descricao, icon')
			->from('tbl_categorias_portalfarma')
			->order_by('descricao', 'ASC')
			->get()
			->result();

		$vinculos = $this->db
			->select('ce.id, pf.courseid, pf.titulo AS nome_curso, cp.id AS categoria_id, cp.descricao AS categoria, ce.principal, cp.icon')
			->from('tbl_categoria_eventos ce')
			->join('tbl_portalfarma pf', 'pf.courseid = ce.courseid')
			->join('tbl_categorias_portalfarma cp', 'cp.id = ce.id_categoria')
			->order_by('pf.titulo', 'ASC')
			->order_by('ce.principal', 'DESC')
			->order_by('cp.descricao', 'ASC')
			->get()
			->result();

		return ['categorias' => $categorias, 'vinculos' => $vinculos];
	}

	private function xml_exportacao_categorias($valor) {
		$valor = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', (string) $valor);
		return htmlspecialchars($valor, ENT_QUOTES | ENT_XML1, 'UTF-8');
	}

	public function categorias_exportar_excel() {
		$dados = $this->dados_exportacao_categorias();
		$arquivo = 'categorias_' . date('Y-m-d_H-i-s') . '.xls';

		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment; filename="' . $arquivo . '"');
		header('Cache-Control: max-age=0, no-cache, must-revalidate');

		$xml = '<?xml version="1.0" encoding="UTF-8"?>'
			. '<?mso-application progid="Excel.Sheet"?>'
			. '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
			. '<Styles>'
			. '<Style ss:ID="Cabecalho"><Font ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#054589" ss:Pattern="Solid"/><Alignment ss:Vertical="Center"/></Style>'
			. '<Style ss:ID="Texto"><Alignment ss:Vertical="Top" ss:WrapText="1"/></Style>'
			. '</Styles>';

		$xml .= '<Worksheet ss:Name="Categorias"><Table>'
			. '<Column ss:Width="55"/><Column ss:Width="220"/><Column ss:Width="220"/>'
			. '<Row ss:Height="24"><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">ID</Data></Cell><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Categoria</Data></Cell><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Ícone</Data></Cell></Row>';
		foreach ($dados['categorias'] as $categoria) {
			$xml .= '<Row>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="Number">' . (int) $categoria->id . '</Data></Cell>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="String">' . $this->xml_exportacao_categorias($categoria->descricao) . '</Data></Cell>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="String">' . $this->xml_exportacao_categorias($categoria->icon) . '</Data></Cell>'
				. '</Row>';
		}
		$xml .= '</Table></Worksheet>';

		$xml .= '<Worksheet ss:Name="Cursos vinculados"><Table>'
			. '<Column ss:Width="55"/><Column ss:Width="75"/><Column ss:Width="350"/><Column ss:Width="75"/><Column ss:Width="220"/><Column ss:Width="80"/><Column ss:Width="200"/>'
			. '<Row ss:Height="24"><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Vínculo ID</Data></Cell><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Curso ID</Data></Cell><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Curso</Data></Cell><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Categoria ID</Data></Cell><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Categoria</Data></Cell><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Principal</Data></Cell><Cell ss:StyleID="Cabecalho"><Data ss:Type="String">Ícone</Data></Cell></Row>';
		foreach ($dados['vinculos'] as $vinculo) {
			$xml .= '<Row>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="Number">' . (int) $vinculo->id . '</Data></Cell>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="Number">' . (int) $vinculo->courseid . '</Data></Cell>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="String">' . $this->xml_exportacao_categorias($vinculo->nome_curso) . '</Data></Cell>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="Number">' . (int) $vinculo->categoria_id . '</Data></Cell>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="String">' . $this->xml_exportacao_categorias($vinculo->categoria) . '</Data></Cell>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="String">' . ((int) $vinculo->principal === 1 ? 'Sim' : 'Não') . '</Data></Cell>'
				. '<Cell ss:StyleID="Texto"><Data ss:Type="String">' . $this->xml_exportacao_categorias($vinculo->icon) . '</Data></Cell>'
				. '</Row>';
		}
		$xml .= '</Table></Worksheet></Workbook>';

		echo $xml;
		exit;
	}

	public function categorias_exportar_pdf() {
		$dados = $this->dados_exportacao_categorias();
		$esc = function($valor) {
			return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
		};
		$mapaCores = [
			'Alimentos' => ['#f97316', '#ffffff'],
			'Análises Clínicas' => ['#9333ea', '#ffffff'],
			'Clínica' => ['#ef4444', '#ffffff'],
			'Educação' => ['#10b981', '#ffffff'],
			'Farmácia' => ['#0ea5e9', '#ffffff'],
			'Gestão' => ['#facc15', '#422006'],
			'Hospitalar' => ['#8b5cf6', '#ffffff'],
			'Industrial' => ['#f43f5e', '#ffffff'],
			'Magistral' => ['#8b5cf6', '#ffffff'],
			'PICs' => ['#22c55e', '#ffffff'],
			'Saúde Pública' => ['#14b8a6', '#ffffff'],
			'Toxicologia' => ['#f97316', '#ffffff'],
			'Outros' => ['#475569', '#ffffff']
		];
		$cursosVinculados = [];
		foreach ($dados['vinculos'] as $vinculo) {
			$courseid = (int) $vinculo->courseid;
			if (!isset($cursosVinculados[$courseid])) {
				$cursosVinculados[$courseid] = [
					'titulo' => $vinculo->nome_curso,
					'categorias' => []
				];
			}
			$cursosVinculados[$courseid]['categorias'][] = $vinculo;
		}

		$html = '<page orientation="L" format="A4" backtop="12mm" backbottom="12mm" backleft="10mm" backright="10mm">'
			. '<style>
				body { font-family: helvetica, sans-serif; color: #263238; }
				h1 { color: #054589; font-size: 17pt; margin: 0 0 3px; }
				h2 { color: #054589; font-size: 12pt; margin: 14px 0 6px; }
				.resumo { color: #607d8b; font-size: 8pt; margin-bottom: 8px; }
				table { width: 100%; border-collapse: collapse; }
				th { background: #054589; color: #fff; padding: 5px; border: 1px solid #04396f; font-size: 7pt; text-transform: uppercase; }
				td { padding: 5px; border: 1px solid #cfd8dc; font-size: 7pt; vertical-align: top; }
				.par { background: #f5f8fa; }
				.cursos-vinculados td { border-left: none; border-right: none; }
				.curso-info td { padding-top: 7px; padding-bottom: 4px; border-bottom: none; font-size: 8pt; }
				.curso-categorias td { padding-top: 3px; padding-bottom: 8px; border-top: none; }
				.curso-id { color: #607d8b; text-align: center; }
				.categoria-badge { display: inline-block; border-radius: 5px; padding: 5px 8px; margin: 3px; font-size: 6.5pt; font-weight: bold; }
			</style>'
			. '<h1>Relatório de Categorias</h1>'
			. '<div class="resumo">Gerado em ' . date('d/m/Y H:i') . ' — ' . count($dados['categorias']) . ' categorias e ' . count($dados['vinculos']) . ' vínculos</div>'
			. '<h2>Categorias cadastradas</h2>'
			. '<table><thead><tr><th style="width:10%">ID</th><th style="width:45%">Categoria</th><th style="width:45%">Ícone</th></tr></thead><tbody>';
		foreach ($dados['categorias'] as $indice => $categoria) {
			$html .= '<tr class="' . ($indice % 2 ? 'par' : '') . '"><td>' . (int) $categoria->id . '</td><td>' . $esc($categoria->descricao) . '</td><td>' . $esc($categoria->icon) . '</td></tr>';
		}
		$html .= '</tbody></table><h2>Cursos vinculados</h2>'
			. '<table class="cursos-vinculados"><tbody>';
		foreach ($cursosVinculados as $courseid => $cursoVinculado) {
			$html .= '<tr class="curso-info">'
				. '<td class="curso-id" style="width:10%">' . $courseid . '</td>'
				. '<td style="width:90%">' . $esc($cursoVinculado['titulo']) . '</td>'
				. '</tr><tr class="curso-categorias"><td></td><td>';

			foreach ($cursoVinculado['categorias'] as $categoriaVinculada) {
				$cores = $mapaCores[$categoriaVinculada->categoria] ?? ['#475569', '#ffffff'];
				$html .= '<span class="categoria-badge" style="background-color:' . $cores[0] . ';color:' . $cores[1] . '">'
					. $esc($categoriaVinculada->categoria)
					. '</span> ';
			}
			$html .= '</td></tr>';
		}
		$html .= '</tbody></table></page>';

		try {
			$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('L', 'A4', 'pt');
			$html2pdf->setDefaultFont('helvetica');
			$html2pdf->writeHTML($html);
			$html2pdf->output('categorias_' . date('Y-m-d_H-i-s') . '.pdf', 'D');
		} catch (\Throwable $e) {
			show_error('Não foi possível gerar o PDF: ' . $e->getMessage(), 500);
		}
	}
	
	public function categorias_curso(){
		
		$qry_categorias = "SELECT * FROM tbl_categorias_portalfarma;";
		$qry_cursos = "SELECT tp.courseid, tp.titulo FROM web_site.tbl_portalfarma AS tp;";
		
		$this->dados['categorias'] 	= $this->capacifar_model->query($qry_categorias);
        $this->dados['cursos'] 		= $this->capacifar_model->query($qry_cursos);

        $this->load->view('restrito/fixo/cabecalho', $this->dados);
		$this->load->view('restrito/categorias_vincular', $this->dados);
		$this->load->view('restrito/fixo/rodape', $this->dados);
		
	}
	
	public function categorias_vincular()
    {
			$courseid = (int) $this->input->post('courseid');
			$categoriaPrincipal = (int) $this->input->post('categoria_principal');
			$categorias = $this->input->post('categorias');

			if (!$courseid || !$categoriaPrincipal || empty($categorias)) {
				redirect('restrito/cursos/categorias_curso?' . http_build_query([
					'retorno_categorias' => 'erro',
					'mensagem' => 'Selecione o curso, a categoria principal e pelo menos uma categoria complementar.'
				]));
				return;
			}

			$categorias = array_values(array_unique(array_filter(array_map('intval', $categorias))));
			$categorias = array_values(array_diff($categorias, [$categoriaPrincipal]));

			if (count($categorias) > 2) {
				redirect('restrito/cursos/categorias_curso?' . http_build_query([
					'retorno_categorias' => 'erro',
					'mensagem' => 'Você só pode selecionar até 2 categorias complementares.'
				]));
				return;
			}

			$idsCategorias = array_merge([$categoriaPrincipal], $categorias);
			$registrosCategorias = $this->db
				->select('id, descricao')
				->where_in('id', $idsCategorias)
				->get('tbl_categorias_portalfarma')
				->result();
			$nomesCategorias = [];
			foreach ($registrosCategorias as $registroCategoria) {
				$nomesCategorias[(int) $registroCategoria->id] = $registroCategoria->descricao;
			}
			$nomePrincipal = $nomesCategorias[$categoriaPrincipal] ?? 'Categoria #' . $categoriaPrincipal;
			$nomesSecundarias = array_map(function ($idCategoria) use ($nomesCategorias) {
				return $nomesCategorias[$idCategoria] ?? 'Categoria #' . $idCategoria;
			}, $categorias);

			$jaPossuiaVinculos = $this->db->where('courseid', $courseid)->count_all_results('tbl_categoria_eventos') > 0;
			$idsVinculos = [];
			$this->db->trans_start();
			$this->db->delete('tbl_categoria_eventos', ['courseid' => $courseid]);
			$this->db->insert('tbl_categoria_eventos', [
				'courseid' => $courseid,
				'id_categoria' => $categoriaPrincipal,
				'principal' => 1
			]);
			$idsVinculos[] = (int) $this->db->insert_id();

			foreach ($categorias as $id) {
				$this->db->insert('tbl_categoria_eventos', [
					'courseid' => $courseid,
					'id_categoria' => $id,
					'principal' => 0
				]);
				$idsVinculos[] = (int) $this->db->insert_id();
			}
			
			$this->db->trans_complete(); // finaliza transação

			// verifica status
			if ($this->db->trans_status() === FALSE) {
				$parametrosRetorno = [
					'retorno_categorias' => 'erro',
					'mensagem' => 'Erro ao salvar no banco.'
				];
			} else {
				foreach ($idsVinculos as $idVinculo) {
					registrar_historico($jaPossuiaVinculos ? 4 : 3, $idVinculo);
				}
				$parametrosRetorno = [
					'retorno_categorias' => 'sucesso',
					'principal' => $nomePrincipal,
					'secundarias' => implode(', ', $nomesSecundarias)
				];
			}
			
			
			redirect('restrito/cursos/categorias_curso?' . http_build_query($parametrosRetorno));
    }

	public function categorias_curso_listar()
	{
		$courseid = $this->input->post('courseid');

		if (empty($courseid)) {
			echo json_encode([
				'status' => 'erro',
				'mensagem' => 'Curso não informado.',
				'categorias' => []
			]);
			return;
		}

		$this->db->select('ce.id AS vinculo_id, ce.id_categoria, ce.principal, cp.descricao, cp.icon');
		$this->db->from('tbl_categoria_eventos ce');
		$this->db->join('tbl_categorias_portalfarma cp', 'cp.id = ce.id_categoria');
		$this->db->where('ce.courseid', $courseid);
		$this->db->order_by('ce.principal', 'DESC');
		$this->db->order_by('cp.descricao', 'ASC');
		$categorias = $this->db->get()->result();

		echo json_encode([
			'status' => 'ok',
			'categorias' => $categorias
		]);
	}

	public function categoria_curso_excluir()
	{
		$vinculoId = (int) $this->input->post('id');

		if (empty($vinculoId)) {
			echo json_encode([
				'status' => 'erro',
				'mensagem' => 'Vínculo não informado.'
			]);
			return;
		}

		$removido = $this->db->delete('tbl_categoria_eventos', ['id' => $vinculoId]);

		echo json_encode([
			'status' => $removido ? 'ok' : 'erro',
			'mensagem' => $removido ? 'Categoria removida.' : 'Não foi possível remover a categoria.'
		]);
	}
	
	public function para()
	{
		$this->db->select('pp.courseid, pp.idpara, pf.titulo AS nome_curso');
		$this->db->from('tbl_portalfarma_para pp');
		$this->db->join('tbl_portalfarma pf', 'pf.courseid = pp.courseid', 'left');
		$this->db->order_by('pf.titulo', 'ASC');
		$vinculos = $this->db->get()->result();
		$cursos = [];
		foreach ($vinculos as $vinculo) {
			$courseid = (string) $vinculo->courseid;
			if (!isset($cursos[$courseid])) {
				$cursos[$courseid] = [
					'courseid' => $courseid,
					'nome_curso' => $vinculo->nome_curso,
					'publicos' => []
				];
			}
			$cursos[$courseid]['publicos'][] = (int) $vinculo->idpara;
		}
		$this->dados['tabela'] = array_values($cursos);
		$this->load->view('restrito/fixo/cabecalho', $this->dados);
		$this->load->view('restrito/para_listar', $this->dados);
		$this->load->view('restrito/fixo/rodape', $this->dados);
	}

	public function para_curso()
	{
		$this->dados['cursos'] = $this->db->select('courseid, titulo')->from('tbl_portalfarma')->order_by('titulo', 'ASC')->get()->result();
		$this->load->view('restrito/fixo/cabecalho', $this->dados);
		$this->load->view('restrito/para_vincular', $this->dados);
		$this->load->view('restrito/fixo/rodape', $this->dados);
	}

	public function para_vincular()
	{
		$courseid = trim((string) $this->input->post('courseid', true));
		$publicos = $this->input->post('para');
		$publicos = is_array($publicos)
			? array_values(array_unique(array_map('intval', $publicos)))
			: [];
		$opcoes = [1 => 'Para Farmacêutico', 2 => 'Para Empresa', 3 => 'Para Sociedade'];
		$publicosInvalidos = array_filter($publicos, function ($idpara) use ($opcoes) {
			return !isset($opcoes[$idpara]);
		});
		if ($courseid === '' || empty($publicos) || !empty($publicosInvalidos)) {
			redirect('restrito/cursos/para_curso?' . http_build_query(['retorno_para' => 'erro', 'mensagem' => 'Selecione o curso e pelo menos uma das opções disponíveis.']));
			return;
		}
		if ($this->db->where('courseid', $courseid)->count_all_results('tbl_portalfarma') === 0) {
			redirect('restrito/cursos/para_curso?' . http_build_query(['retorno_para' => 'erro', 'mensagem' => 'O curso informado não foi encontrado.']));
			return;
		}
		$this->db->trans_start();
		$this->db->delete('tbl_portalfarma_para', ['courseid' => $courseid]);
		foreach ($publicos as $idpara) {
			$this->db->insert('tbl_portalfarma_para', ['courseid' => $courseid, 'idpara' => $idpara]);
		}
		$this->db->trans_complete();
		$sucesso = $this->db->trans_status() !== FALSE;
		$nomesPublicos = array_map(function ($idpara) use ($opcoes) {
			return $opcoes[$idpara];
		}, $publicos);
		redirect('restrito/cursos/para_curso?' . http_build_query([
			'retorno_para' => $sucesso ? 'sucesso' : 'erro',
			'mensagem' => $sucesso ? 'Curso vinculado a: ' . implode(', ', $nomesPublicos) . '.' : 'Não foi possível salvar o vínculo no banco.'
		]));
	}

	public function para_curso_listar()
	{
		$courseid = trim((string) $this->input->post('courseid', true));
		if ($courseid === '') {
			echo json_encode(['status' => 'erro', 'mensagem' => 'Curso não informado.']);
			return;
		}
		$vinculos = $this->db->select('idpara')->where('courseid', $courseid)->get('tbl_portalfarma_para')->result();
		$publicos = array_map(function ($vinculo) {
			return (int) $vinculo->idpara;
		}, $vinculos);
		echo json_encode(['status' => 'ok', 'publicos' => $publicos]);
	}

	/* LISTAS TODOS INSCRITOS DO CURSO */
	public function lista_inscritos() {
		$id_curso  = $this->uri->segment('4');
		
		// Captura o parâmetro da URL (padrão 'portrait' se não vier nada)
		$orientacao = ($this->input->get('orientacao') === 'portrait') ? 'P' : 'L';		
		
		// 1. Busca dados do curso
		$listar = "SELECT c.* FROM tbl_portalfarma c WHERE courseid = '".$id_curso."';";
		$curso 	= $this->capacifar_model->query($listar);
		//$curso = $this->db->get_where('tbl_portalfarma', ['id' => $id_curso])->row();
		// Pegando o tipo de evento 
			if (!empty($curso) && is_array($curso)) {
				// Pega o primeiro objeto do array
				$obj = $curso[0];

				// Verifica se é um objeto e se tem a propriedade
				if (is_object($obj) && isset($obj->tipo_evento)) {
					$tipoEvento = $obj->tipo_evento;
				}
			}
			
		
		// 2.1 Busca inscritos
		if($tipoEvento == '1' || $tipoEvento == '2' || $tipoEvento == '5'){/* CAPACIFAR */
		
			$inscritos 	= $this->Moodle_api->lista_inscritos_cursos($id_curso);
		
		} elseif ($tipoEvento == '3') {/* URM */
		
			$sql = "SELECT i.nome, i.cpf, 'presencial' as modalidade, i.instituicao AS ocupacao FROM urm_inscricao i WHERE i.urm_evento = '".$id_curso."' ORDER BY i.nome;";
				$inscritos 	= $this->capacifar_model->query($sql);
		} elseif ($tipoEvento == '4') {/* FISCALIZAÇÃO HUMANIZADA */
		
			$sql = "SELECT f.nome, f.cpf, f.municipio as modalidade, f.local_trabalho AS ocupacao FROM fiscalizacao_humanizada_inscricao f WHERE f.id_evento = '".$id_curso."' ORDER BY f.nome;";
				$inscritos 	= $this->capacifar_model->query($sql);
		} elseif ($tipoEvento == '7') { /* SEMINÁRIOS */
		
			$sql = "SELECT 
						s.nome,
						s.cpf,
						s.tipo_participacao as modalidade,
						CASE s.ocupacao
							WHEN 2 THEN 'Farmacêutico de outras áreas'
							WHEN 3 THEN 'Fiscal da Vigilância Sanitária Municipal'
							WHEN 4 THEN 'Fiscal da Vigilância Sanitária Estadual'
							WHEN 5 THEN 'Fiscal do CRF/MG'
							WHEN 7 THEN 'Estudante'
							WHEN 8 THEN 'Outros profissionais'
							WHEN 9 THEN 'Fiscal de Conselho Profissional'
							ELSE 'Não informado'
						END AS ocupacao FROM tbl_seminario_inscricao s 
						WHERE s.seminario = '".$id_curso."' AND tipo_participacao = 'presencial'
						ORDER BY s.nome;";
				$inscritos 	= $this->capacifar_model->query($sql);
		}
		
		// 2.2 Busca Palestrantes
		$palestrantes = $this->db->select('p.id_palestrante, p.nome')
			->from('tbl_portalfarma_palestrantes p')
			->join('tbl_portalfarma_palestrantes_curso pc', 'pc.id_palestrante = p.id_palestrante', 'inner')
			->where('pc.courseid', $id_curso) 
			->order_by('p.nome', 'ASC')
			->get()
			->result();

		if (!$curso) show_404();
		
		$path = 'https://www.crfmg.org.br/portalfarma/uploads/cursos/sv_0042026.png';
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

		// 3. Carrega a biblioteca e gera o HTML
		$html = $this->load->view('restrito/pdfs/lista_presenca_pdf', [
			'curso' => $curso,
			'inscritos' => $inscritos,
			'palestrantes' => $palestrantes,
			'orientacao' => $orientacao,
			'imagem' => $data
		], TRUE);

		try {
			// Html2Pdf soma as margens padrão às margens da tag <page>.
			// Em paisagem, os 8 mm à direita são definidos integralmente na view.
			$margens = $orientacao === 'L' ? [5, 5, 0, 8] : [5, 5, 5, 8];
			$html2pdf = new \Spipu\Html2Pdf\Html2Pdf($orientacao, 'A4', 'pt', true, 'UTF-8', $margens);
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($html);
			$html2pdf->output('Lista_Presenca_'.$id_curso.'.pdf');
		} catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
			die($e->getMessage());
		}
	}
	
	public function lista_presenca() {
		$id_curso  = $this->uri->segment('4');
		
		//print_r($id_curso);
		
		// 1. Busca dados do curso
		$listar = "SELECT c.* FROM tbl_portalfarma c WHERE courseid = '".$id_curso."';";
		$curso 	= $this->capacifar_model->query($listar);
		
		// Pegando o tipo de evento 
			if (!empty($curso) && is_array($curso)) {
				// Pega o primeiro objeto do array
				$obj = $curso[0];

				// Verifica se é um objeto e se tem a propriedade
				if (is_object($obj) && isset($obj->tipo_evento)) {
					$tipoEvento = $obj->tipo_evento;
				}
			}
			
		
		// 2.1 Busca inscritos
		if($tipoEvento == '1' || $tipoEvento == '2' || $tipoEvento == '5'){/* CAPACIFAR */
		
			$inscritos 	= $this->Moodle_api->lista_inscritos_cursos($id_curso);
		
		} elseif ($tipoEvento == '3') {/* URM */
		
			$sql = "SELECT i.id, i.nome, i.cpf, i.email, 'presencial' as modalidade, i.instituicao AS ocupacao FROM urm_inscricao i WHERE i.urm_evento = '".$id_curso."' ORDER BY i.nome;";
				$inscritos 	= $this->capacifar_model->query($sql);
		} elseif ($tipoEvento == '4') {/* FISCALIZAÇÃO HUMANIZADA */
		
			$sql = "SELECT f.id, f.nome, f.cpf, f.email, f.municipio as modalidade, f.local_trabalho AS ocupacao FROM fiscalizacao_humanizada_inscricao f WHERE f.id_evento = '".$id_curso."' ORDER BY f.nome;";
				$inscritos 	= $this->capacifar_model->query($sql);
		} elseif ($tipoEvento == '7') { /* SEMINÁRIOS */
		
			$sql = "SELECT 
						s.id,
						s.nome,
						s.cpf,
						s.tipo_participacao as modalidade,
						s.email,
						CASE s.ocupacao
							WHEN 2 THEN 'Farmacêutico de outras áreas'
							WHEN 3 THEN 'Fiscal da Vigilância Sanitária Municipal'
							WHEN 4 THEN 'Fiscal da Vigilância Sanitária Estadual'
							WHEN 5 THEN 'Fiscal do CRF/MG'
							WHEN 7 THEN 'Estudante'
							WHEN 8 THEN 'Outros profissionais'
							WHEN 9 THEN 'Fiscal de Conselho Profissional'
							ELSE 'Não informado'
						END AS ocupacao FROM tbl_seminario_inscricao s 
						WHERE s.seminario = '".$id_curso."'
						ORDER BY s.nome;";
				$inscritos 	= $this->capacifar_model->query($sql);
		}
		
		$this->dados = [
			'curso' => $curso,
			'inscritos' => $inscritos
		];
		
		$this->load->view('restrito/fixo/cabecalho', $this->dados);
		$this->load->view('restrito/lista_presenca', $this->dados);
		$this->load->view('restrito/fixo/rodape', $this->dados);
		
	}
	
	public function atualizar_presenca() {
		$ids 		= $this->input->post('ids');
		$tabela 	= $this->input->post('tabela');
		$courseid 	= $this->input->post('courseid');
		
		if (!empty($ids) && is_array($ids)) {
			
			foreach ($ids as $id) {
				// Chama o model para dar update no status para 1
				$this->capacifar_model->marcar_presenca($id, $courseid, $tabela);
			}

			echo json_encode([
				'status' => 'success',
				'message' => count($ids) . ' presenças confirmadas com sucesso!'
			]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Nenhum dado recebido.']);
		}
	}
	
	
	public function categoria_excluir($id) {
		if ($this->db->delete('tbl_categoria_eventos', array('id' => $id))) {
			$this->session->set_flashdata('type', 'success');
			$this->session->set_flashdata('message', 'Vínculo excluído com sucesso!');
		} else {
			$this->session->set_flashdata('type', 'danger');
			$this->session->set_flashdata('message', 'Erro ao excluir vínculo.');
		}
		redirect('restrito/cursos/categorias');
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
