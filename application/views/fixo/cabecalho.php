<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="<?= base_url() ?>assets/img/logo/logo.png">

<!-- HEADER DESKTOP -->
<header class="header-desktop desktop-only">
    <div class="container-header">

<!-- LOGO -->
        <a href="<?= base_url() ?>" class="logo">
            <img src="<?= base_url('assets/img/icons/PORTAL FARMA.png') ?>" alt="Portal Farma">
        </a>

        <!-- MENU SIMPLIFICADO -->
        <nav class="menu-principal">

            <!-- CAPACIFAR ÚNICO -->
            <?php
            $listaMenu = isset($tabelaCursoMenu) ? $tabelaCursoMenu : $tabelaCurso;

            $presenciais = array_filter($listaMenu, fn($c) => $c->tipo_evento == 1);
            $online = array_filter($listaMenu, fn($c) => $c->tipo_evento == 2);
            $universitario = array_filter($listaMenu, fn($c) => $c->tipo_evento == 5);
            ?>

            <div class="menu-item <?= (empty($presenciais) && empty($online)) ? 'disabled' : ''; ?>">
                <a class="menu-link">Capacifar</a>

                <?php if (!empty($presenciais) || !empty($online)): ?>
                    <div class="submenu">
                        <?php
                        $colunas = 0;
                        if (!empty($online)) $colunas++;
                        if (!empty($presenciais)) $colunas++;
                        if (!empty($universitario ?? [])) $colunas++;
                        ?>

                        <div class="submenu-container capacificar-layout">
                            <!-- ONLINE -->
                            <div class="submenu-group">
                                <div class="submenu-header online">
                                    <img src="<?php echo base_url('assets/img/icons/icons_capacifar/capacifar_online_icon_azul.png'); ?>"
                                        alt="Capacifar Online"
                                        class="mega-icon">

                                    <div class="submenu-header-text">
                                        <strong>CAPACIFAR ONLINE</strong>
                                        <span class="submenu-subtitle">Cursos em destaque</span>
                                    </div>
                                </div>

                                <?php if (!empty($online)): ?>
                                    <?php $count = 0; ?>
                                    <?php foreach ($online as $curso): ?>
                                        <?php if ($count++ >= 3) break; ?>
                                        <a href="<?= base_url() ?>Curso/Listar/<?= $curso->courseid; ?>" class="submenu-link">
                                            <?= $curso->titulo; ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <a href="#" class="submenu-link disabled">
                                        Em breve <small>(novos cursos)</small>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- PRESENCIAL -->
                            <div class="submenu-group">
                                <div class="submenu-header presencial">
                                    <img src="<?php echo base_url('assets/img/icons/icons_capacifar/capacifar_presencial_icon_vermelho.png'); ?>"
                                        alt="Capacifar Presencial"
                                        class="mega-icon">

                                    <div class="submenu-header-text">
                                        <strong>CAPACIFAR PRESENCIAL</strong>
                                        <span class="submenu-subtitle">Cursos em destaque</span>
                                    </div>
                                </div>

                                <?php if (!empty($presenciais)): ?>
                                    <?php $count = 0; ?>
                                    <?php foreach ($presenciais as $curso): ?>
                                        <?php if ($count++ >= 3) break; ?>
                                        <a href="<?= base_url() ?>Curso/Listar/<?= $curso->courseid; ?>" class="submenu-link">
                                            <?= $curso->titulo; ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <a href="#" class="submenu-link disabled">
                                        Em breve <small>(novos cursos)</small>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- UNIVESITÁRIO -->
                            <div class="submenu-group">
                                <div class="submenu-header universitario">
                                    
									<img src="<?php echo base_url('assets/img/icons/icons_capacifar/capacifar_universitario_icon_azul.png'); ?>"
                                        alt="Capacifar Universitário"
                                        class="mega-icon">
										
									<a href="<?=base_url()?>universitario">
                                    <div class="submenu-header-text">
                                        <strong>CAPACIFAR UNIVERSITÁRIO</strong>
                                        <span class="submenu-subtitle">Cursos em destaque</span>
                                    </div>
									</a>
                                </div>

                                <?php if (!empty($universitario)): ?>
                                    <?php $count = 0; ?>
                                    <?php foreach ($universitario as $curso): ?>
                                        <?php if ($count++ >= 3) break; ?>
                                        <a href="<?= base_url() ?>Curso/Listar/<?= $curso->courseid; ?>" class="submenu-link">
                                            <?= $curso->titulo; ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <a href="#" class="submenu-link disabled">
                                        Em breve <small>(novos cursos)</small>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <style>
                                .submenu-header-text {
                                    display: flex;
                                    flex-direction: column;
                                    line-height: 1.05;
                                }

                                .submenu-header strong {
                                    font-size: 17px;
                                    font-weight: 600;
                                    letter-spacing: 0.3px;
                                    margin: 0;
                                }

                                .submenu-subtitle {
                                    font-size: 13px;
                                    color: #888;
                                    font-weight: 400;
                                    margin-top: 0;
                                }

                                .mega-icon {
                                    width: 34px !important;
                                    height: 34px !important;
                                    flex-shrink: 0;
                                    object-fit: contain;
                                    position: relative;
                                    top: -1px;
                                }

                                .submenu-header {
                                    display: flex;
                                    align-items: center;
                                    margin-bottom: 10px;
                                    gap: 7px;
                                }

                                .submenu-header.online strong {
                                    color: #009EB0;
                                }

                                .submenu-header.presencial strong {
                                    color: #E53845;
                                }

                                .submenu-header.universitario strong {
                                    color: #12455e;
                                }
                            </style>
                        </div>

                    </div>
                <?php endif; ?>
            </div>

            <!-- OUTROS ITENS DO MENU -->
            <div class="menu-item">
                <a class="menu-link">Projetos/CRFMG</a>
                <div class="submenu">
                    <div class="submenu-container projetos-4col">

                        <!-- COLUNA (EM BREVE) -->
                        <div class="submenu-group">
                            <a href="#" class="disabled">Atitude Farmacêutica <small>(em breve)</small></a>
                            <a href="#" class="disabled">Receita Legível <small>(em breve)</small></a>
                            <a href="#" class="disabled">Traga de Volta <small>(em breve)</small></a>
                        </div>

                        <!-- COLUNA 1 -->
                        <div class="submenu-group">
                            <a href="<?= base_url() ?>fiscalizacao-humanizada">Fiscalização Humanizada</a>
                            <a href="<?= base_url() ?>plenaria" target="_blank">Plenária Técnica</a>
                            <a href="<?= base_url() ?>urm">Uso Racional de Medicamentos</a>
                        </div>

                        <!-- COLUNA 2 -->
                        <div class="submenu-group">
                            <a href="<?= base_url() ?>merito-academico">Mérito Acadêmico</a>
                            <a href="https://open.spotify.com/show/7fTVbzaZURCPAp7eY5P6Tf" target="_blank">Podcast CRFMG</a>
							<a href="<?= base_url() ?>seminario">Seminário de Vigilância em Saúde</a>
                        </div>

                        <!-- COLUNA 3 -->
                        <div class="submenu-group">
                            <a href="https://crfmg.org.br/minasdesuperacao/" target="_blank">Minas de Superação</a>
                            <a href="<?= base_url() ?>pesquisa-cientifica">Pesquisa Científica</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="menu-item">
                <a class="menu-link">Área Técnica</a>
                <div class="submenu">
                    <div class="submenu-container">
                        <div class="submenu-group">
                            <a href="https://bjhp.crfmg.org.br/crfmg" target="_blank" rel="noopener">Revista BJHP</a>
                        </div>
                        <div class="submenu-group">
                            <a href="https://crf-mg.implanta.net.br/portaltransparencia/#publico/Listas?id=3999544a-8571-4ad4-8e5a-880fa6ddce9e" target="_blank" rel="noopener">Documentos Técnicos</a>
                        </div>
                        <div class="submenu-group">
                            <a href="https://validar.iti.gov.br/" target="_blank" rel="noopener">Validadores</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu-item">
                <a href="https://portal.crfmg.org.br/" class="menu-link">Site CRFMG</a>
            </div>

        </nav>

        <style>
            /* GRID 4 COLUNAS */
            .projetos-4col {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                column-gap: 32px;
            }

            /* GRUPO */
            .projetos-4col .submenu-group {
                position: relative;
                padding-left: 0;
            }

            /* TRAÇO ÚNICO ENTRE COLUNAS */
            .projetos-4col .submenu-group:not(:first-child)::before {
                content: "";
                position: absolute;
                left: -16px;
                top: 6px;
                bottom: 6px;
                width: 1px;
                background: rgba(0, 0, 0, 0.18);
            }

            /* LINKS */
            .projetos-4col a {
                display: block;
                padding: 6px 0;
            }

            .submenu-group strong {
                font-weight: 700;
                margin-bottom: 6px;
                display: block;
            }

            .submenu-group {
                position: relative;
                padding-left: 20px;
            }

            .submenu-group:first-child {
                padding-left: 0;
            }

            .submenu-group:first-child::before {
                display: none;
            }

            .submenu-group:not(:first-child)::before {
                content: "";
                position: absolute;
                left: 0;
                top: 8px;
                bottom: 8px;
                width: 1px;
                background: rgba(0, 0, 0, 0.15) !important;
                opacity: 1 !important;
            }
        </style>

        <!-- AÇÕES -->
        <div class="header-acoes">

            <a href="https://portalfarma.crfmg.org.br/moodle"
                class="btn-entrar">
                Portal do Aluno
            </a>

        </div>

        <style>
            /* =========================================================
            HEADER DESKTOP - NORMAL E SCROLLED
            ========================================================= */

            /* HEADER DESKTOP NORMAL */
            .header-desktop {
                position: fixed;
                top: 0;
                width: 100%;
                height: 130px;
                background-color: #ffffff;
                z-index: 1100;
                transition: background-color 0.35s ease, color 0.35s ease, height 0.35s ease;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);

            }

            /* CONTAINER INTERNO */
            .container-header {
                max-width: 1410px;
                height: 100%;
                margin: 0 auto;
                padding: 0 24px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            /* LOGO */
            .logo img {
                height: 78px;
                margin-top: -5px;
                transition: all 0.35s ease;
            }

            /* MENU PRINCIPAL */
            .menu-principal {
                display: flex;
                gap: 42px;
                margin-top: 32px;
            }

            .menu-principal a {
                color: #12455e;
                font-size: 18px;
                font-weight: 500;
                text-decoration: none;
                padding: 6px 10px;
                border-radius: 8px;
                transition: background 0.25s ease, color 0.25s ease;
            }

            .menu-principal a:hover {
                background: rgba(18, 69, 94, 0.08);
            }

            /* HEADER AÇÕES */
            .header-acoes {
                display: flex;
                align-items: center;
                gap: 18px;
            }

            /* BUSCA */
            .btn-search {
                background: none;
                border: none;
                color: #12455e;
                margin-top: 25px;
                font-size: 20px;
                cursor: pointer;
            }

            /* BOTÃO ENTRAR – OUTLINE */
            .btn-entrar {
                background: transparent;
                margin-top: 20px;
                font-size: 18px;
                color: #fc3041;
                font-weight: 700;
                padding: 8px 25px;
                border-radius: 19px;
                border: 2px solid #fc3041;
                text-decoration: none;
                transition: background 0.25s ease, color 0.25s ease, transform 0.2s ease;
				text-align: center;
            }

            /* HOVER */
            .btn-entrar:hover {
                background: #fc3041;
                color: #ffffff;
                transform: translateY(-1px);
            }

            /* MENU ITEM E SUBMENU */
            .menu-item {
                position: relative;
            }

            .submenu-link {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;

                line-height: 1.3em;
                max-height: 3.2em;

                word-break: break-word;

                position: relative;
                padding-left: 28px !important;
                font-size: 16px !important;
                transition: font-size 0.28s cubic-bezier(.4, 0, .2, 1) !important;

            }

            .submenu-link::before {
                content: "";
                position: absolute;
                left: 6px;

                top: 50%;
                transform: translateY(-50%);

                width: 6px;
                height: 6px;

                background: #c2c7cf;
                border-radius: 50%;
            }

            .submenu {
                position: fixed;
                top: 130px;
                left: 0;
                right: 0;
                width: 100vw;
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                padding: 18px 0;
                opacity: 0;
                visibility: hidden;
                transition: all 0.35s ease;
                z-index: 1099;
                box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);
            }

            /* Submenu quando o header está scrolled */
            .header-desktop.header-scrolled .submenu {
                top: 115px;
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
            }

            .submenu-container {
                max-width: 1250px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px 28px;
                position: relative;
            }

            .submenu-container a {
                padding: 6px 10px;
                color: #000000d8;
                border-radius: 6px;
                transition: background 0.25s ease, color 0.25s ease;
            }



            /* links herdam o tamanho da coluna */
            .submenu-group a {
                font-size: inherit !important;
            }

            .submenu-group {
                font-size: 17px;
                transition: font-size 0.28s cubic-bezier(.4, 0, .2, 1);
            }

            .header-desktop.header-scrolled .submenu-group {
                font-size: 16px;
            }

            /* PROJETOS – FORÇAR 4 COLUNAS */
            .submenu-container.projetos-4col {
                grid-template-columns: repeat(4, 1fr) !important;
            }

            .submenu-group {
                position: relative;
                padding-left: 18px;
            }

            .submenu-group:first-child {
                padding-left: 0;
            }

            .submenu-group:not(:first-child)::before {
                content: "";
                position: absolute;
                left: 0;
                top: 8px;
                bottom: 8px;
                width: 1px;
                background: rgba(0, 0, 0, 0.15);
            }


            .submenu-container a:hover {
                background: rgba(11, 76, 120, 0.08);
                color: #031c2c;
                text-decoration: none;
            }

            .menu-item:hover .submenu {
                opacity: 1;
                visibility: visible;
            }

            /* TRACE NO MENU LINK */
            .menu-link {
                --trace-color: #ffffffb4;
                position: relative;
                display: inline-flex;
                flex-direction: column;
                align-items: center;
                padding-top: 14px;
            }

            /* SUBLINHADO VERMELHO NO HOVER */
            .menu-link {
                position: relative;
                text-decoration: none;
                background: transparent;
            }


            .menu-link::after {
                content: "";
                position: absolute;
                left: 0;
                bottom: -4px;
                width: 0;
                height: 2px;
                background: #fc3041;
                transition: width 0.25s ease;
            }

            .menu-item:hover>.menu-link::after {
                width: 100%;
            }

            .menu-item:hover>.menu-link,
            .menu-link:hover {
                background: transparent !important;
            }

            .menu-link::before {
                content: "";
                position: absolute;
                top: -4px;
                left: 50%;
                transform: translateX(-50%);
                width: 18px;
                height: 3px;
                border-radius: 4px;
                transition: width 0.25s ease, background 0.25s ease;
            }

            .menu-item:hover .menu-link::before {
                opacity: 1;
                width: 34px;
            }

            .menu-link:active::before {
                width: 46px;
            }

            /* HEADER SCROLLED */
            .header-desktop.header-scrolled {
                height: 115px;
                transition: background-color 0.35s ease, height 0.35s ease, color 0.35s ease;
            }

            /* HEADER SCROLLED - fundo branco com sombra */
            .header-desktop.header-scrolled {
                height: 115px;
                transition: background-color 0.35s ease, height 0.35s ease, color 0.35s ease;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                /* sombra suave embaixo */
            }

            /* LOGO MENOR NO SCROLL, mas maior que antes */
            .header-desktop.header-scrolled .logo img {
                height: 70px;
                margin-top: 0;
            }

            /* manter linha vertical escura no scroll */
            .header-desktop.header-scrolled .submenu-group:not(:first-child)::before {
                background: rgba(0, 0, 0, 0.15) !important;
                opacity: 1 !important;
            }

            /* tamanho no scroll — levemente maior */

            .header-desktop.header-scrolled .mega-icon {
                width: 34px !important;
                height: 34px !important;
            }

            .header-desktop.header-scrolled .submenu-header strong {
                font-size: 16.5px;
            }

            .header-desktop.header-scrolled .submenu-subtitle {
                font-size: 12.5px;
            }

            .header-desktop.header-scrolled .submenu-link {
                font-size: 15.5px !important;
            }

            .mega-icon,
            .submenu-header strong,
            .submenu-subtitle,
            .submenu-link {
                transition: all 0.28s cubic-bezier(.4, 0, .2, 1);
            }
        </style>

        <style>
            /* =========================================================
                    ITENS DESABILITADOS – PADRÃO
                    ========================================================= */
            .submenu-container a.disabled,
            .mega-content a.disabled {
                opacity: 0.6;
                pointer-events: none;
                cursor: default;
            }

            /* "(em breve)" – vermelho no estado normal */
            .submenu-container a.disabled small,
            .mega-content a.disabled small {
                font-size: 0.75rem;
                margin-left: 6px;
                color: #fc3041;
            }
        </style>
    </div>
