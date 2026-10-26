 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-growl/1.3.5/jquery.growl.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/plugins/select2/select2.bundle.css')?>">
<script src="<?=base_url('assets/plugins/select2/select2.bundle.js')?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- CSS GERAL -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">


<div class="container py-5">

    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <i class="fas fa-calendar-alt text-primary me-2 fs-4"></i>
            <h4 class="mb-0 text-primary">Programação de Cursos</h4>
        </div>
        
        <div class="d-flex gap-2">
            <a href="<?=base_url()?>restrito/programacao/cadastrar" class="btn btn-primary btn-cadastrar">
                <i class="bi bi-plus-lg"></i> Novo Item de Programação
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-end">
				<div class="col-md-12">
                    <label class="form-label fw-bold text-muted small text-uppercase">Selecione o Curso para gerenciar</label>
					<select id="curso" class="form-select" aria-label="Pesquisar curso pelo nome ou CourseID">
						<option value="">Selecione ou digite o código ou nome do curso</option>
						<?php foreach($cursos as $c){ ?>
						<option value="<?=htmlspecialchars($c->courseid, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($c->courseid . ' - ' . $c->titulo, ENT_QUOTES, 'UTF-8')?></option>
						<?php } ?>
					</select>
                </div>
				<div class="col-md-12 mt-3">
                    <h5 id="nomeCurso" class="text-primary fw-bold mb-0"></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelaProgramacaoPrincipal">
                <thead style="background-color: #054589;">
                    <tr>
                        <th class="ps-4 py-3 text-white align-top" style="width: 120px;">DATA</th>
                        <th class="py-3 text-white align-top" style="width: 100px;">INÍCIO</th>
                        <th class="py-3 text-white align-top" style="width: 100px;">FIM</th>
                        <th class="py-3 text-white align-top">
                            PALESTRA
                            <input type="text" class="filter-input" placeholder="Filtrar título..." onkeyup="filterTable(3, this.value)">
                        </th>
                        <th class="py-3 text-white align-top">DESCRIÇÃO</th>
                        <th class="text-center py-3 text-white align-top" style="width: 120px;">AÇÕES</th>
                    </tr>
                </thead>
                <tbody id="tabelaProgramacao">
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-arrow-up-circle d-block fs-2 mb-2"></i>
                                Selecione um curso acima para carregar a programação.
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Programação</h5>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formEditarProgramacao">
                <div class="modal-body">
                    <!--<input type="text" name="id" id="edit_id">-->
                    <input type="hidden" name="prog_id" id="prog_id">
                    <div class="form-group">
                        <label>Título (Palestra)</label>
                        <input type="text" name="palestra" id="edit_titulo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Data/Hora Inicial</label>
                        <input type="datetime-local" name="data_hora_inicial" id="edit_data_inicial" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Hora Final</label>
                        <input type="time" name="hora_final" id="edit_hora_final" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="descricao" id="edit_descricao" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
			
			 <div id="box_retorno"></div>
        </div>
    </div>
</div>


