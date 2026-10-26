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

        <h4 class="text-center mb-3">Definir Nova Senha</h4>

        <div id="msg"></div>

        <!--<form method="post" id="formNovaSenha_" action="<?=base_url()?>salvar_nova_senha">-->
        <form method="post" id="formNovaSenha">

				<div class="form-group">
					<label>Token</label>
					<input type="text" name="token" value="">
				</div>

                <div class="form-group">
                    <label>Nova senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Confirmar senha</label>
                    <input type="password" id="confirmar" class="form-control" required>
                </div>

                <button type="submit" id="btnSalvar"  class="btn-buscar">
                    Salvar nova senha
                </button>

        </form>
		
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
$("#formNovaSenha").submit(async function(e){

    e.preventDefault();

    let btn = $("#btnSalvar");

    if(btn.hasClass('btn-loading')) return;

    let senha = $("#senha").val();
    let confirmar = $("#confirmar").val();

    // validação
    if(senha.length < 8){
        $('#msg').html(
			'<div class="alert alert-danger">Senha deve ter no mínimo 8 caracteres.</div>'
		);
		return;
    }

    if(senha !== confirmar){
       $('#msg').html(
			'<div class="alert alert-danger">As senhas não coincidem.</div>'
		);
		return;
    }

    try {

        btn.addClass('btn-loading').text('Salvando...');

        let res = await $.ajax({
            type: "POST",
            url: '<?=base_url("recuperar/salvar_nova_senha")?>',
            data: $("#formNovaSenha").serialize(),
            dataType: 'json'
        });

        if(res.status){

            $('#msg').html(
				'<div class="alert alert-success">'+res.msg+' <br><a href="https://portalfarma.crfmg.org.br/moodle/login">acessar PortalFarma</a></div>'
			);

        }else{
			$('#msg').html(
				'<div class="alert alert-danger">'+res.msg+'</div>'
			);

        }

    } catch (error) {

        console.log(error);
       $('#msg').html(
			'<div class="alert alert-danger">Erro ao atualizar senhas.</div>'
		);

    } finally {

        btn.removeClass('btn-loading').text('Salvar nova senha');

    }

});

function mostrarMsg(tipo, msg){

    $("#msg").hide().html(
        '<div class="alert alert-${tipo}">${msg}</div>'
    ).fadeIn();

    $('html, body').animate({
        scrollTop: $("#msg").offset().top - 20
    }, 400);
}
</script>
</body>
</html>
