
<!-- CSS GERAL -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">
<script>
document.querySelectorAll('.btn-filtro').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.btn-filtro')
            .forEach(b => b.classList.remove('active'));

        btn.classList.add('active');

        const filtro = btn.dataset.filtro;
        console.log('Filtro selecionado:', filtro);
    });
});
</script>
 <!-- Utilizando Tailwind CSS para o layout rápido -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
		#menuEsquerda.collapse {
			visibility: visible;
		}

		@media (max-width: 767.98px) {
			#menuEsquerda.collapse:not(.show) {
				display: none;
			}

			#menuEsquerda.collapse.show {
				display: block;
			}
		}

        /* Estilização personalizada para a barra de rolagem */
        .scrollbar-custom::-webkit-scrollbar {
            height: 14px;
        }

        .scrollbar-custom::-webkit-scrollbar-track {
            background: #f4f4f5; 
            border-radius: 10px;
            margin: 0 4px;
        }

        .scrollbar-custom::-webkit-scrollbar-thumb {
            background-color: #8b8b8b;
            border-radius: 10px;
            border: 3px solid #f4f4f5; 
        }

        .scrollbar-custom::-webkit-scrollbar-thumb:hover {
            background-color: #6b7280;
        }
        
        .scrollbar-custom {
            scrollbar-width: thin;
            scrollbar-color: #8b8b8b #f4f4f5;
        }

		.seminario-resumo { margin-bottom: 20px; overflow: hidden; background: #fff; border: 1px solid #e4e7ec; border-radius: 12px; box-shadow: 0 1px 2px rgba(16,24,40,.04); }
		.seminario-resumo-header { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; border-bottom: 1px solid #e4e7ec; }
		.seminario-resumo-header h5 { margin: 0; color: #101828; font-size: 18px; font-weight: 600; }
		.seminario-resumo-header p { margin: 4px 0 0; color: #667085; font-size: 12px; }
		.seminario-resumo-menu { color: #98a2b3; font-size: 20px; letter-spacing: 2px; }
		.seminario-resumo-table { width: 100%; margin: 0; border-collapse: collapse; }
		.seminario-resumo-table th { padding: 13px 24px; color: #667085; background: #f9fafb; border-bottom: 1px solid #e4e7ec; font-size: 12px; font-weight: 500; text-align: left; }
		.seminario-resumo-table td { padding: 13px 24px; color: #475467; border-bottom: 1px solid #e4e7ec; font-size: 14px; vertical-align: middle; }
		.seminario-resumo-table tbody tr:last-child td { border-bottom: 0; }
		.seminario-resumo-table tbody tr:hover { background: #fcfcfd; }
		.seminario-resumo-nome { position: relative; min-width: 260px; }
		.seminario-resumo-progresso { position: absolute; z-index: 0; left: 16px; bottom: 7px; height: 34px; max-width: calc(100% - 32px); background: #eef4ff; border-radius: 6px; }
		.seminario-resumo-conteudo { position: relative; z-index: 1; }
		.seminario-resumo-titulo { display: block; color: #344054; font-weight: 600; }
		.seminario-resumo-data { display: block; margin-top: 3px; color: #98a2b3; font-size: 11px; }
		.seminario-resumo-total { color: #101828; font-size: 15px; font-weight: 600; }
		.seminario-resumo-vazio { padding: 28px !important; color: #667085 !important; text-align: center; }
		@media (max-width: 767.98px) {
			.seminario-resumo-header { padding: 16px; }
			.seminario-resumo-table th, .seminario-resumo-table td { padding: 12px 16px; }
			.seminario-resumo-nome { min-width: 230px; }
		}
		</style>
	
<?php
	
	$totalLinhas = count($tabelaCurso);
	$qtdOnline = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '2';
	}));
	$qtdPresencial = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '1';
	}));
	$qtdurm = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '3';
	}));
	$qtdfh = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '4';
	}));
	
?>
<div class="container">
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-calendar-alt text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Seminários</h4>
		</div>
		
		<div class="d-flex gap-2">
			<a href="<?=base_url()?>restrito/cursos/cadastrar" class="btn btn-primary btn-cadastrar">
				<i class="fas fa-plus"></i> Cadastrar Seminário
			</a>
			<button type="button" class="btn btn-outline-secondary" onclick="history.back()">
				<i class="bi bi-arrow-left"></i> Voltar
			</button>
		</div>
	</div>
	
	
	
	<div class="kpi-container">
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-primary text-white"><i class="bi bi-collection"></i></div>
			<div class="kpi-info">
				<h6>Total Eventos</h6>
				<span><?=$totalLinhas;?></span>
			</div>
		</div>
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-success text-white"><i class="bi bi-globe"></i></div>
			<div class="kpi-info">
				<h6>Inscrições</h6>
				<span><?=$qtdOnline;?></span>
			</div>
		</div>
	</div>
	
	<?php
	$maiorTotalSeminario = 0;
	foreach (($tabelaincricoes ?? []) as $resumoSeminario) {
		$totalSeminario = (int) $resumoSeminario->total_online + (int) $resumoSeminario->total_presencial;
		$maiorTotalSeminario = max($maiorTotalSeminario, $totalSeminario);
	}
	?>
	<section class="seminario-resumo">
		<div class="seminario-resumo-header">
			<div>
				<h5>Inscrições por seminário</h5>
				<p>Comparativo das participações on-line e presenciais.</p>
			</div>
			<span class="seminario-resumo-menu" aria-hidden="true">•••</span>
		</div>
		<div class="table-responsive">
			<table class="seminario-resumo-table">
				<thead><tr><th>Seminário</th><th>On-line</th><th>Presencial</th></tr></thead>
				<tbody>
				<?php foreach (($tabelaincricoes ?? []) as $resumoSeminario):
					$totalSeminario = (int) $resumoSeminario->total_online + (int) $resumoSeminario->total_presencial;
					$percentualBarra = $maiorTotalSeminario > 0 ? max(12, round(($totalSeminario / $maiorTotalSeminario) * 100)) : 0;
					$dataSeminario = !empty($resumoSeminario->data_inicio) ? date('d/m/Y', strtotime($resumoSeminario->data_inicio)) : 'Data não informada';
				?>
					<tr>
						<td class="seminario-resumo-nome">
							<span class="seminario-resumo-progresso" style="width:<?=$percentualBarra?>%"></span>
							<div class="seminario-resumo-conteudo">
								<span class="seminario-resumo-titulo"><?=htmlspecialchars($resumoSeminario->titulo ?: $resumoSeminario->seminario, ENT_QUOTES, 'UTF-8')?></span>
								<span class="seminario-resumo-data"><?=htmlspecialchars($resumoSeminario->seminario, ENT_QUOTES, 'UTF-8')?> · <?=$dataSeminario?></span>
							</div>
						</td>
						<td><span class="seminario-resumo-total"><?=number_format((int) $resumoSeminario->total_online, 0, ',', '.')?></span></td>
						<td><span class="seminario-resumo-total"><?=number_format((int) $resumoSeminario->total_presencial, 0, ',', '.')?></span></td>
					</tr>
				<?php endforeach; ?>
				<?php if (empty($tabelaincricoes)): ?><tr><td colspan="3" class="seminario-resumo-vazio">Nenhuma inscrição de seminário encontrada.</td></tr><?php endif; ?>
				</tbody>
			</table>
		</div>
	</section>
	
	<?php
	if ($totalLinhas == 0){
		echo "nenhum retorno";
	} else {

	?>
    <div class="row">
        <div class="col">
            <table class="table table-hover border shadow-sm" id="table_programacao" style="font-size: 12px; background: white;">
				<thead>
					<tr>
						<th style="width: 5px;"></th> 
						<th class="align-top">
							MOODLE
							<input type="text" class="filter-input" placeholder="ID..." onkeyup="filterTable(0, this.value)">
						</th>
						<th class="align-top">IMG</th>
						<th class="align-top">
							TIPO
							<select class="filter-input" onchange="filterTable(3, this.value)">
								<option value="">Todos</option>
								<option value="Online">Online</option>
								<option value="Presencial">Presencial</option>
							</select>
						</th>
						<th class="align-top">
							NOME
							<input type="text" class="filter-input" placeholder="Buscar nome..." onkeyup="filterTable(4, this.value)">
						</th>
						<th class="align-top">DATAS</th>
						<th class="align-top text-center">CH</th>
						<th class="align-top text-center">INFOS</th>
						<th class="align-top text-center">CADASTRO</th>
						<th class="align-top"></th>
					</tr>
				</thead>
                <tbody>
					<?php 
					
					foreach ($tabelaCurso as $campo){
						
						// Lógica de Status
						$is_ativo = ($campo->status == 1);
						$status_label = $is_ativo ? 'Ativo' : 'Desativado';
						$status_class = $is_ativo ? 'bg-ativo' : 'bg-desativado';
						
						// Lógica de Tipo 
						$campo_evento = "Outro";
						if($campo->tipo_evento == 1) $campo_evento = "Presencial";
						if($campo->tipo_evento == 2) $campo_evento = "Online";
						if($campo->tipo_evento == 3) $campo_evento = "Evento";
						$classe_tipo = strtolower($campo_evento);
						$presencaLiberada = isset($campo->presenca_liberada) && (int) $campo->presenca_liberada === 1;
					?>
					<tr class="position-relative">
						<td class="p-0" style="width: 5px;">
							<div class="status-indicator <?= $status_class ?>"></div>
						</td>

						<td class="text-center align-middle">
							<small class="text-muted d-block">ID MOODLE</small>
							<span class="fw-bold">#<?= $campo->courseid; ?></span>
						</td>

						<td class="align-middle" style="width: 80px;">
							<img src="<?=base_url()?>uploads/cursos/<?= $campo->nome_curto; ?>.png" 
								 class="img-curso" 
								 style="width: 70px; height: 45px;" >
						</td>

						<td class="align-middle">
							<span class="badge-tipo tipo-evento-<?= $classe_tipo; ?>"><?= $campo_evento; ?></span>
						</td>

						<td class="align-middle">
							<div class="fw-bold" style="color:#054589; font-size: 14px;"><?= $campo->titulo; ?></div>
							<small class="text-muted">Cadastrado em: <?= date('d/m/Y', strtotime($campo->data_cadastro)); ?></small>
						</td>

						<td class="align-middle">
							<div class="d-flex flex-column">
								<span class="fw-bold text-dark" style="font-size: 13px;">
									<i class="bi bi-calendar-check text-success me-1"></i> 
									<?= date('d/m/Y', strtotime($campo->data_inicio)); ?>
									<span class="text-muted fw-normal ms-1">
										<i class="bi bi-clock"></i> <?= date('H:i', strtotime($campo->data_inicio)); ?>
									</span>
								</span>

								<small class="text-muted">
									<i class="bi bi-calendar-x me-1"></i> 
									<?php if(!empty($campo->data_fim)): ?>
										<?= date('d/m/Y', strtotime($campo->data_fim)); ?>
										<span class="ms-1"><i class="bi bi-clock"></i> <?= date('H:i', strtotime($campo->data_fim)); ?></span>
									<?php else: ?>
										---
									<?php endif; ?>
								</small>
							</div>
						</td>

						<td class="text-center align-middle">
							<span class="badge bg-light text-dark border"><?= $campo->carga_horaria / 60; ?>h</span>
						</td>

						<td class="align-middle">
							<div class="d-flex gap-1 justify-content-center">
								<a href="javascript:void(0)" class="info-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-title="Tópicos" data-bs-content='<?= htmlspecialchars($campo->topicos) ?>'>
									<i class="bi bi-card-list" title="Tópicos"></i>
								</a>
								
								<a href="javascript:void(0)" class="info-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-title="Descrição" data-bs-content='<?= htmlspecialchars($campo->descricao) ?>'>
									<i class="bi bi-card-text" title="Descrição"></i>
								</a>

								<a href="javascript:void(0)" class="info-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-title="Palestrantes" data-bs-content='<?php 
									if(!empty($campo->palestrantes)){
										$array = explode(",", $campo->palestrantes);
										echo "<ul>";
										foreach($array as $p) echo "<li>".trim($p)."</li>";
										echo "</ul>";
									} else { echo "Nenhum"; }
								?>'>
									<i class="bi bi-mic" title="Palestrantes"></i>
								</a>

								<a href="javascript:void(0)" class="info-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-title="Programação" data-bs-content='<?= htmlspecialchars($campo->programacao) ?>'>
									<i class="bi bi-calendar3" title="Programação"></i>
								</a>
							</div>
						</td>
						
						<td class="align-middle">
							<div class="d-flex flex-column">
								<span><i class="bi bi-calendar-check text-success"></i> <?= date('d/m/Y', strtotime($campo->data_cadastro)); ?></span>
							</div>
						</td>
						<td class="text-center align-middle">
							<div class="btn-group shadow-sm">
								<a href="<?=base_url()?>restrito/seminario/estatisticas/<?=$campo->courseid?>" 
								   class="btn btn-sm btn-outline-primary px-3" 
								   title="DashBoard">
									<i class="bi bi-speedometer2"></i>
								</a>
								
								<a href="<?=base_url()?>restrito/cursos/lista_presenca/<?=$campo->courseid?>" 
								   class="btn btn-sm btn-outline-primary px-3" 
								   title="Marcar presença">
									<i class="bi bi-check"></i>
								</a>
								
								<a href="<?=base_url()?>restrito/cursos/lista_inscritos/<?=$campo->courseid?>" 
								   class="btn btn-sm btn-outline-primary px-3" 
								   title="Lista de Inscritos">
									<i class="bi bi-people"></i>
								</a>

								<a href="<?=base_url()?>restrito/cursos/editar/<?=$campo->id?>" 
								   class="btn btn-sm btn-outline-primary px-3" 
								   title="Editar Curso">
									<i class="bi bi-pencil"></i>
								</a>

								<button type="button" class="btn btn-sm btn-outline-primary px-3 btn-opcoes-nps"
									data-url-acessar="<?=base_url('nps/listar')?>?courseid=<?=urlencode($campo->courseid)?>"
									data-url-gerar="<?=base_url('nps/')?><?=urlencode($campo->courseid)?>"
									data-courseid="<?=htmlspecialchars($campo->courseid, ENT_QUOTES, 'UTF-8')?>"
									data-bs-toggle="tooltip" title="Acessar o painel ou gerar o link público do NPS deste seminário">
									<i class="bi bi-bar-chart-line"></i>
								</button>

								<button type="button"
									class="btn btn-sm px-3 btn-liberar-presenca <?=$presencaLiberada ? 'btn-success' : 'btn-outline-success'?>"
									data-courseid="<?=htmlspecialchars($campo->courseid, ENT_QUOTES, 'UTF-8')?>"
									data-liberada="<?=$presencaLiberada ? '1' : '0'?>"
									data-bs-toggle="tooltip"
									title="<?=$presencaLiberada ? 'Bloquear marcação de presença deste seminário' : 'Liberar marcação de presença deste seminário'?>">
									<i class="bi <?=$presencaLiberada ? 'bi-unlock-fill' : 'bi-person-check'?>"></i>
								</button>

								<button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"></button>
								<ul class="dropdown-menu dropdown-menu-end shadow border-0">
									<li><h6 class="dropdown-header">Status: <?= $status_label ?></h6></li>
									<li>
										<button type="button" class="dropdown-item btn-status d-flex align-items-center gap-2" data-id="<?= $campo->id ?>" data-status="<?= $campo->status ?>">
											<?php if($is_ativo): ?>
												<i class="bi bi-ban text-danger"></i> <span class="text-danger">Desativar</span>
											<?php else: ?>
												<i class="bi bi-check2-circle text-success"></i> <span class="text-success">Ativar</span>
											<?php endif; ?>
										</button>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<?php } ?>
					</tbody>
            </table>
        </div>
    </div>
	<?php
	}
	?>
</div>
<!-- MOdal Confirmação --> 
<div class="modal fade" id="modalConfirmar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p id="textoConfirmacao"></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="confirmarAlteracao" class="btn btn-primary">Confirmar</button>
            </div>

        </div>
    </div>
</div>
<!-- MOdal REtorno --> 
<div class="modal fade" id="modalRetorno" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Resultado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p id="mensagemRetorno"></p>
            </div>

        </div>
    </div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(){

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')

    popoverTriggerList.forEach(function (el) {
        new bootstrap.Popover(el)
    });

	document.querySelectorAll('.btn-opcoes-nps').forEach(function (botao) {
		botao.addEventListener('click', function () {
			Swal.fire({
				title: 'NPS do seminário ' + botao.dataset.courseid,
				text: 'Escolha o que deseja fazer:',
				icon: 'question',
				showDenyButton: true,
				showCancelButton: true,
				confirmButtonText: '<i class="bi bi-bar-chart-line me-1"></i> Acessar NPS',
				denyButtonText: '<i class="bi bi-link-45deg me-1"></i> Gerar link NPS',
				cancelButtonText: 'Cancelar',
				confirmButtonColor: '#465fff',
				denyButtonColor: '#198754'
			}).then(function (resultado) {
				if (resultado.isConfirmed) {
					window.location.href = botao.dataset.urlAcessar;
				} else if (resultado.isDenied) {
					window.location.href = botao.dataset.urlGerar;
				}
			});
		});
	});

	document.querySelectorAll('.btn-liberar-presenca').forEach(function (botao) {
		botao.addEventListener('click', function () {
			const estaLiberada = botao.dataset.liberada === '1';
			const novoEstado = estaLiberada ? 0 : 1;

			Swal.fire({
				title: estaLiberada ? 'Bloquear marcação de presença?' : 'Liberar marcação de presença?',
				text: estaLiberada
					? 'O botão de confirmar presença deixará de aparecer para este seminário.'
					: 'Os inscritos poderão confirmar a presença na página pública do seminário.',
				icon: 'question',
				showCancelButton: true,
				confirmButtonText: estaLiberada ? 'Sim, bloquear' : 'Sim, liberar',
				cancelButtonText: 'Cancelar',
				confirmButtonColor: estaLiberada ? '#dc3545' : '#198754'
			}).then(function (resultado) {
				if (!resultado.isConfirmed) {
					return;
				}

				$.ajax({
					url: '<?=base_url("restrito/seminario/alterar_liberacao_presenca")?>',
					type: 'POST',
					dataType: 'json',
					data: {
						courseid: botao.dataset.courseid,
						liberar: novoEstado
					},
					success: function (resposta) {
						Swal.fire({
							title: 'Tudo certo!',
							text: resposta.message,
							icon: 'success',
							timer: 1800,
							showConfirmButton: false
						}).then(function () {
							window.location.reload();
						});
					},
					error: function (xhr) {
						const resposta = xhr.responseJSON || {};
						Swal.fire('Erro!', resposta.message || 'Não foi possível alterar a liberação de presença.', 'error');
					}
				});
			});
		});
	});

});
</script>
<script>
	let idSelecionado = null;
		let statusAtual = null;

		$(document).on("click",".btn-status",function(){

			idSelecionado = $(this).data("id");
			statusAtual = $(this).data("status");

			let texto = statusAtual == 1 
				? "Deseja desativar este curso?" 
				: "Deseja ativar este curso?";

			$("#textoConfirmacao").text(texto);

			const modal = new bootstrap.Modal(document.getElementById('modalConfirmar'));
			modal.show();

		});
