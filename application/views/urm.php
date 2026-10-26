<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Porta Farma - Uso Racional de Medicamentos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            padding: 0px 0 25px;
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

        .hero-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 52px;
        }

        .hero-actions .btn-voltar {
            margin-bottom: 0;
        }

        .btn-emitir-certificado {
            background: #0b4f63;
            color: #fff;
            border-color: #0b4f63;
        }

        .btn-emitir-certificado:hover {
            background: #239961;
            border-color: #239961;
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
                src="assets\banner_projetos\Banner-Projetos_URM.jpg"
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
	
		$cursosAtivos = array_values($urm ?? []);
	
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
    <!-- URM -->
    <section class="curso-hero">
        <div class="container-inscricao">
            <div class="hero-actions">
                <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>
                <a href="#certificado-section" class="btn-voltar btn-emitir-certificado">EMITIR CERTIFICADO</a>
            </div>


            <div class="curso-hero-grid">
                <div class="curso-hero-info">
                    <h1 class="curso-titulo destaque">Uso Racional de Medicamentos</h1>
                    <p class="curso-publicacao">
                        A Campanha de Uso Racional de Medicamentos, promovida pelo Conselho Regional de Farmácia do Estado de Minas Gerais (CRF/MG) visa o fortalecimento do uso seguro de medicamentos pela população, e maior visibilidade e valorização do profissional farmacêutico. </p>
                </div>
				
				<?php if (count($cursosAtivos) > 0): ?>
                <div class="curso-hero-card">
                    <?php foreach ($cursosAtivos as $indice => $campo): ?>
                        <?php
                        $data_inicio = new DateTime($campo->data_inicio);
                        $data_fim = !empty($campo->data_fim) ? new DateTime($campo->data_fim) : null;
                        ?>
                        <?php if ($indice > 0): ?>
                            <hr class="curso-divisoria">
                        <?php endif; ?>
                    <div class="curso-hero-item">
                    <ul class="curso-detalhes">
                        <li><strong>Tema:</strong> <?=htmlspecialchars($campo->titulo, ENT_QUOTES, 'UTF-8')?></li>
                        <li><strong>Data:</strong> <?= formatarDataEvento($data_inicio, $data_fim); ?></li>
                        <li><strong>Horário:</strong> <?=$data_inicio->format('G:i')?><?php if ($data_fim): ?> às <?=$data_fim->format('G:i')?><?php endif; ?></li>
                        <li><strong>Local:</strong> <?=htmlspecialchars($campo->local, ENT_QUOTES, 'UTF-8')?></li>
                    </ul>
                    <?php if (!empty($campo->descricao)): ?>
                        <!--<div class="curso-descricao"><?=$campo->descricao?></div>-->
                    <?php endif; ?>
					<a href="<?=base_url('urm/inscricao/' . rawurlencode((string) $campo->courseid))?>" class="btn-inscricao grande">INSCRIÇÕES ABERTAS</a>
                    </div>
                    <?php endforeach; ?>
                </div>
				<?php else: ?>
					<div class="curso-hero-card">
						<i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
						<h5 class="mb-0">Nenhum Uso Racional de Medicamentos <br> programada no momento.</h5>
					</div>
				<?php endif; ?>
            </div>
        </div>

        <style>
            .curso-divisoria {
                width: 100%;
                margin: 32px 0;
                border: 0;
                border-top: 1px solid #d1d5db;
                opacity: 1;
            }

            .curso-descricao {
                margin: 16px 0;
                overflow-wrap: anywhere;
            }

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
                    padding: 15px 0 40px !important;

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
        </style>
    </section>

    <!-- INFORMAÇÕES DO CURSO -->
    <section class="lugares-section container-fluid text-center py-5">
        <h2 class="curso-info-titulo">Últimos Eventos do Projeto</h2>

        <div class="container-card rounded-4 p-1 mt-4">
            <div class="cards-grid" id="cards-carousel">
                <?php
                $meses = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
                $anosLocais = [];
                foreach (($locais_urm ?? []) as $indiceLocal => $local):
                    $dataLocal = !empty($local->data_evento) ? strtotime($local->data_evento) : false;
                    $anoLocal = $dataLocal !== false ? date('Y', $dataLocal) : 'sem-data';
                    $anosLocais[$anoLocal] = $anoLocal === 'sem-data' ? 'Sem data' : $anoLocal;
                    $descricaoLocal = (string) $local->descricao;
                    $descricaoLonga = mb_strlen($descricaoLocal, 'UTF-8') > 150;
                    $resumoLocal = $descricaoLonga ? mb_substr($descricaoLocal, 0, 150, 'UTF-8') . '...' : $descricaoLocal;
                ?>
                    <div class="card custom-card card-lugar shadow-lg<?=$indiceLocal >= 3 ? ' local-card-oculto' : ''?>" data-local-id="<?= (int) $local->id ?>" data-ano="<?=$anoLocal?>">
                        <div class="card-body">
                            <h5 class="card-title py-2"><?=htmlspecialchars($local->titulo, ENT_QUOTES, 'UTF-8')?></h5>
                            <p class="card-subtitle">
                                <i class="fa-solid fa-location-dot"></i>
                                <?=htmlspecialchars($local->cidade_evento ?? 'Local não informado', ENT_QUOTES, 'UTF-8')?>
                            </p>
                            <p class="card-text">
                                <span class="card-text-resumo"><?=nl2br(htmlspecialchars($resumoLocal, ENT_QUOTES, 'UTF-8'))?></span>
                                <?php if ($descricaoLonga): ?>
                                    <span class="card-text-completo" id="descricao-local-<?= (int) $indiceLocal ?>" hidden><?=nl2br(htmlspecialchars($descricaoLocal, ENT_QUOTES, 'UTF-8'))?></span>
                                    <button type="button" class="card-text-toggle" aria-expanded="false" aria-controls="descricao-local-<?= (int) $indiceLocal ?>">Ver mais</button>
                                <?php endif; ?>
                            </p>
                            <div class="card-footer-info">
                                <?php if (!empty($local->link)): ?>
                                    <a href="<?=htmlspecialchars($local->link, ENT_QUOTES, 'UTF-8')?>" class="card-button" target="_blank" rel="noopener noreferrer">Ver sobre</a>
                                <?php endif; ?>
                                <span class="card-date">
                                    <i class="fa-regular fa-calendar"></i>
                                    <?php if ($dataLocal !== false): ?>
                                        <?=$meses[(int) date('n', $dataLocal)]?> de <?=date('Y', $dataLocal)?>
                                    <?php else: ?>
                                        Data não informada
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <img src="<?=base_url('uploads/urm_locais/'.rawurlencode($local->imagem_arquivo))?>" class="card-img-top" alt="<?=htmlspecialchars($local->titulo, ENT_QUOTES, 'UTF-8')?>">
                    </div>
                <?php endforeach; ?>
                <?php if (empty($locais_urm)): ?>
                    <p class="text-muted">Nenhum local cadastrado.</p>
                <?php endif; ?>
            </div>

            <div class="carousel-dots" id="carousel-dots"></div>
            <?php if (count($locais_urm ?? []) > 3): ?>
                <button type="button" class="mostrar-locais-btn" id="mostrar-locais-btn" aria-expanded="false">
                    <span>Mostrar demais</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            <?php endif; ?>
            <?php if (!empty($locais_urm)): ?>
                <?php krsort($anosLocais, SORT_NUMERIC); ?>
                <div class="locais-filtro" id="filtro-ano-locais" role="group" aria-label="Filtrar locais por ano">
                        <button type="button" class="locais-ano-btn active" data-ano="" aria-pressed="true" aria-controls="cards-carousel locais-seletor">Todos os anos</button>
                        <?php foreach ($anosLocais as $ano => $rotuloAno): ?>
                            <button type="button" class="locais-ano-btn" data-ano="<?=htmlspecialchars((string) $ano, ENT_QUOTES, 'UTF-8')?>" aria-pressed="false" aria-controls="cards-carousel locais-seletor"><?=htmlspecialchars((string) $rotuloAno, ENT_QUOTES, 'UTF-8')?></button>
                        <?php endforeach; ?>
                </div>
                <div class="locais-seletor" id="locais-seletor" aria-label="Selecionar local">
                    <?php foreach ($locais_urm as $local): ?>
                        <?php $dataSeletor = !empty($local->data_evento) ? strtotime($local->data_evento) : false; ?>
                        <button type="button" class="local-seletor-item" data-local-id="<?=(int) $local->id?>" data-ano="<?=$dataSeletor !== false ? date('Y', $dataSeletor) : 'sem-data'?>">
                            <?=htmlspecialchars($local->titulo . (!empty($local->cidade) ? ' - ' . $local->cidade : ''), ENT_QUOTES, 'UTF-8')?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <style>
            /* ================================
            SECTION
            ================================ */

            .lugares-section {
                background-color: #FFFFFF;
                padding-top: 4rem;
                padding-bottom: 4rem;
                text-align: center;
            }

            /* ================================
            CONTAINER
            ================================ */

            .container-card {
                max-width: 1350px;
                margin: 0 auto;
                padding: 0 1rem;
                margin-bottom: 25px;
                border-radius: 1rem;
            }

            /* ================================
            GRID
            ================================ */

            .cards-grid {
                display: flex;
                justify-content: center;
                gap: 2rem;
                flex-wrap: wrap;
            }

            /* ================================
            CARD
            ================================ */

            .card.custom-card {
                flex: 0 0 calc(33.333% - 2rem);
                max-width: 460px;
            }

            /* CARD BASE */

            .card.custom-card {
                background-color: #F8FAFC;
                color: #1E293B;
                border-radius: 2rem;
                display: flex;
                position: relative;
                flex-direction: column;
                height: auto;
                overflow: hidden;
                border: 1px solid #E2E8F0;
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
                transition: transform .25s ease, box-shadow .25s ease;
            }

            /* ================================
            CARD BODY
            ================================ */

            .card .card-body {
                padding: 1.5rem;
                flex-grow: 1;
                text-align: left;
                display: flex;
                flex-direction: column;
            }

            /* ================================
            TÍTULO DA SEÇÃO
            ================================ */

            .curso-info-titulo {
                text-align: center;
                font-size: clamp(22px, 2.4vw, 36px);
                font-weight: 700;
                color: #12455e;
                margin-bottom: clamp(28px, 4vw, 60px);
            }

            /* ================================
            TÍTULO DO CARD
            ================================ */

            .card-title {
                font-size: clamp(18px, 1.5vw, 24px);
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: #12455e;
            }

            /* ================================
            SUBTÍTULO
            ================================ */

            .card-subtitle {
                font-size: clamp(14px, 1vw, 18px);
                font-weight: 500;
                color: #454e5c;
                margin-bottom: 10px;
                margin-top: -10px;

                display: flex;
                align-items: center;
                gap: 8px;
            }

            .card-subtitle i {
                font-size: clamp(12px, 0.8vw, 15px);
                color: #e92d26;
            }

            /* ================================
            TEXTO
            ================================ */

            .card-text-toggle {
                padding: 0;
                border: 0;
                background: none;
                color: #12455e;
                font: inherit;
                font-weight: 600;
                text-decoration: underline;
                cursor: pointer;
            }

            .card-text [hidden] {
                display: none !important;
            }

            .card-text {
                font-weight: 400;
                font-size: clamp(14px, 1vw, 17px);
                line-height: 1.5;
                color: #334155;
                margin-bottom: auto;
            }

            /* ================================
            FOOTER
            ================================ */

            .card-footer-info {
                display: flex;
                align-items: center;
                margin-top: 18px;
                width: 100%;
            }

            /* ================================
            BOTÃO
            ================================ */

            .card-button {
                display: inline-block;
                padding: clamp(6px, 0.7vw, 10px) clamp(14px, 1.2vw, 18px);
                font-size: clamp(13px, 0.9vw, 16px);
                font-weight: 600;
                color: #FFFFFF;
                background-color: #3B5FC0;
                border-radius: 10px;
                text-decoration: none;
                transition: all .25s ease;
            }

            .card-button:hover {
                background-color: #3353ac;
            }

            /* ================================
            DATA
            ================================ */

            .card-date {
                margin-left: auto;
                display: flex;
                align-items: center;
                gap: 6px;
                margin-top: auto;
                font-size: clamp(13px, 0.9vw, 16px);
                font-weight: 500;
                color: #566172;
            }

            .card-date i {
                font-size: clamp(12px, 0.8vw, 14px);
                color: #e92d26;
            }

            /* ================================
            IMAGEM
            ================================ */

            .card-img-top {
                width: 100%;
                height: 220px;
                object-fit: cover;
                border-top-left-radius: 2rem;
                border-top-right-radius: 2rem;
            }

            /* ================================
            MOBILE
            ================================ */

            .locais-seletor {
                display: flex;
                justify-content: flex-start;
                align-items: flex-start;
                flex-wrap: wrap;
                gap: 10px;
                margin: 8px auto 24px;
                padding: 0 12px;
                text-align: left;
            }

            .locais-filtro {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                padding: 0 12px;
                margin: 16px 0;
                text-align: left;
                color: #12455e;
                font-weight: 600;
            }

            .locais-ano-btn {
                background: #102f50;
                color: #fff;
                border: 2px solid #102f50;
                border-radius: 10px;
                padding: 9px 18px;
                font: inherit;
                max-width: 100%;
                cursor: pointer;
                transition: background .2s ease, border-color .2s ease;
            }

            .locais-ano-btn:hover,
            .locais-ano-btn.active {
                background: #1d4f7c;
                border-color: #5c9bd2;
            }

            .locais-ano-btn:focus-visible {
                outline: 2px solid #102f50;
                outline-offset: 3px;
            }

            .local-seletor-item[hidden], .mostrar-locais-btn[hidden] {
                display: none !important;
            }

            .local-seletor-item {
                border: 1px solid #d8e2e8;
                border-radius: 14px;
                background: #f8fafc;
                color: #12455e;
                padding: 10px 18px;
                font-size: 14px;
                font-weight: 600;
                max-width: 100%;
                text-align: left;
                white-space: normal;
                overflow-wrap: anywhere;
                line-height: 1.5;
                cursor: pointer;
                box-shadow: 0 3px 10px rgba(15, 23, 42, .06);
                transition: all .2s ease;
            }

            .local-seletor-item:focus-visible {
                outline: 2px solid #12455e;
                outline-offset: 3px;
            }

            .local-seletor-item:hover,
            .local-seletor-item.active {
                color: #fff;
                background: #12455e;
                border-color: #12455e;
                transform: translateY(-1px);
            }

            .card.custom-card.local-card-oculto {
                display: none;
            }

            .card.custom-card.local-card-dimmed {
                opacity: .28;
                filter: grayscale(.45);
                transform: scale(.97);
                box-shadow: none !important;
            }

            .card.custom-card.local-card-selecionado {
                opacity: 1;
                filter: none;
                transform: translateY(-8px) scale(1.02);
                border-color: rgba(18, 69, 94, .35);
                box-shadow: 0 20px 45px rgba(18, 69, 94, .28) !important;
                z-index: 2;
            }

            .mostrar-locais-btn {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                margin: 12px auto 18px;
                padding: 10px 20px;
                border: 1px solid #12455e;
                border-radius: 14px;
                color: #12455e;
                background: #fff;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
                transition: all .2s ease;
            }

            .mostrar-locais-btn:hover {
                color: #fff;
                background: #12455e;
            }

            .mostrar-locais-btn i {
                transition: transform .2s ease;
            }

            .mostrar-locais-btn[aria-expanded="true"] i {
                transform: rotate(180deg);
            }

            @media (max-width:768px) {

                .lugares-section {
                    padding-top: 0rem !important;
                    padding-bottom: 1rem !important;
                }

                .container-card {
                    position: relative;
                    overflow: visible;
                    margin-bottom: 10px;

                }

                .cards-grid {
                    display: flex;
                    overflow-x: auto;
                    scroll-snap-type: x mandatory;
                    -webkit-overflow-scrolling: touch;
                    gap: 1.5rem;
                    scroll-padding-left: 1rem;
                    flex-wrap: nowrap;
                    justify-content: flex-start;
                }

                .cards-grid::-webkit-scrollbar {
                    display: none;
                }

                .card.custom-card {
                    flex: 0 0 90%;
                    max-width: 90%;
                    scroll-snap-align: start;
                    border-radius: 1.5rem;
                    box-shadow: none !important;
                    height: auto;
                }

                .card.custom-card:first-child {
                    margin-left: 1.6rem;
                }

                .cards-grid>.card.custom-card:last-child {
                    margin-right: 1.6rem;
                }

                .card-img-top {
                    height: 180px;
                    border-top-left-radius: 1.5rem;
                    border-top-right-radius: 1.5rem;
                }

                .carousel-dots {
                    display: flex;
                    justify-content: center;
                    margin-top: 1.2rem;
                    margin-bottom: .8rem;
                    gap: .45rem;
                }

                .carousel-dots .dot {
                    width: 8px;
                    height: 8px;
                    background-color: #cbd5e1;
                    border-radius: 50%;
                    cursor: pointer;
                    transition: all .25s ease;
                }

                .carousel-dots .dot.active {
                    background-color: #12455e;
                    transform: scale(1.25);
                }


                .curso-info-titulo {
                    font-size: 19px;
                }
            }

            /* ================================
            HOVER DESKTOP
            ================================ */

            @media (min-width:769px) {

                .card.custom-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 12px 32px rgba(15, 23, 42, .12);
                }

            }
        </style>

    </section>
	
	
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

            .certificado-section {
                scroll-margin-top: 24px;
            }

            /* BOX */
            .certificado_box {
				background: #F8FAFC;
				padding: 40px 30px;
				border-radius: 18px;
				border: 1px solid rgba(23, 90, 120, 0.08);
				box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.08), 0 6px 18px rgba(23, 90, 120, 0.08), 0 20px 48px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.6) inset;
				
				/* Centralização e Margens */
				max-width: 820px;
				width: 100%;
				margin: 50px auto; /* 50px em cima/baixo e 'auto' nas laterais para centralizar */
				
				text-align: center;
				
				/* Garante que o box-shadow e bordas não quebrem o layout */
				box-sizing: border-box; 
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
    <!-- SECTION CERTIFICADO -->
    <section class="certificado-section" id="certificado-section">

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
            carousel.addEventListener('click', function (event) {
                const botao = event.target.closest('.card-text-toggle');
                if (!botao) return;
                const texto = botao.closest('.card-text');
                const expandir = botao.getAttribute('aria-expanded') !== 'true';
                texto.querySelector('.card-text-resumo').hidden = expandir;
                texto.querySelector('.card-text-completo').hidden = !expandir;
                botao.setAttribute('aria-expanded', String(expandir));
                botao.textContent = expandir ? 'Ver menos' : 'Ver mais';
            });
            const todosCards = Array.from(carousel.querySelectorAll(".card"));
            let cards = Array.from(carousel.querySelectorAll(".card:not(.local-card-oculto)"));
            let cardsFiltrados = todosCards;
            const dotsContainer = document.getElementById("carousel-dots");
            const botoesLocais = document.querySelectorAll(".local-seletor-item");
            const botaoMostrar = document.getElementById("mostrar-locais-btn");
            const filtroAno = document.getElementById('filtro-ano-locais');
            let anoSelecionado = '';
            let exibindoTodos = false;

            function atualizarDots() {
                cards = todosCards.filter((card) => !card.classList.contains('local-card-oculto'));
                dotsContainer.innerHTML = '';
                if (window.innerWidth > 768) return;
                cards.forEach((card, index) => {
                    const dot = document.createElement('span');
                    dot.classList.add('dot');
                    if (index === 0) dot.classList.add('active');
                    dot.addEventListener('click', () => card.scrollIntoView({behavior: 'smooth', inline: 'start', block: 'nearest'}));
                    dotsContainer.appendChild(dot);
                });
            }

            function atualizarLocais() {
                const visiveis = exibindoTodos ? cardsFiltrados : cardsFiltrados.slice(0, 3);
                todosCards.forEach((card) => {
                    card.classList.toggle('local-card-oculto', !visiveis.includes(card));
                    card.classList.remove('local-card-dimmed', 'local-card-selecionado');
                    card.style.order = '';
                });
                botoesLocais.forEach((botao) => {
                    botao.hidden = Boolean(anoSelecionado && botao.dataset.ano !== anoSelecionado);
                    botao.classList.remove('active');
                });
                if (botaoMostrar) {
                    botaoMostrar.hidden = cardsFiltrados.length <= 3;
                    botaoMostrar.setAttribute('aria-expanded', String(exibindoTodos));
                    botaoMostrar.querySelector('span').textContent = exibindoTodos ? 'Mostrar menos' : 'Mostrar demais';
                }
                atualizarDots();
            }

            if (filtroAno) {
                filtroAno.addEventListener('click', function (event) {
                    const escolhido = event.target.closest('.locais-ano-btn');
                    if (!escolhido) return;
                    anoSelecionado = escolhido.dataset.ano;
                    filtroAno.querySelectorAll('.locais-ano-btn').forEach((botao) => {
                        const ativo = botao === escolhido;
                        botao.classList.toggle('active', ativo);
                        botao.setAttribute('aria-pressed', String(ativo));
                    });
                    cardsFiltrados = todosCards.filter((card) => !anoSelecionado || card.dataset.ano === anoSelecionado);
                    exibindoTodos = false;
                    atualizarLocais();
                });
            }

            function selecionarLocal(idLocal) {
                const cardSelecionado = carousel.querySelector('.card[data-local-id="' + idLocal + '"]');
                if (!cardSelecionado || !cardsFiltrados.includes(cardSelecionado)) return;

                botoesLocais.forEach((botao) => {
                    botao.classList.toggle("active", botao.dataset.localId === String(idLocal));
                });

                let cardsVisiveis;
                if (!exibindoTodos) {
                    cardsVisiveis = cardsFiltrados.slice(0, 3);
                    if (!cardsVisiveis.includes(cardSelecionado)) {
                        cardsVisiveis = cardsFiltrados.slice(0, 2).concat(cardSelecionado);
                    }
                    todosCards.forEach((card) => {
                        card.classList.toggle("local-card-oculto", !cardsVisiveis.includes(card));
                    });
                } else {
                    cardsVisiveis = cardsFiltrados;
                }

                cardsVisiveis.forEach((card) => {
                    card.classList.toggle("local-card-selecionado", card === cardSelecionado);
                    card.classList.toggle("local-card-dimmed", card !== cardSelecionado);
                    card.style.order = "";
                });

                if (!exibindoTodos && cardsVisiveis.length === 3) {
                    const laterais = cardsVisiveis.filter((card) => card !== cardSelecionado);
                    laterais[0].style.order = "0";
                    cardSelecionado.style.order = "1";
                    laterais[1].style.order = "2";
                }

                if (window.innerWidth <= 768 || exibindoTodos) {
                    cardSelecionado.scrollIntoView({
                        behavior: "smooth",
                        inline: "center",
                        block: "nearest"
                    });
                }
                atualizarDots();
            }

            botoesLocais.forEach((botao) => {
                botao.addEventListener("click", () => selecionarLocal(botao.dataset.localId));
            });

            if (botaoMostrar) {
                botaoMostrar.addEventListener("click", () => {
                    exibindoTodos = !exibindoTodos;
                    atualizarLocais();
                });
            }

            if (window.innerWidth <= 768) {

                atualizarDots();

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
						url: '<?= base_url("urm/buscarInscricoes") ?>',
						type: 'POST',
						data: { cpf: cpf }, 
						dataType: 'json',
						success: function(data) {
							// CORREÇÃO 1: Adicionado o check de tamanho do array
							if (data && data.length > 0) {
								let html = `
									<div class="alert alert-info mt-3 mb-0">
										${data.length} ${data.length === 1 ? 'participação encontrada' : 'participações encontradas'}.
									</div>
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

									if (item.presenca == 1) {
										acaoHtml = `<a href="<?= base_url('urm/gerarCertificado') ?>/${item.inscricao_id}" target="_blank" class="btn btn-sm btn-success">Gerar Certificado</a>`;
									} 
									else if (item.presenca_liberada == 1) {
										acaoHtml = `<button type="button" onclick="confirmarPresenca(${item.inscricao_id})" class="btn btn-sm btn-primary">Marcar Presença</button>`;
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
						title: 'Marcar Presença?',
						text: "Deseja marcar sua presença neste evento?",
						icon: 'question',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#aaa',
						confirmButtonText: 'Sim, marcar!',
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
								url: '<?= base_url("urm/setPresenca") ?>',
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

</body>

</html>
