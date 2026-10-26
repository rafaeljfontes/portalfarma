<style>
.doc-upload{min-height:140px;border:1px dashed #b2ccff;border-radius:10px;background:#f9faff;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:18px;cursor:pointer;transition:.2s ease}
.doc-upload:hover{border-color:#465fff;background:#f5f7ff}.doc-upload i{color:#465fff;font-size:30px;margin-bottom:8px}.doc-upload strong{color:#344054;font-size:14px}.doc-upload span{color:#667085;font-size:12px;margin-top:4px}
.doc-preview{position:relative;width:100%;aspect-ratio:3/4;max-height:390px;border:1px solid #e0e0e0;border-radius:12px;overflow:hidden;background:#f8f9fa;transition:.3s ease}
.doc-preview:hover{transform:translateY(-5px);box-shadow:0 10px 20px rgba(0,0,0,.1)}.doc-preview img{width:100%;height:100%;object-fit:contain}
.doc-file-info{margin-top:12px;padding:12px;background:#f9fafb;border:1px solid #e4e7ec;border-radius:8px;color:#667085;font-size:12px;overflow-wrap:anywhere}
</style>
<?php $edicao = !empty($documento); ?>
<div class="container py-4 tail-settings-page">
    <div class="tail-page-header">
        <div>
            <h2><?=$edicao ? 'Editar documento técnico' : 'Cadastrar documento técnico'?></h2>
            <p class="tail-page-subtitle">Gerencie o título, a capa e o arquivo exibidos no PortalFarma.</p>
        </div>
        <a href="<?=base_url('restrito/doc_tecnico/listar')?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Voltar
        </a>
    </div>

    <?php if ($this->session->flashdata('doc_erro')): ?>
        <div class="alert alert-danger"><?=$this->session->flashdata('doc_erro')?></div>
    <?php endif; ?>

    <?=form_open_multipart('restrito/doc_tecnico/salvar', ['id' => 'formDocumento'])?>
        <input type="hidden" name="id" value="<?=$edicao ? (int)$documento->id : ''?>">

        <div class="tail-settings-grid">
            <section class="tail-section-card">
                <div class="tail-section-header">
                    <h3>Informações do documento</h3>
                    <p>Dados de identificação e arquivo disponibilizado para leitura.</p>
                </div>
                <div class="tail-section-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="titulo" class="form-label">Título *</label>
                            <input type="text" id="titulo" name="titulo" class="form-control"
                                maxlength="255" required autocomplete="off"
                                value="<?=$edicao ? html_escape($documento->titulo) : ''?>">
                            <small class="text-muted">Este título será mostrado na página pública.</small>
                        </div>
                        <div class="col-12">
                            <label for="arquivo" class="doc-upload">
                                <i class="bi bi-file-earmark-pdf"></i>
                                <strong><?=$edicao ? 'Atualizar documento PDF' : 'Clique para enviar o documento'?></strong>
                                <span>Somente PDF — tamanho máximo de 20 MB</span>
                            </label>
                            <input type="file" name="arquivo" id="arquivo" class="visually-hidden"
                                accept="application/pdf" <?=$edicao ? '' : 'required'?>>
                            <div class="doc-file-info">
                                <small>Arquivo selecionado</small><br>
                                <strong id="pdfFileName"><?=$edicao ? html_escape($documento->arquivo) : 'Nenhum arquivo selecionado'?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tail-section-card">
                <div class="tail-section-header">
                    <h3>Capa do documento</h3>
                    <p>Imagem utilizada no card da página de documentos técnicos.</p>
                </div>
                <div class="tail-section-body">
                    <div id="previewContainer" class="doc-preview <?=$edicao ? '' : 'd-none'?>">
                        <img id="coverPreview"
                            src="<?=$edicao ? base_url('uploads/doc_tecnico/'.$documento->capa) : '#';?>"
                            alt="Prévia da capa">
                    </div>
                    <label for="capa" class="doc-upload mt-3">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <strong><?=$edicao ? 'Atualizar capa' : 'Clique para enviar a capa'?></strong>
                        <span>PNG, JPG ou WEBP — formato vertical recomendado</span>
                    </label>
                    <input type="file" name="capa" id="capa" class="visually-hidden"
                        accept="image/png,image/jpeg,image/webp" <?=$edicao ? '' : 'required'?>>
                    <div class="doc-file-info">
                        <small>Imagem selecionada</small><br>
                        <strong id="coverFileName"><?=$edicao ? html_escape($documento->capa) : 'Nenhuma imagem selecionada'?></strong>
                    </div>
                </div>
            </section>
        </div>

        <div class="tail-form-actions">
            <a href="<?=base_url('restrito/doc_tecnico/listar')?>" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-lg me-1"></i>Salvar documento
            </button>
        </div>
    <?=form_close()?>
</div>

<script>
document.getElementById('arquivo').addEventListener('change', function () {
    document.getElementById('pdfFileName').textContent = this.files[0] ? this.files[0].name : 'Nenhum arquivo selecionado';
});
document.getElementById('capa').addEventListener('change', function () {
    const file = this.files[0];
    document.getElementById('coverFileName').textContent = file ? file.name : 'Nenhuma imagem selecionada';
    if (!file) return;
    const preview = document.getElementById('coverPreview');
    preview.src = URL.createObjectURL(file);
    document.getElementById('previewContainer').classList.remove('d-none');
});
</script>
