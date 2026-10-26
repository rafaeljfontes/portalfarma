<!-- BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- CSS GERAL -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">

<style>
    .sub-text { font-size: 11px; color: #6c757d; line-height: 1.3; }
    .main-text { font-weight: 700; color: #054589; margin-bottom: 2px; }
    .badge-data { background: #eef6ff; color: #054589; padding: 4px 8px; border-radius: 6px; font-weight: 600; display: inline-block; }
    .badge-status-estilizado { padding: 5px 12px; border-radius: 50px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .bg-pendente { background: #fff3e0; color: #ef6c00; }
    .bg-aceito { background: #e8f5e9; color: #2e7d32; }
    .bg-recusado { background: #ffebee; color: #c62828; }

	.merito-table { min-width: 1420px; table-layout: fixed; }
	.merito-table thead th { position: sticky; top: 0; z-index: 2; padding: 15px 12px; vertical-align: middle; }
	.merito-table tbody td { padding: 18px 12px; border-bottom: 1px solid #e9eef5; vertical-align: middle; color: #344054; }
	.merito-table tbody tr { transition: background-color .2s ease, box-shadow .2s ease; }
	.merito-table tbody tr:hover { background: #f8fbff; box-shadow: inset 4px 0 0 #0d6efd; }
	.merito-table .main-text, .merito-table .fw-bold { overflow-wrap: anywhere; }
	.merito-table .sub-text { display: block; margin-top: 6px; line-height: 1.45; overflow-wrap: anywhere; }
	.merito-table .sub-text i { display: inline-block; width: 15px; color: #0d6efd; text-align: center; margin-right: 5px !important; }
	.merito-table .event-date { display: inline-flex; flex-direction: column; gap: 6px; min-width: 120px; padding: 9px 11px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; }
	.merito-table .actions-stack { display: flex; flex-direction: column; align-items: stretch; gap: 7px; max-width: 160px; margin: 0 auto; }
	.merito-table .actions-stack .btn { margin-top: 0 !important; white-space: nowrap; }
	.merito-table .solicitacao-id {
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
	.merito-table .solicitacao-id.status-pendente { background: #f7d154; color: #4b3a00; }
	.merito-table .solicitacao-id.status-aceito { background: #58a942; color: #fff; }
	.merito-table .solicitacao-id.status-recusado { background: #c94f4f; color: #fff; }
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
	
	$totalLinhas = count($tabelaMerito);
	$qtdPendentes = $totaisStatus[0] ?? 0;
	$ativos = $totaisStatus[1] ?? 0;
	$inativos = $totaisStatus[2] ?? 0;
	
?>
<div class="container-fluid px-3 px-xl-4">
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-calendar-alt text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Eventos - Méritos Acadêmicos</h4>
		</div>
	</div>
	<div class="d-flex justify-content-end mb-3">
		<div class="btn-group" role="group" aria-label="Filtrar méritos por status">
			<a href="<?=base_url('restrito/merito/listar?status=0')?>" class="btn <?=$statusLista === 0 ? 'btn-warning' : 'btn-outline-warning'?>" data-bs-toggle="tooltip" title="Mostrar méritos pendentes"><i class="bi bi-hourglass-split me-1"></i>Pendentes (<?=$qtdPendentes?>)</a>
			<a href="<?=base_url('restrito/merito/listar?status=1')?>" class="btn <?=$statusLista === 1 ? 'btn-success' : 'btn-outline-success'?>" data-bs-toggle="tooltip" title="Mostrar méritos aceitos"><i class="bi bi-check-circle-fill me-1"></i>Aceitos (<?=$ativos?>)</a>
			<a href="<?=base_url('restrito/merito/listar?status=2')?>" class="btn <?=$statusLista === 2 ? 'btn-danger' : 'btn-outline-danger'?>" data-bs-toggle="tooltip" title="Mostrar méritos recusados"><i class="bi bi-x-circle-fill me-1"></i>Recusados (<?=$inativos?>)</a>
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
				<i class="bi bi-megaphone"></i> <!-- Ícone trocado -->
			</div>
			<div class="kpi-info">
				<h6>Convocação Feita</h6>
				<span><?=$ativos;?></span>
			</div>
		</div>
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-danger text-white">
				<i class="bi bi-person-x"></i> <!-- Ícone trocado -->
			</div>
			<div class="kpi-info">
				<h6>Não Atendida</h6>
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
			<table class="table table-hover align-middle merito-table mb-0" id="table_programacao" style="font-size: 13px;">
				<colgroup>
					<col style="width: 115px;"><col style="width: 210px;"><col style="width: 220px;">
					<col style="width: 160px;"><col style="width: 230px;"><col style="width: 250px;"><col style="width: 220px;">
				</colgroup>
				<thead class="thead-azul">
					<tr>
						<th class="ps-4">SOLICITAÇÃO</th>
						<th>INSTITUIÇÃO</th>
						<th>LOCAL DA CERIMÔNIA</th>
						<th>EVENTO (DATA/HORA)</th>
						<th>RESPONSÁVEL</th>
						<th>HOMENAGEADO / INFO</th>
						<th class="text-center">REPRESENTANTE / AÇÕES</th>
					</tr>
				</thead>
				<tbody class="bg-white">
					<?php foreach ($tabelaMerito as $merito): 
						$mesa_honra = ($merito->mesa_de_honra == 's') ? 'Sim' : 'Não';
						$discurso = ($merito->discurso_entrega == 's') ? 'Sim' : 'Não';
						
						// Definição de cores e status baseada no seu switch
						$status_cfg = [
							0 => ['label' => 'Pendente', 'class' => 'status-pendente'],
							1 => ['label' => 'Aceito', 'class' => 'status-aceito'],
							2 => ['label' => 'Recusado', 'class' => 'status-recusado']
						];
						$atual = $status_cfg[$merito->status];
					?>
					<tr class="position-relative">
						<td class="ps-4">
							<div class="solicitacao-id <?=$atual['class']?>"
								data-bs-toggle="tooltip"
								title="Solicitação #<?=$merito->id?> — <?=$atual['label']?>">
								#<?=$merito->id?>
							</div>
						</td>

						<td>
							<div class="main-text"><?= $merito->instituicao ?></div>
							<div class="sub-text"><i class="bi bi-calendar-check me-1"></i>Cad: <?= date('d/m/Y', strtotime($merito->data_cadastro)) ?></div>
						</td>

						<td>
							<div class="fw-bold" style="color: #054589;"><?= $merito->cidade ?></div>
							<div class="sub-text"><i class="bi bi-geo-alt me-1"></i><?= $merito->local_cerimonia ?></div>
						</td>

						<td>
							<div class="event-date">
								<span class="text-primary fw-semibold text-nowrap">
								<i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($merito->data_evento)) ?>
								</span>
								<span class="text-muted text-nowrap"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($merito->hora_evento)) ?></span>
							</div>
						</td>

						<td>
							<div class="fw-bold"><?= $merito->responsavel ?></div>
							<div class="sub-text">
								<i class="bi bi-briefcase me-1"></i><?= $merito->cargo_responsavel ?><br>
								<i class="bi bi-envelope me-1"></i><?= $merito->email_responsavel ?>
							</div>
						</td>

						<td>
							<div class="main-text text-dark"><?= $merito->graduando_homenageado ?></div>
							<div class="d-flex gap-2 mt-1">
								<span class="sub-text"><i class="bi bi-people me-1"></i>Mesa: <strong><?= $mesa_honra ?></strong></span>
								<span class="sub-text"><i class="bi bi-mic me-1"></i>Discurso: <strong><?= $discurso ?></strong></span>
							</div>
						</td>

						<td class="text-center pe-4">
							<?php if($merito->status == 1): ?>
								<div class="p-2 rounded-3 bg-light border actions-stack">
									<small class="d-block text-muted text-uppercase fw-bold" style="font-size: 9px;">Representante</small>
									<span class="fw-bold text-success"><?= $merito->representante_crfmg ?></span>
									<button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-historico-merito" data-id="<?=$merito->id?>" data-bs-toggle="tooltip" title="Visualizar o histórico deste mérito"><i class="bi bi-clock-history me-1"></i>Histórico</button>
									<button type="button" class="btn btn-sm btn-outline-warning mt-2 btn-voltar-acao" data-id="<?=$merito->id?>" data-bs-toggle="tooltip" title="Retornar para pendente"><i class="bi bi-arrow-counterclockwise me-1"></i>Voltar ação</button>
								</div>
							<?php elseif($merito->status == 2): ?>
								<div class="actions-stack text-danger small fw-bold">
									<span><i class="bi bi-exclamation-triangle me-1"></i>Recusado</span>
									<button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-historico-merito" data-id="<?=$merito->id?>" data-bs-toggle="tooltip" title="Visualizar o histórico deste mérito"><i class="bi bi-clock-history me-1"></i>Histórico</button>
									<button type="button" class="btn btn-sm btn-outline-warning mt-2 btn-voltar-acao" data-id="<?=$merito->id?>" data-bs-toggle="tooltip" title="Retornar para pendente"><i class="bi bi-arrow-counterclockwise me-1"></i>Voltar ação</button>
								</div>
							<?php else: ?>
								<div class="actions-stack">
									<button class="btn btn-sm btn-outline-primary btnDesignar px-3" data-id="<?= $merito->id ?>" data-bs-toggle="modal" data-bs-target="#modalDesignar">
										<i class="bi bi-person-check me-1"></i>Designar
									</button>
									<button class="btn btn-sm btn-outline-danger btnRecusar" data-id="<?= $merito->id ?>" data-bs-toggle="modal" data-bs-target="#modalRecusar">
										<i class="bi bi-x-circle me-1"></i>Recusar
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
	<?php
			
	}
	?>
</div>

<div class="modal fade" id="modalHistoricoMerito" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable"><div class="modal-content">
		<div class="modal-header"><h5 class="modal-title"><i class="bi bi-clock-history text-primary me-2"></i>Histórico do mérito acadêmico</h5><button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg text-white me-1"></i>Fechar</button></div>
		<div class="modal-body">
			<div id="carregandoHistoricoMerito" class="text-center text-muted py-5"><span class="spinner-border spinner-border-sm text-primary me-2"></span>Carregando histórico...</div>
			<div id="listaHistoricoMerito" class="list-group list-group-flush"></div>
		</div>
	</div></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) { bootstrap.Tooltip.getOrCreateInstance(el); });
	document.addEventListener('click', function (event) {
		var historicoBtn = event.target.closest('.btn-historico-merito');
		if (historicoBtn) {
			var carregando = document.getElementById('carregandoHistoricoMerito');
			var lista = document.getElementById('listaHistoricoMerito');
			lista.innerHTML = '';
			carregando.style.display = '';
			bootstrap.Modal.getOrCreateInstance(document.getElementById('modalHistoricoMerito')).show();

			fetch('<?=base_url("restrito/merito/historico/")?>' + encodeURIComponent(historicoBtn.dataset.id), {headers:{'X-Requested-With':'XMLHttpRequest'}})
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
		Swal.fire({title:'Voltar ação?', text:'O mérito retornará para pendente e poderá ser analisado novamente.', icon:'question', showCancelButton:true, confirmButtonText:'Sim, voltar ação', cancelButtonText:'Cancelar', confirmButtonColor:'#f0ad4e'}).then(function (resultado) {
			if (!resultado.isConfirmed) return;
			fetch('<?=base_url("restrito/merito/voltar_acao")?>', {method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Content-Type':'application/x-www-form-urlencoded'}, body:'id=' + encodeURIComponent(voltarBtn.dataset.id)})
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

$(document).on('click', '.btnDesignar', function(){

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
				console.log('Designando...');
				
			try {
				var form = document.getElementById("formUpdate");
				var fd = new FormData(form);
				console.log(fd);

				const result = await $.ajax({
						type: "POST",
						url: '<?=base_url()?>restrito/merito/alterar_status',
						data: fd,
						dataType: 'html',
						enctype: "multipart/form-data",
						contentType: false,
						processData: false,
						beforeSend: function() {
							console.log('Enviando designação...');
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
							$("#box_retorno").html('<div class="alert alert-success">'+retorno.message+'</div>');
						} else {
							$("#box_retorno").html('<div class="alert alert-danger">'+retorno.message+'</div>');
						}
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
						url: '<?=base_url()?>restrito/merito/alterar_status',
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
                    <h5 class="modal-title">Mérito Designar</h5>
                    <button type="button" id="btnfechar1" class="btn-close btn btn-outline-dark" data-bs-dismiss="modal">fechar</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="designarId">
                    <input type="hidden" name="status" value="1">

                    <div class="mb-3">
                        <label class="form-label">Designação</label>
                        <textarea 
                            name="descricao" 
                            class="form-control" 
                            rows="4"
                            placeholder="Digite a designação..."
                            required></textarea>
						<div class="mt-3">
							<label class="form-label">Motivo do aceite</label>
							<textarea name="motivo" class="form-control" rows="3" placeholder="Informe o motivo do aceite..." required></textarea>
						</div>
                    </div>
					
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
                    <h5 class="modal-title">Mérito Recusar</h5>
                    <button type="button" id="btnfechar2" class="btn-close btn btn-outline-dark" data-bs-dismiss="modal">fechar</button>
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
                        class="btn btn-primary">
                        💾 Recusar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
