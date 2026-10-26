<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/restrito/painel.css')?>">
<style>
	.local-image-preview{width:100%;aspect-ratio:16/9;border:1px solid #e0e0e0;border-radius:12px;overflow:hidden;background:#f8f9fa}
	.local-image-preview img{width:100%;height:100%;object-fit:cover;display:block}
	.local-photo-upload{min-height:140px;border:1px dashed #b2ccff;border-radius:10px;background:#f9faff;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:18px;cursor:pointer;transition:.2s ease}
	.local-photo-upload:hover{border-color:#465fff;background:#f5f7ff}.local-photo-upload i{color:#465fff;font-size:30px;margin-bottom:8px}
	.local-photo-upload strong{color:#344054;font-size:14px}.local-photo-upload span{color:#667085;font-size:12px;margin-top:4px}
</style>

<?php
$edicao = isset($local) && !empty($local->id);
$dados = $edicao ? (array) $local : [];
$dadosTemporarios = $this->session->flashdata('local_dados');
$contextoLocal = $edicao ? 'editar:'.$local->id : 'cadastrar:'.($courseid ?? '');
$mesmoFormulario = $this->session->flashdata('local_contexto') === $contextoLocal;
$erroLocal = $mesmoFormulario ? $this->session->flashdata('local_erro') : null;
if ($mesmoFormulario && is_array($dadosTemporarios)) {
	$dados = array_merge($dados, $dadosTemporarios);
}
$this->session->unset_userdata(['local_erro', 'local_dados', 'local_contexto']);
$limiteUpload = (int) $limiteUpload;
$imagemX = 50;
$imagemY = 50;
?>
<div class="container py-4 tail-settings-page">
	<div class="tail-page-header">
		<div>
			<h2><?=$edicao ? 'Editar local' : 'Cadastrar local'?></h2>
			<p class="tail-page-subtitle"><?=$edicao ? 'Atualize os dados e a imagem do local.' : 'Cadastre um local da área de Uso Racional de Medicamentos.'?></p>
		</div>
		<a href="<?=base_url('restrito/urm/local')?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
	</div>

	<?php if ($erroLocal): ?>
		<div class="alert alert-danger"><?=htmlspecialchars($erroLocal, ENT_QUOTES, 'UTF-8')?></div>
	<?php endif; ?>

	<form method="post" action="<?=base_url('restrito/urm/local/salvar')?>" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$edicao ? (int) $local->id : ''?>">
		<div class="tail-settings-grid">
			<section class="tail-section-card">
				<div class="tail-section-header"><h3>Informações do local</h3><p>Dados de identificação, endereço, descrição e acesso.</p></div>
				<div class="tail-section-body">
					<div class="row g-3">
						<div class="col-12">
							<label for="courseidLocal" class="form-label">Curso URM (courseid) *</label>
							<select id="courseidLocal" name="courseid" class="form-select" required>
								<option value="">Selecione um curso URM</option>
								<?php $cursoSelecionado = (string) ($dados['courseid'] ?? $courseid ?? ''); ?>
								<?php foreach ($cursosUrm as $curso): ?>
									<option value="<?=htmlspecialchars((string) $curso->courseid, ENT_QUOTES, 'UTF-8')?>" <?=$cursoSelecionado === (string) $curso->courseid ? 'selected' : ''?>><?=htmlspecialchars($curso->courseid . ' - ' . $curso->titulo, ENT_QUOTES, 'UTF-8')?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">Título *</label>
							<input type="text" name="titulo" class="form-control" maxlength="180" value="<?=htmlspecialchars($dados['titulo'] ?? '', ENT_QUOTES, 'UTF-8')?>" required>
						</div>
						<div class="col-md-6">
							<label class="form-label">Cidade *</label>
							<input type="text" name="cidade" class="form-control" maxlength="120" value="<?=htmlspecialchars($dados['cidade'] ?? '', ENT_QUOTES, 'UTF-8')?>" required>
						</div>
						<div class="col-12">
							<label class="form-label">Descrição *</label>
							<textarea name="descricao" class="form-control" rows="7" required><?=htmlspecialchars($dados['descricao'] ?? '', ENT_QUOTES, 'UTF-8')?></textarea>
						</div>
						<div class="col-12">
							<label class="form-label">Link</label>
							<input type="url" name="link" class="form-control" maxlength="500" placeholder="https://..." value="<?=htmlspecialchars($dados['link'] ?? '', ENT_QUOTES, 'UTF-8')?>">
						</div>
					</div>
				</div>
			</section>

			<section class="tail-section-card">
				<div class="tail-section-header"><h3>Imagem do local</h3><p>Imagem utilizada para representar o local.</p></div>
				<div class="tail-section-body">
					<div id="previewContainer" class="local-image-preview mb-3<?=$edicao ? '' : ' d-none'?>">
					<img id="imagePreview" src="<?=$edicao ? base_url('uploads/urm_locais/'.rawurlencode($local->imagem_arquivo)) : ''?>" alt="Prévia da imagem" style="object-position:<?=$imagemX?>% <?=$imagemY?>%">
					</div>
					<label for="imagemLocal" class="local-photo-upload">
						<i class="bi bi-cloud-arrow-up"></i><strong><?=$edicao ? 'Clique para substituir a imagem' : 'Clique para enviar a imagem'?></strong><span>PNG, JPG ou WEBP — envio de até <?=number_format($limiteUpload / (1024 * 1024), 2, ',', '.')?> MB após o recorte</span>
					</label>
					<input type="file" name="imagem" id="imagemLocal" class="visually-hidden" accept="image/png,image/jpeg,image/webp" <?=$edicao ? '' : 'required'?>>
					<div class="mt-3" id="ajusteImagemLocal">
						<label for="imagemPosicaoX" class="form-label">Alinhamento horizontal: <output id="valorPosicaoX" for="imagemPosicaoX"><?=$imagemX?>%</output></label>
						<input type="range" id="imagemPosicaoX" class="form-range" min="0" max="100" step="1" value="<?=$imagemX?>" aria-describedby="ajudaEnquadramento">
						<div class="d-flex justify-content-between small text-muted"><span>Esquerda</span><span>Direita</span></div>
						<label for="imagemPosicaoY" class="form-label mt-3">Alinhamento vertical: <output id="valorPosicaoY" for="imagemPosicaoY"><?=$imagemY?>%</output></label>
						<input type="range" id="imagemPosicaoY" class="form-range" min="0" max="100" step="1" value="<?=$imagemY?>" aria-describedby="ajudaEnquadramento">
						<div class="d-flex justify-content-between small text-muted"><span>Topo</span><span>Base</span></div>
						<p class="small text-muted mt-2" id="ajudaEnquadramento">Ajuste o recorte na prévia. Ao salvar, será enviada apenas a área visível da foto, no formato 16:9. O movimento aparece no eixo em que houver corte.</p>
						<div id="erroRecorteImagem" class="text-danger small" role="alert"></div>
						<button type="button" id="centralizarImagemLocal" class="btn btn-sm btn-outline-secondary">Centralizar foto</button>
					</div>
				</div>
			</section>
		</div>
		<div class="tail-form-actions">
			<a href="<?=base_url('restrito/urm/local')?>" class="btn btn-outline-secondary">Cancelar</a>
			<button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i><?=$edicao ? 'Atualizar local' : 'Salvar local'?></button>
		</div>
	</form>
</div>
<script>
(function () {
    const imagem = document.getElementById('imagePreview');
    const horizontal = document.getElementById('imagemPosicaoX');
    const vertical = document.getElementById('imagemPosicaoY');
    const input = document.getElementById('imagemLocal');
    const formulario = input.form;
    const limiteUpload = <?=json_encode($limiteUpload)?>;
    let recorteAlterado = false;
    let recortePronto = false;
    let processando = false;
    let previewUrl = null;
    function atualizarPosicao() {
        recorteAlterado = true;
        recortePronto = false;
        imagem.style.objectPosition = horizontal.value + '% ' + vertical.value + '%';
        document.getElementById('valorPosicaoX').textContent = horizontal.value + '%';
        document.getElementById('valorPosicaoY').textContent = vertical.value + '%';
    }
    horizontal.addEventListener('input', atualizarPosicao);
    vertical.addEventListener('input', atualizarPosicao);
    document.getElementById('centralizarImagemLocal').addEventListener('click', function () {
        horizontal.value = vertical.value = '50';
        atualizarPosicao();
    });
    input.addEventListener('change', function () {
        const arquivo = this.files && this.files[0];
        if (!arquivo) return;
        if (previewUrl) URL.revokeObjectURL(previewUrl);
        previewUrl = URL.createObjectURL(arquivo);
        imagem.src = previewUrl;
        document.getElementById('previewContainer').classList.remove('d-none');
        atualizarPosicao();
    });
    formulario.addEventListener('submit', async function (evento) {
        if (recortePronto || (!input.files.length && !recorteAlterado)) return;
        evento.preventDefault();
        if (processando) return;
        processando = true;
        const botao = evento.submitter;
        const erro = document.getElementById('erroRecorteImagem');
        erro.textContent = '';
        if (botao) botao.disabled = true;
        try {
            await imagem.decode();
            const largura = imagem.naturalWidth;
            const altura = imagem.naturalHeight;
            if (!largura || !altura) throw new Error('Selecione uma foto válida para recortar.');
            const proporcao = 16 / 9;
            const larguraRecorte = Math.min(largura, altura * proporcao);
            const alturaRecorte = larguraRecorte / proporcao;
            const x = (largura - larguraRecorte) * Number(horizontal.value) / 100;
            const y = (altura - alturaRecorte) * Number(vertical.value) / 100;
            const canvas = document.createElement('canvas');
            const original = input.files[0];
            const tipo = original ? original.type : (/\.png(?:\?|$)/i.test(imagem.src) ? 'image/png' : /\.webp(?:\?|$)/i.test(imagem.src) ? 'image/webp' : 'image/jpeg');
            let larguraSaida = Math.min(1920, larguraRecorte);
            let blob = null;
            for (let tentativa = 0; tentativa < 8; tentativa++) {
                canvas.width = Math.max(1, Math.round(larguraSaida));
                canvas.height = Math.max(1, Math.round(larguraSaida / proporcao));
                canvas.getContext('2d').drawImage(imagem, x, y, larguraRecorte, alturaRecorte, 0, 0, canvas.width, canvas.height);
                blob = await new Promise(function (resolve) { canvas.toBlob(resolve, tipo, 0.9); });
                if (!blob) throw new Error('Não foi possível recortar a foto. Tente outra imagem.');
                if (blob.size <= limiteUpload) break;
                larguraSaida *= Math.min(0.8, Math.sqrt(limiteUpload / blob.size) * 0.9);
            }
            if (blob.size > limiteUpload) throw new Error('Não foi possível reduzir a foto ao limite do servidor. Selecione uma imagem menor.');
            const extensao = blob.type === 'image/png' ? 'png' : blob.type === 'image/webp' ? 'webp' : 'jpg';
            const arquivos = new DataTransfer();
            arquivos.items.add(new File([blob], 'local-recortado.' + extensao, {type: blob.type}));
            input.files = arquivos.files;
            recortePronto = true;
            if (botao) botao.disabled = false;
            if (botao) formulario.requestSubmit(botao);
            else formulario.requestSubmit();
        } catch (falha) {
            erro.textContent = falha.message || 'Não foi possível recortar a foto. Tente novamente.';
            if (botao) botao.disabled = false;
        } finally {
            processando = false;
        }
    });
})();
</script>
