<!-- BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
	
	thead th {
		background-color: #0468aa; 
		color: white; 
	}
	
</style>
<style>
.col-status {
    display: flex;
    align-items: center;
    gap: 10px;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 0 0 2px #f1f1f1;
}

.status-dot:hover {
    transform: scale(1.3);
}

/* Estados */
.status-dot.aceito {
    background: #28a745;
}

.status-dot.recusado {
    background: #dc3545;
}

.status-dot.pendente {
    background: #adb5bd;
}

//////////////* BOTÃO DESIGNAR *///////////////////////////
.designar-box {
    max-width: 400px;
    padding: 15px;
}

.btn-designar {
    background: #0d6efd;
    color: #fff;
    border: none;
    padding: 8px 18px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-designar:hover {
    background: #0b5ed7;
}

/* Form escondido inicialmente */
#formDesignar {
    display: none;
    margin-top: 12px;
    position: relative;
}

#formDesignar textarea {
    width: 100%;
    min-height: 90px;
    padding: 10px 40px 10px 10px;
    border-radius: 8px;
    border: 1px solid #ced4da;
    resize: vertical;
    font-size: 14px;
}

/* Botão disquete */
.btn-salvar {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #0d6efd;
    transition: transform 0.2s, color 0.2s;
}

.btn-salvar:hover {
    color: #0b5ed7;
    transform: scale(1.2);
}

