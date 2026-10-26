<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plenaria extends MY_Controller {

    public function __construct()
	{
		parent::__construct();
		require_once FCPATH . 'vendor/autoload.php';		
		$dados = array();
        //$this->load->model('capacifar_model');
        $this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
	}

    public function index()
    {	
		$arrayDados = [];
		
		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		$this->db->order_by('data_plenaria', 'ASC');
		$plenarias = $this->db->get('tbl_portalfarma_plenaria_tecnica')->result();

			// Processa e formata as datas antes de mandar para a View
			foreach ($plenarias as $item) {
				// 1. Limpa a string removendo espaços soltos nas pontas
				$data_limpa = trim($item->data_plenaria);
				
				// 2. Extrai o ano, mês e dia de forma segura usando o timestamp do PHP
				$timestamp = strtotime($data_limpa);
				
				// Se o strtotime falhar por algum motivo, definimos um timestamp padrão atual para não travar a tela
				if ($timestamp === false) {
					$timestamp = time(); 
				}

				// 3. Alimenta as variáveis que a View precisa
				$item->dia  = date('d', $timestamp);
				$item->hora = '13:00'; 

				// 4. Cria a tradução do mês para português sem depender do date_create()
				$meses_br = [
					'01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr',
					'05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago',
					'09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'
				];
				
				$numero_mes = date('m', $timestamp); // Pega o número do mês (01 a 12)
				$item->mes  = isset($meses_br[$numero_mes]) ? $meses_br[$numero_mes] : 'S/M';
			}

			$dados['plenarias'] = $plenarias;
		
		
		//$this->carregarCabecalho();
		$this->carregarCabecalho($arrayDados);
		$this->load->view('plenaria', $dados);
		$this->load->view('fixo/rodape');
    }
	
}