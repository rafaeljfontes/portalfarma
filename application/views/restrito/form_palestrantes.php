<?php
if(isset($edit)) $edit = $edit[0];
$temFotoAtual = isset($edit) && !is_null($edit) && !empty($edit->foto);
?>
<div class="container py-4 tail-settings-page">
	<div class="tail-page-header">
		<div>
			<h2><?=isset($edit) && !is_null($edit) ? 'Editar palestrante' : 'Cadastrar palestrante'?></h2>
			<p class="tail-page-subtitle">Gerencie as informações profissionais e a foto exibida no PortalFarma.</p>
		</div>
		<a href="<?=base_url()?>restrito/palestrantes" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
	</div>

	<form id="form" enctype="multipart/form-data" autocomplete="off">
		<?php if(isset($edit) && !is_null($edit)): ?>
			<input type="hidden" value="<?=$edit->id_palestrante?>" name="id">
		<?php endif; ?>

		<div class="tail-settings-grid">
			<section class="tail-section-card">
				<div class="tail-section-header">
					<h3>Informações pessoais</h3>
					<p>Dados públicos e profissionais do palestrante.</p>
				</div>
				<div class="tail-section-body">
					<div class="mb-4">
						<label for="nome" class="form-label">Nome completo *</label>
						<input type="text" class="form-control <?=(form_error('nome')) ? 'is-invalid' : ''; ?>" id="nome" name="nome" placeholder="Informe o nome completo" value="<?=set_value('nome', isset($edit) && !is_null($edit) ? $edit->nome ?? '' : '')?>">
						<?=form_error('nome','<small class="text-danger d-block mt-1">', '</small>'); ?>
					</div>

					<div class="row g-3 mb-4">
						<div class="col-md-6">
							<label for="email" class="form-label">E-mail</label>
							<input type="email" class="form-control <?=(form_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="nome@exemplo.com" value="<?=set_value('email', isset($edit) && !is_null($edit) ? $edit->email ?? '' : '')?>">
							<?=form_error('email','<small class="text-danger d-block mt-1">', '</small>'); ?>
						</div>
						<div class="col-md-6">
							<label for="link" class="form-label">Perfil profissional</label>
							<input type="text" class="form-control <?=(form_error('link')) ? 'is-invalid' : ''; ?>" id="link" name="link" placeholder="Lattes, LinkedIn ou Instagram" value="<?=set_value('link', isset($edit) && !is_null($edit) ? $edit->link ?? '' : '')?>">
							<?=form_error('link','<small class="text-danger d-block mt-1">', '</small>'); ?>
						</div>
					</div>

					<div>
						<label for="curriculo" class="form-label">Mini-currículo *</label>
						<textarea class="form-control <?=(form_error('curriculo')) ? 'is-invalid' : ''; ?>" id="curriculo" rows="8" name="curriculo" placeholder="Apresente a formação e a experiência profissional"><?=set_value('curriculo', isset($edit) && !is_null($edit) ? $edit->curriculo ?? '' : '')?></textarea>
						<div class="form-text">Este conteúdo será exibido na página pública do curso.</div>
						<?=form_error('curriculo','<small class="text-danger d-block mt-1">', '</small>'); ?>
					</div>
				</div>
			</section>

			<section class="tail-section-card">
				<div class="tail-section-header">
					<h3>Foto do palestrante</h3>
					<p>Envie e ajuste a imagem antes de salvar.</p>
				</div>
				<div class="tail-section-body">
					<div id="current-photo" class="current-photo" <?=$temFotoAtual ? '' : 'hidden'?>>
						<?php if($temFotoAtual): ?><img id="preview" src="<?=$edit->foto?>" alt="Foto atual do palestrante"><?php endif; ?>
					</div>
					<div class="photo-preview-wrap"><canvas id="photo-canvas" width="600" height="600" aria-label="Prévia do enquadramento da foto"></canvas></div>

					<label for="foto" class="photo-upload-box mt-3">
						<i class="bi bi-cloud-arrow-up"></i>
						<strong>Clique para enviar uma foto</strong>
						<span>JPG ou PNG, até 5 MB</span>
					</label>
					<input class="visually-hidden <?=(form_error('foto')) ? 'is-invalid' : ''; ?>" type="file" id="foto" name="foto" accept="image/png, image/jpeg">
					<?=form_error('foto','<small class="text-danger d-block mt-1">', '</small>'); ?>

					<div id="photo-controls" class="photo-controls" hidden>
						<label for="photo-zoom">Zoom</label><input id="photo-zoom" class="form-range" type="range" min="1" max="3" step="0.01" value="1">
						<label for="photo-horizontal">Horizontal</label><input id="photo-horizontal" class="form-range" type="range" min="-100" max="100" step="1" value="0">
						<label for="photo-vertical">Vertical</label><input id="photo-vertical" class="form-range" type="range" min="-100" max="100" step="1" value="0">
					</div>
				</div>
			</section>
		</div>

		<div class="tail-form-actions">
			<a href="<?=base_url()?>restrito/palestrantes" class="btn btn-outline-secondary">Cancelar</a>
			<button id="btn-send" type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Salvar palestrante</button>
		</div>
	</form>
</div>