</script>
<script>
	$("#confirmarAlteracao").click(function(){

    $.ajax({

        url: "<?=base_url()?>restrito/cursos/alterar_status",
        type: "POST",
        dataType: "json",
        data:{
            id:idSelecionado,
            status:statusAtual
        },

        success:function(res){

            $("#mensagemRetorno").text(res.message);

            const modalRetorno = new bootstrap.Modal(document.getElementById('modalRetorno'));
            modalRetorno.show();

            setTimeout(function(){
                location.reload();
            },1500);

        },

        error:function(){

            $("#mensagemRetorno").text("Erro ao alterar status.");

            const modalRetorno = new bootstrap.Modal(document.getElementById('modalRetorno'));
            modalRetorno.show();
        }

    });

});
</script>
<script>
	/*new DataTable('#table_programacao', {
        info: false,
        ordering: false,
        paging: false,
    });*/


    $(".mudar_status").change(async function(e){
        e.preventDefault();

        try {
            var id      = $(this).data('id-inscrito');
            var status  = $(this).val();

            var data = new FormData();
            data.append('id', id);
            data.append('status', status);

            const result = await $.ajax({
                type: 'POST',
                method: 'POST',
                url: `<?=base_url()?>restrito/mudar-status-inscritos`,
                data: data,
                dataType: 'html',
                enctype:"multipart/form-data",
                contentType: false,
                processData: false,
                beforeSend: function(){
                    // console.log('beforeSend');
                },
                success: function(res){
                    // console.log('success', res);
                }
            }).done(function( res ) {
                // console.log('done',res);

            }).fail(function(res) {
                //console.log('fail',res);

            }).always(function( res ) {
                console.log('always',res);
                var retorno = JSON.parse(res);
                var type = 'default';

                if(retorno.type == 'danger'){
                    type = 'error';
                }
                if(retorno.type == 'success'){
                    type = 'notice';
                }
                $.growl({
                    title: retorno.title,
                    message: retorno.message,
                    style: type,
                });
               
                return res;
            }); 
            
            return result;
        } catch (error) {
            Swal.showValidationMessage(`Falha na requisição: ${error}`);
            return false;
        }

        
    });


</script>

<script>
function filterTable(colIndex, query) {
    const table = document.getElementById("table_programacao");
    const tr = table.getElementsByTagName("tr");
    const filter = query.toUpperCase();

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td")[colIndex];
        if (td) {
            let txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
