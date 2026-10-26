<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Farma</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/style_caminhos.css">
    <link rel="stylesheet" href="assets/css/style_iniciativas.css">
    <link rel="stylesheet" href="assets/css/style_selector.css">
    <link rel="stylesheet" href="assets/css/style_cursos.css">
    <link rel="stylesheet" href="assets/css/style_bjhp_documentos.css">


    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<?php

	// TOTAL DE INSCRITOS
	$totalStudent = 0;
	
	
	foreach ($contador_inscritos as $item) {
		$totalMoodle = (int) $item->total_usuarios_ativos;
	}
	
	@$inscritos_por_tipo = array_reduce($resultadosInscritos, function($carregador, $item) {
		$carregador[$item->tipo_evento] = ($carregador[$item->tipo_evento] ?? 0) + $item->total_inscritos;
		return $carregador;
	}, []);
	
	foreach ($URMInscritos as $item) {
		$totalURM = (int) $item->total_inscritos;
	}
	
	// 1. Soma os valores do array reduzido (Presencial + Online + etc)
	$totalInscritosPorTipo = array_sum($inscritos_por_tipo);

	// 2. Calcula o TOTAL geral
	$totalStudent = $totalMoodle + $totalInscritosPorTipo + $totalURM;
	//echo $totalStudent;


?>

