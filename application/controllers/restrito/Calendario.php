<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
		$this->dados = array();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
		$this->load->model('Password_model');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);

		if (!$this->session->userdata('usuario_logado')) {
			redirect('login');
			exit;
		}
    }
	
	public function index()
	{
		$lista = "SELECT
					DATE_FORMAT(c.data_inicio, '%Y-%m-%d') AS data_evento,
					c.courseid,
					c.titulo AS titulo_curso
				FROM 
					tbl_portalfarma AS c
				ORDER BY 
					c.data_inicio DESC;";

		$this->dados['tabelaCurso'] 	= $this->capacifar_model->query($lista);

		// 2. Carrega as views padrão do seu painel
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/calendario', $this->dados);
		$this->load->view('restrito/fixo/rodape');
	}
	
	public function get_detalhes_evento()
	{
		$courseid = trim((string) $this->input->post('courseid'));
		$data_evento = $this->input->post('data_evento'); // Recebe YYYY-MM-DD

		// Evita repetir no modal registros com os mesmos dados de exibição.
		$detalhe = "SELECT DISTINCT
					p.palestra AS titulo_programacao, 
					p.descricao, 
					p.hora_final,
					DATE_FORMAT(p.data_hora_inicial, '%H:%i') AS hora_inicio,
					DATE_FORMAT(p.data_hora_inicial, '%d/%m/%Y') AS data_ptbr,
					c.titulo AS titulo_curso,
					c.local,
					c.tipo_evento
				FROM 
					tbl_portalfarma_programacao AS p
				INNER JOIN 
					tbl_portalfarma AS c ON p.courseid = c.courseid
				WHERE 
					p.courseid = " . $this->db->escape($courseid) . "
					AND p.status = 1
					AND DATE(p.data_hora_inicial) = " . $this->db->escape($data_evento) . "
				ORDER BY hora_inicio ASC, p.hora_final ASC, titulo_programacao ASC;";
					
		
		//print_r($detalhe);
		$resultado 	= $this->capacifar_model->query($detalhe);
		//print_r($resultado);

		$curso = $this->db->get_where('tbl_portalfarma', ['courseid' => $courseid])->row();
		$totalInscritos = NULL;
		if ($curso) {
			$fontes = [
				3 => ['urm_inscricao', 'urm_evento'],
				4 => ['fiscalizacao_humanizada_inscricao', 'id_evento'],
				7 => ['tbl_seminario_inscricao', 'seminario']
			];
			$tipo = (int) $curso->tipo_evento;
			if (in_array($tipo, [1, 2, 5], TRUE)) {
				try {
					$totais = $this->Moodle_api->totais_inscritos_cursos([$courseid]);
					$totalInscritos = empty($totais) ? 0 : (int) $totais[0]->total_estudantes;
				} catch (Exception $e) {
					log_message('error', 'Calendario: contagem de inscritos indisponivel para curso ' . $courseid);
				}
			} elseif (isset($fontes[$tipo])) {
				list($tabela, $coluna) = $fontes[$tipo];
				$totalInscritos = $this->db->where($coluna, $courseid)->count_all_results($tabela);
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode([
			'programacao' => $resultado,
			'total_inscritos' => $totalInscritos,
			'tipo_evento' => $curso ? $curso->tipo_evento : NULL
		]));
	}
	
}