</header>


<!-- HEADER MOBILE -->
<header class="header-mobile mobile-only">
    <div class="mobile-container">

        <!-- BOTÃO MENU -->
        <button class="btn-menu" id="btnMenu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- LOGO MOBILE -->
        <div class="mobile-logo">
            <a href="<?= base_url() ?>" aria-label="Portal Farma">
                <img src="<?= base_url('assets/img/icons/PORTAL FARMA.png') ?>" alt="Portal Farma">
            </a>
        </div>

        <!-- BUSCA -->
        <div class="mobile-search">
            <a href="<?= base_url() ?>#filtro" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>
        </div>

        <style>
            .mobile-search .btn-search {
                text-decoration: none;
                /* remove o traço */
            }

            html {
                scroll-behavior: smooth;
            }

            #filtro {
                scroll-margin-top: 330px;
            }

            .header-mobile {
                position: fixed;
                top: 0;
                width: 100%;
                background: #ffffff;
                z-index: 1200;

                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
            }
        </style>


    </div>
</header>


<!-- MENU LATERAL MOBILE -->
<nav class="menu-lateral" id="menuLateral">
    <div class="menu-scroll">

        <!-- LOGO MOBILE -->
        <div class="menu-logo">
            <img src="<?= base_url('assets/img/crfmg_logo.png') ?>" alt="CRFMG">
        </div>

        <div class="mobile-login ">
            <a href="<?= site_url('portalfarma/entrar') ?>" class="btn-login-mobile">
                <span class="login-text">Portal do Aluno</span>
                <span class="login-action">
                    <i class="bi bi-arrow-right"></i>
                </span>
            </a>

            <a href="https://site.crfmg.org.br"
                class="link-site-crfmg"
                target="_blank"
                rel="noopener">
                SITE DO CRFMG
            </a>
        </div>

        <style>
            .link-site-crfmg {
                display: block;

                margin-top: 22px;
                padding-top: 14px;

                border-top: 1px solid rgba(255, 255, 255, 0.15);

                text-decoration: none;

                font-size: 14px;
                font-weight: 500;
                letter-spacing: 1px;

                color: rgba(255, 255, 255, 0.76);
                text-transform: uppercase;

                transition: opacity .2s ease, transform .2s ease;
            }

            .link-site-crfmg:hover {
                opacity: 1;
            }

            .link-site-crfmg:active {
                transform: scale(0.96);
            }
        </style>

        <!-- EXPLORAR -->
        <div class="mobile-mega">

            <h5 class="mobile-mega-title title-marker">
                O QUE VOCÊ PROCURA?
            </h5>

            <?php
            $listaMenu = isset($tabelaCursoMenu) ? $tabelaCursoMenu : $tabelaCurso;

            $presenciais = array_filter($listaMenu, fn($c) => $c->tipo_evento == 1);
            $online = array_filter($listaMenu, fn($c) => $c->tipo_evento == 2);
            $universitario = array_filter($listaMenu, fn($c) => $c->tipo_evento == 5);
            ?>

            <!-- CAPACIFAR MOBILE -->
            <div class="mobile-mega-group">
                <button class="mega-toggle">
                    <span class="mega-title-text">
                        <i class="fa-solid fa-graduation-cap"></i>
                        CAPACIFAR
                    </span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </button>

                <ul class="mega-content">

                    <!-- SUBTÍTULO CURSOS EM DESTAQUE -->
                    <li class="mega-item mega-subtitle">
                        Cursos em destaque
                    </li>

                    <!-- ONLINE -->
                    <?php if (!empty($online)): ?>
                        <li class="mega-item mega-section-title section-toggle">
                            <img src="<?= base_url('assets/img/icons/icons_capacifar/capacifar_online_icon.png') ?>" class="mega-icon">
                            CAPACIFAR ONLINE
                            <i class="fa-solid fa-chevron-down arrow-section"></i>
                        </li>

                        <ul class="mega-subcontent">
                            <?php foreach (array_slice($online, 0, 3) as $curso): ?>
                                <li class="mega-item">
                                    <a href="<?= base_url() ?>Curso/Listar/<?= $curso->courseid; ?>">
                                        <?= $curso->titulo; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <!-- PRESENCIAL -->
                    <?php if (!empty($presenciais)): ?>
                        <li class="mega-item mega-section-title section-toggle">
                            <img src="<?= base_url('assets/img/icons/icons_capacifar/capacifar_presencial_icon.png') ?>" class="mega-icon">
                            CAPACIFAR PRESENCIAL
                            <i class="fa-solid fa-chevron-down arrow-section"></i>
                        </li>

                        <ul class="mega-subcontent">
                            <?php foreach (array_slice($presenciais, 0, 3) as $curso): ?>
                                <li class="mega-item">
                                    <a href="<?= base_url() ?>Curso/Listar/<?= $curso->courseid; ?>">
                                        <?= $curso->titulo; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <!-- UNIVERSITÁRIO -->
                    <?php if (!empty($universitario)): ?>
                        <li class="mega-item mega-section-title section-toggle">
                            <img src="<?= base_url("assets/img/icons/icons_capacifar/capacifar_online_icon.png") ?>" class="mega-icon">
                            CAPACIFAR UNIVERSITÁRIO <i class="fa-solid fa-chevron-down arrow-section"></i>
                        </li>

                        <ul class="mega-subcontent">
                            <?php foreach (array_slice($universitario, 0, 3) as $curso): ?>
                                <li class="mega-item">
                                    <a href="<?= base_url() ?>Curso/Listar/<?= $curso->courseid; ?>">
                                        <?= $curso->titulo; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- PROJETOS -->
            <div class="mobile-mega-group">
                <button class="mega-toggle">
                    <span class="mega-title-text">
                        <i class="fa-solid fa-diagram-project"></i>
                        PROJETOS/CRFMG
                    </span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </button>

                <ul class="mega-content">

                    <li class="mega-item">
                        <a href="<?= base_url() ?>fiscalizacao-humanizada" class="mega-card">
                            <span class="mega-title">Fiscalização Humanizada</span>
                            <p class="mega-desc">
                                Segurança e parceria: a fiscalização como ferramenta de excelência.
                                Uma iniciativa do CRF/MG em parceria com a Vigilância Sanitária,
                                transformando a fiscalização em uma abordagem educativa e colaborativa.
                                Participe de diálogos estratégicos com órgãos reguladores, tire suas dúvidas e
                                construa uma prática farmacêutica baseada na confiança e na segurança
                                sanitária.
                            </p>
                        </a>
                    </li>

                    <li class="mega-item">
                        <a href="<?= base_url() ?>merito-academico" class="mega-card">
                            <span class="mega-title">Mérito Acadêmico</span>
                            <p class="mega-desc">
                                Honrando o legado, premiando o futuro.
                                A comenda que reconhece a dedicação e o talento dos novos profissionais
                                de Minas Gerais. Uma homenagem à excelência acadêmica inspirada por
                                um dos maiores nomes da nossa história.
                            </p>
                        </a>
                    </li>

                    <li class="mega-item">
                        <a href="https://crfmg.org.br/minasdesuperacao/" target="_blank" rel="noopener" class="mega-card">
                            <span class="mega-title">Minas de Superação</span>
                            <p class="mega-desc">
                                Liderança, acolhimento e cuidado integral.
                                Uma rede colaborativa focada na saúde da mulher e no empoderamento
                                profissional. Capacite-se para um atendimento humanizado e participe de
                                debates essenciais sobre gênero, mercado e liderança.
                            </p>
                        </a>
                    </li>

                    <li class="mega-item">
                        <a href="https://www.youtube.com/watch?v=cRiKBJDybwE" target="_blank" rel="noopener" class="mega-card">
                            <span class="mega-title">Plenária Técnica</span>
                            <p class="mega-desc">
                                Onde as decisões estratégicas encontram a ciência.
                                Acompanhe os debates que orientam o futuro da profissão. Um fórum
                                bimestral de análise legislativa e técnica, aberto ao diálogo com instituições
                                e profissionais que buscam o fortalecimento do setor.
                            </p>
                        </a>
                    </li>

                    <li class="mega-item">
                        <a href="https://open.spotify.com/show/7fTVbzaZURCPAp7eY5P6Tf" target="_blank" rel="noopener" class="mega-card">
                            <span class="mega-title">Podcast CRFMG</span>
                            <p class="mega-desc">
                                A voz da farmácia mineira nos seus ouvidos.
                                Informação técnica, debates atuais e entrevistas com grandes nomes da
                                área. Conteúdo dinâmico e educativo para você se atualizar enquanto se
                                desloca, trabalha ou descansa.
                            </p>
                        </a>
                    </li>

                    <li class="mega-item">
                        <a href="<?= base_url() ?>pesquisa-cientifica" class="mega-card">
                            <span class="mega-title">Pesquisa Científica</span>
                            <p class="mega-desc">
                                O ponto de encontro da ciência farmacêutica.
                                Apoio real para quem produz conhecimento. Um espaço dedicado à
                                divulgação de pesquisas e coleta de dados, conectando pesquisadores de
                                todo o país a temas vitais para a nossa profissão.
                            </p>
                        </a>
                    </li>

                    <li class="mega-item">
                        <a href="<?= base_url() ?>urm" class="mega-card">
                            <span class="mega-title">Uso Racional de Medicamentos</span>
                            <p class="mega-desc">
                                Protagonismo farmacêutico no cuidado à vida.
                                Fortalecemos as boas práticas e a conscientização sobre o uso seguro de
                                medicamentos. Uma iniciativa que une o Conselho e a sociedade para
                                destacar o farmacêutico como agente essencial na saúde pública.
                            </p>
                        </a>
                    </li>

					<li class="mega-item">
                        <a href="<?= base_url() ?>seminario" class="mega-card">
                            <span class="mega-title">Seminário de Vigilância Sanitária</span>
                            <p class="mega-desc">
                                O CRF-MG e a SES-MG realizam o “Seminário de Vigilância em Saúde” para promover o diálogo técnico sobre temas regulatórios e sanitários.
								O evento é voltado a farmacêuticos e fiscais, focando nos desafios e oportunidades da fiscalização de serviços do setor.
                            </p>
                        </a>
                    </li>
					
                    <!-- EM BREVE -->
                    <li class="mega-item">
                        <span class="mega-card mega-card-disabled">
                            <span class="mega-title">
                                Atitude Farmacêutica <small>(em breve)</small>
                            </span>
                        </span>
                    </li>

                    <li class="mega-item">
                        <span class="mega-card mega-card-disabled">
                            <span class="mega-title">
                                Receita Legível <small>(em breve)</small>
                            </span>
                        </span>
                    </li>

                    <li class="mega-item">
                        <span class="mega-card mega-card-disabled">
                            <span class="mega-title">
                                Traga de Volta <small>(em breve)</small>
                            </span>
                        </span>
                    </li>


                </ul>

            </div>

            <!-- CIENTÍFICO -->
            <div class="mobile-mega-group">
                <button class="mega-toggle">
                    <span class="mega-title-text">
                        <i class="fa-solid fa-book-open"></i>
                        ÁREA TÉCNICA
                    </span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </button>

                <ul class="mega-content">
                    <li>
                        <a href="https://bjhp.crfmg.org.br/crfmg"
                            target="_blank" rel="noopener">
                            Revista BJHP
                        </a>
                    </li>

                    <li>
                        <a href="https://crf-mg.implanta.net.br/portaltransparencia/#publico/Listas?id=3999544a-8571-4ad4-8e5a-880fa6ddce9e"
                            target="_blank" rel="noopener">
                            Documentos Técnicos
                        </a>
                    </li>

                    <li>
                        <a href="https://validar.iti.gov.br"
                            target="_blank" rel="noopener">
                            Validadores
                        </a>
                    </li>
                </ul>
            </div>

            <a href="<?= site_url('portalfarma/entrar') ?>"
                class="link-site-crfmg "
                style="border-top: 0px solid rgba(255, 255, 255, 0.15) !important;">
                Acesse aqui sua Área do aluno
            </a>

            <style>
                .mega-subtitle {
                    font-size: 13px;
                    font-weight: 500;
                    color: #a5a4a4;
                    margin: 8px 0 6px 0;
                    padding-left: 0;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .mega-title-text {
                    letter-spacing: 0.5px;
                }

                .mega-desc {
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;

                    font-size: 13.5px;
                    line-height: 1.45;
                    color: rgba(255, 255, 255, 0.78);
                }

                .mega-desc {
                    font-size: 13px;
                    line-height: 1.4;
                    color: rgba(255, 255, 255, 0.75);
                    margin: 4px 0 0 16px;
                    padding-right: 12px;
                }

                /* ======================
                ESPAÇAMENTO ITENS – MEGA MENU MOBILE
                ====================== */

                .mega-content li {
                    margin-bottom: 18px;
                    padding-bottom: 14px;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                }

                .mega-content li:last-child {
                    border-bottom: none;
                    margin-bottom: 0;
                    padding-bottom: 0;
                }

                .mega-content a {
                    display: block;
                    margin-bottom: 6px;
                }

                .mega-desc {
                    margin: 0 0 0 16px;
                    font-size: 13px;
                    line-height: 1.45;
                    color: rgba(255, 255, 255, 0.75);
                }

                .mega-card-disabled {
                    display: block;
                    padding: 14px 16px;
                    border-radius: 12px;
                    background: rgba(255, 255, 255, 0.08);
                    border: 1px dashed rgba(255, 255, 255, 0.35);
                    color: #ffffff;
                    opacity: 0.75;
                }

                .mega-card-disabled .mega-title {
                    font-size: 15px;
                    font-weight: 600;
                    color: #ffffff;
                }

                .mega-card-disabled small {
                    font-size: 12px;
                    margin-left: 6px;
                    color: #ffb3b3;
                }

                .mega-card-disabled {
                    pointer-events: none;
                }


                .mega-button {
                    width: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 12px;

                    background: rgba(255, 255, 255, 0.12);
                    border-radius: 14px;
                    padding: 16px 18px;

                    color: #ffffff;
                    font-size: 16px;
                    font-weight: 600;
                    text-decoration: none;

                    transition: background 0.25s ease, transform 0.2s ease;
                }

                .mega-button span {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .mega-button i {
                    font-size: 16px;
                    opacity: 0.8;
                }

                /* interação */
                .mega-button:active {
                    transform: scale(0.97);
                }

                .mega-button:hover {
                    background: rgba(255, 255, 255, 0.18);
                }

                .mobile-mega-group.no-divider {
                    border-bottom: none !important;
                    padding-bottom: 0;
                    margin-bottom: 16px;
                }

                .mega-card-button {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 16px;
                    padding: 18px 16px;
                    border-radius: 14px;
                    background: rgba(255, 255, 255, 0.08);
                    text-decoration: none;
                    color: #ffffff;
                    transition: background .25s ease, transform .2s ease;
                }

                .mega-card-button:hover {
                    background: rgba(255, 255, 255, 0.12);
                }

                .mega-card-button:active {
                    transform: scale(0.97);
                }

                /* CONTEÚDO */
                .mega-card-content {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                }

                /* TÍTULO */
                .mega-card-title {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    font-size: 17px;
                    font-weight: 700;
                    color: #ffffff;
                }

                /* TEXTO */
                .mega-card-desc {
                    font-size: 13.5px;
                    line-height: 1.45;
                    color: rgba(255, 255, 255, 0.78);
                    margin: 0;
                }

                /* ÍCONE SETA */
                .mega-card-button i {
                    font-size: 16px;
                    opacity: 0.7;
                    margin-top: 4px;
                }

                .mega-section-title {
                    display: flex;
                    align-items: center;
                    justify-content: flex-start !important;
                    gap: 8px;
                    margin-top: 26px;
                    margin-bottom: 16px;
                    font-size: 14px;
                    color: #ffffff;
                }

                .mega-section-title:first-child {
                    margin-top: 0;
                }

                .mega-section-title img {
                    width: 21px !important;
                    height: 21px !important;
                    object-fit: contain;
                    flex-shrink: 0;
                }

                .mega-subcontent {
                    display: none;
                    padding-left: 16px;
                }

                .section-toggle {
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .arrow-section {
                    transition: transform 0.3s ease;
                }

                .section-toggle.active .arrow-section {
                    transform: rotate(180deg);
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toggles = document.querySelectorAll('.section-toggle');

                    toggles.forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const sublist = toggle.nextElementSibling; // pega a ul dos cursos
                            if (!sublist) return;

                            sublist.style.display = sublist.style.display === 'block' ? 'none' : 'block';
                            toggle.classList.toggle('active');
                        });
                    });
                });
            </script>
        </div>

        <!-- LOGO RODAPÉ MENU MOBILE -->
        <div class="menu-footer-logo">
            <img src="<?= base_url('assets/img/logo-portal-farma-branco.png') ?>" alt="Portal Farma">
        </div>

    </div>
