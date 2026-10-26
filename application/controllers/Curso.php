<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Curso  extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
		$this->load->library('email');
		$this->load->helper(['url', 'form', 'text']);
	}

	public function listar()
	{
		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = $this->uri->segment('3');
		
		
		$arrayDados['total_alunos'] 		= $this->Moodle_api->total_alunos_curso($id);
		
		//var_dump($arrayDados['tabelaCursosMoodle']);
		
		$listar_matriculados = $this->Moodle_model->listar_matriculados($id);
		$arrayDados['total_inscritos'] = count($listar_matriculados);

			$prog = "SELECT tpp.data_hora_inicial, tpp.hora_final, tpp.descricao, tpp.palestra  FROM web_site.tbl_portalfarma_programacao AS tpp wHERE tpp.status = 1 AND tpp.courseid = " . $id . ";";

		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCursosPortalFarma('tpf.status in (0,1,2) AND tpf.courseid = '.$id, 'tpf.data_cadastro DESC');

		$arrayDados['programacao'] = $this->capacifar_model->query($prog);

		$queryPalestrantes = "
        SELECT 
            p.id_palestrante,
            p.nome,
            p.`curriculo`,
            p.foto,
            p.link
        FROM tbl_portalfarma_palestrantes p
        INNER JOIN tbl_portalfarma_palestrantes_curso pc
            ON pc.id_palestrante = p.id_palestrante
        WHERE pc.courseid = " . $id . "
   		";

		$arrayDados['palestrantes'] = $this->capacifar_model->query($queryPalestrantes);

		// =========================================
		// ÁREAS / ÍCONES - ADICIONE AQUI
		// =========================================
		$arrayDados['areas_icons'] = [
			'Alimentos'           => ['icone' => 'fa-solid fa-carrot', 'cor' => '#f97316,#fb923c'],
			'Análises Clínicas'   => ['icone' => 'fa-solid fa-flask', 'cor' => '#9333ea,#a855f7'],
			'Clínica'             => ['icone' => 'fa-solid fa-heart-pulse', 'cor' => '#ef4444,#f87171'],
			'Educação'            => ['icone' => 'fa-solid fa-graduation-cap', 'cor' => '#10b981,#34d399'],
			'Farmácia'            => ['icone' => 'fa-solid fa-capsules', 'cor' => '#0ea5e9,#3b82f6'],
			'Gestão'              => ['icone' => 'fa-solid fa-chart-line', 'cor' => '#facc15,#eab308'],
			'Hospitalar'          => ['icone' => 'fa-solid fa-hospital', 'cor' => '#8b5cf6,#a78bfa'],
			'Industrial'          => ['icone' => 'fa-solid fa-industry', 'cor' => '#f43f5e,#fb7185'],
			'Magistral'           => ['icone' => 'fa-solid fa-mortar-pestle', 'cor' => '#8b5cf6,#a78bfa'],
			'PICs'                => ['icone' => 'fa-solid fa-leaf', 'cor' => '#22c55e,#4ade80'],
			'Saúde Pública'       => ['icone' => 'fa-solid fa-users', 'cor' => '#14b8a6,#2dd4bf'],
			'Toxicologia'         => ['icone' => 'fa-solid fa-radiation', 'cor' => '#f97316,#fcd34d'],
			'Outros'              => ['icone' => 'fa-solid fa-layer-group', 'cor' => '#475569,#64748b'],
		];


		$this->carregarCabecalho($arrayDados);
		$this->load->view('course_view', $arrayDados);
		$this->load->view('fixo/rodape');
	}


	public function Inscricao()
	{
		//echo 'asdasd';exit;
		$dados = array();


		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = $this->uri->segment('3');

		//$arrayDados['tabelaCategoria'] 	= $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.status = 1 AND tpf.courseid = '.$id, 'tpf.data_cadastro DESC');
		$arrayDados['capacifar_tipo'] 		= 'Online';

		$this->carregarCabecalho($arrayDados);
		$this->load->view('inscricao', $arrayDados);
		//$this->load->view('fixo/rodape');
	}

	public function Inscricao_estrangeiro()
	{
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id = $this->uri->segment('3');
		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCursosPortalFarma('tpf.status = 1 AND tpf.courseid = '.(int) $id, 'tpf.data_cadastro DESC');
		$arrayDados['capacifar_tipo'] = 'Online';

		$this->carregarCabecalho($arrayDados);
		$this->load->view('inscricao_estrangeiro', $arrayDados);
	}
	
	public function Inscricao_teste()
	{
		//echo 'asdasd';exit;
		$dados = array();


		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = $this->uri->segment('3');

		//$arrayDados['tabelaCategoria'] 	= $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.status = 1 AND tpf.courseid = '.$id, 'tpf.data_cadastro DESC');
		$arrayDados['capacifar_tipo'] 		= 'Online';


		$this->carregarCabecalho($arrayDados);
		$this->load->view('inscricao_teste', $arrayDados);
		//$this->load->view('fixo/rodape');
	}

	public function Inscricao_english()
	{
		$id = (int) $this->uri->segment('3');
		if ($id <= 0) show_404();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCursosPortalFarma('tpf.status = 1 AND tpf.courseid = '.$id, 'tpf.data_cadastro DESC');
		$arrayDados['capacifar_tipo'] = 'Online';

		$this->carregarCabecalho($arrayDados);
		$this->load->view('inscricao_english', $arrayDados);
	}
}
