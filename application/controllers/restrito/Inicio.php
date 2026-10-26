<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends MY_Controller {

	private $dados;

	public function __construct(){
        parent::__construct();
		
		$this->dados = array();
		$this->dados['menu_ativo'] = "inicio";
		
		// verifica se existe usuário logado
        if(!$this->session->userdata('usuario_logado')){
            redirect('login');
        }

        $controller = 'dashboard';

        $permissoes = $this->session->userdata('permissao');
        $permissoes = str_replace('permissão: ', '', $permissoes);
        $permissoes = array_map('trim', explode(',', $permissoes));

        if(!in_array($controller, $permissoes)){
            show_error('Sem permissão para acessar esta página',403);
        }
	}
	
	public function index()
	{
		try {
			$this->load->model('Moodle_api');
			$this->dashboard();
		} catch (mysqli_sql_exception $e) {
			log_message('error', 'Dashboard: conexão/consulta MySQL indisponível (código ' . (int) $e->getCode() . ').');
			$this->load->view('restrito/fixo/cabecalho', $this->dados);
			$this->load->view('restrito/dashboard_indisponivel');
			$this->load->view('restrito/fixo/rodape', $this->dados);
		}
	}

	private function dashboard()
	{
		$this->load->model('capacifar_model', 'capacifar_model', TRUE);
		$tipoEventoRanking = $this->input->get('tipo_evento');
		$tipoEventoRanking = is_string($tipoEventoRanking) && in_array($tipoEventoRanking, ['1', '2', '3', '4', '5', '7'], true)
			? (int) $tipoEventoRanking : null;
		$arrayDados['tipo_evento_ranking'] = $tipoEventoRanking;
		$this->load->model('Designacoes_model', 'designacoes_model');
		$arrayDados['designacoesRankingDisponiveis'] = $this->designacoes_model->disponivel();
		//var_dump($this->session->userdata);
		
		$sql = "SELECT 
					p.courseid,
					p.tipo_evento,
					COUNT(inscritos.id) AS total_inscritos
				FROM tbl_portalfarma p
				LEFT JOIN (
					-- Inscrições da Fiscalização Humanizada (tipo 4)
					SELECT fh.id_evento AS course_id, id 
					FROM fiscalizacao_humanizada_inscricao fh    
					UNION ALL
					-- Inscrições do Seminário (tipo 7)
					SELECT seminario AS course_id, id 
					FROM tbl_seminario_inscricao
				) AS inscritos ON p.courseid = inscritos.course_id
				WHERE p.status IN (0,1) 
				  AND p.tipo_evento IN (4, 7)
				  AND YEAR(p.data_inicio) = YEAR(CURDATE()) -- Filtra pelo ano atual (2026)
				GROUP BY p.courseid, p.tipo_evento;";
				
		$urmsql = "SELECT COUNT(ui.id) AS total_inscritos
						FROM urm_inscricao ui
					WHERE YEAR(ui.data_inscricao) >= 2026;";		
		
		$arrayDados['resultadosInscritos'] 		= $this->capacifar_model->query($sql);
		$arrayDados['URMInscritos'] 			= $this->capacifar_model->query($urmsql);
		
		$arrayDados['total_alunos_cursos']		= $this->Moodle_api->total_alunos();
		$cursosPortal = $this->capacifar_model->cursosRankingDesignados($this->designacoes_model->usuario_sessao(), $tipoEventoRanking);
		$cursosPorId = [];
		foreach ($cursosPortal as $cursoPortal) {
			$idCurso = trim((string) $cursoPortal->courseid);
			$chaveCurso = (int) $cursoPortal->tipo_evento . ':' . $idCurso;
			if ($idCurso !== '' && !isset($cursosPorId[$chaveCurso])) {
				$cursosPorId[$chaveCurso] = $cursoPortal;
			}
		}
		$inscritosMoodlePorCurso = [];
		foreach ($arrayDados['total_alunos_cursos'] as $cursoMoodle) {
			$inscritosMoodlePorCurso[(int) $cursoMoodle->courseid] = (int) $cursoMoodle->total_estudantes;
		}
		$arrayDados['cursos_mais_requisitados'] = [];
		foreach ($cursosPorId as $curso) {
			// Eventos locais participam do ranking mesmo sem curso correspondente no Moodle.
			$curso->total_estudantes = $curso->total_inscritos_local !== NULL
				? (int) $curso->total_inscritos_local
				: ($inscritosMoodlePorCurso[(string) $curso->courseid] ?? 0);
			$arrayDados['cursos_mais_requisitados'][] = $curso;
		}
		$arrayDados['total_inscritos_moodle']	= $this->Moodle_api->total_inscritos_moodle();
		$arrayDados['contador_inscritos']		= $this->Moodle_api->contador_inscritos();
		$arrayDados['total_students_mes']		= $this->Moodle_api->total_students_mes();
		$arrayDados['categoria_inscritos']		= $this->Moodle_api->categoria_inscritos();

		$sqlResumoCursos = "SELECT
				CASE
					WHEN tipo_evento IN (2, 6) THEN 'online'
					WHEN tipo_evento IN (1, 3, 4, 5, 7) THEN 'presencial'
				END AS modalidade,
				COUNT(*) AS quantidade_cursos,
				ROUND(
					COUNT(*) /
					CASE
						WHEN YEAR(CURDATE()) = 2026 THEN GREATEST(MONTH(CURDATE()), 1)
						WHEN YEAR(CURDATE()) > 2026 THEN 12
						ELSE 1
					END,
					1
				) AS media_cursos_mes
			FROM tbl_portalfarma
			WHERE tipo_evento IN (1, 2, 3, 4, 5, 6, 7)
				AND data_inicio IS NOT NULL
				AND YEAR(data_inicio) = 2026
			GROUP BY modalidade
			ORDER BY modalidade";
		$arrayDados['resumo_cursos_portalfarma'] = $this->capacifar_model->query($sqlResumoCursos);

		$cursosModalidade2026 = $this->capacifar_model->query("SELECT courseid, tipo_evento
			FROM tbl_portalfarma
			WHERE tipo_evento IN (1, 2, 3, 4, 5, 6, 7)
				AND data_inicio IS NOT NULL
				AND YEAR(data_inicio) = 2026");
		$courseids2026 = ['online' => [], 'presencial' => []];
		foreach ($cursosModalidade2026 as $cursoModalidade) {
			$courseid = trim((string) $cursoModalidade->courseid);
			if (!ctype_digit($courseid) || (int) $courseid <= 0) {
				continue;
			}
			$modalidade = in_array((int) $cursoModalidade->tipo_evento, [2, 6], true) ? 'online' : 'presencial';
			$courseids2026[$modalidade][] = (int) $courseid;
		}
		$arrayDados['media_inscricoes_portalfarma'] = [
			'online' => $this->Moodle_api->media_inscricoes_mensal_por_cursos($courseids2026['online'], 2026),
			'presencial' => $this->Moodle_api->media_inscricoes_mensal_por_cursos($courseids2026['presencial'], 2026)
		];

		$categoriasGrafico = [
			'Farmacêutico(s) Inscrito(s) no CRF/MG' => 0,
			'Estudante de Farmácia' => 0,
			'Não declarada' => 0,
			'Outros Profissionais' => 0,
			'Farmacêutico(s) Outro(s) Estado(s)' => 0,
			'Farmacêutico(s) NÃO Inscrito(s)' => 0
		];

		foreach ($arrayDados['categoria_inscritos'] as $categoriaInscrito) {
			$nomeCategoria = trim((string) $categoriaInscrito->categoria);
			$nomeNormalizado = function_exists('iconv')
				? iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nomeCategoria)
				: $nomeCategoria;
			$nomeNormalizado = strtolower((string) $nomeNormalizado);
			$totalCategoria = (int) $categoriaInscrito->total_usuarios;

			if ($nomeNormalizado === '' || strpos($nomeNormalizado, 'sem categoria') !== false) {
				$categoriasGrafico['Não declarada'] += $totalCategoria;
			} elseif (strpos($nomeNormalizado, 'outro') !== false && strpos($nomeNormalizado, 'estado') !== false) {
				$categoriasGrafico['Farmacêutico(s) Outro(s) Estado(s)'] += $totalCategoria;
			} elseif (strpos($nomeNormalizado, 'nao inscrit') !== false) {
				$categoriasGrafico['Farmacêutico(s) NÃO Inscrito(s)'] += $totalCategoria;
			} elseif (strpos($nomeNormalizado, 'estud') !== false) {
				$categoriasGrafico['Estudante de Farmácia'] += $totalCategoria;
			} elseif (strpos($nomeNormalizado, 'farmac') !== false) {
				$categoriasGrafico['Farmacêutico(s) Inscrito(s) no CRF/MG'] += $totalCategoria;
			} else {
				$categoriasGrafico['Outros Profissionais'] += $totalCategoria;
			}
		}

		$arrayDados['grafico_categorias_labels'] = array_keys($categoriasGrafico);
		$arrayDados['grafico_categorias_valores'] = array_values($categoriasGrafico);
		
		//grafico de Inscrições por mês
		$meses = [];
        $totais = [];

        foreach ($arrayDados['total_students_mes'] as $row) {
            $meses[] = $row->mes;
            $totais[] = (int)$row->total;
        }

        $arrayDados['meses'] = $meses;
        $arrayDados['totais'] = $totais;
		
		// Grafico de Tipo de incrições PiZZA
		
		$arraySimples = [];

			foreach ($arrayDados['total_inscritos_moodle'] as $item) {
				$arraySimples[$item->shortname] = (int) $item->total;
			}

			//print_r($arraySimples);

			$labels_pizza 		= array_keys($arraySimples);
			$valores_pizza 		= array_values($arraySimples);
			$totalGeral_pizza 	= array_sum($arraySimples);

								
		//SUBINDO A PAGINA						
		$this->load->view('restrito/fixo/cabecalho', $this->dados);
		$this->load->view('restrito/inicio', $arrayDados);
		$this->load->view('restrito/fixo/rodape', $this->dados);
	}
}