</nav>

<!-- ÍCONES SOCIAIS -->
<div class="menu-social" id="menuSocial">

    <a href="https://www.instagram.com/crfmg/" aria-label="Instagram">
        <i class="bi bi-instagram"></i>
    </a>

    <a href="https://www.facebook.com/crfminas/?locale=pt_BR" aria-label="Facebook">
        <i class="bi bi-facebook"></i>
    </a>

    <a href="https://www.youtube.com/@crfminasgerais" aria-label="YouTube">
        <i class="bi bi-youtube"></i>
    </a>

    <a href="https://www.linkedin.com/company/crfmg/posts/?feedView=all" aria-label="LinkedIn">
        <i class="bi bi-linkedin"></i>
    </a>

</div>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<style>
    /* =========================================================
    RESET GLOBAL
    ======================================================= */
    * {
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    body {
        font-family: "Quicksand", Arial, sans-serif;
        letter-spacing: 0.2px;
        background-color: #f7f9f8;
        padding-top: 120px;
    }

    /* =========================================================
    CONTAINERS PADRÃO
    ======================================================= */
    .container-portal {
        max-width: 1400px;
        width: 100%;
        margin: 0 auto;
        padding: 0 0;
    }

    .container-categorias {
        max-width: 850px;
        width: 100%;
        margin: 0 auto;
        padding: 0 0;
    }

    /* =========================================================
    HEADER FIXO - DESKTOP
    ======================================================= */
    /* Header fixo - Desktop */
    .header-portal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: transparent;
        z-index: 1000;
        transition:
            transform 0.4s ease,
            background-color 0.35s ease,
            box-shadow 0.45s cubic-bezier(.22, 1, .36, 1);
        /* transição mais suave */
    }

    /* Header após scroll */
    .header-portal.header-scrolled {
        background: #ffffff;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
    }


    /* Header após scroll */
    .header-portal.header-scrolled {
        background: #ffffff;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
    }

    /* Header escondido ao scroll prolongado */
    .header-portal.header-hidden {
        transform: translateY(-100%);
    }

    /* Navbar */
    .navbar {
        padding: 10px 0;
        min-height: 96px;
        font-size: 1.1rem;
        transition: padding 0.35s ease, min-height 0.35s ease, box-shadow 0.35s ease;
    }

    .navbar>.container-portal {
        display: flex;
        align-items: center;
    }

    /* Links */
    .navbar-nav {
        gap: 30px;
        margin-left: 24px;
    }

    .navbar-nav .nav-link {
        color: #ffffff !important;
        font-size: 18px;
        font-weight: 500;
        letter-spacing: 0.4px;
        padding: 8px 10px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.25s ease, background-color 0.25s ease;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.show {
        background-color: rgba(255, 255, 255, 0.14);
        color: #eafff6 !important;
    }

    /* Dropdown */
    .navbar .nav-link.dropdown-toggle {
        color: #ffffff;
        font-weight: 600;
        font-size: 18px;
        padding: 8px 14px;
        border-radius: 12px;
        transition: background 0.25s ease, color 0.25s ease;
    }

    .navbar .nav-link.dropdown-toggle:hover {
        background: rgba(255, 255, 255, 0.14);
    }

    /* Triângulo */
    .dropdown-triangle {
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 7px solid #ffffff;
        transition: transform 0.3s ease, border-top-color 0.3s ease;
    }

    .nav-item.show .dropdown-triangle {
        transform: rotate(180deg);
    }



    /* =========================================================
    LOGO
    ======================================================== */
    .navbar-brand {
        display: flex;
        align-items: center;
        margin-right: 40px;
    }

    /* SVG */
    .logo-svg {
        width: 180px;
        height: auto;
        color: #ffffff;
        transition: color 0.35s ease, width 0.35s ease, transform 0.35s ease;
    }

    /* Logo menor após scroll */
    .header-portal.header-scrolled .logo-svg {
        width: 150px;
        color: #0b3c5d;
        transform: translateY(-1px);
    }

    /* =========================================================
    BUSCA
    ==================================================== */
    .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        transform: translateY(8px);
    }

    .search-input {
        width: 300px;
        height: 44px;
        padding: 0 18px 0 44px;
        background: rgba(255, 255, 255, 0.28);
        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 999px;
        color: #ffffff;
        font-size: 15px;
        font-weight: 500;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: width 0.35s cubic-bezier(.22, 1, .36, 1), background 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.9);
    }

    .search-input:focus {
        outline: none;
        width: 450px;
        background: rgba(255, 255, 255, 0.42);
        border-color: rgba(255, 255, 255, 0.75);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
    }

    .search-icon {
        position: absolute;
        left: 16px;
        font-size: 16px;
        color: rgba(255, 255, 255, 0.95);
        pointer-events: none;
        transition: transform .25s ease, opacity .25s ease;
    }

    .header-portal.header-scrolled .search-input {
        border-color: #1f2933;
        color: #1f2933;
    }

    .header-portal.header-scrolled .search-input::placeholder {
        color: #6b7280;
    }

    .header-portal.header-scrolled .search-icon {
        color: #1f2933 !important;
    }

    /* ÍCONES DO MEGA MENU MOBILE */
    .mega-icon {
        width: 22px;
        height: 22px;
        object-fit: contain;
        flex-shrink: 0;
    }

    /* =========================================================
    BOTÃO LOGIN
    ========================================================= */
    .btn-login {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        height: 44px;
        padding: 0 20px;
        background: #e63946;
        border: none;
        border-radius: 999px;
        font-size: 17px;
        font-weight: 700;
        letter-spacing: .3px;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 6px 18px rgba(230, 57, 70, 0.35);
        transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
    }

    .btn-login:hover {
        background: #d62839;
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(230, 57, 70, 0.45);
    }

    .btn-login:active {
        transform: scale(0.96);
    }

    .header-portal.header-scrolled .btn-login {
        padding: 8px 22px 8px 16px;
        font-size: 16px;
    }

    /* =========================================================
    MEGA MENU
    ========================================================= */
    .mega-dropdown {
        position: static;
    }

    .mega-dropdown .dropdown-menu {
        position: absolute;
        left: 0;
        right: 0;
        top: 100%;
        width: 100%;
        margin: 0;
        padding: 34px 0;
        border: none;
        border-radius: 0;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
        display: block;
        opacity: 0;
        transform: translateY(-12px) scale(0.98);
        pointer-events: none;
        transition: opacity 0.35s ease, transform 0.45s cubic-bezier(.22, 1, .36, 1);
    }

    .mega-dropdown.show .dropdown-menu {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    .mega-menu .col-md-3 {
        padding: 0 30px;
        border-right: 1px solid rgba(0, 0, 0, 0.08);
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.35s ease, transform 0.35s ease;
    }

    .mega-dropdown.show .mega-menu .col-md-3 {
        opacity: 1;
        transform: translateY(0);
    }

    /* =========================================================
    MOBILE STYLES
    ========================================================= */
    @media (max-width: 991px) {
        body {
            padding-top: 76px;
        }

        .navbar {
            font-size: 1rem;
            padding: 12px 0;
            min-height: auto;
        }

        .navbar-nav {
            gap: 16px;
            margin-top: 12px;
        }

        .logo-svg {
            width: 150px;
        }

        .header-portal.header-scrolled .logo-svg {
            width: 130px;
        }

        .search-input {
            width: 100%;
            margin: 12px 0;
        }

        /* Menu lateral mobile */
        .menu-lateral,
        .menu-social,
        #overlay {
            display: block;
        }
    }

    @media (min-width: 992px) {
        body {
            overflow-x: hidden;
        }

        .menu-lateral,
        .menu-social,
        #overlay {
            display: none;
        }
    }

    /* =========================================================
    VISIBILIDADE MOBILE/DESKTOP
    ========================================================= */
    .desktop-only {
        display: block;
    }

    .mobile-only {
        display: none;
    }

    @media (max-width: 991px) {
        .desktop-only {
            display: none;
        }

        .mobile-only {
            display: block;
        }
    }

    /* =========================================================
   MOBILE HEADER
    ======================================================= */
    .header-mobile {
        position: fixed;
        top: 0;
        width: 100%;
        height: 85px;
        background-color: #ffffff;
        z-index: 1200;
    }



    .mobile-container {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 8px 19px;
    }

    /* =========================================================
    LOGO MOBILE
    ================================================== */
    .mobile-logo {
        transition: transform .3s ease;
        transform: translateX(-2px);
    }

    /* LOGO IMG MOBILE */
    .mobile-logo img {
        height: 60px;
        width: auto;
        transition: height .3s ease;
    }

    /* =========================================================
    BUSCA MOBILE
    =========================================================*/
    .mobile-search {
        position: absolute;
        top: 40%;
        right: 15px;
        transform: translateY(-50%);
        z-index: 999;
    }

    .mobile-search-box {
        position: absolute;
        top: 120%;
        right: 0;
        width: 220px;

        background: #fff;
        padding: 10px;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);

        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all .25s ease;
    }

    .mobile-search-box input {
        width: 100%;
        border: none;
        outline: none;
        font-size: 14px;
    }

    .mobile-search-box.ativo {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .mobile-search .btn-search i {
        font-size: 26px;
        color: #194a5e;
    }

    .mobile-search .btn-search {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        cursor: pointer;
    }


    /* =========================================================
    BOTÃO HAMBURGUER (MENU)
    ===================================================== */
    .btn-menu {
        width: 46px;
        height: 44px;
        padding: 10px;
        background: rgba(54, 50, 50, 0.08);
        border: none;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-top: 18px;
        gap: 5px;
        cursor: pointer;
        transition: background .3s ease;
    }

    .btn-menu:hover {
        background: rgb(255, 255, 255);
    }

    /* Linhas do hamburger */
    .btn-menu span {
        height: 4px;
        width: 26px;
        background-color: #0c4a63;
        border-radius: 3px;
        transition: transform .35s ease, opacity .25s ease;
    }

    /* Animação X */
    .btn-menu.active span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    .btn-menu.active span:nth-child(2) {
        opacity: 0;
    }

    .btn-menu.active span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }

    .btn-menu:active {
        transform: scale(0.95);
    }

    /* =========================================================
    MENU LATERAL MOBILE
    ===================================================== */
    .menu-lateral {
        position: fixed;
        top: 0;
        left: -100%;
        width: 88vw;
        max-width: 380px;
        height: 100vh;

        /* AZUL COM VARIAÇÃO DE TONS */
        background: linear-gradient(180deg,
                #0f3f57 0%,
                #12455e 35%,
                #0b3348 100%);

        z-index: 1300;
        transition: left .45s cubic-bezier(.22, 1, .36, 1), box-shadow .45s ease;
        box-shadow: 20px 0 40px rgba(0, 0, 0, .25);
    }

    .menu-lateral.active {
        left: 0;
    }

    .menu-scroll {
        height: 100%;
        overflow-y: auto;
        padding: 35px 30px 40px;
    }

    /* LOGO NO MENU */
    .menu-logo {
        display: flex;
        margin-bottom: 28px;
        padding-bottom: 34px;
        border-bottom: 2px solid #ffffff66;
    }

    .menu-logo img {
        max-width: 175px;
        width: 170%;
        height: auto;
    }

    /* LINKS DO MENU MOBILE */
    .mobile-menu-bottom {
        list-style: none;
        padding: 0;
        margin-bottom: 32px;
    }

    .mobile-menu-bottom a {
        color: #fff;
        font-size: 18px;
        text-decoration: none;
    }

    /* MEGA MENU MOBILE */
    .mobile-mega-group {
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, .08);
        padding-bottom: 16px;
    }

    .mega-toggle {
        width: 100%;
        background: none;
        border: none;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
        cursor: pointer;
        transition: transform .15s ease, opacity .15s ease;
    }

    .mega-toggle span {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .mega-toggle .arrow {
        font-size: 14px;
        transition: transform .3s ease;
    }

    .mega-toggle:active {
        transform: scale(0.97);
        opacity: 0.85;
    }

    .mega-content {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transform: translateY(-6px);
        transition: max-height .45s cubic-bezier(.22, 1, .36, 1), opacity .35s ease, transform .35s ease;
    }

    .mobile-mega-group.active .mega-content {
        max-height: 2000px;
        opacity: 1;
        transform: translateY(0);
        padding-top: 12px;
        display: block;
    }

    .mega-content li {
        margin-bottom: 12px;
    }

    .mega-content a {
        color: #ffffff;
        text-decoration: none;
        font-size: 15px;
        position: relative;
        padding-left: 18px;
    }

    .mega-content a::before {
        content: "›";
        position: absolute;
        left: 0;
        top: 50%;
        font-size: 18px;
        color: rgba(255, 255, 255, 0.6);
        transform: translateY(-50%);
    }


    .mega-content a:active {
        transform: translateX(3px);
    }

    .mega-content a.ver-todos {
        color: #00e6a8;
        font-weight: 500;
    }

    /* MEGA TITLES */
    .mobile-mega-title {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #ffffff;
        font-size: 20px;
        font-weight: 700;
        margin-top: 33px;
        margin-bottom: 17px;
        padding-bottom: 14px;
    }

    .mobile-mega-title i {
        font-size: 18px;
        color: #0df4b7ff;
    }

    .mobile-mega-title span {
        margin-left: 4px;
    }

    /* =========================================================
    OVERLAY MOBILE
    ========================================================= */
    #overlay,
    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .35);
        backdrop-filter: blur(6px);
        opacity: 0;
        pointer-events: none;
        transition: opacity .35s ease;
        z-index: 1200;
    }

    #overlay.active,
    .overlay.active {
        opacity: 1;
        pointer-events: all;
    }

    /* =========================================================
    MENU SOCIAL MOBILE
    ========================================================= */
    .menu-social {
        position: fixed;
        right: 14px;
        bottom: 55px;
        display: flex;
        flex-direction: column;
        gap: 26px;
        opacity: 0;
        pointer-events: none;
        transform: translateX(10px);
        transition: opacity .35s ease, transform .35s ease;
        z-index: 1305;
    }

    .menu-lateral.active~.menu-social {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(0);
    }

    .menu-social a {
        color: #ffffff;
        font-size: 20px;
        opacity: 0.85;
        padding: 2px 0;
        transition: transform .25s ease, opacity .25s ease;
    }

    .menu-social a:active {
        transform: scale(0.9);
        opacity: 1;
    }

    /* =========================================================
    BOTÃO LOGIN MOBILE
    ========================================================= */
    .mobile-login {
        margin-bottom: 10px;
    }

    .btn-login-mobile {
        display: flex;
        align-items: center;
        gap: 14px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 16px 18px;
        text-decoration: none;
        color: #ffffff;
        position: relative;
    }

    .btn-login-mobile::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 6px;
        height: 100%;
        background: #E53845;
        border-radius: 12px 0 0 12px;
    }

    .btn-login-mobile .login-text {
        font-size: 20px;
        font-weight: 700;
    }

    .btn-login-mobile i {
        margin-left: auto;
        font-size: 18px;
        opacity: .9;
    }

    .btn-login-mobile:hover {
        background: rgba(255, 255, 255, 0.12);
    }

    /* =========================================================
    LINK DESTAQUE MOBILE
    ========================================================= */
    .link-destaque-mobile {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 4px;
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        text-decoration: none;
        transition: transform .25s ease, opacity .25s ease;
    }

    .link-destaque-mobile i {
        font-size: 22px;
        opacity: .6;
        transition: transform .25s ease, opacity .25s ease;
    }

    .link-destaque-mobile:hover i {
        transform: translateX(4px);
        opacity: .9;
    }

    .link-destaque-mobile:active {
        transform: scale(0.97);
        opacity: 0.85;
    }

    /* =========================================================
    LOGO FOOTER MENU MOBILE
    ========================================================= */
    .menu-footer-logo {
        margin-top: 0;
        padding-top: 210px;
        display: flex;
        justify-content: center;
    }

    .menu-footer-logo img {
        max-width: 110px;
        width: 45%;
        height: auto;
        opacity: 0.95;
    }

    /* ESCONDER HEADER AO SCROLL */
    .header-hidden,
    .header-mobile.header-hidden {
        transform: translateY(-100%);
    }

    .header-mobile {
        transition: transform 0.35s ease;
    }


    @media (max-width: 768px) {
        body {
            padding-top: 85px !important;
        }
    }
