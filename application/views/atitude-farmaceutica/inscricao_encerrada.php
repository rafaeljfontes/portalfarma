<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atitude Farmacêutica — Inscrições encerradas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php $this->load->view('fixo/cabecalho'); ?>
    <main class="container text-center" style="padding-top: 190px; padding-bottom: 80px; color: #12455e;">
        <h1>Inscrições encerradas</h1>
        <p>Agradecemos o seu interesse e a participação de todos!</p>
        <a class="btn btn-outline-primary" href="<?= site_url('atitude_farmaceutica') ?>">Voltar para Atitude Farmacêutica</a>
    </main>
    <?php $this->load->view('fixo/rodape'); ?>
</body>
</html>
