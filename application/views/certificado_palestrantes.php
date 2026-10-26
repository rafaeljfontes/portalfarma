<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
	<!-- SECTION CERTIFICADO -->
    <section class="certificado_section">

        <div class="certificado_box" id="certificado_box">

            <h2 class="certificado_titulo">
                Informe seu E-mail<br>
                cadastrado para emitir o certificado
            </h2>

            <input
                type="text"
                class="certificado_input"
                placeholder="Digite seu e-mail">

            <button class="certificado_botao">
                GERAR CERTIFICADO
            </button>
			
			<div id='resultado-busca' style="margin-top: 25px;"></div>
        </div>
		
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		
		<script>
			// CERTIFICADO FUNCTION
			$(document).on('change', '.certificado_input', function() {
				
				let email = $(this).val();
				let divResultado = $('#resultado-busca');
				console.log('buscando pelo..');
				console.log(email);

				// Se o campo for limpo, esvazia a div de resultado
				if (email.trim() === '') {
					divResultado.html('');
					return;
				}

				$.ajax({
					url: "<?= base_url('certificado/buscar_palestrante_id'); ?>",
					type: "POST",
					data: { email: email },
					dataType: "json",
					beforeSend: function() {
						divResultado.html('<span class="text-muted"><i class="fa-solid fa-spinner fa-spin"></i> Buscando...</span>');
					},
					success: function(response) {
						if (response.status === 'success') {
							// Insere o botão retornado pelo PHP dentro da DIV
							divResultado.html(response.html);
						} else {
							// Caso não encontre, mostra mensagem ou limpa
							divResultado.html('<span class="text-danger"><i class="fa-solid fa-xmark"></i> Palestrante não encontrado.</span>');
						}
					},
					error: function() {
						divResultado.html('<span class="text-danger">Erro ao processar a busca.</span>');
					}
				});
			});
			
			function btn_gerar_certificados(id_palestrante) {
				// Registra no console para você homologar o ID recebido
				console.log("ID do Palestrante:", id_palestrante);
				
				if (!id_palestrante) {
					console.error("ID do palestrante não foi fornecido.");
					return;
				}
				
				// Abre a URL diretamente em uma nova aba passando o ID correto
				window.open("<?= base_url('certificado/gerar_certificado_palestrantes/'); ?>" + id_palestrante, '_blank');
			}
    </script>
	<style>
		/* SECTION */
		.certificado_section {
			width: 100%;
			padding: 0px 20px 80px;
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 50px;
		}

		/* BOX */
		.certificado_box {
			background: #F8FAFC;
			padding: 40px 30px;
			border-radius: 18px;
			border: 1px solid rgba(23, 90, 120, 0.08);

			box-shadow:
				0 -4px 10px rgba(0, 0, 0, 0.08),
				0 6px 18px rgba(23, 90, 120, 0.08),
				0 20px 48px rgba(0, 0, 0, 0.12),
				0 0 0 1px rgba(255, 255, 255, 0.6) inset;

			max-width: 820px;
			width: 100%;
			text-align: center;
		}

		/* TITULO RESPONSIVO */
		.certificado_titulo {
			color: #e63b2e;
			font-size: clamp(18px, 2.5vw, 30px);
			font-weight: 700;
			margin-bottom: 30px;
			line-height: 1.3;
		}

		/* INPUT */
		.certificado_input {
			width: 80%;
			max-width: 580px;
			padding: 14px 16px;

			background: transparent;
			border-radius: 8px;
			border: 2px solid #2c5d73;

			text-align: center;
			font-size: clamp(15px, 1.2vw, 18px);

			outline: none;
			margin: 0 auto 30px auto;
			display: block;

			transition: 0.2s;
		}

		.certificado_input:focus {
			border-color: #1c4456;
		}

		/* BOTAO RESPONSIVO */
		.certificado_botao {
			background: #005c8d;
			color: #fff;
			border: none;

			padding: clamp(10px, 1vw, 14px) clamp(24px, 2vw, 36px);

			font-size: clamp(18px, 2vw, 24px);
			font-weight: 700;

			border-radius: 12px;
			cursor: pointer;
			transition: 0.25s;
		}

		.certificado_botao:hover {
			background: #239961;
		}

		/* MOBILE */
		@media (max-width:768px) {

			.certificado_section {
				padding: 0 16px 55px;
			}

			.certificado_box {
				padding: 22px 18px;
				border-radius: 14px;
				max-width: 95%;
			}

			.certificado_input {
				width: 100%;
				max-width: 95%;
			}

			.certificado_botao {
				width: 80%;
				max-width: 300px;
				display: block;
				margin: 0 auto;
			}

		}
	</style>
    </section>