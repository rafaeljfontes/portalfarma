<script>
let botaoCurso54Selecionado = null;
document.addEventListener('click', async function (event) {
    const botao = event.target.closest('.btn-curso54');
    if (botao) {
        botaoCurso54Selecionado = botao;
        const modal = document.getElementById('modalCurso54');
        const obrigatorio = botao.dataset.exigir === '0';
        modal.querySelector('[data-estado-curso54]').textContent = 'Configuração atual: ' + (obrigatorio ? 'Obrigatório' : 'Opcional');
        modal.querySelector('[data-erro-curso54]').textContent = '';
        modal.querySelectorAll('[data-opcao-curso54]').forEach(function (opcao) {
            opcao.setAttribute('aria-pressed', String(opcao.dataset.opcaoCurso54 === (obrigatorio ? '1' : '0')));
        });
        bootstrap.Modal.getOrCreateInstance(modal).show();
        return;
    }
    const opcao = event.target.closest('[data-opcao-curso54]');
    if (!opcao || opcao.disabled || !botaoCurso54Selecionado) return;
    const modal = document.getElementById('modalCurso54');
    const botoes = modal.querySelectorAll('button');
    botoes.forEach(function (item) { item.disabled = true; });
    modal.querySelector('[data-erro-curso54]').textContent = '';
    try {
        const resposta = await fetch(botaoCurso54Selecionado.dataset.url, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({exigir: opcao.dataset.opcaoCurso54})
        });
        const dados = await resposta.json();
        if (!resposta.ok) throw new Error(dados.message || 'Não foi possível salvar a opção.');
        window.location.reload();
    } catch (erro) {
        modal.querySelector('[data-erro-curso54]').textContent = erro.message || 'Não foi possível salvar a opção.';
        botoes.forEach(function (item) { item.disabled = false; });
    }
});
</script>
<!-- Bootstrap CSS -->
<div class="modal fade" id="modalCurso54" tabindex="-1" aria-labelledby="modalCurso54Titulo" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCurso54Titulo">Requisito para inscrição</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>O Curso 54 <strong>“Uso Racional de Medicamentos - Online”</strong> será:</p>
                <p><strong>Obrigatório:</strong> somente quem estiver inscrito no curso 54 do Moodle poderá se inscrever neste evento URM.</p>
                <p><strong>Opcional:</strong> a inscrição neste evento URM será permitida mesmo sem vínculo com o curso 54.</p>
                <p class="text-muted mb-0" data-estado-curso54></p>
                <div class="text-danger mt-2" role="alert" data-erro-curso54></div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" data-opcao-curso54="1">Obrigatório</button>
                <button type="button" class="btn btn-primary" data-opcao-curso54="0">Opcional</button>
            </div>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<!-- CSS GERAL -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">
