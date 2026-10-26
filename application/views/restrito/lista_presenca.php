<?php

	foreach($curso as $campo){
	
		$titulo 		= $campo->titulo;
		$tipo_evento 	= $campo->tipo_evento;
		$courseid 		= $campo->courseid;
		
		/* tipo evento */
		switch ($tipo_evento) {
			case 1:
				$campo_evento = "Capacifar Presencial";
				$classe_card = '#F43F3F';
				break;
			case 2:
				$campo_evento = "Capacifar On-line";
				$classe_card = '#0EA5B7';
				break;
			case 3:
				$campo_evento 	= "Uso Racional de Medicamentos";
				$classe_card 	= '#00579c';
				$tabela 		= 'urm_inscricao';
				break;
			case 4:
				$campo_evento 	= "Fiscalização Humanizada";
				$classe_card 	= '#02795f';
				$tabela 		= 'fiscalizacao_humanizada_inscricao';
				break;
			case 5:
				$campo_evento = "Capacifar Universitário";
				$classe_card = '#004761';
				break;
			case 7:
				$campo_evento 	= "Seminário de Vigilância e Saúde";
				$classe_card 	= '#105e8f';
				$tabela 		= 'tbl_seminario_inscricao';
				break;
			default:
				$campo_evento 	= "Evento";
				$tabela 		= "mdl_user";
		}
	}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="container">
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-people-group text-primary me-2 fs-4"></i>&nbsp;
			<h4 class="mb-0 text-primary">Gerenciar Presenças - <?=$campo_evento?></h4>
		</div>
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<h5 class="mb-0 text-danger"><?=$titulo?></h5>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-md-12">
			<div class="input-group">
				<span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
				<input type="text" id="inputBusca" class="form-control" placeholder="Buscar por Nome ou CPF...">
			</div>
			<small class="text-muted">A busca filtra automaticamente enquanto você digita.</small>
		</div>
	</div>
	<table class="table table-striped" id="tabelaInscritos">
		<thead>
			<tr>
				<th><input type="checkbox" id="selecionarTodos"></th>
				<th>Nome</th>
				<th>CPF</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach ($inscritos as $row): 
			?>
			<tr>
				<td>
					<input type="checkbox" class="checkPresenca" value="<?= $row->id; ?>" <?= ($row->presenca == 1) ? 'checked' : ''; ?>><br>
					<small class="text-muted" style="color:#a6a8ab;">#<?php echo $row->id; ?></small>
				</td>
				<td>
					<?= $row->nome; ?><br>
					<small class="text-muted" style="color:#a6a8ab;"># <?php echo $row->ocupacao; ?></small>
				</td>
				<td><?= $row->cpf; ?><br>
					<small class="text-muted" style="color:#a6a8ab;">Inscrição: <?= $row->modalidade; ?></small>
				</td>
				<td><?= $row->email; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<button type="button" id="btnSalvarPresenca" class="btn btn-primary" style="width: 100%;">Salvar Presença</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Selecionar/Deselecionar todos
    $('#selecionarTodos').click(function() {
        $('.checkPresenca').prop('checked', this.checked);
    });


    $('#btnSalvarPresenca').click(function() {
        let ids = [];
        $('.checkPresenca:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            Swal.fire('Aviso', 'Selecione ao menos um inscrito!', 'warning');
            return;
        }
		
		let tabela 		= '<?=$tabela?>';
		let courseid 	= '<?=$courseid?>';

        $.ajax({
            url: "<?= base_url('restrito/cursos/atualizar_presenca'); ?>",
            type: "POST",
            data: {
				ids: ids,        	// Array de IDs selecionados
				tabela: tabela,     	// Passando a variável evento
				courseid: courseid  // Passando a variável courseid
			},
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Sucesso!', response.message, 'success').then(() => {
                        location.reload(); // Recarrega para mostrar status atualizado
                    });
                } else {
                    Swal.fire('Erro', 'Erro ao processar solicitação', 'error');
                }
            }
        });
    });
	
	
	// Filtro de Busca na Tabela
	$("#inputBusca").on("keyup", function() {
		let value = $(this).val().toLowerCase();
		
		$("#tabelaInscritos tbody tr").filter(function() {
			// Busca o texto dentro da linha atual
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
});
</script>