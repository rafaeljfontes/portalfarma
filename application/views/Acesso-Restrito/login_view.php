   <?php 
	   	header('Content-type: text/html; charset=utf-8');
   ?>
 <!doctype html>
<html lang="pt-br" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<link rel="shortcut icon" href="<?=base_url();?>/assets/img/crfmgLogo.png" />
	<title> Login - Acesso Restrito/CRFMG </title>
	
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="<?=base_url();?>/assets/css/bootstrap.min.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="<?=base_url();?>/assets/css/style.css">
 	
 	<script src="<?= base_url()?>assets/public/js/jquery.js"></script>
 	<script src="<?= base_url()?>assets/public/js/bootstrap.min.js"></script>
 	
 	
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            height: 100vh;
            background: #f4f6f9;
        }

        .login-container {
            display: flex;
            height: 100vh;
        }

        /* LADO ESQUERDO - IMAGEM */
        .login-image {
            flex: 1;
            background: url("https://images.unsplash.com/photo-1521791136064-7986c2920216")
                        no-repeat center center;
            background-size: cover;
        }

        /* LADO DIREITO - FORM */
        .login-form {
            flex: 1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .form-box {
            width: 100%;
            max-width: 360px;
        }

        .form-box h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .form-box p {
            margin-bottom: 30px;
            color: #777;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #0056b3;
        }

        .extra {
            margin-top: 15px;
            text-align: center;
        }

        .extra a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        /* RESPONSIVO */
        @media (max-width: 768px) {
            .login-image {
                display: none;
            }

            .login-form {
                flex: 1;
            }
        }
    </style>
</head>

<body>

	
	<div class="login-container">
		<!-- IMAGEM -->
		<div class="login-image"></div>

		<!-- FORM -->
		<div class="login-form">
			<div class="form-box">
				<h2>Bem-vindo</h2>
				<p>Faça login para continuar</p>
				
				<?php if ($this->session->flashdata('erro')): ?>
					<div class="alert alert-danger">
						<?= $this->session->flashdata('erro') ?>
					</div>
				<?php endif; ?>

				<form action="<?=base_url()?>restrito/login/entrar" method="POST" class="mt-5">
					<div class="form-group">
						<label>Usuário</label>
						<input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário" required>
					</div>

					<div class="form-group">
						<label>Senha</label>
						<input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
					</div>

					<button type="submit" class="btn-login">Entrar</button>

					<div class="extra">
						<a href="#">Esqueceu a senha?</a>
					</div>
				</form>
			</div>
		</div>
	</div>


</body>


</html>