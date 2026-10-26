<!-- CSS GERAL --> 
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">
<!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
	.thead-azul,
	.thead-azul th {
		background-color: #004761 !important;
		color: #fff !important;
		border-color: #00394e !important;
	}
    .nav-pills .nav-link {
        color: #64748b;
        font-weight: 600;
        padding: 12px 25px;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        background: #f8fafc;
        margin-right: 10px;
    }
    .nav-pills .nav-link.active {
        background-color: #054589 !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(5, 69, 137, 0.2);
    }
    .nav-pills .nav-link:hover:not(.active) {
        background: #e2e8f0;
        border-color: #cbd5e1;
    }
    .btn-delete-vinculo {
        color: #ef4444;
        background: #fee2e2;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        transition: 0.3s;
    }
    .btn-delete-vinculo:hover {
        background: #ef4444;
        color: white;
    }
	.curso-vinculado-topo { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
	.curso-vinculado-nome { color: #101828; font-weight: 600; }
	.curso-vinculado-tipo { display: inline-flex; align-items: center; padding: 4px 9px; color: #d92d20; background: #fff; border: 1px solid #f04438; border-radius: 999px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .25px; white-space: nowrap; }
	.curso-vinculado-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 999px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
	.curso-vinculado-status.ativo { color: #067647; background: #ecfdf3; border: 1px solid #abefc6; }
	.curso-vinculado-status.inativo { color: #b42318; background: #fef3f2; border: 1px solid #fecdca; }
	.curso-vinculado-categorias { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; margin-top: 8px; }
	.curso-vinculado-grupo { display: inline-flex; flex-wrap: wrap; align-items: center; gap: 5px; }
	.curso-vinculado-grupo + .curso-vinculado-grupo { margin-left: 7px; padding-left: 10px; border-left: 1px solid #d0d5dd; }
	.curso-vinculado-label { color: #667085; font-size: 11px; font-weight: 600; text-transform: uppercase; }
	.curso-vinculado-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 9px; color: #fff; border-radius: 999px; font-size: 11px; font-weight: 600; }
	.curso-vinculado-ausente { color: #98a2b3; font-size: 11px; font-style: italic; }
	.acoes-vinculos { display: flex; flex-wrap: wrap; justify-content: center; gap: 6px; }
	.courseid-vinculado { color: #475467; font-weight: 600; white-space: nowrap; }
	.filtros-vinculados { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 14px 16px; background: #fff; border-bottom: 1px solid #e4e7ec; }
	.filtros-vinculados label { margin: 0; color: #667085; font-size: 12px; font-weight: 600; }
	.filtros-vinculados .form-select { width: min(100%, 260px); min-height: 38px; color: #344054; border-color: #d0d5dd; border-radius: 8px; font-size: 12px; }
	@media (max-width: 575.98px) { .filtros-vinculados { align-items: stretch; flex-direction: column; } .filtros-vinculados .form-select { width: 100%; } }
</style>
<div class="container">
    
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-calendar-alt text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Categorias</h4>
		</div>
		
		<div class="d-flex gap-2">
			<button type="button" id="btn-exportar-categorias" class="btn btn-success" data-bs-toggle="tooltip" title="Exportar categorias e cursos vinculados">
				<i class="bi bi-download"></i> Exportar
			</button>
			<a href="<?=base_url()?>restrito/cursos/categorias_curso" class="btn btn-primary" data-bs-toggle="tooltip" title="Vincular uma categoria a um curso"><i class="fa fa-plus"></i> Vincular Categoria/Curso</a>
		</div>
	</div>
	
	
	
	<?php
		$totalLinhas = count($tabela);
		
		$mapa_cores = [
			'Alimentos' => '#f97316,#fb923c',
			'Análises Clínicas' => '#9333ea,#a855f7',
			'Clínica' => '#ef4444,#f87171',
			'Educação' => '#10b981,#34d399',
			'Farmácia' => '#0ea5e9,#3b82f6',
			'Gestão' => '#facc15,#eab308',
			'Hospitalar' => '#8b5cf6,#a78bfa',
			'Industrial' => '#f43f5e,#fb7185',
			'Magistral' => '#8b5cf6,#a78bfa',
			'PICs' => '#22c55e,#4ade80',
			'Saúde Pública' => '#14b8a6,#2dd4bf',
			'Toxicologia' => '#f97316,#fcd34d',
			'Outros' => '#475569,#64748b'
		];
		
		/* cor principal */
        //$cor_principal = $mapa_cores[$primeira_categoria] ?? '#64748b,#94a3b8';
	?>
	<div class="kpi-container">
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-primary text-white"><i class="bi bi-collection"></i></div>
			<div class="kpi-info">
				<h6>Total de categorias</h6>
				<span><?=$totalLinhas;?></span>
			</div>
		</div>
	</div>
   
	
	<!-- INICIO TABELAS -->	
	<div class="container pb-5">
		<ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="pills-categorias-tab" data-bs-toggle="pill" data-bs-target="#pills-categorias" type="button" role="tab" title="Mostrar as categorias cadastradas" data-tooltip="true">
					<i class="bi bi-tags me-2"></i> Categorias Criadas
				</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="pills-vinculos-tab" data-bs-toggle="pill" data-bs-target="#pills-vinculos" type="button" role="tab" title="Mostrar os cursos vinculados às categorias" data-tooltip="true">
					<i class="bi bi-link-45deg me-2"></i> Cursos Vinculados
				</button>
			</li>
		</ul>

		<div class="tab-content" id="pills-tabContent">
			<div class="tab-pane fade show active" id="pills-categorias" role="tabpanel">
				<div class="card shadow-sm border-0 overflow-hidden rounded-4">
					<div class="table-responsive">
						<table class="table table-hover align-middle mb-0" id="table_programacao">
							<thead class="thead-azul text-white" style="background: #054589;">
								<tr>
									<th class="ps-4 py-3">#</th>
									<th>CATEGORIAS</th>
									<th>ICONES</th>
									<th>CORES</th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($tabela)): foreach ($tabela as $idx => $linha): 
									$cores = $mapa_cores[$linha->descricao] ?? '475569,64748b';
									$arr_c = explode(',', $cores);
								?>
								<tr>
									<td class="ps-4 fw-bold text-muted"><?= sprintf("%02d", $idx + 1); ?></td>
									<td class="fw-bold text-dark"><?= $linha->descricao ?></td>
									<td>
										<div class="area-icon" style="background: linear-gradient(135deg, <?= $arr_c[0] ?>, <?= $arr_c[1] ?? $arr_c[0] ?>);">
											<i class="<?= $linha->icon; ?> fa-solid"></i>
											<span class="label"><?= $linha->descricao; ?></span>
										</div>
									</td>
									<td><code class="badge bg-light text-dark border"><?= $cores ?></code></td>
								</tr>
								<?php endforeach; endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<div class="tab-pane fade" id="pills-vinculos" role="tabpanel">
			
			<div class="card shadow-sm border-0 overflow-hidden rounded-4">
				<div class="filtros-vinculados">
					<label for="filtroTipoCurso">Tipo de evento</label>
					<select id="filtroTipoCurso" class="form-select" data-bs-toggle="tooltip" title="Filtrar os cursos vinculados pelo tipo de evento">
						<option value="">Todos os tipos</option>
						<option value="1">Capacifar Presencial</option>
						<option value="2">Capacifar On-line</option>
						<option value="3">URM</option>
						<option value="4">Fiscalização Humanizada</option>
						<option value="5">Universitário Presencial</option>
						<option value="6">Universitário On-line</option>
						<option value="7">Seminário de Vigilância</option>
					</select>
				</div>
				<div class="table-responsive">
					<table class="table table-hover align-middle mb-0" id="tabelaVinculos">
						<thead class="thead-azul text-white" style="background: #054589;">
							<tr>
								<th class="ps-4 py-3">ID</th>
								<th>
									<div class="d-flex flex-column">
										<span class="mb-1">NOME DO CURSO</span>
										<div class="input-group input-group-sm" style="max-width: 250px;">
											<span class="input-group-text bg-light border-0" style="border-radius: 8px 0 0 8px;">
												<i class="bi bi-search text-muted"></i>
											</span>
											<input type="text" id="filtroCurso" class="form-control border-0 bg-light" placeholder="Buscar curso..." style="border-radius: 0 8px 8px 0; font-size: 0.8rem; height: 36px;">
										</div>
									</div>
								</th>
								<th class="text-center">AÇÕES</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($vinculados)): foreach ($vinculados as $v): ?>
							<?php
								$tiposCurso = [
									1 => 'Capacifar Presencial',
									2 => 'Capacifar On-line',
									3 => 'URM',
									4 => 'Fiscalização Humanizada',
									5 => 'Universitário Presencial',
									6 => 'Universitário On-line',
									7 => 'Seminário de Vigilância'
								];
								$nomeTipoCurso = $tiposCurso[(int) $v['tipo_evento']] ?? 'Outro';
							?>
							<tr class="linha-curso" data-tipo-evento="<?=(int)$v['tipo_evento']?>">
								<td class="ps-4 courseid-vinculado"><?=htmlspecialchars($v['courseid'], ENT_QUOTES, 'UTF-8')?></td>
								<td class="nome-curso-txt">
									<div class="curso-vinculado-topo">
										<span class="curso-vinculado-nome"><?=htmlspecialchars($v['nome_curso'], ENT_QUOTES, 'UTF-8')?></span>
										<span class="curso-vinculado-tipo"><?=htmlspecialchars($nomeTipoCurso, ENT_QUOTES, 'UTF-8')?></span>
										<span class="curso-vinculado-status <?=((int)$v['status'] === 1 ? 'ativo' : 'inativo')?>"><i class="bi <?=((int)$v['status'] === 1 ? 'bi-check-circle' : 'bi-slash-circle')?>"></i><?=((int)$v['status'] === 1 ? 'Ativo' : 'Inativo')?></span>
									</div>
									<div class="curso-vinculado-categorias">
										<div class="curso-vinculado-grupo">
											<span class="curso-vinculado-label">Principal:</span>
											<?php if (!empty($v['principal'])):
												$coresPrincipal = explode(',', $mapa_cores[$v['principal']['nome']] ?? '#475569,#64748b');
											?>
												<span class="curso-vinculado-badge" style="background:linear-gradient(135deg,<?=$coresPrincipal[0]?>,<?=$coresPrincipal[1] ?? $coresPrincipal[0]?>)"><i class="<?=htmlspecialchars($v['principal']['icon'], ENT_QUOTES, 'UTF-8')?> fa-solid"></i><?=htmlspecialchars($v['principal']['nome'], ENT_QUOTES, 'UTF-8')?></span>
											<?php else: ?><span class="curso-vinculado-ausente">Não definida</span><?php endif; ?>
										</div>
										<div class="curso-vinculado-grupo">
											<span class="curso-vinculado-label">Outras:</span>
											<?php if (!empty($v['outras'])): foreach ($v['outras'] as $categoriaOutras):
												$coresOutras = explode(',', $mapa_cores[$categoriaOutras['nome']] ?? '#475569,#64748b');
											?>
												<span class="curso-vinculado-badge" style="background:linear-gradient(135deg,<?=$coresOutras[0]?>,<?=$coresOutras[1] ?? $coresOutras[0]?>)"><i class="<?=htmlspecialchars($categoriaOutras['icon'], ENT_QUOTES, 'UTF-8')?> fa-solid"></i><?=htmlspecialchars($categoriaOutras['nome'], ENT_QUOTES, 'UTF-8')?></span>
											<?php endforeach; else: ?><span class="curso-vinculado-ausente">Nenhuma</span><?php endif; ?>
										</div>
									</div>
								</td>
								<td class="text-center">
									<div class="acoes-vinculos">
									<?php $categoriasAcao = array_merge(!empty($v['principal']) ? [$v['principal']] : [], $v['outras']); ?>
									<?php foreach ($categoriasAcao as $categoriaAcao): ?>
										<button type="button" onclick="confirmarExclusao(<?=$categoriaAcao['id']?>)" class="btn-delete-vinculo" data-bs-toggle="tooltip" title="Excluir o vínculo com <?=htmlspecialchars($categoriaAcao['nome'], ENT_QUOTES, 'UTF-8')?>">
											<i class="bi bi-trash3-fill"></i>
										</button>
									<?php endforeach; ?>
									</div>
								</td>
							</tr>
							<?php endforeach; else: ?>
							<tr id="no-results"><td colspan="3" class="text-center py-5 text-muted">Nenhum curso vinculado.</td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
			
		</div>
	</div>
<script>
document.getElementById('btn-exportar-categorias').addEventListener('click', function() {
    Swal.fire({
        title: 'Exportar categorias',
        text: 'Escolha o formato do arquivo:',
        icon: 'question',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-file-earmark-excel me-1"></i> Excel',
        denyButtonText: '<i class="bi bi-file-earmark-pdf me-1"></i> PDF',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#198754',
        denyButtonColor: '#dc3545'
    }).then(function(resultado) {
        if (resultado.isConfirmed) {
            window.location.href = '<?=base_url("restrito/cursos/categorias_exportar_excel")?>';
        } else if (resultado.isDenied) {
            window.location.href = '<?=base_url("restrito/cursos/categorias_exportar_pdf")?>';
        }
    });
});

function confirmarExclusao(id) {
    Swal.fire({
        title: 'Excluir Vínculo?',
        text: "Esta ação não poderá ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= base_url('restrito/cursos/categoria_excluir/') ?>" + id;
        }
    })
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-bs-toggle="tooltip"], [data-tooltip="true"]').forEach(function(elemento) {
        bootstrap.Tooltip.getOrCreateInstance(elemento);
    });

	const inputFiltro = document.getElementById('filtroCurso');
	const selectTipo = document.getElementById('filtroTipoCurso');

	function aplicarFiltrosVinculados() {
		const busca = (inputFiltro ? inputFiltro.value : '').toLowerCase().trim();
		const tipo = selectTipo ? selectTipo.value : '';
		const linhas = document.querySelectorAll('.linha-curso');
		let encontrou = false;

		linhas.forEach(function(linha) {
			const textoCurso = linha.querySelector('.nome-curso-txt').textContent.toLowerCase();
			const correspondeNome = !busca || textoCurso.includes(busca);
			const correspondeTipo = !tipo || linha.dataset.tipoEvento === tipo;
			const mostrar = correspondeNome && correspondeTipo;
			linha.style.display = mostrar ? '' : 'none';
			if (mostrar) encontrou = true;
		});

		let msgVazio = document.getElementById('no-results-filter');
		if (!encontrou && linhas.length > 0) {
			if (!msgVazio) {
				msgVazio = document.createElement('tr');
				msgVazio.id = 'no-results-filter';
				msgVazio.innerHTML = '<td colspan="3" class="text-center py-4 text-muted">Nenhum curso encontrado para os filtros selecionados.</td>';
				document.querySelector('#tabelaVinculos tbody').appendChild(msgVazio);
			}
		} else if (msgVazio) {
			msgVazio.remove();
		}
	}

	if (inputFiltro) inputFiltro.addEventListener('input', aplicarFiltrosVinculados);
	if (selectTipo) selectTipo.addEventListener('change', aplicarFiltrosVinculados);
});
</script>
