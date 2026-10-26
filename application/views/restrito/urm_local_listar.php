<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/restrito/painel.css')?>">

<div class="container">
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="bi bi-geo-alt-fill text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Locais - Uso Racional de Medicamentos</h4>
		</div>
		<!--<a href="<?=base_url('restrito/urm/local/cadastrar')?>" class="btn btn-primary btn-cadastrar">
			<i class="fas fa-plus"></i> Cadastrar local
		</a>-->
	</div>

	<?php if ($this->session->flashdata('local_sucesso')): ?>
		<div class="alert alert-success"><?=$this->session->flashdata('local_sucesso')?></div>
	<?php endif; ?>

	<div class="kpi-container">
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-primary text-white"><i class="bi bi-pin-map"></i></div>
			<div class="kpi-info"><h6>Total de locais</h6><span><?=count($locais)?></span></div>
		</div>
	</div>

	<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
		<div class="table-responsive">
			<table class="table table-hover align-middle mb-0">
				<thead class="thead-azul">
					<tr>
						<th class="ps-4">IMAGEM</th>
						<th>LOCAL / CIDADE</th>
						<th>DESCRIÇÃO</th>
						<th>DATA</th>
						<th class="text-center pe-4">AÇÕES</th>
					</tr>
				</thead>
				<tbody class="bg-white">
				<?php if (empty($locais)): ?>
					<tr><td colspan="5" class="text-center text-muted py-5">Nenhum local cadastrado.</td></tr>
				<?php else: foreach ($locais as $local): ?>
					<tr style="font-size:13px">
						<td class="ps-4">
							<img src="<?=base_url('uploads/urm_locais/'.rawurlencode($local->imagem_arquivo))?>" alt="<?=htmlspecialchars($local->titulo, ENT_QUOTES, 'UTF-8')?>" class="rounded border" style="width:72px;height:48px;object-fit:cover">
						</td>
						<td>
							<div class="main-text mb-0"><?=htmlspecialchars($local->titulo, ENT_QUOTES, 'UTF-8')?></div>
							<div class="sub-text text-primary"><i class="bi bi-geo-alt-fill me-1"></i><?=htmlspecialchars($local->cidade, ENT_QUOTES, 'UTF-8')?></div>
						</td>
						<td style="max-width:360px"><?=nl2br(htmlspecialchars($local->descricao, ENT_QUOTES, 'UTF-8'))?></td>
						<td><span class="badge bg-light text-dark border fw-normal"><i class="bi bi-calendar-event me-1 text-primary"></i><?=date('d/m/Y', strtotime($local->data))?></span></td>
						<td class="text-center pe-4">
							<div class="btn-group shadow-sm rounded-3 overflow-hidden">
								<a href="<?=base_url('restrito/urm/local/editar/'.$local->id.'?registro=1')?>" class="btn btn-sm btn-light border-end px-3" title="Editar">
									<i class="bi bi-pencil-square text-primary"></i>
								</a>
								<?php if (!empty($local->link)): ?>
									<a href="<?=htmlspecialchars($local->link, ENT_QUOTES, 'UTF-8')?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-light px-3" title="Abrir link"><i class="bi bi-box-arrow-up-right text-primary"></i></a>
								<?php endif; ?>
							</div>
						</td>
					</tr>
				<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
