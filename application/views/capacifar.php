<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Porta Farma</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/css/style.css">
	
	<link rel="stylesheet" href="assets/css/style_caminhos.css">
	<link rel="stylesheet" href="assets/css/style_iniciativas.css">
	<link rel="stylesheet" href="assets/css/style_selector.css">
	<link rel="stylesheet" href="assets/css/style_cursos.css">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<?php //print_r($capacifar_tipo); ?>
<style>

/* Breadcrumb */
.breadcrumb {
    background: #f0f0f0;
    padding: 15px 40px;
    font-size: 14px;
}

.breadcrumb a {
    color: #3b5bdb;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb span {
    margin: 0 6px;
}

</style>
	
<body>
	
	<nav class="breadcrumb">
		<a href="inicio">Início</a> <span>/</span> 
		<a href="online">Capacifar <?=$capacifar_tipo?></a> <span>/</span>
	</nav>

    <!-- CATEGORIAS -->
    <section class="area-selector">
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
                            data-text="<i class='fa-solid fa-clock'></i> Em breve">
                            PARA A EMPRESA
                        </button>

                        <button class="area-tab active"
                            data-target="farmaceutico"
                            data-text="Conteúdos que transformam conhecimento em vantagem competitiva">
                            PARA O FARMACÊUTICO
                        </button>

                        <button class="area-tab"
                            data-target="sociedade"
                            data-text="<i class='fa-solid fa-clock'></i> Em breve">
                            PARA A SOCIEDADE
                        </button>
                    </div>

                    <!-- ÍCONES -->
                    <div class="area-icons">
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
                    </div>

                </div>
            </div>

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
    </section>


    <!-- CURSOS -->
    <section class="section-cursos">
        <div class="container-portal">

            <!-- CONTEÚDOS -->
            <div class="tabs-content">

                <!-- FARMACÊUTICO -->
                <div class="tab-pane active" id="farmaceutico">
                    <div class="cards-wrapper">
                        <div class="cards-track">

                            <?php

                            ///print_r($tabelaCurso);

                            foreach ($tabelaCurso as $campo) {

                                // var_dump($campo);

                                if ($campo->courseid  == 0 || $campo->courseid  == 1) {
                                    continue;
                                }

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

                                $campo_horas = $campo->carga_horaria / 60;
                                $campo_parte = preg_split('/[\.\r\n]/', $campo->descricao, 2)[0];

                                ?>
                                <?php
                                $classe_card = ($campo->tipo_evento == 2) ? 'online' : 'presencial';
                                ?>

                                <?php
                                $classe_area = 'area-' . strtolower(str_replace(' ', '-', $campo->categorias));
                                ?>

                                <div class="card-curso <?= $classe_card; ?> <?= $classe_area; ?>"
                                    data-area="<?= trim($campo->categorias); ?>">
                                    <div class="card-curso-topo">
                                        <img src="assets/img/cursos_ava/<?= $campo->nome_curto; ?>.png" alt="">
                                    </div>

                                    <div class="card-curso-info">
                                        <?php
                                        $classe_tipo = strtolower(trim($campo_evento)); // "online" ou "presencial"
                                        ?>
                                        <span class="tipo-evento <?= $classe_tipo; ?>"><?= $campo_evento; ?></span>

                                        <span><i class="bi bi-clock"></i><?= $campo_horas; ?>hrs</span>

                                        <span><i class="bi bi-people-fill"></i> 0</span>
                                    </div>

                                    <div class="card-curso-body">
                                        <small class="nome-evento"><?= $campo->categorias; ?></small>

                                        <div class="titulo-wrapper">
                                            <h3 class="nome-curso"><?= $campo->titulo; ?></h3>
                                        </div>

                                        <a href="<?= base_url() ?>Curso/Listar/<?= $campo->courseid; ?>" class="btn-saiba-mais">
                                            Saiba mais
                                        </a>
                                    </div>


                                    <div class="card-icon">
                                        <i class="<?= $campo->icones; ?>"></i>
                                    </div>


                                    <!-- OVERLAY HOVER -->
                                    <div class="card-curso-hover">

                                        <span class="hover-tipo">
                                            <?= $campo_evento; ?>
                                        </span>

                                        <span class="hover-icon">
                                            <i class="<?= $campo->icones; ?>"></i>
                                        </span>

                                        <span class="hover-categoria"><?= $campo->categorias; ?></span>

                                        <h4><?= $campo->titulo; ?></h4>

                                        <div style="min-height: 310px;"><?= $campo_parte; ?></div>

                                        <a href="<?= base_url() ?>curso/listar/<?= $campo->courseid; ?>" class="btn-hover">Ver agora</a>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>

                        </div>

                    </div>

                    <div class="paginacao-cursos">
                        <button class="page-btn prev" data-page="prev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <button class="page-btn active" data-page="1">1</button>
                        <button class="page-btn" data-page="2">2</button>
                        <button class="page-btn" data-page="3">3</button>

                        <button class="page-btn next" data-page="next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="swipe-indicator">
                    <span></span>
                </div>
            </div>

        </div>

    </section>


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
                    pane.classList.toggle('active', pane.id === target);
                });

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
                const area = card.dataset.area;
                const color = mapaCores[area];

                if (color) {
                    const c = color.includes(',') ? color.split(',')[0] : color;
                    card.style.setProperty('--area-color', c);
                }
            });

            areaIcons.forEach(icon => {
                icon.addEventListener('click', () => {

                    const filtro = icon.dataset.filter;
                    const jaAtivo = filtroAtivo === filtro;

                    /* RESET VISUAL */
                    areaIcons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.style.background = '#ffffff';

                        const i = btn.querySelector('i');
                        if (i) i.style.color = '#2563eb';
                    });

                    /* RESET FILTRO */
                    if (jaAtivo) {
                        filtroAtivo = null;

                        cards.forEach(card => {
                            card.classList.remove('filtrado', 'is-open');
                        });

                        if (window.setPaginaAtualCursos) {
                            window.setPaginaAtualCursos(1);
                        }
                        return;
                    }

                    /* ATIVA FILTRO */
                    filtroAtivo = filtro;
                    icon.classList.add('active');

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


                    /* FILTRA CARDS + COR DOS ÍCONES */
                    cards.forEach(card => {
                        const categoria = card.querySelector('.nome-evento')?.textContent.trim();
                        const ativo = categoria === filtro;

                        card.classList.toggle('filtrado', !ativo);
                        card.classList.remove('is-open');

                        if (ativo && color) {
                            const bg = color.includes(',') ?
                                `linear-gradient(135deg, ${color})` :
                                color;

                            /* card-icon */
                            const cardIcon = card.querySelector('.card-icon');
                            if (cardIcon) cardIcon.style.background = bg;

                            /* hover-icon */
                            const hoverIcon = card.querySelector('.hover-icon');
                            if (hoverIcon) hoverIcon.style.background = bg;
                        }
                    });


                    if (window.setPaginaAtualCursos) {
                        window.setPaginaAtualCursos(1);
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
               5. PAGINAÇÃO – DESKTOP (ROBUSTA)
            ====================================================== */
            if (window.innerWidth > 768) {

                const paginacao = document.querySelector('.paginacao-cursos');
                const pageBtns = document.querySelectorAll('.page-btn[data-page]');
                const prevBtn = document.querySelector('.page-btn.prev');
                const nextBtn = document.querySelector('.page-btn.next');

                const cardsPorPagina = 4;
                let paginaAtual = 1;

                function getCardsAtivos() {
                    return [...document.querySelectorAll('.card-curso')]
                        .filter(card => !card.classList.contains('filtrado'));
                }

                function renderizarPagina(pagina) {
                    const cards = getCardsAtivos();
                    const totalPaginas = Math.ceil(cards.length / cardsPorPagina);

                    if (cards.length <= cardsPorPagina) {
                        paginacao.style.display = 'none';
                        cards.forEach(card => card.style.display = 'block');
                        return;
                    }

                    paginacao.style.display = 'flex';

                    const inicio = (pagina - 1) * cardsPorPagina;
                    const fim = inicio + cardsPorPagina;

                    cards.forEach((card, index) => {
                        card.style.display =
                            index >= inicio && index < fim ? 'block' : 'none';
                    });

                    pageBtns.forEach(btn => {
                        btn.classList.toggle(
                            'active',
                            parseInt(btn.dataset.page) === pagina
                        );
                    });
                }

                pageBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        paginaAtual = parseInt(btn.dataset.page);
                        renderizarPagina(paginaAtual);
                    });
                });

                prevBtn?.addEventListener('click', () => {
                    if (paginaAtual > 1) {
                        paginaAtual--;
                        renderizarPagina(paginaAtual);
                    }
                });

                nextBtn?.addEventListener('click', () => {
                    paginaAtual++;
                    renderizarPagina(paginaAtual);
                });

                window.setPaginaAtualCursos = (p) => {
                    paginaAtual = p;
                    renderizarPagina(paginaAtual);
                };

                renderizarPagina(paginaAtual);
            }

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

    <?php //include __DIR__ . '/layout/footer.php'; 
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>