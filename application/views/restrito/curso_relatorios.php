<?php
$formatar = function ($valor) { return $valor === NULL ? 'Indisponível' : number_format($valor, 0, ',', '.'); };
$taxa = $indicadores['inscritos'] !== NULL && $indicadores['ativos'] !== NULL
    ? ($indicadores['inscritos'] > 0 ? 100 * $indicadores['ativos'] / $indicadores['inscritos'] : 0) : NULL;
$cards = [
    'Total de inscritos' => $formatar($indicadores['inscritos']),
    'Taxa de engajamento' => $taxa === NULL ? 'Indisponível' : number_format($taxa, 1, ',', '.').'%',
    'Participantes ativos' => $formatar($indicadores['ativos']),
    'Acessos ao curso' => $formatar($indicadores['acessos']),
    'Certificados emitidos' => $formatar($indicadores['certificados']),
    'Acessos às atividades' => $formatar($indicadores['atividades']),
];
$aparencia = [
    ['people', 'blue', 'Estudantes matriculados'],
    ['graph-up-arrow', 'violet', 'Participação dos inscritos'],
    ['person-check', 'green', 'Com atividade registrada'],
    ['box-arrow-in-right', 'blue', 'Visualizações do curso'],
    ['award', 'amber', 'Emissões registradas'],
    ['collection-play', 'violet', 'Visualizações das atividades'],
];
?>
<style>
    .curso-relatorio { --report-ink: #182230; --report-muted: #667085; }
    .curso-relatorio .report-back { display: inline-flex; align-items: center; gap: 8px; color: #475467; text-decoration: none; font-size: 14px; margin-bottom: 24px; }
    .curso-relatorio .report-back:hover { color: #465fff; }
    .curso-relatorio .report-header { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 28px; }
    .curso-relatorio .report-eyebrow { color: #465fff; font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; margin-bottom: 8px; }
    .curso-relatorio .report-title { color: var(--report-ink); font-size: clamp(24px, 3vw, 32px); font-weight: 700; letter-spacing: -.035em; margin-bottom: 6px; }
    .curso-relatorio .report-subtitle { color: var(--report-muted); margin: 0; overflow-wrap: anywhere; }
    .curso-relatorio .report-badge { display: inline-flex; align-items: center; gap: 7px; padding: 8px 12px; border: 1px solid #e4e7ec; border-radius: 100px; background: #fff; color: #475467; font-size: 12px; white-space: nowrap; }
    .curso-relatorio .report-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; margin-bottom: 28px; }
    .curso-relatorio .report-metric { --metric-color: #465fff; --metric-tint: #eef2ff; position: relative; padding: 24px; border: 1px solid #e4e7ec; border-radius: 18px; background: #fff; box-shadow: 0 3px 10px rgba(16,24,40,.035); }
    .curso-relatorio .report-metric.violet { --metric-color: #7c3aed; --metric-tint: #f3edff; }
    .curso-relatorio .report-metric.green { --metric-color: #07865f; --metric-tint: #e8f8f0; }
    .curso-relatorio .report-metric.amber { --metric-color: #b76e08; --metric-tint: #fff5df; }
    .curso-relatorio .report-metric-top { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 18px; }
    .curso-relatorio .report-metric-label { font-size: 14px; font-weight: 600; color: #475467; margin: 0; }
    .curso-relatorio .report-icon { display: inline-flex; flex-shrink: 0; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 13px; background: var(--metric-tint); color: var(--metric-color); font-size: 21px; }
    .curso-relatorio .report-value { font-size: clamp(28px, 3vw, 38px); font-weight: 700; color: var(--report-ink); letter-spacing: -.04em; line-height: 1.2; margin: 0 0 10px; overflow-wrap: anywhere; }
    .curso-relatorio .report-value.unavailable { font-size: 22px; color: var(--report-muted); }
    .curso-relatorio .report-caption { color: var(--report-muted); font-size: 12px; margin: 0; }
    .curso-relatorio .report-progress { height: 5px; background: var(--metric-tint); border-radius: 8px; overflow: hidden; margin-top: 16px; }
    .curso-relatorio .report-progress-fill { height: 100%; background: var(--metric-color); border-radius: inherit; }
    .curso-relatorio > .card { border: 1px solid #e4e7ec; border-radius: 18px; box-shadow: none; }
    .curso-relatorio > .card > .card-body { padding: 24px; }
    @media (max-width: 991px) { .curso-relatorio .report-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 575px) { .curso-relatorio .report-grid { grid-template-columns: 1fr; gap: 14px; } .curso-relatorio .report-header { align-items: flex-start; flex-direction: column; gap: 12px; } .curso-relatorio .report-metric { padding: 20px; } }
</style>
<div class="container py-4 curso-relatorio">
    <a href="<?=base_url('restrito/capacifar/listar')?>" class="report-back"><i class="bi bi-arrow-left" aria-hidden="true"></i> Voltar aos eventos</a>
    <header class="report-header">
        <div><p class="report-eyebrow">Visão geral do evento</p><h1 class="report-title">Relatórios</h1>
        <p class="report-subtitle"><?=htmlspecialchars($curso->titulo, ENT_QUOTES, 'UTF-8')?></p></div>
        <span class="report-badge"><i class="bi bi-mortarboard" aria-hidden="true"></i> Moodle · Curso #<?=(int) $curso->courseid?></span>
    </header>
    <?php if (in_array(NULL, $indicadores, TRUE)): ?>
        <div class="alert alert-warning" role="alert">Alguns indicadores não puderam ser consultados no Moodle. Valores indisponíveis não representam zero.</div>
    <?php endif; ?>
    <div class="report-grid">
        <?php $indice = 0; foreach ($cards as $titulo => $valor):
            [$icone, $cor, $descricao] = $aparencia[$indice++]; ?>
            <section class="report-metric <?=$cor?>">
                <div class="report-metric-top"><h2 class="report-metric-label"><?=$titulo?></h2>
                    <span class="report-icon"><i class="bi bi-<?=$icone?>" aria-hidden="true"></i></span></div>
                <p class="report-value <?=$valor === 'Indisponível' ? 'unavailable' : ''?>"><?=$valor?></p>
                <p class="report-caption"><?=$descricao?></p>
                <?php if ($titulo === 'Taxa de engajamento' && $taxa !== NULL): ?>
                    <div class="report-progress" aria-hidden="true"><div class="report-progress-fill" style="width: <?=number_format(max(0, min(100, $taxa)), 2, '.', '')?>%"></div></div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
    <div class="card mb-4"><div class="card-body">
        <h2 class="h6">Como os indicadores são calculados</h2>
        <p class="mb-1">Engajamento: inscritos com pelo menos uma ação de participação registrada no curso ÷ total de inscritos. Considera estudantes com matrícula ativa e o histórico de logs disponível no Moodle.</p>
        <p class="mb-1">Acessos: visualizações da página do curso e das atividades, incluindo acessos repetidos dos inscritos. Logs removidos do Moodle não entram na contagem.</p>
        <p class="mb-0">Certificados: todas as emissões registradas nas atividades Certificado do curso, Custom certificate e Certificate, incluindo usuários que não estão mais matriculados. Downloads repetidos não são novas emissões.</p>
    </div></div>
    <?php if ((int) $curso->tipo_evento === 1): ?>
    <section class="card"><div class="card-body">
        <h2 class="h5">Presença no evento presencial</h2>
        <p>Lista de presença: <strong><?=$formatar($presencas === NULL ? NULL : count(array_unique($presencas)))?></strong> pessoa(s).</p>
        <?php if ($grupos_indisponiveis): ?>
            <div class="alert alert-warning">Não foi possível consultar os grupos do Moodle.</div>
        <?php elseif (!$grupos): ?>
            <p class="text-muted">Nenhum grupo encontrado no Moodle.</p>
        <?php else: ?>
            <form method="get" class="mb-3">
                <label for="grupo-presenca" class="form-label">Grupo do Moodle que representa os presentes</label>
                <div class="d-flex gap-2"><select name="grupo" id="grupo-presenca" class="form-select">
                    <option value="">Selecione o grupo de presença</option>
                    <?php foreach ($grupos as $grupo): ?>
                        <option value="<?=(int) $grupo['id']?>" <?=$grupo_selecionado && $grupo_selecionado['id'] === $grupo['id'] ? 'selected' : ''?>><?=htmlspecialchars($grupo['nome'], ENT_QUOTES, 'UTF-8')?> (<?=count($grupo['membros'])?>)</option>
                    <?php endforeach; ?>
                </select><button class="btn btn-primary" type="submit">Consultar</button></div>
            </form>
            <?php if ($grupo_selecionado):
                $idsGrupo = array_column($grupo_selecionado['membros'], 'id'); ?>
                <p>Presentes no grupo selecionado: <strong><?=count(array_unique($idsGrupo))?></strong>.</p>
                <?php if ($presencas !== NULL): ?>
                    <p class="mb-0">Total de presentes (lista + grupo, sem duplicar pessoas): <strong><?=count(array_unique(array_merge($presencas, $idsGrupo)))?></strong>.</p>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div></section>
    <?php endif; ?>
</div>
