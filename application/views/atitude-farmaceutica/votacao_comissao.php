<?php defined('BASEPATH') OR exit('No direct script access allowed');
$criterios = array(
    'relevancia' => 'Relevância da iniciativa',
    'impacto' => 'Impacto gerado',
    'pessoas' => 'Número de pessoas alcançadas',
    'duracao' => 'Duração/continuidade da iniciativa',
    'beneficios' => 'Benefícios alcançados'
);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Votação da comissão — Atitude Farmacêutica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f4f7fa; }
        .comissao { max-width: 1100px; margin: auto; padding: 180px 24px 70px; color: #34465a; }
        .comissao h1, .comissao h2, .comissao h3 { color: #12455e; font-weight: 700; }
        .comissao h2 { font-size: 25px; }
        .comissao h3 { font-size: 17px; }
        .comissao-card { background: #fff; border: 1px solid #dce5ef; border-radius: 16px; padding: 26px; margin: 24px 0; box-shadow: 0 4px 16px #12455e08; }
        .comissao-imagem { width: 100%; max-height: 360px; object-fit: cover; aspect-ratio: 16/9; border-radius: 10px; margin-bottom: 20px; }
        .comissao-texto { white-space: pre-wrap; overflow-wrap: anywhere; line-height: 1.65; }
        .comissao details summary { cursor: pointer; color: #12455e; font-weight: 600; padding: 10px 0; }
        .comissao details dl { margin-top: 14px; }
        .comissao details dt { color: #12455e; margin-top: 12px; }
        .comissao fieldset { border: 0; border-top: 1px solid #e6edf2; padding: 16px 0 0; margin: 18px 0 0; min-width: 0; }
        .comissao legend { float: none; font-size: 16px; font-weight: 600; margin: 0 0 10px; }
        .comissao-escala { display: flex; gap: 12px; flex-wrap: wrap; }
        .comissao-nota { display: inline-flex; align-items: center; justify-content: center; gap: 7px; min-width: 58px; padding: 10px; border: 1px solid #c4d2df; border-radius: 9px; cursor: pointer; }
        .comissao-nota:has(input:checked) { background: #12455e; color: #fff; border-color: #12455e; }
        .comissao-nota:focus-within { outline: 3px solid #8ab9d1; outline-offset: 2px; }
        .comissao-nota input { accent-color: #12455e; }
        .comissao-enviar { border: 0; border-radius: 10px; background: #12455e; color: white; padding: 13px 24px; font-weight: 700; }
        .comissao-enviar:disabled { opacity: .5; cursor: not-allowed; }
        .comissao-progresso { position: sticky; top: 120px; z-index: 5; background: #edf4f8; border: 1px solid #dce5ef; border-radius: 12px; padding: 14px 18px; }
        @media(max-width: 768px) { .comissao { padding: 115px 14px 40px; } .comissao-card { padding: 18px; } .comissao-progresso { position: static; } .comissao-escala { gap: 7px; } .comissao-nota { min-width: 45px; padding: 9px 6px; } }
    </style>
</head>
<body>
<?php $this->load->view('fixo/cabecalho'); ?>
<main class="comissao">
    <a href="<?= site_url('atitude_farmaceutica') ?>" class="btn btn-outline-primary mb-4">VOLTAR</a>
    <h1>Votação da comissão</h1>
    <p>O acesso é exclusivo aos membros previamente cadastrados na comissão. Após identificar seu e-mail, avalie todos os projetos aprovados.</p>
    <?php if (!$membroComissao): ?>
        <form id="identificar-comissao" class="comissao-card" action="<?= site_url('atitude_farmaceutica/votacao_comissao/identificar') ?>" method="post">
            <input type="hidden" name="token" value="<?= html_escape($tokenComissao) ?>">
            <input type="hidden" id="identificar-csrf" name="<?= html_escape($this->security->get_csrf_token_name()) ?>" value="<?= html_escape($this->security->get_csrf_hash()) ?>">
            <label for="identificar-email" class="form-label fw-bold">E-mail cadastrado na comissão</label>
            <input id="identificar-email" class="form-control mb-3" type="email" name="email" maxlength="254" autocomplete="email" required>
            <button type="submit" class="comissao-enviar">Acessar votação</button>
        </form>
    <?php elseif (!$projetosAceitos): ?>
        <p class="alert alert-info">Ainda não há projetos aprovados para avaliação.</p>
    <?php else: ?>
    <form id="form-comissao" action="<?= site_url('atitude_farmaceutica/votacao_comissao/salvar') ?>" method="post">
        <input type="hidden" name="token" value="<?= html_escape($tokenComissao) ?>">
        <input type="hidden" id="comissao-csrf" name="<?= html_escape($this->security->get_csrf_token_name()) ?>" value="<?= html_escape($this->security->get_csrf_hash()) ?>">
        <div class="comissao-card">
            <h2>Olá, <?= html_escape($membroComissao->nome) ?>!</h2>
            <label for="comissao-email" class="form-label fw-bold">E-mail autorizado</label>
            <input id="comissao-email" class="form-control" type="email" name="email" value="<?= html_escape($membroComissao->email) ?>" readonly required aria-describedby="comissao-email-ajuda">
            <small id="comissao-email-ajuda">Atribua notas de 1 a 5 em todos os critérios. É permitido um envio por e-mail.</small>
        </div>
        <div class="comissao-progresso" id="comissao-progresso" role="status" aria-live="polite">0 de <?= count($projetosAceitos) ?> projetos avaliados</div>
        <?php foreach ($projetosAceitos as $projeto): $id = (int) $projeto->id;
            $imagem = $projeto->imagem_principal;
        ?>
        <article class="comissao-card" data-projeto="<?= $id ?>" aria-labelledby="comissao-projeto-<?= $id ?>">
            <?php if (is_string($imagem) && preg_match('/\A[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)\z/i', $imagem)): ?>
                <img class="comissao-imagem" src="<?= html_escape(base_url('uploads/atitude-farmaceutica/' . rawurlencode($imagem))) ?>" alt="<?= html_escape($projeto->nome_projeto) ?>" loading="lazy">
            <?php endif; ?>
            <h2 id="comissao-projeto-<?= $id ?>"><?= html_escape($projeto->nome_projeto) ?></h2>
            <p class="comissao-texto"><?= html_escape($projeto->resumo_projeto ?? '') ?></p>
            <details>
                <summary>Ver informações do projeto</summary>
                <dl>
                    <?php foreach (array('Eixo' => 'eixo_projeto', 'Cidade' => 'cidade_projeto', 'Espaço de realização do projeto' => 'local_projeto', 'Data de início' => 'data_inicio', 'Descrição' => 'descricao_projeto', 'Justificativa' => 'justificativa', 'Participantes' => 'numero_pessoas', 'Pessoas alcançadas' => 'pessoas_alcancadas', 'Recursos' => 'recursos', 'Benefícios alcançados' => 'beneficios_alcancados', 'Objetivos alcançados' => 'objetivos_alcancados') as $rotulo => $campo): ?>
                        <dt><?= html_escape($rotulo) ?></dt>
                        <dd class="comissao-texto"><?= html_escape(trim((string) ($projeto->$campo ?? '')) ?: 'Não informado') ?></dd>
                    <?php endforeach; ?>
                </dl>
                <div class="row g-2">
                    <?php $imagens = json_decode($projeto->imagens ?? '[]', true);
                    foreach (is_array($imagens) ? $imagens : array() as $foto):
                        if (!is_string($foto) || !preg_match('/\A[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)\z/i', $foto)) continue;
                        $url = base_url('uploads/atitude-farmaceutica/' . rawurlencode($foto)); ?>
                        <a class="col-6 col-md-4" href="<?= html_escape($url) ?>" target="_blank" rel="noopener noreferrer"><img class="img-fluid rounded" src="<?= html_escape($url) ?>" alt="Imagem do projeto <?= html_escape($projeto->nome_projeto) ?>" loading="lazy"></a>
                    <?php endforeach; ?>
                </div>
            </details>
            <p class="small">Atribua uma nota de 1 a 5 em cada critério.</p>
            <p class="small text-muted fst-italic mt-1 mb-3"><strong>Nota:</strong> <strong>1</strong> representa a menor nota (Péssimo) e <strong>5</strong> a maior nota (Ótimo).</p>
            <?php foreach ($criterios as $criterio => $rotulo): ?>
                <fieldset>
                    <legend><?= html_escape($rotulo) ?></legend>
                    <div class="comissao-escala">
                        <?php for ($nota = 1; $nota <= 5; $nota++): ?>
                            <label class="comissao-nota"><input type="radio" name="notas[<?= $id ?>][<?= $criterio ?>]" value="<?= $nota ?>" required><span><?= $nota ?></span></label>
                        <?php endfor; ?>
                    </div>
                </fieldset>
            <?php endforeach; ?>
        </article>
        <?php endforeach; ?>
        <p id="comissao-instrucao">Preencha seu e-mail e todos os critérios para liberar o envio.</p>
        <button class="comissao-enviar" id="comissao-enviar" type="submit" disabled>Enviar avaliação</button>
    </form>
    <?php endif; ?>
</main>
<?php $this->load->view('fixo/rodape'); ?>
<?php if (!$membroComissao): ?>
<script>
document.getElementById('identificar-comissao').addEventListener('submit', async function(event) {
    event.preventDefault();
    if (!this.reportValidity()) return;
    const botao = this.querySelector('button');
    if (botao.disabled) return;
    botao.disabled = true;
    try {
        const response = await fetch(this.action, { method: 'POST', body: new FormData(this), credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        let data;
        try { data = await response.json(); } catch (error) { throw new Error('Atualize a página e tente novamente.'); }
        if (data.csrf_hash) { const csrf = document.getElementById('identificar-csrf'); csrf.name = data.csrf_name; csrf.value = data.csrf_hash; }
        if (response.redirected || !response.ok || !data.status) throw new Error(data.message || 'Não foi possível liberar o acesso.');
        window.location.reload();
    } catch (error) {
        await Swal.fire({ icon: 'error', title: 'Acesso não liberado', text: error.message });
    } finally { botao.disabled = false; }
});
</script>
<?php endif; ?>
<?php if ($projetosAceitos): ?>
<script>
(() => {
    const form = document.getElementById('form-comissao');
    const email = document.getElementById('comissao-email');
    const botao = document.getElementById('comissao-enviar');
    const projetos = Array.from(form.querySelectorAll('[data-projeto]'));
    let enviando = false, concluido = false;
    function atualizar() {
        const total = projetos.filter(projeto => projeto.querySelectorAll('input[type="radio"]:checked').length === 5).length;
        document.getElementById('comissao-progresso').textContent = `${total} de ${projetos.length} projetos avaliados`;
        botao.disabled = concluido || enviando || !email.validity.valid || total !== projetos.length;
    }
    form.addEventListener('input', atualizar);
    form.addEventListener('change', atualizar);
    form.addEventListener('submit', async event => {
        event.preventDefault();
        if (enviando || concluido || !form.reportValidity()) return;
        if (projetos.some(projeto => projeto.querySelectorAll('input[type="radio"]:checked').length !== 5)) return;
        const body = new FormData(form);
        enviando = true; atualizar();
        const controles = Array.from(form.querySelectorAll('input'));
        controles.forEach(input => { input.disabled = true; });
        try {
            const response = await fetch(form.action, { method: 'POST', body, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (response.redirected) throw new Error('Sua sessão expirou. Atualize a página e tente novamente.');
            let data;
            try { data = await response.json(); }
            catch (error) { throw new Error('Não foi possível processar a avaliação. Atualize a página e tente novamente.'); }
            if (data.csrf_hash) {
                const csrf = document.getElementById('comissao-csrf');
                csrf.name = data.csrf_name; csrf.value = data.csrf_hash;
            }
            if (!response.ok || !data.status) throw new Error(data.message || 'Não foi possível registrar a avaliação.');
            concluido = true;
            document.getElementById('comissao-instrucao').textContent = 'Sua avaliação foi registrada. Obrigado pela participação!';
            await Swal.fire({ icon: 'success', title: 'Voto registrado com sucesso!', confirmButtonColor: '#12455e' });
        } catch (error) {
            await Swal.fire({ icon: 'error', title: 'Avaliação não registrada', text: error.message, confirmButtonColor: '#12455e' });
        } finally {
            enviando = false;
            controles.forEach(input => { input.disabled = concluido; });
            atualizar();
        }
    });
    atualizar();
})();
</script>
<?php endif; ?>
</body>
</html>
