<!-- Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- jquery-3.7.1 -->
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<style>
	.modal-content {
		max-height: 90vh;
		overflow-y: auto;
	}
</style>
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Solicitação de Pesquisa científica</h4>
        </div>

        <div class="card-body">

            <form method="post" id="formAdd" enctype="multipart/form-data">

                <div class="row g-3">
					
					<h4> Dados do Solicitante</h4>
					
                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label">E-mail do Solicitante</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <!-- Nome -->
                    <div class="col-md-6">
                        <label class="form-label">Nome do solicitante / pesquisador responsável</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <!-- Lattes -->
                    <div class="col-md-6">
                        <label class="form-label">Link do Currículo Lattes</label>
                        <input type="text" name="lattes" class="form-control">
                    </div>

                    <!-- Telefone -->
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control">
                    </div>

                    <!-- Orientador -->
                    <div class="col-md-6">
                        <label class="form-label">Nome do Orientador</label>
                        <input type="text" name="orientador" class="form-control">
                    </div>
					
					<hr class="my-4">
					
					<h4> Dados da Pesquisa</h4>

                    <!-- Título -->
                    <div class="col-md-12">
                        <label class="form-label">Título da Pesquisa</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>
					
					<!-- Instituição -->
                    <div class="col-md-12">
                        <label class="form-label">Instituição</label>
                        <input type="text" name="instituicao" class="form-control" required>
                    </div>

                    <!-- Objetivo -->
                    <div class="col-12">
                        <label class="form-label">Autores da Pesquisa</label>
                        <textarea name="autores" class="form-control" rows="3"></textarea>
						<small class="text-muted">
							cada Autor deverá ser separado pela tecla enter (um por linha)
						</small>
                    </div>
					
					<!-- Descrição -->
                    <div class="col-12">
                        <label class="form-label">Descricao da Pesquisa</label>
                        <textarea name="descricao" class="form-control" rows="3"></textarea>
                    </div>
					
					

                    <!-- Tipo -->
                    <div class="col-12">
                        <label class="form-label">Tipo de Solicitação</label>
                        <select name="tipo" id="tipo" class="form-select" onchange="mostrarCampo()" required>
                            <option value="">Selecione</option>
                            <option value="1">
                                1 - Dado estatístico referente ao número e distribuição dos profissionais e empresas farmacêuticas atuantes no Estado de Minas Gerais
                            </option>
                            <option value="2">
                                2 - Divulgação de link de formulário de coleta de dados aos profissionais ou empresas registrados no CRF/MG
                            </option>
                        </select>
                    </div>

                    <!-- Campo Condicional -->
                    <div class="col-12 d-none" id="campo_descricao">
                        <label class="form-label">
                            Caso positivo, descrever o dado estatístico solicitado
                        </label>
                        <textarea name="descricao_dado" class="form-control" rows="3"></textarea>
                    </div>

                    <hr class="my-4">
					
					

                    <!-- Pré-projeto -->
                    <div class="col-md-6">
                        <label class="form-label">Cópia do Pré-projeto (PDF)</label>
                        <input type="file" name="projeto" class="form-control" accept="application/pdf">
                        <div class="form-text">
                            Ou informe link do Google Drive (liberar acesso para qualquer pessoa com o link).
                        </div>
                        <input type="text" name="link_projeto" class="form-control mt-2" placeholder="Link Google Drive">
                    </div>

                    <!-- Ética -->
                    <div class="col-md-6">
                        <label class="form-label">Carta de Aprovação do Comitê de Ética (PDF)</label>
                        <input type="file" name="etica" class="form-control" accept="application/pdf">
                        <div class="form-text">
                            Ou informe link do Google Drive (liberar acesso para qualquer pessoa com o link).
                        </div>
                        <input type="text" name="link_etica" class="form-control mt-2" placeholder="Link Google Drive">
                    </div>

                    <!-- Período -->
                    <div class="col-md-6">
                        <label class="form-label">Período de coleta de dados</label>
                        <input type="date" name="data_expiracao" class="form-control">
						<small class="text-muted">
							Data limite para respostas
						</small>
                    </div> 
					
					<!-- Descrição -->
                    <div class="col-12">
                        <label class="form-label">Link do formulário da Pesquisa</label>
						<input type="text" name="link" class="form-control mt-2" placeholder="Link de pesquisa (site ou Google Forms)">
                    </div>
					
					<div class="alert alert-warning" role="alert">
						<div class="col-md-12">
							<input class="form-check-input" type="checkbox" value="aceito" id="termo">&nbsp;&nbsp;<b>Termo de Aceite</b>
							<label class="form-check-label" for="flexCheckDefault">
								O pesquisador acima indicado possui plenos poderes de representação pela pesquisa, assumindo, para todos os fins, quaisquer responsabilidades decorrentes do possível deferimento do Termo de Solicitação de Apoio  a Pesquisa, nos termos do Edital 01/2022. O interessado declara que estar ciente e dá plena concordância às condições contidas no Edital de Chamamento Público 01/2022, que encontra-se publicado no portal transparência do CRF/MG.
								
							</label>
						</div>
                    </div>
					
					

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        Enviar Solicitação
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function mostrarCampo() {
    let tipo = document.getElementById("tipo").value;
    let campo = document.getElementById("campo_descricao");

    if (tipo === "1") {
        campo.classList.remove("d-none");
    } else {
        campo.classList.add("d-none");
    }
}
</script>
<script>
	$("#formAdd").submit(async function(e) {
		e.preventDefault();
		
		
			console.log('Cadastrando Pesquisa...');
				
			try {
			
				var form = document.getElementById("formAdd");
				var fd = new FormData(form);
				//Adicionar ao FormData		
				
				console.log(fd);

				const result = await $.ajax({
						type: "POST",
						url: '<?=base_url()?>pesquisacientifica/enviar',
						data: fd,
						dataType: 'html',
						enctype: "multipart/form-data",
						contentType: false,
						processData: false,
						beforeSend: function() {
							console.log('Enviando dados...');
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

						$("#mensagemRetorno").text(retorno.msg);

						const modal = new bootstrap.Modal(document.getElementById('modalRetorno'));
						modal.show();
					});

				return result;
			} catch (error) {
				console.log('Erro geral:', error);
				return false;
			}	
	});
</script>

<!-- Modal -->
<div class="modal fade" id="modalRetorno" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
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
        window.location.href = "<?= base_url('restrito/palestrantes'); ?>";
    });

});
</script>
<?php endif; ?>