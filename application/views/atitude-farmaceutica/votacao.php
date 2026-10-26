<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Votação popular — Atitude Farmacêutica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f4f7fa; }
        .atitude-votacao { max-width: 1350px; margin: 0 auto; padding: 190px 24px 150px; }
        .atitude-votacao h1 { color: #12455e; font-weight: 700; }
        .atitude-eleitor { padding: 24px; background: #fff; border: 1px solid #dce5ef; border-radius: 16px; margin: 24px 0; }
        .atitude-eleitor label { color: #12455e; font-weight: 700; }
        .atitude-votar-flutuante { position: fixed; bottom: 24px; right: 24px; z-index: 1030; display: flex; align-items: center; gap: 16px; padding: 14px 20px; border-radius: 18px; background: #fff; border: 1px solid #dce5ef; box-shadow: 0 8px 32px rgba(18, 69, 94, .22); }
        .atitude-votar-flutuante button { background: #12455e; color: #fff; border: 0; border-radius: 12px; padding: 12px 24px; font-weight: 700; }
        .atitude-votar-flutuante button:disabled { opacity: .5; cursor: not-allowed; }
        .atitude-voto-avaliacao { border-top: 1px solid #dce5ef; padding-top: 16px; margin-bottom: 20px; }
        .atitude-voto-criterio { border: 0; margin: 0 0 18px; padding: 0; min-width: 0; }
        .atitude-voto-criterio legend { float: none; color: #12455e; font-size: 15px; font-weight: 600; margin-bottom: 8px; }
        .atitude-voto-escala { display: flex; gap: 7px; flex-wrap: wrap; }
        .atitude-voto-escala label { display: flex; align-items: center; justify-content: center; gap: 5px; padding: 8px; border: 1px solid #b9cad7; border-radius: 8px; cursor: pointer; min-width: 43px; }
        .atitude-voto-escala label:has(input:checked) { background: #12455e; color: #fff; }
        .atitude-voto-escala label:focus-within { outline: 3px solid #82afc8; outline-offset: 2px; }
        .atitude-voto-escala input { accent-color: #12455e; }
        @media(max-width: 768px) { .atitude-votacao { padding-top: 110px; } .atitude-votar-flutuante { bottom: 12px; right: 12px; left: 12px; justify-content: space-between; } }
    </style>
</head>
<body>
    <?php $this->load->view('fixo/cabecalho'); ?>
    <main class="atitude-votacao">
        <a href="<?= site_url('atitude_farmaceutica') ?>" class="btn btn-outline-primary mb-4">VOLTAR</a>
        <h1>Votação popular — Atitude Farmacêutica</h1>
        <?php if (!$votacaoAberta): ?>
            <p class="alert alert-info mt-4">A votação não está aberta no momento.</p>
        <?php elseif (count($projetosAceitos) < $limiteProjetosVotacao): ?>
            <p class="alert alert-info mt-4">A votação aguarda a disponibilização de projetos suficientes para o limite configurado. Volte em breve.</p>
        <?php else: ?>
            <p>Selecione exatamente <strong><?= (int) $limiteProjetosVotacao ?> projeto(s)</strong> e atribua notas de 1 a 5 nos cinco critérios de cada projeto selecionado. Não é necessário cadastro prévio.</p>
            <form id="atitude-votacao-form" method="post" action="<?= site_url('atitude_farmaceutica/votar') ?>"
                data-limite="<?= (int) $limiteProjetosVotacao ?>">
                <input type="hidden" name="token" value="<?= html_escape($tokenVoto) ?>">
                <input type="hidden" id="atitude-voto-csrf" name="<?= html_escape($this->security->get_csrf_token_name()) ?>" value="<?= html_escape($this->security->get_csrf_hash()) ?>">
                <div class="atitude-eleitor">
                    <label for="atitude-voto-email" class="form-label">Seu e-mail</label>
                    <input type="email" id="atitude-voto-email" name="email" class="form-control" maxlength="254" autocomplete="email" placeholder="seuemail@exemplo.com.br" required aria-describedby="atitude-voto-email-ajuda">
                    <small id="atitude-voto-email-ajuda">É permitido apenas um envio por e-mail e por endereço IP. Não é necessário cadastro prévio.</small>
                </div>
                <?php $this->load->view('atitude-farmaceutica/projetos_aceitos', array('projetosAceitos' => $projetosAceitos, 'modoVotacao' => true, 'criteriosVotacao' => $criteriosVotacao)); ?>
                <div class="atitude-votar-flutuante">
                    <div><span id="atitude-votos-contador" aria-live="polite"></span><small id="atitude-votos-ajuda" class="d-block text-muted"></small></div>
                    <button type="submit" id="atitude-votar-botao" disabled>Confirmar voto</button>
                </div>
            </form>
        <?php endif; ?>
    </main>
    <?php $this->load->view('fixo/rodape'); ?>
    <?php if ($votacaoAberta && count($projetosAceitos) >= $limiteProjetosVotacao): ?>
        <script src="<?= base_url('assets/js/atitude-votacao.js') ?>?v=20261016-2"></script>
    <?php endif; ?>
</body>
</html>
