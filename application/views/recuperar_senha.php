<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<title>Recuperar Senha</title>
<link rel="icon" href="<?= base_url('assets/img/icons/icons_capacifar/favicon_capacifar.ico') ?>">

<!-- CSS do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net" rel="stylesheet">
	
<!-- Importação do Boostra icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>		
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
	body{
		margin:0;
		font-family: Arial, Helvetica, sans-serif;
		background:#eef1f5;
	}

	/* container */

	.container{
		width:1200px;
		margin:auto;
		display:flex;
		justify-content:space-between;
		align-items:center;
	}

	/* TOPO */

	.topbar{
		background:#e53935;
		color:#fff;
		padding:10px 0;
		font-size:14px;
	}

	.topbar a{
		color:#fff;
		text-decoration:none;
	}

	/* HEADER */

	.header{
		background:#fff;
		padding:20px 0;
		border-bottom:1px solid #eee;
	}

	.logo{
		height:60px;
	}

	.home-link{
		color:#e53935;
		text-decoration:none;
	}

	/* CONTEUDO */

	.conteudo{
		display:flex;
		justify-content:center;
		align-items:center;
		height:70vh;
	}

	/* CARD */

	.card-recuperar{

		background:#fff;
		width:420px;
		padding:40px;
		border-radius:10px;

		box-shadow:0 10px 25px rgba(0,0,0,0.1);
	}

	.card-recuperar h2{
		color:#1f4e79;
	}

	.texto{
		color:#555;
		font-size:15px;
	}

	/* FORM */

	.form-group{
		margin-top:20px;
	}

	.form-group label{
		display:block;
		margin-bottom:8px;
	}

	.form-group input{

		width:100%;
		padding:10px;
		border:1px solid #ddd;
		border-radius:6px;
	}

	.btn-buscar{

		margin-top:25px;

		background:#e53935;
		color:#fff;

		border:none;

		padding:12px 25px;

		border-radius:6px;

		cursor:pointer;
	}

	.btn-buscar:hover{
		background:#c62828;
	}
	
	/* FOOTER */
	.footer{

		background: linear-gradient(90deg,#1e1e1e,#2a2a2a);

		color:#fff;

		padding:60px 0;

		font-family:Arial, Helvetica, sans-serif;

	}

	.container-footer{

		width:1200px;

		margin:auto;

		display:grid;

		grid-template-columns: 1.3fr 1fr 1.2fr 1fr;

		gap:40px;

	}

	/* LOGO */

	.footer-logo{

		width:180px;

		margin-bottom:15px;

	}

	/* TITULOS */

	.footer h3{

		font-size:24px;

		margin-bottom:20px;

	}

	/* TEXTO */

	.footer p{

		color:#ddd;

		line-height:1.6;

	}

	/* LINKS */

	.footer ul{

		list-style:none;

		padding:0;

	}

	.footer ul li{

		margin-bottom:10px;

	}

	.footer ul li a{

		color:#fff;

		text-decoration:none;

	}

	.footer ul li a:hover{

		text-decoration:underline;

	}

	/* SOCIAL */

	.social{

		display:flex;

		gap:15px;

		margin-top:10px;

	}

	.social a{

		width:45px;

		height:45px;

		display:flex;

		align-items:center;

		justify-content:center;

		border-radius:6px;

		color:#fff;

		font-weight:bold;

		text-decoration:none;

	}

	.instagram{ background:#3fb0d0; }

	.linkedin{ background:#3fb0d0; }

	.youtube{ background:#e53935; }

	.facebook{ background:#3b82c4; }
	
	.alert {
		position: relative;
		padding: .75rem 1.25rem;
		margin-bottom: 1rem;
		border: 1px solid transparent;
		border-radius: .25rem;
	}
	
	.alert-success {
		color: #155724;
		background-color: #d4edda;
		border-color: #c3e6cb;
	}
	
	.alert-danger {
		    color: #721c24;
		background-color: #f8d7da;
		border-color: #f5c6cb;
	}
	
	.login-form-forgotpassword a{
		color: #E53845;
		padding:10px;
	}

</style>
</head>

<body>

<!-- TOPO -->
<div class="topbar">

    <div class="container">

        <div class="top-left">
            <i class="bi bi-telephone-fill"></i> Fale conosco : (31) 3218-1026
            &nbsp;&nbsp;
            <i class="bi bi-envelope-fill"></i> E-mail : capacifar@crfmg.org.br
        </div>

        <div class="top-right">
            Português - Brasil (pt_br) | <a href="https://portalfarma.crfmg.org.br/moodle/login/index.php">Acessar</a>
        </div>

    </div>

</div>


<!-- HEADER -->
<div class="header">

    <div class="container">

        <img src="<?=base_url('assets/img/icons/CAPACIFAR_online cor.png')?>" class="logo">

        <a href="https://portalfarma.crfmg.org.br/moodle/" class="home-link">
            Página inicial
        </a>

    </div>

</div>


<!-- CONTEÚDO -->
<div class="conteudo">

    <div class="card-recuperar">

        <p class="texto">
			Para redefinir sua senha, preencha seu usuário(CPF) e seu e-mail abaixo.
			Se sua conta for encontrada no banco de dados, sua senha será resetada para seu CPF conforme cadastro inicial.
        </p>

        <h2>Buscar por identificação de usuário</h2>

		<div id="msg" style="padding: 10px;"></div>
		
        <!--<form method="post" id="formRecuperar_" action="<?=base_url()?>recuperar_enviar">-->
        <form method="post" id="formRecuperar">

            <div class="form-group">

                <label>Identificação de usuário (CPF)</label>

                <input type="text" name="usuario" required>
				
				<label>E-mail cadastrado</label>

                <input type="text" name="email" required>

            </div>

            <button type="submit" class="btn-buscar">
                Buscar
            </button>

        </form>

		<div class="login-form-forgotpassword mb-3">
			<a href="https://portalfarma.crfmg.org.br/moodle/login/index.php">Já recuperei a senha</a>
        </div>
		
    </div>
	
</div>

<!-- FOOTER -->
<footer class="footer">

<div class="container-footer">

    <!-- COLUNA 1 -->
    <div class="footer-col">

        <img src="<?=base_url('assets/img/icons/capacifar_online.png')?>" class="logo">

        <p>
        O Capacifar é o programa de capacitações do CRF/MG que há mais
        de 10 anos promove cursos, palestras e eventos presenciais e
        em todo estado de Minas Gerais.
        </p>

    </div>


    <!-- COLUNA 2 -->
    <div class="footer-col">

        <h3>Informações</h3>

        <ul>
            <li><a href="https://www.crfmg.org.br/portalfarma/">Capacifar Presencial</a></li>
            <li><a href="https://www.crfmg.org.br/portalfarma/">Capacifar Online</a></li>
            <li><a href="https://ava.crfmg.org.br/">Portal AVA</a></li>
        </ul>

    </div>


    <!-- COLUNA 3 -->
    <div class="footer-col">

        <h3>Contate-nos</h3>

        <p>
        Rua Rodrigues Caldas, 493 | Santo Agostinho |
        CEP 30190-120 | Belo Horizonte/MG
        </p>

        <p><i class="bi bi-telephone-fill"></i> Telefone : (31) 3218-1026</p>

        <p><i class="bi bi-envelope-fill"></i> E-mail : capacifar@crfmg.org.br</p>

    </div>


    <!-- COLUNA 4 -->
    <div class="footer-col">

        <h3>Siga-nos</h3>

        <div class="social">

            <a class="instagram"><i class="bi bi-instagram"></i></a>
            <a class="linkedin"><i class="bi bi-linkedin"></i></a>
            <a class="youtube"><i class="bi bi-youtube"></i></a>
            <a class="facebook"><i class="bi bi-facebook"></i></a>

        </div>

    </div>

</div>

</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

	$("#formRecuperar").submit(async function(e) {

		e.preventDefault();

		console.log('recuperando senha...');

		try {

			var form = document.getElementById("formRecuperar");
			var fd = new FormData(form);

			const res = await $.ajax({
				type: "POST",
				url: '<?=base_url()?>resetarSenhaMoodle',
				data: fd,
				dataType: 'json',
				contentType: false,
				processData: false,
				beforeSend: function() {
					console.log('Enviando dados...');
				}
			});

			console.log("Sucesso:", res);
			
			if (res.status === 'success') {
				Swal.fire({
					title: 'Tudo certo!',
					text: res.msg,
					icon: 'success',
					confirmButtonText: 'Ir para o Moodle'
				}).then(() => {
					window.location.href = 'https://portalfarma.crfmg.org.br/moodle/login';
				});
			} else {
				Swal.fire({
					title: 'Erro!',
					text: res.msg, // A mensagem que vem do seu PHP ("Usuário não encontrado")
					icon: 'error',
					confirmButtonText: 'Tentar novamente'
				});
			}

		} catch (error) {

			console.log('Erro na requisição:', error);
			
			Swal.fire({
				title: 'Erro!',
				text: 'Erro ao processar a solicitação. usuário não encontrado!', // A mensagem que vem do seu PHP ("Usuário não encontrado")
				icon: 'error',
				confirmButtonText: 'Tentar novamente'
			});
			
		}

	});
});
</script>


</body>
</html>
