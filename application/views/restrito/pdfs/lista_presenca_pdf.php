<?php
// A4 menos as margens reais (margens padrão + margens da tag page).
$larguraUtil = ($orientacao ?? 'P') === 'L' ? 277 : 186;
$larguraColunas = $larguraUtil - 1; // reserva para as bordas; sem padding horizontal
$larguraNome = floor(($larguraColunas - 8) * 0.44);
$larguraAssinatura = $larguraColunas - 8 - $larguraNome;
$larguraAuxiliar = ($larguraColunas - 8) / 2;
$cursoCabecalho = $curso[0] ?? null;
$exibirNomeIes = (string) ($cursoCabecalho->courseid ?? '') === '111';
$larguraAssinaturaInscrito = $exibirNomeIes ? floor($larguraAssinatura / 2) : $larguraAssinatura;
$larguraNomeIes = $larguraAssinatura - $larguraAssinaturaInscrito;
$tituloCabecalho = $cursoCabecalho ? $cursoCabecalho->titulo : '';
$dataCabecalho = $cursoCabecalho ? date('d/m/Y', strtotime($cursoCabecalho->data_inicio)) : '';
$tiposRodape = [1=>'Capacifar Presencial', 2=>'Capacifar On-line', 3=>'Uso Racional de Medicamentos',
    4=>'Fiscalização Humanizada', 5=>'Capacifar Universitário', 7=>'Seminário de Vigilância e Saúde'];
