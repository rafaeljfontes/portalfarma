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
		color: #ffffff important!;
		box-shadow: 0 6px 15px rgba(13, 110, 253, 0.45);
	}
	
	thead th {
		background-color: #0468aa;
		color: white;
	}
	
	.btn-custom-white-green {
		background-color: white !important;
		border-color: #93bf82 !important; /* Azul padrão Bootstrap 5 */
		color: #93bf82 !important;
	}
	.btn-custom-white-grenn:hover {
		background-color: #93bf82 !important;
		color: white !important;
	}
	
	.btn-custom-white-red {
		background-color: white !important;
		border-color: #c77575 !important; /* Azul padrão Bootstrap 5 */
		color: #c77575 !important;
	}
	.btn-custom-white-red:hover {
		background-color: #c77575 !important;
		color: white !important;
	}
	
	.info-hover{
		font-size:13px;
		text-decoration:none;
		color:#0d6efd;
		cursor:pointer;
	}

	.info-hover:hover{
		text-decoration:underline;
	}
	.popover{
		padding:15px !important;
	}
	
	.popover-header{
		font-weight:600;
		font-size:14px;
	}
</style>
<style>
    /* Badge de Temas Estilizado */
    .tema-badge {
        background: #f0f7ff;
        border: 1.5px solid #054589;
        color: #054589;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.2;
        display: block;
        text-align: center;
        margin-bottom: 5px;
    }

    /* Status sutil na lateral da célula de ID */
    .status-id {
        font-size: 14px;
        font-weight: 800;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Customização de botões de ação */
    .btn-supreme-success {
        background: #93bf82;
        color: white;
        border: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-supreme-success:hover {
        background: #7ca86b;
        transform: scale(1.05);
    }

    .btn-observacoes {
        border-color: #054589;
        color: #054589;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 10px;
    }

    .btn-observacoes:hover {
        background-color: #054589;
        color: #fff;
    }

    .texto-observacoes {
        white-space: pre-wrap;
        font-size: 14px;
        line-height: 1.6;
    }
</style>
<style>
    /* Estilo para o ID com cor de status */
    .status-id-badge {
        padding: 5px 10px;
        border-radius: 6px;
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Badge de Tema no estilo Pill do Supreme */
    .tema-pill {
        background: #eef6ff;
        color: #054589;
        border: 1px solid #d0e3ff;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 5px;
    }

    /* Ajuste da Tabela */
    .table-supreme thead th {
        background-color: #054589 !important;
        color: white !important;
        padding: 15px 10px !important;
        font-size: 11px !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: none;
    }

	.universitario-table {
		min-width: 1480px;
		table-layout: fixed;
	}

	.universitario-table tbody td {
		padding: 18px 12px;
		border-bottom: 1px solid #e9eef5;
		vertical-align: middle;
		color: #344054;
	}

	.universitario-table thead th {
		position: sticky;
		top: 0;
		z-index: 2;
		vertical-align: middle;
	}

	.universitario-table tbody tr {
		transition: background-color .2s ease, box-shadow .2s ease;
	}

	.universitario-table tbody tr:hover {
		background-color: #f8fbff;
		box-shadow: inset 4px 0 0 #0d6efd;
	}

	.universitario-table .info-primary {
		font-size: 13px;
		font-weight: 700;
		color: #172b4d;
		line-height: 1.35;
		overflow-wrap: anywhere;
	}

	.universitario-table .info-line {
		display: flex;
		align-items: flex-start;
		gap: 7px;
		margin-top: 6px;
		font-size: 11px;
		line-height: 1.35;
		color: #667085;
		overflow-wrap: anywhere;
	}

	.universitario-table .info-line i {
		width: 14px;
		flex: 0 0 14px;
		margin-top: 1px;
		color: #0d6efd;
		text-align: center;
	}

	.universitario-table .date-panel {
		display: inline-flex;
		flex-direction: column;
		gap: 5px;
		min-width: 118px;
		padding: 8px 10px;
		background: #f8fafc;
		border: 1px solid #e2e8f0;
		border-radius: 10px;
	}

	.universitario-table .evento-acesso-badge {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 7px;
		min-width: 118px;
		margin: 0 0 8px 4px;
		padding: 8px 13px;
		border-radius: 10px;
		background: #125470;
		color: #ffffff;
		font-size: 12px;
		font-weight: 700;
		line-height: 1;
		box-shadow: 0 4px 10px rgba(18, 84, 112, .22);
	}

	.universitario-table .evento-acesso-badge i {
		font-size: 13px;
	}

	.universitario-table .actions-stack {
		display: flex;
		flex-direction: column;
		align-items: stretch;
		gap: 7px;
		max-width: 145px;
		margin: 0 auto;
	}

	.universitario-table .actions-stack .btn {
		white-space: nowrap;
	}

	.table-responsive {
		scrollbar-color: #aabbd0 #eef3f8;
		scrollbar-width: thin;
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
	$qtdPendentes = $totaisStatus[0] ?? 0;
	$qtdAtvos = $totaisStatus[1] ?? 0;
	$qtdInatvos = $totaisStatus[2] ?? 0;
	
?>
<div class="container-fluid px-3 px-xl-4 py-4">
    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="bg-primary-subtle p-3 rounded-3 me-3">
                <i class="fas fa-file-signature text-primary fs-3"></i>
            </div>
            <div>
                <h4 class="mb-0 fw-bold text-dark">Gerenciar Eventos</h4>
                <p class="text-muted small mb-0">Capacifar Universitário - Análise e Aprovação</p>
            </div>
        </div>
    </div>

	<div class="d-flex justify-content-end mb-3">
		<div class="btn-group" role="group" aria-label="Filtrar eventos por status">
			<a href="<?=base_url('restrito/universitario?status=0')?>" class="btn <?=$statusLista === 0 ? 'btn-warning' : 'btn-outline-warning'?>" data-bs-toggle="tooltip" title="Mostrar eventos pendentes de análise">
				<i class="bi bi-hourglass-split me-1"></i> Pendentes (<?=$qtdPendentes?>)
			</a>
			<a href="<?=base_url('restrito/universitario?status=1')?>" class="btn <?=$statusLista === 1 ? 'btn-success' : 'btn-outline-success'?>" data-bs-toggle="tooltip" title="Mostrar eventos aceitos">
				<i class="bi bi-person-check-fill me-1"></i> Aceitos (<?=$qtdAtvos?>)
			</a>
			<a href="<?=base_url('restrito/universitario?status=2')?>" class="btn <?=$statusLista === 2 ? 'btn-danger' : 'btn-outline-danger'?>" data-bs-toggle="tooltip" title="Mostrar eventos recusados">
				<i class="bi bi-person-x-fill me-1"></i> Recusados (<?=$qtdInatvos?>)
			</a>
		</div>
	</div>

    <div class="kpi-container mb-4" hidden>
        <div class="kpi-card shadow-sm border-0 bg-white p-3 rounded-4">
            <div class="kpi-icon bg-primary text-white"><i class="bi bi-search"></i></div>
            <div class="kpi-info">
                <h6>Total na listagem</h6>
                <span><?=$totalLinhas;?></span>
            </div>
        </div>
        <div class="kpi-card shadow-sm border-0 bg-white p-3 rounded-4">
            <div class="kpi-icon text-white" style="background-color: #93bf82;"><i class="bi bi-check-circle"></i></div>
            <div class="kpi-info">
				<h6>Aceitos</h6>
                <span><?=$qtdAtvos;?></span>
            </div>
        </div>
        <div class="kpi-card shadow-sm border-0 bg-white p-3 rounded-4">
            <div class="kpi-icon text-white" style="background-color: #c77575;"><i class="bi bi-x-circle"></i></div>
            <div class="kpi-info">
				<h6>Recusados</h6>
                <span><?=$qtdInatvos;?></span>
            </div>
        </div>
    </div>

    <?php if ($totalLinhas == 0): ?>
        <div class="alert alert-light border text-center py-5 rounded-4 shadow-sm">
            <i class="bi bi-inbox fs-1 d-block mb-3 text-muted"></i>
            <h5 class="text-muted">Nenhum evento retornado no momento.</h5>
        </div>
    <?php else: ?>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
		<div class="table-responsive">
			<table class="table table-hover align-middle table-supreme universitario-table mb-0" id="table_programacao">
				<colgroup>
					<col style="width: 70px;">
					<col style="width: 135px;">
					<col style="width: 245px;">
					<col style="width: 230px;">
					<col style="width: 235px;">
					<col style="width: 145px;">
					<col style="width: 245px;">
					<col style="width: 175px;">
				</colgroup>
				<thead>
					<tr>
						<th class="ps-4">ID</th>
						<th>DATA DE CADASTRO</th>
						<th>INSTITUIÇÃO / CIDADE</th>
						<th>RESPONSÁVEL</th>
						<th>EVENTO / DATA</th>
						<th>PÚBLICO / PERÍODO</th>
						<th style="width: 220px;">TEMA E OBSERVAÇÕES</th>
						<th class="text-center pe-4">AÇÕES</th>
					</tr>
				</thead>
				<tbody class="bg-white">
					<?php foreach ($tabelaCurso as $campo): 
						// Configuração de Status dinâmico
						$status_map = [
							0 => ['bg' => '#f7f6a3', 'label' => 'Pendente'],
							1 => ['bg' => '#93bf82', 'label' => 'Ativo'],
							2 => ['bg' => '#c77575', 'label' => 'Inativo']
						];
						$current_status = $status_map[$campo->status] ?? $status_map[0];

						$temas_map = [
							1 => "CRF/MG na Prática: Diretrizes Atuais",
							2 => "Uso Racional de Medicamentos",
							3 => "Atuação em Drogaria: Além da Dispensação",
							4 => "Novas áreas e o Papel do CRF/MG",
							5 => "Outros"
						];
						$tema_label = $temas_map[$campo->temas] ?? "Outros";
						$observacoes = trim($campo->observacoes ?? '');
						$registroAcao = json_decode((string) ($campo->recusa ?? ''), true);
						$motivoAcao = is_array($registroAcao) ? ($registroAcao['motivo'] ?? '') : (string) ($campo->recusa ?? '');
						$usuarioAcao = is_array($registroAcao) ? ($registroAcao['usuario'] ?? 'Usuário não identificado') : 'Usuário não registrado';
						$dataAcao = is_array($registroAcao) ? ($registroAcao['data'] ?? '') : '';
						if ($dataAcao !== '' && strtotime($dataAcao)) {
							$dataAcao = date('d/m/Y H:i', strtotime($dataAcao));
						}
					?>
					<tr style="font-size: 13px;">
						<td class="ps-4">
							<span class="status-id-badge" style="background-color: <?= $current_status['bg'] ?>;">
								<?= $campo->id ?>
							</span>
						</td>

						<td>
							<?php if (!empty($campo->data_cadastro) && strtotime($campo->data_cadastro)): ?>
								<div class="date-panel">
									<span class="d-flex align-items-center" style="gap: 7px;"><i class="bi bi-calendar-check text-primary"></i><strong><?=date('d/m/Y', strtotime($campo->data_cadastro))?></strong></span>
									<span class="d-flex align-items-center text-muted" style="gap: 7px;"><i class="bi bi-clock"></i><?=date('H:i', strtotime($campo->data_cadastro))?></span>
								</div>
							<?php else: ?>
								<span class="text-muted">Não informado</span>
							<?php endif; ?>
						</td>
						
						<td>
							<div class="info-primary"><?=htmlspecialchars($campo->instituicao, ENT_QUOTES, 'UTF-8')?></div>
							<div class="info-line"><i class="bi bi-geo-alt-fill"></i><span><?=htmlspecialchars($campo->cidade, ENT_QUOTES, 'UTF-8')?></span></div>
							<div class="info-line"><i class="bi bi-signpost-2"></i><span><?=htmlspecialchars($campo->endereco, ENT_QUOTES, 'UTF-8')?></span></div>
						</td>

						<td>
							<div class="info-primary"><?=htmlspecialchars($campo->responsavel, ENT_QUOTES, 'UTF-8')?></div>
							<div class="info-line"><i class="bi bi-envelope-at"></i><span><?=htmlspecialchars($campo->email, ENT_QUOTES, 'UTF-8')?></span></div>
							<div class="info-line"><i class="bi bi-telephone"></i><span><?=htmlspecialchars($campo->telefone, ENT_QUOTES, 'UTF-8')?></span></div>
						</td>

						<td>
							<div class="d-flex align-items-start gap-2 mb-2">
								<span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary flex-shrink-0"
									style="width: 30px; height: 30px;">
									<i class="bi bi-calendar-event"></i>
								</span>
								<div class="fw-bold text-dark lh-sm pt-1">
									<?=htmlspecialchars($campo->evento, ENT_QUOTES, 'UTF-8')?>
								</div>
							</div>
							<?php $eventoPago = (int) ($campo->acesso ?? 0) === 1; ?>
							<div class="evento-acesso-badge" title="Acesso <?= $eventoPago ? 'pago' : 'gratuito' ?>">
								<i class="bi <?= $eventoPago ? 'bi-credit-card-fill' : 'bi-gift-fill' ?>" aria-hidden="true"></i>
								<span><?= $eventoPago ? 'Pago' : 'Gratuito' ?></span>
							</div>
							<div class="date-panel ms-1">
								<span class="text-primary fw-semibold text-nowrap d-flex align-items-center" style="gap: 7px;">
									<i class="bi bi-calendar3"></i>
									<span><?=date('d/m/Y', strtotime($campo->data))?></span>
								</span>
								<span class="text-muted text-nowrap d-flex align-items-center" style="gap: 7px;">
									<i class="bi bi-clock"></i>
									<span><?=date('H:i', strtotime($campo->data))?></span>
								</span>
							</div>
						</td>

						<td>
							<div class="info-line mt-0"><i class="bi bi-people-fill"></i><span><strong class="text-dark"><?=htmlspecialchars($campo->publico, ENT_QUOTES, 'UTF-8')?></strong> participantes</span></div>
							<div class="info-line"><i class="bi bi-clock"></i><span><?=htmlspecialchars($campo->periodo, ENT_QUOTES, 'UTF-8')?></span></div>
						</td>

						<td>
							<div class="tema-pill"><?=htmlspecialchars($tema_label, ENT_QUOTES, 'UTF-8')?></div>
							<?php if(!empty($campo->outros)): ?>
								<div class="p-2 rounded bg-light border-start border-primary border-3" style="font-size: 11px;">
									<strong>Curso:</strong> <?=htmlspecialchars($campo->outros, ENT_QUOTES, 'UTF-8')?>
								</div>
							<?php endif; ?>
							<button
								type="button"
								class="btn btn-sm btn-outline-primary btn-observacoes mt-1"
								data-bs-toggle="modal"
								data-bs-target="#modalObservacoes"
								data-tooltip="true"
								title="Visualizar as observações enviadas"
								data-observacoes="<?= htmlspecialchars($observacoes, ENT_QUOTES, 'UTF-8') ?>"
								<?= $observacoes === '' ? 'disabled' : '' ?>>
								<i class="bi bi-card-text me-1"></i>Observações
							</button>
						</td>

						<td class="text-center pe-4">
							<?php if($campo->status == 1): ?>
								<div class="actions-stack">
									<span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
										<i class="bi bi-check-circle-fill me-1"></i>APROVADO
									</span>
									<button type="button" class="btn btn-sm btn-outline-primary btn-historico-universitario"
										data-id="<?=$campo->id?>"
										data-tooltip="true" title="Visualizar todo o histórico deste evento">
										<i class="bi bi-clock-history me-1"></i>Histórico
									</button>
									<button type="button" class="btn btn-sm btn-outline-warning btn-voltar-acao" data-id="<?=$campo->id?>" data-bs-toggle="tooltip" title="Retornar este evento para pendente e permitir uma nova decisão">
										<i class="bi bi-arrow-counterclockwise me-1"></i>Voltar ação
									</button>
								</div>
							<?php elseif($campo->status == 2): ?>
								<div class="actions-stack">
									<span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold">RECUSADO</span>
									<button type="button" class="btn btn-sm btn-outline-primary btn-historico-universitario"
										data-id="<?=$campo->id?>"
										data-tooltip="true" title="Visualizar todo o histórico deste evento">
										<i class="bi bi-clock-history me-1"></i>Histórico
									</button>
									<button type="button" class="btn btn-sm btn-outline-warning btn-voltar-acao" data-id="<?=$campo->id?>" data-bs-toggle="tooltip" title="Retornar este evento para pendente e permitir uma nova decisão">
										<i class="bi bi-arrow-counterclockwise me-1"></i>Voltar ação
									</button>
								</div>
							<?php else: ?>
								<div class="actions-stack">
									<button class="btn btn-sm btn-success btn-status" data-id="<?= $campo->id ?>" data-status="<?= $campo->status ?>" data-bs-toggle="tooltip" title="Aceitar este evento universitário">
										<i class="bi bi-check-lg me-1"></i>Aceitar
									</button>
									<button class="btn btn-sm btn-outline-danger btnRecusar" data-id="<?= $campo->id ?>" data-bs-toggle="tooltip" title="Recusar este evento e informar o motivo">
										<i class="bi bi-x-lg me-1"></i>Recusar
									</button>
								</div>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
    <?php endif; ?>
</div>

<!-- Modal Observações -->
<div class="modal fade" id="modalObservacoes" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Observações</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" data-tooltip="true" title="Fechar as observações">
                    <i class="bi bi-x-lg text-white me-1"></i>Fechar
                </button>
            </div>

            <div class="modal-body">
                <div id="textoObservacoes" class="texto-observacoes text-dark"></div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Histórico -->
<div class="modal fade" id="modalHistoricoUniversitario" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="bi bi-clock-history text-primary me-2"></i>Histórico do evento universitário</h5>
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" data-tooltip="true" title="Fechar os detalhes" aria-label="Fechar os detalhes">
					<i class="bi bi-dash-lg"></i>
				</button>
			</div>
			<div class="modal-body">
				<div id="carregandoHistoricoUniversitario" class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm text-primary me-2"></span>Carregando histórico...</div>
				<div id="listaHistoricoUniversitario" class="list-group list-group-flush"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="tooltip" title="Fechar os detalhes">
					<i class="bi bi-x-lg text-white me-1"></i>Fechar
				</button>
			</div>
		</div>
	</div>
</div>

<!-- MOdal Confirmação --> 
<div class="modal fade" id="modalConfirmar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-tooltip="true" title="Fechar a confirmação"></button>
            </div>

            <div class="modal-body">
                <p id="textoConfirmacao"></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" data-tooltip="true" title="Cancelar esta ação">Cancelar</button>
                <button id="confirmarAlteracao" class="btn btn-primary" data-bs-toggle="tooltip" title="Confirmar a alteração de status">Confirmar</button>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-tooltip="true" title="Fechar a mensagem de resultado"></button>
            </div>

            <div class="modal-body">
                <p id="mensagemRetorno"></p>
            </div>

        </div>
    </div>
</div>
<!-- MODAL RECUSA-->
<div class="modal fade" id="modalRecusar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="post" id="formRecusar">
                <div class="modal-header">
                    <h5 class="modal-title">Mérito Recusar</h5>
                    <button type="button" id="btnfechar2" class="btn-close btn btn-outline-dark" data-bs-dismiss="modal" data-tooltip="true" title="Fechar sem recusar">fechar</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="recusarId">
                    <input type="hidden" name="status" value="2">

                    <div class="mb-3">
                        <label class="form-label">Motivo da Recusa</label>
                        <textarea 
                            name="descricao" 
                            class="form-control" 
                            rows="4"
                            placeholder="Digite o motivo da recusa..."
                            required></textarea>
                    </div>
					
					<div id="box_retorno_recusar"></div>
                </div>

                <div class="modal-footer">
                    <button 
                        type="submit"
						class="btn btn-primary"
						data-bs-toggle="tooltip" title="Confirmar a recusa e salvar o motivo">
                        💾 Recusar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(){
	document.querySelectorAll('[data-bs-toggle="tooltip"], [data-tooltip="true"]').forEach(function (el) {
		bootstrap.Tooltip.getOrCreateInstance(el);
	});

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')

    popoverTriggerList.forEach(function (el) {
        new bootstrap.Popover(el)
    });

    const modalObservacoes = document.getElementById('modalObservacoes');

    if (modalObservacoes) {
        modalObservacoes.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const observacoes = button ? button.getAttribute('data-observacoes') : '';

            modalObservacoes.querySelector('#textoObservacoes').textContent = observacoes || 'Nenhuma observação informada.';
        });
    }

	document.querySelectorAll('.btn-historico-universitario').forEach(function (botao) {
		botao.addEventListener('click', function () {
			const carregando = document.getElementById('carregandoHistoricoUniversitario');
			const lista = document.getElementById('listaHistoricoUniversitario');
			lista.innerHTML = '';
			carregando.style.display = '';
			bootstrap.Modal.getOrCreateInstance(document.getElementById('modalHistoricoUniversitario')).show();

			fetch('<?=base_url('restrito/universitario/historico/')?>' + encodeURIComponent(botao.dataset.id), {headers:{'X-Requested-With':'XMLHttpRequest'}})
			.then(function (resposta) { return resposta.json(); })
			.then(function (retorno) {
				carregando.style.display = 'none';
				if (retorno.status !== 'success') throw new Error(retorno.message || 'Erro ao carregar histórico.');
				if (!retorno.historico.length) {
					lista.innerHTML = '<div class="text-center text-muted py-5"><i class="bi bi-clock-history fs-2 d-block mb-2"></i>Nenhuma alteração registrada para este evento.</div>';
					return;
				}
				retorno.historico.forEach(function (registro) {
					const item = document.createElement('div'); item.className = 'list-group-item px-0 py-3';
					const linha = document.createElement('div'); linha.className = 'd-flex justify-content-between align-items-start gap-3';
					const dados = document.createElement('div');
					const acao = document.createElement('div'); acao.className = 'fw-semibold text-dark'; acao.textContent = registro.acao;
					const usuario = document.createElement('small'); usuario.className = 'text-muted d-block mt-1'; usuario.textContent = 'Usuário: ' + registro.usuario;
					const data = document.createElement('span'); data.className = 'badge bg-light text-dark border text-nowrap'; data.textContent = registro.data_formatada;
					dados.appendChild(acao); dados.appendChild(usuario); linha.appendChild(dados); linha.appendChild(data); item.appendChild(linha); lista.appendChild(item);
				});
			})
			.catch(function (erro) { carregando.style.display = 'none'; lista.innerHTML = '<div class="alert alert-danger mb-0"></div>'; lista.firstElementChild.textContent = erro.message; });
		});
	});

});
</script>
<script>
		$(document).on("click",".btn-status",function(){
			const id = $(this).data("id");
			Swal.fire({
				title: 'Aceitar evento',
				input: 'textarea',
				inputLabel: 'Motivo do aceite',
				inputPlaceholder: 'Informe o motivo do aceite...',
				inputAttributes: { 'aria-label': 'Motivo do aceite' },
				showCancelButton: true,
				confirmButtonText: 'Aceitar evento',
				cancelButtonText: 'Cancelar',
				confirmButtonColor: '#198754',
				inputValidator: function(valor) {
					if (!valor || !valor.trim()) return 'Informe o motivo do aceite.';
				}
			}).then(function(resultado) {
				if (!resultado.isConfirmed) return;
				$.ajax({
					url: '<?=base_url("restrito/universitario/alterar_status")?>',
					type: 'POST',
					dataType: 'json',
					data: { id: id, motivo: resultado.value.trim() }
				}).done(function(retorno) {
					Swal.fire({
						title: retorno.status === 'success' ? 'Evento aceito!' : 'Atenção',
						text: retorno.message,
						icon: retorno.status === 'success' ? 'success' : 'error'
					}).then(function() {
						if (retorno.status === 'success') location.reload();
					});
				}).fail(function() {
					Swal.fire('Erro!', 'Não foi possível aceitar o evento.', 'error');
				});
			});
		});
		
		$(document).on('click', '.btnRecusar', function(){
			const id = $(this).data('id');
			Swal.fire({
				title: 'Recusar evento',
				input: 'textarea',
				inputLabel: 'Motivo da recusa',
				inputPlaceholder: 'Informe o motivo da recusa...',
				inputAttributes: { 'aria-label': 'Motivo da recusa' },
				showCancelButton: true,
				confirmButtonText: 'Recusar evento',
				cancelButtonText: 'Cancelar',
				confirmButtonColor: '#dc3545',
				inputValidator: function(valor) {
					if (!valor || !valor.trim()) return 'Informe o motivo da recusa.';
				}
			}).then(function(resultado) {
				if (!resultado.isConfirmed) return;
				$.ajax({
					url: '<?=base_url("restrito/universitario/recusar")?>',
					type: 'POST',
					dataType: 'json',
					data: { id: id, descricao: resultado.value.trim(), status: 2 }
				}).done(function(retorno) {
					const sucesso = retorno.type === 'sucess';
					Swal.fire({
						title: sucesso ? 'Evento recusado!' : 'Atenção',
						text: retorno.message,
						icon: sucesso ? 'success' : 'error'
					}).then(function() {
						if (sucesso) location.reload();
					});
				}).fail(function() {
					Swal.fire('Erro!', 'Não foi possível recusar o evento.', 'error');
				});
			});
		});

		$(document).on('click', '.btn-voltar-acao', function(){
			const id = $(this).data('id');

			Swal.fire({
				title: 'Voltar ação?',
				text: 'O evento retornará para pendente e poderá ser aceito ou recusado novamente.',
				icon: 'question',
				showCancelButton: true,
				confirmButtonText: 'Sim, voltar ação',
				cancelButtonText: 'Cancelar',
				confirmButtonColor: '#f0ad4e'
			}).then(function(resultado) {
				if (!resultado.isConfirmed) return;

				fetch('<?=base_url("restrito/universitario/voltar_acao")?>', {
					method: 'POST',
					headers: {
						'X-Requested-With': 'XMLHttpRequest',
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: 'id=' + encodeURIComponent(id)
				})
				.then(function(response) { return response.json(); })
				.then(function(retorno) {
					return Swal.fire({
						title: retorno.status === 'success' ? 'Ação desfeita!' : 'Atenção',
						text: retorno.message,
						icon: retorno.status === 'success' ? 'success' : 'error'
					}).then(function() {
						if (retorno.status === 'success') location.reload();
					});
				})
				.catch(function() {
					Swal.fire('Erro!', 'Não foi possível voltar a ação.', 'error');
				});
			});
		});

		$('#btnfechar1').click(function() {
			console.log('fechando modal');
			location.reload();
		});

		$('#btnfechar2').click(function() {
			console.log('fechando modal');
			location.reload();
		});
</script>
<script>
$("#confirmarAlteracao").click(function(){

    $.ajax({

        url: "<?=base_url()?>restrito/universitario/alterar_status",
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

$("#formRecusar").submit(async function(e) {
				e.preventDefault();
				console.log('Recusando...');
				
			try {
				var form = document.getElementById("formRecusar");
				var fd = new FormData(form);
				console.log(fd);

				const result = await $.ajax({
						type: "POST",
						url: '<?=base_url()?>restrito/universitario/recusar',
						data: fd,
						dataType: 'html',
						enctype: "multipart/form-data",
						contentType: false,
						processData: false,
						beforeSend: function() {
							console.log('Enviando Recusa...');
						}
					})
					.done(function(res) {
						console.log('Sucesso:', res);
					})
					.fail(function(res) {
						console.log('Erro na requisição:', res);
					})
					.always(function(res) {
						console.log('retorno:', res);
						
						var retorno = typeof res === "string" ? JSON.parse(res) : res;
						if(retorno.type == "sucess"){
							$("#box_retorno_recusar").html('<div class="alert alert-success">'+retorno.message+'</div>');
						} else {
							$("#box_retorno_recusar").html('<div class="alert alert-danger">'+retorno.message+'</div>');
						}
					});

				return result;
			} catch (error) {
				console.log('Erro geral:', error);
				return false;
			}	
	});
</script>
