<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Seminário de Vigilância Sanitária</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
    <!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/css/style_caminhos.css">
    <link rel="stylesheet" href="assets/css/style_iniciativas.css">
    <link rel="stylesheet" href="assets/css/style_selector.css">
    <link rel="stylesheet" href="assets/css/style_cursos.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
	<style>
			
			
			:root {
				--azul-escuro: #005691;
				--azul-claro: #eef6fb;
				--pessego: #f77568;
				--texto-cor: #333;
				--borda: #ddd;
			}
			.container_Acordeon {
				width: 100%;
				max-width: 900px;
				background: white;
				box-shadow: 0 4px 10px rgba(0,0,0,0.1);
				border-radius: 8px;
				overflow: hidden;
			}

			.header_Acordeon {
				background-color: var(--azul-escuro);
				color: white;
				padding: 15px;
				text-align: center;
				font-weight: bold;
				font-size: 1.1rem;
			}

			/* Estilização do Acordeon */
			details {
				border-bottom: 1px solid var(--borda);
				transition: background 0.3s ease;
			}

			details:last-child {
				border-bottom: none;
				}

			summary {
				padding: 20px;
				cursor: pointer;
				list-style: none;
				display: flex;
				justify-content: space-between;
				align-items: center;
				font-weight: bold;
				color: var(--azul-escuro);
				font-size: 1.1rem;
				text-transform: uppercase;
				text-align: left;
			}

			summary:hover {
				background-color: var(--azul-claro);
			}

			/* Ícone de seta customizado */
			summary::after {
				content: '▼';
				font-size: 0.8rem;
				transition: transform 0.3s;
			}

			details[open] summary::after {
				transform: rotate(180deg);
			}

			details[open] summary {
				border-bottom: 1px solid var(--borda);
				background-color: var(--azul-claro);
			}

			.content {
				padding: 20px;
				display: flex;
				flex-wrap: wrap;
				gap: 15px;
				background-color: #fafafa;
			}

			.date-info {
				width: 100%;
				font-size: 0.9rem;
				color: #666;
				margin-bottom: 5px;
				font-weight: normal;
				display: block;
			}

			/* Estilização dos Botões */
			.btn {
				display: inline-flex;
				align-items: center;
				padding: 10px 20px;
				border-radius: 5px;
				text-decoration: none;
				font-weight: 600;
				font-size: 0.9rem;
				transition: opacity 0.2s;
			}

			.btn-youtube {
				background-color: #cc0000;
				color: white;
			}

			.btn-fotos {
				background-color: var(--azul-escuro);
				color: white;
			}
			
			.btn-arquivos {
				background-color: var(--pessego);
				color: white;
			}

			.btn:hover {
				opacity: 0.85;
			}

			@media (max-width: 600px) {
				.content {
					flex-direction: column;
				}
				.btn {
					width: 100%;
					justify-content: center;
				}
			}
			
			.curso-info-links {
                display: flex;
				justify-content: center;
				width: 100%;
				font-family: sans-serif;
            }
			
		</style>
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
            padding: 0px 0 75px;
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
            margin: auto 0;
        }

        .curso-detalhes {
            list-style: none;
            padding: 0;
            margin-bottom: 25px;
        }

        .curso-detalhes li {
            font-size: 21px;
            color: #12455e;
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
                src="assets\banner_projetos\Seminario_Banner.png"
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

	<?php
	
		//var_dump($palestrantes);
	
		foreach ($seminario as $indice => $campo) {
			
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
			
		}
	
		function formatarDataEvento($data_inicio, $data_fim)
		{
			$meses = [
				1 => 'janeiro',
				2 => 'fevereiro',
				3 => 'março',
				4 => 'abril',
				5 => 'maio',
				6 => 'junho',
				7 => 'julho',
				8 => 'agosto',
				9 => 'setembro',
				10 => 'outubro',
				11 => 'novembro',
				12 => 'dezembro'
			];

			// Verifica se $data_inicio já é um objeto; se não for, cria o DateTime
			$inicio = ($data_inicio instanceof DateTime) ? $data_inicio : new DateTime($data_inicio);

			// Aplica a mesma lógica para o fim, tratando também o valor nulo
			if ($data_fim) {
				$fim = ($data_fim instanceof DateTime) ? $data_fim : new DateTime($data_fim);
			} else {
				$fim = null;
			}

			$di = (int)$inicio->format('d');
			$mi = (int)$inicio->format('m');
			$yi = $inicio->format('Y');

			if (!$fim) {
				return "$di de {$meses[$mi]} de $yi";
			}

			$df = (int)$fim->format('d');
			$mf = (int)$fim->format('m');
			$yf = $fim->format('Y');
			
			//Mesma data exata (Dia, Mês e Ano)
			if ($di === $df && $mi === $mf && $yi === $yf) {
				return "$di de {$meses[$mi]} de $yi";
			}			
			
		}
	?>
    <!-- SEMINARIOS DE VIGILÂNCIA E SAÚDE -->
    <section class="curso-hero">
        <div class="container-inscricao">
            <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>
            <a href="#certificado_box" class="btn-voltar">Certificado</a>


            <div class="curso-hero-grid">
                <div class="curso-hero-info">
                    <h1 class="curso-titulo destaque">Seminário de Vigilância em Saúde</h1>
                    <p class="curso-publicacao">
						O Conselho Regional de Farmácia de Minas Gerais (CRF-MG), em parceria com a Secretaria de Estado de Saúde de Minas Gerais (SES-MG) – Superintendência de Vigilância Sanitária (SVS) apresentam o “Seminário de Vigilância em Saúde”.
						<br>
						O evento tem como principal objetivo promover um espaço de diálogo técnico, qualificado e aprofundado sobre temas regulatórios e sanitários, direcionado especialmente aos fiscais da Vigilância em Saúde e aos profissionais farmacêuticos.
						<br>
						Durante o seminário, serão abordados os principais desafios e oportunidades enfrentados na fiscalização dos serviços farmacêuticos, com o intuito de fortalecer as práticas de vigilância e contribuir para a excelência na prestação de serviços à população.
					</p>
                </div>
                <?php if (!empty($id)): ?>
                <div class="curso-hero-card">
                    <ul class="curso-detalhes">
                        <li><strong>Tema:</strong> <?=$titulo?></li>
                        <li><strong>Data:</strong> <?= formatarDataEvento($data_inicio, $data_fim); ?></li>
                        <li><strong>Horário:</strong> <?= $campo_horario; ?> às <?=$campo_horario_final?></li>
                        <li><strong>Local:</strong> <?=$local?></li>
                    </ul>
					<a href="<?=base_url()?>seminario/inscrever/<?=$id?>" class="btn-inscricao grande">INSCRIÇÕES ABERTAS</a>
                </div>
				<?php else: ?>
					<div class="curso-hero-card text-center">
						<i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
						<h5 class="mb-0">Nenhum Seminário <br> programado no momento.</h5>
					</div>
				<?php endif; ?>


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
	
	<style>
    /* Container que envolve os dois botões do YouTube */
    .container-botoes-youtube {
        display: flex;
        justify-content: space-between; /* Espaça os botões */
        width: 90%;             /* Ocupa 90% da div pai */
        margin: 0 auto 15px;    /* Centraliza o container e dá margem inferior */
        gap: 15px;              /* Espaço entre os botões */
    }

    /* Ajuste nos botões para crescerem igualmente */
    .container-botoes-youtube .btn-youtube {
        flex: 1;                /* Faz cada botão ocupar 50% da linha */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        text-decoration: none;
        border-radius: 5px;
        white-space: nowrap;    /* Impede quebra de texto dentro do botão */
    }

    /* Estilo do botão de fotos (mantendo 100% da div maior ou 90% para alinhar) */
    .container-fotos {
        width: 90%;
        margin: 0 auto;
		align-items: center;
        justify-content: center;
    }
	</style>	
    <!-- INFORMAÇÕES DO CURSO -->
    <section class="curso-informacoes d-none">
        <div class="container-informacoes">
            <h2 class="curso-info-titulo">Informações do Projeto</h2>
            <div class="curso-info-card">
                <div class="curso-info-programacao">

                    <h2>PROGRAMAÇÃO</h2>

                    <!-- PROGRAMAÇÃO -->
                    <div class="programacao-grid">
						<?php 
						if (!empty($programacao)):
							// Divide o array da programação em 2 partes (colunas)
							$totalItens = count($programacao);
							$metade = ceil($totalItens / 2);
							$colunas = array_chunk($programacao, $metade);
							
							foreach ($colunas as $index => $colunaDados): 
						?>
							<div class="coluna">
								<?php foreach ($colunaDados as $item): 
									// Formata as horas para exibir apenas HH:mm
									$inicio = date('H\hi', strtotime($item->data_hora_inicial));
									$fim = !empty($item->hora_final) ? date('H\hi', strtotime($item->hora_final)) : null;
								?>
									<div class="item-programacao" style="margin-bottom: 15px;">
										<p>
											<strong><?php echo $inicio; ?><?php echo $fim ? " às $fim" : ""; ?></strong> 
											- <?php echo $item->palestra; ?>
										</p>
										
										<?php if (!empty($item->descricao)): ?>
											<?php 
											// Se no seu banco os palestrantes vierem separados por vírgula ou linha
											// aqui quebramos para manter a classe .palestrante individual
											$palestrantes = explode("\n", $item->descricao); 
											foreach ($palestrantes as $p): if(trim($p) != ""):
											?>
												<p class="palestrante">Palestrante: <?php echo trim($p); ?></p>
											<?php endif; endforeach; ?>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>

							<?php 
							// Adiciona o divisor apenas entre a primeira e a segunda coluna
							if ($index == 0 && count($colunas) > 1): ?>
								<div class="curso-info-divider"></div>
							<?php endif; ?>

						<?php 
							endforeach; 
						else: 
						?>
							<p>Programação em breve.</p>
						<?php endif; ?>
					</div>
					
					<div class="container-botoes-youtube">
						<a href="https://www.youtube.com/live/3gSL9TaIYRk" class="btn btn-youtube">
							<i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Manhã
						</a>
						
						<a href="https://www.youtube.com/watch?v=YGIz_bNFKyA" class="btn btn-youtube">
							<i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Tarde
						</a>
					</div>

					<div class="container-fotos">
						<a href="https://drive.google.com/drive/folders/1yFf4_8UmWmP5fcA-kIGhnn0pIpDa4nJR" class="btn btn-fotos" style="width:100%;">
							<i class="fa-regular fa-images"></i>&nbsp;&nbsp; Ver Fotos do Seminário
						</a>
					</div>
					
					<div class="container-arquivos">
						<a href="https://drive.google.com/drive/folders/1EE4xPBXYCyEdnsZka5mVPD-1ohnXa3j_" class="btn btn-arquivos" style=" width: 90%;margin-top: 15px;margin-left: 59px;">
							<i class="fa-regular fa-file"></i>&nbsp;&nbsp; Arquivos de Apresentações
						</a>
					</div>

                </div>
            </div>
        </div>

        <style>
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
                grid-template-columns: 1fr 1px 1fr;
                gap: 24px;
                align-items: stretch;
            }

            .programacao-grid p {
                margin-bottom: 10px;
            }

            /* PALESTRANTE */

            .programacao-grid .palestrante {
                padding-left: 16px;
                font-size: 16px;
                font-style: italic;
                opacity: 0.85;
            }

            /* DIVISOR */

            .curso-info-divider {
                width: 1px;

                background: linear-gradient(to bottom,
                        transparent,
                        #e92d26,
                        transparent);

                border-radius: 2px;
            }

            /* FOTOS */

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

                padding: 10px 24px;

                border-radius: 12px;

                font-size: 18px;
                font-weight: 500;

                text-decoration: none;
            }

            .curso-info-fotos-texto {
                font-size: 18px;
                color: #12455e;
                opacity: 0.95;
            }

            /* =================================
            RESPONSIVO
            ================================= */

            /* NOTEBOOK */

            @media (max-width:1200px) {

                .curso-info-titulo {
                    font-size: 32px;
                }

                .curso-info-card {
                    padding: 40px 38px;
                }

                .curso-info-programacao {
                    font-size: 17px;
                }

                .curso-topicos li {
                    font-size: 16px;
                }
            }

            /* TABLET */

            @media (max-width:1024px) {

                .curso-informacoes {
                    padding: 30px 0 50px;
                }

                .curso-info-titulo {
                    font-size: 28px;
                    margin-bottom: 40px;
                }

                .curso-info-card {
                    padding: 34px 30px;
                    gap: 36px;
                }

                .curso-info-programacao {
                    font-size: 16px;
                }

                .programacao-grid {
                    gap: 3px;
                }

            }

            /* TABLET PEQUENO */

            @media (max-width:768px) {

                .container-informacoes {
                    padding: 0 20px;
                }

                .curso-info-titulo {
                    font-size: 24px;
                    margin-bottom: 28px;
                }

                .curso-info-card {
                    padding: 36px 26px;
                    gap: 28px;
                    border-radius: 22px;
                }

                .curso-info-programacao {
                    font-size: 15px;
                    line-height: 1.6;
                }

                .curso-info-programacao h2 {
                    font-size: 18px;
                    margin-bottom: 16px;
                }

                .curso-info-programacao h2::after {
                    width: 160px;
                }

                .programacao-grid {
                    grid-template-columns: 1fr;
                }



                .curso-info-divider {
                    display: none;
                }

                .coluna {
                    font-size: 14px;
                }

                .curso-info-fotos {
                    flex-direction: column;
                    text-align: center;
                    margin-top: 12px;
                    gap: 0px;
                }

                .curso-info-fotos-texto {
                    font-size: 14px;
                }

                .curso-info-fotos-botao {
                    font-size: 15px;
                }

            }

            /* CELULAR */

            @media (max-width:480px) {

                .curso-info-titulo {
                    font-size: 21px;
                }

                .curso-info-programacao {
                    font-size: 14px;
                }

                .curso-topicos li {
                    font-size: 14px;
                }

                .curso-info-programacao h2 {
                    font-size: 16px;
                }

                .programacao-grid .palestrante {
                    font-size: 13px;
                }

            }

            /* CELULAR PEQUENO */

            @media (max-width:360px) {

                .curso-info-titulo {
                    font-size: 19px;
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


    <!-- PALESTRANTES -->
    <section class="curso-palestrantes d-none">
        <div class="container-palestrantes">

            <h2 class="curso-info-titulo d-none">Palestrantes</h2>

            <div class="palestrantes-grid">
				
                <?php if (!empty($tblpalestrantes)): ?>
                    <?php foreach ($tblpalestrantes as $p): ?>

                        <div class="palestrante-card"
                            data-nome="<?= htmlspecialchars($p->nome) ?>"
                            data-descricao="<?= htmlspecialchars($p->{'curriculo'}) ?>">

                            <?php
                            $this->load->helper('url');

                            $foto = !empty($p->foto) ? $p->foto : base_url('assets/palestrantes/avatar_palestrante.png');
                            ?>
                            <div class="palestrante-avatar">
                                <img src="<?= $foto ?>"
                                    alt="<?= htmlspecialchars($p->nome) ?>"
                                    onerror="this.onerror=null;this.src='<?= base_url('assets/palestrantes/avatar_palestrante.png') ?>';">
                            </div>

                            <div class="palestrante-info">
                                <h3><?= $p->nome ?></h3>

                                <p class="palestrante-resumo">
                                    <?= strip_tags($p->{'curriculo'}); ?>
                                </p>


                                <button class="btn-ver-mais">ver mais</button>
                            </div>

                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="modal-palestrante" id="modalPalestrante">
            <div class="modal-conteudo">
                <button class="modal-fechar">&times;</button>

                <h3 id="modalNome"></h3>
                <p id="modalDescricao"></p>
            </div>
        </div>

        </div>

        <style>
            /* ===============================
            PALESTRANTES
            =============================== */
            .curso-palestrantes {
                padding: 0 0 100px;
                background-color: #ffffffde;

            }

            .container-palestrantes {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 24px;
            }

            .palestrantes-titulo {
                text-align: center;
                font-size: 36px;
                font-weight: 700;
                color: #12455e;
                margin-bottom: 56px;
            }

            /* GRID */
            .palestrantes-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 42px;
            }

            .palestrantes-grid>.palestrante-card:last-child:nth-child(odd) {
                grid-column: 1 / -1;
                justify-self: center;
                max-width: 680px;
            }

            /* CARD */
            .palestrante-card {
                background: #ffffff00;
                border-radius: 24px;
                padding: 26px 30px;

                display: flex;
                align-items: center;
                gap: 32px;
                transition: gap .45s ease;

                border: 1px solid #12455e;

                transition:
                    transform .35s ease,
                    box-shadow .35s ease;
            }

            .palestrante-info {
                transition: transform .45s ease;
            }

            .palestrante-card.aberto .palestrante-info {
                transform: translateX(0);
            }

            /* Animação padrão do nome */
            .palestrante-info h3 {
                transition:
                    color .3s ease,
                    transform .35s ease;
            }

            /* Sobe o nome quando o card abre */
            .palestrante-card.aberto .palestrante-info h3 {
                transform: translateY(-4px);
            }

            .palestrante-card.aberto {
                gap: 0;
            }

            .palestrante-card:hover {
                transform: translateY(-2px);
                box-shadow:
                    0 6px 20px rgba(18, 69, 94, 0.12),
                    0 2px 6px rgba(0, 0, 0, 0.08);
            }

            .palestrante-avatar {
                flex-shrink: 0;
                flex-basis: 190px;

                transition:
                    opacity .4s ease,
                    flex-basis .45s cubic-bezier(.22, 1, .36, 1),
                    transform .45s cubic-bezier(.22, 1, .36, 1);
            }

            .palestrante-avatar img {
                width: 190px;
                height: 190px;
                object-fit: cover;
                border-radius: 50%;

                box-shadow: 0 8px 22px rgba(0, 0, 0, 0.14);
                display: block;
            }

            .palestrante-card.aberto .palestrante-avatar {
                opacity: 0;
                flex-basis: 0;
                transform: scale(0.85);
                pointer-events: none;

                width: 0;
            }

            .palestrante-card.aberto .palestrante-avatar img {
                box-shadow: none;
            }


            /* INFO */
            .palestrante-info h3 {
                font-size: 24px;
                font-weight: 700;
                color: #12455e;
                margin-bottom: 12px;
            }

            .palestrante-info p {
                font-size: 18px;
                line-height: 1.3;
                color: #12455e;
                margin-bottom: 10px;
            }

            /* TEXTO EXTRA */
            .palestrante-extra {
                display: none;
            }

            /* BOTÃO */
            .btn-ver-mais {
                background: none;
                border: none;
                padding: 0;

                font-size: 15px;
                font-weight: 700;
                color: #e92d26;
                cursor: pointer;
            }

            /* ESTADO ABERTO */
            .palestrante-card.aberto .palestrante-extra {
                display: inline;
            }

            .palestrante-card.aberto .btn-ver-mais {
                letter-spacing: .3px;
                transition: all .25s ease;
            }

            .palestrante-card.aberto .btn-ver-mais {
                color: #063c4d;
                margin-top: 6px;

            }

            /* RESUMO */
            .palestrante-resumo {
                font-size: 17px !important;
                line-height: 1.7;
                color: #4b5563;

                overflow: hidden;
                max-height: 7.6em;

                transition: none;
            }

            /* ativa animação só depois */
            body.animado .palestrante-resumo {
                transition: max-height .6s cubic-bezier(.22, 1, .36, 1);
            }

            /* clamp quando fechado */
            /* estado fechado */
            .palestrante-card:not(.aberto) .palestrante-resumo {
                display: -webkit-box;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
            }

            /* aberto */
            .palestrante-card.aberto .palestrante-resumo {
                max-height: 1000px;
            }

            .modal-palestrante {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.6);

                display: flex;
                align-items: flex-end;
                justify-content: center;

                opacity: 0;
                pointer-events: none;

                transition: opacity .35s ease;
                z-index: 9999;
            }

            .modal-palestrante.ativo {
                opacity: 1;
                pointer-events: auto;
            }

            /* CONTEÚDO */
            .modal-conteudo {
                background: #ffffff;
                width: 100%;
                max-width: 520px;

                border-radius: 24px 24px 0 0;
                padding: 28px 24px 18px;

                transform: translateY(100%);
                transition: transform .45s cubic-bezier(.22, 1, .36, 1);
            }

            /* ANIMAÇÃO AO ABRIR */
            .modal-palestrante.ativo .modal-conteudo {
                transform: translateY(0);
            }

            /* TÍTULO */
            .modal-conteudo h3 {
                font-size: 20px;
                font-weight: 700;
                color: #12455e;
                margin-bottom: -10px;

            }

            /* TEXTO */
            .modal-conteudo p {
                font-size: 17px;
                line-height: 1.7;
                color: #12455e;
                text-align: left;
            }

            /* BOTÃO FECHAR */
            .modal-fechar {
                position: absolute;
                top: 12px;
                right: 18px;

                background: none;
                border: none;
                font-size: 30px;
                line-height: 1;
                color: #12455e;
                cursor: pointer;
            }

            /* ===============================
            RESPONSIVO
            =============================== */
            /* TABLET */
            @media (max-width:1024px) {

                .modal-conteudo {
                    max-width: 480px;
                    padding: 26px 22px 18px;
                }

                .modal-conteudo h3 {
                    font-size: 19px;
                }

                .modal-conteudo p {
                    font-size: 16px;
                    line-height: 1.65;
                }
            }

            @media (max-width: 768px) {

                /* Remove resumo e botão */
                .palestrante-resumo,
                .btn-ver-mais {
                    display: none !important;
                }

                .curso-palestrantes {
                    padding: 0 0 60px;
                }

                /* CARD */
                .palestrante-card {
                    flex-direction: column;
                    text-align: center;
                    padding: 16px 12px;
                    background-color: #ffffffde;
                    gap: 12px;
                    align-items: center;
                    cursor: pointer;
                    min-height: auto;
                }

                /* AVATAR */
                .palestrante-avatar {
                    flex-basis: auto;
                    margin-bottom: 8px;
                }

                .palestrante-avatar img {
                    width: 90px;
                    height: 90px;
                    margin-bottom: -5px;
                    border-radius: 50%;
                }

                /* INFO */
                .palestrante-info {
                    margin-top: 0;
                }

                .palestrante-info h3 {
                    font-size: 14px;
                    line-height: 1.2;
                    margin: 0;
                    color: #12455e;
                }

                /* GRID */
                .palestrantes-grid {
                    gap: 16px;
                }

                /* Título principal */
                .palestrantes-titulo {
                    font-size: 24px;
                    margin-bottom: 32px;
                }

                .modal-conteudo {
                    max-width: 100%;
                    border-radius: 22px 22px 0 0;
                    padding: 24px 20px 18px;
                }

                .modal-conteudo h3 {
                    font-size: 18px;
                }

                .modal-conteudo p {
                    font-size: 15px;
                    line-height: 1.6;
                }

                .modal-fechar {
                    font-size: 28px;
                    top: 10px;
                    right: 16px;
                }
            }

            @media (max-width:480px) {

                .modal-conteudo {
                    padding: 22px 18px 16px;
                }

                .modal-conteudo h3 {
                    font-size: 17px;
                }

                .modal-conteudo p {
                    font-size: 14px;
                    line-height: 1.6;
                }

                .modal-fechar {
                    font-size: 26px;
                }

            }

            @media (max-width:360px) {

                .modal-conteudo {
                    padding: 20px 16px 14px;
                }

                .modal-conteudo h3 {
                    font-size: 16px;
                }

                .modal-conteudo p {
                    font-size: 13px;
                    line-height: 1.55;
                }

                .modal-fechar {
                    font-size: 24px;
                }

            }
        </style>

    </section>
	
	<!-- INFORMAÇÕES DO CURSO -->
    <!-- SECTION CERTIFICADO -->
    <section class="certificado_section">
		
		<div class="container-palestrantes">
		<h2 class="curso-info-titulo">Links Úteis</h2>
            

			<!-- LINKS -->
		
			<div class="container_Acordeon">
				<div class="header_Acordeon">
					Veja aqui todos os links dos Seminários
				</div>
				
				<details>
					<summary>
						<div>
							SERVIÇOS QUE EXECUTAM EXAMES DE ANÁLISES CLÍNICAS (EAC)
							<span class="date-info">20 de Maio de 2026</span>
						</div>
					</summary>
					<div class="content">
						<a href="https://www.youtube.com/live/3gSL9TaIYRk" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Manhã</a>
						<a href="https://www.youtube.com/live/3gSL9TaIYRk" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Tarde</a>
						<a href="https://drive.google.com/drive/folders/1yFf4_8UmWmP5fcA-kIGhnn0pIpDa4nJR" class="btn btn-fotos"><i class="fa-regular fa-images"></i>&nbsp;&nbsp; Ver Fotos do Seminário</a>
						<a href="https://drive.google.com/drive/folders/1EE4xPBXYCyEdnsZka5mVPD-1ohnXa3j_" class="btn btn-arquivos">
							<i class="fa-regular fa-file"></i>&nbsp;&nbsp; Arquivos de Apresentações
						</a>
					</div>
				</details>
				
				<details>
					<summary>
						<div>
							DISTRIBUIDORA E TRANSPORTADORA: MEDICAMENTOS, COSMÉTICOS E CORRELATOS
							<span class="date-info">21 de Agosto de 2025</span>
						</div>
					</summary>
					<div class="content">
						<a href="https://www.youtube.com/watch?v=uRNDyeRC2qU" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Manhã</a>
						<a href="https://www.youtube.com/watch?v=rv8xbA_12xE" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Tarde</a>
						<!--<a href="#" class="btn btn-fotos"><i class="fa-regular fa-images"></i>&nbsp;&nbsp; Ver Fotos do Seminário</a>-->
					</div>
				</details>
				
				<details>
					<summary>
						<div>
							FARMÁCIA MAGISTRAL | FARMÁCIA VIVA E PICS
							<span class="date-info">23 de Julho de 2025</span>
						</div>
					</summary>
					<div class="content">
						<a href="https://www.youtube.com/live/JFFwjwfsWkM" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Manhã</a>
						<a href="https://www.youtube.com/live/s1IXuJ1UkbA" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Tarde</a>
						<a href="https://drive.google.com/drive/folders/1-fNgTvbF641VEaiICNOh65qDNR9mCYcz?usp=share_link" class="btn btn-fotos"><i class="fa-regular fa-images"></i>&nbsp;&nbsp; Ver Fotos do Seminário</a>
					</div>
				</details>
				
				<details>
					<summary>
						<div>
							FARMÁCIA PRIVATIVA, ONCOLOGIA E RADIOFÁRMACOS
							<span class="date-info">27 de Junho de 2025</span>
						</div>
					</summary>
					<div class="content">
						<a href="https://www.youtube.com/watch?v=PDsrsPaPMpg&pp=ygUFQ1JGTUc%3D" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Manhã</a>
						<a href="https://www.youtube.com/watch?v=1DlOGn301A0&pp=ygUFQ1JGTUc%3D" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Tarde</a>
						<a href="https://drive.google.com/drive/folders/1DTob82mQV6la2i9Goz27_7B9oiqCpoZr" class="btn btn-fotos"><i class="fa-regular fa-images"></i>&nbsp;&nbsp; Ver Fotos do Seminário</a>
					</div>
				</details>

				<details>
					<summary>
						<div>
							SERVIÇO EM ESTÉTICA
							<span class="date-info">04 de Abril de 2025</span>
						</div>
					</summary>
					<div class="content">
						<a href="https://youtube.com/live/ONZGYnS-zo8?feature=share" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Manhã</a>
						<a href="https://youtube.com/live/YHpcdf3HcKw?feature=share" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp; Link Tarde</a>
						<a href="#" class="btn btn-fotos"><i class="fa-regular fa-images"></i>&nbsp;&nbsp; Ver Fotos do Seminário</a>
					</div>
				</details>

				<details>
					<summary>
						<div>
							FARMÁCIAS E DROGARIAS
							<span class="date-info">28 de Junho de 2024</span>
						</div>
					</summary>
					<div class="content">
						<a href="https://www.youtube.com/watch?v=xjQ-Nro4Rwc&pp=ygUQQ1JGTUcgc2VtaW7DoXJpbw%3D%3D" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp;Link Manhã</a>
						<a href="https://www.youtube.com/watch?v=H06-12hynU0&pp=ygUQQ1JGTUcgc2VtaW7DoXJpbw%3D%3D" class="btn btn-youtube"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp;Link Tarde</a>
						<a href="https://drive.google.com/drive/folders/1_4huw6lInIbut5VP1A-kU_avo7-jULFQ" class="btn btn-fotos"><i class="fa-regular fa-images"></i>&nbsp;&nbsp; Ver Fotos do Seminário</a>
					</div>
				</details>

			</div>
		</div>
	</section>			


    <!-- SECTION CERTIFICADO -->
    <section class="certificado_section">

        <div class="certificado_box" id="certificado_box">

            <h2 class="certificado_titulo">
                Informe seu CPF<br>
                cadastrado para emitir o certificado
            </h2>

            <input
                type="text"
                class="certificado_input"
                placeholder="Digite seu CPF ou e-mail">

            <button class="certificado_botao">
                GERAR CERTIFICADO
            </button>
			
			<div id='resultado-busca'></div>
        </div>
		
		<script>
			// CERTIFICADO FUNCTION
			$(document).ready(function() {
			
				$('.certificado_botao').on('click', function() {
				const cpf = $('.certificado_input').val();
				
				console.log('buscando...'+cpf);
				
				const $container = $('#resultado-busca'); // Seleciona a div de resultado

				// Validação: Se o campo estiver vazio
				if (!cpf) {
					$container.html(`
						<div class="alert alert-warning mt-3" role="alert">
							<i class="bi bi-exclamation-triangle-fill"></i> 
							Por favor, informe o CPF ou E-mail para continuar.
						</div>
					`);
					return; // Para a execução aqui
				}

				// Se passou na validação, limpa o container e inicia o AJAX
				$container.html('<div class="text-center mt-3"><div class="spinner-border text-primary" role="status"></div></div>');

					$.ajax({
						url: '<?= base_url("seminario/buscarInscricoes") ?>',
						type: 'POST',
						data: { cpf: cpf }, 
						dataType: 'json',
						success: function(data) {
							// CORREÇÃO 1: Adicionado o check de tamanho do array
							if (data && data.length > 0) {
								// CORREÇÃO 2: Inicialização da variável html com a estrutura da tabela
								let html = `
									<table class="table mt-4 table-striped">
										<thead>
											<tr>
												<th>Data</th>
												<th>Evento</th>
												<th>Modalidade</th>
												<th class="text-center">Ação</th>
											</tr>
										</thead>
										<tbody>`;

								data.forEach(item => {
									let acaoHtml = '';
									
									// Datas para cálculo
									const dataEvento = new Date(item.data_evento); 
									const hoje = new Date();
									hoje.setHours(0, 0, 0, 0); 
									
									console.log(dataEvento);
									
									const diffTime = hoje - dataEvento;
									const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
									console.log(item.data_pura);
									console.log(item.data_evento);
									console.log(diffTime);
									console.log(diffDays);

									if (item.presenca == 1) {
										acaoHtml = `<a href="<?= base_url('seminario/gerarCertificado') ?>/${item.inscricao_id}" class="btn btn-sm btn-success">Gerar Certificado</a>`;
									} else if (item.presenca == 0 && item.presenca_liberada == 1) {
										acaoHtml = `<button onclick="confirmarPresenca(${item.inscricao_id})" class="btn btn-sm btn-primary">Confirmar Presença</button>`;
									} 
									else {
										acaoHtml = `<span class="badge bg-secondary">Indisponível</span>`;
									}

									const cores = {
										'presencial': '#F43F3F',
										'online': '#0ca3b4'
									};

									// Pega a cor do mapa ou usa preto (#000) como padrão (fallback)
									const corStyle = cores[item.modalidade.toLowerCase()] || '#000';

									html += `
										<tr>
											<td>${item.data_evento_formatada}</td>
											<td>${item.evento_nome}</td>
											<td style="color: ${corStyle}; font-weight: bold;">
												${item.modalidade}
											</td>
											<td class="text-center">${acaoHtml}</td>
										</tr>`;
								});

								html += '</tbody></table>';
								$container.html(html);
							} else {
								$container.html('<div class="alert alert-warning mt-3">Nenhum registro encontrado para este CPF ou E-mail.</div>');
							}
						},
						error: function() {
							$container.html('<div class="alert alert-danger mt-3">Erro ao conectar com o servidor. Verifique sua conexão.</div>');
						}
					});
				
				});
		});
		
		function confirmarPresenca(id) {
					// Substitui o confirm() nativo
					Swal.fire({
						title: 'Confirmar Presença?',
						text: "Deseja confirmar sua presença neste evento?",
						icon: 'question',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#aaa',
						confirmButtonText: 'Sim, confirmar!',
						cancelButtonText: 'Cancelar'
					}).then((result) => {
						if (result.isConfirmed) {
							// Mostra um loading enquanto o AJAX processa
							Swal.fire({
								title: 'Processando...',
								allowOutsideClick: false,
								didOpen: () => { Swal.showLoading(); }
							});

							$.ajax({
								url: '<?= base_url("seminario/setPresenca") ?>',
								type: 'POST',
								data: { id: id },
								dataType: 'json',
								success: function(res) {
									if (res.status === 'success') {
										Swal.fire({
											title: 'Sucesso!',
											text: res.message || 'Presença confirmada!',
											icon: 'success',
											timer: 2000,
											showConfirmButton: false
										});
										$('.certificado_botao').click(); // Atualiza a tabela
									} else {
										Swal.fire('Erro!', res.message, 'error');
									}
								},
								error: function(xhr) {
									const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Erro ao conectar com o servidor.';
									Swal.fire('Atenção', msg, 'warning');
								}
							});
						}
					});
				}

    </script>
        <style>
            /* SECTION */
            .certificado_section {
                width: 100%;
                background-color: #fff;
                padding: 0px 20px 80px;
                display: flex;
                justify-content: center;
                align-items: center;
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


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const cards = document.querySelectorAll('.palestrante-card');
            const ALTURA_FECHADO = '7.6em';

            const modal = document.getElementById('modalPalestrante');
            const modalNome = document.getElementById('modalNome');
            const modalDescricao = document.getElementById('modalDescricao');
            const fecharModalBtn = document.querySelector('.modal-fechar');

            /* remove botão se não precisar */
            cards.forEach(card => {

                const resumo = card.querySelector('.palestrante-resumo');
                const btn = card.querySelector('.btn-ver-mais');

                if (!resumo || !btn) return;

                resumo.style.maxHeight = 'none';
                const alturaTotal = resumo.scrollHeight;

                resumo.style.maxHeight = ALTURA_FECHADO;
                const alturaFechada = resumo.clientHeight + 2;

                if (alturaTotal <= alturaFechada) {
                    btn.style.display = 'none';
                    card.classList.add('sem-expansao');
                }

            });

            requestAnimationFrame(() => {
                document.body.classList.add('animado');
            });

            function abrirCard(card) {

                const resumo = card.querySelector('.palestrante-resumo');
                const btn = card.querySelector('.btn-ver-mais');

                resumo.style.maxHeight = resumo.scrollHeight + 'px';

                card.classList.add('aberto');

                if (btn) btn.textContent = 'ver menos';

            }

            function fecharCard(card) {

                const resumo = card.querySelector('.palestrante-resumo');
                const btn = card.querySelector('.btn-ver-mais');

                resumo.style.maxHeight = ALTURA_FECHADO;

                card.classList.remove('aberto');

                if (btn) btn.textContent = 'ver mais';

            }

            /* HOVER DESKTOP */
            cards.forEach(card => {

                if (card.classList.contains('sem-expansao')) return;

                card.addEventListener('mouseenter', () => {

                    if (window.innerWidth <= 768) return;

                    abrirCard(card);

                });

                card.addEventListener('mouseleave', () => {

                    if (window.innerWidth <= 768) return;

                    fecharCard(card);

                });

            });

            /* CLICK BOTÃO */
            cards.forEach(card => {

                const btn = card.querySelector('.btn-ver-mais');

                if (!btn) return;

                btn.addEventListener('click', e => {

                    e.stopPropagation();

                    if (card.classList.contains('aberto'))
                        fecharCard(card);
                    else
                        abrirCard(card);

                });

            });

            /* MODAL MOBILE */
            cards.forEach(card => {

                card.addEventListener('click', () => {

                    if (window.innerWidth > 768) return;

                    const nome = card.querySelector('h3').innerText;
                    const descricao = card.querySelector('.palestrante-resumo').innerText;

                    modalNome.innerText = nome;
                    modalDescricao.innerText = descricao;

                    modal.classList.add('ativo');

                });

            });

            function fecharModal() {
                modal.classList.remove('ativo');
            }

            fecharModalBtn.addEventListener('click', fecharModal);

            modal.addEventListener('click', e => {

                if (e.target === modal)
                    fecharModal();

            });

        });
    </script>
</body>

</html>
