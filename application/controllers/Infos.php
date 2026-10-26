<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Infos extends MY_Controller {


	public function index()
	{
	
		$dados = array();

		$this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		
		$listaCursos			= "SELECT tc.course_id  FROM web_site.tbl_capacifar tc WHERE tc.tipo_curso = 1 ORDER BY tc.course_id DESC";
		$listaCursosPresencial	= "SELECT tc.course_id  FROM web_site.tbl_capacifar tc WHERE tc.tipo_curso = 0 ORDER BY tc.course_id DESC";
		
		$arraycursosOnline	= $this->capacifar_model->query($listaCursos);
		$arraycursosPres	= $this->capacifar_model->query($listaCursosPresencial);
		
		//CURSOS ONLINE
		$total = count($arraycursosOnline);
		$i = 0;
		$x = '(';
		foreach ($arraycursosOnline as $curso) {
			if ($i == $total - 1) {
				$x .= $curso->course_id;
			} else {
				$x .= $curso->course_id . ",";
			}
			$i++;
		}
		$x .= ')';
		
		//CURSOS ONLINE
		$total = count($arraycursosPres);
		$i = 0;
		$y = '(';
		foreach ($arraycursosPres as $curso) {
			if ($i == $total - 1) {
				$y .= $curso->course_id;
			} else {
				$y .= $curso->course_id . ",";
			}
			$i++;
		}
		$y .= ')';
		//echo $x;
		
		$courseid 			= $x;
		$courseidpresencial = $y;
		
		
		$FH_id_evento 	= "5";
		$SV_id_evento 	= "5";
		 ///API BUSCA DADOS PELO CPF
			 $curl = curl_init();
			 curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_rel_all_mdl_course.php'  );
			 curl_setopt( $curl, CURLOPT_POST, true );
			 curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				 'courseid' 	=> $courseid,
			 ));
			 curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			 $online = json_decode( curl_exec( $curl ), true);
			 curl_close($curl);
			 
			 
			 ///API BUSCA DADOS PELO CPF
			 $curl = curl_init();
			 curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_rel_all_mdl_course.php'  );
			 curl_setopt( $curl, CURLOPT_POST, true );
			 curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				 'courseid' 	=> $courseidpresencial,
			 ));
			 curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			 $presencial = json_decode( curl_exec( $curl ), true);
			 curl_close($curl);
		
		$seminario 	= "SELECT CASE WHEN tipo_inscricao = 0 THEN 'Presencial' ELSE 'Online' END AS 'tipo', COUNT(DISTINCT id) AS 'qtd' FROM crfmg_acesso_restrito.evento_seminario_vs2_inscricao where id_seminario = $SV_id_evento GROUP BY CASE WHEN tipo_inscricao = 0 THEN 'Presencial' ELSE 'Online' END;";
		$fischum 	= "SELECT COUNT(ID) as quantdade FROM fiscalizacao_humanizada_inscricao fh WHERE fh.id_evento = $FH_id_evento ";
		$saudemu 	= "SELECT tipo_inscricao, COUNT(DISTINCT id) AS 'Qtd' FROM saude_da_mulher_inscricao GROUP BY tipo_inscricao";
		$saudemu_farmas 	= "SELECT tipo_inscricao as inscricao, COUNT(DISTINCT id) AS 'Qtd' FROM saude_da_mulher_inscricao where crfmg != '' GROUP BY tipo_inscricao";
		
		
		$arrayDados['tabelaCursosAva'] 			= $online;
		$arrayDados['arraycursosPres']		= $presencial;
		$arrayDados['tabelaSeminario'] 			= $this->capacifar_model->query($seminario);
		$arrayDados['tabelaHumanizada'] 		= $this->capacifar_model->query($fischum);
		$arrayDados['tabelaSaudemulher'] 		= $this->capacifar_model->query($saudemu);
		$arrayDados['tabelaSaudemulher_farmas'] = $this->capacifar_model->query($saudemu_farmas);

		//print_r($arrayDados['tabelaCursosAva']);	exit;

		$this->load->view('fixo/cabecalho');
		$this->load->view('infos', $arrayDados);
		$this->load->view('fixo/rodape');
	}
}