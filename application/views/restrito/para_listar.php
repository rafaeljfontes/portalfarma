<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/restrito/painel.css')?>">
<?php $opcoesPara = [
	1 => ['nome' => 'Para Farmacêutico', 'classe' => 'para-farmaceutico'],
	2 => ['nome' => 'Para Empresa', 'classe' => 'para-empresa'],
	3 => ['nome' => 'Para Sociedade', 'classe' => 'para-sociedade']
]; ?>
<style>
	.thead-azul, .thead-azul th { background-color: #004761 !important; color: #fff !important; }
	.para-badge { display: inline-flex; padding: 6px 10px; border-radius: 5px; font-size: 12px; font-weight: 700; white-space: nowrap; }
	.para-farmaceutico { color: #175cd3; background: #eff8ff; border: 1px solid #b2ddff; }
	.para-empresa { color: #b54708; background: #fffaeb; border: 1px solid #fedf89; }
	.para-sociedade { color: #067647; background: #ecfdf3; border: 1px solid #abefc6; }
</style>
<div class="container">
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap gap-2">
		<div class="d-flex align-items-center"><i class="bi bi-people-fill text-primary me-2 fs-4"></i><h4 class="mb-0 text-primary">Cursos por público</h4></div>
		<a href="<?=base_url('restrito/cursos/para_curso')?>" class="btn btn-primary"><i class="fa fa-plus"></i> Vincular Curso Para</a>
	</div>
	<div class="card shadow-sm border-0 overflow-hidden rounded-4 mb-5">
		<div class="table-responsive">
			<table class="table table-hover align-middle mb-0" id="table_programacao">
				<thead class="thead-azul"><tr><th class="ps-4 py-3">#</th><th>COURSEID</th><th>CURSO</th><th>PARA</th></tr></thead>
				<tbody>
				<?php if (!empty($tabela)): foreach ($tabela as $indice => $linha): ?>
					<tr>
						<td class="ps-4 fw-bold text-muted"><?=sprintf('%02d', $indice + 1)?></td>
						<td class="fw-semibold"><?=htmlspecialchars((string) $linha['courseid'], ENT_QUOTES, 'UTF-8')?></td>
						<td><?=htmlspecialchars($linha['nome_curso'] ?: 'Curso não encontrado', ENT_QUOTES, 'UTF-8')?></td>
						<td>
							<div class="d-flex flex-wrap gap-2">
								<?php foreach ($linha['publicos'] as $idpara): $opcao = $opcoesPara[$idpara] ?? null; ?>
									<?php if ($opcao): ?><span class="para-badge <?=$opcao['classe']?>"><?=$opcao['nome']?></span><?php endif; ?>
								<?php endforeach; ?>
							</div>
						</td>
					</tr>
				<?php endforeach; else: ?>
					<tr><td colspan="4" class="text-center text-muted py-4">Nenhum curso vinculado.</td></tr>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
