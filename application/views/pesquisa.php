 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Inscrição - Portal Farma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Jquery e Swal Fire --> 
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

	<style>
		
			label{
				color:#00598D;
			}
			
			.obr{
				color:#d6192f;
				font-weight: bold;
			}
			
            /* Fundo da seção inicial */
            .background-inicio {
                background-size: cover;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .background-inicio {
                background: url('assets/background-banner.png') no-repeat center center;
                background-size: cover;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                position: relative;
                /* Necessário para o pseudoelemento */
            }


            .container-content {
                position: relative;
                z-index: 1;
            }

            .container-apoio {
                background-color: #fff;
            }

            /* Estilos para as seções */
            .contador,
            .relacionamento,
            .inscricao,
            .palestrantes {
                margin-top: -1px;
            }

            .inscricao {
                background-color: #ffffff;
            }

            /*.certificado {
                background: url('assets/imagens/paginas/inscricao_inicio.png') repeat;
            }*/

            .declaracaoComparecimento {
                background: #e9695c;
            }

            .palestrantes {
                background-color: #005b8e;
            }

            /* Estilo do texto de relacionamento */
            .texto_relacionamento {
                color: var(--roxo-topo);
            }

            /* Estilo do título do box de apoio */
            .titulo_box_apoio {
                color: #00598D;
                text-transform: uppercase;
                font-family: 'Outfit-Bold', sans-serif;
            }

            /* Estilo do título do box de inscrição */
            .titulo_box_inscricao {
                color: #FFF;
                text-transform: uppercase;
                font-family: 'Outfit-Bold', sans-serif;
            }

            .col_imagens_inicio {
                padding: 0;
                margin: 0;
            }

            .negrito {
                font-family: 'Outfit-Bold' !important;
                font-size: 1.1em;
            }

            img {
                margin: auto;
                display: block;
            }

            .botao-lateral {
                position: fixed;
                right: 20px;
                top: 55%;
                transform: translateY(-50%);
                background: linear-gradient(135deg, #bd1621, #a2131b);
                color: #FFF;
                text-decoration: none;
                border-radius: 15px;
                font-size: 26px;
                padding: 16px 28px;
                font-weight: bold;
                box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.3);
                transition: all 0.3s ease;
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .botao-lateral-inscricao {
                position: fixed;
                right: 20px;
                top: 45%;
                transform: translateY(-50%);
                background: linear-gradient(135deg, #bd1621, #a2131b);
                color: #FFF;
                text-decoration: none;
                border-radius: 15px;
                font-size: 26px;
                padding: 16px 28px;
                font-weight: bold;
                box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.3);
                transition: all 0.3s ease;
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .botao-lateral:hover {
                background: linear-gradient(135deg,rgb(11, 97, 246), #8b0f17);
                transform: translateY(-50%) scale(1.05);
                box-shadow: 6px 6px 20px rgba(0, 0, 0, 0.4);
            }

            .botao-lateral-inscricao:hover {
                background: linear-gradient(135deg, #a2131b, #8b0f17);
                transform: translateY(-50%) scale(1.05);
                box-shadow: 6px 6px 20px rgba(0, 0, 0, 0.4);
            }

            #botao-fixo {
                position: fixed;
                right: 20px;
                top: 63%;
                transform: translateY(-50%);
                background: linear-gradient(135deg, #00598D, #00416D);
                color: white;
                border: none;
                padding: 18px 30px;
                font-size: 18px;
                cursor: pointer;
                border-radius: 15px;
                box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.2);
                z-index: 1000;
                transition: all 0.3s ease;
                font-weight: bold;
                letter-spacing: 1px;
            }

            #botao-fixo:hover {
                background: linear-gradient(135deg, #00416D, #002C4C);
                transform: translateY(-50%) scale(1.05);
                box-shadow: 6px 6px 20px rgba(0, 0, 0, 0.3);
            }


            #botao-fixo:hover {
                background-color: #004570;
            }

            .red-button{
                width: 100%;
                background-color:#db052a; 
                border-color: #a2131b;
                color: #ffffff;
            }

            .red-button:hover {
                background-color: #8b0f17;
                color: #ffffff;
            }
			
			.box-seminario{
				background-color: #005c8d;
				color: #ffffff;
				border-radius: 10px;
				font-size:60px;
				padding:20px;
				font-weight: bold;
				width: 800px;
				height:250px
			}
			
			.box_eventos{
				display: flex;
				justify-content: center;
				margin-top: -50px;
				padding: 15px;
				width: 800px;
			}
			
			.box-realiza{
				max-width: 670px;
				margin-left: -125px;
				margin-top: 20px;
			}
			
			.img_rodape{
				width: 690px;
				margin-left: -70px;
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
				margin-top:50px;
				margin-left:50px;
			}

			.btn-voltar:hover {
				background: #0b4f63;
				color: #fff;
				border-color: #0b4f63;
				box-shadow: 0 10px 24px #0b4e6313;
			}

            /* Ajustes para telas menores */
            @media (max-width: 1800px) {

                .botao-lateral,
                #botao-fixo {
                    right: 1000%;
                    transform: translate(50%, -50%);
                    font-size: 18px;
                    padding: 8px 16px;
                }
				
				.botao- {
					position: fixed;
					right: 140px;
					top: 45%;
					transform: translateY(-50%);
					background: linear-gradient(135deg, #bd1621, #a2131b);
					color: #FFF;
					text-decoration: none;
					border-radius: 15px;
					font-size: 16px;
					padding: 16px 28px;
					font-weight: bold;
					box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.3);
					transition: all 0.3s ease;
					z-index: 1000;
					display: flex;
					align-items: center;
					justify-content: center;
				}

                /* Ajuste na imagem */
                .img-fluid {
                    width: 50%;
                    max-width: 500px;
                    height: auto;
                }

                /* Estilo das colunas para telas menores */
                .col {
                    padding: 0 15px;
                }
               
				.box-seminario{
					background-color: #005c8d;
					color: #ffffff;
					border-radius: 10px;
					font-size:45px;
					padding:20px;
					font-weight: bold;
					width: 390px;
					height:250px
				}
				
				.box_eventos{
					display: flex;
					justify-content: center;
					margin-top: -50px;
					padding: 15px;
					width: 650px;
					flex-wrap: nowrap;
					flex-direction: column;
				}
				
				.box-realiza{
					max-width: 670px;
					margin-left: -125px;
					margin-top: 20px;
				}
				
				.img_rodape{
					width: 350px;
					margin-left: 220px;
				}
            }
			
			 /* ===============================
            INFORMAÇÕES DO PROJETO
            =============================== */

            .curso-informacoes {
                background-color: #ffffffde;
                padding: 20px 0 80px;
            }

            .container-informacoes {
                max-width: 1350px;
                margin: 0 auto;
                padding: 0 24px;
            }

            /* TITULO */

            .curso-info-titulo {
                text-align: center;
                margin-bottom: 60px;
                font-size: 36px;
                font-weight: 700;
                color: #12455e;
            }
			
			.curso-info-titulo-red{
				text-align: center;
                margin-bottom: 60px;
                font-size: 26px;
                font-weight: 700;
                color: #E4231B;
            }

            /* CARD */

            .curso-info-card {
                background: #F8FAFC;
                border-radius: 28px;
                padding: 48px 56px;

                display: grid;
                gap: 48px;

                border: 1px solid rgba(23, 90, 120, 0.08);

                box-shadow:
                    0 6px 18px rgba(23, 90, 120, 0.08),
                    0 20px 48px rgba(0, 0, 0, 0.12),
                    0 0 0 1px rgba(255, 255, 255, 0.6) inset;
            }

            /* TEXTO */

            .curso-info-programacao {
                font-size: 18px;
                line-height: 1.75;
                color: #12455e;
            }

            .coluna {
                font-weight: 500;
            }

            /* TITULOS */

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

                width: 240px;
                height: 1px;

                background: #e92d26;
                border-radius: 3px;

                margin: 12px auto 0;
            }

            /* LISTAS */

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

            /* GRID */

            .programacao-grid {
                display: grid;
                gap: 24px;
                align-items: stretch;
            }

            .programacao-grid p {
                margin-bottom: 10px;
            }

        </style>

	<?PHP
	
	foreach($portalfarma as $dado){
			$titulo = $dado->titulo;
	}
	
	
	?>

    <!-- SEMINARIOS DE VIGILÂNCIA E SAÚDE -->
    <section class="curso-hero">
        <div class="container-inscricao">
            <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>
	</section>
			
	<!-- PESQUISA DE SATISFAÇÃO DO CURSO -->
    <section class="curso-informacoes">
        <div class="container-informacoes">
            <h2 class="curso-info-titulo">Pesquisa de Satisfação</h2>
            <h3 class="curso-info-titulo-red"><?=html_escape($titulo)?></h3>
			<div class="curso-info-card">
                <div class="curso-info-programacao">

                    <!-- RESPOSTTAS -->
                    <div class="programacao-grid">

					<?php $this->load->view('pesquisa_form'); ?>
				
				</div>
			</div>
        </div>
	 </section>
