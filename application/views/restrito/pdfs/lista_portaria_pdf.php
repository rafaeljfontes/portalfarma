<?php
$tituloCurso = isset($curso->titulo) ? trim($curso->titulo) : 'Curso';
$dataCurso = !empty($curso->data_inicio)
	? date('d/m/Y', strtotime($curso->data_inicio))
	: 'Data não informada';
?>
<style type="text/css">
	* { font-family: Arial, sans-serif; }
	.page-title {
		margin: 0 0 8pt;
		color: #153f5b;
		font-size: 22px;
		font-weight: bold;
		line-height: 1.08;
		text-align: center;
	}
	.course-date {
		margin: 0 0 24pt;
		color: #333333;
		font-size: 16px;
		line-height: 1;
		text-align: center;
	}
	.participants {
		width: 100%;
		border-collapse: collapse;
	}
	.participants th {
		padding: 6px 5px;
		border: 1px solid #555555;
		background: #e8f0f5;
		color: #153f5b;
		font-size: 16px;
		font-weight: bold;
		text-align: center;
	}
	.participants td {
		padding: 5px;
		border: 1px solid #777777;
		color: #111111;
		font-size: 16px;
		line-height: 1.05;
	}
	.sequence {
		width: 9%;
		text-align: center;
	}
	.participant-name {
		width: 79%;
		text-align: left;
	}
	.attendance {
		width: 12%;
		text-align: center;
	}
	.empty {
		padding: 20pt !important;
		color: #666666 !important;
		text-align: center;
	}
	.footer-table {
		width: 100%;
		border-top: 1px solid #9aa7b1;
		border-collapse: collapse;
	}
	.footer-table td {
		padding-top: 6px;
		color: #4b5563;
		font-size: 9px;
	}
	.footer-course { width: 60%; text-align: left; }
	.footer-date { width: 20%; text-align: center; }
	.footer-page { width: 20%; text-align: right; }
</style>

<page orientation="P" format="A4" backtop="24pt" backright="28pt" backbottom="42pt" backleft="28pt">
	<page_footer>
		<table class="footer-table">
			<tr>
				<td class="footer-course"><?=htmlspecialchars($tituloCurso, ENT_QUOTES, 'UTF-8')?></td>
				<td class="footer-date"><?=htmlspecialchars($dataCurso, ENT_QUOTES, 'UTF-8')?></td>
				<td class="footer-page">Página [[page_cu]] de [[page_nb]]</td>
			</tr>
		</table>
	</page_footer>

	<h1 class="page-title"><?=htmlspecialchars($tituloCurso, ENT_QUOTES, 'UTF-8')?></h1>
	<div class="course-date"><?=htmlspecialchars($dataCurso, ENT_QUOTES, 'UTF-8')?></div>

	<table class="participants">
		<thead>
			<tr>
				<th class="sequence">Nº</th>
				<th class="participant-name">Participante</th>
				<th class="attendance">Presença</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($inscritos)): ?>
				<?php foreach ($inscritos as $indice => $participante): ?>
					<tr>
						<td class="sequence"><?=($indice + 1)?></td>
						<td class="participant-name"><?=htmlspecialchars(mb_strtoupper($participante->nome_completo, 'UTF-8'), ENT_QUOTES, 'UTF-8')?></td>
						<td class="attendance"><span style="font-family:dejavusans; font-size:24pt;">&#9744;</span></td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="3" class="empty">Nenhum participante encontrado para este curso.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

</page>