</style>

<script>
    /* =========================================================
     HEADER DESKTOP + MOBILE – SCROLL INTELIGENTE
    ========================================================= */
    (function() {
        const headerDesktop = document.querySelector('.header-desktop');
        const headerMobile = document.querySelector('.header-mobile');

        let lastScrollY = window.scrollY;

        const SCROLL_OFFSET = 10; // mínimo para reagir
        const SCROLLED_TRIGGER = 60; // estado "scrolled"
        const DESKTOP_LIMIT = 120; // limite para desktop sumir

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            const delta = currentScrollY - lastScrollY;

            /* =====================
               SCROLLED STATE
            ===================== */
            if (currentScrollY > SCROLLED_TRIGGER) {
                headerDesktop?.classList.add('header-scrolled');
                headerMobile?.classList.add('scrolled');
            } else {
                headerDesktop?.classList.remove('header-scrolled');
                headerMobile?.classList.remove('scrolled');
            }

            /* =====================
               MOBILE
            ===================== */
            if (window.innerWidth <= 768 && Math.abs(delta) > SCROLL_OFFSET) {
                if (delta > 0) {
                    headerMobile?.classList.add('header-hidden');
                } else {
                    headerMobile?.classList.remove('header-hidden');
                }
            }


            /* =====================
               TOPO SEMPRE VISÍVEL
            ===================== */
            if (currentScrollY <= 0) {
                headerDesktop?.classList.remove('header-hidden');
                headerMobile?.classList.remove('header-hidden');
                headerDesktop.style.transform = 'translateY(0)';
            }

            lastScrollY = currentScrollY;
        });
    })();


    /* =========================================================
       MENU LATERAL MOBILE + ACORDEÃO
    ========================================================= */
    const btnMenu = document.getElementById('btnMenu');
    const menuLateral = document.getElementById('menuLateral');
    const overlay = document.getElementById('overlay');
    const menuSocial = document.getElementById('menuSocial');

    // Abrir/fechar menu
    btnMenu.addEventListener('click', () => {
        btnMenu.classList.toggle('active');
        menuLateral.classList.toggle('active');
        overlay.classList.toggle('active');
        menuSocial.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
        btnMenu.classList.remove('active');
        menuLateral.classList.remove('active');
        overlay.classList.remove('active');
        menuSocial.classList.remove('active');
    });

    // Acordeão submenus
    document.querySelectorAll('.mega-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const group = toggle.closest('.mobile-mega-group');

            // fecha os outros grupos
            document.querySelectorAll('.mobile-mega-group').forEach(item => {
                if (item !== group) item.classList.remove('active');
            });

            group.classList.toggle('active');
        });
    });

    // Funções auxiliares (não usadas diretamente)
    function openMenu() {
        menuLateral.classList.add('active');
        overlay.classList.add('active');
        menuSocial.classList.add('active');
    }

    function closeMenu() {
        menuLateral.classList.remove('active');
        overlay.classList.remove('active');
        menuSocial.classList.remove('active');
    }
