
<!-- CSS GERAL -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
	/*$('.table').DataTable({
		dom: 'Bfrtip',
		buttons: ['copy', 'csv', 'excel', 'pdf']
	});*/
</script>
<div class="container">
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex text-primary text-uppercase font-weight-bold align-items-center mb-2 mb-md-0">
			<i class="fas fa-chart-pie me-2 text-primary me-2 fs-4"></i>
			<?= $titulo; ?>
		</div>
	</div>
	
	<div class="container-fluid mt-4">
		<div class="row">
			<div class="col-12">
				<div class="card card-outline card-primary shadow-sm">
					
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-hover table-striped mb-0">
								<thead class="bg-light">
									<tr>
										<th>Ocupação</th>
										<th class="text-center">Inscritos Online</th>
										<th class="text-center">Inscritos Presencial</th>
										<th class="text-center">Presenças Confirmadas</th>
										<th class="text-center">Total Inscritos</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									
										$t_online = 0; $t_presencial = 0; $t_confirmada = 0;
										
										foreach ($stats as $row): 
											$total_linha = $row->inscritos_online + $row->inscritos_presencial;
											$t_online += $row->inscritos_online;
											$t_presencial += $row->inscritos_presencial;
											$t_confirmada += $row->presencas_confirmadas;
									?>
									<tr>
										<td class="font-weight-bold"><?= $row->ocupacao_nome; ?></td>
										<td class="text-center"><span class="badge badge-info"><?= $row->inscritos_online; ?></span></td>
										<td class="text-center"><span class="badge badge-warning"><?= $row->inscritos_presencial; ?></span></td>
										<td class="text-center"><span class="badge badge-success"><?= $row->presencas_confirmadas; ?></span></td>
										<td class="text-center text-bold"><?= $total_linha; ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot class="bg-primary text-white text-center">
									<tr>
										<th class="text-left">TOTAIS GERAIS</th>
										<th><?= $t_online; ?></th>
										<th><?= $t_presencial; ?></th>
										<th><?= $t_confirmada; ?></th>
										<th><?= ($t_online + $t_presencial); ?></th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<div class="card-footer shadow-sm">
						<small class="text-muted">Dados atualizados em: <?= date('d/m/Y H:i'); ?></small>
					</div>
				</div>
			</div>
		</div>
	</div>
