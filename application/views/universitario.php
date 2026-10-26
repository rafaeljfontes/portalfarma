<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/css/style_caminhos.css">
    <link rel="stylesheet" href="assets/css/style_iniciativas.css">
    <link rel="stylesheet" href="assets/css/style_selector.css">
    <link rel="stylesheet" href="assets/css/style_cursos.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>

    <!--  msg de retorno -->
    <?php if ($this->session->flashdata('tipo') != "") { ?>
        <div class="toast-alert <?= $this->session->flashdata('tipo'); ?>">

            <div class="toast-content">
                <?php if ($this->session->flashdata('tipo') == "success") { ?>
                    <i class="fas fa-circle-check"></i>
                <?php } else { ?>
                    <i class="fas fa-circle-exclamation"></i>
                <?php } ?>

                <span><?= $this->session->flashdata('msg'); ?></span>
            </div>

            <button class="toast-close"
                onclick="this.parentElement.style.display='none';">
                <i class="fas fa-times"></i>
            </button>

        </div>
    <?php } ?>
    <!--  fim msg de retorno -->

    <style>
        /* =========================
        TOAST ALERT - CANTO DIREITO
        ========================= */

        .toast-alert {
            position: fixed;
            /* fixa na tela */
            top: 30px;
            right: 30px;

            min-width: 320px;
            max-width: 420px;

            padding: 18px 20px;
            border-radius: 16px;

            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;

            font-size: 14px;
            font-weight: 500;

            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
            z-index: 9999;

            animation: slideIn .4s ease;
        }

        /* SUCCESS */
        .toast-alert.success {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: #ffffff;
        }

        /* ERROR */
        .toast-alert.danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: #ffffff;
        }

        .toast-content {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            flex: 1;
        }

        .toast-content i {
            font-size: 18px;
            margin-top: 2px;
        }

        .toast-close {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 15px;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity .2s ease;
        }

        .toast-close:hover {
            opacity: 1;
        }

        /* Animação */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* RESPONSIVO */
        @media (max-width: 600px) {
            .toast-alert {
                right: 15px;
                left: 15px;
                top: 20px;
                min-width: auto;
            }
        }
    </style>

    <!--  fim msg de retorno -->
    <!-- BANNER-->
    <section class="banner-curso">
        <div class="banner-container">
            <img
                src="assets/banner_projetos/Banner-Projetos_CAPACIFAR UNIVERSITARIO.jpg"
                alt="Uso racional de medicamentos"
                class="banner-imagem">
        </div>

        <style>
            .banner-curso {
                width: 100%;
                padding: 190px 20px 60px;
                background-color: #ffffffde;

                display: flex;
                justify-content: center;
            }

            /* CONTAINER */
            .banner-container {
                width: 100%;
                max-width: 1360px;
            }

            /* IMAGEM */
            .banner-imagem {
                width: 100%;
                height: auto;

                border-radius: 35px;

                display: block;

                box-shadow:
                    0 12px 28px rgba(0, 0, 0, 0.14),
                    0 4px 10px rgba(0, 0, 0, 0.08);
            }

            @media (max-width: 1024px) {

                .banner-curso {
                    padding: 100px 18px 40px;
                }

                .banner-imagem {
                    border-radius: 28px;
                }

            }

            @media (max-width: 768px) {

                .banner-curso {
                    padding: 30px 16px 20px;
                }

                .banner-imagem {
                    border-radius: 20px;
                }

            }

            @media (max-width: 480px) {

                .banner-curso {
                    padding: 30px 12px 20px;
                }

                .banner-imagem {
                    border-radius: 16px;
                }
            }
        </style>
    </section>


    <!-- CAPACIFAR UNIVERSITÁRIO -->
    <section class="curso-hero">
        <div class="container-inscricao">
            <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>

            <div class="curso-hero-grid">
                <div class="curso-hero-info">
                    <h1 class="curso-titulo destaque">Capacifar Universitário</h1>
                    <p class="curso-publicacao">
                        O Capacifar Universitário é um projeto pioneiro do CRF/MG em parceria com faculdades de Farmácia de Minas Gerais. 
						A iniciativa aproxima estudantes do Conselho por meio de ações exclusivas solicitadas pelas instituições 
						– palestras, workshops e eventos práticos que preparam para o mercado antes mesmo do registro profissional. 
						Universidades buscam ativamente o CRF/MG para incluir alunos em oportunidades reais, fomentando networking, 
						conhecimento e liderança desde a graduação. 
						Capacifar Universitário: A ponte para o futuro farmacêutico!
                </div>

                <div class="curso-hero-card">
                    <ul class="curso-detalhes">
                        <li>Para solicitar, basta um representante da instituição preencher a ficha disponível abaixo:</li>
                    </ul>
                    <a href="#universitario"
                        class="btn-inscricao grande">
                        FICHA DE SOLICITAÇÃO
                    </a>
                </div>
            </div>
        </div>

        <style>
            html {
                scroll-behavior: smooth;
            }

            .section-universitario {
                scroll-margin-top: 135px;
            }

            body {
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            .container-inscricao {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 24px;
            }

            .curso-hero {
                padding: 0px 0 0px;
                background-color: #ffffffde;
            }

            .curso-hero-grid {
                display: grid;
                grid-template-columns: minmax(0, 760px) minmax(0, 600px);
                gap: 82px;
                align-items: flex-start;
                margin: 0 auto;
                max-width: 1350px;
            }

            .btn-voltar {
                display: inline-flex;
                gap: 8px;
                margin-bottom: 25px;
                padding: 9px 20px;
                border-radius: 10px;
                background: #ffffffde;
                border: 1px solid #12455e;
                color: #12455e;
                font-size: 17px;
                font-weight: 700;
                text-decoration: none;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
                transition: all .25s ease;
            }

            .btn-voltar:hover {
                background: #0b4f63;
                color: #fff;
                border-color: #0b4f63;
                box-shadow: 0 10px 24px #0b4e6313;
            }

            .curso-titulo {
                font-size: 41px;
                color: #e92d26;
                font-weight: 700;
                max-width: 680px;
                line-height: 1.25;
                margin-bottom: 30px;
            }

            .curso-badges {
                display: flex;
                gap: 24px;
                margin-bottom: 24px;
            }

            .badge {
                font-size: 15px;
                padding: 14px 16px;
                border-radius: 8px;
                color: #fff;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .badge.azul {
                background: #3B5FC0;
            }

            .badge.verde {
                background: #0bbcd6;
            }

            .curso-publicacao {
                font-size: 20px;
                line-height: 1.6;
                font-weight: 500;
                color: #0a2d3f;
            }

            .curso-hero-card {
                background: #F8FAFC;
                border-radius: 28px;
                padding: 28px 43px 28px 33px;
                border: 1px solid rgba(23, 90, 120, 0.08);
                box-shadow: 0 4px 12px rgba(23, 90, 120, 0.08), 0 16px 40px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.6) inset;
                margin: auto 0;
            }

            .curso-detalhes {
                list-style: none;
                text-align: center;
                padding: 0;
                margin-bottom: 25px;
            }

            .curso-detalhes li {
                font-size: 21px;
                color: #12455e;
                margin-bottom: 12px;
            }

            .btn-inscricao {
                display: block;
                text-align: center;
                padding: 8px 23px;
                border-radius: 12px;
                background-color: #e92d26;
                color: #fff;
                font-size: 24px;
                font-weight: 500;
                width: fit-content;
                text-decoration: none;
                margin: 0 auto;
                transition: transform .25s ease, box-shadow .25s ease, background-color .25s ease;
            }

            .btn-inscricao:hover {
                background-color: #d3211f;
                box-shadow: 0 4px 12px rgba(233, 45, 38, 0.3);
                cursor: pointer;
            }


            /* ===============================
            RESPONSIVO
            ================================ */
            @media (max-width: 768px) {

                .curso-hero {
                    padding: 17px 0 0px 0;
                }


                .curso-hero-grid {
                    grid-template-columns: 1fr;
                    gap: 10px;
                }


                /* TÍTULO */
                .curso-titulo {
                    font-size: 28px;
                    max-width: 100%;
                    margin-bottom: 20px;
                }

                /* BADGES */
                .curso-badges {
                    flex-wrap: wrap;
                    gap: 13px;
                    margin-bottom: 16px;
                }

                .badge {
                    font-size: 13px;
                    padding: 8px 12px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                }


                .badge-azul {
                    color: #3B5FC0;
                }

                /* PUBLICAÇÃO */
                .curso-publicacao {
                    font-size: 15px;
                }

                /* CARD */
                .curso-hero-card {
                    margin-left: 0;
                    padding: 22px;
                    margin-bottom: 25px;
                    border-radius: 22px;
                }

                .curso-detalhes {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                    width: 100%;
                }

                .curso-detalhes li {
                    font-size: 15px;
                    line-height: 1.5;
                    margin-bottom: 0;
                    word-break: break-word;
                }

                /* remove regras que quebram layout */
                .curso-detalhes li:nth-child(1),
                .curso-detalhes li:nth-child(2),
                .curso-detalhes li:nth-child(3),
                .curso-detalhes li:nth-child(4) {
                    grid-column: auto;
                    text-align: left;
                    white-space: normal;
                }

                /* BOTÃO */
                .btn-inscricao {
                    font-size: 18px;
                    padding: 12px 22px;
                    margin-top: 19px;
                }

                .btn-voltar {
                    margin-bottom: 30px;
                }
            }
        </style>
    </section>


    <!-- INFORMAÇÕES DO CURSO -->
    <section class="curso-informacoes">
        <div class="container-informacoes d-none">
            <h2 class="curso-info-titulo">Informações do Projeto</h2>
            <div class="curso-info-card">
                <div class="curso-info-programacao">

                    <h2>Sobre a Solicitação</h2>

                    <!-- PROGRAMAÇÃO -->
                    <div class="programacao-grid">

                        <div class="coluna">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>

                        <!-- DIVISOR -->
                        <div class="curso-info-divider"></div>

                        <div class="coluna">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <style>
            /* ===============================
            INFORMAÇÕES DO CURSO
            ================================ */
            .curso-informacoes {
                background-color: #ffffffde;
                padding: 0 0 0px 0;

            }

            .container-informacoes {
                max-width: 1350px;
                margin: 0 auto;
                padding: 0 24px;
            }

            .curso-info-titulo {
                text-align: center;
                font-size: 36px;
                font-weight: 700;
                color: #12455e;
                margin-bottom: 52px;
            }

            .curso-info-card {
                background: #F8FAFC;
                border-radius: 28px;
                padding: 48px 56px;
                display: grid;
                gap: 48px;
                border: 1px solid rgba(23, 90, 120, 0.08);
                box-shadow: 0 6px 18px rgba(23, 90, 120, 0.08), 0 20px 48px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.6) inset;
            }

            .curso-info-programacao {
                font-size: 18px;
                line-height: 1.75;
                color: #12455e;
            }

            .coluna {
                font-weight: 500;
            }

            .curso-info-programacao h2 {
                font-size: 22px;
                font-weight: 700;
                color: #e92d26;
                text-align: center;
                letter-spacing: 1px;
                margin-bottom: 28px;
                text-transform: uppercase;
                position: relative;
                padding-bottom: 14px;
            }

            .curso-info-programacao h2::after {
                content: "";
                display: block;
                width: 250px;
                height: 1px;
                background: #e92d26;
                border-radius: 3px;
                margin: 12px auto 0;
            }

            .curso-topicos {
                margin: 0;
                padding-left: 22px;
            }

            .curso-topicos li {
                font-size: 17px;
                line-height: 1.6;
                color: #0e2e3d;
                margin-bottom: 12px;
            }

            .curso-info-divider {
                width: 1px;
                background: linear-gradient(to bottom, transparent, #ff3b30, transparent);
                border-radius: 2px;
            }

            .programacao-grid {
                display: grid;
                grid-template-columns: 1fr 1px 1fr;
                gap: 20px;
                align-items: stretch;
            }

            .programacao-grid p {
                margin-bottom: 10px;
            }

            .programacao-grid .palestrante {
                padding-left: 16px;
                font-size: 16px;
                font-style: italic;
                opacity: 0.85;
            }

            .curso-info-divider {
                width: 1px;
                background: linear-gradient(to bottom,
                        transparent,
                        #e92d26,
                        transparent);
                border-radius: 2px;
            }

            .curso-info-fotos {
                margin-top: 40px;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 25px;
                flex-wrap: wrap;
            }

            .curso-info-fotos-botao {
                display: inline-block;
                background: linear-gradient(135deg, #0c7c5d, #027353);
                color: #fff;
                padding: 9px 23px;
                border-radius: 12px;
                font-size: 19px;
                font-weight: 500;
                text-decoration: none;
                order: 1;
            }

            .curso-info-fotos-texto {
                font-size: 18px;
                color: #12455e;
                opacity: 0.95;
                margin: 0;
                order: 2;
            }

            /* ===============================
            RESPONSIVO
            ================================ */
            @media (max-width: 768px) {

                .curso-palestrantes {
                    padding: 0px 0 60px !important;
                }

                .curso-informacoes {
                    padding: 0 0 0px 0 !important;
                }

                .curso-info-titulo {
                    font-size: 24px;
                    margin-bottom: 28px;
                }

                .curso-info-card {
                    grid-template-columns: 1fr;
                    gap: 40px;
                    padding: 32px 22px;
                    border-radius: 22px;
                }

                /* DIVISOR HORIZONTAL */
                .curso-info-divider {
                    width: 100%;
                    height: 2px;
                    background: linear-gradient(to right,
                            transparent,
                            #e92d26,
                            transparent);
                    margin: 4px 0;
                }

                /* TÍTULOS */
                .curso-info-metodologia h2,
                .curso-info-programacao h2 {
                    font-size: 16px;
                    margin-bottom: 15px;
                    padding-bottom: 12px;
                }

                .curso-info-metodologia h2::after,
                .curso-info-programacao h2::after {
                    width: 80%;
                }

                /* TEXTO */
                .curso-info-metodologia,
                .curso-info-programacao {
                    font-size: 16px;
                    line-height: 1.65;
                }

                .curso-topicos li {
                    font-size: 15px;
                }

                .curso-info-divider {
                    display: none;
                }


                .programacao-grid {
                    grid-template-columns: 1fr;
                    gap: 20px;
                }

                .curso-info-divider {
                    display: none;
                }

                .programacao-grid {
                    grid-template-columns: 1fr;
                    gap: 20px;
                }

                .programacao-grid .palestrante {
                    font-size: 14px;
                }

                /* FOTOS DO EVENTO */
                .curso-info-fotos {
                    margin-top: 20px;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                    gap: 14px;
                }

                .curso-info-fotos-texto {
                    order: 1;
                    font-size: 14px;
                }

                .curso-info-fotos-botao {
                    order: 2;
                    font-size: 15px;
                    padding: 10px 22px;
                }
            }
        </style>
    </section>


    <!-- FICHA DE SOLICITAÇÃO -->
    <section id="universitario" class="section-universitario">
        <h2 class="curso-info-titulo">Ficha de Solicitação</h2>

        <div class="page-wrap">
            <form action="<?= base_url() ?>universitario/salvar" method="POST" id="form-send">
                <div class="form-card">

                    <div class="form-header">
                        <div>
                            <h2 class="sub">
                                Para solicitar, basta um representante da instituição preencher a ficha que entraremos em contato. <br>
                            </h2>
                        </div>

                        <span class="badge-soft">
                            <i class="fas fa-graduation-cap"></i>
                            CAPACIFAR UNIVERSITÁRIO
                        </span>
                    </div>

                    <style>
                        .badge-soft {
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                        }
                    </style>
                    <div class="form-body">
                        <div class="form-grid">
							
							<input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro" value="<?=date("Y-m-d H:i:s");?>">
							
                            <!-- Nome da Instituição (2 colunas) -->
                            <div class="form-group col-2">
                                <label for="instituicao">Nome da Instituição</label>
                                <input type="text" class="form-control" id="instituicao" name="instituicao"
                                    placeholder="Nome da Instituição de Ensino" required>
                            </div>

                            <!-- Cidade (1 coluna) -->
                            <div class="form-group col-1">
                                <label for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade"
                                    placeholder="Cidade" required>
                            </div>

                            <!-- Endereço (linha inteira) -->
                            <div class="form-group col-3">
                                <label for="endereco">Endereço</label>
                                <input type="text" class="form-control" id="endereco" name="endereco"
                                    placeholder="Endereço" required>
                            </div>

                            <!-- Cargo -->
                            <div class="form-group col-1">
                                <label for="cargo">Cargo do Responsável</label>
                                <input type="text" class="form-control" id="cargo" name="cargo"
                                    placeholder="Cargo do responsável pela solicitação" required>
                            </div>

                            <!-- Nome -->
                            <div class="form-group col-1">
                                <label for="responsavel">Nome do Responsável</label>
                                <input type="text" class="form-control" id="responsavel" name="responsavel"
                                    placeholder="Nome do responsável pela solicitação" required>
                            </div>

                            <!-- Telefone -->
                            <div class="form-group col-1">
                                <label for="telefone">Telefone do Responsável</label>
                                <input type="text" class="form-control" id="telefone" name="telefone"
                                    placeholder="Tel. do responsável" required>
                            </div>

                            <!-- Email (2 colunas para não sobrar espaço) -->
                            <div class="form-group col-3">
                                <label for="email">Email do Responsável</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email do responsável pela solicitação" required>
                            </div>

                            <!-- Evento -->
                            <div class="form-group col-2">
                                <label for="evento">Nome do Evento</label>
                                <input type="text" class="form-control" id="evento" name="evento"
                                    placeholder="Nome do evento que será realizado (se houver)" required>
                            </div>

                            <!-- Tipo de acesso -->
                            <fieldset class="form-group col-1 access-fieldset">
                                <legend>Acesso ao Evento</legend>
                                <div class="access-options">
                                    <label class="access-option">
                                        <input type="radio" name="acesso" value="0" checked required>
                                        <span><i class="fa-solid fa-gift" aria-hidden="true"></i> Gratuito</span>
                                    </label>
                                    <label class="access-option">
                                        <input type="radio" name="acesso" value="1" required>
                                        <span><i class="fa-solid fa-credit-card" aria-hidden="true"></i> Pago</span>
                                    </label>
                                </div>
                            </fieldset>

                            <!-- Data -->
                            <div class="form-group col-1">
                                <label for="data">Data e Hora</label>
                                <input type="datetime-local" class="form-control" id="data" name="data"
                                    min="<?=date('Y-m-d\T00:00', strtotime('+15 days'))?>" required>
                                <small class="text-muted">Selecione uma data com pelo menos 15 dias de antecedência.</small>
                            </div>

                            <!-- Público -->
                            <div class="form-group col-1">
                                <label for="publico">Público Estimado</label>
                                <input type="text" class="form-control" id="publico" name="publico"
                                    placeholder="Público estimado" required>
                            </div>

                            <!-- Períodos -->
                            <div class="form-group col-1">
                                <label for="periodo">Períodos</label>
                                <input type="text" class="form-control" id="periodo" name="periodo"
                                    placeholder="Quais períodos do curso estarão presentes?" required>
                            </div>

                            <!-- ALERTA -->
                            <div class="alert alert-primary alert-full" role="alert">
                                <p>
                                    Indique o tema que deseja levar aos seus alunos (qualquer área da Farmácia).
                                    Faremos o possível para atendê-lo.<br>
                                    Pedimos também que selecione um tema alternativo dentre as opções sugeridas,
                                    caso não seja possível viabilizar o tema principal.
                                </p>
                            </div>

                            <!-- Tema -->
                            <div class="form-group col-3">
                                <label for="temas">Selecione abaixo o tema de seu interesse</label>
                                <select class="form-select" id="temas" name="temas" required>
                                    <option selected>Tema de interesse</option>
                                    <option value="1">CRF/MG: Conhecendo Seu Conselho Profissional</option>
                                    <option value="2">Uso Racional de Medicamentos e o Protagonismo Farmacêutico</option>
                                    <option value="3">Atuação em Drogaria: Muito Além da Dispensação</option>
                                    <option value="4">Novas áreas da profissão farmacêutica e o Papel do CRF/MG</option>
                                    <option value="6">CRF/MG: Conhecimento, Ética e Responsabilidade</option>
                                    <option value="5">Outros</option>
                                </select>
                            </div>

                            <!-- Projeto -->
                            <div class="form-group col-3">
                                <label for="projeto">Selecione o projeto que também queira de seu interesse</label>
                                <select class="form-select" id="projeto" name="outros" required>
                                    <option selected>Selecione o projeto</option>
                                    <option value="URM">Uso Racional de Medicamentos</option>
                                    <option value="FISC. HUMANIZADA">Fiscalização Humanizada</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>

                            <!-- Observações -->
                            <div class="form-group col-3">
                                <label for="observacoes">Observações</label>
                                <textarea class="form-control" id="observacoes" name="observacoes"
                                    rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="form-footer">
                        <div class="footer-info">
                            <i class="fas fa-shield-alt"></i>
                            <span>Ao enviar, você confirma a veracidade dos dados e autoriza seu uso apenas para retorno da solicitação.</span>
                        </div>

                        <button type="submit" class="btn-enviar" id="btn-send">
                            <span>Enviar solicitação</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>

                    <?php echo form_close(); ?>

                </div>
            </form>
        </div>

        <style>
            /* =========================================
            SECTION UNIVERSITÁRIO – VERSÃO FINAL LIMPA
            ========================================= */

            :root {
                --brand: #12455e;
                --brand-light: #e6f0f5;
                --accent: #e92d26;
                --ink: #0f172a;
                --muted: #64748b;
                --line: #e2e8f0;
            }

            /* =========================
            FUNDO
            ========================= */
            body {
                background:
                    radial-gradient(800px 400px at 10% 0%, #eef6fb, transparent),
                    radial-gradient(600px 300px at 90% 10%, #f0f9ff, transparent),
                    linear-gradient(180deg, #f8fbff, #ffffff);
            }

            /* =========================
            SECTION
            ========================= */
            .section-universitario {
                padding: 15px 20px 70px;
                background-color: #ffffffde;
            }

            .section-universitario .page-wrap {
                max-width: 1200px;
                margin: 0 auto;
            }

            /* =========================
            TÍTULO
            ========================= */
            .section-universitario .curso-info-titulo {
                text-align: center;
                font-size: 36px;
                font-weight: 700;
                color: var(--brand);
                margin-bottom: 50px;
            }

            /* =========================
            CARD
            ========================= */
            .section-universitario .form-card {
                background: #ffffff;
                border-radius: 22px;
                border: 1px solid rgba(18, 69, 94, 0.08);
                box-shadow:
                    0 10px 30px rgba(18, 69, 94, 0.08),
                    0 25px 60px rgba(0, 0, 0, 0.08);
                overflow: hidden;
            }

            /* =========================
            HEADER
            ========================= */
            .section-universitario .form-header {
                padding: 28px 32px;
                background: linear-gradient(135deg, #f0f7fb, #ffffff);
                border-bottom: 1px solid var(--line);
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
                flex-wrap: wrap;
            }

            .section-universitario .form-header .sub {
                font-size: 16px;
                font-weight: 600;
                color: #0a2d3f;
                max-width: 650px;
            }

            /* BADGE */
            .section-universitario .badge-soft {
                background: var(--brand-light);
                color: var(--brand);
                font-weight: 700;
                font-size: 13px;
                padding: 10px 18px;
                border-radius: 999px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                white-space: nowrap;
            }

            /* =========================
            BODY
            ========================= */
            .section-universitario .form-body {
                padding: 32px;
            }

            /* =========================
            GRID DESKTOP
            ========================= */
            .form-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 18px 20px;
            }

            .col-1 {
                grid-column: span 1;
            }

            .col-2 {
                grid-column: span 2;
            }

            .col-3 {
                grid-column: span 3;
            }

            /* =========================
            FORM GROUP
            ========================= */
            .section-universitario .form-group {
                width: 100%;
            }

            /* =========================
            LABELS
            ========================= */
            .section-universitario .form-group label {
                display: block;
                font-size: 13px;
                font-weight: 700;
                margin-bottom: 6px;
                color: var(--ink);
            }

            .section-universitario .access-fieldset {
                min-width: 0;
                margin: 0;
                padding: 0;
                border: 0;
            }

            .section-universitario .access-fieldset legend {
                float: none;
                width: auto;
                margin-bottom: 6px;
                font-size: 13px;
                font-weight: 700;
                color: var(--ink);
            }

            .section-universitario .access-options {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
                padding: 5px;
                border: 1px solid #dbe3ea;
                border-radius: 14px;
                background: #f9fbfd;
            }

            .section-universitario .access-option {
                margin: 0;
                cursor: pointer;
            }

            .section-universitario .access-option input {
                position: absolute;
                opacity: 0;
                pointer-events: none;
            }

            .section-universitario .access-option span {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                min-height: 42px;
                padding: 8px 10px;
                border-radius: 10px;
                color: #52616b;
                font-size: 13px;
                font-weight: 700;
                transition: all .2s ease;
            }

            .section-universitario .access-option input:checked + span {
                color: #ffffff;
                background: var(--brand);
                box-shadow: 0 5px 12px rgba(18, 69, 94, 0.2);
            }

            .section-universitario .access-option input:focus-visible + span {
                outline: 3px solid rgba(18, 69, 94, 0.25);
                outline-offset: 2px;
            }

            /* =========================
            INPUTS
            ========================= */
            .section-universitario .form-control,
            .section-universitario .form-select,
            .section-universitario textarea {
                width: 100% !important;
                max-width: 100% !important;
                padding: 14px 16px;
                border-radius: 14px;
                border: 1px solid #dbe3ea;
                font-size: 14px;
                background: #f9fbfd;
                transition: all .2s ease;
                display: block;
            }

            .section-universitario textarea {
                min-height: 120px;
                resize: vertical;
            }

            .section-universitario .form-control:focus,
            .section-universitario .form-select:focus,
            .section-universitario textarea:focus {
                border-color: var(--brand);
                background: #ffffff;
                box-shadow: 0 0 0 4px rgba(18, 69, 94, 0.12);
                outline: none;
            }

            /* =========================
            ALERT
            ========================= */
            .section-universitario .form-grid .alert-full {
                grid-column: 1 / -1;
                border-radius: 16px;
                padding: 22px;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            /* =========================
            FOOTER
            ========================= */
            .section-universitario .form-footer {
                padding: 26px 32px;
                border-top: 1px solid var(--line);
                background: #f8fbfd;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 24px;
                flex-wrap: wrap;
            }

            .section-universitario .footer-info {
                display: flex;
                align-items: center;
                gap: 13px;
                font-size: 16px;
                font-weight: 500;
                color: #0a2d3f;
            }

            .section-universitario .footer-info i {
                color: var(--brand);
            }

            /* BOTÃO */
            .section-universitario .btn-enviar {
                background: var(--brand);
                border: none;
                color: #fff;
                padding: 14px 30px;
                border-radius: 14px;
                font-weight: 700;
                font-size: 16px;
                cursor: pointer;

                display: inline-flex;
                align-items: center;
                gap: 10px;

                transition: background 0.2s ease;
            }

            .section-universitario .btn-enviar:hover {
                background: #0c3447;
                box-shadow: none;
            }

            /* =========================================
            RESPONSIVO
            ========================================= */

            /* TABLET */
            @media (max-width: 992px) {

                .form-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .col-3 {
                    grid-column: span 2;
                }

                .section-universitario .form-header {
                    flex-direction: column;
                    align-items: flex-start;

                }

                .badge-soft {
                    display: none !important;
                }

            }

            /* MOBILE */
            @media (max-width: 600px) {


                .form-grid {
                    grid-template-columns: 1fr;
                }

                .col-1,
                .col-2,
                .col-3 {
                    grid-column: span 1;
                }

                .section-universitario {
                    padding: 10px 16px 35px;
                }

                .section-universitario .form-body {
                    padding: 20px;
                }

                .section-universitario .curso-info-titulo {
                    font-size: 26px;
                    margin-bottom: 30px;
                }

                .section-universitario .form-footer {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 18px;
                }

                .section-universitario .footer-info {
                    justify-content: flex-start;
                    text-align: left;
                    font-size: 15px;
                    margin-bottom: 10px;
                    line-height: 1.4;
                }

                .section-universitario .btn-enviar {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>
    </section>

</body>


<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    $(function() {
        <?php if (validation_errors() != "") { ?>
            new Toast({
                message: 'Não foi possível enviar os dados. Verifique o preenchimento da ficha.',
                type: 'danger'
            });
        <?php } ?>

        $("#form-send").on('submit', function() {
            $("#btn-send").prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Enviando...");
        });
    });
</script>

<script type="text/javascript">
    /*var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : 'your_site_key'
        });
      };*/
</script>

<script>
    function valida() {
        if (grecaptcha.getResponse() == "") {
            alert("Você precisa marcar que não é um robô!");
            return false;
        } else {
            return true;
        }
    }

    $(function() {
        <?php
        if (validation_errors() != "") {
        ?>
            new Toast({
                message: 'N�o foi poss�vel enviar os dados. Verifique o preenchimento da ficha.',
                type: 'danger'
            });
        <?php
        }
        ?>
    });
</script>

<script>
    $(function() {
        /* iniciar a pagina chamando a function para setar o select do UF e cidades */
        toggleSelectNaturalidade($("input[name=nacionalidade]:checked").val());
        setSelectUf('uf_natural', 'naturalidade', "<?= $uf_natural_val ?>", "<?= $naturalidade_val ?>");
        setSelectUf('uf_instituicao_ensino', 'cidade_instituicao_ensino', "<?= $uf_instituicao_ensino_val ?>", "<?= $cidade_instituicao_ensino_val ?>");
        setSelectUf('uf_origem', 'cidade_origem', "<?= $uf_origem_val ?>", "<?= $cidade_origem_val ?>");
        setSelectUf('uf_titulo_eleitoral', 'cidade_origem', "<?= $uf_titulo_eleitoral_val ?>", "<?= $cidade_origem_val ?>");
        getInstituicaoEnsino();
        toggleUfOrigem();


        $("input[name=nacionalidade]").click(function() {
            toggleSelectNaturalidade($(this).val());
        });


        $("select[name='cidade_instituicao_ensino']").change(function() {
            getInstituicaoEnsino();
        });

        $("select[name='select_instituicao_ensino']").change(function() {
            if ($("select[name='select_instituicao_ensino'] option:selected").val() == "outro") {
                $("input[name='instituicao_ensino']").show();
            } else {
                $("input[name='instituicao_ensino']").hide();
            }
        });


        $("select[name='forma_ingresso']").change(function() {
            toggleUfOrigem();
        });

        function toggleUfOrigem() {
            if ($("select[name='forma_ingresso'] option:selected").val() == "Transfer�ncia") {
                $("#box_uf_origem").show();
            } else {
                $("#box_uf_origem").hide();
            }
        }




        function getInstituicaoEnsino() {

            var fd = new FormData();
            fd.append('uf', $("select[name='uf_instituicao_ensino'] option:selected").val());
            fd.append('cidade', $("select[name='cidade_instituicao_ensino'] option:selected").val());

            $.ajax({
                type: "POST",
                method: 'POST',
                url: "<?= base_url() ?>inscricao_pf/getInstituicaoEnsino",
                data: fd,
                dataType: 'JSON',
                contentType: false,
                processData: false,

                beforeSend: function() {
                    $("select[name='select_instituicao_ensino']").fadeOut('fast');
                },
                success: function(res) {
                    // console.log(res);   
                }
            }).done(function(res) {
                // console.log(res);
            }).fail(function(res) {
                // console.log(res);
            }).always(function(res) {
                $("select[name='select_instituicao_ensino']").fadeIn('fast');
                $("select[name='select_instituicao_ensino']").removeAttr('disabled');
                if (res != "") {
                    res.forEach(element => {

                        var label = element.Sigla === null ? element.Instituicao : element.Sigla + " - " + element.Instituicao;
                        var value = element.InstituicaoId;

                        $("select[name='select_instituicao_ensino']").append('<option value=' + value + '>' + label + '</option>');
                    });
                    $("select[name='select_instituicao_ensino']").append('<option value="outro">Outros</option>');
                }
            });
        }

        function toggleSelectNaturalidade(nacionalidade) {
            $("#uf_natural").removeAttr("disabled", "disabled");
            $("#naturalidade").removeAttr("disabled", "disabled");
            setSelectUf('uf_natural', 'naturalidade', "<?= $uf_natural_val ?>", "<?= $naturalidade_val ?>");

            if (nacionalidade != "brasileiro") {
                $("#outra_nacionalidade").show();
                if (nacionalidade == "estrangeiro_nao_naturalizado") {
                    $("#uf_natural").html('<option>Selecione</option>').attr("disabled", "disabled");
                    $("#naturalidade").html('<option>Selecione</option>').attr("disabled", "disabled");
                }
            } else {
                $("#outra_nacionalidade").hide();
            }
        }

        function setSelectUf(select_estado, select_cidade, estadoVal, cidadeVal) {
            new dgCidadesEstados({
                estado: document.getElementById(select_estado),
                cidade: document.getElementById(select_cidade),
                estadoVal,
                cidadeVal,
            });
        }


        $("#form-send").submit(function() {
            $("#btn-send").prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
        });
    });
</script>
