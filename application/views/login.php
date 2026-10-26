   <?php 
	   	header('Content-type: text/html; charset=utf-8');
   ?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?=base_url();?>/assets/img/crfmgLogo.png" />
    <title>PortalFarma - Acesso Restrito/CRFMG</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

   <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/login.css">
</head>

<body>

    <div class="login-container">
        <div class="login-image">
            <div class="image-content">
                <h1>Painel <br>Portal Farma.</h1>
                <p>Gerencie eventos, palestrantes e programações em um só lugar com o novo sistema integrado Capacifar.</p>
            </div>
        </div>

        <div class="login-form">
            <div class="form-box">
                <div class="logo-placeholder">
                    <img src="https://www.crfmg.org.br/portalfarma/assets/img/icons/PORTAL%20FARMA.png" alt="PORTAL FARMA">
                </div>

                <h2>Bem-vindo</h2>
                <p class="subtitle">Insira suas credenciais para acessar o painel.</p>
                
                <?php if ($this->session->flashdata('erro')): ?>
                    <div class="alert-custom">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span><?= $this->session->flashdata('erro') ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?=base_url()?>restrito/login/entrar" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Usuário</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="usuario" class="form-control" placeholder="Seu nome de usuário" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
						<label class="form-label">Senha</label>
						<div class="input-group">
							<span class="input-group-text"><i class="bi bi-lock"></i></span>
							<input type="password" name="senha" id="inputSenha" class="form-control" placeholder="Sua senha secreta" required>
							<button class="btn btn-outline-secondary border-start-0" type="button" id="btnSenha" style="border-color: #dee2e6;">
								<i class="bi bi-eye" id="iconeOlho"></i>
							</button>
						</div>
					</div>

                    <button type="submit" class="btn-login">
                        Acessar Sistema <i class="bi bi-arrow-right ms-2"></i>
                    </button>

                    <div class="extra">
                        <a href="#"><i class="bi bi-question-circle me-1"></i> Utilize seu login e senha de rede </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script>
    const btnSenha = document.querySelector('#btnSenha');
    const inputSenha = document.querySelector('#inputSenha');
    const iconeOlho = document.querySelector('#iconeOlho');

    btnSenha.addEventListener('click', function() {
        // Alterna o tipo do input
        const type = inputSenha.getAttribute('type') === 'password' ? 'text' : 'password';
        inputSenha.setAttribute('type', type);
        
        // Alterna o ícone (bi-eye para bi-eye-slash)
        iconeOlho.classList.toggle('bi-eye');
        iconeOlho.classList.toggle('bi-eye-slash');
    });
</script>
</body>
</html>