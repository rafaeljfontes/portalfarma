<div class="container">
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-file-signature text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Eventos - Capacifar</h4>
		</div>
	</div>
	
	
	
	<div class="alert alert-info d-flex justify-content-between align-items-center gap-2 small">
        <span>Total encontrado: <strong><?=$totalLinhas;?></strong> evento(s)</span>
		
		<span><strong><?=$qtdOnline;?></strong> Online</span>
        <span><strong><?=$qtdPresencial;?></strong> Presencial</span>
    </div>
	
	<!-- Orders -->
		<div class="orders">
			<div class="row">
				<div class="col-xl-8">
					<div class="card">
						<div class="card-body">
							<h4 class="box-title">Cursos mais requisitados</h4>
							<a href="<?=base_url()?>restrito/capacifar/inscricoescursos">ver todos</a>
						</div>
						<div class="card-body--">
							<div class="table-stats order-table ov-h">
								<table class="table ">
									<thead>
										<tr>
											<th class="serial">#</th>
											<th>ID</th>
											<th>Titulo</th>
											<th>Professores</th>
											<th>Quantity</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
									<?php
									var_dump($total_alunos_cursos);
									
									$i = 0;
									foreach ($total_alunos_cursos as $item) {
									
									$i++;
									?>
										<tr>
											<td class="serial"><?=$i?>º</td>
											
											<td> <span class="name"><?=$item->courseid;?></span> </td>
											<td> <span class="product"><?=$item->fullname;?></span> </td>
											<td><?=$item->professor;?></td>
											<td> <span class="count"><?=$item->total_estudantes;?></span></td>
											<td>
												<span class="badge badge-complete"><?=$item->category_name;?></span>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div> <!-- /.table-stats -->
						</div>
					</div> <!-- /.card -->
				</div>  <!-- /.col-lg-8 -->
		
				<div class="col-xl-4">
					<div class="row">
						<div class="col-lg-6 col-xl-12">
							<!-- GRAFICO PIZZA -->
							<div class="card shadow-sm">
								<div class="card-body text-center">

									<h5 class="mb-4">Distribuição de Usuários Moodle</h5>

									<div style="position:relative; height:400px;">
										<canvas id="graficoPizza"></canvas>
									</div>

								</div>
							</div>
							
							<div class="col-lg-6 col-xl-12">
                                    <div class="card br-0">
                                        <div class="card-body">
                                            <div class="chart-container ov-h">
                                                <div id="flotPie1" class="float-chart"></div>
                                            </div>
                                        </div>
                                    </div><!-- /.card -->
                                </div>


						</div>

					</div>
				</div> <!-- /.col-md-4 -->
			</div>
		</div>
		<!-- /.orders -->
</div>