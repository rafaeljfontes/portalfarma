<!-- CSS  -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">

<style>
	.contato-palestrante { display: flex; align-items: center; justify-content: center; gap: 8px; }
	.contato-icone {
		width: 38px;
		height: 38px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border: 1px solid #b9d2ea;
		border-radius: 50%;
		background: #f4f9fd;
		color: #0468aa;
		font-size: 17px;
		transition: all .2s ease;
	}
	.contato-icone:not(.is-disabled):hover { background: #0468aa; color: #fff; transform: translateY(-1px); }
	.contato-icone.is-disabled { border-color: #e1e5e9; background: #f5f5f5; color: #c2c7cc; cursor: not-allowed; opacity: .65; }
</style>

<div class="container">
    
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="bi bi-people-fill text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Palestrantes</h4>
		</div>
		
		<div class="d-flex gap-2">
			<button type="button" id="btn-exportar-palestrantes" class="btn btn-success btn-cadastrar d-flex align-items-center gap-2" data-bs-toggle="tooltip" title="Exportar todas as informações dos palestrantes">
				<i class="bi bi-download"></i> Exportar
			</button>
			<a href="<?=base_url()?>restrito/palestrantes/curso" class="btn btn-primary btn-cadastrar d-flex align-items-center gap-2" data-bs-toggle="tooltip" title="Vincular palestrantes aos cursos">
				<i class="bi bi-link-45deg"></i> Vincular Palestrantes ao Curso
			</a>
			<a href="<?=base_url()?>restrito/palestrantes/formulario" class="btn btn-primary btn-cadastrar" data-bs-toggle="tooltip" title="Cadastrar um novo palestrante">
				<i class="bi bi-plus-lg"></i> Novo Palestrante
			</a>
		</div>
	</div>

	<div class="d-flex justify-content-end mb-3">
		<div class="btn-group" role="group" aria-label="Filtrar palestrantes por status">
			<a href="<?=base_url()?>restrito/palestrantes?status=1"
			   class="btn <?=$statusLista === 1 ? 'btn-success' : 'btn-outline-success'?>"
			   data-bs-toggle="tooltip" title="Mostrar somente os palestrantes ativos">
				<i class="bi bi-person-check-fill me-1"></i> Ativos (<?=$totaisStatus[1]?>)
			</a>
			<a href="<?=base_url()?>restrito/palestrantes?status=0"
			   class="btn <?=$statusLista === 0 ? 'btn-secondary' : 'btn-outline-secondary'?>"
			   data-bs-toggle="tooltip" title="Mostrar somente os palestrantes inativos">
				<i class="bi bi-person-x-fill me-1"></i> Inativos (<?=$totaisStatus[0]?>)
			</a>
		</div>
	</div>
	
	
	
	<?php
		$totalLinhas = count($tabelaPalestrantes);
	?>

	<div class="kpi-container" hidden>
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-primary text-white"><i class="bi bi-collection"></i></div>
			<div class="kpi-info">
				<h6>Palestrantes <?=$statusLista === 1 ? 'Ativos' : 'Inativos'?></h6>
				<span><?=$totalLinhas;?></span>
			</div>
		</div>
	</div>
   
	<!-- TABELA DE PALESTRANTES -->
    <div class="row">
		<div class="col">
			<div class="card shadow-sm border-0">
				<div class="table-responsive">
					<table class="table table-hover align-middle mb-0" id="tabelaPalestrantes">
						<thead>
							<tr style="background-color: #0468aa;"> <th class="ps-4 py-3 align-top" style="width: 300px;">
									PALESTRANTE
									<input type="text" 
										   class="filter-input" 
										   placeholder="Filtrar por nome..." 
										   onkeyup="filterTable(0, this.value)">
								</th>
								<th class="py-3 text-white align-top">
									SOBRE / CURRÍCULO
									<div style="height: 26px; margin-top: 5px;"></div> 
								</th>
								<th class="py-3 text-white text-center align-top" style="width: 150px;">
									E-MAIL / LATTES
									<div style="height: 26px; margin-top: 5px;"></div>
								</th>
								<th class="text-end pe-4 py-3 text-white align-top">
									AÇÕES
									<div style="height: 26px; margin-top: 5px;"></div>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($tabelaPalestrantes) && !empty($tabelaPalestrantes)): ?>
								<?php 
									foreach ($tabelaPalestrantes as $palestrante): ?>
								<tr>
									<td class="ps-4">
										<div class="d-flex align-items-center">
											<img src="<?= $palestrante->foto ?: base_url('assets/img/default-user.png') ?>" 
												 class="img-palestrante me-3" 
												 alt="<?= $palestrante->nome ?>">
											<div>
												<div class="fw-bold text-dark"><?= $palestrante->nome ?></div>
												<small class="text-muted">ID: #<?= $palestrante->id_palestrante ?></small>
											</div>
										</div>
									</td>
									<td style="vertical-align: middle;">
										<div class="d-flex justify-content-between align-items-start">
											<div style="flex: 1;">
												<div class="curriculo-clamp text-muted mb-2" title="<?= $palestrante->curriculo ?>">
													<?= $palestrante->curriculo ?? 'Nenhum currículo informado.' ?>
												</div>

												<?php if(!empty($palestrante->cursos)): ?>
													<?php $listaCursos = explode(',', $palestrante->cursos); ?>
													<div class="d-flex flex-wrap gap-1">
														<?php 
														foreach($listaCursos as $curso_nome): 
															?>
															<span class="box-curso"><?= trim($curso_nome); ?></span>
														<?php endforeach; ?>
													</div>
												<?php else: ?>
													<div class="box-curso vazio">Sem curso vinculado</div>
												<?php endif; ?>
											</div>

											<!--<button type="button" 
													class="btn btn-sm btn-outline-danger ms-2 btn-remover-vinculo" 
													data-id-palestrante="<?= $palestrante->id_palestrante ?>" 
													data-courseid="12" 
													title="Remover palestrante deste curso">
												<i class="bi bi-trash"></i>
											</button>-->
										</div>
									</td>
									<td class="text-center">
										<?php
											$emailPalestrante = trim((string) ($palestrante->email ?? ''));
											$lattesPalestrante = trim((string) ($palestrante->link ?? ''));
										?>
										<div class="contato-palestrante">
											<button type="button"
								class="contato-icone <?=$emailPalestrante !== '' ? 'btn-contato' : 'is-disabled'?>"
												data-tipo="E-mail"
												data-valor="<?=htmlspecialchars($emailPalestrante, ENT_QUOTES, 'UTF-8')?>"
								title="<?=$emailPalestrante !== '' ? 'Visualizar e-mail' : 'E-mail não informado'?>"
								data-bs-toggle="tooltip"
								aria-label="<?=$emailPalestrante !== '' ? 'Visualizar e-mail' : 'E-mail não informado'?>"
								aria-disabled="<?=$emailPalestrante === '' ? 'true' : 'false'?>">
												<i class="bi bi-envelope-fill"></i>
											</button>
											<button type="button"
								class="contato-icone <?=$lattesPalestrante !== '' ? 'btn-contato' : 'is-disabled'?>"
												data-tipo="Lattes"
												data-valor="<?=htmlspecialchars($lattesPalestrante, ENT_QUOTES, 'UTF-8')?>"
								title="<?=$lattesPalestrante !== '' ? 'Visualizar Lattes' : 'Lattes não informado'?>"
								data-bs-toggle="tooltip"
								aria-label="<?=$lattesPalestrante !== '' ? 'Visualizar Lattes' : 'Lattes não informado'?>"
								aria-disabled="<?=$lattesPalestrante === '' ? 'true' : 'false'?>">
												<i class="bi bi-journal-text"></i>
											</button>
										</div>
									</td>
									<td class="text-end pe-4">
										<div class="btn-group">
											<button type="button" 
													class="btn btn-outline-success btn-sm btn-action btn-gerar-certificados" 
											data-id="<?= $palestrante->id_palestrante ?>"
											data-bs-toggle="tooltip" title="Gerar os certificados do palestrante">
												<i class="fa fa-file-pdf-o"></i> <span>Certificados</span>
											</button>
									<a href="<?=base_url()?>restrito/palestrantes/formulario/<?=$palestrante->id_palestrante?>"
									   class="btn btn-outline-primary btn-sm btn-action"
									   data-bs-toggle="tooltip" title="Editar os dados do palestrante">
										<i class="fa fa-pencil"></i> <span>Editar</span>
									</a>
									<?php if ($statusLista === 1): ?>
									<button type="button"
											class="btn btn-outline-danger btn-sm btn-action btn-excluir"
											data-id="<?=$palestrante->id_palestrante?>"
											data-bs-toggle="tooltip" title="Inativar este palestrante">
										<i class="fa fa-trash"></i>
									</button>
									<?php else: ?>
									<button type="button"
											class="btn btn-outline-success btn-sm btn-action btn-reativar"
											data-id="<?=$palestrante->id_palestrante?>"
											data-bs-toggle="tooltip" title="Reativar este palestrante">
										<i class="bi bi-person-check-fill"></i>
									</button>
									<?php endif; ?>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="4" class="text-center py-5 text-muted">
										Nenhum palestrante encontrado.
									</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- FIM TABELA DE PALESTRANTES -->
    
</div>



<script>
	document.addEventListener('DOMContentLoaded', function() {
		document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(elemento) {
			bootstrap.Tooltip.getOrCreateInstance(elemento);
		});
	});

	$(document).on('click', '#btn-exportar-palestrantes', function() {
		Swal.fire({
			title: 'Exportar palestrantes',
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
				window.location.href = '<?=base_url("restrito/palestrantes/exportar_excel")?>';
			} else if (resultado.isDenied) {
				window.location.href = '<?=base_url("restrito/palestrantes/exportar_pdf")?>';
			}
		});
	});

	$(document).on('click', '.btn-contato', function() {
		const tipo = String($(this).data('tipo') || 'Informação');
		const valor = String($(this).attr('data-valor') || '');
		const ehEmail = tipo === 'E-mail';
		let destino = valor;

		if (!ehEmail && destino && !/^https?:\/\//i.test(destino)) {
			destino = 'https://' + destino;
		}

		Swal.fire({
			title: tipo + ' do palestrante',
			text: valor,
			icon: 'info',
			showCancelButton: true,
			confirmButtonText: ehEmail ? 'Enviar e-mail' : 'Abrir Lattes',
			cancelButtonText: 'Fechar',
			confirmButtonColor: '#0468aa'
		}).then(function(resultado) {
			if (resultado.isConfirmed) {
				if (ehEmail) {
					const gmailCompose = 'https://mail.google.com/mail/?view=cm&fs=1&to=' + encodeURIComponent(valor);
					window.open(gmailCompose, '_blank', 'noopener');
				} else {
					window.open(destino, '_blank', 'noopener');
				}
			}
		});
	});

	$(document).on('click', '.btn-reativar', function() {
		const id = $(this).data('id');

		Swal.fire({
			title: 'Reativar palestrante?',
			text: 'O palestrante voltará a aparecer na lista de ativos.',
			icon: 'question',
			showCancelButton: true,
			confirmButtonText: 'Sim, reativar',
			cancelButtonText: 'Cancelar',
			confirmButtonColor: '#198754'
		}).then(function(resultado) {
			if (!resultado.isConfirmed) return;

			fetch('<?=base_url("restrito/palestrantes/reativar/")?>' + id, {
				method: 'POST',
				headers: { 'X-Requested-With': 'XMLHttpRequest' }
			})
			.then(function(response) { return response.json(); })
			.then(function(data) {
				return Swal.fire({
					title: data.status === 'success' ? 'Reativado!' : 'Atenção',
					text: data.mensagem,
					icon: data.status === 'success' ? 'success' : 'error',
					confirmButtonColor: '#0468aa'
				}).then(function() {
					if (data.status === 'success') location.reload();
				});
			})
			.catch(function() {
				Swal.fire('Erro!', 'Não foi possível processar a reativação.', 'error');
			});
		});
	});

	$(document).on('click', '.btn-gerar-certificados', function(e) {
		e.preventDefault();
		
		let id_palestrante = $(this).data('id');
		
		console.log(id_palestrante);
		
		// Abre a URL diretamente em uma nova aba
		// O navegador interpretará o fluxo binário do Html2Pdf como um PDF
		window.open("<?= base_url('restrito/palestrantes/certificado_palestrantes/'); ?>" + id_palestrante, '_blank');
	});


document.addEventListener('click', function(e) {
    if (e.target && (e.target.classList.contains('btn-excluir') || e.target.closest('.btn-excluir'))) {
        const btn = e.target.closest('.btn-excluir');
        const id = btn.getAttribute('data-id');

        if (confirm('Deseja realmente excluir este palestrante?')) {
            fetch('<?= base_url("restrito/palestrantes/excluir/") ?>' + id, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.mensagem);
                    location.reload(); // Recarrega a lista
                } else {
                    alert('Erro: ' + data.mensagem);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao processar a requisição.');
            });
        }
    }
});
</script>
<script>
function filterTable(colIndex, query) {
    // Seleciona a tabela correta de palestrantes
    const table = document.getElementById("tabelaPalestrantes");
    const tr = table.getElementsByTagName("tr");
    const filter = query.toUpperCase();

    // Começa do 1 para pular o thead
    for (let i = 1; i < tr.length; i++) {
        // Busca a célula na coluna informada (colIndex)
        let td = tr[i].getElementsByTagName("td")[colIndex];
        
        if (td) {
            // Pegamos o texto apenas da div que contém o nome para o filtro ser mais preciso
            // ou o conteúdo total da célula
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