</script>

<script>
    const cards = document.querySelectorAll('.mega-card');
    let expandedCard = null; // guarda qual card está aberto

    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            const desc = card.querySelector('.mega-desc');
            const icon = card.querySelector('i.fa-arrow-right');

            if (expandedCard && expandedCard !== card) {
                // fecha o card que estava aberto
                const prevDesc = expandedCard.querySelector('.mega-desc');
                const prevIcon = expandedCard.querySelector('i.fa-arrow-down');
                if (prevDesc) {
                    prevDesc.style.webkitLineClamp = '2';
                    prevDesc.style.overflow = 'hidden';
                }
                if (prevIcon) {
                    prevIcon.classList.remove('fa-arrow-down');
                    prevIcon.classList.add('fa-arrow-right');
                }
                expandedCard = null;
            }

            if (expandedCard === card) {
                // se clicou no card já expandido → deixa o link funcionar normalmente
                return;
            } else {
                // primeiro clique no card → expande e impede navegação
                e.preventDefault();
                desc.style.webkitLineClamp = 'unset';
                desc.style.overflow = 'visible';
                if (icon) {
                    icon.classList.remove('fa-arrow-right');
                    icon.classList.add('fa-arrow-down');
                }
                expandedCard = card; // marca este card como aberto
            }
        });
    });
</script>