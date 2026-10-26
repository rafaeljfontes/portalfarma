<?php

	$totalLinhas = count($total_alunos_cursos);
	$totalStudent = 0;

	$totalStudent = array_sum(array_column($total_alunos_cursos, 'total_estudantes'));

?>
<style>
	thead th {
		background-color: #0468aa;
		color: white;
	}

	h6{
		color: #0468aa;
	}
</style>
<div class="container">
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-file-signature text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Quantidade Inscrições por Curso</h4>
		</div>
	</div>
	<form method="get" action="<?=base_url('restrito/capacifar/inscricoescursos')?>" class="bg-white p-3 rounded shadow-sm mb-4 border">
		<?php if (!empty($escopoDesignados)): ?><input type="hidden" name="escopo" value="designados"><?php endif; ?>
		<label for="tipo_evento" class="form-label fw-semibold">Tipo do evento</label>
		<div class="d-flex flex-wrap gap-2">
			<select name="tipo_evento" id="tipo_evento" class="form-select w-auto">
				<option value="">Todos os tipos</option>
				<?php foreach ($tiposEvento as $tipo => $nome): ?>
					<option value="<?=$tipo?>" <?=$tipoEventoSelecionado === $tipo ? 'selected' : ''?>><?=$tipo?> - <?=html_escape($nome)?></option>
				<?php endforeach; ?>
			</select>
			<button type="submit" class="btn btn-primary">Filtrar</button>
			<a href="<?=base_url('restrito/capacifar/inscricoescursos').(!empty($escopoDesignados) ? '?escopo=designados' : '')?>" class="btn btn-outline-secondary">Limpar</a>
		</div>
	</form>



	<div class="alert alert-info d-flex justify-content-between align-items-center gap-2 small">
        <span>Total encontrado: <strong><?=$totalLinhas;?></strong> evento(s)</span>
		<span><strong><?=$totalStudent;?></strong> Inscrições</span>
    </div>


	<!-- Orders -->
	<div class="row">
		<div class="col">

			<table class="table table-striped table-bordered table-responsive" id="table_programacao" style="font-size: 12px;">
				<thead>
					<tr>
						<th class="serial">#</th>
						<th>ID</th>
						<th>Tipo do evento</th>
						<th>Titulo</th>
						<th>Palestrantes</th>
						<th>Nº de Inscrições</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				<?php if (empty($total_alunos_cursos)): ?>
					<tr><td colspan="7" class="text-center text-muted py-4">Nenhum curso/evento encontrado.</td></tr>
				<?php endif; ?>
				<?php

				$i = 0;
				foreach ($total_alunos_cursos as $item) {

				$i++;
				?>
					<tr>
						<td class="serial"><?=$i?>º</td>

						<td> <span class="name"><?=(int) $item->courseid;?></span> </td>
						<td><?=(int) $item->tipo_evento;?> - <?=html_escape($tiposEvento[(int) $item->tipo_evento] ?? 'Outro');?></td>
						<td><h6><span class="product"><?=html_escape($item->titulo);?></span></h6></td>
						<td><?=html_escape($item->palestrantes ?: 'Não informado');?></td>
						<td><h6><span class="count"><?=$item->total_estudantes;?></span></h6></td>
						<td>
							<span class="badge bg-<?=(int) $item->status === 1 ? 'success' : 'secondary'?>"><?=(int) $item->status === 1 ? 'Ativo' : 'Inativo'?></span>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>

		</div>
	</div>
	<!-- /.orders -->


</div>