<style>
	.tipo-evento-online {
		display: inline-block;
		padding: 10px 20px;
		text-decoration: none; /* Remove sublinhado do link */
		border-radius: 25px; /* Bordas arredondadas (ajuste conforme necessário) */
		font-family: Arial, sans-serif;
		transition: background-color 0.3s;
		background-color: #ffffff;
		border: 1px solid #0EA5B7;
		color: #0EA5B7;
		box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05), inset 0 0 0 1px rgba(0, 0, 0, 0.05);
	}
	
	.tipo-evento-presencial {
		display: inline-block;
		padding: 10px 20px;
		text-decoration: none; /* Remove sublinhado do link */
		border-radius: 25px; /* Bordas arredondadas (ajuste conforme necessário) */
		font-family: Arial, sans-serif;
		transition: background-color 0.3s;
		background-color: #ffffff;
		border: 1px solid #F43F3F;
		color: #F43F3F;
		box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05), inset 0 0 0 1px rgba(0, 0, 0, 0.05);
	}
	
	
	
	.button-edit {
		display: inline-block;
		padding: 10px 20px;
		background-color: #007bff; /* Cor de fundo */
		color: white; /* Cor do texto */
		text-decoration: none; /* Remove sublinhado do link */
		border-radius: 25px; /* Bordas arredondadas (ajuste conforme necessário) */
		font-family: Arial, sans-serif;
		transition: background-color 0.3s;
	}

	.botao-arredondado:hover {
		background-color: #7cabde; /* Cor ao passar o mouse */
		color: #0056b3; /* Cor ao passar o mouse */
	}
	
	.lista-palestrantes {
		padding-left: 20px;
		margin: 0;
	}

	.lista-palestrantes li {
		list-style: disc;
		font-size: 14px;
		line-height: 1.6;
	}
	
	.filtro-container {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 10px;
		padding: 15px 20px;
		background: linear-gradient(135deg, #e7f1ff, #f8fbff);
		border-radius: 12px;
		box-shadow: 0 8px 20px rgba(13, 110, 253, 0.12);
		margin-bottom: 25px;
	}

	.filtro-titulo {
		font-weight: 600;
		color: #0d6efd;
		margin-right: 10px;
	}

.btn-filtro {
		padding: 8px 18px;
		border-radius: 20px;
		border: 1px solid #0d6efd;
		background: #ffffff;
		color: #0d6efd;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.25s ease;
	}

	.btn-filtro:hover {
		background: #0d6efd;
		color: #ffffff;
		box-shadow: 0 6px 15px rgba(13, 110, 253, 0.35);
		transform: translateY(-1px);
	}

	.btn-filtro.active {
		background: #0d6efd;
		color: #ffffff;
		box-shadow: 0 6px 15px rgba(13, 110, 253, 0.45);
	}

</style>
<style>
    .ch-badge {
        background: #f0f7ff;
        color: #054589;
        border: 1px solid #d0e3ff;
        padding: 3px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 11px;
    }
    .palestrante-item {
        font-size: 11px;
        color: #444;
        background: #f8f9fa;
        margin-bottom: 2px;
        padding: 2px 8px;
        border-radius: 4px;
        display: block;
        text-align: left;
    }
    .status-badge-supreme {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }
</style>
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
			<h4 class="mb-0 text-primary">Gerenciar Eventos - Uso Racional de Medicamentos</h4>
		</div>
		
		<a href="<?=base_url()?>restrito/cursos/cadastrar/urm" class="btn btn-primary btn-cadastrar">
			<i class="fas fa-plus"></i> Cadastrar Evento
		</a>
	</div>
	
	<div class="kpi-container">
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-primary text-white"><i class="bi bi-collection"></i></div>
			<div class="kpi-info">
				<h6>Total Eventos </h6>
				<span><?=$totalLinhas;?></span>
			</div>
		</div>
	</div>
	<?php
	if ($totalLinhas == 0){
		echo "nenhum retorno";
	} else {

	?>
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
		<div class="table-responsive">
			<table class="table table-hover align-middle mb-0" id="table_programacao">
				<thead class="thead-azul">
					<tr>
						<th class="ps-4">ID MOODLE</th>
						<th>CURSO / LOCAL</th>
						<th>CRONOGRAMA (INÍCIO/FIM)</th>
						<th class="text-center">C.H.</th>
						<th class="text-center pe-4">AÇÕES</th>
					</tr>
				</thead>
				<tbody class="bg-white">
					<?php
					foreach ($tabelaCurso as $campo) {
						if ($campo->courseid == 3) continue;

						// Configuração de Status
						$is_ativo = ($campo->status == 1);
						$status_cfg = [
							0 => ['label' => 'Desativado', 'class' => 'bg-danger-subtle text-danger', 'icon' => 'bi-dash-circle-fill', 'bar' => '#c77575'],
							1 => ['label' => 'Ativo', 'class' => 'bg-success-subtle text-success', 'icon' => 'bi-check-circle-fill', 'bar' => '#93bf82']
						];
						$st = $status_cfg[$campo->status] ?? $status_cfg[0];
						$campo_horas = $campo->carga_horaria / 60;
						$status_label = $st ? 'Ativo' : 'Desativado';
						$presencaLiberada = isset($campo->presenca_liberada) && (int) $campo->presenca_liberada === 1;
						
					?>
					<tr style="font-size: 13px;" class="position-relative">
						<td class="ps-4">
							<div class="status-indicator" style="background-color: <?= $st['bar'] ?>; width: 4px; height: 100%; position: absolute; left: 0; top: 0;"></div>
							<span class="fw-bold text-secondary">#<?= $campo->courseid; ?></span>
						</td>

						<td>
							<div class="main-text mb-0"><?= $campo->titulo; ?></div>
							<div class="sub-text text-primary" style="font-size: 11px;">
								<i class="bi bi-geo-alt-fill me-1"></i><?= $campo->local; ?>
							</div>
						</td>

						<td>
							<div class="d-flex align-items-center gap-2 mb-1">
								<span class="badge bg-light text-dark border fw-normal" style="font-size: 11px;">
									<i class="bi bi-calendar-event me-1 text-primary"></i><?= date('d/m/Y', strtotime($campo->data_inicio)); ?>
								</span>
								<span class="text-muted" style="font-size: 11px;">
									&nbsp;&nbsp;<i class="bi bi-clock me-1"></i>
									<?= date('H:i', strtotime($campo->data_inicio)); ?>
								</span>
							</div>
							<div class="sub-text" style="font-size: 10px;">
								<i class="bi bi-arrow-right me-1"></i>Término: <?= ($campo->data_fim == '') ? '---' : date('d/m/Y', strtotime($campo->data_fim)); ?>
							</div>
						</td>

						<td class="text-center">
							<span class="ch-badge"><?= $campo_horas; ?>h</span>
						</td>

						<td class="text-center pe-4">
							<div class="btn-group shadow-sm rounded-3 overflow-hidden">
								<a href="<?=base_url()?>restrito/cursos/editar/<?=$campo->id?>" target="_blank" class="btn btn-sm btn-light border-end px-3" title="Editar">
									<i class="bi bi-pencil-square text-primary"></i>
								</a>
								<?php $exigeCurso54 = !isset($campo->exigir_curso54) || (int) $campo->exigir_curso54 === 1; ?>
								<button type="button" class="btn btn-sm <?=$exigeCurso54 ? 'btn-warning' : 'btn-light'?> btn-curso54"
									data-url="<?=site_url('restrito/urm/alterar_exigencia_curso54/' . (int) $campo->id)?>"
									data-exigir="<?=$exigeCurso54 ? '0' : '1'?>"
									title="<?=$exigeCurso54 ? 'Liberar inscrições sem vínculo com o curso 54' : 'Exigir vínculo com o curso 54 para inscrição'?>">
									<i class="bi <?=$exigeCurso54 ? 'bi-shield-lock-fill' : 'bi-shield-check'?>" aria-hidden="true"></i>
									Curso 54: <?=$exigeCurso54 ? 'obrigatório' : 'opcional'?>
								</button>
								<?php $temLocal = !empty($locaisCadastrados['curso:'.$campo->courseid]); ?>
								<a href="<?=site_url($temLocal ? 'restrito/urm/local/editar/' . rawurlencode((string) $campo->courseid) : 'restrito/urm/local/cadastrar?courseid=' . rawurlencode((string) $campo->courseid))?>" class="btn btn-sm btn-light border-end px-3" title="<?=$temLocal ? 'Editar local da URM' : 'Cadastrar local da URM'?>" aria-label="<?=$temLocal ? 'Editar local da URM' : 'Cadastrar local da URM'?>">
									<i class="bi bi-geo-alt-fill <?=!empty($locaisCadastrados['curso:'.$campo->courseid]) ? 'text-primary' : 'text-secondary'?>" aria-hidden="true"></i>
								</a>
								<button 
									type="button"
									class="btn btn-sm btn-light px-3" 
									title="Programação Completa" 
									data-bs-toggle="popover" 
									data-bs-trigger="focus" 
									tabindex="0"
									data-bs-content="<?= htmlspecialchars($campo->programacao); ?>">
									<i class="bi bi-card-text"></i>
								</button>
								<button
									type="button"
									class="btn btn-sm px-3 btn-liberar-presenca <?=$presencaLiberada ? 'btn-success' : 'btn-light'?>"
									data-courseid="<?=htmlspecialchars($campo->courseid, ENT_QUOTES, 'UTF-8')?>"
									data-liberada="<?=$presencaLiberada ? '1' : '0'?>"
									title="<?=$presencaLiberada ? 'Bloquear marcação de presença deste evento URM' : 'Liberar marcação de presença deste evento URM'?>">
									<i class="bi <?=$presencaLiberada ? 'bi-unlock-fill' : 'bi-lock-fill'?>"></i>
								</button>
								<a href="<?=site_url('restrito/urm/inscritos/' . $campo->id)?>" class="btn btn-sm btn-light px-3" title="Inscritos e presença" aria-label="Inscritos e presença">
									<span class="me-1"><?=(int) ($totaisInscritos['curso:'.$campo->courseid] ?? 0)?></span><i class="bi bi-person-fill" aria-hidden="true"></i>
								</a>
								<button 
									type="button" 
									class="btn btn-sm btn-status" 
									data-id="<?= $campo->id ?>" 
									data-status="<?= $campo->status ?>">
									<?php if($is_ativo): ?>
										<i class="bi bi-toggle-on text-success"></i> Ativo
									<?php else: ?>
										<i class="bi bi-toggle-off text-danger"></i> Inativo
									<?php endif; ?>
								</button>

							</div>
							<div class="mt-1" style="font-size: 9px; color: #bbb;">
								Cad: <?= date('d/m/Y', strtotime($campo->data_cadastro)); ?>
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

<style>
    .popover {
        max-width: 350px; /* Limita a largura do balão da programação */
    }
</style>
<script>
	$(document).on('click', '.btn-status', function() {
    let btn = $(this);
    let idSelecionado = btn.data('id');
    let statusAtual = btn.data('status');

    // Confirmação antes de alterar
    Swal.fire({
        title: 'Confirmação',
        text: statusAtual == 1 
              ? "Deseja desativar este curso?" 
              : "Deseja ativar este curso?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?=base_url()?>restrito/cursos/alterar_status",
                type: "POST",
                dataType: "json",
                data: {
                    id: idSelecionado,
                    status: statusAtual
                },
                success: function(data) {
                    if (data.success) {
                        // Atualiza dataset e botão
                        btn.data('status', data.status);
                        if (data.status == 1) {
                            btn.html('<i class="bi bi-toggle-on text-success"></i> Ativo');
                        } else {
                            btn.html('<i class="bi bi-toggle-off text-danger"></i> Inativo');
                        }

                        Swal.fire({
                            icon: data.status == 1 ? 'success' : 'info',
                            title: 'Status atualizado!',
                            text: data.status == 1 
                                  ? 'O curso foi ativado com sucesso.' 
                                  : 'O curso foi desativado com sucesso.',
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Não foi possível atualizar o status.',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Falha na requisição',
                        text: 'Verifique sua conexão e tente novamente.',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }
    });
});


</script>
<script>
	$(document).on('click', '.btn-liberar-presenca', function() {
		const botao = $(this);
		const estaLiberada = String(botao.data('liberada')) === '1';
		const novoEstado = estaLiberada ? 0 : 1;

		Swal.fire({
			title: estaLiberada ? 'Bloquear marcação de presença?' : 'Liberar marcação de presença?',
			text: estaLiberada
				? 'O botão de confirmar presença deixará de aparecer para este evento URM.'
				: 'Os inscritos poderão confirmar a presença na página pública de URM.',
			icon: 'question',
			showCancelButton: true,
			confirmButtonText: estaLiberada ? 'Sim, bloquear' : 'Sim, liberar',
			cancelButtonText: 'Cancelar',
			confirmButtonColor: estaLiberada ? '#dc3545' : '#198754'
		}).then(function(result) {
			if (!result.isConfirmed) {
				return;
			}

			$.ajax({
				url: '<?=base_url("restrito/urm/alterar_liberacao_presenca")?>',
				type: 'POST',
				dataType: 'json',
				data: {
					courseid: botao.data('courseid'),
					liberar: novoEstado
				},
				success: function(resposta) {
					Swal.fire({
						title: 'Tudo certo!',
						text: resposta.message,
						icon: 'success',
						timer: 1800,
						showConfirmButton: false
					}).then(function() {
						window.location.reload();
					});
				},
				error: function(xhr) {
					const resposta = xhr.responseJSON || {};
					Swal.fire('Erro!', resposta.message || 'Não foi possível alterar a liberação de presença.', 'error');
				}
			});
		});
	});
</script>
<script>
	document.addEventListener("DOMContentLoaded", function(){

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')

    popoverTriggerList.forEach(function (el) {
        new bootstrap.Popover(el)
    });

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
