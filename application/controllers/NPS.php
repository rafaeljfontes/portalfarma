<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nps extends CI_Controller {

	public function __construct() {
        parent::__construct();

		// A sessão pode expirar enquanto o usuário permanece em uma página do sistema.
		// Não carregue as views restritas nesse caso; envie-o novamente para o login.
		if (!$this->session->userdata('usuario_logado')) {
			redirect('login');
		}

		require_once FCPATH . 'vendor/autoload.php';
		$dados = array();
        $this->load->database();
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$this->load->model('palestrantes_model');
		$this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
		
    }

    
    public function listar() {
		$courseidSelecionado = trim((string) $this->input->get('courseid', true));
	
		$sql = "SELECT tp.courseid, tp.titulo 
				FROM tbl_portalfarma tp
				LEFT JOIN tbl_portalfarma_nps nps ON tp.courseid = nps.courseid
				GROUP BY tp.courseid, tp.titulo
				ORDER BY tp.titulo ASC;";
		
		$dados['cursos'] = $this->capacifar_model->query($sql);
		$dados['courseidSelecionado'] = $courseidSelecionado;

        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/nps_listar', $dados);
        $this->load->view('restrito/fixo/rodape');
    }

    /* MNTANDO GRÁFICO DE NPS */
    public function busca_nps() {
    $courseid = $this->input->post('courseid');

		if (empty($courseid)) {
			echo json_encode(
				['status' => 'error', 
				'mensagem' => 'Curso não selecionado.']);
			return;
		}
		
		// 1. Busca os dados de NPS (Sua query atual)
		$sql = "SELECT nps.* FROM tbl_portalfarma_nps nps WHERE nps.courseid = '".$courseid."';";
		$notas = $this->capacifar_model->query($sql);
		$total_votos = count($notas);
		
		// 2. Busca o número total de inscritos neste curso
		$listar = "SELECT c.* FROM tbl_portalfarma c WHERE courseid = '".$courseid."';";
		$curso 	= $this->capacifar_model->query($listar);
		$dataInicioCurso = (!empty($curso) && !empty($curso[0]->data_inicio))
			? strtotime($curso[0]->data_inicio)
			: false;
		$dataLimiteAssincrono = $dataInicioCurso !== false
			? strtotime('+48 hours', $dataInicioCurso)
			: false;
		
		// Pegando o tipo de evento 
			if (!empty($curso) && is_array($curso)) {
				// Pega o primeiro objeto do array
				$obj = $curso[0];

				// Verifica se é um objeto e se tem a propriedade
				if (is_object($obj) && isset($obj->tipo_evento)) {
					$tipoEvento = $obj->tipo_evento;
				}
			}
		
			if($tipoEvento == '1' || $tipoEvento == '2' || $tipoEvento == '5'){/* CAPACIFAR */
		
				$res_inscritos 	= $this->Moodle_api->total_inscritos_cursos($courseid);
			
			} elseif ($tipoEvento == '3') {/* URM */
			
				$sql = "SELECT COUNT(*) as total FROM urm_inscricao i WHERE i.urm_evento = '".$courseid."' ORDER BY i.nome;";
					$res_inscritos 	= $this->capacifar_model->query($sql);
			} elseif ($tipoEvento == '4') {/* FISCALIZAÇÃO HUMANIZADA */
			
				$sql = "SELECT COUNT(*) as total FROM fiscalizacao_humanizada_inscricao f WHERE f.id_evento = '".$courseid."' ORDER BY f.nome;";
					$res_inscritos 	= $this->capacifar_model->query($sql);
			} elseif ($tipoEvento == '7') { /* SEMINÁRIOS */
			
				$sql = "SELECT 
							COUNT(*) as total FROM tbl_seminario_inscricao s 
							WHERE s.seminario = '".$courseid."'
							ORDER BY s.nome;";
					$res_inscritos 	= $this->capacifar_model->query($sql);
			}
		
		// Pega o resultado do COUNT (ajuste o mapeamento se o seu model retornar array)
		$total_inscritos = isset($res_inscritos[0]->total) ? (int)$res_inscritos[0]->total : 0;
		

		if ($total_votos === 0) {
			echo json_encode([
				'status' => 'empty', 
				'mensagem' => 'Nenhuma avaliação encontrada para este curso.',
				'total_inscritos' => $total_inscritos // Enviamos mesmo se não houver votos
			]);
			return;
		}

		$promotores = 0;
		$neutros    = 0;
		$detratores = 0;
		
		// Criamos um array para armazenar os comentários/respostas formatados
		$lista_respostas = [];

		foreach ($notas as $item) {
			$nota_num = (int) $item->escala; // Ajustado conforme erro anterior

			// Classificação das notas
			if ($nota_num >= 9) {
				$promotores++;
				$classe_feedback = 'success'; // Verde para promotor
			} elseif ($nota_num >= 7) {
				$neutros++;
				$classe_feedback = 'warning'; // Amarelo para neutro
			} else {
				$detratores++;
				$classe_feedback = 'danger';  // Vermelho para detrator
			}

			// Se houver um texto digitado pelo usuário, adicionamos na lista			
			$lista_respostas[] = [
				'nota'   => $nota_num,
				'classe' => $classe_feedback,
				'tipo'   => ($dataInicioCurso !== false
					&& !empty($item->data_cadastro)
					&& strtotime($item->data_cadastro) >= $dataInicioCurso
					&& strtotime($item->data_cadastro) <= $dataLimiteAssincrono)
						? 'assincrono'
						: 'nao_assincrono',
				'respA'  => !empty($item->perguntaA) ? $item->perguntaA : '-',
				'respB'  => !empty($item->perguntaB) ? $item->perguntaB : '-',
				'respC'  => !empty($item->perguntaC) ? $item->perguntaC : '-',
				'respD'  => !empty($item->perguntaD) ? $item->perguntaD : '-',
				'respE'  => !empty($item->perguntaE) ? $item->perguntaE : '-',
				'data_cadastro' => !empty($item->data_cadastro) && strtotime($item->data_cadastro) !== false
					? date('d/m/Y H:i', strtotime($item->data_cadastro))
					: '-'
			];
			
		}

		$pct_promotores = round(($promotores / $total_votos) * 100, 1);
		$pct_neutros    = round(($neutros / $total_votos) * 100, 1);
		$pct_detratores = round(($detratores / $total_votos) * 100, 1);
		$score_nps = round($pct_promotores - $pct_detratores);

		if ($score_nps >= 75) { $zona = 'Zona de Excelência'; $zona_cor = '#198754'; }
		elseif ($score_nps >= 50) { $zona = 'Zona de Qualidade'; $zona_cor = '#0d6efd'; }
		elseif ($score_nps >= 0) { $zona = 'Zona de Aperfeiçoamento'; $zona_cor = '#ffc107'; }
		else { $zona = 'Zona Crítica'; $zona_cor = '#dc3545'; }

		$retorno = [
			'status' => 'success',
			'periodo_curso' => [
				'inicio' => !empty($curso[0]->data_inicio) && strtotime($curso[0]->data_inicio) !== false
					? date('d/m/Y H:i', strtotime($curso[0]->data_inicio))
					: '-',
				'fim' => !empty($curso[0]->data_fim) && strtotime($curso[0]->data_fim) !== false
					? date('d/m/Y H:i', strtotime($curso[0]->data_fim))
					: '-'
			],
			'metricas' => [
				'total'       => $total_votos,
				'inscritos'   => $total_inscritos,
				'score'       => $score_nps,
				'zona'        => $zona,
				'zona_cor'    => $zona_cor,
				'promotores'  => $promotores,
				'neutros'     => $neutros,
				'detratores'  => $detratores,
				'pct_prom'    => $pct_promotores,
				'pct_neu'     => $pct_neutros,
				'pct_det'     => $pct_detratores
			],
			'respostas' => $lista_respostas // <-- Passando a tabela de respostas!
		];

		echo json_encode($retorno);
	}

	public function exportar_pdf() {
		$id = trim((string) $this->input->post('courseid'));
		$grafico = (string) $this->input->post('grafico');
		if ($id === '') show_error('Curso não selecionado.', 400);

		$cursos = $this->capacifar_model->query("SELECT courseid,titulo,tipo_evento,data_inicio,data_fim FROM tbl_portalfarma WHERE courseid=".$this->db->escape($id)." LIMIT 1");
		$notas = $this->capacifar_model->query("SELECT escala,perguntaA,perguntaB,perguntaC,perguntaD,perguntaE FROM tbl_portalfarma_nps WHERE courseid=".$this->db->escape($id));
		if (!$cursos || !$notas) show_error('Curso ou avaliações não encontrados.', 404);
		$curso = $cursos[0]; $tipoId = (int)$curso->tipo_evento;
		$tipos = [
			1 => 'Capacifar Presencial',
			2 => 'Capacifar On-line',
			3 => 'URM',
			4 => 'Fiscalização Humanizada',
			5 => 'Universitário Presencial',
			6 => 'Universitário On-line',
			7 => 'Seminário de Vigilância e Saúde'
		];
		$tipo = $tipos[$tipoId] ?? 'Evento';
		$meses = [1=>'Janeiro',2=>'Fevereiro',3=>'Março',4=>'Abril',5=>'Maio',6=>'Junho',7=>'Julho',8=>'Agosto',9=>'Setembro',10=>'Outubro',11=>'Novembro',12=>'Dezembro'];
		$dataCurso = 'Data não informada';
		if (!empty($curso->data_inicio) && strtotime($curso->data_inicio) !== false) {
			$timestampCurso = strtotime($curso->data_inicio);
			$dataCurso = date('d', $timestampCurso).' de '.$meses[(int)date('n', $timestampCurso)].' de '.date('Y', $timestampCurso);
		}

		if (in_array($tipoId,[1,2,5],true)) $ri=$this->Moodle_api->total_inscritos_cursos($id);
		elseif ($tipoId===3) $ri=$this->capacifar_model->query("SELECT COUNT(*) total FROM urm_inscricao WHERE urm_evento=".$this->db->escape($id));
		elseif ($tipoId===4) $ri=$this->capacifar_model->query("SELECT COUNT(*) total FROM fiscalizacao_humanizada_inscricao WHERE id_evento=".$this->db->escape($id));
		elseif ($tipoId===7) $ri=$this->capacifar_model->query("SELECT COUNT(*) total FROM tbl_seminario_inscricao WHERE seminario=".$this->db->escape($id));
		else $ri=[];
		$inscritos = isset($ri[0]->total) ? (int)$ri[0]->total : 0;

		$p=$n=$d=0;
		foreach ($notas as $r) { $v=(int)$r->escala; if($v>=9)$p++; elseif($v>=7)$n++; else$d++; }
		$total=count($notas); $pp=round($p/$total*100,1); $pn=round($n/$total*100,1); $pd=round($d/$total*100,1);
		$score=round($pp-$pd);
		if($score>=75){$zona='Zona de Excelência';$zc='#198754';}
		elseif($score>=50){$zona='Zona de Qualidade';$zc='#0d6efd';}
		elseif($score>=0){$zona='Zona de Aperfeiçoamento';$zc='#ffc107';}
		else{$zona='Zona Crítica';$zc='#dc3545';}

		$e=static function($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');};
		$cel=static function($v)use($e){$v=trim((string)$v);return $v===''?'-':nl2br($e($v));};
		$titulo=$e($id.' - '.mb_strtoupper($curso->titulo,'UTF-8')); $tipoHtml=$e($tipo); $dataHtml=$e($dataCurso);
		$css='<style>
		body{font-family:helvetica,sans-serif;color:#263238}.titulo{color:#003b5c;font-size:19pt;font-weight:bold;text-align:center;border-bottom:2px solid #006080;padding-bottom:8px}.tipo{text-align:center;color:#667085;font-size:11pt;padding-top:5px}.data{text-align:center;color:#667085;font-size:10pt;padding-top:3px}
		.painel,.metricas{width:100%;border-collapse:collapse;margin-top:16px}.card{border:1px solid #d0d5dd;vertical-align:middle}.scoretab{width:100%;border-collapse:collapse}.scoretab td{border:0;text-align:center}.rot{color:#667085;font-size:8pt}.score{font-size:48pt;color:#343a40}.zona{color:'.$zc.';font-size:8pt;font-weight:bold;text-align:center;border-top:1px solid #e4e7ec;padding:10px}.info{color:#667085;font-size:8pt;text-align:center;border-top:1px solid #e4e7ec;padding:10px}
		.gtit{color:#667085;font-size:14pt;text-align:left;padding:10px 14px}.met{border:1px solid #d0d5dd;padding:12px}.mv{font-size:19pt;font-weight:bold}.g{color:#16a34a}.a{color:#f0a000}.v{color:#ef3340}
		.st{font-size:15pt;font-weight:bold;margin-bottom:10px}.fb{width:100%;border-collapse:collapse;table-layout:fixed}.fb th{color:#fff;background:#00516d;border:1px solid #fff;padding:7px 4px;font-size:7pt}.fb td{color:#536273;border:1px solid #d9dee3;padding:6px 4px;font-size:6.5pt;vertical-align:top}.fb .nota{color:#fff;font-weight:bold;text-align:center;vertical-align:middle}.alt{background:#f5f7f9}
		.rod{width:100%;color:#667085;border-top:1px solid #b8c2cc;font-size:7pt}.pag{text-align:right}</style>';
		$footer='<page_footer><table class="rod"><tr><td style="width:80%"><b>'.$tipoHtml.'</b> — '.$titulo.' — '.$dataHtml.'</td><td class="pag" style="width:20%">Página [[page_cu]] de [[page_nb]]</td></tr></table></page_footer>';
		$img=strpos($grafico,'data:image/jpeg;base64,')===0?'<img src="'.$e($grafico).'" style="width:215px;height:215px">':'';

		$html='<page orientation="L" format="A4" backtop="8mm" backbottom="14mm" backleft="8mm" backright="8mm">'.$css.$footer
		.'<div class="titulo">'.$titulo.'</div><div class="tipo">Tipo de curso: <b>'.$tipoHtml.'</b></div><div class="data">Realizado em: <b>'.$dataHtml.'</b></div><table class="painel"><tr><td class="card" style="width:31%"><table class="scoretab">'
		.'<tr><td class="rot" style="padding:12px 8px 4px">SCORE GERAL NPS</td></tr><tr><td class="score">'.$score.'</td></tr><tr><td class="zona">'.$e($zona).'</td></tr><tr><td class="info">Total de respostas: <b>'.$total.'</b></td></tr><tr><td class="info">Total de inscritos: <b>'.$inscritos.'</b></td></tr></table></td>'
		.'<td style="width:3%"></td><td class="card" style="width:66%;text-align:center"><div class="gtit">Distribuição dos Tipos de Alunos</div>'.$img.'</td></tr></table>'
		.'<table class="metricas"><tr><td class="met g" style="width:32%">Promotores (Notas 9 e 10)<br><br><span class="mv">'.$p.'</span> '.$pp.'%</td><td style="width:2%"></td><td class="met a" style="width:32%">Neutros (Notas 7 e 8)<br><br><span class="mv">'.$n.'</span> '.$pn.'%</td><td style="width:2%"></td><td class="met v" style="width:32%">Detratores (Notas 0 a 6)<br><br><span class="mv">'.$d.'</span> '.$pd.'%</td></tr></table></page>';
		$html.='<page orientation="L" format="A4" backtop="8mm" backbottom="14mm" backleft="8mm" backright="8mm">'.$css.$footer.'<div class="st">Feedbacks e Comentários Detalhados</div><table class="fb"><thead><tr><th style="width:5%">NOTA</th><th style="width:18%">MOTIVO DA NOTA</th><th style="width:18%">O QUE MAIS AGRADOU</th><th style="width:24%">O QUE PODE MELHORAR</th><th style="width:10%">PARTICIPARIA<br>DE NOVO?</th><th style="width:25%">COMENTÁRIO ADICIONAL</th></tr></thead><tbody>';
		foreach($notas as $i=>$r){$v=(int)$r->escala;$cor=$v>=9?'#20b54b':($v>=7?'#ffbd17':'#ef3340');$html.='<tr class="'.($i%2?'alt':'').'"><td class="nota" style="width:5%;background:'.$cor.'">'.$v.'</td><td style="width:18%">'.$cel($r->perguntaA).'</td><td style="width:18%">'.$cel($r->perguntaB).'</td><td style="width:24%">'.$cel($r->perguntaC).'</td><td style="width:10%">'.$cel($r->perguntaD).'</td><td style="width:25%">'.$cel($r->perguntaE).'</td></tr>';}
		$html.='</tbody></table></page>';
		try{$pdf=new \Spipu\Html2Pdf\Html2Pdf('L','A4','pt');$pdf->setDefaultFont('helvetica');$pdf->writeHTML($html);$pdf->output('Relatorio_NPS_'.preg_replace('/[^A-Za-z0-9_-]+/','_',$id).'.pdf','I');}
		catch(\Throwable $ex){show_error('Não foi possível gerar o PDF: '.$ex->getMessage(),500);}
	}
}
