<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Portalfarma extends MY_Controller
{


	public function Presencial()
	{
		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = 0;

		/*$qry_courseid 		= "SELECT courseid FROM tbl_portalfarma";
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
		*/

		//$arrayDados['tabelaCategoria'] 	= $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.status = 1 AND tpf.tipo_evento = 1', 'tpf.data_fim DESC');
		$arrayDados['capacifar_tipo'] 	= 'Presencial';

		$arrayDados = [];

		$this->carregarCabecalho($arrayDados);
		$this->load->view('capacifar', $arrayDados);
		$this->load->view('fixo/rodape');
	}

	public function Online()
	{

		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = 0;

		/*$qry_courseid 		= "SELECT courseid FROM tbl_portalfarma";
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
		*/

		//$arrayDados['tabelaCategoria'] 	= $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.status = 1 AND tpf.tipo_evento = 2', 'tpf.data_fim DESC');
		$arrayDados['capacifar_tipo'] 		= 'Online';

		$this->carregarCabecalho($arrayDados);
		$this->load->view('capacifar', $arrayDados);
		$this->load->view('fixo/rodape');
	}


	public function detalhe()
	{
		//print_r('entremo');
		//exit;

		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = $this->uri->segment('3');
		//$id = 1;
		//print_r($id);exit;
		$arrayDados['tabelaCurso'] = $this->capacifar_model->listaCursosPortalFarma('tpf.status = 1 AND tpf.tipo_evento = 2 AND tpf.courseid = '.$id, 'tpf.data_fim DESC');


		$this->load->view('fixo/cabecalho');
		$this->load->view('course_view', $arrayDados);
		$this->load->view('fixo/rodape');
	}

	public function Inscricao()
	{

		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		$id  = $this->uri->segment('3');

		//$arrayDados['tabelaCategoria'] 	= $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] 		= $this->capacifar_model->listaCursosPortalFarma('tpf.status = 1 AND tpf.tipo_evento = 2 AND tpf.courseid = '.$id, 'tpf.data_fim DESC');
		$arrayDados['capacifar_tipo'] 		= 'Online';

		$this->carregarCabecalho($arrayDados);
		$this->load->view('inscricao', $arrayDados);
		$this->load->view('fixo/rodape');
	}

	public function categoria()
	{
		//echo "aqui";
		$arrayDados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);

		if (empty($this->input->post('categoria'))) {
			$categoria  = "WHERE tc.categoria = '" . $this->uri->segment('3') . "' ";
		} else if ($this->input->post('categoria') == 'todas') {
			$categoria = "";
		} else if (empty($this->uri->segment('3'))) {
			$categoria = "";
		} else {
			$categoria = "WHERE tc.categoria = '" . $this->input->post('categoria') . "' ";
		}

		//print_r($categoria);//exit;

		$query 		= "SELECT tc.categoria, COUNT(tc.id) as 'qtd' FROM tbl_capacifar tc GROUP BY tc.categoria";
		$qry_cat 	= "SELECT * FROM `17_congresso`.tbl_capacifar tc  " . $categoria . "";

		$arrayDados['tabelaCategoria'] = $this->capacifar_model->query($query);
		$arrayDados['tabelaCurso'] = $this->capacifar_model->query($qry_cat);


		$this->carregarCabecalho($arrayDados);
		$this->load->view('online_teste', $arrayDados);
		$this->load->view('fixo/rodape');
	}

	public function buscaCurso() {}

	public function entrar()
	{
		$arrayDados = [];

		$this->carregarCabecalho($arrayDados);
		$this->load->view('entrar');
		$this->load->view('fixo/rodape');
	}
}
