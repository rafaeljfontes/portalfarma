<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Porta Farma - Atitude Farmacêutica</title>

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

        .atitude-hero-botoes {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        #atitude-apresentacao-modal,
        #atitude-criterios-modal { z-index: 1400; }
        body.atitude-modal-informacoes-aberto .modal-backdrop { z-index: 1390; }
        #atitude-apresentacao-modal .modal-dialog,
        #atitude-criterios-modal .modal-dialog {
            margin: var(--atitude-modal-topo, 135px) auto 15px;
            height: calc(100% - var(--atitude-modal-topo, 135px) - 15px);
        }
        @media (max-width: 575.98px) {
            #atitude-apresentacao-modal .modal-dialog,
            #atitude-criterios-modal .modal-dialog { margin-left: 8px; margin-right: 8px; }
        }
        #atitude-apresentacao-modal .modal-body,
        #atitude-criterios-modal .modal-body { line-height: 1.7; }
        #atitude-apresentacao-modal .modal-body strong,
        #atitude-criterios-modal .modal-body strong { color: #b3710a; font-weight: 700; }
        #atitude-apresentacao-modal .modal-body h3,
        #atitude-criterios-modal .modal-body h3 { font-size: 1.15rem; margin-bottom: 16px; }
        #atitude-apresentacao-modal .modal-body li,
        #atitude-criterios-modal .modal-body li { margin-bottom: 12px; }

        .btn-atitude-informacoes {
            background: #12455e;
            color: #fff;
            border: 1px solid #12455e;
            border-radius: 10px;
            padding: 12px 24px;
            font-size: 17px;
            font-weight: 600;
            transition: background-color .2s ease;
        }

        .btn-atitude-informacoes:hover {
            background: #0a3043;
        }

        .btn-atitude-informacoes:focus-visible {
            outline: 3px solid #6ba5c4;
            outline-offset: 3px;
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
            border: 0;
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
    <?php $this->load->view('fixo/cabecalho'); ?>
<section class="banner-curso">
        <div class="banner-container">
            <img
                src="<?= base_url('assets/banner_projetos/header-atitude-farmaceutica.png') ?>"
                alt="Atitude Farmacêutica" width="1360" height="460"
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
                width: 100%;
                max-width: 1360px;
            }

            /* IMAGEM */
            .banner-imagem {
                width: 100%;
                height: auto;
                aspect-ratio: 1360 / 460;
                object-fit: cover;
                object-position: center;

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

    <section class="curso-hero">
        <div class="container-inscricao">
            <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>


            <div class="curso-hero-grid">
                <div class="curso-hero-info">
                    <h1 class="curso-titulo destaque">Atitude Farmacêutica</h1>
                    <p class="curso-publicacao">
                        Um projeto do CRF/MG que tem o objetivo de valorizar e disseminar a cultura da responsabilidade social e ambiental, ressaltando as ações de profissionais e empresas do segmento farmacêutico que desenvolvem ações que impactam positivamente a organização e a sociedade.
                    </p>
                    <div class="atitude-hero-botoes">
                        <button type="button" class="btn-atitude-informacoes" data-bs-toggle="modal" data-bs-target="#atitude-apresentacao-modal">Apresentação</button>
                        <button type="button" class="btn-atitude-informacoes" data-bs-toggle="modal" data-bs-target="#atitude-criterios-modal">Ver critérios</button>
                    </div>
                </div>

                <div class="curso-hero-card">
                        <?php if (($faseEvento ?? 'inscricao') === 'votacao'): ?>
                            <a href="<?= site_url('atitude_farmaceutica/votacao') ?>" class="btn-inscricao grande">Votação</a>
                        <?php elseif (($faseEvento ?? 'inscricao') === 'inscricao'): ?>
                            <a href="<?= site_url('atitude_farmaceutica/inscricao'); ?>" class="btn-inscricao grande">Inscrever minha atitude</a>
                        <?php else: ?>
                            <p class="mb-0 text-center" style="color: #12455e; font-size: 20px;">Agradecemos a participação de todos! As inscrições e a votação estão encerradas.</p>
                        <?php endif; ?>
                    </div>
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

    <div class="modal fade" id="atitude-apresentacao-modal" tabindex="-1" aria-labelledby="atitude-apresentacao-titulo" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="atitude-apresentacao-titulo">Apresentação</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <h3><strong>ATITUDE FARMACÊUTICA</strong></h3>
                    <p>O <strong>ATITUDE FARMACÊUTICA</strong> é um programa institucional do CRF/MG voltada à identificação, valorização e divulgação de projetos e ações que demonstrem a contribuição da profissão farmacêutica para a sociedade. A proposta busca dar visibilidade a experiências que promovam o desenvolvimento comunitário, a melhoria das práticas nos ambientes de trabalho e a proteção do meio ambiente, incentivando a continuidade e a disseminação de iniciativas de interesse público.</p>
                    <p>Sabemos que o cuidado está no cerne da profissão farmacêutica e por isso entendemos a importância do nosso papel em ações em prol do bem comum. Com o <strong>ATITUDE FARMACÊUTICA</strong> queremos conhecer os vários projetos e ações, realizados por profissionais e empresas, que sejam voltados para a Responsabilidade Social, Relações de Trabalho Humanizadas e Responsabilidade Ambiental. Esperamos que cada um seja tocado por bons exemplos e assim espalhar a solidariedade farmacêutica em nosso Estado.</p>
                    <h3 class="mt-4"><strong>OBJETIVOS</strong></h3>
                    <p>O projeto propõe um processo organizado de inscrição, análise e divulgação das iniciativas, combinando avaliação técnica por um comitê e votação aberta por meio do site do CRF/MG. Tem como objetivos:</p>
                    <ul>
                        <li>Identificar, registrar e divulgar iniciativas de responsabilidade social desenvolvidas por profissionais farmacêuticos, empresas e organizações relacionadas à área farmacêutica, dando visibilidade às ações realizadas e aos resultados alcançados.</li>
                        <li>Estimular o compartilhamento de experiências e boas práticas, promovendo a disseminação de conhecimentos e incentivando a replicação ou adaptação de iniciativas bem-sucedidas em diferentes contextos.</li>
                        <li>Promover a participação da sociedade por meio da votação popular, ampliando o envolvimento social e a valorização das iniciativas inscritas.</li>
                        <li>Reconhecer e valorizar iniciativas de destaque com base em critérios de avaliação previamente estabelecidos e divulgados, contribuindo para a valorização da responsabilidade social no exercício profissional e na atuação institucional.</li>
                        <li>Incentivar o desenvolvimento e o fortalecimento de projetos de responsabilidade social entre profissionais farmacêuticos, empresas e organizações do setor, estimulando a cooperação entre empresas, empregados e sociedade em prol do bem comum e da melhoria da qualidade de vida.</li>
                        <li>Disseminar a cultura da responsabilidade social na área farmacêutica, promovendo o conhecimento, a reflexão e o debate sobre sua importância para o exercício profissional, a atuação institucional e o desenvolvimento da sociedade.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-atitude-informacoes" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="atitude-criterios-modal" tabindex="-1" aria-labelledby="atitude-criterios-titulo" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="atitude-criterios-titulo">Critérios</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <h3><strong>CRITÉRIOS PARA PARTICIPAÇÃO E INSCRIÇÃO</strong></h3>
                    <p>As inscrições serão realizadas por meio de formulário eletrônico disponibilizado pelo CRF/MG. O Farmacêutico participante deverá preencher os campos solicitados, enviar a imagem prevista no sistema e revisar as informações antes de confirmar o envio.</p>
                    <p>O programa <strong>ATITUDE FARMACÊUTICA</strong> contemplará a inscrição de projetos em duas categorias: <strong>Profissionais</strong> e <strong>Empresas</strong>. Cada categoria terá critérios específicos de inscrição e avaliação, definidos de acordo com seus respectivos Eixos de Inscrição.</p>
                    <ul>
                        <li>
                            <strong>Categoria 1 - Profissionais</strong>
                            <p>Poderão se inscrever e participar do programa <strong>ATITUDE FARMACÊUTICA</strong>, profissionais farmacêuticos atuantes em qualquer área da profissão. Nesta categoria serão inscritos projetos de iniciativa individual ou coletiva, que se enquadram nos eixos do programa e que sejam desenvolvidos ou contem com a participação direta de farmacêuticos, mesmo aqueles que, em caráter de financiamento, recebam recursos ou ajuda financeira de empresas privadas sem, contudo, estar à estas organizacionalmente submetidos. Somente farmacêuticos, poderão se inscrever nesta categoria. Não serão aceitos projetos de iniciativa exclusiva de terceiros, que não contam com a participação direta de farmacêuticos.</p>
                        </li>
                        <li>
                            <strong>Categoria 2 - Empresas</strong>
                            <p>Todas as empresas, órgãos e entidades, públicas e privadas sediadas no Estado de Minas Gerais, que desenvolvam atividades farmacêuticas, incluindo Instituições de Ensino ou Centros de Pesquisa, poderão cadastrar seus projetos no <strong>ATITUDE FARMACÊUTICA</strong>. Para participar é necessário, quando houver, que a empresa esteja legal e sanitariamente licenciada, que possua registro e Certidão de Regularidade Técnica válida emitida pelo CRF/MG. A constatação de qualquer ato de ilegalidade ou relacionado ao descumprimento dos preceitos éticos da profissão farmacêutica será critério para exclusão do projeto submetido.</p>
                        </li>
                    </ul>
                    <p>O formulário de inscrição será preenchido em etapas, reunindo informações sobre o projeto, sua execução, o público beneficiado e os resultados alcançados. A seguir, estão as orientações para os campos exibidos:</p>
                    <ol>
                        <li><strong>Título do Projeto:</strong> Informar o nome do projeto desenvolvido. O título deve ser claro, objetivo e representar a iniciativa inscrita.</li>
                        <li>
                            <strong>Eixo do Projeto:</strong> Selecionar o eixo temático que melhor corresponde à finalidade principal e às ações desenvolvidas pelas iniciativas
                            <ul class="mt-3">
                                <li><strong>Eixo 1: Envolvimento e desenvolvimento da comunidade</strong> – está relacionado à promoção de quaisquer ações de cunho assistencial e/ou educacional destinadas à comunidade onde operam, ou a grupos específicos que careçam de apoio especial.</li>
                                <li><strong>Eixo 2: Práticas exitosas de trabalho</strong> – Este eixo está relacionado a promoção de políticas internas, destinadas a parceiros, colegas e/ou colaboradores, que contribuem individual ou coletivamente para o desenvolvimento e benefício do ser humano, que vão além do cumprimento das obrigações legais nas relações de trabalho.</li>
                                <li><strong>Eixo 3: Respeito e proteção do Meio Ambiente</strong> – Envolve as ações individuais e coletivas ou programas organizacionais que visam recuperar ou minimizar os impactos ambientas provenientes das ações da empresa ou da comunidade onde está inserida.</li>
                            </ul>
                        </li>
                        <li><strong>Número de participantes:</strong> Informar o número de pessoas que participaram diretamente da realização do projeto, como profissionais envolvidos, voluntários, colaboradores ou integrantes da equipe executora.</li>
                        <li><strong>Cidade:</strong> Informar o município onde o projeto foi desenvolvido. Caso a iniciativa tenha ocorrido em mais de uma cidade, detalhar essa informação no campo de descrição, quando aplicável.</li>
                        <li><strong>Local:</strong> Informar o local em que as atividades foram realizadas, como instituição, estabelecimento, comunidade, unidade de saúde, escola ou outro espaço relacionado à execução do projeto.</li>
                        <li><strong>Data de início:</strong> Indicar a data em que o projeto começou a ser executado.</li>
                        <li><strong>Recursos:</strong> Informar os recursos utilizados para a realização do projeto, incluindo, quando aplicável, recursos financeiros, materiais, humanos, estruturais e parcerias. Se forem utilizados recursos próprios, indicar essa condição.</li>
                        <li><strong>Resumo:</strong> Apresentar uma síntese do projeto, destacando sua finalidade, o público atendido, as principais atividades realizadas e os resultados mais relevantes. O texto deve permitir uma compreensão rápida da iniciativa, sendo o número máximo de caracteres de 450.</li>
                        <li><strong>Descrição do Projeto:</strong> Descrever como o projeto foi desenvolvido, incluindo o contexto em que surgiu, as etapas de execução, as atividades realizadas, a participação dos envolvidos e as estratégias utilizadas para alcançar os resultados. Sempre que possível, apresentar informações concretas sobre a realização da iniciativa, sendo o número máximo de caracteres de 600.</li>
                        <li><strong>Justificativa:</strong> Explicar a necessidade ou o problema que motivou a criação do projeto. Apresentar sua relevância para o público beneficiado e para a comunidade, indicando a situação que a iniciativa buscou transformar. sendo o número máximo de caracteres de 120.</li>
                        <li><strong>Pessoas Alcançadas:</strong> Informar o número estimado ou contabilizado de pessoas alcançadas pelas ações do projeto. Considerar o público beneficiado direta ou indiretamente, conforme os registros disponíveis, evitando duplicidade na contagem sempre que possível.</li>
                        <li><strong>Benefícios já alcançados:</strong> Descrever os benefícios observados a partir da realização do projeto, indicando mudanças, melhorias ou contribuições para o público atendido, a comunidade, os serviços ou as instituições envolvidas. Quando houver dados, registros ou exemplos que demonstrem os resultados, eles poderão ser mencionados. sendo o número máximo de caracteres de 250.</li>
                        <li><strong>Objetivos já alcançados:</strong> Informar quais objetivos previstos para o projeto foram efetivamente alcançados até o momento da inscrição. Quando pertinente, indicar os objetivos parcialmente alcançados e aqueles que ainda estão em andamento, distinguindo resultados obtidos de metas futuras. sendo o número máximo de caracteres de 250.</li>
                    </ol>
                    <p>Após concluir os dados do projeto, seguir à etapa de inclusão das imagens. Nesta etapa incluir as imagens, conferir as informações e confirmar o envio da inscrição.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-atitude-informacoes" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <section class="curso-informacoes" id="atitude-projetos">
        <div class="container-informacoes">
            <h2 class="curso-info-titulo">Projetos</h2>
            <?php $this->load->view('atitude-farmaceutica/projetos_aceitos', array('projetosAceitos' => $projetosAceitos ?? array())); ?>
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
    <?php $this->load->view('fixo/rodape'); ?>
    <script>
    (() => {
        const modais = ['atitude-apresentacao-modal', 'atitude-criterios-modal'].map(id => document.getElementById(id));
        const cabecalhos = Array.from(document.querySelectorAll('header.header-desktop, header.header-mobile'));
        function posicionarModais() {
            const baseCabecalho = cabecalhos.reduce((base, cabecalho) => {
                const area = cabecalho.getBoundingClientRect();
                return area.width > 0 && area.height > 0 && area.bottom > 0 ? Math.max(base, area.bottom) : base;
            }, 0);
            modais.forEach(modal => modal.style.setProperty('--atitude-modal-topo', `${Math.ceil(baseCabecalho) + 15}px`));
        }
        modais.forEach(modal => {
            modal.addEventListener('show.bs.modal', () => {
                posicionarModais();
                document.body.classList.add('atitude-modal-informacoes-aberto');
            });
            modal.addEventListener('hidden.bs.modal', () => {
                if (!modais.some(item => item.classList.contains('show'))) document.body.classList.remove('atitude-modal-informacoes-aberto');
            });
        });
        window.addEventListener('resize', posicionarModais);
        window.addEventListener('scroll', posicionarModais, { passive: true });
        if (typeof ResizeObserver !== 'undefined') {
            const observador = new ResizeObserver(posicionarModais);
            cabecalhos.forEach(cabecalho => observador.observe(cabecalho));
        }
        posicionarModais();
    })();
    </script>
</body>
</html>
