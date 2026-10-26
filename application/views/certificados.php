<meta charset="utf-8">
<title>Emissão de certificado — Portal Farma</title>
<style>
.cert-page{max-width:920px;margin:60px auto;padding:24px;color:#12455e}.cert-banner{background:#00598d;color:white;padding:30px;border-radius:16px}.cert-banner h1{font-size:30px}.cert-card{padding:28px;margin-top:24px;border:1px solid #cbd5e1;border-radius:14px;background:white}.cert-page button{padding:12px 20px;margin:8px 8px 8px 0;border:1px solid #00598d;border-radius:8px;background:#00598d;color:white;cursor:pointer}.cert-page button:disabled{opacity:.5;cursor:not-allowed}.cert-page input{display:block;padding:12px;margin:12px 0;width:100%;max-width:340px;border:1px solid #64748b;border-radius:8px}.cert-page input:disabled{background:#e2e8f0}.cert-modal{width:min(850px,94vw);padding:16px;border:0;border-radius:14px;max-height:94vh}.cert-modal::backdrop{background:#0009}.cert-modal iframe{display:block;width:100%;height:65vh;border:0}.cert-modal button{float:right;padding:8px}.cert-modal h2{font-size:22px}.cert-page [hidden]{display:none}
</style>
<main class="cert-page" id="cert-page" data-course-id="<?= (int) $curso->courseid ?>">
    <header class="cert-banner"><p>Portal Farma · CRF/MG</p><h1>Emissão de certificado</h1><h2><?= html_escape($curso->titulo) ?></h2></header>
    <section class="cert-card" id="cert-question" aria-labelledby="cert-question-title">
        <h3 id="cert-question-title">Deseja responder à Pesquisa de Satisfação deste evento antes de baixar seu certificado?</h3>
        <button type="button" id="cert-yes">Sim, responder</button><button type="button" id="cert-skip">Não / Pular</button>
    </section>
    <section class="cert-card">
        <p id="cert-help">Responda à pesquisa ou escolha “Não / Pular” para liberar o CPF.</p>
        <?php if (in_array((int) $curso->tipo_evento, [1, 2], true)): ?>
            <p id="cert-enrolment-help">O CPF informado será utilizado para verificar se você está matriculado neste curso no Moodle. O certificado será liberado somente após a confirmação da matrícula e da presença ou conclusão exigida para o curso.</p>
        <?php endif; ?>
        <form id="cert-form" action="<?= site_url('certificados/' . (int) $curso->courseid . '/baixar') ?>" method="post">
            <?php if ($this->config->item('csrf_protection')): ?><input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>"><?php endif; ?>
            <label for="cert-cpf">CPF do participante</label>
            <input id="cert-cpf" name="cpf" inputmode="numeric" autocomplete="off" placeholder="000.000.000-00" maxlength="14" required disabled aria-describedby="cert-help<?= in_array((int) $curso->tipo_evento, [1, 2], true) ? ' cert-enrolment-help' : '' ?>">
            <button id="cert-download" type="submit" disabled>Gerar / Baixar Certificado</button>
        </form>
        <p id="cert-feedback" role="status" aria-live="polite"></p>
    </section>
</main>
<dialog class="cert-modal" id="cert-modal" aria-labelledby="cert-modal-title">
    <button type="button" id="cert-close" aria-label="Fechar pesquisa">Fechar</button>
    <h2 id="cert-modal-title">Pesquisa de satisfação - <?= html_escape($curso->titulo) ?></h2>
    <iframe id="cert-nps" title="Formulário de pesquisa de satisfação" data-src="<?= site_url('nps/' . (int) $curso->courseid) ?>?embedded=1"></iframe>
</dialog>
<script src="<?= base_url('assets/js/certificados.js') ?>" defer></script>
