<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ACasaeSua  extends MY_Controller {


	public function index()
	{
		//echo"AAAAAAAAAAAAAAA";exit;
		$this->load->view('fixo/cabecalho');
		$this->load->view('acasaesua');
		//$this->load->view('embreve');
		$this->load->view('fixo/rodape');
	}
}
