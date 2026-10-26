<?php
$totalStudent = 0;
foreach (($contador_inscritos ?? []) as $item) {
	$totalStudent = (int) $item->total_usuarios_ativos;
}

$inscritosPorTipo = array_reduce($resultadosInscritos ?? [], function ($totais, $item) {
	$tipo = (string) $item->tipo_evento;
	$totais[$tipo] = ($totais[$tipo] ?? 0) + (int) $item->total_inscritos;
	return $totais;
}, []);

$totalURM = 0;
foreach (($URMInscritos ?? []) as $item) {
	$totalURM = (int) $item->total_inscritos;
}

$totalSeminario = (int) ($inscritosPorTipo['7'] ?? 0);
$totalFiscalizacao = (int) ($inscritosPorTipo['4'] ?? 0);
$totalGeral = $totalStudent + array_sum($inscritosPorTipo) + $totalURM;

$cursosOrdenados = $cursos_mais_requisitados ?? [];
usort($cursosOrdenados, function ($a, $b) {
	return ((int) $b->total_estudantes <=> (int) $a->total_estudantes)
		?: strcmp((string) $a->titulo, (string) $b->titulo);
});
$topCursos = array_slice($cursosOrdenados, 0, 10);
$filtrosRanking = [
	'' => 'Todos', 1 => 'Capacifar Presencial', 2 => 'Capacifar Online',
	3 => 'Uso Racional de Medicamentos', 4 => 'Fiscalização Humanizada',
	5 => 'Capacifar Universitário', 7 => 'Seminário de Vigilância'
];
$tipoEventoRankingAtivo = (string) ($tipo_evento_ranking ?? '');

$labelsCategorias = $grafico_categorias_labels ?? [];
$valoresCategorias = array_map('intval', $grafico_categorias_valores ?? []);
$totalCategorias = array_sum($valoresCategorias);
$coresCategorias = ['#465fff', '#12b76a', '#98a2b3', '#7a5af8', '#f79009', '#f04438'];

$dadosModalidades = [
	'online' => ['quantidade_cursos' => 0, 'media_cursos_mes' => 0, 'media_inscricoes_mes' => 0],
	'presencial' => ['quantidade_cursos' => 0, 'media_cursos_mes' => 0, 'media_inscricoes_mes' => 0]
];
foreach (($resumo_cursos_portalfarma ?? []) as $resumoPortal) {
	$chaveModalidade = strtolower((string) $resumoPortal->modalidade);
	if (isset($dadosModalidades[$chaveModalidade])) {
		$dadosModalidades[$chaveModalidade]['quantidade_cursos'] = (int) $resumoPortal->quantidade_cursos;
		$dadosModalidades[$chaveModalidade]['media_cursos_mes'] = (float) $resumoPortal->media_cursos_mes;
	}
}

foreach (($media_inscricoes_portalfarma ?? []) as $modalidade => $mediaInscricoes) {
	if (isset($dadosModalidades[$modalidade])) {
		$dadosModalidades[$modalidade]['media_inscricoes_mes'] = (float) $mediaInscricoes;
	}
}

