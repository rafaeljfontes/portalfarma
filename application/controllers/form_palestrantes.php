<div class="container">
    <div class=" d-flex" style="display: flex; justify-content: space-between;">
        <div>
            <h2>Cadastro de Palestrante</h2>
        </div>
        <div>
            <a href="<?=base_url()?>restrito/palestrantes" class="btn btn-danger"><i class="fa fa-chevron-left"></i> voltar</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Para cadastrar/editar o palestrante, preencha o formulário abaixo:</div>
                <div class="card-body">
                    <?php
                    if(isset($edit)){
                        $edit = $edit[0];
                    }
                    ?>
                    <form id="form" enctype="multipart/form-data" autocomplete="off">
                        <?php
                        if(isset($edit) && !is_null($edit)){
                        ?>
                        <input type="hidden" value="<?=$edit->id_palestrante?>" name="id">
                        <?php
                        }
                        ?>
                        <div class="mb-3">
                            <label for="nome" class="form-label">* Nome</label>
                            <input type="text" class="form-control <?=(form_error('nome')) ? 'is-invalid' : ''; ?>" id="nome" name="nome" placeholder="Nome do palestrante (campo obrigatório)" value="<?=set_value('nome', isset($edit) && !is_null($edit) ? $edit->nome ?? '' : '')?>">
                            <?=form_error('nome','<small class="text-danger pull-right w-100" style="text-align:right">', '</small>'); ?>
                        </div>

                        <div class="mb-3">
                            <label for="curriculo" class="form-label">Mini-currículo</label>
                            <textarea class="form-control <?=(form_error('curriculo')) ? 'is-invalid' : ''; ?>" id="curriculo" rows="5" name="curriculo" placeholder="Mini currículo/apresentação (campo obrigatório)"><?=set_value('curriculo', isset($edit) && !is_null($edit) ? $edit->curriculo ?? '' : '')?></textarea>
                            <?=form_error('curriculo','<small class="text-danger pull-right w-100" style="text-align:right">', '</small>'); ?>
                        </div>
						
						<div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="link" class="form-label">E-mail </label>
                                    <input type="text" class="form-control <?=(form_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="E-mal necessário para busca dos certificados" value="<?=set_value('email', isset($edit) && !is_null($edit) ? $edit->email ?? '' : '')?>">
                                    <?=form_error('email','<small class="text-danger pull-right w-100" style="text-align:right">', '</small>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link (Lattes/Instagram) </label>
                                    <input type="text" class="form-control <?=(form_error('link')) ? 'is-invalid' : ''; ?>" id="link" name="link" placeholder="Lattes/Instagram" value="<?=set_value('link', isset($edit) && !is_null($edit) ? $edit->link ?? '' : '')?>">
                                    <?=form_error('link','<small class="text-danger pull-right w-100" style="text-align:right">', '</small>'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input class="form-control <?=(form_error('foto')) ? 'is-invalid' : ''; ?>" type="file" id="foto" name="foto" accept="image/png, image/jpeg">
                                    <?=form_error('foto','<small class="text-danger pull-right w-100" style="text-align:right">', '</small>'); ?>
                                </div>
                                <div style="width: 200px; height: 200px; border-radius: 50%;" >
                                    <!-- exibir foto aqui -->
									<?php
                                    if(isset($edit) && !is_null($edit) && !empty($edit->foto)){
                                    ?>
										<img id="preview" src="<?=$edit->foto?>" style="border-radius: 50%; width: 100%;">
									<?php
									} else {
									?>
										<img id="preview" src="#" style="border-radius: 50%; width: 100%;">
									<?php }	?>
                                </div>
                            </div>
                        </div>
                     
                        <button id="btn-send" type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Salvar</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    
    // 1. Preview da Foto
    document.getElementById('foto').addEventListener('change', function(event) {
        if (event.target.files && event.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    });

    // 2. Submissão via Ajax
    $("#form").on('submit', function(e) {
        e.preventDefault(); // Impede o reload da página

        // --- Validação Simples de Campos Obrigatórios ---
        let nome = $('#nome').val().trim();
        let curriculo = $('#curriculo').val().trim();

        if (nome === "" || curriculo === "") {
            Swal.fire({
                title: 'Campos Obrigatórios',
                text: 'Por favor, preencha o Nome e o Mini-currículo.',
                icon: 'warning',
                confirmButtonColor: '#0468aa'
            });
            return false;
		} else {
			// --- Preparação para o Envio ---
			let btn = $("#btn-send");
			btn.prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde...");
		}

		// FormData é necessário para enviar arquivos (foto)
        let formData = new FormData(this);
		
        console.log('salvando...');
        console.log(formData);

        $.ajax({
            url: "<?= base_url('restrito/palestrantes/salvar'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false, // Necessário para FormData
            contentType: false, // Necessário para FormData
            success: function(retorno) {
                // retorno deve ser um JSON: { status: 'success', mensagem: '...' }
                
                Swal.fire({
                    title: retorno.status === 'success' ? 'Sucesso!' : 'Atenção',
                    text: retorno.mensagem,
                    icon: retorno.status,
                    confirmButtonColor: '#0468aa'
                }).then(() => {
                    if (retorno.status === 'success') {
                        // Redireciona após o sucesso
                        window.location.href = "<?= base_url('restrito/palestrantes'); ?>";
                    }
                });
            },
            error: function(xhr, status, error) {
				// Isso vai te mostrar no console o erro real vindo do PHP
				console.error(xhr.responseText); 
				Swal.fire('Erro!', 'O servidor respondeu com erro. Verifique o console do navegador.', 'error');
			},
            complete: function() {
                btn.prop('disabled', false).html("<i class='fa fa-check'></i> Salvar");
            }
        });
    });
});
</script>
<script>
	/*<?php if($this->session->flashdata('retorno')): ?>
		let retorno = <?= json_encode($this->session->flashdata('retorno')); ?>;
		
		Swal.fire({
			title: retorno.status === 'success' ? 'Sucesso!' : 'Atenção',
			text: retorno.mensagem,
			icon: retorno.status, // dinâmico: 'success' ou 'error'
			confirmButtonColor: '#0468aa'
		});
	<?php endif; ?>
	
    // Script para exibir a foto antes do upload
    document.getElementById('foto').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    });
    
    $(function(){
        $("#form").submit(function(){
            $("#btn-send").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
        });
    });*/
	
	
</script>
