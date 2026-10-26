<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presencial  extends MY_Controller {


	public function index()
	{
	
		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = 0;
		
		$qry_courseid 			= "SELECT course_id FROM tbl_capacifar WHERE tipo_curso = 0";
		$arraycourseid 			= $this->capacifar_model->query($qry_courseid);
		
				
		$course_ids = array_map(function($item) {
			return $item->course_id;
		}, $arraycourseid);
		
		$courseid = '(' . implode(',', $course_ids) . ')';
		
		
		 ///API BUSCA DADOS PELO CPF
			 $curl = curl_init();
			 curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_rel_all_mdl_course.php'  );
			 curl_setopt( $curl, CURLOPT_POST, true );
			 curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				 'courseid' 	=> $courseid,
			 ));
			 curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			 $response = json_decode( curl_exec( $curl ), true);
			 curl_close($curl);
		
		$arrayDados['tabelaCursosAva'] 		= $response;
		
		$query 		= "SELECT cat.categoria, COUNT(cat.id_categoria) as 'qtd' FROM tbl_capacifar_categorias cat inner join tbl_capacifar_categoria_curso cc ON cc.id_categoria = cat.id_categoria inner join tbl_capacifar tc ON tc.id = cc.id_curso WHERE tc.tipo_curso = 0 GROUP BY cat.categoria";
		
		$listaCursos = "SELECT * FROM `web_site`.tbl_capacifar tc WHERE tipo_curso = 0 ORDER BY data_fim desc";
		
		
		$arrayDados['tabelaCategoria'] 	= $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->query($listaCursos);

		$this->load->view('fixo/cabecalho');
		$this->load->view('presencial', $arrayDados);
		$this->load->view('fixo/rodape');
	}
	
	public function categoria()
	{
		//echo "aqui";
		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		//print_r($this->input->post('categoria'));
		//print_r('-'.$this->uri->segment('3'));
		
		if(!empty($this->input->post('categoria') && $this->input->post('categoria') != 'todas')){
			$categoria = "AND tc.categoria = '".$this->input->post('categoria')."' ";
		} else if($this->input->post('categoria') == 'todas') {
			$categoria = "";
		} else if (!empty($this->uri->segment('3'))){
			$categoria  = "AND tc.categoria = '".$this->uri->segment('3')."' ";
		} else {
			$categoria = "";
		}
		
		
		$query 		= "SELECT cat.categoria, COUNT(cat.id_categoria) as 'qtd' FROM tbl_capacifar_categorias cat inner join tbl_capacifar_categoria_curso cc ON cc.id_categoria = cat.id_categoria inner join tbl_capacifar tc ON tc.id = cc.id_curso WHERE tc.status = 1 AND tc.tipo_curso = 0 GROUP BY cat.categoria";
		$qry_cat 	= "SELECT * FROM `web_site`.tbl_capacifar tc WHERE tc.status = 1 AND tc.tipo_curso = 0 ".$categoria."";
		
		//print_r($qry_cat);exit;
		
		$arrayDados['tabelaCategoria'] = $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] = $this->capacifar_model->query($qry_cat);
		

		$this->load->view('fixo/cabecalho');
		$this->load->view('online', $arrayDados);
		$this->load->view('fixo/rodape');
	}
	
	public function buscaCurso()
	{
	
	
	}
}
