
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
			<h4 class="mb-0 text-primary">Gerenciar Fiscalizações Humanizadas</h4>
		</div>
		
		<a href="<?=base_url()?>restrito/cursos/cadastrar" class="btn btn-primary btn-cadastrar">
			<i class="fas fa-plus"></i> Cadastrar Fiscalizações Humanizadas
		</a>
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
						<th class="align-top text-center">AÇÕES</th>
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
					?>
					<tr class="position-relative">
						<td class="p-0" style="width: 5px;">
							<div class="status-indicator <?= $status_class ?>"></div>
						</td>

						<td class="text-center align-middle">
							<small class="text-muted d-block">ID</small>
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
									<!--a href="<?=base_url()?>restrito/fiscalizacao/fiscalizacao_inscritos/<?=rawurlencode((string) $campo->courseid)?>" class="badge align-self-center text-decoration-none" style="background-color: #054589; color: #b9e2ff; line-height: 1; padding: 0.35em 0.65em;" title="Quantidade de inscritos"><?= $inscritosPorCurso[$campo->courseid] ?? 0; ?></a>-->
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
                                <a href="<?=base_url()?>restrito/fiscalizacao/fiscalizacao_inscritos/<?=rawurlencode((string) $campo->courseid)?>" class="btn btn-sm btn-outline-primary px-3" title="Ver inscritos" aria-label="Ver inscritos: <?=(int) ($inscritosPorCurso[$campo->courseid] ?? 0)?>">
                                    <i class="bi bi-people text-success" aria-hidden="true"></i>
                                    <span><?=(int) ($inscritosPorCurso[$campo->courseid] ?? 0)?></span>
                                </a>
								<a href="<?=base_url()?>restrito/cursos/editar/<?=$campo->id?>" class="btn btn-sm btn-outline-primary px-3">
									<i class="bi bi-pencil"></i>
								</a>
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