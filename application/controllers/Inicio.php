<?php
	defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends MY_Controller{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
		$this->load->library('email');
		$this->load->helper(['url', 'form']);
	}

	public function index()
	{
		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = 0;

		$qry_courseid 			= "SELECT courseid FROM tbl_portalfarma WHERE tipo_evento in (1,2,7)";
		$arraycourseid 			= $this->capacifar_model->query($qry_courseid);


		$course_ids = array_map(function ($item) {
			return $item->courseid;
		}, $arraycourseid);

		//$courseid = '(' . implode(',', $course_ids) . ')';
		//$courseid = $course_ids;

		$courseid = '';
		foreach ($course_ids as $valor) {
			//$courseid = $valor . ', ';
			$total = $this->Moodle_model->total_inscritos_curso($courseid);
			//echo $total;
		}

		$courseid .= $total . ', ';
		
		/* Contador */
		$sql = "SELECT 
					p.courseid,
					p.tipo_evento,
					COUNT(inscritos.id) AS total_inscritos
				FROM tbl_portalfarma p
				LEFT JOIN (
					-- Inscrições da Fiscalização Humanizada (tipo 4)
					SELECT fh.id_evento AS course_id, id 
					FROM fiscalizacao_humanizada_inscricao fh    
					UNION ALL
					-- Convertendo o varchar 'seminario' para bater com o courseid se necessário
					SELECT seminario AS course_id, id 
					FROM tbl_seminario_inscricao
				) AS inscritos ON p.courseid = inscritos.course_id
				WHERE p.status = 1 
				  AND p.tipo_evento IN (4, 7)
				GROUP BY p.courseid, p.tipo_evento;";
				
		$urmsql = "SELECT COUNT(ui.id) AS total_inscritos
					FROM urm_inscricao ui
					WHERE YEAR(ui.data_inscricao) > 2026;";		
		
		$arrayDados['resultadosInscritos'] 		= $this->capacifar_model->query($sql);
		$arrayDados['URMInscritos'] 			= $this->capacifar_model->query($urmsql);

		$arrayDados['total_alunos'] 			= $this->Moodle_api->total_alunos();
		$arrayDados['contador_inscritos']    	= $this->Moodle_api->contador_inscritos();
		

		$listarpalestrante = "SELECT * FROM web_site.tbl_portalfarma_palestrantes tpp WHERE status = 1;";
		
		$sql = "SELECT 
					p.courseid,
					COUNT(inscritos.id) AS total_inscritos
				FROM tbl_portalfarma p
				LEFT JOIN (
					-- Inscrições da Fiscalização Humanizada (tipo 4)
					SELECT fh.id_evento AS course_id, id 
					FROM fiscalizacao_humanizada_inscricao fh    
					UNION ALL
					-- Convertendo o varchar 'seminario' para bater com o courseid se necessário
					SELECT seminario AS course_id, id 
					FROM tbl_seminario_inscricao
				) AS inscritos ON p.courseid = inscritos.course_id
				WHERE p.status = 1 
				  AND p.tipo_evento IN (4, 7)
				GROUP BY p.courseid;";
				
		$urmsql = "SELECT COUNT(ui.id) AS total_inscritos
					FROM urm_inscricao ui
				WHERE YEAR(ui.data_inscricao) >= 2026;";		
		
		$arrayDados['URMInscritos'] 			= $this->capacifar_model->query($urmsql);
		
		$arrayDados['resultadosInscritos'] 	= $this->capacifar_model->query($sql);
		$arrayDados['palestrantes'] 		= $this->capacifar_model->query($listarpalestrante);
		// Cursos de hoje em diante primeiro; os anteriores ficam no final.
		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCursosPortalFarma(
			'tpf.status = 1',
			'CASE WHEN tpf.data_inicio >= CURDATE() THEN 0 ELSE 1 END ASC, tpf.data_inicio ASC, tpf.data_fim DESC'
		);

		$this->carregarCabecalho($arrayDados);
		$this->load->view('inicio', $arrayDados);
		$this->load->view('fixo/rodape');
	}
}