<style>
.photo-preview-wrap { display: none; width: min(100%, 280px); aspect-ratio: 1; margin: 0 auto 1rem; border: 4px solid #fff; border-radius: 50%; overflow: hidden; background: #eef2f6; box-shadow: 0 0 0 1px #d0d5dd, 0 8px 20px rgba(16,24,40,.12); }
.photo-preview-wrap.is-visible { display: block; }
#photo-canvas { display: block; width: 100%; height: 100%; }
.photo-controls label { display: block; margin-top: .65rem; color: #52627a; font-weight: 700; }
.photo-controls .form-range { width: 100%; }
.current-photo { width: 180px; height: 180px; margin: 0 auto 1rem; border-radius: 50%; overflow: hidden; border: 4px solid #fff; box-shadow: 0 0 0 1px #d0d5dd, 0 8px 20px rgba(16,24,40,.12); }
.current-photo img { width: 100%; height: 100%; object-fit: cover; }
.photo-upload-box { min-height: 126px; border: 1px dashed #b2ccff; border-radius: 10px; background: #f9faff; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 18px; color: #344054; cursor: pointer; transition: .2s ease; }
.photo-upload-box:hover { border-color: #465fff; background: #f5f7ff; }
.photo-upload-box i { color: #465fff; font-size: 28px; margin-bottom: 7px; }
.photo-upload-box strong { font-size: 14px; }
.photo-upload-box span { color: #667085; font-size: 12px; margin-top: 3px; }
</style>

<script>
$(document).ready(function() {
    const inputFoto = document.getElementById('foto');
    const canvas = document.getElementById('photo-canvas');
    const context = canvas.getContext('2d');
    const previewWrap = document.querySelector('.photo-preview-wrap');
    const controls = document.getElementById('photo-controls');
    const currentPhoto = document.getElementById('current-photo');
    const zoom = document.getElementById('photo-zoom');
    const horizontal = document.getElementById('photo-horizontal');
    const vertical = document.getElementById('photo-vertical');
    let cropImage = null;

    function drawCrop() {
        if (!cropImage) return;

        const baseScale = Math.max(canvas.width / cropImage.naturalWidth, canvas.height / cropImage.naturalHeight);
        const scale = baseScale * Number(zoom.value);
        const width = cropImage.naturalWidth * scale;
        const height = cropImage.naturalHeight * scale;
        const maxX = Math.max(0, (width - canvas.width) / 2);
        const maxY = Math.max(0, (height - canvas.height) / 2);
        const x = (canvas.width - width) / 2 + maxX * Number(horizontal.value) / 100;
        const y = (canvas.height - height) / 2 + maxY * Number(vertical.value) / 100;

        context.clearRect(0, 0, canvas.width, canvas.height);
        context.drawImage(cropImage, x, y, width, height);
    }

    inputFoto.addEventListener('change', function(event) {
        const file = event.target.files && event.target.files[0];
        if (!file) return;
        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            Swal.fire('Atenção', 'Selecione uma imagem JPG ou PNG.', 'warning');
            inputFoto.value = '';
            return;
        }
        if (file.size > 5242880) {
            Swal.fire('Atenção', 'A foto selecionada é muito pesada. Limite: 5MB.', 'warning');
            inputFoto.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const image = new Image();
            image.onload = function() {
                cropImage = image;
                zoom.value = 1;
                horizontal.value = 0;
                vertical.value = 0;
                previewWrap.classList.add('is-visible');
                controls.hidden = false;
                currentPhoto.hidden = true;
                drawCrop();
            };
            image.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    [zoom, horizontal, vertical].forEach(function(control) {
        control.addEventListener('input', drawCrop);
    });

    // 2. Submissão via Ajax
    $("#form").on('submit', function(e) {
        e.preventDefault(); // Impede o reload da página

        // --- Validação Simples de Campos Obrigatórios ---
        let nome = $('#nome').val().trim();
        let curriculo = $('#curriculo').val().trim();
		let btn = $("#btn-send");

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
			btn.prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde...");
		}
		
        const form = this;
        function sendForm(croppedBlob) {
            let formData = new FormData(form);
            if (croppedBlob) {
                formData.set('foto', croppedBlob, 'foto_enquadrada.jpg');
            }
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
				console.error(xhr.responseText);
				let retorno = xhr.responseJSON;
				if (!retorno && xhr.responseText) {
					try { retorno = JSON.parse(xhr.responseText); } catch (e) {}
				}
				Swal.fire(
					retorno && retorno.status === 'error' ? 'Atenção' : 'Erro!',
					retorno && retorno.mensagem ? retorno.mensagem : 'Não foi possível salvar o palestrante. Tente novamente.',
					retorno && retorno.status === 'error' ? 'warning' : 'error'
				);
			},
            complete: function() {
				btn.prop('disabled', false).html("<i class='bi bi-check-lg me-1'></i> Salvar palestrante");
            }
        });
		}

		if (cropImage) {
			canvas.toBlob(function(blob) {
				if (!blob) {
					btn.prop('disabled', false).html("<i class='bi bi-check-lg me-1'></i> Salvar palestrante");
					Swal.fire('Erro!', 'Não foi possível preparar a foto para envio.', 'error');
					return;
				}
				sendForm(blob);
			}, 'image/jpeg', 0.9);
		} else {
			sendForm(null);
		}
    });
});
</script>
