<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8">
	<title>Porta Farma - Pesquisa Científica</title>

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

	<style>
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
			padding: 0px 0 32px;
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
			margin: 40px 0;
		}

		.curso-detalhes {
			list-style: none;
			padding: 0;
			margin-bottom: 25px;
		}

		.curso-detalhes li {
			font-size: 21px;
			color: #12455e;
			text-align: center;
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
</head>

<body>
	<!-- BANNER-->
	<section class="banner-curso">
		<div class="banner-container">
			<img
				src="assets\banner_projetos\Banner-Projetos_PESQUISA CIENTIFICA.jpg"
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
		</style>
	</section>

	<!-- PESQUISA CIENTIFICA -->
	<section class="curso-hero">
		<div class="container-inscricao">
			<a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>


			<div class="curso-hero-grid">
				<div class="curso-hero-info">
					<h1 class="curso-titulo destaque">Pesquisa Científica</h1>
					<p class="curso-publicacao">
						No intuito de auxiliar os diversos pesquisadores, de instituições de todo o país, que solicitam apoio do CRF/MG para divulgação de suas pesquisas científicas, criamos este espaço que visa divulgar o link de formulários para coletas de dados de pesquisas em andamento, cujo tema seja relevante para área farmacêutica.
				</div>

				<div class="curso-hero-card">
					<ul class="curso-detalhes">
						<li>Para se cadastrar, o pesquisador solicitante deve responder o formulário disponível abaixo:</li>
					</ul>
					<a href="<?=base_url()?>pesquisa-cientifica/formulario"
						rel="noopener noreferrer"
						class="btn-inscricao grande">
						TERMO DE APOIO À PESQUISA
					</a>
				</div>
			</div>
		</div>

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
	</section>

	<!-- INFORMAÇÕES DO PROJETO -->
	<section class="curso-informacoes">
		<div class="container-informacoes">
			<h2 class="curso-info-titulo">Informações do Projeto</h2>
			<div class="curso-info-card">
				<div class="curso-info-programacao">

					<h2>ATENÇÃO</h2>

					<!-- ATENÇÃO -->
					<div class="programacao-grid">
						<div class="coluna">
							<P>Deverá ser informado o título da pesquisa, dados dos autores, dados do orientador, nome da instituição, objetivo e parecer do Comitê de Ética em Pesquisa. Após análise da Assessoria Técnica e deferimento pela Diretoria do CRF/MG (aproximadamente 15 dias), a pesquisa poderá ser divulgada no site.</P>
						</div>

						<!-- DIVISOR -->
						<div class="curso-info-divider"></div>
						<div class="coluna">
							<p>O CRF/MG não participa como coautor ou parceiro na pesquisa e, dessa forma, não se responsabiliza pela análise e tratamento dos dados coletados. Este é apenas um apoio técnico para a divulgação do questionário, cuja participação é totalmente opcional e voluntária.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
			/* ===============================
            INFORMAÇÕES DO PROJETO
            ================================ */
			.curso-informacoes {
				background-color: #ffffffde;
				padding: 25px 0 80px;
			}

			.container-informacoes {
				max-width: 1350px;
				margin: 0 auto;
				padding: 0 24px;
			}

			.curso-info-titulo {
				text-align: center;
				margin-bottom: 60px;

				font-size: 36px;
				font-weight: 700;
				color: #12455e;
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
			RESPONSIVO COMPLETO - INFORMAÇÕES DO PROJETO
			=============================== */

			/* ===== 1024px ===== */
			@media (max-width: 1024px) {

				.curso-informacoes {
					padding: 20px 0 50px;
				}

				.curso-info-titulo {
					font-size: 30px;
					margin-bottom: 40px;
				}

				.curso-info-card {
					padding: 36px 32px;
					border-radius: 24px;
					gap: 36px;
				}

				.curso-info-programacao {
					font-size: 17px;
					line-height: 1.7;
				}

				.curso-info-programacao h2 {
					font-size: 20px;
					margin-bottom: 22px;
				}

				.programacao-grid {
					gap: 18px;
				}
			}


			/* ===== 768px ===== */
			@media (max-width: 768px) {

				.curso-informacoes {
					padding: 15px 0 40px !important;
				}

				.container-informacoes {
					padding: 0 20px;
				}

				.curso-info-titulo {
					font-size: 24px;
					margin-bottom: 24px;
					line-height: 1.3;
				}

				.curso-info-card {
					padding: 24px 20px;
					border-radius: 20px;
					gap: 24px;
				}

				.curso-info-programacao {
					font-size: 15px;
					line-height: 1.6;
				}

				.curso-info-programacao h2 {
					font-size: 18px;
					margin-bottom: 18px;
					padding-bottom: 10px;
				}

				.curso-info-programacao h2::after {
					width: 140px;
				}

				.programacao-grid {
					grid-template-columns: 1fr;
					gap: 16px;
				}

				.coluna {
					font-size: 14px;
					margin-bottom: -10px;
					line-height: 1.6;
				}

				.curso-info-divider {
					display: none;
				}
			}


			/* ===== 480px ===== */
			@media (max-width: 480px) {

				.curso-info-titulo {
					font-size: 20px;
					margin-bottom: 20px;
				}

				.curso-info-card {
					padding: 20px 18px;
					border-radius: 18px;
				}

				.curso-info-programacao {
					font-size: 14px;
					line-height: 1.55;
				}

				.curso-info-programacao h2 {
					font-size: 16px;
					margin-bottom: 10px;
				}

				.programacao-grid {
					gap: 14px;
				}
			}


			/* ===== 360px ===== */
			@media (max-width: 360px) {

				.curso-info-titulo {
					font-size: 18px;
				}

				.curso-info-programacao {
					font-size: 13px;
				}

				.curso-info-programacao h2 {
					font-size: 15px;
				}
			}
		</style>
	</section>

	<!-- PESQUISAS -->
	<section class="section-pesquisas">

		<div class="container-pesquisas">

			<h2 class="pesquisa-info-titulo">Pesquisas</h2>

			<div class="carousel">

				<!-- BOTÃO ESQUERDA -->
				<button class="carousel-btn prev">&#10094;</button>

				<!-- TRACK -->

				<div class="carousel-viewport">

					<div class="carousel-track">

						<?php
						if (empty($tabelaCientifica)) {

							echo "<div class='card aviso'>
                        Nenhuma pesquisa cadastrada até o momento
                    </div>";
						} else {

							foreach ($tabelaCientifica as $row) {

								$dataAtual = date("Y-m-d");

								$statusAberto = ($row->data_expiracao >= $dataAtual);

								$status = $statusAberto
									? "ABERTO ATÉ " . date('d/m/Y', strtotime($row->data_expiracao))
									: "DATA EXPIRADA";

								$statusClass = $statusAberto
									? "status-aberto"
									: "status-fechado";

								/* AUTORES */
								$autoresHtml = $row->autores;

								$autoresHtml = preg_replace(
									'/<p[^>]*><strong><u>Autores:<\/u><\/strong><\/p>/i',
									'',
									$autoresHtml
								);

								preg_match_all(
									'/<strong>(.*?)<\/strong>(.*?)(?=<strong>|$)/is',
									$autoresHtml,
									$matches,
									PREG_SET_ORDER
								);

								$autoresArray = [];

								foreach ($matches as $match) {

									$autoresArray[] = [
										'nome' => trim(strip_tags($match[1])),
										'info' => trim(strip_tags($match[2]))
									];
								}
						?>

								<!-- CARD -->
								<div class="card-pesquisa">

									<div class="card-header">
										<h3><?= $row->titulo ?></h3>
									</div>

									<div class="card-body">

										<!-- AUTORES -->
										<div class="card-box autores">

											<h4>Autores</h4>

											<div class="card-box-content">

												<?php foreach ($autoresArray as $autor): ?>

													<div class="autor">
														<strong><?= $autor['nome'] ?></strong>
														<div><?= html_entity_decode($autor['info']) ?></div>
													</div>

												<?php endforeach; ?>

												<div class="instituicao">
													<?= $row->instituicao ?>
												</div>

											</div>

										</div>

										<!-- DESCRIÇÃO -->
										<div class="card-box descricao">

											<h4>Descrição</h4>

											<div class="card-box-content">
												<p>
													<?= $row->descricao ?>
												</p>
											</div>
										</div>

									</div>

									<div class="card-footer">

										<?php if ($statusAberto): ?>

											<a href="<?= $row->link ?>"
												target="_blank"
												class="btn-card">
												ACESSAR FORMULÁRIO
											</a>

										<?php else: ?>

											<span class="btn-card btn-disabled">
												ENCERRADO
											</span>
										<?php endif; ?>

										<span class="status <?= $statusClass ?>">
											<?= $status ?>
										</span>

									</div>
								</div>
						<?php
							}
						}
						?>

					</div>
				</div>

				<!-- BOTÃO DIREITA -->
				<button class="carousel-btn next">&#10095;</button>
			</div>
		</div>

		<style>
			.pesquisa-info-titulo {
				text-align: center;
				margin-bottom: 35px;

				font-size: 36px;
				font-weight: 700;
				color: #12455e;
			}

			.section-pesquisas {
				background: #ffffffde;
				padding: 0 0 80px;
			}

			.container-pesquisas {
				width: 100%;
				max-width: 1150px;
				margin: 0 auto;
				padding: 0px 20px;
			}

			/* CARD */
			.card-pesquisa {
				background: white;
				border-radius: 12px;
				box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
				overflow: hidden;
				display: flex;
				flex-direction: column;
				transition: 0.3s;
				border: 1px solid #e5e5e5;
			}

			/* HEADER */
			.card-header h3 {
				background: #155779;
				color: white;
				padding: 25px;
				text-align: center;
				font-size: 18px;
				font-weight: 600;
			}

			/* BODY */
			.card-body {
				display: flex;
				gap: 20px;
				padding: 20px;
				flex-wrap: wrap;
			}

			.card-box {
				flex: 1;
				background: #f8f9fa;
				padding: 15px;
				border-radius: 8px;

				display: flex;
				flex-direction: column;

				max-height: 340px;
			}

			.card-box h4 {
				margin-bottom: 20px;
				font-size: 20px;
				font-weight: 700;
				color: #e92d26;
			}

			.autor {
				margin-bottom: 20px;
			}


			.instituicao {
				margin-top: 10px;
				font-style: italic;
				color: #666;
			}

			.btn-card {
				display: inline-block;
				background: #3B5FC0;
				color: white;
				padding: 10px 16px;
				font-size: 13px;
				font-weight: 700;
				border-radius: 10px;
				text-decoration: none;
			}

			.btn-card:hover {
				background: #1a58b6;
			}

			/* FOOTER */
			.card-footer {
				display: flex;
				align-items: center;
				gap: 10px;
				padding: 16px;
			}

			.status {
				margin-left: auto;
			}

			.btn-card {
				display: inline-flex;
				align-items: center;
				gap: 6px;
			}

			/* STATUS BASE */
			.status {
				display: inline-flex;
				align-items: center;
				gap: 6px;
				padding: 8px 16px;
				border-radius: 999px;
				font-size: 13px;
				font-weight: 600;
				letter-spacing: 0.3px;
				box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
				border: 1px solid transparent;
			}

			/* ABERTO */
			.status-aberto {
				background: linear-gradient(135deg, #d1fae5, #ecfdf5);
				color: #065f46;
				border-color: #a7f3d0;
			}

			/* FECHADO */
			.status-fechado {
				background: linear-gradient(135deg, #fee2e2, #fee2e2);
				color: #7f1d1d;
				border-color: #fecaca;
			}

			/* AVISO */
			.aviso {
				padding: 20px;
				text-align: center;
				background: #fff3cd;
				border: 1px solid #ffeeba;
			}

			.carousel {
				position: relative;
				display: flex;
				align-items: center;
			}

			.carousel-viewport {
				overflow: hidden;
				scroll-snap-type: x mandatory;
				width: 100%;
				padding: 20px 0;
			}

			.carousel-track {
				display: flex;
				gap: 30px;
				scroll-behavior: smooth;
			}

			.card-pesquisa {
				min-width: 100%;
				max-width: 100%;
				scroll-snap-align: start;
				flex-shrink: 0
			}

			.carousel-btn {
				position: absolute;
				top: 50%;
				transform: translateY(-50%);
				background: #12455e;
				color: white;
				border: none;
				font-size: 28px;
				width: 45px;
				height: 45px;
				border-radius: 50%;
				cursor: pointer;
				z-index: 10;
			}

			.carousel-btn.prev {
				left: -100px;
			}

			.carousel-btn.next {
				right: -100px;
			}

			.carousel-btn:hover {
				background: #206385;
			}

			/* ==================================
			RESPONSIVO COMPLETO - PESQUISAS
			================================== */

			/* ===== 1024px ===== */
			@media (max-width: 1024px) {

				.pesquisa-info-titulo {
					font-size: 30px;
					margin-bottom: 28px;
				}

				.carousel-track {
					gap: 24px;
				}

				.card-header h3 {
					font-size: 17px;
					padding: 20px;
				}

				.card-body {
					padding: 18px;
					gap: 18px;
				}

				.card-box {
					min-height: 280px;
					max-height: 280px;
				}

				.card-box h4 {
					font-size: 18px;
				}

				.descricao p {
					font-size: 15px;
				}

				.btn-card {
					font-size: 13px;
					padding: 9px 14px;
				}

				.status {
					font-size: 12px;
				}
			}

			/* ===== 768px ===== */
			@media (max-width: 768px) {

				.section-pesquisas {
					padding: 0 0 50px;
				}

				.pesquisa-info-titulo {
					font-size: 24px;
					margin-bottom: 22px;
				}

				.carousel-btn {
					display: none;
				}

				.carousel-viewport {
					overflow-x: auto;
					overflow-y: hidden;
					padding: 10px 0 20px;
					-webkit-overflow-scrolling: touch;
				}

				.carousel-track {
					gap: 16px;
					padding: 0 16px;
				}

				.card-pesquisa {
					min-width: 92%;
					border-radius: 14px;
				}

				.card-header h3 {
					font-size: 15px;
					padding: 16px;
					line-height: 1.4;
				}

				.card-body {
					flex-direction: column;
					gap: 14px;
					padding: 14px;
				}

				.card-box {
					min-height: 220px;
					max-height: 220px;
					padding: 12px;
				}

				.card-box h4 {
					font-size: 16px;
					margin-bottom: 10px;
				}

				.autor strong {
					font-size: 14px;
				}

				.autor div,
				.instituicao {
					font-size: 13px;
					line-height: 1.4;
				}

				.descricao p {
					font-size: 14px;
					line-height: 1.5;
				}

				.card-footer {
					padding: 14px;
				}

				.btn-card {
					font-size: 12px;
					padding: 8px 12px;
				}

				.status {
					font-size: 11px;
					padding: 6px 10px;
				}
			}

			/* ===== 480px ===== */
			@media (max-width: 480px) {

				.pesquisa-info-titulo {
					font-size: 20px;
					margin-bottom: 18px;
				}

				.card-pesquisa {
					min-width: 94%;
				}

				.card-header h3 {
					font-size: 14px;
					padding: 14px;
				}

				.card-box {
					min-height: 190px;
					max-height: 190px;
				}

				.card-box h4 {
					font-size: 15px;
				}

				.descricao p {
					font-size: 13px;
				}

				.btn-card {
					font-size: 11px;
					padding: 7px 10px;
				}

				.status {
					font-size: 10px;
					padding: 5px 8px;
				}
			}

			/* ===== 360px ===== */
			@media (max-width: 360px) {

				.pesquisa-info-titulo {
					font-size: 18px;
				}

				.card-header h3 {
					font-size: 13px;
				}

				.card-box {
					min-height: 170px;
					max-height: 170px;
				}

				.descricao p {
					font-size: 12px;
				}

				.btn-card {
					font-size: 10px;
				}

				.status {
					font-size: 9px;
				}
			}
		</style>
	</section>

	<style>
		.card-box {
			flex: 1;
			background: #f8f9fa;
			padding: 15px;
			border-radius: 8px;

			display: flex;
			flex-direction: column;
		}

		.card-box-content {
			flex: 1;
			overflow-y: auto;
			overflow-x: hidden;
		}

		.card-box-content,
		.card-box-content p,
		.autor div,
		.instituicao {
			word-break: break-word;
			overflow-wrap: break-word;
		}

		.card-box-content::-webkit-scrollbar {
			width: 6px;
		}

		.card-box-content::-webkit-scrollbar-thumb {
			background: #cbd5e1;
			border-radius: 6px;
		}

		.card-box-content::-webkit-scrollbar-thumb:hover {
			background: #94a3b8;
		}
	</style>

	<script>
		const track = document.querySelector('.carousel-viewport');
		const btnPrev = document.querySelector('.prev');

		const btnNext = document.querySelector('.next');

		btnNext.addEventListener('click', () => {

			track.scrollBy({
				left: track.clientWidth,
				behavior: 'smooth'
			});

		});

		btnPrev.addEventListener('click', () => {

			track.scrollBy({
				left: -track.clientWidth,
				behavior: 'smooth'
			});

		});
	</script>

</body>