 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
 
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
 
 <!-- CSS  -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">

<div class="container">
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-file-signature text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Vincular Palestrantes ao Curso</h4>
		</div>
	</div>

	<form method="post" action="<?= base_url('restrito/palestrantes/vincular') ?>">

		<div class="mb-3">
			<label class="form-label">Selecione o Curso</label>
			<select name="courseid" class="form-select select-busca" required>
				<option value="">Selecione ou digite o nome do curso</option>
				<?php foreach($cursos as $curso): ?>
					<option value="<?= $curso->courseid ?>">
						<?= $curso->titulo ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="mb-3">
			<label class="form-label">Selecione os Palestrantes</label>
			<select name="palestrantes[]" 
					class="form-select select-busca" 
					multiple 
					required>
				<?php foreach($palestrantes as $p): ?>
					<option value="<?= $p->id_palestrante ?>">
						<?= $p->nome ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<button type="submit" class="btn btn-primary mb-3">
			Salvar
		</button>

	</form>
</div>
<script>
$(document).ready(function() {
    $('.select-busca').select2({
        theme: 'bootstrap-5', // Opcional: se estiver usando o tema do Bootstrap
        placeholder: "Clique para pesquisar...",
        allowClear: true,
        width: '100%'
    });
});
</script>
<style>
    /* Estilização da Tabela */
    #tabelaPalestrantes thead th {
        background-color: #1b4c7e;
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-top: none;
    }

    /* Container dos Palestrantes */
    .palestrantes-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px; /* Espaço entre os badges */
    }

    /* Item individual do Palestrante (Badge) */
    .palestrante-item {
        display: flex;
        align-items: center;
        background-color: #e9ecef;
        padding: 4px 10px;
        border-radius: 50px; /* Formato de pílula */
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }

    .palestrante-item:hover {
        background-color: #dee2e6;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .palestrante-item span {
        font-size: 0.9rem;
        color: #212529;
        margin-right: 8px;
        font-weight: 500;
    }

    /* Botão de Excluir dentro do Badge */
    .btn-delete-vinculo {
        border: none;
        background: transparent;
        color: #dc3545;
        padding: 0;
        line-height: 1;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
    }

    .btn-delete-vinculo:hover {
        transform: scale(1.2);
        color: #a71d2a;
    }

    /* Ajuste para células da tabela */
    #tabelaPalestrantes td {
        padding: 15px;
        vertical-align: middle;
    }
</style>

<!-- TABELA DE PALESTRANTES -->
<div class="row">
    <div class="col">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-chalkboard-teacher me-2"></i>Gestão de Vínculos: Palestrantes x Cursos</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabelaPalestrantes">
                    <thead>
                        <tr>
                            <th width="35%">Curso</th>
                            <th width="65%">Palestrantes Vinculados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tabelaPalestrantes as $row): ?>
                        <tr>
                            <td>
                                <span class="text-dark fw-bold"><?php echo $row->curso_nome; ?></span>
                                <br>
                                <small class="text-muted">ID: #<?php echo $row->courseid; ?></small>
                            </td>
                            <td>
                                <div class="palestrantes-list">
                                    <?php 
                                    if (!empty($row->palestrantes_info)):
                                        $palestrantes = explode('|', $row->palestrantes_info);
                                        foreach ($palestrantes as $p): 
                                            list($nome, $id_palestrante) = explode(':', $p);
                                    ?>
                                        <div class="palestrante-item">
                                            <span><?php echo $nome; ?></span>
                                            <button type="button" 
                                                    class="btn-delete-vinculo" 
                                                    onclick="confirmarExclusao(<?php echo $id_palestrante; ?>, '<?php echo $row->courseid; ?>')"
                                                    title="Remover palestrante do curso">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                    <?php endforeach; 
                                    else: ?>
                                        <span class="text-muted small">Nenhum palestrante vinculado.</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
	<!-- FIM TABELA DE PALESTRANTES -->

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
<?php
$retorno = $this->session->flashdata('retorno');
$this->session->unset_userdata('retorno');
if (!empty($retorno)):
?>
<script>
document.addEventListener("DOMContentLoaded", function(){

    var retorno = <?= json_encode($retorno, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    document.getElementById("mensagemRetorno").innerText = retorno.mensagem;

    var modal = new bootstrap.Modal(document.getElementById('modalRetorno'));
    modal.show();

});
</script>
<?php endif; ?>


<script>
	function confirmarExclusao(idPalestrante, courseId) {
	
	console.log(idPalestrante);
	console.log(courseId);
	
    Swal.fire({
        title: 'Remover palestrante?',
        text: "O vínculo deste palestrante com o curso será excluído.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, remover!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Envia os dados via AJAX (Fetch API)
            fetch('<?php echo base_url("restrito/palestrantes/excluir_vinculo_palestrante"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_palestrante=${idPalestrante}&courseid=${courseId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Removido!', data.message, 'success')
                        .then(() => location.reload()); // Recarrega para atualizar a lista
                } else {
                    Swal.fire('Erro!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Erro!', 'Não foi possível se comunicar com o servidor.', 'error');
            });
        }
    });
}
</script>
