<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Inscrição no Curso</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Segoe UI", Arial, sans-serif;
}

body {
    background: linear-gradient(135deg, #eef2ff, #f9f9ff);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Container principal */
.inscricao-container {
    width: 900px;
    max-width: 95%;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,0.12);
    display: flex;
}

/* Lado esquerdo */
.inscricao-imagem {
    width: 45%;
    background: #000;
}

.inscricao-imagem img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Lado direito */
.inscricao-form {
    width: 55%;
    padding: 40px;
}

.inscricao-form h1 {
    font-size: 26px;
    color: #1e2a78;
    margin-bottom: 8px;
}

.inscricao-form p {
    font-size: 14px;
    color: #666;
	margin-top: 25px;
    margin-bottom: 25px;
}

/* Campos */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 6px;
}

.form-group input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
}

.form-group input:focus {
    border-color: #3b5bdb;
    box-shadow: 0 0 0 2px rgba(59,91,219,.15);
}

/* Botão */
.btn-submit {
    margin-top: 20px;
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #3b5bdb, #2f4bd1);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(59,91,219,.35);
}

/* Responsivo */
@media (max-width: 768px) {
    .inscricao-container {
        flex-direction: column;
    }

    .inscricao-imagem {
        width: 100%;
        height: 200px;
    }

    .inscricao-form {
        width: 100%;
        padding: 30px;
    }
}
</style>

</head>
<?php 
									
	//print_r($tabelaCurso);
	
	foreach ($tabelaCurso as $campo){
		
		switch ($campo->tipo_evento) {
			case 1:
				$campo_evento = "Presencial";
				break;
			case 2:
				$campo_evento = "On-line";
				break;
			default: // Caso nenhum dos cases anteriores seja verdadeiro
				$campo_evento = "Evento";
				break;
		}
		
		$campo_imagem 	= $campo->nome_curto;
		$campo_titulo 	= $campo->titulo;
		$course_id 		= $campo->courseid;
	}
?>
<body>

<div class="inscricao-container">

    <!-- Imagem do curso -->
    <div class="inscricao-imagem">
        <img src="<?=base_url()?>assets/img/cursos/<?=$campo_imagem;?>.png" alt="Imagem do Curso">
    </div>

    <!-- Formulário -->
    <div class="inscricao-form">
        <h1>Inscrição no Curso</h1>
        <h2><?=$campo_titulo?></h2>
		
        <p>Preencha seus dados para confirmar sua inscrição.</p>

        <form action="<?=base_url()?>inscricao/salvar" method="post" novalidate>

            <div class="form-group">
                <input type="text" id="course_id" name="course_id" value="<?=$course_id?>">
            </div>
			
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
            </div>
			
			<div class="form-group">
                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>
			
			<div class="form-group">
                <label for="nome">CRFMG</label>
                <input type="text" id="crfmg" name="crfmg" placeholder="Digite seu número CRFMG">
            </div>
			
			<div class="form-group">
                <label for="nome">E-mail</label>
                <input type="text" id="email" name="email" placeholder="Digite seu E-mail" required>
            </div>
			
			<div class="form-group">
                <label for="nome">Telefone</label>
                <input type="text" id="telefone" name="telefone" placeholder="(99) 99999-9999" required>
            </div>

            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required>
            </div>

            <button type="submit" class="btn-submit">
                Inscrever!
            </button>
            
            <?php
                var_dump($this->session->flashdata('type'));
            ?>
            
            <?php if ($this->session->flashdata('type')): ?>
                <div class="alert alert-<?= $this->session->flashdata('type') ?>">
                    <?= $this->session->flashdata('message') ?>
                </div>
            <?php endif; ?>

        </form>
    </div>

</div>

</body>
</html>



