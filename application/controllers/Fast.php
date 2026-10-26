<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fast  extends MY_Controller {


	public function index()
	{
	
		//echo"AAAAAAAAAAAAAAA";exit;
		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCursos('Fast');

		$this->load->view('fixo/cabecalho');
		$this->load->view('fast', $arrayDados);
		$this->load->view('fixo/rodape');
	}
}
