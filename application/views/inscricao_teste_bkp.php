<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <head>
        <meta charset="UTF-8">
        <title>Porta Farma</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- CSS do projeto -->
        <link rel="stylesheet" href="assets/css/style.css">

        <link rel="stylesheet" href="assets/css/style_caminhos.css">
        <link rel="stylesheet" href="assets/css/style_iniciativas.css">
        <link rel="stylesheet" href="assets/css/style_selector.css">
        <link rel="stylesheet" href="assets/css/style_cursos.css">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">


        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
		
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>		
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		
		
    </head>

    <style>
        /* =================================
        BODY
        ================================= */
        body {
            background-color: #ffffffde;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 60px 20px;
        }

        /* =================================
        WRAPPER
        ================================= */
        .page-wrapper {
            width: 100%;
            max-width: 1225px;
			margin-top: 300px;
        }

        /* =================================
        BOTÃO VOLTAR
        ================================= */
        .btn-voltar {
            position: absolute;
            top: 20px;
            right: 20px;

            display: inline-flex;
            gap: 8px;

            padding: 8px 16px;

            border-radius: 10px;
            background: transparent;
            border: 1px solid #12455e;

            color: #12455e;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;

            transition: .25s;
        }

        .btn-voltar:hover {
            background: #0b4f63;
            color: #F8FAFC;
        }

        /* =================================
        CONTAINER PRINCIPAL
        ================================= */
        .inscricao-container {
            width: 100%;
            background: #F8FAFC;

            border-radius: 18px;
            overflow: hidden;

            box-shadow:
                -10px 0 25px rgba(0, 0, 0, 0.06),
                10px 0 25px rgba(0, 0, 0, 0.06),
                0 25px 60px rgba(0, 0, 0, 0.10);

            display: flex;
            align-items: stretch;
            margin-top: 80px;
            min-height: 460px;
        }

        /* =================================
        IMAGEM
        ================================= */
        .inscricao-imagem {
            width: 40%;
            position: relative;
            background: #0b1026;
            display: flex;
            min-height: 460px;
        }

        .inscricao-imagem img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center right;
        }

        /* sombra leve saindo da direita */
        .inscricao-imagem::after {
            content: "";
            position: absolute;
            inset: 0;

background: linear-gradient(270deg,
                    rgba(0, 0, 0, 0.45) 0%,
                    rgba(0, 0, 0, 0.30) 25%,
                    rgba(0, 0, 0, 0.15) 50%,
                    rgba(0, 0, 0, 0.05) 70%,
                    rgba(0, 0, 0, 0) 85%);
        }

        /* =================================
        FORMULÁRIO
        ================================= */
        .inscricao-form {
            width: 100%;
            padding: 36px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            position: relative;
        }

        /* =================================
        TEXTOS
        ================================= */
        .inscricao-form h1 {
            font-size: 28px;
            color: #12455e;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .inscricao-form h2 {
            font-size: 23px;
            color: #374151;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 5px;
			color: #fc3041;

        }

        .inscricao-form p {
            font-size: 14.5px;
            color: #585c64;
            line-height: 1.5;
            margin-bottom: 26px;
        }

        /* =================================
        ALERT
        ================================= */
        .alert {
            display: flex;
            gap: 12px;
            align-items: flex-start;

            padding: 12px;
            border-radius: 14px;

            margin-bottom: 16px;

            border: 1px solid transparent;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .08);
        }

        .alert .icon {
            width: 32px;
            height: 32px;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert .title {
            font-weight: 800;
            font-size: 13px;
        }

        .alert .msg {
            font-size: 12px;
        }

        /* cores */
        .alert-success {
            background: #ecfdf5;
            border-color: #a7f3d0;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: #fecaca;
        }

        .alert-warning {
            background: #fffbeb;
            border-color: #fde68a;
        }

        .alert-info {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        /* =================================
        FORM GRID
        ================================= */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-row-1 {
            grid-column: 1 / -1;
        }

        /* =================================
        CAMPOS
        ================================= */
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #111827;
        }

        .form-group input,
        .form-group select {
            width: 100%;

            padding: 11px 13px;

            border-radius: 12px;
            border: 1px solid #d1d5db;

            font-size: 14px;
            outline: none;
            background: #F8FAFC;
            border: 1px solid #d1d5db;
            transition: .15s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(59, 91, 219, .14);
            background: #F8FAFC;
            outline: none;
        }

        /* =================================
        BOTÃO
        ================================= */
        .btn-submit {
            margin-top: 28px;

            width: 100%;
            padding: 14px;

            background: linear-gradient(135deg, #3b5bdb 0%, #2f4bd1 100%);
            color: #fff;

            border: none;
            border-radius: 12px;

            font-size: 17px;
            font-weight: 700;
            letter-spacing: .3px;

            cursor: pointer;
            transition: background 0.25s ease;

        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #354fd0, #2a46c7);
        }

        .btn-submit:active {
            background: linear-gradient(135deg, #2f4bd1, #2741bb);
        }

        .form-hint {
            margin-top: 18px;
            font-size: 14.5px;
            color: #585c64;
            text-align: center;
            line-height: 1.4;
        }

        .titulo-linha {
            display: block;
            margin-bottom: 10px;
        }

        /* =================================
        RESPONSIVO GERAL
        ================================= */

        @media (max-width: 1024px) {

            body {
                align-items: flex-start;
            }

            .page-wrapper {
                max-width: 100%;
            }

            .inscricao-container {
                min-height: auto;
            }

            .inscricao-form {
                padding: 28px;
            }

            .inscricao-form h1 {
                font-size: 24px;
                margin-bottom: 6px;
                line-height: 1.25;
            }

            .inscricao-form h2 {
                font-size: 17px;
                margin-bottom: 6px;
                line-height: 1.35;
            }

            .inscricao-form p {
                font-size: 14px;
                margin-bottom: 22px;
                line-height: 1.5;
            }

        }

        @media (max-width: 860px) {

            .titulo-linha {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 10px;
            }

            .btn-voltar {
                position: static;
                margin: 0;
                font-size: 13px;
                padding: 6px 11px;
                white-space: nowrap;
            }

            .inscricao-container {
                flex-direction: column;
                margin-top: 30px;
                max-width: 520px;
                margin-left: auto;
                margin-right: auto;
            }

            .inscricao-imagem {
                width: 100%;
                height: 200px;
                min-height: auto;
            }

            .inscricao-imagem img {
                object-position: center;
            }

            .inscricao-form {
                width: 100%;
                padding: 26px;
            }

            .inscricao-form h1 {
                font-size: 23px;
                margin-bottom: 4px;
                line-height: 1.25;
            }

            .inscricao-form h2 {
                font-size: 16px;
                margin-top: 10px;
                margin-bottom: 6px;
                line-height: 1.35;
            }

            .inscricao-form p {
                font-size: 13.5px;
                margin-bottom: 20px;
                line-height: 1.5;
            }

            .form-group label {
                font-size: 13px;
            }

            .form-group input,
            .form-group select {
                font-size: 14px;
            }

            .btn-submit {
                font-size: 15px;
            }

        }

        @media (max-width: 520px) {

            body {
                padding: 24px 12px;
            }

            .page-wrapper {
                max-width: 100%;
            }

            .inscricao-container {
                border-radius: 14px;
                margin-top: 20px;
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }

            .inscricao-imagem {
                height: 160px;
            }

            .inscricao-form {
                padding: 22px;
            }

            .inscricao-form h1 {
                font-size: 21px;
                line-height: 1.25;
                margin-bottom: 4px;
            }

            .inscricao-form h2 {
                font-size: 15px;
                margin-bottom: 5px;
                line-height: 1.35;
            }

            .inscricao-form p {
                font-size: 13px;
                margin-bottom: 18px;
                line-height: 1.5;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .form-group label {
                font-size: 12.5px;
            }

            .form-group input,
            .form-group select {
                padding: 10px 12px;
                font-size: 13.5px;
            }

            .btn-submit {
                padding: 12px;
                font-size: 14px;
            }

            .form-hint {
                font-size: 12px;
                margin-top: 14px;
                line-height: 1.4;
            }

            .btn-voltar {
                font-size: 12px;
                padding: 5px 10px;
            }

        }

        @media (max-width: 380px) {

            body {
                padding: 18px 10px;
            }

            .inscricao-container {
                margin-top: 15px;
                max-width: 340px;
                margin-left: auto;
                margin-right: auto;
            }

            .inscricao-imagem {
                height: 140px;
            }

            .inscricao-form {
                padding: 18px;
            }

            .inscricao-form h1 {
                font-size: 19px;
                margin-bottom: 3px;
                line-height: 1.25;
            }

            .inscricao-form h2 {
                font-size: 14px;
                margin-bottom: 4px;
                line-height: 1.35;
            }

            .inscricao-form p {
                font-size: 12.5px;
                margin-bottom: 16px;
                line-height: 1.5;
            }

            .btn-voltar {
                font-size: 11.5px;
                padding: 4px 9px;
            }

            .form-group label {
                font-size: 12px;
            }

            .form-group input,
            .form-group select {
                font-size: 13px;
            }

            .btn-submit {
                font-size: 13.5px;
            }

        }
    </style>
	<style>
    /* Estilo para os Labels */
    .form-group label {
        font-weight: 600;
        color: #444;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.9rem;
    }

    /* Estilo para o asterisco de obrigatoriedade */
    .text-danger {
        color: #dc3545 !important;
        font-weight: bold;
    }

    /* Feedback visual nos inputs obrigatórios quando vazios */
    input:required:invalid {
        border-left: 3px solid #dee2e6; /* Cinza antes de digitar */
    }

    input:required:valid {
        border-left: 3px solid #198754; /* Verde após preenchimento correto */
    }

    /* Ajuste para o campo Opcional */
    #crfmg {
        background-color: #fcfcfc;
    }

    /* Grid layout para manter o alinhamento que você já usa */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-row-1 {
        grid-column: span 2;
    }

    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-row-1 { grid-column: span 1; }
    }
</style>
<style>
	/* LGDP */
    .custom-checkbox-lgpd {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6 !important;
    }

    .custom-checkbox-lgpd:hover {
        background-color: #fff !important;
        border-color: #0d6efd !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.08);
    }

    .custom-checkbox-lgpd .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.15em;
        cursor: pointer;
    }

    .custom-checkbox-lgpd .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    /* Ajuste para o PDF no Mobile */
    @media (max-width: 768px) {
        #modalLGPD .modal-body {
            height: 50vh;
        }
    }
	
	/* Estilo para campos bloqueados (vão parecer desabilitados, mas ainda enviam no POST) */
	input[readonly] {
		background-color: #f8f9fa !important;
		border-color: #e9ecef !important;
		color: #6c757d !important;
		cursor: not-allowed;
	}

	/* Animação de loading no input de CPF */
	.is-loading {
		background-image: url('https://i.gifer.com/ZKZg.gif'); /* Substitua por um loader local se preferir */
		background-repeat: no-repeat;
		background-position: center right 10px;
		background-size: 20px;
	}