<body>

    <!-- BANNER -->
    <div id="bannerCarousel" class="carousel slide banner"
        data-bs-ride="carousel"
        data-bs-interval="6000">

        <!-- INDICADORES -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerCarousel"
                data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#bannerCarousel"
                data-bs-slide-to="1"></button>
        </div>

        <!-- SLIDES -->
        <div class="carousel-inner">

            <!-- BANNER 1 -->
            <div class="carousel-item active">
                <picture>
                    <source media="(max-width: 768px)"
                        srcset="assets/img/PortalFarma-banner-mobile.png">

                    <img src="assets/img/PortalFarma-banner.png"
                        class="d-block w-100"
                        alt="Banner Portal Farma">
                </picture>
            </div>

            <!-- BANNER 2 -->
            <div class="carousel-item">
                <a href="https://revistacientifica.crfmg.emnuvens.com.br/crfmg/edicao_especial"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="d-block w-100">

                    <picture>
                        <source media="(max-width: 768px)"
                            srcset="assets/img/BJHP-banner_mobile_portal_farma.png">

                        <img src="assets/img/BJHP-banner_desktop portal_farma.png"
                            class="d-block w-100"
                            alt="BJHP Edição Especial 2026">
                    </picture>
                </a>
            </div>
        </div>

        <!-- SETAS -->
        <button class="carousel-control-prev" type="button"
            data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button"
            data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

        <style>
            #bannerCarousel .carousel-control-prev-icon,
            #bannerCarousel .carousel-control-next-icon {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                background-color: rgba(0, 0, 0, 0.45);
                background-size: 16px 16px;
                transition:
                    transform 0.2s ease,
                    box-shadow 0.2s ease,
                    background-color 0.2s ease;
            }

            #bannerCarousel .carousel-control-prev {
                left: -48px;
            }

            #bannerCarousel .carousel-control-next {
                right: -48px;
            }

            #bannerCarousel .carousel-control-prev:hover .carousel-control-prev-icon,
            #bannerCarousel .carousel-control-next:hover .carousel-control-next-icon {
                transform: scale(1.08);
                background-color: rgba(0, 0, 0, 0.65);
                box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35);
            }

            #bannerCarousel .carousel-control-prev:active .carousel-control-prev-icon,
            #bannerCarousel .carousel-control-next:active .carousel-control-next-icon {
                transform: scale(0.9);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
                background-color: rgba(0, 0, 0, 0.8);
            }

            #bannerCarousel .carousel-control-prev,
            #bannerCarousel .carousel-control-next {
                -webkit-tap-highlight-color: transparent;
            }

            @media (max-width: 768px) {

                #bannerCarousel .carousel-control-prev-icon,
                #bannerCarousel .carousel-control-next-icon {
                    width: 2rem;
                    height: 2rem;

                    background-image: var(--bs-carousel-control-prev-icon-bg);
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: 100% 100%;

                    background-color: transparent;
                    border-radius: 0;
                    box-shadow: none;
                    transform: none;
                }

                #bannerCarousel .carousel-control-next-icon {
                    background-image: var(--bs-carousel-control-next-icon-bg);
                }
            }
        </style>
    </div>

    <!-- CONTADOR -->
    <section class="section-contador">
        <div class="container-portal">
            <div class="contador-unico caminhos-contador" id="contador-wrapper">
                <span class="contador-num">
                    +<span id="contador">0</span>
                </span>
                <p>Alunos Inscritos</p>
            </div>
        </div>
    </section>
 
    <!-- CAMINHOS -->
    <section class="section-caminhos">
        <div class="container-portal">
            <div class="caminhos-layout">

                <!-- TEXTO -->
                <div class="caminhos-texto-wrapper">
                    <h2 class="caminhos-titulo">
                        PRONTO PARA ACELERAR<br> SUA CARREIRA?
                    </h2>
                    <p class="caminhos-texto">
                        Descubra cursos presenciais e online que transformam conhecimento em resultados reais.
                    </p>
                </div>

                <!-- CARDS -->
                <div class="caminhos-botoes">

                    <!-- Capacifar Online -->
                    <a class="btn-caminho btn-online btn-swap" data-modalidade="online">
                        <div class="btn-logos">
                            <img src="assets/img/logo-capacifar-online.png" alt="Capacifar Online">
                        </div>
                        <div class="btn-conteudo">
                            Excelência técnica onde você estiver. Capacitações flexíveis, inovadoras e
                            acessíveis para manter você sempre na vanguarda do setor farmacêutico.
                        </div>
                    </a>

                    <!-- Capacifar Presencial -->
                    <a class="btn-caminho btn-presencial btn-swap" data-modalidade="presencial">
                        <div class="btn-logos">
                            <img src="assets/img/logo-capacifar-presencial.png" alt="Capacifar Presencial">
                        </div>
                        <div class="btn-conteudo">
                            A tradição do aprendizado que percorre Minas Gerais. Há mais de uma década,
                            levamos atualização técnica e networking por todo o estado.
                        </div>
                    </a>

                    <!-- Capacifar Universitário -->
                    <a class="btn-caminho btn-universitario btn-swap " href="<?= base_url('universitario') ?>" id="btnuniversitario">
                        <div class="btn-logos">
                            <img src="assets/img/capacifar-universitario-branca.png" alt="Capacifar Universitário">
                        </div>
                        <div class="btn-conteudo">
                            Projeto do CRF/MG em parceria com faculdades de Farmácia de Minas Gerais. 
							<br>
							<br>
							Preencha a ficha de solicitação.
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </section>


    <script>
       
		
		document.addEventListener('DOMContentLoaded', () => {
            const total = <?= (int) $totalStudent; ?>;
            const contador = document.getElementById('contador');
            if (!contador) return;

            const duration = 5000;
            const inicio = performance.now();

            function animarContador(agora) {
                const progresso = Math.min((agora - inicio) / duration, 1);
                const suavizado = 1 - Math.pow(1 - progresso, 3);
                const valorAtual = Math.floor(total * suavizado);

                contador.textContent = valorAtual.toLocaleString('pt-BR');

                if (progresso < 1) {
                    requestAnimationFrame(animarContador);
                } else {
                    contador.textContent = total.toLocaleString('pt-BR');
                }
            }

            requestAnimationFrame(animarContador);
        });
    </script>

    <style>
        .section-contador {
            width: 100%;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(0, 49, 68, 0.08);
            position: relative;
            z-index: 10;
        }

        .caminhos-contador {
            text-align: center;
            padding: 24px 40px;
        }

        .caminhos-contador .contador-num {
            font-size: 49px;
            font-weight: 800;
            color: #095d7e;
        }

        .caminhos-contador p {
            margin-top: 4px;
            font-size: 20px;
            color: #003144;
        }

        @media (max-width: 768px) {
            .caminhos-contador {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                gap: 12px;
                padding: 14px 16px;
            }

            .caminhos-contador .contador-num {
                font-size: 26px;
                /* menor */
            }

            .caminhos-contador p {
                font-size: 14px;
                /* menor */
                margin: 0;
            }
        }
    </style>


    <!-- INICIATIVAS -->
    <div class="secao-iniciativas">

        <h2 class="titulo-iniciativas">
            Explore projetos que vão além da teoria e fortalecem sua prática no dia a dia
        </h2>

        <!-- DESKTOP -->
        <div class="logos-desktop">

            <!-- LINHA DE CIMA -->
            <div class="logos-grid">

                <!-- Atitude Farmacêutica -->
                <a href="#" class="logo-link has-tooltip disabled" tabindex="-1">
                    <img src="assets/img/icons/logos-projetos_atitude farmacêutica.png" alt="Atitude Farmacêutica">
                    <span class="tooltip">
                        Inovação que transforma e inspira. O palco para iniciativas que geram impacto real
                        na sociedade. Inscreva seu projeto, participe da votação e ajude a dar visibilidade
                        ao protagonismo transformador da profissão.
                    </span>
                </a>

                <!-- Fiscalização Humanizada -->
                <a href="<?= base_url() ?>fiscalizacao-humanizada" class="logo-link has-tooltip">
                    <img src="assets/img/icons/logos-projetos_fiscalização humanizada.png" alt="Fiscalização Humanizada">
                    <span class="tooltip">
                        Segurança e parceria como ferramentas de excelência. Uma iniciativa do CRF/MG em
                        parceria com a Vigilância Sanitária, promovendo uma fiscalização educativa,
                        colaborativa e orientada à segurança sanitária.
                    </span>
                </a>

                <!-- Mérito Acadêmico -->
                <a href="<?= base_url() ?>merito-academico" class="logo-link logo-merito has-tooltip">
                    <img src="assets/img/icons/merito_acadêmico.png" alt="Mérito Acadêmico">
                    <span class="tooltip">
                        Honrando o legado e premiando o futuro. A comenda reconhece a dedicação e o talento
                        dos novos profissionais de Minas Gerais, inspirada por um dos maiores nomes da
                        nossa história.
                    </span>
                </a>

                <!-- Minas de Superação -->
                <a href="https://crfmg.org.br/minasdesuperacao/" target="_blank" rel="noopener"
                    class="logo-link has-tooltip">
                    <img src="assets/img/icons/minas_de_superacao_branco-01.png" alt="Minas de Superação">
                    <span class="tooltip">
                        Liderança, acolhimento e cuidado integral. Uma rede colaborativa focada na saúde da
                        mulher e no empoderamento profissional, com capacitação para um atendimento
                        humanizado e debates sobre gênero, mercado e liderança.
                    </span>
                </a>

                <!-- Pesquisa Científica -->
                <a href="<?= base_url() ?>pesquisa-cientifica" class="logo-link logo-pesquisa has-tooltip">
                    <img src="assets/img/icons/pesquisa_científica.png" alt="Pesquisa Científica">
                    <span class="tooltip">
                        O ponto de encontro da ciência farmacêutica. Apoio real para quem produz
                        conhecimento, com espaço para divulgação de pesquisas e coleta de dados,
                        conectando pesquisadores de todo o país.
                    </span>
                </a>
            </div>

            <!-- LINHA DE BAIXO -->
            <div class="logos-grid logos-grid-bottom">

                <!-- Plenária Técnica -->
                <a href="https://crfmg.org.br/portalfarma/plenaria" rel="noopener"
                    class="logo-link has-tooltip">
                    <img src="assets/img/icons/logos-projetos_plenária técnica.png" alt="Plenária Técnica">
                    <span class="tooltip">
                        Onde as decisões estratégicas encontram a ciência. Fórum bimestral de análise
                        legislativa e técnica, promovendo diálogo entre instituições e profissionais para
                        o fortalecimento da profissão.
                    </span>
                </a>

                <!-- Podcast CRF/MG -->
                <a href="https://open.spotify.com/show/7fTVbzaZURCPAp7eY5P6Tf" target="_blank" rel="noopener"
                    class="logo-link logo-podcast has-tooltip">
                    <img src="assets/img/icons/podcast_1.png" alt="Podcast CRF/MG">
                    <span class="tooltip">
                        A voz da farmácia mineira. Informação técnica, debates atuais e entrevistas com
                        grandes nomes da área, em conteúdo dinâmico para você se atualizar onde e quando
                        quiser.
                    </span>
                </a>

                <!-- Receita Legível -->
                <!-- <a href="#" class="logo-link has-tooltip disabled" tabindex="-1">
                    <img src="assets/img/icons/logos-projetos_receita legível.png" alt="Receita Legível">
                    <span class="tooltip">
                        Clareza na prescrição e segurança para o paciente. Atuamos contra receitas
                        ilegíveis para garantir o direito técnico do farmacêutico e proteger quem precisa
                        de cuidado.
                    </span>
                </a>-->
				
				<!-- Seminário em Vigilância em Saúde -->
                <a href="<?= base_url() ?>seminario" class="logo-link has-tooltip disabled" tabindex="-1">
                    <img src="assets/img/icons/logos-projetos_seminario.png" alt="Seminário em Vigilância em Saúde">
                    <span class="tooltip">
                        O evento tem como principal objetivo promover um espaço de diálogo técnico, 
						qualificado e aprofundado sobre temas regulatórios e sanitários, 
						direcionado especialmente aos fiscais da Vigilância em Saúde e aos profissionais farmacêuticos.
                    </span>
                </a>

                <!-- Traga de Volta -->
                <a href="#" class="logo-link has-tooltip disabled" tabindex="-1">
                    <img src="assets/img/icons/traga_de_volta.png" alt="Traga de Volta">
                    <span class="tooltip">
                        Sustentabilidade e responsabilidade na palma da mão. Lideramos a logística reversa
                        de medicamentos com foco na saúde pública e no meio ambiente, engajando
                        estabelecimentos e comunidades.
                    </span>
                </a>

                <!-- Uso Racional de Medicamentos -->
                <a href="<?= base_url() ?>urm" class="logo-link has-tooltip">
                    <img src="assets/img/icons/logos-projetos_uso racional de medicamentos.png"
                        alt="Uso Racional de Medicamentos">
                    <span class="tooltip">
                        Protagonismo farmacêutico no cuidado à vida. Fortalecemos boas práticas e a
                        conscientização sobre o uso seguro de medicamentos, destacando o farmacêutico
                        como agente essencial da saúde pública.
                    </span>
                </a>
            </div>
        </div>

        <!-- MOBILE – CARROSSEL AUTOMÁTICO -->
        <div class="logos-carousel auto-scroll">
            <div class="logos-track">

                <!-- Atitude Farmacêutica (em breve) -->
                <a href="#" class="logo-link disabled" tabindex="-1">
                    <img src="assets/img/icons/logos-projetos_atitude farmacêutica.png" alt="Atitude Farmacêutica">
                </a>



                <!-- Fiscalização Humanizada -->
                <a href="<?= base_url() ?>fiscalizacao-humanizada" class="logo-link">
                    <img src="assets/img/icons/logos-projetos_fiscalização humanizada.png" alt="Fiscalização Humanizada">
                </a>

                <!-- Mérito Acadêmico -->
                <a href="<?= base_url() ?>merito-academico" class="logo-link logo-merito">
                    <img src="assets/img/icons/merito_acadêmico.png" alt="Mérito Acadêmico">
                </a>

                <!-- Minas de Superação -->
                <a href="https://crfmg.org.br/minasdesuperacao/"
                    target="_blank" rel="noopener"
                    class="logo-link">
                    <img src="assets/img/icons/minas_de_superacao_branco-01.png" alt="Minas de Superação">
                </a>

                <!-- Pesquisa Científica -->
                <a href="<?= base_url() ?>pesquisa-cientifica" class="logo-link logo-pesquisa">
                    <img src="assets/img/icons/pesquisa_científica.png" alt="Pesquisa Científica">
                </a>

                <!-- Plenária Técnica -->
                <a href="https://www.youtube.com/watch?v=cRiKBJDybwE"
                    target="_blank" rel="noopener"
                    class="logo-link">
                    <img src="assets/img/icons/logos-projetos_plenária técnica.png" alt="Plenária Técnica">
                </a>

                <!-- Podcast CRFMG -->
                <a href="https://open.spotify.com/show/7fTVbzaZURCPAp7eY5P6Tf"
                    target="_blank" rel="noopener"
                    class="logo-link logo-podcast">
                    <img src="assets/img/icons/podcast_1.png" alt="Podcast CRFMG">
                </a>

                <!-- Receita Legível (em breve) 
                <a href="#" class="logo-link disabled" tabindex="-1">
                    <img src="assets/img/icons/logos-projetos_receita legível.png" alt="Receita Legível">
                </a>-->
				
				<!-- Seminário de Vigilância em Saúde (em breve) -->
                <a href="<?= base_url() ?>seminario" class="logo-link">
                    <img src="assets/img/icons/logos-projetos_seminario.png" alt="Seminário em Vigilância em Saúde">
                </a>

                <!-- Traga de Volta (em breve) -->
                <a href="#" class="logo-link disabled" tabindex="-1">
                    <img src="assets/img/icons/traga_de_volta.png" alt="Traga de Volta">
                </a>

                <!-- Uso Racional de Medicamentos -->
                <a href="<?= base_url() ?>urm" class="logo-link">
                    <img src="assets/img/icons/logos-projetos_uso racional de medicamentos.png"
                        alt="Uso Racional de Medicamentos">
                </a>
            </div>
        </div>
    </div>


    <!-- CATEGORIAS -->
    <section class="area-selector">

        <div class="filtro-cursos-container">
            <button class="btn-filtro" id="btnFiltro">
                <i class="bi bi-search"></i>
            </button>

            <div class="filtro-decoracao"></div>

            <div class="filtro-cursos" id="painelFiltro">

                <!-- MODALIDADE -->
                <div class="modalidade-group">
                    <button class="modalidade-btn online" data-value="online">
                        On-line
                    </button>

                    <button class="modalidade-btn presencial" data-value="presencial">
                        Presencial
                    </button>

					<button class="modalidade-btn universitario" data-value="universitario">
						Universitário
					</button>
                </div>

                <!-- BUSCA -->
                <input
                    type="text"
                    id="filtro-titulo"
                    placeholder="Buscar por título">


                <!-- PALESTRANTES -->
                <select id="filtro-autor">
                    <option value="">Todos os palestrantes</option>
                    <?php
                    foreach ($palestrantes as $l) {
                        echo "<option value=" . $l->id_palestrante . ">$l->nome.</option>";
                    }
                    ?>

                </select>
            </div>
        </div>

        <div class="area-container">

            <div class="area-header">
                <h2 class="area-title">
                    Qual é o seu <br>foco profissional?
                </h2>

                <div class="area-text">
                    <p>Descubra capacitações específicas para cada área da farmácia, com conteúdos que realmente fazem a diferença na sua prática diária.</p>

                    <p class="area-sub">Veja abaixo as áreas disponíveis e escolha a sua!</p>
                </div>
            </div>

            <div class="area-box">
                <div class="area-layout">

                    <!-- DESKTOP -->
                    <div class="area-tabs">
                        <button class="area-tab"
                            data-target="empresa"
                            data-text="Capacitações e eventos direcionados às empresas">
                            PARA A EMPRESA
                        </button>

                        <button class="area-tab active"
                            data-target="farmaceutico"
                            data-text="Conteúdos que transformam conhecimento em vantagem competitiva">
                            PARA O FARMACÊUTICO
                        </button>

                        <button class="area-tab"
                            data-target="sociedade"
                            data-text="Capacitações e eventos voltados para toda a sociedade">
                            PARA A SOCIEDADE
                        </button>
                    </div>

                    <!-- ÍCONES -->
                    <div class="area-icons">
                        <button class="area-icon" data-color="#3155b8,#3B5FC0" data-position="up">
                            <i class="fa-solid fa-layer-group"></i> <span class="label">Todos</span>
                        </button>

                        <button class="area-icon" data-filter="Alimentos" data-color="#f97316,#fb923c" data-position="up">
                            <i class="fa-solid fa-carrot"></i>
                            <span class="label">Alimentos</span>
                        </button>

                        <button class="area-icon" data-filter="Análises Clínicas" data-color="#9333ea,#a855f7" data-position="up">
                            <i class="fa-solid fa-flask"></i>
                            <span class="label">Análises Clínicas</span>
                        </button>

                        <button class="area-icon" data-filter="Clínica" data-color="#ef4444,#f87171" data-position="up">
                            <i class="fa-solid fa-heart-pulse"></i>
                            <span class="label">Clínica</span>
                        </button>

                        <button class="area-icon" data-filter="Educação" data-color="#10b981,#34d399" data-position="up">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span class="label">Educação</span>
                        </button>

                        <button class="area-icon" data-filter="Farmácia" data-color="#0ea5e9,#3b82f6" data-position="up">
                            <i class="fa-solid fa-capsules"></i>
                            <span class="label">Farmácia</span>
                        </button>

                        <button class="area-icon" data-filter="Gestão" data-color="#facc15,#eab308" data-position="up">
                            <i class="fa-solid fa-chart-line"></i>
                            <span class="label">Gestão</span>
                        </button>

                        <button class="area-icon" data-filter="Hospitalar" data-color="#8b5cf6,#a78bfa" data-position="down">
                            <i class="fa-solid fa-hospital"></i>
                            <span class="label">Hospitalar</span>
                        </button>

                        <button class="area-icon" data-filter="Industrial" data-color="#f43f5e,#fb7185" data-position="down">
                            <i class="fa-solid fa-industry"></i>
                            <span class="label">Industrial</span>
                        </button>

                        <button class="area-icon" data-filter="Magistral" data-color="#8b5cf6,#a78bfa" data-position="down">
                            <i class="fa-solid fa-mortar-pestle"></i>
                            <span class="label">Magistral</span>
                        </button>

                        <button class="area-icon" data-filter="PICs" data-color="#22c55e,#4ade80" data-position="down">
                            <i class="fa-solid fa-leaf"></i>
                            <span class="label">PICs</span>
                        </button>

                        <button class="area-icon" data-filter="Saúde Pública" data-color="#14b8a6,#2dd4bf" data-position="down">
                            <i class="fa-solid fa-users"></i>
                            <span class="label">Saúde Pública</span>
                        </button>

                        <button class="area-icon" data-filter="Toxicologia" data-color="#f97316,#fcd34d" data-position="down">
                            <i class="fa-solid fa-radiation"></i>
                            <span class="label">Toxicologia</span>
                        </button>

                        <button class="area-icon" data-filter="Outros" data-color="#475569,#64748b" data-position="down">
                            <i class="fa-solid fa-bars"></i>
                            <span class="label">Outros</span>
                        </button>


                    </div>
                </div>
            </div>

            <!--<div class="card-filtro mobile-only">
                <div class="modalidade-group">
                    <button class="modalidade-btn online" data-value="online">On-line</button>
                    <button class="modalidade-btn presencial" data-value="presencial">Presencial</button>
                </div>

                <input type="text" id="filtro-titulo" placeholder="Buscar por título" class="filtro-titulo">
                <select id="filtro-autor" class="filtro-autor">
                    <option value="">Todos os palestrantes</option>
                </select>
            </div>-->

            <div class="area-tabs-mobile">
                <button class="area-arrow prev">‹</button>

                <div class="area-tab-display" id="area-tab-title">
                    PARA O FARMACÊUTICO
                </div>

                <button class="area-arrow next">›</button>
            </div>

            <div class="area-tabs-texto">
                <p id="area-tabs-text">
                    Conteúdos que transformam conhecimento em vantagem competitiva
                </p>
            </div>

        </div>

        <style>
            .card-curso.filtrado {
                display: none !important;
            }
        </style>
    </section>


    <!-- CURSOS -->
    <section id="filtro" class="section-cursos">
        <div class="container-portal">
            <div class="tabs-content">
                <div class="tab-pane active" id="farmaceutico">
                    <div class="cards-wrapper">
                        <div class="cards-track">

                            <?php

                            $mapa = [];

                            /* mapa de alunos */
                            foreach ($total_alunos as $valor) {
                                $mapa[$valor->courseid] = (int)$valor->total_estudantes;
                            }

                            /* BUSCAR TODAS AS CATEGORIAS RELACIONADAS AOS CURSOS */
							$categorias_cursos = $this->db
								->select('ce.courseid, ce.principal, c.descricao, c.icon')
								->from('tbl_categoria_eventos ce')
								->join('tbl_categorias_portalfarma c', 'c.id = ce.id_categoria')
								->order_by('ce.courseid', 'ASC')
								->order_by('ce.principal', 'DESC')
								->order_by('ce.id', 'ASC')
								->get()
                                ->result();

                            $mapa_categorias = [];

                            foreach ($categorias_cursos as $cat) {

								$mapa_categorias[$cat->courseid][] = [
									'descricao' => $cat->descricao,
									'icon' => $cat->icon,
									'principal' => (int) $cat->principal
								];
                            }

							/* PÚBLICOS VINCULADOS A CADA CURSO */
							$publicos_cursos = $this->db
								->select('courseid, idpara')
								->from('tbl_portalfarma_para')
								->get()
								->result();

							$mapa_publicos = [];
							foreach ($publicos_cursos as $publico) {
								$mapa_publicos[(string) $publico->courseid][] = (int) $publico->idpara;
							}


                            /* MAPA DE CORES (MESMO DO FILTRO) */
                            $mapa_cores = [
                                'Alimentos' => '#f97316,#fb923c',
                                'Análises Clínicas' => '#9333ea,#a855f7',
                                'Clínica' => '#ef4444,#f87171',
                                'Educação' => '#10b981,#34d399',
                                'Farmácia' => '#0ea5e9,#3b82f6',
                                'Gestão' => '#facc15,#eab308',
                                'Hospitalar' => '#8b5cf6,#a78bfa',
                                'Industrial' => '#f43f5e,#fb7185',
                                'Magistral' => '#8b5cf6,#a78bfa',
                                'PICs' => '#22c55e,#4ade80',
                                'Saúde Pública' => '#14b8a6,#2dd4bf',
                                'Toxicologia' => '#f97316,#fcd34d',
                                'Outros' => '#475569,#64748b'
                            ];
							
							// Indexar por courseid para busca rápida O(1) dentro do loop
							$contagemPorCurso = [];
							foreach ($resultadosInscritos as $linha) {
								$contagemPorCurso[$linha->courseid] = $linha->total_inscritos;
							}
							
                            foreach ($tabelaCurso as $campo) {

								
                                //if ($campo->courseid == 0 || $campo->courseid == 1 || $campo->tipo_evento == 7) continue;
								
								// Pega o total do array indexado ou define 0 se não houver ninguém
								$evento_inscritos = $contagemPorCurso[$campo->courseid] ?? 0;
								
                                /* tipo evento */
                                switch ($campo->tipo_evento) {
                                    case 1:
                                        $campo_evento = "Presencial";
										$classe_card = 'presencial';
                                        break;
                                    case 2:
                                        $campo_evento = "On-line";
										$classe_card = 'online';
										break;
									case 3:
                                        //$campo_evento = "URM";
                                        $campo_evento = "Presencial";
										$classe_card = 'urm';
										break;
									case 4:
                                        //$campo_evento = "F. Humanizada";
                                        $campo_evento = "Presencial";
										$classe_card = 'fiscalizacaohumanizada';
										break;
									case 5:
                                        $campo_evento = "Universitário";
                                        //$campo_evento = "Hibrido";
										$classe_card = 'universitario';
										break;
									case 7:
                                        //$campo_evento = "Seminário";
                                        $campo_evento = "Hibrido";
										$classe_card = 'seminario';
										break;
                                    default:
                                        $campo_evento = "Evento";
                                }

                                /* horas */
                                $campo_horas = $campo->carga_horaria / 60;

                                /* inscritos */
                                $total_inscritos = $mapa[$campo->courseid] ?? 0;

                                /* modalidade */
                                //$classe_card = ($campo->tipo_evento == 2) ? 'online' : 'presencial';
								

                                /* categorias */
                                $categorias = $mapa_categorias[$campo->courseid] ?? [];

								/* categoria principal */
								$categoria_principal = null;
								foreach ($categorias as $categoria) {
									if (($categoria['principal'] ?? 0) === 1) {
										$categoria_principal = $categoria;
										break;
									}
								}

								/* Compatibilidade com cursos antigos ainda sem categoria principal. */
								$categoria_principal = $categoria_principal ?? ($categorias[0] ?? []);
								$primeira_categoria = $categoria_principal['descricao'] ?? '';
								$primeiro_icone = $categoria_principal['icon'] ?? '';
                                $todas_categorias = array_values(array_unique(array_column($categorias, 'descricao')));
								$publicos = array_values(array_unique($mapa_publicos[(string) $campo->courseid] ?? []));

                                /* cor principal */
                                $cor_principal = $mapa_cores[$primeira_categoria] ?? '#64748b,#94a3b8';

                            ?>

                                <div class="card-curso <?= $classe_card ?>"
                                    data-area="<?= html_escape(implode('|', $todas_categorias)) ?>"
                                    data-modalidade="<?= $classe_card ?>"
									data-publicos="<?= html_escape(implode('|', $publicos)) ?>"
									data-tipo-evento="<?= (int) $campo->tipo_evento ?>">

                                    <!-- IMAGEM -->
                                    <div class="card-curso-topo">
                                        <img
                                            src="<?= base_url() ?>uploads/cursos/<?= $campo->nome_curto ?>.png"
                                            onerror="this.onerror=null;this.src='<?= base_url() ?>assets/img/icons/icons_capacifar/banner_cursos.png';"
                                            alt="<?= $campo->titulo ?>">
                                    </div>

                                    <!-- INFO -->
                                    <div class="card-curso-info">
                                        <span class="tipo-evento <?= $classe_card ?>">
                                            <?= $campo_evento ?>
                                        </span>

                                        <span>
                                            <i class="bi bi-clock"></i>
                                            <?= $campo_horas ?>hrs
                                        </span>

                                        <span>
                                            <i class="bi bi-people-fill"></i>
                                            <?//= $total_inscritos ?>
                                            <?php
											if($campo->tipo_evento == 1 || $campo->tipo_evento == 2 || $campo->tipo_evento == 5){
												echo $total_inscritos;
											} else if($campo->tipo_evento == 4 || $campo->tipo_evento == 7) {
												echo $evento_inscritos;
											} else if($campo->tipo_evento == 3) {
												echo $totalURM;												
											}
											?>
                                        </span>

                                        <span class="publico-evento">
                                            PARA O FARMACÊUTICO
                                        </span>
                                    </div>

                                    <!-- BODY -->
                                    <div class="card-curso-body">

                                        <small class="nome-evento">
                                            <?= $primeira_categoria ?>
                                        </small>

                                        <div class="titulo-wrapper">
                                            <h3 class="nome-curso">
                                                <?= $campo->titulo ?>
                                            </h3>
                                        </div>
										
										<?php
										if ($campo->tipo_evento == 1 || $campo->tipo_evento == 2){
										?>
											<a href="<?= base_url() ?>Curso/Listar/<?= $campo->courseid ?>"
                                            class="btn-saiba-mais">
												Saiba mais
											</a>
										<?php } elseif ($campo->tipo_evento == 3){ ?>
												<a href="<?= base_url() ?>urm"
												class="btn-saiba-mais">
													Saiba mais
												</a>
										<?php } elseif ($campo->tipo_evento == 4){ ?>
												<a href="<?= base_url() ?>fiscalizacao-humanizada"
												class="btn-saiba-mais">
													Saiba mais
												</a>
										<?php } elseif ($campo->tipo_evento == 5){ ?>
												<a href="<?= base_url() ?>Curso/Listar/<?= $campo->courseid ?>"
												class="btn-saiba-mais">
													Saiba mais
												</a>
										<?php } elseif ($campo->tipo_evento == 7){ ?>
												<a href="<?= base_url() ?>seminario"
												class="btn-saiba-mais">
													Saiba mais
												</a>
										<?php }	?>
                                        

                                    </div>

                                    <!-- ICONES DO CARD -->
                                    <div class="card-icon-stack">

                                        <?php foreach ($categorias as $index => $cat):

                                            $cores = $mapa_cores[$cat['descricao']] ?? '#64748b,#94a3b8';
                                        ?>

                                            <span class="card-icon-item <?= $index === 0 ? 'principal' : 'secundario' ?>"
                                                style="background: linear-gradient(135deg, <?= $cores ?>);">

                                                <i class="<?= $cat['icon'] ?>"></i>

                                            </span>

                                        <?php endforeach; ?>

                                    </div>

                                    <!-- HOVER -->
                                    <div class="card-curso-hover">

                                        <!-- ICONES -->
                                        <div class="hover-icons">

                                            <?php foreach ($categorias as $cat):

                                                $cores = $mapa_cores[$cat['descricao']] ?? '#64748b,#94a3b8';
                                            ?>

                                                <span class="hover-icon"
                                                    style="background: linear-gradient(135deg, <?= $cores ?>);">

                                                    <i class="<?= $cat['icon'] ?>"></i>

                                                </span>

                                            <?php endforeach; ?>

                                        </div>


                                        <!-- CATEGORIAS -->
                                        <div class="hover-header">

                                            <span class="hover-categoria">

                                                <?php foreach ($categorias as $index => $cat): ?>

                                                    <span class="cat-item">
                                                        <?= trim($cat['descricao']); ?>
                                                    </span><?= $index < count($categorias) - 1 ? '<br>' : ''; ?>

                                                <?php endforeach; ?>

                                            </span>

                                            <span class="hover-tipo">
                                                <?= $campo_evento ?>
                                            </span>

                                            <span class="hover-horas">
                                                <i class="bi bi-clock"></i>
                                                <?= $campo_horas ?>hrs
                                            </span>

                                        </div>


                                        <h4>
                                            <?= $campo->titulo ?>
                                        </h4>


                                        <!-- TOPICOS -->
                                        <div class="conteudo-topicos">
                                            <?= nl2br($campo->topicos) ?>
                                        </div>
										
										<?php
										if ($campo->tipo_evento == 1 || $campo->tipo_evento == 2){
										?>
											<a href="<?= base_url() ?>curso/listar/<?= $campo->courseid ?>"	class="btn-hover">
												Ver agora
											</a>
										<?php } elseif ($campo->tipo_evento == 3){ ?>
												<a href="<?= base_url() ?>urm" class="btn-hover">
													Ver agora
												</a>
										<?php } elseif ($campo->tipo_evento == 4){ ?>
												<a href="<?= base_url() ?>fiscalizacao-humanizada" class="btn-hover">
													Ver agora
												</a>
										<?php } elseif ($campo->tipo_evento == 5){ ?>
												<a href="<?= base_url() ?>curso/listar/<?= $campo->courseid ?>"	class="btn-hover">
													Ver agora
												</a>
										<?php } elseif ($campo->tipo_evento == 7){ ?>
												<a href="<?= base_url() ?>seminario" class="btn-hover">
													Ver agora
												</a>
										<?php }	?>
                                        

                                    </div>
                                </div>

                            <?php } ?>

                        </div>

                        <div class="paginacao-cursos"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- DESTAQUES -->
    <section class="section-destaques">
        <div class="container-portal">
            <div class="destaques-wrapper">
                <a href="https://bjhp.crfmg.org.br/crfmg"
                    class="destaque-link"
                    target="_blank"
                    rel="noopener noreferrer">
                    <img src="assets/img/icons/div_doc_bjhp/bjhp.png"
                        alt="Brazilian Journal of Health and Pharmacy">
                </a>

                <a href="https://crf-mg.implanta.net.br/portaltransparencia/#publico/Listas?id=3999544a-8571-4ad4-8e5a-880fa6ddce9e"
                    class="destaque-link"
                    target="_blank"
                    rel="noopener noreferrer">
                    <img src="assets/img/icons/div_doc_bjhp/documentos.png"
                        alt="Documentos Técnicos">
                </a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputTitulo = document.getElementById('filtro-titulo');
            const cards = document.querySelectorAll('.card-curso');

            let filtroTituloAtual = '';

            if (inputTitulo) {
                inputTitulo.addEventListener('input', () => {
                    filtroTituloAtual = inputTitulo.value.toLowerCase().trim();

                    cards.forEach(card => {
                        const tituloEl = card.querySelector('.titulo-wrapper .nome-curso');
                        const titulo = tituloEl ? tituloEl.textContent.toLowerCase().trim() : '';

                        if (titulo.includes(filtroTituloAtual)) {
                            card.classList.remove('filtrado-titulo');
                        } else {
                            card.classList.add('filtrado-titulo');
                        }
                    });

                    // Sempre volta para página 1 após digitar
                    if (window.setPaginaAtualCursos) {
                        window.setPaginaAtualCursos(1);
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
		
			/*const btnUniversitario = document.getElementById('btnuniversitario');

			if (btnUniversitario) {
				btnUniversitario.style.display = 'block';
				btnUniversitario.classList.remove('hidden', 'd-none');
			}*/

            //const caminhoBtns = document.querySelectorAll('.btn-caminho');
			const caminhoBtns = document.querySelectorAll('.btn-caminho:not(#btnuniversitario)');

            const ajusteScroll = 870;

            caminhoBtns.forEach(btn => {

                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const modalidade = this.dataset.modalidade;

                    const btnFiltro = document.getElementById('btnFiltro');
                    const painelFiltro = document.getElementById('painelFiltro');

                    if (!btnFiltro || !painelFiltro) return;


                    if (!painelFiltro.classList.contains('ativo')) {
                        btnFiltro.click();
                    }

                    const btnModalidadeReal = document.querySelector(
                        `.modalidade-btn[data-value="${modalidade}"]`
                    );

                    if (btnModalidadeReal) {
                        btnModalidadeReal.click();
                    }

                    const sectionCursos = document.querySelector('.section-cursos');

                    if (sectionCursos) {

                        setTimeout(() => {

                            const y =
                                sectionCursos.getBoundingClientRect().top +
                                window.pageYOffset -
                                ajusteScroll;

                            window.scrollTo({
                                top: y,
                                behavior: 'smooth'
                            });

                        }, 150);
                    }

                });

            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /* ======================================================
               1. ABAS DE ÁREA
            ====================================================== */
            const areaTabs = document.querySelectorAll('.area-tab');
            const tabPanes = document.querySelectorAll('.tab-pane');
            const areaText = document.getElementById('area-tabs-text');

            function activateTab(tab) {
                areaTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const target = tab.dataset.target;
                tabPanes.forEach(pane => {
                    pane.classList.add('active');
                });

				document.querySelectorAll('.card-curso').forEach(card => {
					const publicos = (card.dataset.publicos || '')
						.split('|')
						.filter(Boolean)
						.map(Number);
					const tipoEvento = Number(card.dataset.tipoEvento || 0);
					let exibir = true;

					if (target === 'empresa') {
						exibir = publicos.includes(2);
					} else if (target === 'sociedade') {
						exibir = tipoEvento === 3 || publicos.includes(3);
					}

					card.classList.toggle('filtrado-publico', !exibir);
					card.classList.remove('is-open');

					const rotuloPublico = card.querySelector('.publico-evento');
					if (rotuloPublico) {
						rotuloPublico.textContent = target === 'empresa'
							? 'PARA A EMPRESA'
							: target === 'sociedade'
								? 'PARA A SOCIEDADE'
								: 'PARA O FARMACÊUTICO';
					}
				});

				if (window.setPaginaAtualCursos) {
					window.setPaginaAtualCursos(1);
				}

                if (areaText && tab.dataset.text) {
                    areaText.style.animation = 'none';
                    areaText.offsetHeight;
                    areaText.style.animation = null;
                    areaText.innerHTML = tab.dataset.text;
                }
            }

            areaTabs.forEach(tab => {
                tab.addEventListener('click', () => activateTab(tab));
            });


            /* ======================================================
               2. ÍCONES + FILTRO (SEM QUEBRAR PAGINAÇÃO)
            ====================================================== */
            const areaIcons = document.querySelectorAll('.area-icon');
            const cards = document.querySelectorAll('.card-curso');
            let filtroAtivo = null;
            const btnTodos = [...areaIcons].find(
                icon => !icon.dataset.filter
            );

            if (btnTodos) {
                btnTodos.classList.add('active');
                filtroAtivo = 'TODOS';

                const color = btnTodos.dataset.color;
                if (color) {
                    const bg = color.includes(',') ?
                        `linear-gradient(135deg, ${color})` :
                        color;

                    btnTodos.style.background = bg;
                }

                const iconEl = btnTodos.querySelector('i');
                if (iconEl) iconEl.style.color = '#ffffff';

                cards.forEach(card => {
                    card.classList.remove('filtrado', 'is-open');
                });
            }

            const mapaCores = {};

            /* cria mapa filtro -> cor */
            areaIcons.forEach(icon => {
                const filtro = icon.dataset.filter;
                const color = icon.dataset.color;

                if (filtro && color) {
                    mapaCores[filtro] = color;
                }
            });

            /* aplica cor inicial nos cards */
            cards.forEach(card => {
                const area = (card.dataset.area || '').split('|')[0].trim();
                const color = mapaCores[area];

                if (color) {
                    const c = color.includes(',') ? color.split(',')[0] : color;
                    card.style.setProperty('--area-color', c);
                }
            });

            areaIcons.forEach(icon => {
                icon.addEventListener('click', () => {

                    const filtro = icon.dataset.filter || 'TODOS';

                    /* RESET VISUAL */
                    areaIcons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.style.background = '#ffffff';

                        const i = btn.querySelector('i');
                        if (i) i.style.color = '#2563eb';
                    });

                    icon.classList.add('active');
                    filtroAtivo = filtro;

                    /* COR DO ÍCONE */
                    const color = icon.dataset.color;
                    if (color) {
                        if (color.includes(',')) {
                            const [c1, c2] = color.split(',');
                            icon.style.background = `linear-gradient(135deg, ${c1}, ${c2})`;
                        } else {
                            icon.style.background = color;
                        }
                    }

                    const iconEl = icon.querySelector('i');
                    if (iconEl) iconEl.style.color = '#ffffff';

                    /* ===== FILTRO ===== */

                    // TODOS 
                    if (filtro === 'TODOS') {
                        cards.forEach(card => {
                            card.classList.remove('filtrado', 'is-open');
                        });

                        if (window.setPaginaAtualCursos) {
                            window.setPaginaAtualCursos(1);
                        }
                        return;
                    }

                    // FILTRO NORMAL
                    cards.forEach(card => {
                        const categorias = (card.dataset.area || '')
                            .split('|')
                            .map(categoria => categoria.trim());
                        const ativo = categorias.includes(filtro);

                        card.classList.toggle('filtrado', !ativo);
                        card.classList.remove('is-open');

                        if (ativo && color) {
                            const bg = color.includes(',') ?
                                `linear-gradient(135deg, ${color})` :
                                color;

                            const cardIcon = card.querySelector('.card-icon');
                            if (cardIcon) cardIcon.style.background = bg;

                            const hoverIcon = card.querySelector('.hover-icon');
                            if (hoverIcon) hoverIcon.style.background = bg;
                        }
                    });

                    if (window.setPaginaAtualCursos) {
                        window.setPaginaAtualCursos(1);
                    }

                    /* ======================================================
                    FILTRO POR TÍTULO
                    ====================================================== */
                    const inputTitulo = document.getElementById('filtro-titulo');

                    if (inputTitulo) {

                        inputTitulo.addEventListener('input', function() {
                            const termo = this.value.toLowerCase().trim();

                            cards.forEach(card => {
                                const tituloEl = card.querySelector('.nome-curso');
                                const titulo = tituloEl ? tituloEl.textContent.toLowerCase() : '';

                                if (titulo.includes(termo)) {
                                    card.classList.remove('filtrado-titulo');
                                } else {
                                    card.classList.add('filtrado-titulo');
                                }
                            });

                            // sempre volta pra página 1
                            if (window.setPaginaAtualCursos) {
                                window.setPaginaAtualCursos(1);
                            }
                        });
                    }
                });
            });


            /* ======================================================
               3. MOBILE – ABRIR / FECHAR CARD
            ====================================================== */
            if (window.innerWidth <= 768) {
                cards.forEach(card => {
                    card.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const isOpen = card.classList.contains('is-open');
                        cards.forEach(c => c.classList.remove('is-open'));
                        if (!isOpen) card.classList.add('is-open');
                    });
                });

                document.addEventListener('click', () => {
                    cards.forEach(c => c.classList.remove('is-open'));
                });
            }


            /* ======================================================
               4. MOBILE – SETAS DE ABAS
            ====================================================== */
            if (window.innerWidth <= 768) {

                const prevBtn = document.querySelector('.area-arrow.prev');
                const nextBtn = document.querySelector('.area-arrow.next');
                const titleEl = document.getElementById('area-tab-title');

                if (prevBtn && nextBtn && areaTabs.length && titleEl) {

                    let currentIndex = [...areaTabs].findIndex(tab =>
                        tab.classList.contains('active')
                    );
                    if (currentIndex === -1) currentIndex = 0;

                    function formatMobileTitle(text) {
                        return text.replace('PARA O ', 'PARA O<br>');
                    }

                    function updateByIndex(index) {
                        const tab = areaTabs[index];
                        titleEl.innerHTML = formatMobileTitle(tab.textContent.trim());
                        activateTab(tab);
                    }

                    updateByIndex(currentIndex);

                    prevBtn.addEventListener('click', () => {
                        currentIndex = (currentIndex - 1 + areaTabs.length) % areaTabs.length;
                        updateByIndex(currentIndex);
                    });

                    nextBtn.addEventListener('click', () => {
                        currentIndex = (currentIndex + 1) % areaTabs.length;
                        updateByIndex(currentIndex);
                    });
                }
            }


            /* ======================================================
            5. PAGINAÇÃO – DESKTOP (CORRETA E DINÂMICA)
            ====================================================== */

            const paginacao = document.querySelector('.paginacao-cursos');

            const cardsPorPagina = 8;
            let paginaAtual = 1;

            function getCardsAtivos() {
                return [...document.querySelectorAll('.card-curso')]
                    .filter(card =>
                        !card.classList.contains('filtrado') &&
                        !card.classList.contains('filtrado-titulo') &&
						!card.classList.contains('filtrado-publico')
                    )
            }

            function criarBotoes(totalPaginas) {

                paginacao.innerHTML = '';

                if (totalPaginas <= 1) {
                    paginacao.style.display = 'none';
                    return;
                }

                paginacao.style.display = 'flex';

                // botão anterior
                const prev = document.createElement('button');
                prev.className = 'page-btn prev';
                prev.innerHTML = '<i class="bi bi-arrow-left"></i> Anterior';
                prev.onclick = () => {
                    if (paginaAtual > 1) {
                        paginaAtual--;
                        renderizarPagina();
                    }
                };

                paginacao.appendChild(prev);

                // botões numéricos
                for (let i = 1; i <= totalPaginas; i++) {

                    const btn = document.createElement('button');

                    btn.className = 'page-btn';
                    btn.textContent = i;

                    if (i === paginaAtual) {
                        btn.classList.add('active');
                    }

                    btn.onclick = () => {
                        paginaAtual = i;
                        renderizarPagina();
                    };

                    paginacao.appendChild(btn);
                }

                // botão próximo
                const next = document.createElement('button');
                next.className = 'page-btn next';
                next.innerHTML = 'Próximo <i class="bi bi-arrow-right"></i>';
                next.onclick = () => {
                    if (paginaAtual < totalPaginas) {
                        paginaAtual++;
                        renderizarPagina();
                    }
                };

                paginacao.appendChild(next);
            }

            function renderizarPagina() {

                // MOBILE NÃO USA PAGINAÇÃO
                if (window.innerWidth <= 768) {

                    document.querySelectorAll('.card-curso').forEach(card => {

                        if (!card.classList.contains('filtrado') &&
                            !card.classList.contains('filtrado-titulo') &&
							!card.classList.contains('filtrado-publico')) {

                            card.style.display = 'flex';

                        } else {
                            card.style.display = 'none';
                        }

                    });

                    return;
                }

                // ===== DESKTOP NORMAL =====

                const cards = getCardsAtivos();
                const totalPaginas = Math.ceil(cards.length / cardsPorPagina);

                if (paginaAtual > totalPaginas) {
                    paginaAtual = totalPaginas || 1;
                }

                const inicio = (paginaAtual - 1) * cardsPorPagina;
                const fim = inicio + cardsPorPagina;

                document.querySelectorAll('.card-curso').forEach(card => {
                    card.style.display = 'none';
                });

                cards.forEach((card, index) => {
                    if (index >= inicio && index < fim) {
                        card.style.display = 'flex';
                    }
                });

                criarBotoes(totalPaginas);
            }

            window.setPaginaAtualCursos = (pagina) => {
                paginaAtual = pagina;
                renderizarPagina();
            };

            // iniciar
            renderizarPagina();

            /* ======================================================
            SCROLL SUAVE PARA SECTION-CURSOS (COM OFFSET)
            ===================================================== */
            const scrollBtns = document.querySelectorAll('.js-scroll-cursos');
            const sectionCursos = document.querySelector('.section-cursos');

            scrollBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();

                    if (!sectionCursos) return;

                    const offset = -240;
                    const y =
                        sectionCursos.getBoundingClientRect().top +
                        window.pageYOffset +
                        offset;

                    window.scrollTo({
                        top: y,
                        behavior: 'smooth'
                    });
                });
            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const btnFiltro = document.getElementById('btnFiltro');
            const painelFiltro = document.getElementById('painelFiltro');
            const iconeBtn = btnFiltro.querySelector('i');

            const areaIcons = document.querySelectorAll('.area-icon');
            const modalidadeBtns = document.querySelectorAll('.modalidade-btn');
            const inputTitulo = document.getElementById('filtro-titulo');
            const cards = document.querySelectorAll('.card-curso');

            let filtroAreaAtual = 'TODOS';
            let filtroModalidadeAtual = null;
            let filtroTituloAtual = '';

            let filtroAberto = false;

            /* ===============================
               FUNÇÃO FILTRAR
            ================================ */
            function aplicarFiltros() {

                cards.forEach(card => {

                    const areasCard = (card.dataset.area || '')
                        .split('|')
                        .map(area => area.trim());
                    const modalidadeCard = card.dataset.modalidade?.trim();
                    const tituloCard =
                        card.querySelector('.nome-curso')?.textContent.toLowerCase() || '';

                    const passaArea =
                        filtroAreaAtual === 'TODOS' ||
                        areasCard.includes(filtroAreaAtual);

                    const passaModalidade = !filtroModalidadeAtual ||
                        modalidadeCard === filtroModalidadeAtual;

                    const passaTitulo =
                        tituloCard.includes(filtroTituloAtual);

                    if (passaArea && passaModalidade && passaTitulo) {
                        card.classList.remove('filtrado');
                    } else {
                        card.classList.add('filtrado');
                    }

                });

                if (window.setPaginaAtualCursos) {
                    window.setPaginaAtualCursos(1);
                }
            }

            /* ===============================
               MODALIDADE
            ================================ */
            modalidadeBtns.forEach(btn => {

                btn.addEventListener('click', function() {

                    const jaEstaAtivo = this.classList.contains('active');

                    // remove active de todos
                    modalidadeBtns.forEach(b => b.classList.remove('active'));

                    if (jaEstaAtivo) {
                        // 🔁 DESATIVAR FILTRO
                        filtroModalidadeAtual = null;

                        // reativa áreas
                        areaIcons.forEach(icon => {
                            icon.style.pointerEvents = 'auto';
                            icon.style.opacity = '1';
                        });

                    } else {
                        // ✅ ATIVAR FILTRO
                        this.classList.add('active');
                        filtroModalidadeAtual = this.dataset.value;

                        // desativa áreas
                        areaIcons.forEach(icon => {
                            icon.classList.remove('active');
                            icon.style.pointerEvents = 'none';
                            icon.style.opacity = '0.4';
                        });

                        filtroAreaAtual = 'TODOS';
                    }

                    aplicarFiltros();
                });

            });


            /* ===============================
               ÁREAS 
            ================================ */
            areaIcons.forEach(icon => {

                icon.addEventListener('click', () => {

                    if (filtroModalidadeAtual) return; // bloqueado

                    areaIcons.forEach(i => i.classList.remove('active'));
                    icon.classList.add('active');

                    filtroAreaAtual = icon.dataset.filter || 'TODOS';

                    aplicarFiltros();
                });

            });

            /* ===============================
               TÍTULO
            ================================ */
            if (inputTitulo) {
                inputTitulo.addEventListener('input', function() {
                    filtroTituloAtual = this.value.toLowerCase().trim();
                });
            }

            /* ===============================
               BOTÃO SEARCH
            ================================ */
            btnFiltro.addEventListener('click', () => {

                filtroAberto = !filtroAberto;

                painelFiltro.classList.toggle('ativo');

                if (filtroAberto) {

                    /* APLICAR FILTRO */
                    aplicarFiltros();

                    iconeBtn.classList.remove('bi-search');
                    iconeBtn.classList.add('bi-x-lg');

                    /* RESET ÁREAS PARA TODOS */
                    areaIcons.forEach(icon => {
                        icon.classList.remove('active');
                    });

                    filtroAreaAtual = 'TODOS';

                } else {

                    filtroModalidadeAtual = null;
                    filtroTituloAtual = '';

                    modalidadeBtns.forEach(b => b.classList.remove('active'));

                    inputTitulo.value = '';

                    /* REATIVA ÁREAS */
                    areaIcons.forEach(icon => {
                        icon.style.pointerEvents = 'auto';
                        icon.style.opacity = '1';
                    });

                    iconeBtn.classList.remove('bi-x-lg');
                    iconeBtn.classList.add('bi-search');

                    /* MOSTRA TODOS */
                    cards.forEach(card => card.classList.remove('filtrado'));

                    if (window.setPaginaAtualCursos) {
                        window.setPaginaAtualCursos(1);
                    }
                }

            });

        });
    </script>


    <?php //include __DIR__ . '/layout/footer.php'; 
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
