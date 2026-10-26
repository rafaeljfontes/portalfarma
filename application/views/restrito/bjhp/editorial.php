<link rel="stylesheet" href="<?= base_url('assets/css/bjhp-editorial.css') ?>?v=2">
<div class="container py-4 tail-settings-page">
    <div class="tail-page-header"><div>
        <h2>BJHP — <?= $membro ? 'Editar' : 'Cadastrar' ?> Corpo Editorial</h2>
        <p class="tail-page-subtitle">Gerencie as informações profissionais e a foto do membro do corpo editorial.</p>
    </div><a href="<?= base_url('restrito/bjhp/corpo_editorial') ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Voltar</a></div>
    <div id="bjhp-alert" role="alert" aria-live="polite" class="d-none"></div>
    <?= form_open_multipart('restrito/bjhp/salvar_editorial', array('id' => 'bjhp-form')) ?>
        <input type="hidden" name="bjhp_csrf" value="<?= html_escape($this->session->userdata('bjhp_csrf')) ?>">
        <input type="hidden" name="id" value="<?= (int) ($membro['id'] ?? 0) ?>">
        <div class="tail-settings-grid">
        <section class="tail-section-card">
        <div class="tail-section-header"><h3>Informações do membro</h3><p>Identificação, atuação profissional e contato. Campos com * são obrigatórios.</p></div>
        <div class="tail-section-body"><div class="row g-3">
            <div class="col-md-6">
                <label for="categoria" class="form-label">Categoria *</label>
                <select id="categoria" name="categoria" class="form-select" required>
                    <option value="">Selecione</option>
                    <?php foreach ($categorias as $valor => $rotulo): ?>
                        <option value="<?= html_escape($valor) ?>" <?= ($membro['categoria'] ?? '') === $valor ? 'selected' : '' ?>><?= html_escape($rotulo) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php foreach (array(
                'nome' => array('Nome *', 255), 'titulacao' => array('Titulação', 100),
                'instituicao' => array('Instituição', 500), 'cidade' => array('Cidade', 150),
                'estado' => array('Estado', 150), 'pais' => array('País', 100),
                'orcid_url' => array('ORCID', 255),
                'email' => array('E-mail', 255)
            ) as $campo => $info): ?>
                <div class="col-md-6">
                    <label for="<?= $campo ?>" class="form-label"><?= $info[0] ?></label>
                    <input id="<?= $campo ?>" name="<?= $campo ?>" class="form-control"
                        type="<?= $campo === 'email' ? 'email' : ($campo === 'orcid_url' ? 'url' : 'text') ?>"
                        maxlength="<?= $info[1] ?>" <?= $campo === 'nome' ? 'required' : '' ?>
                        <?= $campo === 'orcid_url' ? 'placeholder="https://orcid.org/0000-0000-0000-0000"' : '' ?>
                        value="<?= html_escape($membro[$campo] ?? '') ?>">
                </div>
            <?php endforeach; ?>
            <div class="col-12">
                <label for="mini_curriculo" class="form-label">Minicurrículo</label>
                <textarea id="mini_curriculo" name="mini_curriculo" class="form-control" rows="6" maxlength="65535"><?= html_escape($membro['mini_curriculo'] ?? '') ?></textarea>
            </div>
            <div class="col-md-6">
                <label for="ordem_exibicao" class="form-label">Ordem de exibição *</label>
                <input id="ordem_exibicao" name="ordem_exibicao" type="number" class="form-control" min="0" max="65535" step="1" value="<?= (int) ($membro['ordem_exibicao'] ?? 0) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">Status *</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="ativo" <?= ($membro['status'] ?? 'ativo') === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                    <option value="inativo" <?= ($membro['status'] ?? '') === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        </div></div>
        </section>
        <aside class="tail-section-card">
            <div class="tail-section-header"><h3>Foto do membro</h3><p>Selecione uma foto para identificar o membro do corpo editorial.</p></div>
            <div class="tail-section-body">
                <div class="bjhp-photo-preview mb-3">
                    <img id="bjhp-photo-preview" alt="Foto atual ou prévia da foto selecionada" <?= !empty($membro['foto']) ? 'src="' . html_escape(base_url($membro['foto'])) . '"' : 'hidden' ?>>
                    <span id="bjhp-photo-placeholder" <?= !empty($membro['foto']) ? 'hidden' : '' ?>><i class="bi bi-person-circle"></i><br>Prévia da foto</span>
                </div>
                <label for="foto" class="bjhp-photo-upload">
                    <i class="bi bi-cloud-arrow-up"></i><strong>Selecionar foto</strong>
                    <span>PNG ou JPG • Até 2 MB</span>
                </label>
                <input type="file" id="foto" name="foto" class="form-control mt-3" accept=".png,.jpg,.jpeg,image/png,image/jpeg" aria-describedby="bjhp-photo-help">
                <p id="bjhp-photo-help" class="small text-muted mt-2"><?= $membro ? 'Foto opcional. Deixe em branco para manter a imagem atual.' : 'Foto opcional. A imagem será enviada ao salvar o cadastro.' ?></p>
                <div id="bjhp-photo-error" class="text-danger small" role="alert"></div>
            </div>
        </aside>
        </div>
        <div class="d-flex justify-content-end mt-4"><button id="bjhp-submit" class="btn btn-primary" type="submit"><?= $membro ? 'Salvar alterações' : 'Cadastrar Corpo Editorial' ?></button></div>
    </form>
</div>
<script src="<?= base_url('assets/js/bjhp.js') ?>?v=2"></script>
<script src="<?= base_url('assets/js/bjhp-editorial.js') ?>?v=2"></script>
