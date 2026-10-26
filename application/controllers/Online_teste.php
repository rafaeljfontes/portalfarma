<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online_teste extends MY_Controller {


	public function index()
	{
		//echo "aqui";
		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = $this->uri->segment('2');
		print_r($id);//exit;
		//$categoria  = $this->uri->segment('4');
		//print_r($categoria);exit;
		
		
		$query = "SELECT tc.categoria, COUNT(tc.id) as 'qtd' FROM tbl_capacifar tc GROUP BY tc.categoria";
		$arrayDados['tabelaCategoria'] = $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCursos($id);
		

		$this->load->view('fixo/cabecalho');
		$this->load->view('online_teste', $arrayDados);
		$this->load->view('fixo/rodape');
	}
	
	public function categoria()
	{
		//echo "aqui";
		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		if(empty($this->input->post('categoria'))){
			$categoria  = "WHERE tc.categoria = '".$this->uri->segment('3')."' ";
		} else if($this->input->post('categoria') == 'todas') {
			$categoria = "";
		} else if (empty($this->uri->segment('3'))){
			$categoria = "";
		} else {
			$categoria = "WHERE tc.categoria = '".$this->input->post('categoria')."' ";
		}
		
		//print_r($categoria);//exit;
		
		$query 		= "SELECT tc.categoria, COUNT(tc.id) as 'qtd' FROM tbl_capacifar tc GROUP BY tc.categoria";
		$qry_cat 	= "SELECT * FROM `17_congresso`.tbl_capacifar tc  ".$categoria."";
		
		$arrayDados['tabelaCategoria'] = $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] = $this->capacifar_model->query($qry_cat);
		

		$this->load->view('fixo/cabecalho');
		$this->load->view('online_teste', $arrayDados);
		$this->load->view('fixo/rodape');
	}
	
	public function buscaCurso()
	{
	
	
	}
}