<script>
	$(function () {
		function normalizarBusca(texto) {
			return (texto || '')
				.toString()
				.normalize('NFD')
				.replace(/[\u0300-\u036f]/g, '')
				.toLowerCase()
				.trim();
		}

		if ($.fn.select2) {
			$('#curso').select2({
				placeholder: 'Selecione ou digite o código ou nome do curso',
				allowClear: true,
				width: '100%',
				matcher: function (params, data) {
					const busca = normalizarBusca(params.term);
					if (!busca) return data;

					const textoCurso = normalizarBusca(data.text);
					const palavras = busca.split(/\s+/).filter(Boolean);
					return palavras.every(function (palavra) {
						return textoCurso.indexOf(palavra) !== -1;
					}) ? data : null;
				},
				language: {
					noResults: function () { return 'Nenhum curso encontrado'; },
					searching: function () { return 'Pesquisando...'; }
				}
			});
		}
	});

	function formatarData(dataHora){

		let data = new Date(dataHora);

		return data.toLocaleDateString('pt-BR');

	}

	function formatarHora(dataHora){

		let data = new Date(dataHora);

		return data.toLocaleTimeString('pt-BR',{hour:'2-digit',minute:'2-digit'});

	}

	// 1. CARREGA DADOS NA TABELA COFORME CURSO SELECIONADO
	$('#curso').change(function() {
		console.log('carrega o curso...')
			carregarProgramacao();
	});
	
	// A FUNÇÃO PRINCIPAL
	function carregarProgramacao() {
		let courseid = $('#curso').val(); // Pega o ID atual do select
	   
		if(courseid == '' || !courseid) {
			$('#tabelaProgramacao').html('<tr><td colspan="6" class="text-center text-muted">Selecione um curso para ver a programação</td></tr>');
			return;
		}

		// Feedback visual de carregamento
		$('#tabelaProgramacao').html('<tr><td colspan="6" class="text-center">Carregando...</td></tr>');
	   
		$.ajax({
			url: "<?= base_url('restrito/programacao/buscarProgramacao') ?>",
			type: "POST",
			data: {courseid: courseid},
			dataType: "json",
			success: function(retorno) {
				$('#nomeCurso').text(retorno.curso.length ? retorno.curso[0].titulo : '');
			   
				let html = '';
				if(retorno.programacao.length == 0) {
					html = '<tr><td colspan="6" class="text-center text-muted">Nenhuma programação encontrada</td></tr>';
				} else {
					retorno.programacao.forEach(function(item) {
						html += '<tr>';
						html += '<td>' + formatarData(item.data_hora_inicial) + '</td>';
						html += '<td>' + formatarHora(item.data_hora_inicial) + '</td>';
						html += '<td>' + item.hora_final + '</td>';
						html += '<td>' + item.palestra + '</td>';
						html += '<td>' + item.descricao + '</td>';
						
						// Coluna de Ações Agrupadas
						html += '<td class="text-center align-middle">';
						html += '<div class="btn-group shadow-sm" role="group">';
						
						// Botão Editar
						html += `<button type="button" class="btn btn-outline-primary btn-sm btn-editar" 
									data-id="${item.id}" 
									data-titulo="${item.palestra}" 
									data-inicio="${item.data_hora_inicial.replace(' ', 'T')}" 
									data-fim="${item.hora_final}" 
									data-desc="${item.descricao}">
									<i class="bi bi-pencil"></i>
								</button>`;

						// Botão Excluir
						html += `<button type="button" class="btn btn-outline-danger btn-sm btn-excluir-programacao" 
									data-id="${item.id}" 
									data-titulo="${item.palestra}">
									<i class="bi bi-trash"></i>
								</button>`;
								
						html += '</div>';
						html += '</td>';
						html += '</tr>';
					});
				}
				$('#tabelaProgramacao').html(html);
			},
			error: function() {
				$('#tabelaProgramacao').html('<tr><td colspan="6" class="text-center text-danger">Erro ao buscar dados.</td></tr>');
			}
		});
	}
	
	// 2. CARREGAR DADOS NO MODAL
		$(document).on('click', '.btn-editar', function(){
			const btn = $(this);
			//$('#edit_id').val(btn.data('id'));
			$('#prog_id').val(btn.data('id'));
			$('#edit_titulo').val(btn.data('titulo'));
			$('#edit_data_inicial').val(btn.data('inicio'));
			$('#edit_hora_final').val(btn.data('fim'));
			$('#edit_descricao').val(btn.data('desc'));
			
			$('#modalEditar').modal('show');
		});

	// 3. SALVAR VIA AJAX
		$('#formEditarProgramacao').submit(function(e){
			e.preventDefault();
			
					
			let dados = $(this).serialize();
			
			console.log('editando...');
			console.log("Dados serializados:", dados); // 3. VEJA SE O ID APARECE AQUI

			$.ajax({
				url: "<?= base_url('restrito/programacao/atualizar') ?>", 
				type: "POST",
				data: dados,
				dataType: "json",
				success: function(res){
					if(res.status == 'success'){
						alert('Atualizado com sucesso!');
						$('#modalEditar').modal('hide');
						$('#curso').trigger('change'); // Recarrega a tabela automaticamente
					} else {
						alert('Erro ao salvar.');
					}
				}
			});
		});
		
	// 4. Altera Status da Programação
		$(document).on("click", ".btn-excluir-programacao", function() {
			const id = $(this).data("id");
			const titulo = $(this).data("titulo");

			Swal.fire({
				title: 'Tem certeza?',
				text: `Deseja remover "${titulo}" da programação?`,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33', // Vermelho para excluir
				cancelButtonColor: '#6c757d',
				confirmButtonText: 'Sim, excluir!',
				cancelButtonText: 'Cancelar',
				reverseButtons: true
			}).then((result) => {
				if (result.isConfirmed) {
					// Se o usuário confirmou, dispara o AJAX abaixo
					excluirProgramacao(id); 
				}
			});
		});

		function excluirProgramacao(idSelecionado) {
			$.ajax({
				url: "<?= base_url('restrito/programacao/excluir_item') ?>",
				type: "POST",
				data: { id: idSelecionado },
				dataType: "json",
				success: function(res) {
					Swal.fire({
						title: res.type == 'success' ? "Excluído!" : "Erro",
						text: res.message,
						icon: res.type == 'success' ? "success" : "error",
						timer: 1500,
						showConfirmButton: false
					});

					if(res.type == 'success') {
						carregarProgramacao();
					}
				}
			});
		}
   
</script>
