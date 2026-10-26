<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ACESSO RESTRITO / LOGIN

class Urm extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		
		$this->dados 	= array();
		$dados 			= array();
		$programacoes 	= array();
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->dados['menu_ativo'] = "inicio";
		
		
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

	public function index()
	{
		$this->load->view('login');	
	}
	
	public function listar() {
	
		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$url_filtro = $this->uri->segment('4');
		
		//echo $url_filtro; //exit;
		
		
		if ($url_filtro == 'ativos'){
			$filtro = 'tpf.status = 1';
		} elseif ($url_filtro == 'inativos') {
			$filtro = 'tpf.status = 0';
		} else {
			$filtro = 'tpf.status in (0,1)';
		}
		//$arrayDados['tabelaCategoria'] 	= $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.tipo_evento = 3 AND '.$filtro, 'tpf.data_inicio DESC, tpf.id DESC');
		$arrayDados['locaisCadastrados'] = [];
		$arrayDados['totaisInscritos'] = [];
		$courseids = array_unique(array_map(function ($curso) { return (string) $curso->courseid; }, $arrayDados['tabelaCurso']));
		if ($courseids) {
			$totais = $this->db->select('urm_evento, COUNT(*) AS total', false)
				->where_in('urm_evento', $courseids)->group_by('urm_evento')->get('urm_inscricao')->result();
			foreach ($totais as $total) $arrayDados['totaisInscritos']['curso:'.$total->urm_evento] = (int) $total->total;
			$campoCodigo = $this->db->field_exists('courseid', 'tbl_portalfarma_urm_local') ? 'courseid' : 'id';
			$locais = $this->db->select($campoCodigo.' AS codigo')->where_in($campoCodigo, $courseids)->get('tbl_portalfarma_urm_local')->result();
			foreach ($locais as $local) $arrayDados['locaisCadastrados']['curso:'.$local->codigo] = TRUE;
		}

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/urm_listar', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
    }

	public function alterar_exigencia_curso54($id = 0) {
		if (strtoupper($this->input->method()) !== 'POST') { show_404(); return; }
		$evento = $this->evento_inscritos($id);
		$exigir = $this->input->post('exigir');
		if (!in_array($exigir, ['0', '1'], true)) {
			return $this->json_response(['message' => 'Opção inválida.'], 400);
		}
		if (!$this->db->field_exists('exigir_curso54', 'tbl_portalfarma')) {
			return $this->json_response(['message' => 'Execute a atualização database/urm_exigir_curso54.sql no banco de dados.'], 503);
		}
		$salvou = $this->db->where('id', $evento->id)->where('tipo_evento', 3)
			->update('tbl_portalfarma', ['exigir_curso54' => (int) $exigir]);
		return $this->json_response(['message' => $salvou ? 'Exigência do curso 54 atualizada.' : 'Não foi possível salvar a opção.'], $salvou ? 200 : 500);
	}

	private function evento_inscritos($id) {
		$evento = $this->db->where('id', (int) $id)->where('tipo_evento', 3)->get('tbl_portalfarma')->row();
		if (!$evento) {
			show_404();
			exit;
		}
		return $evento;
	}

	public function inscritos($id = 0) {
		$evento = $this->evento_inscritos($id);
		$inscritos = $this->db->where('urm_evento', $evento->courseid)->order_by('nome', 'ASC')->get('urm_inscricao')->result();
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/urm_inscritos', compact('evento', 'inscritos'));
		$this->load->view('restrito/fixo/rodape');
	}

	public function salvar_presenca($id = 0) {
		if (strtoupper($this->input->method()) !== 'POST') { show_404(); return; }
		$evento = $this->evento_inscritos($id);
		$presenca = $this->input->post('presenca');
		if (!in_array($presenca, ['0', '1'], true)) {
			return $this->json_response(['message' => 'Presença inválida.'], 400);
		}
		$inscrito = $this->db->where('urm_evento', $evento->courseid)->where('id', (int) $this->input->post('inscricao_id'))->get('urm_inscricao')->row();
		if (!$inscrito) { return $this->json_response(['message' => 'Inscrição não encontrada neste curso.'], 404); }
		$salvou = $this->db->where('urm_evento', $evento->courseid)->where('id', $inscrito->id)->update('urm_inscricao', ['presenca' => (int) $presenca]);
		return $this->json_response(['message' => $salvou ? 'Presença salva.' : 'Não foi possível salvar a presença.'], $salvou ? 200 : 500);
	}

	public function salvar_todas_presencas($id = 0) {
		if (strtoupper($this->input->method()) !== 'POST') { show_404(); return; }
		$evento = $this->evento_inscritos($id);
		$presencas = $this->input->post('presencas');
		if (!is_array($presencas) || !$presencas) {
			return $this->json_response(['message' => 'Nenhuma inscrição foi informada.'], 400);
		}

		$ids = array_map('intval', array_keys($presencas));
		$inscritos = $this->db->select('id')->where('urm_evento', $evento->courseid)->where_in('id', $ids)->get('urm_inscricao')->result();
		if (count($inscritos) !== count($ids)) {
			return $this->json_response(['message' => 'Há inscrições que não pertencem a este curso.'], 400);
		}

		$atualizacoes = [];
		foreach ($ids as $inscricaoId) {
			$presenca = (string) $presencas[$inscricaoId];
			if (!in_array($presenca, ['0', '1'], true)) {
				return $this->json_response(['message' => 'Presença inválida.'], 400);
			}
			$atualizacoes[] = ['id' => $inscricaoId, 'presenca' => (int) $presenca];
		}

		$this->db->trans_start();
		$this->db->update_batch('urm_inscricao', $atualizacoes, 'id');
		$this->db->trans_complete();
		if (!$this->db->trans_status()) {
			return $this->json_response(['message' => 'Não foi possível salvar as presenças.'], 500);
		}
		return $this->json_response(['message' => 'Presenças salvas com sucesso.']);
	}

	public function importar_inscritos($id = 0) {
		if (strtoupper($this->input->method()) !== 'POST') { show_404(); return; }
		$evento = $this->evento_inscritos($id);
		$arquivo = isset($_FILES['csv']) ? $_FILES['csv'] : null;
		$handle = null;
		try {
			if (!$arquivo || $arquivo['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($arquivo['tmp_name'])) {
				throw new RuntimeException('Selecione um arquivo CSV válido.');
			}
			if (strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION)) !== 'csv' || $arquivo['size'] > 5 * 1024 * 1024) {
				throw new RuntimeException('Envie um arquivo .csv de até 5 MB.');
			}
			$handle = fopen($arquivo['tmp_name'], 'r');
			if (!$handle) { throw new RuntimeException('Não foi possível ler o CSV.'); }
			$primeiraLinha = fgets($handle);
			if ($primeiraLinha === false) { throw new RuntimeException('O CSV está vazio.'); }
			$separador = count(str_getcsv($primeiraLinha, ';', '"', '')) > count(str_getcsv($primeiraLinha, ',', '"', '')) ? ';' : ',';
			rewind($handle);
			$cabecalho = fgetcsv($handle, 0, $separador, '"', '');
			$cabecalho = array_map(function ($valor) {
				$valor = preg_replace('/^\xEF\xBB\xBF/', '', (string) $valor);
				if (!mb_check_encoding($valor, 'UTF-8')) { $valor = mb_convert_encoding($valor, 'UTF-8', 'Windows-1252'); }
				return strtr(mb_strtolower(trim($valor), 'UTF-8'), ['ç' => 'c', 'ã' => 'a', 'õ' => 'o', 'í' => 'i', 'é' => 'e']);
			}, $cabecalho);
			// Arquivos exportados pelo Excel podem terminar cada linha com vários ";".
			// Essas colunas vazias não fazem parte do layout de importação.
			while ($cabecalho && end($cabecalho) === '') { array_pop($cabecalho); }
			$campos = ['nome', 'cpf', 'email', 'telefone', 'instituicao'];
			if (array_diff($campos, $cabecalho) || count(array_unique($cabecalho)) !== count($cabecalho)) {
				throw new RuntimeException('O cabeçalho deve conter: nome, cpf, email, telefone, instituicao, sem colunas repetidas.');
			}
			$indices = array_flip($cabecalho);
			$existentes = $this->db->select('cpf')->where('urm_evento', $evento->courseid)->get('urm_inscricao')->result();
			$cpfs = [];
			foreach ($existentes as $existente) { $cpfs[preg_replace('/\D/', '', $existente->cpf)] = true; }
			$novos = []; $ignorados = 0; $linha = 1;
			$data = date('Y-m-d H:i:s');
			while (($valores = fgetcsv($handle, 0, $separador, '"', '')) !== false) {
				$linha++;
				if (count($valores) === 1 && trim((string) $valores[0]) === '') { continue; }
				$colunasExtras = array_slice($valores, count($cabecalho));
				if (array_filter($colunasExtras, function ($valor) { return trim((string) $valor) !== ''; })) {
					throw new RuntimeException('Há dados fora das colunas esperadas no registro ' . $linha . '.');
				}
				$valores = array_slice($valores, 0, count($cabecalho));
				if (count($valores) !== count($cabecalho)) { throw new RuntimeException('Quantidade de colunas inválida no registro ' . $linha . '.'); }
				$registro = [];
				foreach ($campos as $campo) {
					$valor = trim((string) $valores[$indices[$campo]]);
					$registro[$campo] = mb_check_encoding($valor, 'UTF-8') ? $valor : mb_convert_encoding($valor, 'UTF-8', 'Windows-1252');
				}
				$registro['cpf'] = preg_replace('/[.\-\s]/', '', $registro['cpf']);
				if ($registro['nome'] === '' || !preg_match('/^[0-9]{11}$/', $registro['cpf']) || !filter_var($registro['email'], FILTER_VALIDATE_EMAIL)) {
					throw new RuntimeException('Registro ' . $linha . ': informe nome, CPF com 11 dígitos e email válido. Nenhuma inscrição foi importada.');
				}
				if (isset($cpfs[$registro['cpf']])) { $ignorados++; continue; }
				$cpfs[$registro['cpf']] = true;
				$registro['urm_evento'] = $evento->courseid;
				$registro['data_inscricao'] = $data;
				$registro['presenca'] = 0;
				$novos[] = $registro;
			}
			if (!$novos && !$ignorados) { throw new RuntimeException('O CSV não contém inscritos.'); }
			if ($novos) {
				$debug = $this->db->db_debug;
				$this->db->db_debug = false;
				$this->db->trans_start();
				$this->db->insert_batch('urm_inscricao', $novos);
				$this->db->trans_complete();
				$this->db->db_debug = $debug;
				if (!$this->db->trans_status()) { throw new RuntimeException('Não foi possível importar os inscritos. Verifique os dados do CSV.'); }
			}
			$this->session->set_flashdata('inscritos_sucesso', count($novos) . ' inscrição(ões) importada(s). ' . $ignorados . ' CPF(s) repetido(s) ignorado(s).');
		} catch (RuntimeException $e) {
			$this->session->set_flashdata('inscritos_erro', $e->getMessage());
		}
		if (is_resource($handle)) { fclose($handle); }
		redirect('restrito/urm/inscritos/' . $evento->id);
	}

	public function local() {
		$arrayDados['locais'] = $this->db
			->order_by('data', 'DESC')
			->order_by('id', 'DESC')
			->get('tbl_portalfarma_urm_local')
			->result();
		foreach ($arrayDados['locais'] as $local) {
			$local->imagem_arquivo = $this->localizar_imagem_local($local->imagem);
		}

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/urm_local_listar', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
	}

	private function cursos_locais_urm() {
		return $this->db->select('courseid, titulo')->where('tipo_evento', 3)
			->order_by('courseid', 'ASC')->get('tbl_portalfarma')->result();
	}

	public function local_cadastrar() {
		$dados = [
			'limiteUpload' => $this->limite_upload_local(),
			'cursosUrm' => $this->cursos_locais_urm(),
			'courseid' => (string) $this->input->get('courseid', true)
		];
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/urm_local_cadastrar', $dados);
		$this->load->view('restrito/fixo/rodape');
	}

	public function local_editar($id) {
		$campoCodigo = $this->input->get('registro') === '1' ? 'id' : ($this->db->field_exists('courseid', 'tbl_portalfarma_urm_local') ? 'courseid' : 'id');
		$local = $this->db
			->where($campoCodigo, (string) $id)
			->get('tbl_portalfarma_urm_local')
			->row();

		if (!$local) {
			show_404();
		}
		$local->imagem_arquivo = $this->localizar_imagem_local($local->imagem);

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/urm_local_cadastrar', ['local' => $local, 'courseid' => (string) ($local->courseid ?? ''), 'cursosUrm' => $this->cursos_locais_urm(), 'limiteUpload' => $this->limite_upload_local()]);
		$this->load->view('restrito/fixo/rodape');
	}

	public function local_salvar() {
		if (strtoupper($this->input->method()) !== 'POST') {
			show_404();
		}

		$dados = [
			'courseid' => trim((string) $this->input->post('courseid', true)),
			'titulo' => trim((string) $this->input->post('titulo', true)),
			'cidade' => trim((string) $this->input->post('cidade', true)),
			'descricao' => trim((string) $this->input->post('descricao')),
			'link' => trim((string) $this->input->post('link', true))
		];
		$id = (int) $this->input->post('id');
		$localAtual = null;

		if ($id > 0) {
			$localAtual = $this->db
				->where('id', $id)
				->get('tbl_portalfarma_urm_local')
				->row();

			if (!$localAtual) {
				show_404();
			}
		}

		$urlFormulario = $id > 0
			? 'restrito/urm/local/editar/' . $id . '?registro=1'
			: 'restrito/urm/local/cadastrar?courseid=' . rawurlencode($dados['courseid']);
		$this->session->set_flashdata('local_contexto', $id > 0 ? 'editar:'.$id : 'cadastrar:'.$dados['courseid']);

		$curso = $dados['courseid'] === '' ? null : $this->db->select('courseid, data_inicio')
			->where('courseid', $dados['courseid'])->where('tipo_evento', 3)->get('tbl_portalfarma')->row();
		if (!$curso || !$this->db->field_exists('courseid', 'tbl_portalfarma_urm_local')) {
			$this->session->set_flashdata('local_erro', !$curso ? 'Selecione um curso URM válido.' : 'Execute a atualização database/urm_local_courseid.sql no banco de dados.');
			$this->session->set_flashdata('local_dados', $dados);
			redirect($urlFormulario);
			return;
		}

		$dataEvento = !empty($curso->data_inicio) ? strtotime($curso->data_inicio) : false;
		if ($dataEvento === false) {
			$this->session->set_flashdata('local_erro', 'O curso URM selecionado precisa ter uma data de início válida.');
			$this->session->set_flashdata('local_dados', $dados);
			redirect($urlFormulario);
			return;
		}
		$dados['data'] = date('Y-m-d', $dataEvento);

		if ($dados['titulo'] === '' || $dados['cidade'] === '' || $dados['descricao'] === '') {
			$this->session->set_flashdata('local_erro', 'Preencha todos os campos obrigatórios.');
			$this->session->set_flashdata('local_dados', $dados);
			redirect($urlFormulario);
			return;
		}

		if ($dados['link'] !== '' && !filter_var($dados['link'], FILTER_VALIDATE_URL)) {
			$this->session->set_flashdata('local_erro', 'Informe um link válido, incluindo http:// ou https://.');
			$this->session->set_flashdata('local_dados', $dados);
			redirect($urlFormulario);
			return;
		}

		if (!$localAtual && empty($_FILES['imagem']['name'])) {
			$this->session->set_flashdata('local_erro', 'Selecione uma imagem para o local.');
			$this->session->set_flashdata('local_dados', $dados);
			redirect($urlFormulario);
			return;
		}

		$upload = null;
		if (!empty($_FILES['imagem']['name'])) {
			$pasta = FCPATH . 'uploads/urm_locais/';
			if (!is_dir($pasta) && !@mkdir($pasta, 0775, true) && !is_dir($pasta)) {
				log_message('error', 'URM: não foi possível criar a pasta de upload: ' . $pasta);
				$this->session->set_flashdata('local_erro', 'Não foi possível criar uploads/urm_locais/. Solicite permissão de escrita para o usuário do PHP na pasta uploads.');
				$this->session->set_flashdata('local_dados', $dados);
				redirect($urlFormulario);
				return;
			}
			clearstatcache(true, $pasta);
			if (!is_writable($pasta)) {
				// Só funciona quando o processo PHP tem permissão para alterar a pasta.
				@chmod($pasta, 0775);
				clearstatcache(true, $pasta);
			}
			if (!is_writable($pasta)) {
				log_message('error', 'URM: pasta de upload sem permissão de escrita: ' . $pasta);
				$this->session->set_flashdata('local_erro', 'A pasta uploads/urm_locais/ está sem permissão de escrita. Solicite ao administrador do servidor que ajuste o proprietário/grupo da pasta para o usuário do PHP e permita a gravação.');
				$this->session->set_flashdata('local_dados', $dados);
				redirect($urlFormulario);
				return;
			}

			$config = [
				'upload_path' => $pasta,
				'allowed_types' => 'jpg|jpeg|png|webp',
				'max_size' => 5120,
				'encrypt_name' => true
			];
			$this->load->library('upload');
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('imagem')) {
				$erroUpload = isset($_FILES['imagem']['error']) ? (int) $_FILES['imagem']['error'] : UPLOAD_ERR_OK;
				$mensagemUpload = in_array($erroUpload, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)
					? 'A foto ultrapassou o limite de upload do servidor. Selecione novamente a imagem para aplicar o recorte e a redução automática.'
					: strip_tags($this->upload->display_errors());
				$this->session->set_flashdata('local_erro', $mensagemUpload);
				$this->session->set_flashdata('local_dados', $dados);
				redirect($urlFormulario);
				return;
			}

			$upload = $this->upload->data();
			$arquivoFisico = $this->localizar_imagem_local($upload['file_name']);
			$dados['imagem'] = $arquivoFisico;
			$upload['full_path'] = FCPATH . 'uploads/urm_locais/' . $arquivoFisico;
		}

		if ($localAtual) {
			$this->db->where('id', $id);
			$salvou = $this->db->update('tbl_portalfarma_urm_local', $dados);
		} else {
			$dados['data_cadastro'] = date('Y-m-d H:i:s');
			$salvou = $this->db->insert('tbl_portalfarma_urm_local', $dados);
		}

		if (!$salvou) {
			if ($upload) {
				@unlink($upload['full_path']);
			}
			$this->session->set_flashdata('local_erro', 'Não foi possível salvar o local no banco de dados.');
			$this->session->set_flashdata('local_dados', $dados);
			redirect($urlFormulario);
			return;
		}

		if ($localAtual && $upload && !empty($localAtual->imagem)) {
			$imagemAnterior = FCPATH . 'uploads/urm_locais/' . $this->localizar_imagem_local($localAtual->imagem);
			if (is_file($imagemAnterior)) {
				@unlink($imagemAnterior);
			}
		}

		$this->session->set_flashdata('local_sucesso', $localAtual
			? 'Local atualizado com sucesso.'
			: 'Local cadastrado com sucesso.');
		redirect('restrito/urm/listar');
	}

	private function limite_upload_local() {
		$limite = 5 * 1024 * 1024;
		foreach (['upload_max_filesize', 'post_max_size'] as $opcao) {
			$valor = trim((string) ini_get($opcao));
			$bytes = (float) $valor;
			$unidade = strtolower(substr($valor, -1));
			if ($unidade === 'g') $bytes *= 1024 * 1024 * 1024;
			elseif ($unidade === 'm') $bytes *= 1024 * 1024;
			elseif ($unidade === 'k') $bytes *= 1024;
			if ($bytes > 0) {
				// Reserva espaço para os campos do formulário e o multipart.
				if ($opcao === 'post_max_size') $bytes = max(1, $bytes - 64 * 1024);
				$limite = min($limite, (int) $bytes);
			}
		}
		return $limite;
	}

	private function localizar_imagem_local($nomeArquivo) {
		$nomeArquivo = basename((string) $nomeArquivo);
		$pasta = FCPATH . 'uploads/urm_locais/';

		if ($nomeArquivo === '' || !is_dir($pasta)) {
			return $nomeArquivo;
		}

		if (is_file($pasta . $nomeArquivo)) {
			return $nomeArquivo;
		}

		$arquivos = glob($pasta . '*' . $nomeArquivo);
		if (empty($arquivos)) {
			return $nomeArquivo;
		}

		usort($arquivos, function ($arquivoA, $arquivoB) {
			return filemtime($arquivoB) <=> filemtime($arquivoA);
		});

		return basename($arquivos[0]);
	}
	
	public function toggleStatus($id)
	{
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$novoStatus = ($curso->status == 1) ? 0 : 1;

		$data_extenso 	= $this->capacifar_model->updateStatus($id, $novoStatus);
		//$this->Cursos_model->updateStatus($id, $novoStatus);

		echo json_encode(['success' => true, 'status' => $novoStatus]);
	}

	public function alterar_liberacao_presenca() {
		$courseid = trim((string) $this->input->post('courseid'));
		$liberar = (int) $this->input->post('liberar');

		if ($courseid === '' || !in_array($liberar, [0, 1], true)) {
			return $this->json_response([
				'status' => 'error',
				'message' => 'Dados inválidos para alterar a liberação de presença.'
			], 400);
		}

		$evento = $this->db
			->select('id')
			->from('tbl_portalfarma')
			->where('courseid', $courseid)
			->where('tipo_evento', 3)
			->get()
			->row();

		if (!$evento) {
			return $this->json_response([
				'status' => 'error',
				'message' => 'Evento URM não encontrado.'
			], 404);
		}

		$this->db->where('id', $evento->id);
		$atualizado = $this->db->update('tbl_portalfarma', [
			'presenca_liberada' => $liberar
		]);

		if (!$atualizado) {
			return $this->json_response([
				'status' => 'error',
				'message' => 'Não foi possível alterar a liberação de presença.'
			], 500);
		}

		return $this->json_response([
			'status' => 'success',
			'message' => $liberar
				? 'Marcação de presença liberada para este evento URM.'
				: 'Marcação de presença bloqueada para este evento URM.',
			'liberar' => $liberar
		]);
	}

	private function json_response($dados, $codigo = 200) {
		return $this->output
			->set_status_header($codigo)
			->set_content_type('application/json')
			->set_output(json_encode($dados));
	}
	
}
