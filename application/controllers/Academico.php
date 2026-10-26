<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Academico  extends MY_Controller {


	public function index()
	{
	
		$this->load->view('fixo/cabecalho');
		$this->load->view('merito_academico.php');
		//$this->load->view('embreve');
		$this->load->view('fixo/rodape');
	}
}
