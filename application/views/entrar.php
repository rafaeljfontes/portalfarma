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
</head>


<style>
	.portal-top {
		width: 100%;
		max-width: 1100px;
		margin: 0 auto 0px auto;
	}

	.btn-voltar {
		display: inline-flex;
		gap: 8px;
		margin-bottom: 52px;
		padding: 9px 20px;
		border-radius: 10px;
		background: #ffffff00;
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

	/* ================================
	WRAPPER
	================================ */
	.portal-wrapper {
		min-height: 85vh;
		padding: 60px 20px !important;
		background-color: #ffffff;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.portal-grid {
		width: 100%;
		max-width: 1100px;
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 40px;
	}

	/* ================================
	CARD
	================================ */
	.opcao {
		background: #ffffff;
		border-radius: 20px;
		box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
		transition: all 0.3s ease;
		overflow: hidden;
		height: 100%;
	}

	.opcao:hover {
		transform: translateY(-8px);
	}

	.opcao a {
		display: flex;
		flex-direction: column;
		height: 100%;
		text-decoration: none;
		color: inherit;
	}

	/* ================================
	IMAGEM FULL
	================================ */
	.opcao-img {
		width: 100%;
		height: 400px;
		overflow: hidden;
	}

	.opcao-img img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
	}

	/* ================================
	CONTEÚDO
	================================ */
	.opcao-content {
		padding: 25px;
		text-align: center;
	}

	.opcao-content h2 {
		font-size: clamp(18px, 2vw, 22px);
		color: #295277;
		margin-bottom: 22px;
		font-weight: 700;
	}

	.opcao-content p {
		font-size: clamp(13px, 1vw, 15px);
		color: #6c757d;
		line-height: 1.5;
	}

	/* ================================
	RESPONSIVO
	================================ */
	@media (max-width: 992px) {
		.portal-grid {
			gap: 30px;
		}
	}

	@media (max-width: 768px) {
		.portal-wrapper {
			padding: 30px 20px !important;
		}

		.portal-grid {
			grid-template-columns: 1fr;
			gap: 25px;
		}

		.opcao-img {
			height: 600px;
		}

		.opcao-content {
			padding: 20px;
		}

		.btn-voltar {
			font-size: 13px;
			padding: 6px 14px;
			margin-bottom: 30px;
		}
	}

	@media (max-width: 480px) {
		.opcao-img {
			height: 300px;
		}

		.opcao-content h2 {
			font-size: 16px;
			margin-bottom: 10px;

		}

		.opcao-content p {
			font-size: 13px;
		}
	}
</style>

<div class="portal-wrapper">

	<div class="portal-top">
		<a href="<?= base_url() ?>" class="btn-voltar">VOLTAR</a>
	</div>

	<div class="portal-grid">

		<!-- AVA -->
		<div class="opcao">
			<a href="https://ava.crfmg.org.br/login/index.php?lang=pt_br" target="_blank" rel="noopener noreferrer">

				<div class="opcao-img">
					<img src="<?= base_url('assets/img/antigo.png') ?>" alt="AVA">
				</div>

				<div class="opcao-content">
					<h2>Antiga plataforma</h2>
					<p>
						Acesse com seu usuário e senha atuais para consultar cursos, conteúdos e
						certificados realizados até o dia 20/01/2026.
					</p>
				</div>

			</a>
		</div>

		<!-- PORTAL FARMA -->
		<div class="opcao">
			<a href="https://portalfarma.crfmg.org.br/moodle/login/index.php?lang=pt_br" target="_blank" rel="noopener noreferrer">

				<div class="opcao-img">
					<img src="<?= base_url('assets/img/novo.png') ?>" alt="Portal Farma">
				</div>

				<div class="opcao-content">
					<h2>Nova plataforma</h2>
					<p>
						Com a reformulação do Portal Farma e a migração dos cursos,
						os dados de acesso anteriores serão alterados. Para acessar o Novo Portal Farma
						crie um novo login e uma nova senha.
					</p>
				</div>
			</a>
		</div>
	</div>
</div>