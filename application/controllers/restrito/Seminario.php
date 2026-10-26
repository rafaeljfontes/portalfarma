<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ACESSO RESTRITO / LOGIN

class Seminario extends CI_Controller {

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
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('login');
		$this->load->view('restrito/fixo/rodape');
	}
	
	public function listar() {
	
		$dados = array();
		
		$url_filtro = $this->uri->segment('4');
		
		//echo $url_filtro; //exit;
		
		
		if ($url_filtro == 'ativos'){
			$filtro = 'AND tpf.status = 1';
		} elseif ($url_filtro == 'inativos') {
			$filtro = 'AND tpf.status = 0';
		} else {
			$filtro = 'AND tpf.status in (0,1)';
		}
		
		
		$listaCursos = "SELECT
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
						WHERE tpf.tipo_evento = 7 ".$filtro."
						GROUP BY tpf.id
						ORDER BY tpf.data_cadastro DESC, tpf.data_fim DESC;";
		
		$query = "SELECT
					s.seminario,
					tp.titulo,
					tp.data_inicio,
					SUM(CASE WHEN LOWER(s.tipo_participacao) = 'online' THEN 1 ELSE 0 END) AS total_online,
					SUM(CASE WHEN LOWER(s.tipo_participacao) = 'presencial' THEN 1 ELSE 0 END) AS total_presencial
				FROM 
					tbl_seminario_inscricao s
				INNER JOIN 
					tbl_portalfarma tp ON tp.courseid = s.seminario 
				WHERE 
					s.tipo_participacao IN ('online', 'presencial')
				GROUP BY
					s.seminario,
					tp.titulo,
					tp.data_inicio
				ORDER BY tp.data_inicio DESC, tp.titulo ASC;";
		
		
		$arrayDados['tabelaincricoes'] 	= $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->query($listaCursos);

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/seminario_listar', $arrayDados);
		$this->load->view('restrito/fixo/rodape');
    }
	
	public function dashboard($courseid) {
    
			// Busca os dados (agora retorna um array com 'titulo' e 'lista')
			$dados_seminario = $this->capacifar_model->get_stats_seminario($courseid);
			
			// Monta o título conforme você solicitou
			$data['titulo'] = "Estatísticas do Seminário: " . $courseid . " - " . $dados_seminario['titulo'];
			
			// Passa a lista de estatísticas para a view
			$data['stats'] = $dados_seminario['lista'];
    
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/seminario_stats_view', $data);
		$this->load->view('restrito/fixo/rodape');
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

		$seminario = $this->db
			->select('id, courseid')
			->from('tbl_portalfarma')
			->where('courseid', $courseid)
			->where('tipo_evento', 7)
			->get()
			->row();

		if (!$seminario) {
			return $this->json_response([
				'status' => 'error',
				'message' => 'Seminário não encontrado.'
			], 404);
		}

		$this->db->where('id', $seminario->id);
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
				? 'Marcação de presença liberada para este seminário.'
				: 'Marcação de presença bloqueada para este seminário.',
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
