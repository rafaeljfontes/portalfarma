<!-- CSS  -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">

<div class="container">
    
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="bi bi-people-fill text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Plenárias</h4>
		</div>
		
		<div class="d-flex gap-2">			
			<a href="<?=base_url()?>restrito/plenaria/formulario" class="btn btn-primary btn-cadastrar">
				<i class="bi bi-plus-lg"></i> Nova Plenária
			</a>
		</div>
	</div>
	
	
	
	<?php
		$totalLinhas = count($tabela);
	?>

	<div class="kpi-container">
		<div class="kpi-card shadow-sm">
			<div class="kpi-icon bg-primary text-white"><i class="bi bi-collection"></i></div>
			<div class="kpi-info">
				<h6>Total Plenarias</h6>
				<span><?=$totalLinhas;?></span>
			</div>
		</div>
	</div>
   
	<!-- TABELA DE Plenarias -->
    <div class="row">
		<div class="col">
			<div class="card shadow-sm border-0">
				<div class="table-responsive">
					<table class="table table-hover align-middle mb-0" id="tabelaPlenarias">
						<thead>
							<tr style="background-color: #0468aa;"> 
								<th class="py-3 text-white">Data</th>
								<th class="py-3 text-white">Título</th>
								<th class="py-3 text-white">Link Youtube</th>
								<th class="text-end pe-4 py-3 text-white">AÇÕES</th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($tabela) && !empty($tabela)): ?>
								<?php foreach ($tabela as $linha): ?>
								<tr>
									<td class="text-center align-middle">
										<i class="fa-regular fa-calendar-days text-primary me-1"></i>
										<?= date('d/m/Y', strtotime($linha->data_plenaria)); ?>
										<span class="fw-bold">#<?= $linha->id; ?></span>
									</td>
									</td>
									<td class="fw-semibold text-dark">
										<?= $linha->titulo; ?>
									</td>
									<td>
										<?php if(!empty($linha->link_youtube)): ?>
											<a href="<?= $linha->link_youtube ?>" target="_blank" class="text-danger text-decoration-none">
												<i class="fa fa-youtube-play"></i> Assistir
											</a>
										<?php else: ?>
											<span class="text-muted small">---</span>
										<?php endif; ?>
									</td>
									<td class="text-end pe-4">
										<div class="btn-group">
											<a href="<?= base_url('restrito/plenaria/formulario/' . $linha->id); ?>" 
											   class="btn btn-outline-primary btn-sm btn-action" title="Editar">
												<i class="bi bi-pencil"></i>
											</a>

											<button type="button" 
													class="btn btn-outline-danger btn-sm btn-action btn-excluir" 
													data-id="<?= $linha->id; ?>" title="Excluir">
												<i class="bi bi-trash"></i>
											</button>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="5" class="text-center py-5 text-muted">
										<i class="fa fa-info-circle"></i> Nenhuma plenária encontrada.
									</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<style>
		/* Ajustes para deixar a tabela mais profissional */
		#tabelaPlenarias thead th {
			font-weight: 600;
			text-transform: uppercase;
			font-size: 0.85rem;
			letter-spacing: 0.5px;
			border: none;
		}
		#tabelaPlenarias tbody td {
			font-size: 0.9rem;
			color: #444;
			padding-top: 15px;
			padding-bottom: 15px;
		}
		.btn-action {
			width: 35px;
			height: 35px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			border-radius: 6px !important;
		}
	</style>
	<!-- FIM TABELA DE Plenarias -->
    
</div>



<!-- Modal -->
<div class="modal fade" id="modalRetorno" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Mensagem</h5>
      </div>

      <div class="modal-body">
        <p id="mensagemRetorno"></p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
          OK
        </button>
      </div>

    </div>
  </div>
</div>
<?php if($this->session->flashdata('retorno')): ?>
<script>
document.addEventListener("DOMContentLoaded", function(){

    var retorno = <?= json_encode($this->session->flashdata('retorno')); ?>;

    document.getElementById("mensagemRetorno").innerText = retorno.mensagem;

    var modal = new bootstrap.Modal(document.getElementById('modalRetorno'));
    modal.show();

    // Ao fechar, redireciona
    document.getElementById('modalRetorno').addEventListener('hidden.bs.modal', function () {
        window.location.href = "<?= base_url('restrito/Plenarias'); ?>";
    });

});
</script>
<?php endif; ?>


<script>
	$(document).on('click', '.btn-gerar-certificados', function(e) {
		e.preventDefault();
		
		let id_palestrante = $(this).data('id');
		
		console.log(id_palestrante);
		
		// Abre a URL diretamente em uma nova aba
		// O navegador interpretará o fluxo binário do Html2Pdf como um PDF
		window.open("<?= base_url('restrito/Plenarias/certificado_Plenarias/'); ?>" + id_palestrante, '_blank');
	});


document.addEventListener('click', function(e) {
    if (e.target && (e.target.classList.contains('btn-excluir') || e.target.closest('.btn-excluir'))) {
        const btn = e.target.closest('.btn-excluir');
        const id = btn.getAttribute('data-id');

        // Substituição do confirm por Swal.fire
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Esta plenária será excluída permanentemente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                
                // Exibe um loading enquanto deleta
                Swal.showLoading();

                fetch('<?= base_url("restrito/plenaria/excluir/") ?>' + id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Excluído!',
                            text: data.mensagem,
                            icon: 'success',
                            confirmButtonColor: '#0468aa'
                        }).then(() => {
                            location.reload(); // Recarrega a lista após o OK
                        });
                    } else {
                        Swal.fire('Erro!', data.mensagem, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    Swal.fire('Erro!', 'Não foi possível processar a exclusão.', 'error');
                });
            }
        });
    }
});
</script>
<script>
function filterTable(colIndex, query) {
    // Seleciona a tabela correta de Plenarias
    const table = document.getElementById("tabelaPlenarias");
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