$tipoRodape = $tiposRodape[(int) ($cursoCabecalho->tipo_evento ?? 0)] ?? 'Evento';
?>
<page hideheader="1" backtop="25mm" backbottom="12mm" backleft="7mm" backright="<?= ($orientacao ?? 'P') === 'L' ? '8mm' : '7mm' ?>">
	<style type="text/css">
        page { color: #333; font-size: 11pt; }
        
        .header-table { width: <?= $larguraUtil - 1 ?>mm; border-bottom: 2px solid #069; padding-bottom: 15px; margin-bottom: 20px; }
        .col-logo { width: 45%; vertical-align: middle; }
        .course-img { width: 80%; max-height: 650px; border-radius: 5px; }
        .col-title { width: <?= $larguraUtil - 1 ?>mm; padding: 0; vertical-align: middle; }
        .course-title { font-size: 18pt; color: #069; font-weight: bold; }
        
        /* Ajuste na info-box para centralização total */
        .info-box { 
            background: #f8f9fa; 
            border: 0.3mm solid #dee2e6;
            padding: 4mm 0;
            border-radius: 8px; 
            margin-bottom: 20px; 
            width: <?= $larguraUtil - 2 ?>mm;
        }
        
        /* Tabela de inscritos respeitando os 7mm da margem direita */
        .table-inscritos {
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-inscritos th {
            background: #069;
            color: white;
            padding: 2mm 0;
            text-align: left;
            font-size: 10pt;
        }

        .table-inscritos td {
            border-bottom: 1px solid #eee;
            padding: 3mm 0;
            font-size: 10pt;
        }

        .signature-line {
            border-bottom: 1px solid #999;
            width: <?= $larguraAssinatura - 2 ?>mm;
            height: 20px;
        }
		
		.text-line {
            border-bottom: 1px solid #999;
            width: <?= $larguraAuxiliar - 2 ?>mm;
            height: 20px;
        }
		
		.text-muted {
			color: #adb5bd !important;
		}
		
		.text-presencial {
			color: #F43F3F !important;
		}
		
		.text-urm {
			color: #00579c !important;
		}
		
		.text-fiscalizacaohumanizada {
			color: #02795f !important;
		}
		
		.text-universitario { 
			color: #004761 !important;
		}
		
		.text-seminario { 
			color: #105e8f !important;
		}
		
		tr {
			page-break-inside: avoid;
		}
		.table-inscritos {
			page-break-after: auto;
		}
		
		.footer-tabela {
			width: 100%;
			border-top: 0.5pt solid #ccc; /* Linha fina para separar o rodapé */
			padding-top: 5px;
		}
		.footer-texto {
			font-size: 8pt;
			color: #777;
			width: 100%;
		}
		.texto-direita { text-align: right; width: 30%; }
		.texto-esquerda { text-align: left; width: 70%; }
		
	</style>
	<page_header>
		<table cellpadding="0" cellspacing="0" style="width: <?= $larguraUtil - 1 ?>mm; border-bottom: 0.3mm solid #069; font-size: 10pt;">
			<tr>
				<td style="width: <?= ($larguraUtil - 1) * 0.65 ?>mm; padding: 0 0 3mm; vertical-align: top; text-align: left;">
					<strong style="color: #069;">Capacifar Presencial</strong><br>
					<?= htmlspecialchars($tituloCabecalho, ENT_QUOTES, 'UTF-8') ?>
				</td>
				<td style="width: <?= ($larguraUtil - 1) * 0.35 ?>mm; padding: 0 0 3mm; vertical-align: top; text-align: right;">
					<strong>Data do evento:</strong> <?= htmlspecialchars($dataCabecalho, ENT_QUOTES, 'UTF-8') ?>
				</td>
			</tr>
		</table>
	</page_header>
	<page_footer>
		<table cellpadding="0" cellspacing="0" style="width: <?= $larguraUtil - 1 ?>mm; border-top: 0.5pt solid #ccc; font-size: 8pt; color: #555;">
			<tr>
				<td style="width: <?= ($larguraUtil - 1) * 0.5 ?>mm; padding: 2mm 0 0; text-align: left;"><strong>Curso:</strong> <?= htmlspecialchars(mb_strtoupper($tipoRodape), ENT_QUOTES, 'UTF-8') ?></td>
				<td style="width: <?= ($larguraUtil - 1) * 0.3 ?>mm; padding: 2mm 0 0; text-align: center;"><strong>Data:</strong> <?= htmlspecialchars($cursoCabecalho->data_inicio ?? '', ENT_QUOTES, 'UTF-8') ?></td>
				<td style="width: <?= ($larguraUtil - 1) * 0.2 ?>mm; padding: 2mm 0 0; text-align: right;">Página [[page_cu]] de [[page_nb]]</td>
			</tr>
		</table>
	</page_footer>
<?php
	
	//var_dump($curso);exit;
	
	/*foreach ($curso as $campo){
		
		$id = $campo->id;
		
	}*/
?>

									
	<table class="header-table" cellpadding="0" cellspacing="0">
<?php foreach($curso as $linha):   
		
		$data_inicio 	= $linha->data_inicio;
		$data_fim 		= $linha->data_fim;
		
		/* tipo evento */
		switch ($linha->tipo_evento) {
			case 1:
				$campo_evento = "Capacifar Presencial";
				$classe_card = '#F43F3F';
				break;
			case 2:
				$campo_evento = "Capacifar On-line";
				$classe_card = '#0EA5B7';
				break;
			case 3:
				$campo_evento = "Uso Racional de Medicamentos";
				$classe_card = '#00579c';
				break;
			case 4:
				$campo_evento = "Fiscalização Humanizada";
				$classe_card = '#02795f';
				break;
			case 5:
				$campo_evento = "Capacifar Universitário";
				$classe_card = '#004761';
				break;
			case 7:
				$campo_evento = "Seminário de Vigilância e Saúde";
				$classe_card = '#105e8f';
				break;
			default:
				$campo_evento = "Evento";
		}
		?>
		<tr>
			<!--<td class="col-logo">
                <img src="https://www.crfmg.org.br/portalfarma/uploads/cursos/<?=$linha->nome_curto;?>.png" class="course-img">
            </td>-->
			<td class="col-title">
				<div class="course-title text-center" style="color:<?=$classe_card;?>;"><?= mb_strtoupper($campo_evento) ?></div>
				<div class="course-title text-center">LISTA DE PRESENÇA:</div>
				<div style="font-size: 13pt; color: #555; margin-top: 5px;">
<?= mb_strtoupper($linha->titulo) ?>
				</div>
			</td>
		</tr>
<?php endforeach; ?>
	</table>

	<table cellpadding="0" cellspacing="0" style="width: <?= $larguraUtil - 2 ?>mm;"><tr><td class="info-box">
		<div style="font-weight: bold; color: #069; margin-bottom: 5px;">DATA DO EVENTO</div>
		<div style="font-size: 12pt;"><?= date('d/m/Y', strtotime($data_inicio)) ?> de <?= date('H:s', strtotime($data_inicio)) ?> às <?= date('H:s', strtotime($data_fim)) ?></div>
	</td></tr></table>
	<div style="height: 3px; line-height: 3px; font-size: 0;"></div>
	<table cellpadding="0" cellspacing="0" style="width: <?= $larguraUtil - 2 ?>mm;"><tr><td class="info-box" style="text-align: left;">
		<div style="font-weight: bold; color: #069; margin-bottom: 8px;">Palestrantes:</div>
<?php foreach($palestrantes as $item): ?>
			<div style="padding-bottom: 15px; page-break-inside: avoid;">
				<table cellpadding="0" cellspacing="0" style="width: <?= $larguraNome + $larguraAssinatura ?>mm;">
					<tr>
						<td style="width: <?= $larguraNome ?>mm; padding: 0; vertical-align: middle; font-weight: bold;"><?= htmlspecialchars(mb_strtoupper($item->nome), ENT_QUOTES, 'UTF-8') ?></td>
						<td style="width: <?= $larguraAssinatura ?>mm; padding: 0; vertical-align: middle;"><div class="signature-line" style="width: <?= $larguraAssinatura - 2 ?>mm; height: 20px;"></div></td>
					</tr>
				</table>
			</div>
<?php endforeach; ?>
	</td></tr></table>
	<table class="table-inscritos" cellpadding="0" cellspacing="0" style="width: <?= $larguraColunas ?>mm;">
		<thead>
			<tr>
				<th style="width: 8mm;">#</th>
				<th style="width: <?= $larguraNome ?>mm;">Participante</th>
				<th style="width: <?= $larguraAssinaturaInscrito ?>mm;">Assinatura</th>
				<?php if ($exibirNomeIes): ?><th style="width: <?= $larguraNomeIes ?>mm;">Nome IES</th><?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($inscritos as $i => $item):	?>
			<tr>
				<td style="width: 8mm;"><?= $i + 1 ?></td>
				<td style="width: <?= $larguraNome ?>mm; font-weight: bold;"><?= mb_strtoupper($item->nome) ?>
					<br>
						<small class="text-muted" style="color:#a6a8ab;"><?php echo $item->ocupacao; ?></small>
				</td>
				
				<td style="width: <?= $larguraAssinaturaInscrito ?>mm;"><div class="signature-line" style="width: <?= $larguraAssinaturaInscrito - 2 ?>mm;"></div></td>
				<?php if ($exibirNomeIes): ?><td style="width: <?= $larguraNomeIes ?>mm;"><div class="signature-line" style="width: <?= $larguraNomeIes - 2 ?>mm;"></div></td><?php endif; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div style="page-break-before: always;"></div>
	
	<?php
		$contador = 1;
	?>
	<h2><div class="course-title text-center">LISTA AUXILIAR DE PRESENÇA</div></h2>
	<p>Faça sua inscrição no curso dentro do PortalFarma ( www.crfmg.org.br/portalfarma ) e coloque seu nome abaixo para marcarmos sua presença</p>
	<table class="table-inscritos" cellpadding="0" cellspacing="0" style="width: <?= $larguraColunas ?>mm;">
		<thead>
			<tr>
				<th style="width: 8mm;">#</th>
				<th style="width: <?= $larguraAuxiliar ?>mm;">Nome</th>
				<th style="width: <?= $larguraAuxiliar ?>mm;">EMAIL</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($contador <= 23):	?>
			<tr>
				<td><?=$contador;?></td>
				<td><div class="text-line"></div></td>
				<td><div class="text-line"></div></td>
			</tr>
			<?php  
			$contador++;
				endwhile; ?>
		</tbody>
	</table>
	
</page>
