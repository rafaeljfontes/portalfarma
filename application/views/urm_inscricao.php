
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Inscrição - URM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Jquery e Swal Fire --> 
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
	<style>
        body {
            /*background-color: #005691; // Azul do fundo da imagem */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 0;
        }
		
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 40px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        }

        .seminario-title {
            color: #005691;
            font-weight: 800;
            font-size: 1.1rem;
            text-transform: uppercase;
        }

        .data-destaque {
            color: #d10024; /* Vermelho da data */
            font-weight: 800;
            font-size: 1.5rem;
            margin-top: 5px;
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .btn-inscrever {
            background-color: #005691;
            border: none;
            color: white;
            padding: 12px 40px;
            border-radius: 8px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background 0.3s;
        }

        .btn-inscrever:hover {
            background-color: #003d66;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #444;
        }

        .asterisco {
            color: #333;
        }
    </style>

<?php
	
	
	foreach ($urm as $campo) {
		
		// DADOS BÁSICOS
		$descricao 		= $campo->descricao;
		$titulo 		= $campo->titulo;
		$local 			= $campo->local;
		$id 			= $campo->courseid;
		
		// DATAS
		$data_inicio 			= new DateTime($campo->data_inicio);
		$data_fim 				= new DateTime($campo->data_fim);
		$campo_horario 			= $data_inicio->format('G:i');
		$campo_horario_final	= $data_fim->format('G:i');
		
		// FORMATANDO A DATA
		$meses = [
			1 => 'JANEIRO', 2 => 'FEVEREIRO', 3 => 'MARÇO', 4 => 'ABRIL',
			5 => 'MAIO', 6 => 'JUNHO', 7 => 'JULHO', 8 => 'AGOSTO',
			9 => 'SETEMBRO', 10 => 'OUTUBRO', 11 => 'NOVEMBRO', 12 => 'DEZEMBRO'
		];

		$dia = $data_inicio->format('d');
		$mes = (int)$data_inicio->format('m');

		$data_formatada = $dia . " de " . $meses[$mes];
		
	}

?>
<div class="container" style="margin-top: 120px;margin-bottom: 50px;">
    <div class="form-container">
        <form id="forminscricao">
            
            <div class="mb-4">
                <label class="form-label">*Selecionar Uso Racional de medicamentos</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="urm" id="urm1" checked required>
                    <label class="form-check-label seminario-title" for="urm1">
                        <?=$titulo?>
                    </label>
                    <div class="data-destaque"><?=$data_formatada;?></div>
					<input type="hidden" class="form-control" id="titulo"   name="titulo" value="<?=$titulo?>">
					<input type="hidden" class="form-control" id="courseid" name="courseid" value="<?=$id?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="nome" class="form-label">*Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cpf" class="form-label">*CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">*E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Informe seu e-mail" required>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">*Telefone</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>
            </div>
			
			<div class="mb-3">
                <label for="instituicao" class="form-label">*Instituicao de Ensino</label>
                <input type="tel" class="form-control" id="instituicao" name="instituicao" placeholder="Instituicao de ensino" required>
            </div>

            <div class="mb-4">
                <label class="form-label">*Quero participar</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_participacao" id="online" value="online" required>
                    <label class="form-check-label fw-bold" for="online">
                        Confirmo que já fiz a parte teórica
                    </label>
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
							</a> de participação do Seminário de Saúde. <span class="text-danger">*</span>
						</label>
					</div>
				</div>
			</div>
			
            <div class="text-center">
                <button type="submit" class="btn btn-inscrever">Inscrever</button>
            </div>

        </form>
    </div>
</div>


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
				<iframe src="<?= base_url('public/TERMO_DE_USO_E_POLITICA_DE_PRIVACIDADE_PORTAL_FARMA_SEMINARIO_DE_VIGILANCIA_EM_SAUDE_CRFMG.pdf') ?>#toolbar=0" 
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

    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 00000-0000');

		$('#cpf').on('blur', function() {
			const cpf = $(this).val().replace(/\D/g, '');
			const courseid = '<?= $id ?>'; // ID do curso atual
			const btnInscrever = $('.btn-inscrever');
			
			console.log('Verificando CPF');
			console.log(cpf);
			

			if (cpf.length === 11) {
				$.ajax({
					url: '<?= base_url("urm/verificar_cadastro_moodle") ?>',
					type: 'POST',
					data: { cpf: cpf, courseid: courseid },
					dataType: 'json',
					beforeSend: function() {
						btnInscrever.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Validando...');
					},
					success: function(response) {
						if (response.status === 'nao_cadastrado') {
							Swal.fire({
								icon: 'error',
								title: 'Acesso Negado',
								text: 'Você precisa estar cadastrado no Curso Preparatório para se inscrever neste URM.',
								showCancelButton: true,
								confirmButtonColor: '#005691',
								cancelButtonColor: '#6c757d',
								confirmButtonText: '<i class="bi bi-box-arrow-up-right"></i> Ir para o Curso',
								cancelButtonText: 'Fechar',
								// Permite HTML dentro do botão
								allowHtml: true 
							}).then((result) => {
								if (result.isConfirmed) {
									// Redireciona para a URL do curso
									window.location.href = 'https://www.crfmg.org.br/portalfarma/curso/listar/54';
								}
							});
							btnInscrever.prop('disabled', true).text('Inscrição Bloqueada');
						} else if (response.status === 'ja_inscrito') {
							Swal.fire({
								icon: 'info',
								title: 'Olá!',
								text: 'Você está apto para concluir a inscrição para este evento.',
								confirmButtonColor: '#005691'
							});
							btnInscrever.prop('disabled', false).text('Me Inscrever no URM Presencial');
						} else {
							// Caso tenha cadastro no Moodle e não esteja inscrito no curso ainda
							btnInscrever.prop('disabled', false).text('Inscrever');
						}
					},
					error: function() {
						btnInscrever.prop('disabled', false).text('Inscrever');
						console.error('Erro na validação.');
					}
				});
			}
		});
    
		$('#forminscricao').on('submit', function(e) {
			e.preventDefault(); // Impede o recarregamento da página

			// 1. Captura os dados do formulário
			const formData = $(this).serialize();
			
			console.log('Inscrição no Seminário');
			console.log(formData);

			// 2. Alerta de "Processando"
			Swal.fire({
				title: 'Processando inscrição...',
				text: 'Aguarde um momento enquanto validamos seus dados.',
				allowOutsideClick: false,
				showConfirmButton: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});

			// 3. Envio via AJAX
			$.ajax({
				url: '<?=base_url()?>urm/processar_inscricao', // O arquivo que receberá os dados via POST
				type: 'POST',
				data: formData,
				dataType: 'json', // Esperamos que o PHP retorne um JSON
				success: function(response) {
					if (response.status === 'success') {
						// Alerta de Sucesso
						Swal.fire({
							icon: 'success',
							title: 'Inscrição Realizada!',
							text: response.message || 'Sua vaga foi garantida com sucesso.',
							confirmButtonColor: '#005691',
							confirmButtonText: 'Ótimo!'
						}).then(() => {
							// Opcional: Redirecionar ou resetar formulário
							// window.location.href = 'obrigado.php';
							$('form')[0].reset(); 
						});
					} else {
						// Alerta de Erro vindo do Servidor
						Swal.fire({
							icon: 'error',
							title: 'Ops...',
							text: response.message || 'Verifique os dados e tente novamente.',
							confirmButtonColor: '#d10024'
						});
					}
				},
				error: function() {
					// Erro de conexão ou erro interno do servidor (500)
					Swal.fire({
						icon: 'error',
						title: 'Erro de Conexão',
						text: 'Não foi possível contatar o servidor. Tente novamente mais tarde.',
						confirmButtonColor: '#d10024'
					});
				}
			});
		});
	});
</script>

