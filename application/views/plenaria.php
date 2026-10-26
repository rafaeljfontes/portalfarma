
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Farma - Plenárias Técnicas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/style_caminhos.css">
    <link rel="stylesheet" href="assets/css/style_iniciativas.css">
    <link rel="stylesheet" href="assets/css/style_selector.css">
    <link rel="stylesheet" href="assets/css/style_cursos.css">
    <link rel="stylesheet" href="assets/css/style_bjhp_documentos.css">


    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	
	<!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/css/style_caminhos.css">
    <link rel="stylesheet" href="assets/css/style_iniciativas.css">
    <link rel="stylesheet" href="assets/css/style_selector.css">
    <link rel="stylesheet" href="assets/css/style_cursos.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

	<style>
			
			
		:root {
			--azul-escuro: #005691;
			--azul-claro: #eef6fb;
			--texto-cor: #333;
			--borda: #ddd;
		}
		.container_Acordeon {
			width: 100%;
			max-width: 900px;
			background: white;
			box-shadow: 0 4px 10px rgba(0,0,0,0.1);
			border-radius: 8px;
			overflow: hidden;
		}

		.header_Acordeon {
			background-color: var(--azul-escuro);
			color: white;
			padding: 15px;
			text-align: center;
			font-weight: bold;
			font-size: 1.1rem;
		}

		/* Estilização do Acordeon */
		details {
			border-bottom: 1px solid var(--borda);
			transition: background 0.3s ease;
		}

		details:last-child {
			border-bottom: none;
			}

		summary {
			padding: 20px;
			cursor: pointer;
			list-style: none;
			display: flex;
			justify-content: space-between;
			align-items: center;
			font-weight: bold;
			color: var(--azul-escuro);
			font-size: 1.1rem;
			text-transform: uppercase;
			text-align: left;
		}

		summary:hover {
			background-color: var(--azul-claro);
		}

		/* Ícone de seta customizado */
		summary::after {
			content: '▼';
			font-size: 0.8rem;
			transition: transform 0.3s;
		}

		details[open] summary::after {
			transform: rotate(180deg);
		}

		details[open] summary {
			border-bottom: 1px solid var(--borda);
			background-color: var(--azul-claro);
		}

		.content {
			padding: 20px;
			display: flex;
			flex-wrap: wrap;
			gap: 15px;
			background-color: #fafafa;
		}

		.date-info {
			width: 100%;
			font-size: 0.9rem;
			color: #666;
			margin-bottom: 5px;
			font-weight: normal;
			display: block;
		}

		/* Estilização dos Botões */
		.btn {
			display: inline-flex;
			align-items: center;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			font-weight: 600;
			font-size: 0.9rem;
			transition: opacity 0.2s;
		}

		.btn-youtube {
			background-color: #cc0000;
			color: white;
		}

		.btn-fotos {
			background-color: var(--azul-escuro);
			color: white;
		}

		.btn:hover {
			opacity: 0.85;
		}

		@media (max-width: 600px) {
			.content {
				flex-direction: column;
			}
			.btn {
				width: 100%;
				justify-content: center;
			}
		}
		
		.curso-info-links {
			display: flex;
			justify-content: center;
			width: 100%;
			font-family: sans-serif;
		}
		
	</style>
	<style>
		body {
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .container-inscricao {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .curso-hero {
            padding: 0px 0 75px;
            background-color: #ffffffde;
			margin-top: 80px;
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
            margin-bottom: 52px;
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
    </style>
	<style>
		/* ===============================
		RESPONSIVO COMPLETO
		=============================== */

		/* ===== Tablets grandes (1024px) ===== */
		@media (max-width: 1024px) {

			.curso-hero {
				padding: 20px 0 40px;
			}

			.curso-hero-grid {
				gap: 20px;
			}

			.curso-titulo {
				font-size: 34px;
				line-height: 1.25;
			}

			.curso-publicacao {
				font-size: 16px;
				line-height: 1.6;
			}

			.curso-hero-card {
				padding: 36px 8px;
				border-radius: 24px;
				margin: 0;

			}

			.curso-detalhes li {
				font-size: 18px;
				line-height: 1.5;
			}

			.btn-inscricao {
				font-size: 22px;
				padding: 12px 24px;
			}
		}


		/* ===== Tablets / Mobile médio (768px) ===== */
		@media (max-width: 768px) {

			.curso-hero {
				padding: 15px 0 30px;

			}


			.curso-hero-grid {
				grid-template-columns: 1fr;
				gap: 10px;
			}

			.curso-titulo {
				font-size: 26px;
				line-height: 1.25;
				margin-bottom: 16px;
			}

			.curso-publicacao {
				font-size: 15px;
				line-height: 1.6;
			}

			.curso-hero-card {
				padding: 30px;
				border-radius: 20px;
			}

			.curso-detalhes {
				gap: 8px;
			}

			.curso-detalhes li {
				font-size: 15px;
				line-height: 1.5;
			}

			.btn-inscricao {
				font-size: 18px;
				padding: 12px 20px;
				margin-top: 16px;
			}

			.btn-voltar {
				font-size: 13px;
				padding: 6px 14px;
				margin-bottom: 30px;
			}
		}


		/* ===== Mobile pequeno (480px) ===== */
		@media (max-width: 480px) {

			.curso-hero {
				padding: 10px 0 25px;
			}

			.curso-titulo {
				font-size: 22px;
				line-height: 1.2;
			}

			.curso-publicacao {
				font-size: 14px;
			}

			.curso-hero-card {
				padding: 26px;
				border-radius: 18px;
			}

			.curso-detalhes li {
				font-size: 14px;
			}

			.btn-inscricao {
				font-size: 16px;
				padding: 10px 18px;
			}
		}


		/* ===== Mobile muito pequeno (360px) ===== */
		@media (max-width: 360px) {

			.curso-titulo {
				font-size: 20px;
			}

			.curso-publicacao {
				font-size: 13px;
			}

			.curso-detalhes li {
				font-size: 13px;
			}

			.btn-inscricao {
				font-size: 15px;
				padding: 9px 16px;
			}
		}
	</style>
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
			width: 95%;
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
		
		.dia-num{			
			background: #ffffff;
			color: #DE3742;
			border: 2px solid #DE3742;
			border-radius: 10px;
		}
	</style>
		
</head>

<body>
    <!-- BANNER-->
    <section class="banner-curso">
        <div class="banner-container">
            <img
                src="assets\banner_projetos\Plenaria_Banner.png"
                alt="Uso racional de medicamentos"
                class="banner-imagem">
        </div>

        
    </section>
<!-- SEMINARIOS DE VIGILÂNCIA E SAÚDE -->
    <section class="curso-hero">
        <div class="container-inscricao">
            <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>


            <div class="curso-hero-grid">
                <div class="curso-hero-info">
                    <h1 class="curso-titulo destaque">Plenárias Técnicas</h1>
                    <p class="curso-publicacao">
						
					</p>
                </div>
            </div>
        </div>
    </section>
<!-- CURSOS -->
    <section id="filtro" class="section-cursos">
        <div class="container-portal">
            <div class="tabs-content">
                <div class="tab-pane active" id="farmaceutico">
                    <div class="cards-wrapper" style="margin-top: 80px;">
                        <div class="cards-track">

                            <?php
							
                            foreach ($plenarias as $campo) {
								
                                
                            ?>

                                <div class="card-curso">

                                    <!-- IMAGEM -->
                                    <div class="card-curso-topo">
                                        <img
                                            src="<?= base_url() ?>public/planaria_tecnica.png"
                                            alt="<?= $campo->titulo ?>">
                                    </div>

                                    <!-- INFO -->
                                    <div class="card-curso-info">
                                       
                                            <span class="dia-num"><?= $campo->dia; ?> de <?= mb_strtoupper($campo->mes); ?></span>
                                       

                                        <span>
                                            <i class="bi bi-clock"></i>
                                            <?= $campo->hora ?> hrs
                                        </span>
										
                                        <span class="publico-evento">
                                            PARA O FARMACÊUTICO
                                        </span>
                                    </div>

                                    <!-- BODY -->
                                    <div class="card-curso-body">

                                        <div class="titulo-wrapper">
                                            <h3 class="nome-curso">
                                                <?= $campo->titulo ?>
                                            </h3>
                                        </div>
										
										<a href="<?=$campo->link_youtube ?>"
                                            class="btn-saiba-mais">
												<i class="fa-brands fa-youtube"></i> Link Youtube
											</a>
                                        

                                    </div>
									
                                </div>

                            <?php } ?>

                        </div>

                        <div class="paginacao-cursos"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>