.criado{
	color: #0b5ed7;
}
.expirado{
	color: #d70b0b;
}
</style>
<style>
    /* Estilo para as datas com ícones */
    .date-badge { 
        background: #f8f9fa; 
        border: 1px solid #dee2e6; 
        padding: 2px 8px; 
        border-radius: 4px; 
        font-size: 11px; 
        display: inline-block;
    }
    /* Limitação de texto para a descrição */
    .desc-truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 12px;
        color: #495057 !important;
    }
	#table_programacao tbody .main-text {
		color: #212529 !important;
		font-weight: 700;
	}
	#table_programacao tbody .sub-text.text-primary {
		color: #0d6efd !important;
	}
    /* Badge de Status Supreme */
    .status-pill {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-0 { background: #fff3e0; color: #ef6c00; } /* Pendente */
    .status-1 { background: #e8f5e9; color: #2e7d32; } /* Aceito */
    .status-2 { background: #ffebee; color: #c62828; } /* Recusado */

	.pesquisa-table { min-width: 1240px; table-layout: fixed; }
	.pesquisa-table thead th { position: sticky; top: 0; z-index: 2; padding: 15px 12px; vertical-align: middle; }
	.pesquisa-table tbody td { padding: 18px 12px; border-bottom: 1px solid #e9eef5; vertical-align: middle; color: #344054; }
	.pesquisa-table tbody tr { transition: background-color .2s ease, box-shadow .2s ease; }
	.pesquisa-table tbody tr:hover { background: #f8fbff; box-shadow: inset 4px 0 0 #0d6efd; }
	.pesquisa-table .main-text { line-height: 1.4; overflow-wrap: anywhere; }
	.pesquisa-table .sub-text { display: flex; align-items: flex-start; gap: 7px; margin-top: 7px; line-height: 1.4; overflow-wrap: anywhere; }
	.pesquisa-table .sub-text i { flex: 0 0 15px; margin: 1px 0 0 !important; text-align: center; }
	.pesquisa-table .timeline-box { display: inline-flex; flex-direction: column; gap: 6px; min-width: 130px; padding: 9px 11px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; }
	.pesquisa-table .desc-truncate { white-space: normal; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5; color: #475467; }
	.pesquisa-table .actions-stack { display: flex; flex-direction: column; align-items: stretch; gap: 7px; max-width: 155px; margin: 0 auto; }
	.pesquisa-table .actions-stack .btn { margin-top: 0 !important; white-space: nowrap; }
	.pesquisa-table .solicitacao-id {
		width: 54px;
		height: 54px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border-radius: 10px;
		font-size: 14px;
		font-weight: 800;
		box-shadow: 0 3px 8px rgba(16, 24, 40, .14);
	}
	.pesquisa-table .solicitacao-id.status-pendente { background: #f7d154; color: #4b3a00; }
	.pesquisa-table .solicitacao-id.status-aceito { background: #58a942; color: #fff; }
	.pesquisa-table .solicitacao-id.status-recusado { background: #c94f4f; color: #fff; }
	.table-responsive { scrollbar-color: #aabbd0 #eef3f8; scrollbar-width: thin; }
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


function toggleStatus(id, atual) {
    const novo = atual === 'Aceito' ? 'Recusado' : 'Aceito';
    alterarStatus(id, novo);
}


function abrirDesignacao() {
    document.getElementById('formDesignar').style.display = 'block';
}


</script>
<?php
	
	$totalLinhas = count($tabela);
	$qtdPendentes = $totaisStatus[0] ?? 0;
	$ativos = $totaisStatus[1] ?? 0;
	$inativos = $totaisStatus[2] ?? 0;
	
?>
<div class="container-fluid px-3 px-xl-4">
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-calendar-alt text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Eventos - Pesquisas Cientificas</h4>
		</div>
	</div>
	<div class="d-flex justify-content-end mb-3">
		<div class="btn-group" role="group" aria-label="Filtrar pesquisas por status">
			<a href="<?=base_url('restrito/pesquisa/listar?status=0')?>" class="btn <?=$statusLista === 0 ? 'btn-warning' : 'btn-outline-warning'?>" data-bs-toggle="tooltip" title="Mostrar pesquisas pendentes"><i class="bi bi-hourglass-split me-1"></i>Pendentes (<?=$qtdPendentes?>)</a>
			<a href="<?=base_url('restrito/pesquisa/listar?status=1')?>" class="btn <?=$statusLista === 1 ? 'btn-success' : 'btn-outline-success'?>" data-bs-toggle="tooltip" title="Mostrar pesquisas aceitas"><i class="bi bi-check-circle-fill me-1"></i>Aceitos (<?=$ativos?>)</a>
			<a href="<?=base_url('restrito/pesquisa/listar?status=2')?>" class="btn <?=$statusLista === 2 ? 'btn-danger' : 'btn-outline-danger'?>" data-bs-toggle="tooltip" title="Mostrar pesquisas recusadas"><i class="bi bi-x-circle-fill me-1"></i>Recusados (<?=$inativos?>)</a>
		</div>
	</div>

	<div class="kpi-container">
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-primary text-white"><i class="bi bi-collection"></i></div>
			<div class="kpi-info">
				<h6>Total Eventos </h6>
				<span><?=$totalLinhas;?></span>
			</div>
		</div>
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-success text-white">
				<i class="bi bi-check"></i> <!-- Ícone trocado -->
			</div>
			<div class="kpi-info">
				<h6>Aceitos</h6>
				<span><?=$ativos;?></span>
			</div>
		</div>
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-danger text-white">
				<i class="bi bi-person-x"></i> <!-- Ícone trocado -->
			</div>
			<div class="kpi-info">
				<h6>Recusados</h6>
				<span><?=$inativos;?></span>
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
			<table class="table table-hover align-middle pesquisa-table mb-0" id="table_programacao">
				<colgroup>
					<col style="width: 80px;"><col style="width: 165px;"><col style="width: 300px;">
					<col style="width: 360px;"><col style="width: 130px;"><col style="width: 205px;">
				</colgroup>
				<thead class="thead-azul">
					<tr>
						<th class="ps-4" style="width: 80px;">SOLICITAÇÃO</th>
						<th style="width: 150px;">CRONOGRAMA</th>
						<th>PESQUISA / INSTITUIÇÃO</th>
						<th>DESCRIÇÃO RESUMIDA</th>
						<th class="text-center">ACESSO</th>
						<th class="text-center pe-4" style="width: 200px;">STATUS / AÇÕES</th>
					</tr>
				</thead>
				<tbody class="bg-white">
					<?php
					foreach ($tabela as $linha) {
						// Configuração de cores para o indicador lateral
						$statusSolicitacao = [
							0 => ['classe' => 'status-pendente', 'label' => 'Pendente'],
							1 => ['classe' => 'status-aceito', 'label' => 'Aceita'],
							2 => ['classe' => 'status-recusado', 'label' => 'Recusada']
						];
						$statusAtual = $statusSolicitacao[$linha->status] ?? $statusSolicitacao[0];
						
						$primeiroParagrafo = preg_split('/\n\s*\n/', trim($linha->descricao))[0];
					?>
					<tr class="position-relative" style="font-size: 13px;">
						<td class="ps-4">
							<div class="solicitacao-id <?=$statusAtual['classe']?>"
								data-bs-toggle="tooltip"
								title="Solicitação #<?=$linha->id_pesquisa?> — <?=$statusAtual['label']?>">
								#<?=$linha->id_pesquisa?>
							</div>
						</td>

						<td>
							<div class="timeline-box">
								<span class="text-primary fw-semibold text-nowrap"><i class="bi bi-calendar-plus me-1"></i><?= date('d/m/Y', strtotime($linha->data_criacao)); ?></span>
								<span class="text-danger small text-nowrap"><i class="bi bi-calendar-x me-1"></i>Expira: <?= date('d/m/Y', strtotime($linha->data_expiracao)); ?></span>
							</div>
						</td>

						<td>
							<div class="main-text mb-1"><?= $linha->titulo; ?></div>
							<div class="sub-text text-primary fw-bold" style="font-size: 11px;">
								<i class="bi bi-bank me-1"></i><?= $linha->instituicao; ?>
							</div>
						</td>

						<td>
							<div class="desc-truncate" title="<?= htmlspecialchars($primeiroParagrafo); ?>">
								<?= $primeiroParagrafo; ?>...
							</div>
						</td>

						<td class="text-center">
							<span class="status-pill status-1">
								<a href="<?= $linha->link; ?>" target="_blank" 
								   class="btn btn-sm btn-outline-info border-0 rounded-pill px-3 shadow-none" 
								   style="color: var(--lilas); font-weight: 500; transition: 0.3s;">
									<i class="bi bi-link-45deg me-1"></i>Acessar
								</a>
							</span>
						</td>

						<td class="text-center pe-4">
							<?php if($linha->status == 1): ?>
								<div class="actions-stack"><span class="status-pill status-1"><i class="bi bi-check-circle-fill me-1"></i>Aceito</span>
								<button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-historico-pesquisa" data-id="<?=$linha->id_pesquisa?>" data-bs-toggle="tooltip" title="Visualizar o histórico desta pesquisa"><i class="bi bi-clock-history me-1"></i>Histórico</button>
								<button type="button" class="btn btn-sm btn-outline-warning mt-2 btn-voltar-acao" data-id="<?=$linha->id_pesquisa?>" data-bs-toggle="tooltip" title="Retornar para pendente"><i class="bi bi-arrow-counterclockwise me-1"></i>Voltar ação</button></div>
							<?php elseif($linha->status == 2): ?>
								<div class="actions-stack">
									<span class="status-pill status-2 mb-1">Recusado</span>
									<button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-historico-pesquisa" data-id="<?=$linha->id_pesquisa?>" data-bs-toggle="tooltip" title="Visualizar o histórico desta pesquisa"><i class="bi bi-clock-history me-1"></i>Histórico</button>
									<button type="button" class="btn btn-sm btn-outline-warning mt-2 btn-voltar-acao" data-id="<?=$linha->id_pesquisa?>" data-bs-toggle="tooltip" title="Retornar para pendente"><i class="bi bi-arrow-counterclockwise me-1"></i>Voltar ação</button>
								</div>
							<?php else: ?>
								<div class="actions-stack">
									<button class="btn btn-sm btn-cadastrar btnAceitar py-1 px-3" 
										data-bs-toggle="modal" 
										data-bs-target="#modalDesignar" 
										data-id="<?= $linha->id_pesquisa ?>">
										ACEITAR
									</button>
									<button class="btn btn-sm btn-outline-danger border-0 px-2" 
										data-bs-toggle="modal" 
										data-bs-target="#modalRecusar" 
										data-id="<?= $linha->id_pesquisa ?>">
										<i class="bi bi-x-lg me-1"></i>RECUSAR
									</button>
								</div>
							<?php endif; ?>
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

<div class="modal fade" id="modalHistoricoPesquisa" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable"><div class="modal-content">
		<div class="modal-header"><h5 class="modal-title"><i class="bi bi-clock-history text-primary me-2"></i>Histórico da pesquisa científica</h5><button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg text-white me-1"></i>Fechar</button></div>
		<div class="modal-body">
			<div id="carregandoHistoricoPesquisa" class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm text-primary me-2"></span>Carregando histórico...</div>
			<div id="listaHistoricoPesquisa" class="list-group list-group-flush"></div>
		</div>
	</div></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) { bootstrap.Tooltip.getOrCreateInstance(el); });
	document.addEventListener('click', function (event) {
		var historicoBtn = event.target.closest('.btn-historico-pesquisa');
		if (historicoBtn) {
			var carregando = document.getElementById('carregandoHistoricoPesquisa');
			var lista = document.getElementById('listaHistoricoPesquisa');
			lista.innerHTML = '';
			carregando.style.display = '';
			bootstrap.Modal.getOrCreateInstance(document.getElementById('modalHistoricoPesquisa')).show();

			fetch('<?=base_url("restrito/pesquisa/historico/")?>' + encodeURIComponent(historicoBtn.dataset.id), {headers:{'X-Requested-With':'XMLHttpRequest'}})
				.then(function (resposta) { return resposta.json(); })
				.then(function (retorno) {
					carregando.style.display = 'none';
					if (retorno.status !== 'success') throw new Error(retorno.message || 'Erro ao carregar histórico.');
					if (!retorno.historico.length) {
						lista.innerHTML = '<div class="text-center text-muted py-5"><i class="bi bi-clock-history fs-2 d-block mb-2"></i>Nenhum aceite ou recusa registrado.</div>';
						return;
					}
					retorno.historico.forEach(function (registro) {
						var item = document.createElement('div');
						item.className = 'list-group-item px-0 py-3';
						var cabecalho = document.createElement('div');
						cabecalho.className = 'd-flex justify-content-between align-items-start gap-3';
						var dados = document.createElement('div');
						var acao = document.createElement('div');
						acao.className = 'fw-semibold text-dark';
						acao.textContent = registro.acao;
						var usuario = document.createElement('small');
						usuario.className = 'text-muted d-block mt-1';
						usuario.textContent = 'Usuário: ' + registro.usuario;
						var data = document.createElement('span');
						data.className = 'badge bg-light text-dark border text-nowrap';
						data.textContent = registro.data_formatada;
						dados.appendChild(acao);
						dados.appendChild(usuario);
						cabecalho.appendChild(dados);
						cabecalho.appendChild(data);
						item.appendChild(cabecalho);
						if (registro.motivo) {
							var motivo = document.createElement('div');
							motivo.className = 'mt-3 p-2 bg-light border rounded small';
							motivo.textContent = 'Motivo: ' + registro.motivo;
							item.appendChild(motivo);
						}
						lista.appendChild(item);
					});
				})
				.catch(function (erro) {
					carregando.style.display = 'none';
					lista.innerHTML = '<div class="alert alert-danger mb-0"></div>';
					lista.firstElementChild.textContent = erro.message;
				});
			return;
		}
		var voltarBtn = event.target.closest('.btn-voltar-acao');
		if (!voltarBtn) return;
		Swal.fire({title:'Voltar ação?', text:'A pesquisa retornará para pendente e poderá ser analisada novamente.', icon:'question', showCancelButton:true, confirmButtonText:'Sim, voltar ação', cancelButtonText:'Cancelar', confirmButtonColor:'#f0ad4e'}).then(function (resultado) {
			if (!resultado.isConfirmed) return;
			fetch('<?=base_url("restrito/pesquisa/voltar_acao")?>', {method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Content-Type':'application/x-www-form-urlencoded'}, body:'id=' + encodeURIComponent(voltarBtn.dataset.id)})
				.then(function (r) { return r.json(); }).then(function (retorno) { Swal.fire(retorno.status === 'success' ? 'Ação desfeita!' : 'Atenção', retorno.message, retorno.status === 'success' ? 'success' : 'error').then(function () { if (retorno.status === 'success') location.reload(); }); })
				.catch(function () { Swal.fire('Erro!', 'Não foi possível voltar a ação.', 'error'); });
		});
	});
});
</script>

<script>
$(function(){
/*const modalDesignar = document.getElementById('modalDesignar');

	modalDesignar.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
	
	console.log(id);
	
	$('#designarId').val(id);
	
    //document.getElementById('designarId').value = id;
});
*/

$(document).on('click', '.btnAceitar', function(){

    var id = $(this).data('id'); // pega o data-id

    $('#designarId').val(id); // coloca no input hidden
    
	console.log(id);

    $('#modalDesignar').modal('show'); // abre o modal
});

$(document).on('click', '.btnRecusar', function(){

    var id = $(this).data('id'); // pega o data-id

    $('#recusarId').val(id); // coloca no input hidden
    
	console.log(id);

    $('#modalRecusar').modal('show'); // abre o modal
});

$('#btnfechar1').click(function() {
	console.log('fechando modal');
    location.reload();
});

$('#btnfechar2').click(function() {
	console.log('fechando modal');
    location.reload();
});



	$("#formUpdate").submit(async function(e) {
				e.preventDefault();
				console.log('Aceitando...');
				
			try {
				var form = document.getElementById("formUpdate");
				var fd = new FormData(form);
				console.log(fd);

				const result = await $.ajax({
						type: "POST",
						url: '<?=base_url()?>restrito/pesquisa/alterar_status',
						data: fd,
						dataType: 'json',
						enctype: "multipart/form-data",
						contentType: false,
						processData: false,
						beforeSend: function() {
							console.log('Enviando aceite...');
						}
					})
					.done(function(retorno) {
						if(retorno.type == "sucess"){
							$("#box_retorno").html('<div class="alert alert-success">'+retorno.message+'</div>');
							location.reload();
						} else {
							$("#box_retorno").html('<div class="alert alert-danger">'+retorno.message+'</div>');
						}
					})
					.fail(function(xhr) {
						var retorno = xhr.responseJSON;
						if (!retorno && xhr.responseText) {
							try {
								retorno = JSON.parse(xhr.responseText);
							} catch (e) {
								retorno = null;
							}
						}

						var mensagem = retorno && retorno.message
							? retorno.message
							: 'Não foi possível salvar o aceite. Verifique o log do sistema.';

						$("#box_retorno").html('<div class="alert alert-danger">'+mensagem+'</div>');
					});

				return result;
			} catch (error) {
				console.log('Erro geral:', error);
				return false;
			}	
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
						url: '<?=base_url()?>restrito/pesquisa/alterar_status',
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
	
});
</script>
<!-- MODAL -->
<div class="modal fade" id="modalDesignar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="post" id="formUpdate">
                <div class="modal-header">
                    <h5 class="modal-title">Aceitar Pesquisa Cientifica</h5>
                    <button type="button" id="btnfechar1" class="btn-close btn btn-outline-dark" data-bs-dismiss="modal">fechar</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="designarId">
					<input type="hidden" name="status" value="1">
					<div class="mb-3"><label class="form-label">Motivo do aceite</label><textarea name="descricao" class="form-control" rows="4" placeholder="Informe o motivo do aceite..." required></textarea></div>
					<div id="box_retorno"></div>
                </div>

                <div class="modal-footer">
                    <button 
                        type="submit"
                        class="btn btn-primary">
                        💾 Salvar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalRecusar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="post" id="formRecusar">
                <div class="modal-header">
                    <h5 class="modal-title">Recusar Pesquisa Cientifica</h5>
                    <button type="button" id="btnfechar2" class="btn-close btn btn-outline-dark" data-bs-dismiss="modal">fechar</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="recusarId">
                    <input type="hidden" name="status" value="2">
					<div class="mb-3"><label class="form-label">Motivo da recusa</label><textarea name="descricao" class="form-control" rows="4" placeholder="Informe o motivo da recusa..." required></textarea></div>
					<div id="box_retorno_recusar"></div>
                </div>

                <div class="modal-footer">
                    <button 
                        type="submit"
                        class="btn btn-primary">
                        💾 Recusar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
