<head>
    <meta charset="UTF-8">
    <title>Porta Farma - Capacifar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/style_caminhos.css">
    <link rel="stylesheet" href="assets/css/style_iniciativas.css">
    <link rel="stylesheet" href="assets/css/style_selector.css">
    <link rel="stylesheet" href="assets/css/style_cursos.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">


    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<?php
	
	//var_dump($programacao);
	
foreach ($tabelaCurso as $indice => $campo) {

    /* =========================================
       TIPO DE EVENTO
    ========================================= */
    $tipo = (int) $campo->tipo_evento;

    if ($tipo === 1) {
        $campo_evento = "Presencial";
        $classe_badge = "presencial";
    } elseif ($tipo === 2) {
        $campo_evento = "Online";
        $classe_badge = "online";
    } else {
        $campo_evento = "Evento";
        $classe_badge = "evento";
    }


    /* =========================================
       DADOS BÁSICOS
    ========================================= */
    $campo_imagem   = $campo->nome_curto;
    $campo_titulo   = $campo->titulo;
    $campo_courseid = $campo->courseid;
    $campo_status   = (int) $campo->status;


    /* =========================================
       OBJETIVO E METODOLOGIA
    ========================================= */
    $campo_informacoes = $campo->topicos;

    $texto_limpo = trim(strip_tags($campo_informacoes));



    /* =========================================
       OUTROS CAMPOS
    ========================================= */
    $campo_programacao  = $campo->programacao;
    $campo_palestrantes = $campo->palestrantes;

    $campo_horas = $campo->carga_horaria / 60;

    // Primeira frase da descrição (hero)
    $campo_parte = preg_split(
        '/[\.\r\n]/',
        strip_tags($campo->descricao),
        2
    )[0];

    //var_dump($total_alunos);
    $total_inscritos = $total_alunos[0]->total_estudantes ?? null;


    /* =========================================
       DATAS
    ========================================= */
    $formatter = new IntlDateFormatter(
        'pt_BR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE
    );

    $campo_cadastro = $formatter->format(
        new DateTime($campo->data_cadastro)
    );

    $data_inicio 	= new DateTime($campo->data_inicio);
    $hora_final 	= new DateTime($campo->data_fim);
    $campo_horario 	= $data_inicio->format('G:i');
    $campo_horario_final = $hora_final->format('G:i');


    $data_fim    = $campo->data_fim ? new DateTime($campo->data_fim) : null;

    $campo_data_evento = $formatter->format($data_inicio);
    if ($data_fim) {
        $campo_data_evento .= ' a ' . $formatter->format($data_fim);
    }

    /* =========================================
       CAMPOS COMPLEMENTARES
    ========================================= */
    $campo_local       = $campo->local ?: 'Evento Online';
    $campo_publico     = $campo->publico_alvo;
    $campo_dificuldade = ucfirst($campo->dificuldade);
}

//amarrar a quantidade de insritos por curso [CourseID, quantidade maxima]
$max_inscritos_por_curso = [
    99 => 80,
];

$limite_inscritos = $max_inscritos_por_curso[(int) $campo_courseid] ?? null;
$curso_ativo = $campo_status === 1;
$possui_vagas = $limite_inscritos === null || (int) $total_inscritos < $limite_inscritos;
$inscricoes_abertas = $curso_ativo && $possui_vagas;
?>

