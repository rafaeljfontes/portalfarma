<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interativo extends MY_Controller {

	public function index()
	{
	
		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		$arrayDados['areaInteresse'] = $this->capacifar_model->query('SELECT * FROM tbl_capacifar_areas');
		
		// echo file_get_contents("cidades.json");
		// $Json = file_get_contents("./cidades.json");

		// $myarray = json_decode($Json, true);
		// var_dump($myarray); // prints array
		
		$this->load->view('fixo/cabecalho');
		$this->load->view('interativo', $arrayDados);
		$this->load->view('fixo/rodape');
	}
}