</style>
</head>

<?php

$english = !empty($english);
foreach ($tabelaCurso as $campo) {
    switch ($campo->tipo_evento) {
        case 1:
            $campo_evento = "Presencial";
            break;
        case 2:
            $campo_evento = "On-line";
            break;
        default:
            $campo_evento = "Evento";
            break;
    }
    $campo_imagem  = $campo->nome_curto;
    $campo_titulo  = $campo->titulo;
    $course_id     = $campo->courseid;
}
?>

<body>

    <div class="page-wrapper">

        <div class="inscricao-container">

            <!-- Formulário -->
            <div class="inscricao-form">

                <div class="titulo-linha">
                    <div class="titulo-textos">
                        <h1><?=$english ? 'Course Registration' : 'Inscrição no Curso'?></h1>
                        <h2><?=$english && (int) $course_id === 74 ? 'Bioequivalence Short Course: Theory and Application' : $campo_titulo?></h2>
                    </div>

                    <a href="<?= base_url() ?>curso/listar/<?= $course_id ?>" class="btn-voltar">
                        VOLTAR
                    </a>
                </div>

                <p><?=$english ? 'Fill in your details below to confirm your registration.' : 'Preencha seus dados abaixo para confirmar sua inscrição.'?></p>

                <?php
					$type = $this->session->flashdata('type');    
					$msg  = $this->session->flashdata('message'); // Retorno do controller: "Inscrição realizada com sucesso!"
					$yourPass = $this->session->flashdata('your_pass');
					$resultadoInscricao = $this->session->flashdata('inscricao_resultado');
					$cursoResultado = $this->session->flashdata('inscricao_course_id');

					if ($resultadoInscricao === '1' && (string) $cursoResultado === (string) $course_id && $type && $msg):
						$swalType = ($type == 'danger') ? 'error' : $type;
				?>

				<script>
					document.addEventListener('DOMContentLoaded', function() {
						const mensagemController = "<?= addslashes($msg) ?>";
						const yourPass = "";

						<?php if ($english && $swalType === 'success'): ?>
						Swal.fire({
							title: 'Registration completed!',
							icon: 'success',
							html: `
								<div class="text-center">
									<p class="mb-3">${mensagemController}</p>
									<p class="small text-muted mb-2">Your access code:</p>
									<div class="fs-3 fw-bold text-primary mb-3" id="swal-your-pass">${yourPass}</div>
									<button type="button" id="copy-your-pass" class="btn btn-primary px-4 mb-3">
										<i class="bi bi-copy me-1"></i> Copy code
									</button>
									<p class="small text-muted mb-3">Use this code as your password on your first login.</p>
									<a href="https://portalfarma.crfmg.org.br/moodle/login/index.php" 
									   target="_blank" 
									   class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-bold">
									   <i class="bi bi-box-arrow-up-right me-1"></i> Access Moodle
									</a>
								</div>
							`,
							didOpen: () => {
								document.getElementById('copy-your-pass').addEventListener('click', async function() {
									await navigator.clipboard.writeText(yourPass);
									this.innerHTML = '<i class="bi bi-check-lg me-1"></i> Copied!';
								});
							},
							confirmButtonColor: '#054589',
							confirmButtonText: 'Close',
							customClass: {
								popup: 'rounded-4 shadow-lg',
								title: 'text-primary fw-bold'
							}
						});
						<?php else: ?>
						Swal.fire({
							title: '<?=$english ? ($swalType === 'error' ? 'Registration error' : 'All set!') : 'Tudo certo!'?>',
							icon: '<?=$swalType?>',
							html: mensagemController,
							confirmButtonColor: '#054589',
							confirmButtonText: '<?=$english ? 'Close' : 'Entendido'?>'
						});
						<?php endif; ?>
					});
				</script>

				<style>
					/* Estilização extra para o link dentro do Swal não parecer um link comum */
					.swal2-html-container a.btn-outline-primary:hover {
						color: white !important;
						background-color: #0d6efd;
					}
				</style>

				<?php endif; ?>

				<form action="<?= base_url('inscricao/salvar'); ?>" method="post" autocomplete="on">

                    <!-- oculto -->
                    <input type="hidden" id="course_id" name="course_id" value="<?= $course_id ?>">
					<?php if ($english): ?>
						<input type="hidden" name="estrangeiro" value="1">
					<?php endif; ?>

                    <div class="form-header-info mb-3">
						<small class="text-muted"><span class="text-danger">*</span> <?=$english ? 'Required fields' : 'Campos de preenchimento obrigatório'?></small>
					</div>

					<div class="form-grid">
						<?php if (!$english && (int) $course_id === 74): ?>
						<div class="form-group form-row-1">
							<div class="p-3 rounded border bg-light">
								<a href="<?=base_url('curso/inscricao_english/'.$course_id)?>" class="small text-muted text-decoration-none d-block">
									<strong>I am a foreign participant</strong><br>
									<small>Select this option to continue with the registration form in English.</small>
								</a>
							</div>
						</div>
						<?php endif; ?>

						<?php if ($english): ?>
						<div class="form-group form-row-1">
							<label for="email">E-mail <span class="text-danger">*</span></label>
							<input type="email" id="email" name="email" placeholder="your@email.com" autocomplete="email" required maxlength="200">
						</div>
						<div class="form-group form-row-1">
							<label for="your-pass">your Pass</label>
							<input type="text" id="your-pass" name="pass" value="" placeholder="Generated from your e-mail" readonly>
							<small class="text-muted d-block mt-1">Use this code as your password on your first login.</small>
						</div>
						<?php else: ?>
						<div class="form-group">
							<label for="cpf">CPF <span class="text-danger">*</span></label>
							<input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00" inputmode="numeric" maxlength="14" autocomplete="off" required>
							<div id="cpf-status" class="small text-muted d-block mt-1" role="status">Informe o CPF para continuar.</div>
						</div>
						<?php endif; ?>
					</div>

					<div id="campos-inscricao" <?=$english ? '' : 'hidden'?>>
					<div id="alerta-dados-perfil" class="alert alert-warning d-none align-items-start gap-2 mb-3" role="alert">
						<i class="bi bi-exclamation-triangle-fill mt-1"></i>
						<div>
							<strong>Dados incorretos?</strong><br>
							Para alterá-los, acesse seu perfil clicando em <strong>Nome → Perfil → Modificar perfil</strong>.
						</div>
					</div>
					<div class="form-grid">
						<div class="form-group">
							<label for="telefone"><?=$english ? 'Phone' : 'Telefone'?> <span class="text-danger">*</span></label>
							<input type="text" id="telefone" name="telefone" placeholder="<?=$english ? '+99 99 9999-9999' : '(99) 99999-9999'?>" inputmode="tel" autocomplete="tel" required>
						</div>

						<div class="form-group form-row-1">
							<label for="nome"><?=$english ? 'Full name' : 'Nome completo'?> <span class="text-danger">*</span></label>
							<input type="text" id="nome" name="nome" placeholder="<?=$english ? 'Enter your full name' : 'Digite seu nome completo'?>" autocomplete="name" required maxlength="100">
						</div>

						<?php if (!$english): ?>
						<div class="form-group">
							<label for="crfmg">CRFMG <span class="badge bg-light text-muted fw-normal" style="font-size: 10px;">Opcional</span></label>
							<input type="text" id="crfmg" name="crfmg" placeholder="Ex: 12345" autocomplete="off" maxlength="10">
							<small class="text-muted d-block mt-1" style="font-size: 11px; line-height: 1.2;">
								<i class="bi bi-info-circle"></i> Preencher apenas se for inscrita(o) no CRF/MG
							</small>
						</div>

						<div class="form-group">
							<label for="categoria">Categoria <span class="text-danger">*</span></label>
							<select id="categoria" name="categoria">
								<option value="">Selecione sua categoria</option>
								<option value="Farmacêutico(s) Inscrito(s) no CRF/MG">Farmacêutico(s) Inscrito(s) no CRF/MG</option>
								<option value="Estudante de Farmácia">Estudante de Farmácia</option>
								<option value="Farmacêutico(s) NÃO Inscrito(s)">Farmacêutico(s) NÃO Inscrito(s)</option>
								<option value="Farmacêutico(s) Outro(s) Estado(s)">Farmacêutico(s) Outro(s) Estado(s)</option>
								<option value="Outros Profissionais">Outros Profissionais</option>
							</select>
						</div>
						<?php endif; ?>

						<div class="form-group">
							<label for="cidade"><?=$english ? 'City' : 'Cidade'?> <span class="text-danger">*</span></label>
							<input type="text" id="cidade" name="<?=$english ? 'cidade' : 'cidade'?>" placeholder="<?=$english ? 'Enter your city' : 'Digite sua cidade'?>" autocomplete="address-level2" required maxlength="200">
						</div>
                        
                        <?php
                        $paises = [
                            ["code" => "AF", "name" => "Afghanistan"],
                            ["code" => "AL", "name" => "Albania"],
                            ["code" => "DZ", "name" => "Algeria"],
                            ["code" => "AD", "name" => "Andorra"],
                            ["code" => "AO", "name" => "Angola"],
                            ["code" => "AI", "name" => "Anguilla"],
                            ["code" => "AQ", "name" => "Antarctica"],
                            ["code" => "AG", "name" => "Antigua and Barbuda"],
                            ["code" => "AR", "name" => "Argentina"],
                            ["code" => "AM", "name" => "Armenia"],
                            ["code" => "AU", "name" => "Australia"],
                            ["code" => "AT", "name" => "Austria"],
                            ["code" => "AZ", "name" => "Azerbaijan"],
                            ["code" => "BS", "name" => "Bahamas"],
                            ["code" => "BH", "name" => "Bahrain"],
                            ["code" => "BD", "name" => "Bangladesh"],
                            ["code" => "BB", "name" => "Barbados"],
                            ["code" => "BY", "name" => "Belarus"],
                            ["code" => "BE", "name" => "Belgium"],
                            ["code" => "BZ", "name" => "Belize"],
                            ["code" => "BJ", "name" => "Benin"],
                            ["code" => "BM", "name" => "Bermuda"],
                            ["code" => "BT", "name" => "Bhutan"],
                            ["code" => "BO", "name" => "Bolivia"],
                            ["code" => "BA", "name" => "Bosnia and Herzegovina"],
                            ["code" => "BW", "name" => "Botswana"],
                            ["code" => "BR", "name" => "Brazil"],
                            ["code" => "BN", "name" => "Brunei"],
                            ["code" => "BG", "name" => "Bulgaria"],
                            ["code" => "BF", "name" => "Burkina Faso"],
                            ["code" => "BI", "name" => "Burundi"],
                            ["code" => "KH", "name" => "Cambodia"],
                            ["code" => "CM", "name" => "Cameroon"],
                            ["code" => "CA", "name" => "Canada"],
                            ["code" => "CV", "name" => "Cape Verde"],
                            ["code" => "CF", "name" => "Central African Republic"],
                            ["code" => "TD", "name" => "Chad"],
                            ["code" => "CL", "name" => "Chile"],
                            ["code" => "CN", "name" => "China"],
                            ["code" => "CO", "name" => "Colombia"],
                            ["code" => "KM", "name" => "Comoros"],
                            ["code" => "CG", "name" => "Congo"],
                            ["code" => "CR", "name" => "Costa Rica"],
                            ["code" => "HR", "name" => "Croatia"],
                            ["code" => "CU", "name" => "Cuba"],
                            ["code" => "CY", "name" => "Cyprus"],
                            ["code" => "CZ", "name" => "Czech Republic"],
                            ["code" => "DK", "name" => "Denmark"],
                            ["code" => "DJ", "name" => "Djibouti"],
                            ["code" => "DM", "name" => "Dominica"],
                            ["code" => "DO", "name" => "Dominican Republic"],
                            ["code" => "TL", "name" => "East Timor"],
                            ["code" => "EC", "name" => "Ecuador"],
                            ["code" => "EG", "name" => "Egypt"],
                            ["code" => "SV", "name" => "El Salvador"],
                            ["code" => "GQ", "name" => "Equatorial Guinea"],
                            ["code" => "ER", "name" => "Eritrea"],
                            ["code" => "EE", "name" => "Estonia"],
                            ["code" => "ET", "name" => "Ethiopia"],
                            ["code" => "FJ", "name" => "Fiji"],
                            ["code" => "FI", "name" => "Finland"],
                            ["code" => "FR", "name" => "France"],
                            ["code" => "GA", "name" => "Gabon"],
                            ["code" => "GM", "name" => "Gambia"],
                            ["code" => "GE", "name" => "Georgia"],
                            ["code" => "DE", "name" => "Germany"],
                            ["code" => "GH", "name" => "Ghana"],
                            ["code" => "GR", "name" => "Greece"],
                            ["code" => "GD", "name" => "Grenada"],
                            ["code" => "GT", "name" => "Guatemala"],
                            ["code" => "GN", "name" => "Guinea"],
                            ["code" => "GW", "name" => "Guinea-Bissau"],
                            ["code" => "GY", "name" => "Guyana"],
                            ["code" => "HT", "name" => "Haiti"],
                            ["code" => "HN", "name" => "Honduras"],
                            ["code" => "HU", "name" => "Hungary"],
                            ["code" => "IS", "name" => "Iceland"],
                            ["code" => "IN", "name" => "India"],
                            ["code" => "ID", "name" => "Indonesia"],
                            ["code" => "IR", "name" => "Iran"],
                            ["code" => "IQ", "name" => "Iraq"],
                            ["code" => "IE", "name" => "Ireland"],
                            ["code" => "IL", "name" => "Israel"],
                            ["code" => "IT", "name" => "Italy"],
                            ["code" => "CI", "name" => "Ivory Coast"],
                            ["code" => "JM", "name" => "Jamaica"],
                            ["code" => "JP", "name" => "Japan"],
                            ["code" => "JO", "name" => "Jordan"],
                            ["code" => "KZ", "name" => "Kazakhstan"],
                            ["code" => "KE", "name" => "Kenya"],
                            ["code" => "KW", "name" => "Kuwait"],
                            ["code" => "KG", "name" => "Kyrgyzstan"],
                            ["code" => "LA", "name" => "Laos"],
                            ["code" => "LV", "name" => "Latvia"],
                            ["code" => "LB", "name" => "Lebanon"],
                            ["code" => "LS", "name" => "Lesotho"],
                            ["code" => "LR", "name" => "Liberia"],
                            ["code" => "LY", "name" => "Libya"],
                            ["code" => "LI", "name" => "Liechtenstein"],
                            ["code" => "LT", "name" => "Lithuania"],
                            ["code" => "LU", "name" => "Luxembourg"],
                            ["code" => "MG", "name" => "Madagascar"],
                            ["code" => "MW", "name" => "Malawi"],
                            ["code" => "MY", "name" => "Malaysia"],
                            ["code" => "MV", "name" => "Maldives"],
                            ["code" => "ML", "name" => "Mali"],
                            ["code" => "MT", "name" => "Malta"],
                            ["code" => "MR", "name" => "Mauritania"],
                            ["code" => "MU", "name" => "Mauritius"],
                            ["code" => "MX", "name" => "Mexico"],
                            ["code" => "MD", "name" => "Moldova"],
                            ["code" => "MC", "name" => "Monaco"],
                            ["code" => "MN", "name" => "Mongolia"],
                            ["code" => "ME", "name" => "Montenegro"],
                            ["code" => "MA", "name" => "Morocco"],
                            ["code" => "MZ", "name" => "Mozambique"],
                            ["code" => "MM", "name" => "Myanmar"],
                            ["code" => "NA", "name" => "Namibia"],
                            ["code" => "NP", "name" => "Nepal"],
                            ["code" => "NL", "name" => "Netherlands"],
                            ["code" => "NZ", "name" => "New Zealand"],
                            ["code" => "NI", "name" => "Nicaragua"],
                            ["code" => "NE", "name" => "Niger"],
                            ["code" => "NG", "name" => "Nigeria"],
                            ["code" => "KP", "name" => "North Korea"],
                            ["code" => "MK", "name" => "North Macedonia"],
                            ["code" => "NO", "name" => "Norway"],
                            ["code" => "OM", "name" => "Oman"],
                            ["code" => "PK", "name" => "Pakistan"],
                            ["code" => "PA", "name" => "Panama"],
                            ["code" => "PG", "name" => "Papua New Guinea"],
                            ["code" => "PY", "name" => "Paraguay"],
                            ["code" => "PE", "name" => "Peru"],
                            ["code" => "PH", "name" => "Philippines"],
                            ["code" => "PL", "name" => "Poland"],
                            ["code" => "PT", "name" => "Portugal"],
                            ["code" => "QA", "name" => "Qatar"],
                            ["code" => "RO", "name" => "Romania"],
                            ["code" => "RU", "name" => "Russia"],
                            ["code" => "RW", "name" => "Rwanda"],
                            ["code" => "LC", "name" => "Saint Lucia"],
                            ["code" => "WS", "name" => "Samoa"],
                            ["code" => "SM", "name" => "San Marino"],
                            ["code" => "ST", "name" => "Sao Tome and Principe"],
                            ["code" => "SA", "name" => "Saudi Arabia"],
                            ["code" => "SN", "name" => "Senegal"],
                            ["code" => "RS", "name" => "Serbia"],
                            ["code" => "SK", "name" => "Slovakia"],
                            ["code" => "SI", "name" => "Slovenia"],
                            ["code" => "SO", "name" => "Somalia"],
                            ["code" => "ZA", "name" => "South Africa"],
                            ["code" => "KR", "name" => "South Korea"],
                            ["code" => "ES", "name" => "Spain"],
                            ["code" => "LK", "name" => "Sri Lanka"],
                            ["code" => "SD", "name" => "Sudan"],
                            ["code" => "SR", "name" => "Suriname"],
                            ["code" => "SE", "name" => "Sweden"],
                            ["code" => "CH", "name" => "Switzerland"],
                            ["code" => "SY", "name" => "Syria"],
                            ["code" => "TJ", "name" => "Tajikistan"],
                            ["code" => "TZ", "name" => "Tanzania"],
                            ["code" => "TH", "name" => "Thailand"],
                            ["code" => "TG", "name" => "Togo"],
                            ["code" => "TT", "name" => "Trinidad and Tobago"],
                            ["code" => "TN", "name" => "Tunisia"],
                            ["code" => "TR", "name" => "Turkey"],
                            ["code" => "TM", "name" => "Turkmenistan"],
                            ["code" => "UG", "name" => "Uganda"],
                            ["code" => "UA", "name" => "Ukraine"],
                            ["code" => "AE", "name" => "United Arab Emirates"],
                            ["code" => "GB", "name" => "United Kingdom"],
                            ["code" => "US", "name" => "United States"],
                            ["code" => "UY", "name" => "Uruguay"],
                            ["code" => "UZ", "name" => "Uzbekistan"],
                            ["code" => "VE", "name" => "Venezuela"],
                            ["code" => "VN", "name" => "Vietnam"],
                            ["code" => "YE", "name" => "Yemen"],
                            ["code" => "ZM", "name" => "Zambia"],
                            ["code" => "ZW", "name" => "Zimbabwe"]
                        ];
                        ?>
                        <?php if ($english): ?>
                        <div class="form-group">
                            <label for="pais"><?=$english ? 'Country' : 'País'?> <span class="text-danger">*</span></label>
                            <select id="pais" name="pais" class="form-control" required>
                                <option value=""><?=$english ? 'Select your Country' : 'Selecione o País'?></option>
                                <?php 
                                $pais_selecionado = isset($edit) && !empty($edit->pais) ? $edit->pais : 'BR';
                                foreach ($paises as $p): 
                                    $selected = ($p['code'] == $pais_selecionado) ? 'selected' : '';
                                ?>
                                    <option value="<?=$p['code']?>" <?=$selected?>><?=$p['name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

						<?php if (!$english): ?>
						<div class="form-group form-row-1">
							<label for="email">E-mail <span class="text-danger">*</span></label>
							<input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" autocomplete="email" required maxlength="200">
						</div>
						<?php endif; ?>
					</div>
					
					<div class="row mt-4 mb-4">
						<div class="col-12">
							<div class="form-check custom-checkbox-lgpd p-3 rounded border bg-light">
								<input class="form-check-input" type="checkbox" value="" id="checkLGPD" required>
								<label class="form-check-label small text-muted ms-2" for="checkLGPD">
									<?=$english ? 'I have read and agree to the ' : 'Eu li e concordo com os '?>
									<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalLGPD" class="fw-bold text-primary text-decoration-none">
										<?=$english ? 'Terms of Use and Privacy Policy' : 'Termos de Uso e Política de Privacidade'?>
									</a><?=$english ? ' of Portal Farma.' : ' do Portal Farma.'?> <span class="text-danger">*</span>
								</label>
							</div>
						</div>
					</div>
					
                    <button type="submit" class="btn-submit"><?=$english ? 'Register!' : 'Inscrever!'?></button>
                    <div class="form-hint"><?=$english ? 'By submitting, you confirm that the information provided is correct.' : 'Ao enviar, você confirma que os dados informados estão corretos.'?></div>
					</div>
                </form>
            </div>

        </div>
    </div>

</body>
<!-- MODAL LGDP -->
<div class="modal fade" id="modalLGPD" tabindex="-1" aria-labelledby="modalLGPDLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content border-0 shadow-lg">
			<div class="modal-header bg-primary text-white">
				<h5 class="modal-title" id="modalLGPDLabel">
					<i class="bi bi-shield-lock me-2"></i> Termos de Uso e Política de Privacidade
				</h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-0" style="height: 70vh;">
				<iframe src="<?= base_url('public/TERMO_DE_USO_E_POLITICA_DE_PRIVACIDADE_PORTAL_FARMA_CAPACIFAR_CRFMG.pdf') ?>#toolbar=0" 
						width="100%" 
						height="100%" 
						style="border: none;">
				</iframe>
			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Fechar</button>
				<button type="button" class="btn btn-primary px-4" onclick="aceitarTermos()">Entendi e Aceito</button>
			</div>
		</div>
	</div>
</div>

<script>
function aceitarTermos() {
    // Marca o checkbox principal
    document.getElementById('checkLGPD').checked = true;
    
    // Fecha o modal (usando o método do Bootstrap 5)
    var myModalEl = document.getElementById('modalLGPD');
    var modal = bootstrap.Modal.getInstance(myModalEl);
    modal.hide();
    
    // Opcional: Feedback visual de sucesso
    Swal.fire({
		icon: 'success',
		title: 'Sucesso',
		text: 'Termos aceitos com sucesso!',
		timer: 2000,
		showConfirmButton: false
	});
}

const emailEnglish = document.getElementById('your-pass') ? document.getElementById('email') : null;
if (emailEnglish) {
    emailEnglish.addEventListener('input', async function() {
        const email = this.value.trim().toLowerCase();
        const campoPass = document.getElementById('your-pass');
        if (!email || !this.checkValidity()) {
            campoPass.value = '';
            return;
        }

        const bytes = new TextEncoder().encode(email);
        const hashBuffer = await crypto.subtle.digest('SHA-256', bytes);
        const hashHex = Array.from(new Uint8Array(hashBuffer))
            .map(byte => byte.toString(16).padStart(2, '0'))
            .join('');
        const numero = BigInt('0x' + hashHex.substring(0, 12)) % 100000000000n;
        campoPass.value = numero.toString().padStart(11, '0');
    });
}


$(document).ready(function() {
    const $campos = $('#campos-inscricao');
    const $status = $('#cpf-status');
    let cpfConsultado = '';

    $('#cpf').on('input blur', function() {
        const cpf = $(this).val().replace(/\D/g, '').slice(0, 11);
        $(this).val(formatarCpf(cpf));

        if (cpf.length !== 11) {
            cpfConsultado = '';
            $campos.prop('hidden', true);
            $('#alerta-dados-perfil').addClass('d-none').removeClass('d-flex');
            $status.removeClass('text-danger text-success alert alert-success').addClass('text-muted').text('Informe o CPF para continuar.');
            return;
        }

        if (cpf === cpfConsultado) return;
        cpfConsultado = cpf;

        const $inputCpf = $(this);
        $inputCpf.addClass('is-loading');
        $status.removeClass('text-danger text-success alert alert-success').addClass('text-muted').text('Consultando CPF...');

        $.ajax({
            url: "<?= base_url('inscricao/verifica_inscrito') ?>",
            type: "POST",
            data: { cpf: cpf },
            dataType: "json",
            success: function(res) {
                if (res.encontrado && res.usuario) {
                    preencherCampo('#nome', res.usuario.nome);
                    preencherCampo('#email', res.usuario.email);
                    preencherCampo('#cidade', res.usuario.cidade);
                    preencherCampo('#telefone', res.usuario.telefone);
                    preencherCampo('#crfmg', res.usuario.crfmg);
                    $('#categoria').val(res.usuario.categoria || '');
                    $('#alerta-dados-perfil').removeClass('d-none').addClass('d-flex');
                    $status.removeClass('text-muted text-danger text-success').addClass('alert alert-success').text('Cadastro localizado. Confira seus dados.');
                } else {
                    limparELiberarCampos();
                    $('#alerta-dados-perfil').addClass('d-none').removeClass('d-flex');
                    $status.removeClass('text-muted text-danger alert alert-success').addClass('text-success').text('CPF não localizado. Preencha seus dados para continuar.');
                }
                $campos.prop('hidden', false);
            },
            error: function() {
                cpfConsultado = '';
                $campos.prop('hidden', true);
                $('#alerta-dados-perfil').addClass('d-none').removeClass('d-flex');
                $status.removeClass('text-muted text-success alert alert-success').addClass('text-danger').text('Não foi possível consultar o CPF. Tente novamente.');
            },
            complete: function() {
                $inputCpf.removeClass('is-loading');
            }
        });
    });

    function preencherCampo(seletor, valor) {
        $(seletor).val(valor || '').prop('readonly', Boolean(valor));
    }

    function formatarCpf(cpf) {
        return cpf
            .replace(/^(\d{3})(\d)/, '$1.$2')
            .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
            .replace(/\.(\d{3})(\d)/, '.$1-$2');
    }

    function limparELiberarCampos() {
        $('#nome, #email, #cidade, #telefone, #crfmg').val('').prop('readonly', false);
        $('#categoria').val('');
    }
});
</script>
</html>
