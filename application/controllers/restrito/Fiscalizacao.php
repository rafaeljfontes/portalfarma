<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ACESSO RESTRITO / LOGIN

class Fiscalizacao extends CI_Controller {

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
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.tipo_evento = 4 AND '.$filtro);

		$inscricoes = $this->db
			->select('id_evento, COUNT(*) AS quantidade_inscritos', FALSE)
			->from('fiscalizacao_humanizada_inscricao')
			->group_by('id_evento')
			->get()->result();
		$arrayDados['inscritosPorCurso'] = array();
		foreach ($inscricoes as $inscricao) {
			$arrayDados['inscritosPorCurso'][$inscricao->id_evento] = (int) $inscricao->quantidade_inscritos;
		}

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/fiscalizacao_listar', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
    }
	

    private function curso_fiscalizacao($courseid)
    {
        if ((!is_string($courseid) && !is_int($courseid)) || !preg_match('/^[A-Za-z0-9_-]{1,64}$/D', (string) $courseid)) {
            show_404();
            return NULL;
        }
        $curso = $this->db->get_where('tbl_portalfarma', [
            'courseid' => (string) $courseid, 'tipo_evento' => 4
        ])->row();
        if (!$curso) show_404();
        return $curso;
    }

    private function inscritos_fiscalizacao($courseid)
    {
        return $this->db
            ->select('id AS id_inscricao, nome AS nome_completo, cpf, email, telefone, data_inscricao, presenca')
            ->from('fiscalizacao_humanizada_inscricao')
            ->where('id_evento', (string) $courseid)
            ->order_by('nome', 'ASC')->order_by('id', 'ASC')
            ->get()->result();
    }

    public function fiscalizacao_inscritos($courseid = NULL)
    {
        $curso = $this->curso_fiscalizacao($courseid);
        if (!$curso) return;
        $inscritos = $this->inscritos_fiscalizacao($courseid);
        $token = $this->session->userdata('fiscalizacao_presencas_csrf');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $this->session->set_userdata('fiscalizacao_presencas_csrf', $token);
        }
        $presencas = [];
        foreach ($inscritos as $inscrito) {
            if ((int) $inscrito->presenca === 1) $presencas[] = (int) $inscrito->id_inscricao;
        }
        $data = [
            'curso' => [$curso], 'courseid' => (string) $courseid,
            'inscritos' => $inscritos, 'presencas' => $presencas, 'presencas_csrf' => $token
        ];
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/fiscalizacao_inscritos', $data);
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
        $token = $this->session->userdata('fiscalizacao_presencas_csrf');
        if (!$token || !is_array($payload) || !is_string($payload['csrf'] ?? NULL) || !hash_equals($token, $payload['csrf'])) {
            $this->output->set_status_header(403)->set_output(json_encode(['ok' => FALSE, 'message' => 'Sessão inválida. Recarregue a página.']));
            return;
        }
        if (!$this->curso_fiscalizacao($courseid)) return;
        $alteracoes = $payload['alteracoes'] ?? NULL;
        $ids = array_map('intval', array_column($this->inscritos_fiscalizacao($courseid), 'id_inscricao'));
        if (!is_array($alteracoes) || count($alteracoes) > count($ids)) {
            $this->output->set_status_header(400)->set_output(json_encode(['ok' => FALSE, 'message' => 'Alterações inválidas.']));
            return;
        }
        foreach ($alteracoes as $id => $presente) {
            if (!ctype_digit((string) $id) || !in_array((int) $id, $ids, TRUE) || !is_bool($presente)) {
                $this->output->set_status_header(400)->set_output(json_encode(['ok' => FALSE, 'message' => 'Inscrito ou presença inválida.']));
                return;
            }
        }
        $this->db->trans_begin();
        foreach ($alteracoes as $id => $presente) {
            $this->db->where('id', (int) $id)->where('id_evento', (string) $courseid)
                ->update('fiscalizacao_humanizada_inscricao', ['presenca' => $presente ? 1 : 0]);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->output->set_status_header(503)->set_output(json_encode(['ok' => FALSE, 'message' => 'Não foi possível salvar. Tente novamente.']));
            return;
        }
        $this->db->trans_commit();
        $this->output->set_output(json_encode(['ok' => TRUE]));
    }

    public function exportar_excel($courseid = NULL)
    {
        $curso = $this->curso_fiscalizacao($courseid);
        if (!$curso) return;
        $inscritos = $this->inscritos_fiscalizacao($courseid);
        $escape = function ($texto) { return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8'); };
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="fiscalizacao_inscritos_'.(string) $courseid.'.xls"');
        header('Cache-Control: no-store');
        echo "\xEF\xBB\xBF";
        echo '<html><head><meta charset="UTF-8"></head><body><table border="1">';
        echo '<tr><th colspan="5">'.$escape($curso->titulo).'</th></tr>';
        echo '<tr><th>Nome</th><th>CPF</th><th>E-mail</th><th>Telefone</th><th>Data da inscrição</th></tr>';
        foreach ($inscritos as $aluno) {
            echo '<tr><td>'.$escape($aluno->nome_completo).'</td>';
            echo '<td style="mso-number-format:\'\\@\';">'.$escape($aluno->cpf).'</td>';
            echo '<td>'.$escape($aluno->email).'</td>';
            echo '<td style="mso-number-format:\'\\@\';">'.$escape($aluno->telefone).'</td>';
            echo '<td>'.$escape($aluno->data_inscricao).'</td></tr>';
        }
        echo '</table></body></html>';
    }

    public function lista_portaria($courseid = NULL)
    {
        $curso = $this->curso_fiscalizacao($courseid);
        if (!$curso) return;
        require_once FCPATH . 'vendor/autoload.php';
        $html = $this->load->view('restrito/pdfs/lista_portaria_pdf', [
            'curso' => $curso, 'inscritos' => $this->inscritos_fiscalizacao($courseid)
        ], TRUE);
        try {
            $pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'pt');
            $pdf->setDefaultFont('dejavusans');
            $pdf->writeHTML($html);
            $pdf->output('Lista_Portaria_Fiscalizacao_'.(string) $courseid.'.pdf', 'I');
        } catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
            log_message('error', 'Falha ao gerar Lista Portaria da fiscalizacao '.(string) $courseid);
            show_error('Não foi possível gerar a Lista Portaria.', 500);
        }
    }

}