$metricasModalidades = [
	['rotulo' => 'Quantidade de cursos', 'campo' => 'quantidade_cursos', 'decimais' => 0],
	['rotulo' => 'Média de cursos por mês', 'campo' => 'media_cursos_mes', 'decimais' => 1],
	['rotulo' => 'Média de inscrições por mês', 'campo' => 'media_inscricoes_mes', 'decimais' => 1]
];
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<style>
	.dashboard-tail { padding: 24px; }
	.dashboard-title { margin-bottom: 24px; }
	.dashboard-title h2 { margin: 0; color: #101828; font-size: 24px; font-weight: 700; }
	.dashboard-title p { margin: 6px 0 0; color: #667085; font-size: 14px; }
	.dashboard-kpis { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 16px; margin-bottom: 24px; }
	.dashboard-kpi { min-width: 0; padding: 20px; background: #fff; border: 1px solid #e4e7ec; border-radius: 12px; box-shadow: 0 1px 2px rgba(16,24,40,.04); }
	.dashboard-kpi-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
	.dashboard-kpi-icon { width: 42px; height: 42px; display: grid; place-items: center; color: #465fff; background: #eef0ff; border-radius: 10px; font-size: 19px; }
	.dashboard-kpi:nth-child(2) .dashboard-kpi-icon { color: #039855; background: #ecfdf3; }
	.dashboard-kpi:nth-child(3) .dashboard-kpi-icon { color: #dc6803; background: #fffaeb; }
	.dashboard-kpi:nth-child(4) .dashboard-kpi-icon { color: #d92d20; background: #fef3f2; }
	.dashboard-kpi:nth-child(5) .dashboard-kpi-icon { color: #175cd3; background: #eff8ff; }
	.dashboard-kpi-label { margin-top: 16px; color: #667085; font-size: 13px; font-weight: 500; }
	.dashboard-kpi-value { margin-top: 3px; color: #101828; font-size: 28px; font-weight: 700; line-height: 1.1; }
	.dashboard-grid { display: grid; grid-template-columns: minmax(0, 1.65fr) minmax(320px, .85fr); gap: 20px; margin-bottom: 20px; }
	.dashboard-card { min-width: 0; background: #fff; border: 1px solid #e4e7ec; border-radius: 12px; box-shadow: 0 1px 2px rgba(16,24,40,.04); }
	.dashboard-card-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 20px 24px; border-bottom: 1px solid #e4e7ec; }
	.dashboard-card-title { margin: 0; color: #101828; font-size: 17px; font-weight: 600; }
	.dashboard-card-subtitle { margin: 4px 0 0; color: #667085; font-size: 12px; }
	.dashboard-card-body { padding: 22px 24px; }
	.dashboard-chart-bar { height: 315px; }
	.dashboard-pie-wrap { position: relative; max-width: 280px; height: 280px; margin: 0 auto 20px; }
	.dashboard-legend { display: grid; gap: 10px; }
	.dashboard-legend-item { display: grid; grid-template-columns: 10px minmax(0, 1fr) auto; align-items: center; gap: 9px; color: #475467; font-size: 12px; }
	.dashboard-legend-color { width: 10px; height: 10px; border-radius: 50%; }
	.dashboard-legend-value { color: #101828; font-weight: 600; }
	.dashboard-table { margin: 0; }
	.dashboard-table thead th { padding: 12px 16px; color: #667085; background: #f9fafb; border-color: #e4e7ec; font-size: 11px; font-weight: 600; text-transform: uppercase; white-space: nowrap; }
	.dashboard-table tbody td { padding: 14px 16px; color: #475467; border-color: #e4e7ec; font-size: 13px; vertical-align: middle; }
	.dashboard-course-name { display: block; max-width: 420px; color: #101828; font-weight: 600; }
	.dashboard-course-id { color: #98a2b3; font-size: 11px; }
	.dashboard-rank { width: 28px; height: 28px; display: inline-grid; place-items: center; color: #465fff; background: #eef0ff; border-radius: 50%; font-size: 11px; font-weight: 700; }
	.dashboard-count { display: inline-block; min-width: 44px; padding: 5px 9px; color: #3538cd; background: #eef0ff; border-radius: 999px; text-align: center; font-weight: 700; }
	.dashboard-type { display: inline-block; padding: 5px 10px; color: #344054; background: #f2f4f7; border: 1px solid #e4e7ec; border-radius: 999px; font-size: 11px; font-weight: 600; }
	.dashboard-empty { padding: 32px; color: #667085; text-align: center; }
	.dashboard-top-content { margin-bottom: 20px; overflow: hidden; }
	.dashboard-top-table { width: 100%; margin: 0; border-collapse: collapse; }
	.dashboard-top-table th { padding: 13px 24px; color: #667085; background: #f9fafb; border-bottom: 1px solid #e4e7ec; font-size: 12px; font-weight: 500; text-align: left; }
	.dashboard-top-table th:not(:first-child), .dashboard-top-table td:not(:first-child) { width: 22%; text-align: right; }
	.dashboard-top-table td { padding: 14px 24px; color: #475467; border-bottom: 1px solid #e4e7ec; font-size: 14px; vertical-align: middle; }
	.dashboard-top-table tbody tr:last-child td { border-bottom: 0; }
	.dashboard-top-metrica { position: relative; min-width: 280px; }
	.dashboard-top-barra { position: absolute; z-index: 0; left: 16px; bottom: 7px; height: 34px; max-width: calc(100% - 32px); background: #eef4ff; border-radius: 6px; }
	.dashboard-top-label { position: relative; z-index: 1; color: #344054; font-weight: 500; }
	.dashboard-top-value { color: #101828; font-size: 15px; font-weight: 600; }
	.dashboard-top-unit { display: block; margin-top: 2px; color: #98a2b3; font-size: 10px; }
	@media (max-width: 1399.98px) { .dashboard-kpis { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
	@media (max-width: 991.98px) { .dashboard-grid { grid-template-columns: 1fr; } .dashboard-kpis { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
	@media (max-width: 575.98px) { .dashboard-tail { padding: 16px; } .dashboard-kpis { grid-template-columns: 1fr; } .dashboard-card-header, .dashboard-card-body { padding: 16px; } }
</style>

<div class="dashboard-tail">
	<div class="dashboard-title">
		<h2>Dashboard</h2>
		<p>Visão geral dos usuários, inscrições e cursos do PortalFarma.</p>
	</div>

	<div class="dashboard-kpis">
		<div class="dashboard-kpi">
			<div class="dashboard-kpi-top"><div class="dashboard-kpi-icon"><i class="bi bi-mortarboard"></i></div></div>
			<div class="dashboard-kpi-label">Alunos Moodle</div>
			<div class="dashboard-kpi-value"><?=number_format($totalStudent, 0, ',', '.')?></div>
		</div>
		<div class="dashboard-kpi">
			<div class="dashboard-kpi-top"><div class="dashboard-kpi-icon"><i class="bi bi-shield-check"></i></div></div>
			<div class="dashboard-kpi-label">Seminário de Vigilância</div>
			<div class="dashboard-kpi-value"><?=number_format($totalSeminario, 0, ',', '.')?></div>
		</div>
		<div class="dashboard-kpi">
			<div class="dashboard-kpi-top"><div class="dashboard-kpi-icon"><i class="bi bi-capsule"></i></div></div>
			<div class="dashboard-kpi-label">Inscrições URM</div>
			<div class="dashboard-kpi-value"><?=number_format($totalURM, 0, ',', '.')?></div>
		</div>
		<div class="dashboard-kpi">
			<div class="dashboard-kpi-top"><div class="dashboard-kpi-icon"><i class="bi bi-heart-pulse"></i></div></div>
			<div class="dashboard-kpi-label">Fiscalização Humanizada</div>
			<div class="dashboard-kpi-value"><?=number_format($totalFiscalizacao, 0, ',', '.')?></div>
		</div>
		<div class="dashboard-kpi">
			<div class="dashboard-kpi-top"><div class="dashboard-kpi-icon"><i class="bi bi-people"></i></div></div>
			<div class="dashboard-kpi-label">Total geral</div>
			<div class="dashboard-kpi-value"><?=number_format($totalGeral, 0, ',', '.')?></div>
		</div>
	</div>

	<div class="dashboard-grid">
		<section class="dashboard-card">
			<div class="dashboard-card-header">
				<div><h3 class="dashboard-card-title">Inscrições por mês</h3><p class="dashboard-card-subtitle">Evolução mensal de matrículas em <?=date('Y')?>.</p></div>
				<div class="dashboard-kpi-icon"><i class="bi bi-bar-chart"></i></div>
			</div>
			<div class="dashboard-card-body"><div class="dashboard-chart-bar"><canvas id="graficoInscricoes"></canvas></div></div>
		</section>

		<section class="dashboard-card">
			<div class="dashboard-card-header">
				<div><h3 class="dashboard-card-title">Perfil dos inscritos</h3><p class="dashboard-card-subtitle">Todas as categorias declaradas no cadastro.</p></div>
			</div>
			<div class="dashboard-card-body">
				<div class="dashboard-pie-wrap"><canvas id="graficoCategorias"></canvas></div>
				<div class="dashboard-legend">
					<?php foreach ($labelsCategorias as $indice => $label): ?>
						<div class="dashboard-legend-item">
							<span class="dashboard-legend-color" style="background:<?=$coresCategorias[$indice]?>"></span>
							<span><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?></span>
							<span class="dashboard-legend-value"><?=number_format($valoresCategorias[$indice] ?? 0, 0, ',', '.')?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>

	<section class="dashboard-card dashboard-top-content">
		<div class="dashboard-card-header">
			<div><h3 class="dashboard-card-title">Cursos por modalidade</h3><p class="dashboard-card-subtitle">Cursos com data de início em 2026 e inscrições registradas no AVA.</p></div>
			<span class="text-muted fs-5" aria-hidden="true">•••</span>
		</div>
		<div class="table-responsive">
			<table class="dashboard-top-table">
				<thead><tr><th>Indicador</th><th>On-line</th><th>Presencial</th></tr></thead>
				<tbody>
				<?php foreach ($metricasModalidades as $metrica):
					$valorOnline = $dadosModalidades['online'][$metrica['campo']];
					$valorPresencial = $dadosModalidades['presencial'][$metrica['campo']];
					$maiorValor = max($valorOnline, $valorPresencial);
					$larguraBarra = $maiorValor > 0 ? max(14, round((($valorOnline + $valorPresencial) / ($maiorValor * 2)) * 100)) : 0;
				?>
					<tr>
						<td class="dashboard-top-metrica"><span class="dashboard-top-barra" style="width:<?=$larguraBarra?>%"></span><span class="dashboard-top-label"><?=htmlspecialchars($metrica['rotulo'], ENT_QUOTES, 'UTF-8')?></span></td>
						<td><span class="dashboard-top-value"><?=number_format($valorOnline, $metrica['decimais'], ',', '.')?></span><?php if ($metrica['decimais']): ?><span class="dashboard-top-unit">média mensal em 2026</span><?php endif; ?></td>
						<td><span class="dashboard-top-value"><?=number_format($valorPresencial, $metrica['decimais'], ',', '.')?></span><?php if ($metrica['decimais']): ?><span class="dashboard-top-unit">média mensal em 2026</span><?php endif; ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</section>

	<section class="dashboard-card" id="ranking-cursos">
		<div class="dashboard-card-header flex-wrap">
			<div><h3 class="dashboard-card-title">Cursos mais requisitados</h3><p class="dashboard-card-subtitle">Os dez cursos com mais inscritos entre os designados a você.</p></div>
			<div class="d-flex flex-wrap gap-2 align-items-center justify-content-end ms-auto" role="group" aria-label="Filtrar ranking por tipo de evento">
				<?php foreach ($filtrosRanking as $valorFiltro => $rotuloFiltro):
					$ativo = (string) $valorFiltro === $tipoEventoRankingAtivo;
					$urlFiltro = base_url('restrito/inicio').($valorFiltro === '' ? '' : '?tipo_evento='.(int) $valorFiltro).'#ranking-cursos';
				?>
					<a href="<?=htmlspecialchars($urlFiltro, ENT_QUOTES, 'UTF-8')?>" class="btn btn-<?=$ativo ? 'primary' : 'outline-primary'?> btn-sm" <?=$ativo ? 'aria-current="true"' : ''?>><?=htmlspecialchars($rotuloFiltro, ENT_QUOTES, 'UTF-8')?></a>
				<?php endforeach; ?>
				<a href="<?=base_url('restrito/capacifar/inscricoescursos').'?escopo=designados'.($tipoEventoRankingAtivo !== '' ? '&amp;tipo_evento='.(int) $tipo_evento_ranking : '')?>" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Visualizar todos os cursos designados a você">Ver todos</a>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table dashboard-table">
				<thead><tr><th>Posição</th><th>Curso</th><th>Palestrantes vinculados</th><th class="text-center">Inscritos</th><th>Tipo</th></tr></thead>
				<tbody>
				<?php foreach ($topCursos as $indice => $item):
					$tiposCurso = [1 => 'Presencial', 2 => 'Online', 3 => 'URM (Presencial)', 4 => 'Fiscalização Humanizada', 5 => 'Universitário', 6 => 'Online', 7 => 'Seminário (Híbrido)'];
					$tipoCurso = $tiposCurso[(int) $item->tipo_evento] ?? 'Outro';
				?>
					<tr>
						<td><span class="dashboard-rank"><?=$indice + 1?></span></td>
						<td><span class="dashboard-course-name"><?=htmlspecialchars($item->titulo, ENT_QUOTES, 'UTF-8')?></span><span class="dashboard-course-id">ID: <?=htmlspecialchars((string) $item->courseid, ENT_QUOTES, 'UTF-8')?></span></td>
						<td><?=htmlspecialchars($item->palestrantes ?: 'Nenhum palestrante vinculado', ENT_QUOTES, 'UTF-8')?></td>
						<td class="text-center"><span class="dashboard-count"><?=(int)$item->total_estudantes?></span></td>
						<td><span class="dashboard-type"><?=htmlspecialchars($tipoCurso, ENT_QUOTES, 'UTF-8')?></span></td>
					</tr>
				<?php endforeach; ?>
				<?php if (empty($topCursos)): ?><tr><td colspan="5" class="dashboard-empty">Nenhum curso designado a você neste filtro.</td></tr><?php endif; ?>
				</tbody>
			</table>
		</div>
	</section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const estiloTexto = '#667085';
	const estiloGrade = '#eaecf0';

	new Chart(document.getElementById('graficoInscricoes'), {
		type: 'bar',
		data: {
			labels: <?=json_encode($meses ?? [], JSON_UNESCAPED_UNICODE)?>,
			datasets: [{
				label: 'Inscrições',
				data: <?=json_encode(array_map('intval', $totais ?? []))?>,
				backgroundColor: '#465fff',
				hoverBackgroundColor: '#3538cd',
				borderRadius: 5,
				borderSkipped: false,
				maxBarThickness: 34
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: { legend: { display: false }, tooltip: { padding: 10, displayColors: false } },
			scales: {
				x: { grid: { display: false }, ticks: { color: estiloTexto } },
				y: { beginAtZero: true, grid: { color: estiloGrade }, border: { display: false }, ticks: { color: estiloTexto, precision: 0 } }
			}
		}
	});

	const totalCentroPlugin = {
		id: 'totalCentro',
		afterDraw: function (chart) {
			if (!chart.chartArea) return;
			const ctx = chart.ctx;
			const centroX = (chart.chartArea.left + chart.chartArea.right) / 2;
			const centroY = (chart.chartArea.top + chart.chartArea.bottom) / 2;
			ctx.save();
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			ctx.fillStyle = '#667085';
			ctx.font = '500 12px Arial';
			ctx.fillText('Total', centroX, centroY - 12);
			ctx.fillStyle = '#101828';
			ctx.font = '700 24px Arial';
			ctx.fillText(<?=json_encode(number_format($totalCategorias, 0, ',', '.'))?>, centroX, centroY + 13);
			ctx.restore();
		}
	};

	new Chart(document.getElementById('graficoCategorias'), {
		type: 'doughnut',
		data: {
			labels: <?=json_encode($labelsCategorias, JSON_UNESCAPED_UNICODE)?>,
			datasets: [{
				data: <?=json_encode($valoresCategorias)?>,
				backgroundColor: <?=json_encode($coresCategorias)?>,
				borderColor: '#ffffff',
				borderWidth: 3,
				hoverOffset: 6
			}]
		},
		plugins: [totalCentroPlugin],
		options: {
			responsive: true,
			maintainAspectRatio: false,
			cutout: '66%',
			plugins: {
				legend: { display: false },
				tooltip: {
					callbacks: {
						label: function (context) {
							const total = <?=$totalCategorias?>;
							const percentual = total > 0 ? ((context.raw / total) * 100).toFixed(1) : '0.0';
							return ' ' + context.label + ': ' + context.raw + ' (' + percentual + '%)';
						}
					}
				}
			}
		}
	});

	document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (elemento) {
		bootstrap.Tooltip.getOrCreateInstance(elemento);
	});
});
</script>
