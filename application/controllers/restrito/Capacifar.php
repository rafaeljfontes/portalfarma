<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ACESSO RESTRITO / LOGIN

class Capacifar extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
		
		$this->dados = array();
		$dados = array();
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->dados['menu_ativo'] = "inicio";
		$this->load->model('Moodle_model');
		
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
		$this->load->model('Designacoes_model', 'designacoes_model');
		$designadosAMim = $this->input->get('designados') === '1';
		$designacoesDisponiveis = $this->designacoes_model->disponivel();
	

		$url_filtro = $this->uri->segment('4');
		
		//echo $url_filtro; //exit;
		
		
		if ($url_filtro == 'ativos'){
			$filtro = 'tpf.status = 1';
		} elseif ($url_filtro == 'inativos') {
			$filtro = 'tpf.status = 0';
		} elseif ($url_filtro == 'online') {
			$filtro = 'tpf.status = 1 AND tpf.tipo_evento = 2';
		} elseif ($url_filtro == 'presencial') {
			$filtro = 'tpf.status = 1 AND tpf.tipo_evento = 1';
		} else {
			$filtro = 'tpf.status in (0,1) AND tpf.tipo_evento in (1,2, 5, 6)';
		}

		//$arrayDados['tabelaCategoria'] 	= $this->capacifar_model->query($query);
		$arrayDados['filtro'] 			= $url_filtro;
		if ($designadosAMim) $filtro .= ' AND '.$this->designacoes_model->condicao_usuario('tpf', $this->designacoes_model->usuario_sessao());
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosAdministracao($filtro, $this->designacoes_model);
		$arrayDados['designadosAMim'] = $designadosAMim;
		$arrayDados['designacoesDisponiveis'] = $designacoesDisponiveis;
		$arrayDados['usuariosDesignacao'] = $designacoesDisponiveis ? $this->designacoes_model->usuarios_ativos() : [];
		$csrf = $this->session->userdata('designacoes_csrf');
		if (!$csrf) { $csrf = bin2hex(random_bytes(32)); $this->session->set_userdata('designacoes_csrf', $csrf); }
		$arrayDados['designacoesCsrf'] = $csrf;
		$arrayDados['inscritosAvaPorCurso'] = [];
		$arrayDados['avaIndisponivel'] = FALSE;
		try {
			$courseids = array_values(array_filter(array_map(function ($curso) {
				return ctype_digit((string) $curso->courseid) ? (int) $curso->courseid : 0;
			}, $arrayDados['tabelaCurso'])));
			if ($courseids) $this->load->model('Moodle_api');
			foreach ($courseids ? $this->Moodle_api->totais_inscritos_cursos($courseids) : [] as $cursoAva) {
				$arrayDados['inscritosAvaPorCurso'][(int) $cursoAva->courseid] = (int) $cursoAva->total_estudantes;
			}
		} catch (mysqli_sql_exception $e) {
			log_message('error', 'Capacifar: consulta ao Moodle indisponivel (codigo ' . (int) $e->getCode() . ').');
			$arrayDados['avaIndisponivel'] = TRUE;
		} catch (RuntimeException $e) {
			log_message('error', 'Capacifar: falha na contagem de inscritos do Moodle.');
			$arrayDados['avaIndisponivel'] = TRUE;
		}

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/capacifar_listar', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
    }
	
    public function salvar_designacoes()
    {
        $responder = function ($status, $mensagem, $http = 200) {
            $this->output->set_status_header($http)->set_content_type('application/json')->set_output(json_encode(['ok'=>$status, 'message'=>$mensagem]));
        };
        if ($this->input->method(TRUE) !== 'POST') { $responder(false, 'Método não permitido.', 405); return; }
        $dados = json_decode($this->input->raw_input_stream, true);
        $csrf = $this->session->userdata('designacoes_csrf');
        if (!$csrf || !is_array($dados) || !is_string($dados['csrf'] ?? null) || !hash_equals($csrf, $dados['csrf'])) {
            $responder(false, 'Sessão inválida. Atualize a página.', 403); return;
        }
        $this->load->model('Designacoes_model', 'designacoes_model');
        if (!$this->designacoes_model->usuario_sessao()) { $responder(false, 'Usuário da sessão não identificado.', 403); return; }
        $courseid = $dados['courseid'] ?? null;
        $ids = $dados['usuarios'] ?? null;
        if (!is_string($courseid) || trim($courseid) === '' || strlen($courseid) > 255 || !is_array($ids) || count($ids) > 200) {
            $responder(false, 'Dados de designação inválidos.', 400); return;
        }
        foreach ($ids as $id) {
            if (!is_scalar($id) || !ctype_digit((string) $id) || (int) $id <= 0) { $responder(false, 'Usuário inválido.', 400); return; }
        }
        try {
            $this->designacoes_model->salvar(trim($courseid), $ids);
            $responder(true, 'Designações salvas com sucesso.');
        } catch (InvalidArgumentException $e) {
            $responder(false, $e->getMessage(), 400);
        } catch (Throwable $e) {
            log_message('error', 'Falha ao salvar designações: '.$e->getMessage());
            $responder(false, 'Não foi possível salvar. Verifique a instalação da tabela de designações.', 503);
        }
    }

    public function relatorios($courseid = NULL)
    {
        if (!ctype_digit((string) $courseid) || (int) $courseid <= 0) {
            show_error('Curso inválido.', 400);
            return;
        }
        $curso = $this->db->select('courseid, titulo, tipo_evento')->where('courseid', (int) $courseid)->get('tbl_portalfarma')->row();
        if (!$curso) { show_404(); return; }
        $dados = ['curso' => $curso, 'indicadores' => array_fill_keys(['inscritos', 'ativos', 'acessos', 'atividades', 'certificados'], NULL),
            'grupos' => [], 'grupos_indisponiveis' => FALSE, 'presencas' => NULL, 'grupo_selecionado' => NULL];
        try {
            $this->load->model('Moodle_api');
            $dados['indicadores'] = $this->Moodle_api->relatorio_curso($courseid);
            if ((int) $curso->tipo_evento === 1) {
                $dados['grupos_indisponiveis'] = TRUE;
                $dados['grupos'] = $this->Moodle_api->grupos_do_curso($courseid);
                $dados['grupos_indisponiveis'] = FALSE;
                foreach ($dados['grupos'] as $grupo) {
                    if ((string) $grupo['id'] === (string) $this->input->get('grupo')) $dados['grupo_selecionado'] = $grupo;
                }
            }
        } catch (Exception $e) {
            $dados['grupos_indisponiveis'] = TRUE;
            log_message('error', 'Capacifar: relatório Moodle indisponível.');
        }
        if ((int) $curso->tipo_evento === 1) {
            $debug = $this->db->db_debug;
            $this->db->db_debug = FALSE;
            try { $dados['presencas'] = $this->capacifar_model->presencas_curso($courseid); }
            catch (Exception $e) { log_message('error', 'Capacifar: lista de presença indisponível.'); }
            finally { $this->db->db_debug = $debug; }
        }
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/curso_relatorios', $dados);
        $this->load->view('restrito/fixo/rodape');
    }

    public function grupos($courseid = NULL)
    {
        if (!ctype_digit((string) $courseid) || (int) $courseid <= 0) {
            show_error('Curso inválido.', 400);
            return;
        }
        $curso = $this->db->select('courseid, titulo')->where('courseid', (int) $courseid)->get('tbl_portalfarma')->row();
        if (!$curso) {
            show_404();
            return;
        }
        $dados = ['curso' => $curso, 'grupos' => [], 'indisponivel' => FALSE];
        try {
            $this->load->model('Moodle_api');
            $dados['grupos'] = $this->Moodle_api->grupos_do_curso($courseid);
        } catch (mysqli_sql_exception $e) {
            $dados['indisponivel'] = TRUE;
            log_message('error', 'Capacifar grupos: Moodle indisponivel (codigo ' . (int) $e->getCode() . ').');
        } catch (RuntimeException $e) {
            $dados['indisponivel'] = TRUE;
            log_message('error', 'Capacifar grupos: falha na consulta ao Moodle.');
        }
        if ($dados['indisponivel']) {
            $this->output->set_status_header(503);
        }
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/curso_grupos', $dados);
        $this->load->view('restrito/fixo/rodape');
    }

	public function lista_inscritos($courseid) {

		$courseid = (int) $courseid;
		
		$curso = "SELECT 
						tpf.*
					FROM web_site.tbl_portalfarma tpf
					WHERE courseid = ".$courseid;
		
		$data['curso']		= $this->capacifar_model->query($curso);
		
		try {
			$data['inscritos'] = $this->capacifar_model->listaInscritosCurso($courseid);
		} catch (mysqli_sql_exception $e) {
			$this->inscritos_indisponiveis($courseid, $e);
			return;
		}
		$data['courseid']  	= $courseid;
		$data['presencas'] = $this->capacifar_model->presencas_curso($courseid);
        $token = $this->session->userdata('presencas_csrf');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $this->session->set_userdata('presencas_csrf', $token);
        }
        $data['presencas_csrf'] = $token;
        $this->session->set_userdata('presencas_alunos_'.$courseid, array_map('intval', array_column($data['inscritos'], 'id_moodle')));
		
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/lista_inscritos_view', $data);
		$this->load->view('restrito/fixo/rodape');
	}

    public function salvar_presencas($courseid = NULL)
    {
        $this->output->set_content_type('application/json');
        if ($this->input->method() !== 'post') {
            $this->output->set_status_header(405)->set_output(json_encode(['ok' => FALSE, 'message' => 'Método não permitido.']));
            return;
        }
        $payload = json_decode($this->input->raw_input_stream, TRUE);
        $token = $this->session->userdata('presencas_csrf');
        if (!$token || !is_array($payload) || !is_string($payload['csrf'] ?? NULL) || !hash_equals($token, $payload['csrf'])) {
            $this->output->set_status_header(403)->set_output(json_encode(['ok' => FALSE, 'message' => 'Sessão inválida. Recarregue a página.']));
            return;
        }
        $alunos = ctype_digit((string) $courseid) ? $this->session->userdata('presencas_alunos_'.(int) $courseid) : NULL;
        $alteracoes = $payload['alteracoes'] ?? NULL;
        if (!is_array($alunos) || !is_array($alteracoes) || count($alteracoes) > count($alunos)) {
            $this->output->set_status_header(400)->set_output(json_encode(['ok' => FALSE, 'message' => 'Recarregue a lista de inscritos.']));
            return;
        }
        foreach ($alteracoes as $id => $presente) {
            if (!ctype_digit((string) $id) || !in_array((int) $id, $alunos, TRUE) || !is_bool($presente)) {
                $this->output->set_status_header(400)->set_output(json_encode(['ok' => FALSE, 'message' => 'Aluno ou presença inválida.']));
                return;
            }
        }
        try {
            $this->capacifar_model->salvar_presencas_curso((int) $courseid, $alteracoes);
            $this->output->set_output(json_encode(['ok' => TRUE, 'message' => 'Presenças salvas.']));
        } catch (Exception $e) {
            log_message('error', 'Falha ao salvar presencas do curso '.(int) $courseid.' (codigo '.(int) $e->getCode().').');
            $this->output->set_status_header(503)->set_output(json_encode(['ok' => FALSE, 'message' => 'Não foi possível salvar. Tente novamente.']));
        }
    }

	public function exportar_excel($courseid) {

		$courseid = (int) $courseid;

		if ($courseid <= 0) {
			show_error('Curso invÃ¡lido.', 400);
		}

		$curso = $this->db
			->select('titulo')
			->from('tbl_portalfarma')
			->where('courseid', $courseid)
			->get()
			->row();

		try {
			$inscritos = $this->capacifar_model->listaInscritosCurso($courseid);
		} catch (mysqli_sql_exception $e) {
			$this->inscritos_indisponiveis($courseid, $e);
			return;
		}
		$titulo = $curso ? $curso->titulo : 'Curso '.$courseid;
		$nomeArquivo = 'inscritos_curso_'.$courseid.'_'.date('Y-m-d').'.xls';

		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment; filename="'.$nomeArquivo.'"');
		header('Cache-Control: max-age=0');

		echo "\xEF\xBB\xBF";
		echo '<html><head><meta charset="UTF-8"></head><body>';
		echo '<table border="1">';
		echo '<tr><th colspan="7" style="background:#005691;color:#fff;font-size:16px;">'.htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8').'</th></tr>';
		echo '<tr style="background:#d9eaf7;font-weight:bold;">';
		echo '<th>ID Moodle</th><th>Nome</th><th>CPF</th><th>E-mail</th><th>Telefone</th><th>Data da inscrição no Moodle</th><th>Cidade</th>';
		echo '</tr>';

		foreach ($inscritos as $aluno) {
			$cpf = preg_replace('/[^0-9]/', '', $aluno->cpf);
			$telefone = preg_replace('/[^0-9]/', '', $aluno->telefone);

			echo '<tr>';
			echo '<td>'.(int) $aluno->id_moodle.'</td>';
			echo '<td>'.htmlspecialchars(mb_strtoupper($aluno->nome_completo), ENT_QUOTES, 'UTF-8').'</td>';
			echo '<td style="mso-number-format:\'\\@\';">'.htmlspecialchars($cpf, ENT_QUOTES, 'UTF-8').'</td>';
			echo '<td>'.htmlspecialchars($aluno->email, ENT_QUOTES, 'UTF-8').'</td>';
			echo '<td style="mso-number-format:\'\\@\';">'.htmlspecialchars($telefone, ENT_QUOTES, 'UTF-8').'</td>';
			echo '<td>'.htmlspecialchars($aluno->data_inscricao ?: 'Não informada', ENT_QUOTES, 'UTF-8').'</td>';
			echo '<td>'.htmlspecialchars(trim($aluno->cidade ?? '') ?: 'Não informada', ENT_QUOTES, 'UTF-8').'</td>';
			echo '</tr>';
		}

		echo '</table></body></html>';
		exit;
	}

    private function inscritos_indisponiveis($courseid, $exception)
    {
        log_message('error', 'Capacifar inscritos: Moodle indisponivel (codigo ' . (int) $exception->getCode() . ').');
        $this->output->set_status_header(503);
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/inscritos_indisponiveis', ['courseid' => (int) $courseid]);
        $this->load->view('restrito/fixo/rodape');
    }

	public function lista_portaria($courseid) {
		$courseid = (int) $courseid;

		if ($courseid <= 0) {
			show_error('Curso inválido.', 400);
		}

		require_once FCPATH . 'vendor/autoload.php';

		$curso = $this->db
			->select('courseid, titulo, data_inicio')
			->from('tbl_portalfarma')
			->where('courseid', $courseid)
			->get()
			->row();

		if (!$curso) {
			show_404();
		}

		$inscritos = $this->capacifar_model->listaInscritosCurso($courseid);

		$html = $this->load->view('restrito/pdfs/lista_portaria_pdf', [
			'curso' => $curso,
			'inscritos' => $inscritos
		], TRUE);

		$nomeArquivo = 'Lista_Portaria_Curso_'.$courseid.'.pdf';

		try {
			$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'pt');
			$html2pdf->setDefaultFont('dejavusans');
			$html2pdf->writeHTML($html);
			$html2pdf->output($nomeArquivo, 'I');
		} catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
			show_error('Não foi possível gerar a Lista Portaria: '.$e->getMessage(), 500);
		}
	}

    public function urm_listar() {
	
		
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
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.tipo_evento = 3 AND '.$filtro);

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/urm_listar', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
    }
	
	public function fiscalizacao_listar() {
	
		
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
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.tipo_evento = 4 AND '.$filtro);

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/fiscalizacao_listar', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
    }
	
	public function inscricoescursos()
	{
		$dados['tiposEvento'] = array(
			1 => 'Capacifar Presencial',
			2 => 'Capacifar Online',
			3 => 'Uso Racional de Medicamentos',
			4 => 'Fiscalização Humanizada',
			5 => 'Capacifar Universitário',
			7 => 'Seminário de Vigilância'
		);
		$tipoEvento = $this->input->get('tipo_evento');
		$dados['escopoDesignados'] = $this->input->get('escopo') === 'designados';
		$dados['tipoEventoSelecionado'] = is_string($tipoEvento)
			&& in_array($tipoEvento, array_map('strval', array_keys($dados['tiposEvento'])), true)
			? (int) $tipoEvento : null;
		try {
			$idUsuario = null;
			if ($this->input->get('escopo') === 'designados') {
				$this->load->model('Designacoes_model', 'designacoes_model');
				$idUsuario = $this->designacoes_model->usuario_sessao();
			}
			$dados['total_alunos_cursos'] = $this->capacifar_model->relatorio_inscricoes_cursos($dados['tipoEventoSelecionado'], $idUsuario);
		} catch (RuntimeException | mysqli_sql_exception $e) {
			log_message('error', 'Capacifar: consulta ao Moodle indisponivel (codigo ' . (int) $e->getCode() . ').');
			show_error('Os dados de inscricoes do AVA estao temporariamente indisponiveis. Tente novamente mais tarde.', 503);
			return;
		}
		
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/inscricoescursos', $dados);
		$this->load->view('restrito/fixo/rodape');
		
	}
	
}
