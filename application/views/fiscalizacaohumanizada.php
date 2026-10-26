<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Porta Farma - Fiscalização Humanizada</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/css/style_caminhos.css">
    <link rel="stylesheet" href="assets/css/style_iniciativas.css">
    <link rel="stylesheet" href="assets/css/style_selector.css">
    <link rel="stylesheet" href="assets/css/style_cursos.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

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
                src="assets\banner_projetos\Banner-Projetos_FISCALIZACAO HUMANIZADA.jpg"
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
	
		//var_dump($fiscalizacao);
	
		foreach ($fiscalizacao as $indice => $campo) {
			
			// DADOS BÁSICOS
			$descricao 		= $campo->descricao;
			$titulo 		= $campo->titulo;
			$local 			= $campo->local;
			$id 			= $campo->courseid;
			
			// DATAS
			$data_inicio 			= new DateTime($campo->data_inicio);
			$data_fim 				= !empty($campo->data_fim) ? new DateTime($campo->data_fim) : null;
			$campo_horario 			= $data_inicio->format('G:i');
			$campo_horario_final	= $data_fim ? $data_fim->format('G:i') : $campo_horario;
			
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
			if ($mi === $mf && $yi === $yf) {
				return "$di a $df de {$meses[$mi]} de $yi";
			}
			if ($yi === $yf) {
				return "$di de {$meses[$mi]} a $df de {$meses[$mf]} de $yi";
			}
			return "$di de {$meses[$mi]} de $yi a $df de {$meses[$mf]} de $yf";
			
		}
	?>

    <!-- FISCALIZAÇÃO HUMANIZADA -->
    <section class="curso-hero">
        <div class="container-inscricao">
            <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>


            <div class="curso-hero-grid">
                <div class="curso-hero-info">
                    <h1 class="curso-titulo destaque">Fiscalização Humanizada</h1>
                    <p class="curso-publicacao">
                        "FISCALIZAÇÃO HUMANIZADA - PARCEIROS NA PRÁTICA FARMACÊUTICA: Confiança e Excelência" é um projeto do Conselho Regional de Farmácia de Minas Gerais (CRF/MG), em parceria com a Vigilância Sanitária. Aprenda sobre as principais normas e legislações da área, tire suas dúvidas e contribua para um futuro mais promissor para a farmácia em Minas Gerais.
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
						<a href="<?=base_url()?>fiscalizacao-humanizada/inscricao/<?=$id?>" class="btn-inscricao grande">INSCRIÇÕES ABERTAS</a>
					</div>
				<?php else: ?>
					<div class="curso-hero-card">
						<i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
						<h5 class="mb-0">Nenhuma Fiscalização Humanizada <br> programada no momento.</h5>
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


    <!-- INFORMAÇÕES DO CURSO -->
    <section class="curso-informacoes">
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
												<p class="palestrante"> <?php echo trim($p); ?></p>
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

                    
                    <!-- FOTOS DO EVENTO -->
                    <div class="curso-info-fotos">
                        <p class="curso-info-fotos-texto">
                            Confira os melhores momentos deste encontro e veja os registros completos do evento.
                        </p>

                        <a href="https://drive.google.com/drive/folders/1PNIyefzUdnOj6Et0mOSMfkM6ZvN9C1hp"
                            class="curso-info-fotos-botao"
                            target="_blank"
                            rel="noopener noreferrer">
                            VER FOTOS DO EVENTO
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
    <section class="curso-palestrantes">
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
	
	<!-- SECTION CERTIFICADO -->
    <style>
        .certificado-section {
            width: 100%;
            background-color: #fff;
            padding: 0 20px 80px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .certificado_box {
            width: 100%;
            max-width: 820px;
            padding: 40px 30px;
            background: #f8fafc;
            border: 1px solid rgba(23, 90, 120, 0.08);
            border-radius: 18px;
            box-shadow:
                0 -4px 10px rgba(0, 0, 0, 0.08),
                0 6px 18px rgba(23, 90, 120, 0.08),
                0 20px 48px rgba(0, 0, 0, 0.12),
                inset 0 0 0 1px rgba(255, 255, 255, 0.6);
            text-align: center;
        }

        .certificado_titulo {
            margin: 0 0 28px;
            color: #ef382e;
            font-size: 30px;
            font-weight: 700;
            line-height: 1.22;
        }

        .certificado_input {
            display: block;
            width: 100%;
            max-width: 558px;
            height: 57px;
            margin: 0 auto 28px;
            padding: 0 20px;
            background-color: transparent;
            border: 1px solid #175a78;
            border-radius: 8px;
            color: #334155;
            font-size: 18px;
            text-align: center;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .certificado_input::placeholder {
            color: #7d8590;
            opacity: 1;
        }

        .certificado_input:focus {
            border-color: #086b9d;
            box-shadow: 0 0 0 3px rgba(8, 107, 157, 0.14);
        }

        .certificado_botao {
            min-width: 301px;
            min-height: 61px;
            padding: 14px 28px;
            background-color: #086b9d;
            border: 0;
            border-radius: 11px;
            color: #fff;
            cursor: pointer;
            font-size: 23px;
            font-weight: 700;
            line-height: 1.2;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .certificado_botao:hover {
            background-color: #075c87;
        }

        .certificado_botao:active {
            transform: translateY(1px);
        }

        .certificado_botao:focus-visible {
            outline: 3px solid rgba(8, 107, 157, 0.3);
            outline-offset: 3px;
        }

        #resultado-busca:not(:empty) {
            margin-top: 24px;
        }

        @media (max-width: 600px) {
            .certificado-section {
                padding: 0 16px 56px;
            }

            .certificado_box {
                padding: 32px 20px;
                border-radius: 14px;
            }

            .certificado_titulo {
                margin-bottom: 24px;
                font-size: 24px;
            }

            .certificado_input {
                height: 54px;
                margin-bottom: 24px;
                font-size: 16px;
            }

            .certificado_botao {
                width: 100%;
                min-width: 0;
                min-height: 56px;
                font-size: 19px;
            }
        }
    </style>
		
    <!-- SECTION CERTIFICADO -->
    <section class="certificado-section">

        <div class="certificado_box">

            <h2 class="certificado_titulo">
                Informe seu CPF<br>
                cadastrado para emitir o certificado
            </h2>

            <input
                type="text"
                class="certificado_input"
                placeholder="Digite seu CPF">

            <button class="certificado_botao">
                GERAR CERTIFICADO
            </button>
			
			<div id='resultado-busca'></div>
        </div>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const carousel = document.getElementById("cards-carousel");
            const cards = carousel.querySelectorAll(".card");
            const dotsContainer = document.getElementById("carousel-dots");

            if (window.innerWidth <= 768) {

                cards.forEach((card, index) => {

                    const dot = document.createElement("span");
                    dot.classList.add("dot");

                    if (index === 0) dot.classList.add("active");

                    dotsContainer.appendChild(dot);

                    dot.addEventListener("click", () => {

                        cards[index].scrollIntoView({
                            behavior: "smooth",
                            inline: "start",
                            block: "nearest"
                        });

                    });

                });

                carousel.addEventListener("scroll", () => {

                    let closestIndex = 0;
                    let closestDistance = Infinity;

                    cards.forEach((card, index) => {

                        const rect = card.getBoundingClientRect();
                        const containerRect = carousel.getBoundingClientRect();

                        const distance = Math.abs(rect.left - containerRect.left);

                        if (distance < closestDistance) {
                            closestDistance = distance;
                            closestIndex = index;
                        }

                    });

                    dotsContainer.querySelectorAll(".dot").forEach((dot, i) => {
                        dot.classList.toggle("active", i === closestIndex);
                    });

                });

            }

        });
    </script>
	<script>

			$(document).ready(function() {
			
				$('.certificado_botao').on('click', function() {
				const cpf = $('.certificado_input').val();
				
				console.log('buscando...');
				console.log(cpf);
				
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
						url: '<?= base_url("fiscalizacao-humanizada/buscarInscricoes") ?>',
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
												<th class="text-center">Ação</th>
											</tr>
										</thead>
										<tbody>`;

								data.forEach(item => {
									let acaoHtml = '';
									
									// Datas para cálculo
									// Certifique-se que item.data_pura vem do PHP no formato YYYY-MM-DD
									const dataEvento = new Date(item.data_pura); 
									const hoje = new Date();
									hoje.setHours(0, 0, 0, 0); 
									
									const diffTime = hoje - dataEvento;
									const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

									if (item.presenca == 1) {
										acaoHtml = `<a href="<?= base_url('fiscalizacao-humanizada/gerarCertificado') ?>/${item.inscricao_id}" class="btn btn-sm btn-success">Gerar Certificado</a>`;
									} 
									// CORREÇÃO 3: de 'elseif' para 'else if'
									else if (diffDays >= 0 && diffDays <= 3) {
										acaoHtml = `<button onclick="confirmarPresenca(${item.inscricao_id})" class="btn btn-sm btn-primary">Confirmar Presença</button>`;
									} 
									else {
										acaoHtml = `<span class="badge bg-secondary">Indisponível</span>`;
									}

									html += `
										<tr>
											<td>${item.data_evento_formatada}</td>
											<td>${item.evento_nome}</td>
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
								url: '<?= base_url("fiscalizacao-humanizada/setPresenca") ?>',
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
										$('.certificado-botao').click(); // Atualiza a tabela
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
