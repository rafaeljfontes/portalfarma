<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold text-secondary">
                <?= isset($edit) ? 'Editar Plenária' : 'Cadastro de Plenária'; ?>
            </h2>
        </div>
        <div>
            <a href="<?=base_url()?>restrito/plenaria/listar" class="btn btn-danger">
                <i class="fa fa-chevron-left"></i> voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light fw-bold text-muted">
                    Para cadastrar/editar a plenária, preencha o formulário abaixo:
                </div>
                <div class="card-body">
                    <?php
                        // Ajuste para pegar o objeto dentro do array se vier do banco
                        if(isset($edit) && is_array($edit)){
                            $edit = $edit[0];
                        }
                    ?>
                    
                    <form id="form" enctype="multipart/form-data" autocomplete="off">
                        
                        <?php if(isset($edit) && !is_null($edit)): ?>
                            <input type="hidden" value="<?=$edit->id?>" name="id">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="titulo" class="form-label fw-bold">* Título</label>
                            <input type="text" 
                                   class="form-control <?=(form_error('titulo')) ? 'is-invalid' : ''; ?>" 
                                   id="titulo" name="titulo" 
                                   placeholder="Título da plenária técnica" 
                                   value="<?=set_value('titulo', $edit->titulo ?? '')?>" required>
                            <?=form_error('titulo','<small class="text-danger">', '</small>'); ?>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="link_youtube" class="form-label fw-bold">Link Youtube</label>
                                    <input type="url" 
                                           class="form-control <?=(form_error('link_youtube')) ? 'is-invalid' : ''; ?>" 
                                           id="link_youtube" name="link_youtube" 
                                           placeholder="https://youtube.com/..." 
                                           value="<?=set_value('link_youtube', $edit->link_youtube ?? '')?>">
                                    <?=form_error('link_youtube','<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
								<div class="mb-3">
									<label for="data_plenaria" class="form-label fw-bold">* Data da Plenária</label>
									<input type="date" 
										   class="form-control <?=(form_error('data_plenaria')) ? 'is-invalid' : ''; ?>" 
										   id="data_plenaria" name="data_plenaria" 
										   value="<?= set_value('data_plenaria', (isset($edit->data_plenaria) && !empty($edit->data_plenaria)) ? date('Y-m-d', strtotime($edit->data_plenaria)) : '') ?>" required>
									<?=form_error('data_plenaria','<small class="text-danger">', '</small>'); ?>
								</div>
							</div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end">
                            <button id="btn-send" type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="fa fa-check"></i> Salvar Alterações
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#form").on('submit', function(e) {
        e.preventDefault();

        // Validação básica
        if ($('#titulo').val() == "" || $('#data_plenaria').val() == "") {
            Swal.fire('Atenção', 'Título e Data são campos obrigatórios.', 'warning');
            return false;
        }

        let btn = $("#btn-send");
        btn.prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde...");

        let formData = new FormData(this);

        $.ajax({
            url: "<?= base_url('restrito/plenaria/salvar'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(retorno) {
                Swal.fire({
                    title: retorno.status === 'success' ? 'Sucesso!' : 'Erro',
                    text: retorno.mensagem,
                    icon: retorno.status,
                    confirmButtonColor: '#0468aa'
                }).then(() => {
                    if (retorno.status === 'success') {
                        window.location.href = "<?= base_url('restrito/plenaria/listar'); ?>";
                    }
                });
            },
            error: function() {
                Swal.fire('Erro!', 'Não foi possível salvar os dados.', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html("<i class='fa fa-check'></i> Salvar Alterações");
            }
        });
    });
});
</script>