<body>
    <section class="curso-hero">

        <div class="container-inscricao">

            <a href="<?= base_url() ?>" class="btn-voltar">
                VOLTAR
            </a>

            <div class="curso-hero-grid">

                <!-- ESQUERDA -->
                <div class="curso-hero-info">

                    <h1 class="curso-titulo destaque">
                        <?= $campo_titulo; ?>
                    </h1>

                    <div class="curso-badges">

                        <!-- LINHA 1 -->
                        <div class="linha-topo">
                            <span class="badge azul">
                                PARA O FARMACÊUTICO
                            </span>

                            <span class="badge <?= $classe_badge; ?> badge-modalidade">
                                <?= strtoupper($campo_evento); ?>
                            </span>

							<?php if (!empty($campo_dificuldade)): ?>
								<span class="badge badge-dificuldade">
									<?= strtoupper(htmlspecialchars($campo_dificuldade, ENT_QUOTES, 'UTF-8')); ?>
								</span>
							<?php endif; ?>

                        </div>

                        <!-- LINHA 2 -->
                        <div class="linha-inferior">
                            <?php
                            $categorias = explode(',', $campo->categorias);
                            $categorias = array_map('trim', $categorias);

                            foreach ($categorias as $categoria):

                                if (!isset($areas_icons[$categoria])) continue;

                                $icone = $areas_icons[$categoria]['icone'];
                                $cor   = explode(',', $areas_icons[$categoria]['cor'])[0];
                            ?>

                                <span class="badge badge-area"
                                    style="background-color: <?= $cor ?>;">
                                    <i class="<?= $icone ?>"></i>
                                    <span class="nome-area"><?= $categoria ?></span>
                                </span>

                            <?php endforeach; ?>
                        </div>

                    </div>

                    <p class="curso-publicacao">
                        Publicado em: <?= $campo_cadastro; ?><br>
                        <?= $total_inscritos; ?> inscrições
                    </p>

                </div>

                <!-- DIREITA -->
                <div class="curso-hero-card">
                    <ul class="curso-detalhes">

                        <?php
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

                            $inicio = new DateTime($data_inicio);
                            $fim = $data_fim ? new DateTime($data_fim) : null;

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
							
                            // Mesmo mês e ano
                            if ($mi === $mf && $yi === $yf) {
                                return "$di a $df de {$meses[$mi]} de $yi";
                            }

                            // Mesmo ano, meses diferentes
                            if ($yi === $yf) {
                                return "$di de {$meses[$mi]} a $df de {$meses[$mf]} de $yi";
                            }

                            // Anos diferentes
                            return "$di de {$meses[$mi]} de $yi a $df de {$meses[$mf]} de $yf";
                        }
                        ?>

                        <?php foreach ($tabelaCurso as $row): ?>
						<?php 
						$agora = date('d/m/Y H:i:s');
						if($row->local != 'Gravado'){ ?>
							
                            <li>
                                <strong>Data:</strong> 
								<?= formatarDataEvento($row->data_inicio, $row->data_fim); ?>
                            </li>
                            <li>
                                <strong>Horário:</strong> <?= $campo_horario; ?> às <?=$campo_horario_final?>
                            </li>
						<?php } ?>
                            <li>
                                <strong>Carga horária:</strong> <?= $campo_horas; ?> horas
                            </li>

                            <?php if ($tipo != 2 && !empty($campo_local)): ?>
                                <li>
                                    <strong>Local:</strong> <?= $campo_local; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </ul>

                    <?php if ($inscricoes_abertas): ?>
                        <a href="<?= base_url('curso/inscricao/' . $campo_courseid); ?>" class="btn-inscricao grande">
                            QUERO ME INSCREVER
                        </a>
                    <?php else: ?>
                        <div class="inscricoes-encerradas">
                            <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                            inscrições Encerradas
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <style>
            /* ===============================
            CONTAINER
            =============================== */
            .container-inscricao {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 24px;
            }

            /* ===============================
            HERO
            =============================== */
            .curso-hero {
                padding: 70px 0 70px 0;
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

            /* ===============================
            BOTÃO VOLTAR
            =============================== */
            .btn-voltar {
                display: inline-flex;
                align-items: center;
                gap: 8px;

                margin-bottom: 52px;

                padding: 9px 20px;
                border-radius: 10px;

                background: #ffffff00;
                border: 1px solid #12455e;

                color: #12455e;
                font-size: 17px;
                font-weight: 700;
                text-decoration: none;

                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);

                transition:
                    background-color .25s ease,
                    color .25s ease,
                    border-color .25s ease,
                    box-shadow .25s ease;
            }

            .btn-voltar:hover {
                background: #0b4f63;
                color: #ffffff;
                border-color: #0b4f63;
                box-shadow: 0 10px 24px #0b4e6313;
            }

            /* ===============================
            TÍTULO
            =============================== */
            .curso-titulo {
                font-size: 41px;
                color: #e92d26;
                font-weight: 700;
                max-width: 680px;
                line-height: 1.25;
                margin-bottom: 30px;
            }

            /* ===============================
            PUBLICAÇÃO
            ============================== */
            .curso-publicacao {
                font-size: 16px;
                line-height: 1.6;
                font-weight: 700;
                color: #0a2d3f;
            }

            /* ===============================
            CARD LATERAL
            =============================== */
            .curso-hero-card {
                background: #F8FAFC;
                border-radius: 28px;
                margin-left: -10px;
                padding: 28px 43px 28px 33px;

                border: 1px solid rgba(23, 90, 120, 0.08);
                box-shadow:
                    0 4px 12px rgba(23, 90, 120, 0.08),
                    0 16px 40px rgba(0, 0, 0, 0.12),
                    0 0 0 1px rgba(255, 255, 255, 0.6) inset;

                transition: box-shadow .3s ease, transform .3s ease;
                margin: auto 0 auto 0;
            }


            .curso-detalhes {
                list-style: none;
                padding: 0;
                margin-bottom: 28px;

                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px 25px;
            }

            .curso-detalhes li {
                font-size: 23px;
                color: #12455e;
                margin: 0;
            }

            /* DATA - linha inteira */
            .curso-detalhes li:nth-child(1) {
                grid-column: 1 / -1;
            }

            /* HORÁRIO */
            .curso-detalhes li:nth-child(2) {
                grid-column: 1;
            }

            /* CARGA HORÁRIA */
            .curso-detalhes li:nth-child(3) {
                grid-column: 2;
                text-align: right;
                white-space: nowrap;
            }

            /* LOCAL - linha inteira */
            .curso-detalhes li:nth-child(4) {
                grid-column: 1 / -1;
            }

            /* ===============================
            BOTÃO INSCRIÇÃO
            =============================== */
            .btn-inscricao {
                display: block;
                text-align: center;
                padding: 8px 18px;
                border-radius: 12px;

                background-color: #e92d26;
                color: #ffffff;

                font-size: 26px;
                font-weight: 500;

                margin: 0 auto;
                width: fit-content;
                text-decoration: none;

                transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
            }

            .btn-inscricao:hover {
                background-color: #d3211f;
                box-shadow: 0 4px 12px rgba(233, 45, 38, 0.3);
                cursor: pointer;
            }

            .inscricoes-encerradas {
                width: fit-content;
                margin: 0 auto;
                padding: 12px 24px;
                border: 1px solid #d7dee3;
                border-radius: 12px;
                background: #f4f6f7;
                color: #60717b;
                font-size: 18px;
                font-weight: 700;
                text-align: center;
                line-height: 1.2;
            }

            /* ===============================
            BADGES
            =============================== */
            .curso-badges {
                display: flex;
                flex-direction: column;
                gap: 24px;
                margin-bottom: 24px;
            }

            /* LINHAS */
            .linha-topo,
            .linha-inferior {
                display: flex;
                flex-wrap: wrap;
                gap: 16px;
            }

            /* Linha inferior alinhada pela base */
            .linha-inferior {
                align-items: flex-end;
                margin-top: -10px;
            }

            /* BADGE BASE */
            .badge {
                font-size: 15px;
                padding: 12px 18px;
                border-radius: 10px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                color: #fff;
                font-weight: 700;
                white-space: nowrap;
            }

            /* BADGES AZUL / DESTAQUE */
            .badge.azul {
                background: #3f5bd9;
            }

            .badge.azul {
                font-size: 16px;
                padding: 14px 20px;
            }

            /* BADGES MODALIDADE */
            .badge.presencial {
                background: #e53845;
            }

            .badge.online {
                background: #009eb0;
            }

            .badge.evento {
                background: #64748b;
            }

			.badge.badge-dificuldade {
				background: #fff;
				border: 2px solid #3f5bd9;
				color: #3f5bd9;
			}


            /* LINHA INFERIOR */
            .linha-inferior .badge:first-child {
                font-size: 15px;
                padding: 12px 18px;
                border-radius: 10px;
            }

            .linha-inferior .badge:not(:first-child) {
                font-size: 13px;
                padding: 10px 14px;
                border-radius: 7px;
            }

            /* Ícones dentro de badges */
            .badge-area i {
                font-size: 15px;
            }

            .linha-inferior .badge:not(:first-child) i {
                font-size: 13px;
            }

            /* ===============================
            RESPONSIVO
            =============================== */
            @media (max-width: 768px) {

                .curso-hero {
                    padding: 30px 0 22px 0;
                }

                .curso-hero-grid {
                    grid-template-columns: 1fr;
                    gap: 10px;
                }

                .curso-titulo {
                    font-size: 22px;
                    line-height: 1.3;
                    max-width: 100%;
                    margin-bottom: 20px;
                }

                .curso-badges {
                    gap: 12px;
                    margin-bottom: 18px;
                }

                .linha-topo,
                .linha-inferior {
                    gap: 10px;
                    margin-top: 0;
                }

                .badge {
                    font-size: 12px;
                    padding: 8px 12px;
                    border-radius: 8px;
                }

                /* badge-modalidade menor no responsivo */
                .linha-topo .badge-modalidade {
                    padding: 4px 8px !important;
                    font-size: 12px;
                }

                /* Ajustes da linha-topo genérica */
                .linha-topo .badge {
                    font-size: 13px;
                    padding: 10px 18px;
                }

                .linha-inferior .badge:first-child {
                    font-size: 13px;
                    padding: 9px 14px;
                }

                .linha-inferior .badge:not(:first-child) {
                    font-size: 11px;
                    padding: 6px 10px;
                }

                .badge {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                }

                .curso-publicacao {
                    font-size: 13px;
                }

                .curso-hero-card {
                    margin-left: 0;
                    padding: 22px;
                    margin-bottom: 25px;
                    border-radius: 22px;
                }

                .curso-detalhes {
                    display: grid;
                    margin-bottom: 25px;
                    grid-template-columns: 1fr 1fr;
                    gap: 12px 16px;
                }

                .curso-detalhes li {
                    font-size: 16px;
                    line-height: 1.5;
                    margin-bottom: 0;
                }

                .curso-detalhes li:nth-child(1) {
                    grid-column: 1 / span 2;
                }

                .curso-detalhes li:nth-child(2) {
                    grid-column: 1;
                }

                .curso-detalhes li:nth-child(3) {
                    grid-column: 2;
                    text-align: right;
                    white-space: nowrap;
                }

                .curso-detalhes li:nth-child(4) {
                    grid-column: 1 / span 2;
                }

                .btn-inscricao {
                    font-size: 18px;
                    padding: 12px 22px;
                    margin-top: 19px;
                }

                .btn-voltar {
                    margin-bottom: 23px;
                    padding: 6px 14px;
                    font-size: 13px;
                }

            }
        </style>
    </section>

    <section class="curso-informacoes">
        <div class="container-informacoes">

            <h2 class="curso-info-titulo">
                Informações do Curso
            </h2>

            <div class="curso-info-card">

                <!-- COLUNA ESQUERDA -->
                <div class="curso-info-metodologia">
                    <h2>OBJETIVO</h2>
                    <?php
                    //$topicos = html_entity_decode($campo->topicos, ENT_QUOTES, 'UTF-8');
                    //echo $topicos;
                    echo $campo->descricao
                    ?>
                </div>

                <!-- DIVISOR -->
                <div class="curso-info-divider"></div>

                <!-- COLUNA DIREITA -->
                <div class="curso-info-programacao">
                    <h2>PROGRAMAÇÃO</h2>
						
						<?php 
							$ultimaData = null;
							
							
							// Mapa de dias da semana
							$diasSemana = [
								'Sunday' => 'Domingo',
								'Monday' => 'Segunda-feira',
								'Tuesday' => 'Terça-feira',
								'Wednesday' => 'Quarta-feira',
								'Thursday' => 'Quinta-feira',
								'Friday' => 'Sexta-feira',
								'Saturday' => 'Sábado'
							];

							foreach($programacao as $prog): 

								// Datas
								$timestamp = strtotime($prog->data_hora_inicial);
								$dataAtual = date('Y-m-d', $timestamp);
								$dataFormatada = date('d/m/Y', $timestamp);
								
								// Dia da semana
								$diaSemanaEn = date('l', $timestamp);
								$diaSemanaPt = $diasSemana[$diaSemanaEn];

								// Horas
								$horaInicio = date('H\hi', strtotime($prog->data_hora_inicial));
								$horaFinal  = $prog->hora_final 
									? date('H\hi', strtotime($prog->hora_final)) 
									: null;
							?>

								<div style="margin-bottom:15px;">

									<!-- DATA (só aparece se mudar) -->
									<?php if($dataAtual !== $ultimaData): ?>
										<div style="font-size:22px; color:#5f6b85; margin-bottom:5px;">
											<strong><?= $dataFormatada ?> (<?= $diaSemanaPt ?>)</strong>
										</div>
										<?php $ultimaData = $dataAtual; ?>
									<?php endif; ?>
									
									<!-- Data principal 
									<div style="font-size:20px; color:#0b3c5d;">
										<strong><?= $horaInicio ?></strong>
										
										<?php if($horaFinal): ?>
											às <strong><?= $horaFinal ?></strong>
										<?php endif; ?>
										
										- <?= $prog->palestra ?>
									</div>-->
									
									<!-- Linha principal -->
									<div style="font-size:20px; color:#0b3c5d;">
										<strong><?= $horaInicio ?></strong>
										
										<?php if($horaFinal): ?>
											às <strong><?= $horaFinal ?></strong>
										<?php endif; ?>
										
										- <?= $prog->palestra ?>
									</div>

									<!-- Palestrante -->
									<?php if(!empty($prog->descricao)): ?>

										<?php 
											$descricao = str_replace('Moderação:', '<br>Moderação:', $prog->descricao);
										?>

										<div style="margin-left:10px; font-style:italic; color:#5a6c7d;">
											<?= $descricao ?>
										</div>
									<?php endif; ?>

								</div>

							<?php endforeach; ?>

                </div>
            </div>
        </div>

        <style>
            /* ===============================
                CONTAINER
                =============================== */
            .container-informacoes {
                max-width: 1350px;
                margin: 0 auto;
                padding: 0 24px;
            }

            /* ===============================
                SEÇÃO
                =============================== */

            .curso-informacoes {
                background-color: #ffffffde;
                padding: 0 0 80px 0;
            }

            /* TÍTULO PRINCIPAL */

            .curso-info-titulo {
                text-align: center;
                font-size: 36px;
                font-weight: 700;
                color: #12455e;
                margin-bottom: 55px;
                line-height: 1.2;
            }

            /* CARD PRINCIPAL */

            .curso-info-card {
                background: #F8FAFC;
                border-radius: 28px;
                padding: 48px 56px;

                display: grid;
                grid-template-columns: 1fr auto 1fr;
                gap: 48px;

                border: 1px solid rgba(23, 90, 120, 0.08);

                box-shadow:
                    0 6px 18px rgba(23, 90, 120, 0.08),
                    0 20px 48px rgba(0, 0, 0, 0.12),
                    0 0 0 1px rgba(255, 255, 255, 0.6) inset;
            }

            /* COLUNAS */

            .curso-info-metodologia,
            .curso-info-programacao {
                font-size: 18px;
                line-height: 1.75;
                color: #12455e;
            }

            /* SUBTÍTULOS */

            .curso-info-metodologia h2,
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

            .curso-info-metodologia h2::after,
            .curso-info-programacao h2::after {
                content: "";
                display: block;
                width: 280px;
                height: 1px;
                background: #e92d26;
                border-radius: 3px;
                margin: 12px auto 0;
            }

            /* LISTA OBJETIVOS */

            .curso-info-metodologia ul {
                list-style: none;
                padding-left: 0;
            }

            .curso-info-metodologia li {
                position: relative;
                padding-left: 28px;
                margin-bottom: 26px;
                line-height: 1.5;
                font-size: 17px;
            }

            .curso-info-metodologia li::before {
                content: "";
                position: absolute;
                left: 5px;
                top: 50%;
                transform: translateY(-50%);
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: #12455e;
            }

            /* DIVISOR */

            .curso-info-divider {
                width: 1px;
                background: linear-gradient(to bottom, transparent, #ff3b30, transparent);
                border-radius: 2px;
            }

            /* ===============================
                RESPONSIVO
                =============================== */

            /* ===== Tablets grandes ===== */

            @media (max-width:1024px) {

                .curso-info-card {
                    grid-template-columns: 1fr;
                    gap: 40px;
                    padding: 40px 32px;
                    border-radius: 24px;
                }

                .curso-info-divider {
                    display: none;
                }

                .curso-info-metodologia h2,
                .curso-info-programacao h2 {
                    font-size: 18px;
                    margin-bottom: 20px;
                }

                .curso-info-metodologia,
                .curso-info-programacao {
                    font-size: 17px;
                    line-height: 1.6;
                }

                .curso-info-metodologia li {
                    font-size: 16px;
                    margin-bottom: 20px;
                }

                /* HERO */

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

            /* ===== Tablets / Mobile médio ===== */

            @media (max-width:768px) {

                .curso-informacoes {
                    padding: 0 0 50px 0;
                }

                .curso-info-titulo {
                    font-size: 24px;
                    margin-bottom: 33px;
                }

                .curso-info-card {
                    padding: 32px 22px;
                    gap: 30px;
                }

                .curso-info-metodologia h2,
                .curso-info-programacao h2 {
                    font-size: 16px;
                    margin-bottom: 16px;
                }

                .curso-info-metodologia,
                .curso-info-programacao {
                    font-size: 15px;
                    line-height: 1.6;
                }

                .curso-info-metodologia li {
                    font-size: 14px;
                    margin-bottom: 16px;
                }

                /* HERO */

                .curso-hero {
                    padding: 35px 0 45px !important;
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

            /* ===== Mobile ===== */

            @media (max-width:480px) {

                .curso-info-titulo {
                    font-size: 20px;
                    margin-bottom: 25px;
                }

                .curso-info-card {
                    padding: 24px 16px;
                    gap: 20px;
                }

                .curso-info-metodologia h2,
                .curso-info-programacao h2 {
                    font-size: 14px;
                    margin-bottom: 14px;
                }

                .curso-info-metodologia,
                .curso-info-programacao {
                    font-size: 14px;
                    line-height: 1.5;
                }

                .curso-info-programacao,
                .curso-info-metodologia {
                    padding: 0 15px;
                }

                .curso-info-metodologia li {
                    font-size: 13px;
                    margin-bottom: 14px;
                }

                /* HERO */

                .curso-hero {
                    padding: 10px 0 25px;
                }

                .curso-titulo {
                    font-size: 22px;
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

            /* ===== Mobile muito pequeno ===== */

            @media (max-width:360px) {

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

    <section class="curso-palestrantes">
        <div class="container-palestrantes">

            <h2 class="curso-info-titulo">Palestrantes</h2>

            <div class="palestrantes-grid">
                <?php if (!empty($palestrantes)): ?>
                    <?php foreach ($palestrantes as $p): ?>
						<?php
						$this->load->helper('url');
						$foto = !empty($p->foto) ? $p->foto : base_url('assets/palestrantes/avatar_palestrante.png');
						?>

                        <div class="palestrante-card"
                            data-nome="<?= htmlspecialchars($p->nome) ?>"
                            data-descricao="<?= htmlspecialchars(strip_tags($p->{'curriculo'}), ENT_QUOTES, 'UTF-8') ?>"
                            data-foto="<?= htmlspecialchars($foto ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            data-linkedin="<?= htmlspecialchars($p->link ?? '', ENT_QUOTES, 'UTF-8') ?>">

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


                                <button type="button" class="btn-ver-mais">Ver mais</button>
                            </div>

                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="modal-palestrante" id="modalPalestrante">
            <div class="modal-conteudo" role="dialog" aria-modal="true" aria-labelledby="modalNome">
                <button type="button" class="modal-fechar" aria-label="Fechar">&times;</button>
                <img id="modalFoto" class="modal-palestrante-foto" src="" alt="" onerror="this.onerror=null;this.src='<?=base_url('assets/palestrantes/avatar_palestrante.png')?>';">
                <h3 id="modalNome"></h3>
                <h4>Currículo</h4>
                <p id="modalDescricao"></p>
                <a id="modalLinkedin" class="btn-linkedin-palestrante" href="#" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-box-arrow-up-right"></i> Acessar perfil
                </a>
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
                align-items: center;
                justify-content: center;
				padding: 24px;

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
                max-width: 760px;
				max-height: calc(100vh - 48px);
				overflow-y: auto;

                border-radius: 24px;
                padding: 36px 40px 32px;
				position: relative;
				text-align: center;

				transform: translateY(20px) scale(.97);
                transition: transform .45s cubic-bezier(.22, 1, .36, 1);
            }

            /* ANIMAÇÃO AO ABRIR */
            .modal-palestrante.ativo .modal-conteudo {
				transform: translateY(0) scale(1);
            }

			.modal-palestrante-foto {
				width: 230px;
				height: 230px;
				object-fit: cover;
				border-radius: 50%;
				border: 4px solid #fff;
				box-shadow: 0 8px 26px rgba(18, 69, 94, .22);
				margin: 0 auto 22px;
				display: block;
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

			.modal-conteudo h4 {
				font-size: 15px;
				font-weight: 700;
				color: #3f5bd9;
				text-transform: uppercase;
				margin: 24px 0 8px;
			}

			.btn-linkedin-palestrante {
				display: inline-flex;
				align-items: center;
				gap: 8px;
				background: #0a66c2;
				color: #fff;
				padding: 11px 20px;
				border-radius: 9px;
				font-weight: 700;
				text-decoration: none;
				margin-top: 10px;
			}

			.btn-linkedin-palestrante:hover { background: #084f96; color: #fff; }
			.btn-linkedin-palestrante.oculto { display: none; }

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

                /* No celular, os detalhes ficam no modal */
                .palestrante-resumo {
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

				.btn-ver-mais { margin-top: 8px; }

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
                    border-radius: 22px;
                    padding: 24px 20px 18px;
                }

				.modal-palestrante-foto { width: 160px; height: 160px; }

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

</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const cards = document.querySelectorAll('.palestrante-card');
        const ALTURA_FECHADO = '7.6em';

        /* ativa animações após carregar */
        requestAnimationFrame(() => {
            document.body.classList.add('animado');
        });

        function fecharCard(card) {
            const resumo = card.querySelector('.palestrante-resumo');
            const btn = card.querySelector('.btn-ver-mais');

            resumo.style.maxHeight = resumo.scrollHeight + 'px';

            requestAnimationFrame(() => {
                resumo.style.maxHeight = ALTURA_FECHADO;
            });

            card.classList.remove('aberto');
            if (btn) btn.textContent = 'ver mais';
        }

        function abrirCard(card) {
            const resumo = card.querySelector('.palestrante-resumo');
            const btn = card.querySelector('.btn-ver-mais');

            resumo.style.maxHeight = resumo.scrollHeight + 'px';
            card.classList.add('aberto');

            if (btn) btn.textContent = 'ver menos';
        }

		/* A abertura dos detalhes ocorre somente pelo botão Ver mais. */
    });
</script>

<script>
    const modal = document.getElementById('modalPalestrante');
    const modalNome = document.getElementById('modalNome');
    const modalDescricao = document.getElementById('modalDescricao');
	const modalFoto = document.getElementById('modalFoto');
	const modalLinkedin = document.getElementById('modalLinkedin');
    const fechar = document.querySelector('.modal-fechar');

    document.querySelectorAll('.palestrante-card').forEach(card => {
		const botaoVerMais = card.querySelector('.btn-ver-mais');
		if (!botaoVerMais) return;

		botaoVerMais.addEventListener('click', (event) => {
			event.preventDefault();
			event.stopPropagation();

			modalNome.textContent = card.dataset.nome || '';
			modalDescricao.textContent = card.dataset.descricao || 'Currículo não informado.';
			modalFoto.src = card.dataset.foto || '<?=base_url('assets/palestrantes/avatar_palestrante.png')?>';
			modalFoto.alt = card.dataset.nome || 'Foto do palestrante';

			const linkedin = (card.dataset.linkedin || '').trim();
			if (linkedin) {
				modalLinkedin.href = /^https?:\/\//i.test(linkedin) ? linkedin : 'https://' + linkedin;
				modalLinkedin.classList.remove('oculto');
			} else {
				modalLinkedin.href = '#';
				modalLinkedin.classList.add('oculto');
			}

			modal.classList.add('ativo');
			document.body.style.overflow = 'hidden';
		});
    });

    function fecharModal() {
        modal.classList.remove('ativo');
		document.body.style.overflow = '';
    }

    fechar.addEventListener('click', fecharModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            fecharModal();
        }
    });

	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && modal.classList.contains('ativo')) fecharModal();
	});
</script>
