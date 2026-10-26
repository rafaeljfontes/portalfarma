<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <head>
        <meta charset="UTF-8">
        <title>Porta Farma - Capacifar</title>

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

        .form-group input {
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

        .form-group input:focus {
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

            .form-group input {
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

            .form-group input {
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

            .form-group input {
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
</style>
</head>

<?php
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
	$link_whatsapp = $campo->link ?? '';
}
?>

<body>

    <div class="page-wrapper">

        <div class="inscricao-container">

            <!-- Imagem do curso
            <div class="inscricao-imagem">
                <img
                    src="<?= base_url() ?>uploads/cursos/<?= $campo_imagem ?>.png"
                    onerror="this.onerror=null;this.src='<?= base_url() ?>assets/img/icons/icons_capacifar/banner_cursos.png';"
                    alt="<?= $campo_titulo ?>">
            </div> -->

            <!-- Formulário -->
            <div class="inscricao-form">

                <div class="titulo-linha">
                    <div class="titulo-textos">
                        <h1>Inscrição no Curso</h1>
                        <h2><?= $campo_titulo ?></h2>
                    </div>

                    <a href="<?= base_url() ?>curso/listar/<?= $course_id ?>" class="btn-voltar">
                        VOLTAR
                    </a>
                </div>

                <p>Preencha seus dados abaixo para confirmar sua inscrição.</p>

                <?php
					$type = $this->session->flashdata('type');    
					$msg  = $this->session->flashdata('message'); // Retorno do controller: "Inscrição realizada com sucesso!"

					if ($type && $msg):
						$swalType = ($type == 'danger') ? 'error' : $type;
				?>

				<script>
					document.addEventListener('DOMContentLoaded', function() {
						// Captura a mensagem do PHP
						const mensagemController = "<?= addslashes($msg) ?>";

						Swal.fire({
							title: 'Tudo certo!',
							icon: 'success',
							// Montamos o corpo do alerta combinando o retorno do controller + o HTML fixo
							html: `
								<div class="text-center">
									<p class="mb-3">${mensagemController}</p>
									<p class="mb-3">curso: <?=$campo_titulo;?></p>
									<hr>
									<p class="small text-muted mb-2">
										Clique abaixo para entrar na plataforma:
									</p>
									<a href="https://portalfarma.crfmg.org.br/moodle/login/index.php" 
									   target="_blank" 
									   class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-bold">
									   <i class="bi bi-box-arrow-up-right me-1"></i> Acessar Portal do Aluno
									</a>
									<p class="mt-3 small fw-bold">
										Use seu CPF como usuário e senha.
									</p>
									<?php if(!empty($link_whatsapp)): ?>
										<a href="<?=$link_whatsapp?>" 
										   target="_blank" 
										   class="btn btn-outline-success btn-sm px-4 rounded-pill fw-bold">
										   <i class="bi bi-whatsapp me-1 text-success"></i> WHATSAPP
										</a>
										<p class="mt-3 small fw-bold">
											Grupo de WhatsApp para informações do curso
										</p>
									<?php endif; ?>
								</div>
							`,
							confirmButtonColor: '#054589',
							confirmButtonText: 'Entendido',
							customClass: {
								popup: 'rounded-4 shadow-lg',
								title: 'text-primary fw-bold'
							}
						});
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

                <form action="<?= base_url() ?>inscricao/salvar" method="post" autocomplete="on">

                    <!-- oculto -->
                    <input type="hidden" id="course_id" name="course_id" value="<?= $course_id ?>">

                    <div class="form-header-info mb-3">
						<small class="text-muted"><span class="text-danger">*</span> Campos de preenchimento obrigatório</small>
					</div>

					<div class="form-grid">
						<div class="form-group">
							<label for="cpf">CPF <span class="text-danger">*</span></label>
							<input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" inputmode="numeric" autocomplete="off" required maxlength="14">
						</div>

						<div class="form-group">
							<label for="telefone">Telefone <span class="text-danger">*</span></label>
							<input type="text" id="telefone" name="telefone" placeholder="(99) 99999-9999" inputmode="tel" autocomplete="tel" required>
						</div>

						<div class="form-group form-row-1">
							<label for="nome">Nome completo <span class="text-danger">*</span></label>
							<input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" autocomplete="name" required maxlength="100">
						</div>

						<div class="form-group">
							<label for="crfmg">CRFMG <span class="badge bg-light text-muted fw-normal" style="font-size: 10px;">Opcional</span></label>
							<input type="text" id="crfmg" name="crfmg" placeholder="Ex: 12345" autocomplete="off" maxlength="10">
							<small class="text-muted d-block mt-1" style="font-size: 11px; line-height: 1.2;">
								<i class="bi bi-info-circle"></i> Preencher apenas se for inscrita(o) no CRF/MG
							</small>
						</div>

						<div class="form-group">
							<label for="cidade">Cidade <span class="text-danger">*</span></label>
							<input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" autocomplete="address-level2" required maxlength="200">
						</div>

						<div class="form-group form-row-1">
							<label for="email">E-mail <span class="text-danger">*</span></label>
							<input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" autocomplete="email" required maxlength="200">
						</div>
					</div>
					
					<div class="row mt-4 mb-4">
						<div class="col-12">
							<div class="form-check custom-checkbox-lgpd p-3 rounded border bg-light">
								<input class="form-check-input" type="checkbox" value="" id="checkLGPD" required>
								<label class="form-check-label small text-muted ms-2" for="checkLGPD">
									Eu li e concordo com os 
									<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalLGPD" class="fw-bold text-primary text-decoration-none">
										Termo de Uso e Política de Privacidade
									</a> do Portal Farma. <span class="text-danger">*</span>
								</label>
							</div>
						</div>
					</div>
					
                    <button type="submit" class="btn-submit">Inscrever!</button>
                    <div class="form-hint">Ao enviar, você confirma que os dados informados estão corretos.</div>
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
</script>
</html>