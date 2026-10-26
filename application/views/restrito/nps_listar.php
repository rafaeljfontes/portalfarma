<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/plugins/select2/select2.bundle.css')?>">
<script src="<?=base_url('assets/plugins/select2/select2.bundle.js')?>"></script>
<style>
/* Container e Label */
.custom-select-container {
    max-width: 600px; /* Evita que o select fique esticado demais em telas grandes */
    margin: 20px 0;
}
.uppercase-tracking {
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.75rem;
}

/* Customização do Select */
.custom-select {
    border: 2px solid #dee2e6 !important;
    border-radius: 10px !important;
    padding: 12px 20px !important;
    font-size: 0.95rem !important;
    color: #495057;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease-in-out;
    cursor: pointer;
	height: calc(2.5em + .75rem + 2px);
}

/* Efeito de Foco (Focus) */
.custom-select:focus {
    border-color: #0d6efd !important; /* Cor primária do Bootstrap */
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15) !important;
    color: #212529;
}

/* Melhoria visual para as opções (Funciona melhor no Chrome/Edge) */
.custom-select option {
    padding: 12px;
    font-size: 0.95rem;
    color: #212529;
}

.nps-course-select + .select2-container { width: 100% !important; }
.nps-course-select + .select2-container .select2-selection--single {
    min-height: 48px;
    border: 1px solid #d0d5dd;
    border-radius: 8px;
    background: #fff;
}
.nps-course-select + .select2-container .select2-selection__rendered {
    padding: 10px 42px 10px 14px;
    color: #344054;
    line-height: 26px;
}
.nps-course-select + .select2-container .select2-selection__arrow { height: 46px; right: 8px; }
.select2-container--open .select2-dropdown { border-color: #b2ccff; box-shadow: 0 8px 24px rgba(16,24,40,.12); }
.select2-container--default .select2-search--dropdown .select2-search__field { padding: 9px 12px; border: 1px solid #d0d5dd; border-radius: 6px; outline: none; }

</style>
<div id="nps-relatorio" class="container">
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap nps-screen-only">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-file-signature text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Análise de Satisfação (NPS)</h4>
		</div>
        <button type="button" id="btn-exportar-pdf" class="btn btn-danger" disabled>
            <i class="fas fa-file-pdf me-1"></i> Exportar em PDF
        </button>
	</div>
	
	
	
	<div class="alert alert-info d-flex justify-content-between align-items-center gap-2 small nps-screen-only">
        <label for="select-curso" class="form-label small text-muted fw-bold mb-2 uppercase-tracking">
			<i class="bi bi-mortarboard-fill me-1"></i> Selecione o Curso para Análise NPS
		</label>
		<select id="select-curso" class="form-select form-select-lg custom-select nps-course-select">
			<option value="">Digite o nome do curso para pesquisar</option>
			<?php if(!empty($cursos)): ?>
				<?php foreach($cursos as $c): ?>
					<option value="<?= $c->courseid; ?>" <?=isset($courseidSelecionado) && (string) $courseidSelecionado === (string) $c->courseid ? 'selected' : ''?>><?= $c->courseid; ?> - <?= mb_strtoupper($c->titulo); ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
    </div>

    <div id="nps-loading" class="text-center my-5 d-none">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="text-muted mt-2">Processando cálculos matemáticos...</p>
    </div>

    <div id="container-resultado-nps" class="d-none">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="card h-100 border-0 rounded-4 shadow-sm text-center p-4 bg-white">
                    <span class="text-muted text-uppercase fw-bold small">Score Geral NPS</span>
                    <h1 id="txt-score-nps" class="display-1 fw-black my-2 text-dark">0</h1>
                    <span id="badge-zona-nps" class="badge fs-6 py-2 px-3 rounded-pill">Zona</span>
                    <hr class="my-3">
                    <small class="text-muted">Total de respostas: <strong id="txt-total-respostas">0</strong></small>
					<hr class="my-3">
                    <small class="text-muted">Total de Inscritos: <strong id="txt-total-inscritos">0</strong></small>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card h-100 border-0 rounded-4 shadow-sm p-4 bg-white">
                    <h5 class="fw-bold mb-3 text-secondary">Distribuição dos Tipos de Alunos</h5>
                    <div class="chart-container position-relative m-auto" style="height:220px; width:220px;">
                        <canvas id="chartNps"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 border-top border-4 border-success rounded-4 shadow-sm p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success fw-bold mb-0">Promotores (Notas 9 e 10)</h6>
                            <h3 id="txt-count-promotores" class="fw-bold mt-2 mb-0">0</h3>
                        </div>
                        <span id="txt-pct-promotores" class="fs-4 fw-bold text-success">0%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 border-top border-4 border-warning rounded-4 shadow-sm p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-warning fw-bold mb-0">Neutros (Notas 7 e 8)</h6>
                            <h3 id="txt-count-neutros" class="fw-bold mt-2 mb-0">0</h3>
                        </div>
                        <span id="txt-pct-neutros" class="fs-4 fw-bold text-warning">0%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 border-top border-4 border-danger rounded-4 shadow-sm p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-danger fw-bold mb-0">Detratores (Notas 0 a 6)</h6>
                            <h3 id="txt-count-detratores" class="fw-bold mt-2 mb-0">0</h3>
                        </div>
                        <span id="txt-pct-detratores" class="fs-4 fw-bold text-danger">0%</span>
                    </div>
                </div>
            </div>
        </div>
		
		<!-- Feedbacks e Comentários Detalhados -->
		<div class="mt-4">
			<div class="card border-0 rounded-4 shadow-sm p-3 bg-white mb-3" id="periodo-curso-nps">
				<div class="d-flex flex-wrap gap-4 align-items-center" style="font-size: 1.25rem;">
					<span><i class="bi bi-calendar-event me-2 text-primary" aria-hidden="true"></i><strong>Início:</strong> <span id="data-inicio-curso-nps">-</span></span>
					<span><i class="bi bi-calendar-check me-2 text-primary" aria-hidden="true"></i><strong>Término:</strong> <span id="data-fim-curso-nps">-</span></span>
				</div>
			</div>
			<h5>Feedbacks e Comentários Detalhados</h5>
			<div class="btn-group mb-3" role="group" aria-label="Filtrar feedbacks por período">
				<button type="button" class="btn btn-primary filtro-feedback-nps active" data-filtro="assincrono">
					Assíncronos <span class="badge bg-light text-primary ms-1" id="total-assincronos">0</span>
				</button>
				<button type="button" class="btn btn-outline-primary filtro-feedback-nps" data-filtro="nao_assincrono">
					Não assíncronos <span class="badge bg-light text-primary ms-1" id="total-nao-assincronos">0</span>
				</button>
			</div>
			<div class="table-responsive">
				<table id="nps-feedback-table" class="table table-bordered table-striped align-middle" style="min-width: 1000px;">
					<thead  class="bg-primary text-white text-center">
						<tr>
							<th style="width: 70px;">Nota</th>
							<th>Motivo da Nota</th>
							<th>O que mais agradou</th>
							<th>O que pode melhorar</th>
							<th>Participaria de novo?</th>
							<th>Comentário Adicional</th>
							<th style="min-width: 155px;">Data de cadastro</th>
						</tr>
					</thead>
					<tbody id="lista-feedbacks-nps">
						<!-- O JavaScript vai preencher as linhas (tr) aqui dentro -->
					</tbody>
				</table>
			</div>
		</div>

    </div>
</div>

<script>
$(document).ready(function() {
    let meuGrafico = null;
	let respostasNps = [];
	let filtroFeedbackAtivo = 'assincrono';

	function escaparHtml(valor) {
		return $('<div>').text(valor == null ? '-' : valor).html();
	}

	function renderizarFeedbacks() {
		const containerRespostas = $('#lista-feedbacks-nps');
		const respostasFiltradas = respostasNps.filter(function(resp) {
			return resp.tipo === filtroFeedbackAtivo;
		});

		containerRespostas.empty();
		if (respostasFiltradas.length === 0) {
			const descricao = filtroFeedbackAtivo === 'assincrono' ? 'assíncrono' : 'não assíncrono';
			containerRespostas.html('<tr><td colspan="7" class="text-center text-muted fst-italic">Nenhum feedback ' + descricao + ' foi encontrado para este curso.</td></tr>');
			return;
		}

		$.each(respostasFiltradas, function(index, resp) {
			containerRespostas.append(`
				<tr>
					<td class="text-center fw-bold text-white bg-${resp.classe}">${escaparHtml(resp.nota)}</td>
					<td class="text-muted small">${escaparHtml(resp.respA)}</td>
					<td class="text-muted small">${escaparHtml(resp.respB)}</td>
					<td class="text-muted small">${escaparHtml(resp.respC)}</td>
					<td class="text-muted small">${escaparHtml(resp.respD)}</td>
					<td class="text-muted small">${escaparHtml(resp.respE)}</td>
					<td class="text-muted small text-nowrap"><i class="bi bi-clock me-1" aria-hidden="true"></i>${escaparHtml(resp.data_cadastro)}</td>
				</tr>
			`);
		});
	}

	$('.filtro-feedback-nps').on('click', function() {
		filtroFeedbackAtivo = $(this).data('filtro');
		$('.filtro-feedback-nps').removeClass('btn-primary active').addClass('btn-outline-primary');
		$(this).removeClass('btn-outline-primary').addClass('btn-primary active');
		renderizarFeedbacks();
	});

	function normalizarBusca(texto) {
		return (texto || '').toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
	}

	if ($.fn.select2) {
		$('#select-curso').select2({
			placeholder: 'Digite o nome do curso para pesquisar',
			allowClear: true,
			width: '100%',
			matcher: function(params, data) {
				const busca = normalizarBusca(params.term);
				if (!busca) return data;
				const nomeCurso = normalizarBusca(data.text);
				return busca.split(/\s+/).filter(Boolean).every(function(palavra) {
					return nomeCurso.indexOf(palavra) !== -1;
				}) ? data : null;
			}
		});
	}

	$('#select-curso').on('change', function() {
        let courseid = $(this).val();

        if(courseid === '') {
            $('#container-resultado-nps').addClass('d-none');
            $('#btn-exportar-pdf').prop('disabled', true);
            return;
        }

        $('#nps-loading').removeClass('d-none');
        $('#container-resultado-nps').addClass('d-none');
        $('#btn-exportar-pdf').prop('disabled', true);

        $.ajax({
            url: '<?= base_url("nps/busca_nps"); ?>',
            type: 'POST',
            data: { courseid: courseid },
            dataType: 'json',
            success: function(response) {
                $('#nps-loading').addClass('d-none');
				
				// ATENÇÃO: Caso entre no bloco de erro/vazio, também podemos atualizar os inscritos se o PHP mandar
				if(response.status === 'empty') {
					$('#txt-total-inscritos').text(response.total_inscritos);
					Swal.fire({
						title: 'Nenhuma avaliação encontrada',
						text: response.mensagem || 'Nenhuma avaliação encontrada para este curso.',
						icon: 'info',
						confirmButtonText: '<i class="bi bi-arrow-left me-1"></i> Voltar à tela anterior',
						confirmButtonColor: '#465fff',
						allowOutsideClick: false
					}).then(function () {
						if (window.history.length > 1) {
							window.history.back();
						} else {
							window.location.href = '<?=base_url('restrito/capacifar/listar')?>';
						}
					});
					return;
				}

                if(response.status === 'success') {
                    let dados = response.metricas;
					$('#data-inicio-curso-nps').text(response.periodo_curso?.inicio || '-');
					$('#data-fim-curso-nps').text(response.periodo_curso?.fim || '-');

                    // 1. Atualiza os Textos e Notas do Dashboard
                    $('#txt-score-nps').text(dados.score);
                    $('#txt-total-respostas').text(dados.total);
					$('#txt-total-inscritos').text(dados.inscritos);
                    
                    $('#badge-zona-nps')
                        .text(dados.zona)
                        .css('background-color', dados.zona_cor);

                    $('#txt-count-promotores').text(dados.promotores);
                    $('#txt-pct-promotores').text(dados.pct_prom + '%');

                    $('#txt-count-neutros').text(dados.neutros);
                    $('#txt-pct-neutros').text(dados.pct_neu + '%');

                    $('#txt-count-detratores').text(dados.detratores);
                    $('#txt-pct-detratores').text(dados.pct_det + '%');

                    // ==========================================
					// RENDERIZA A TABELA DE RESPOSTAS (A, B, C, D, E)
					// ==========================================
					respostasNps = Array.isArray(response.respostas) ? response.respostas : [];
					const totalAssincronos = respostasNps.filter(resp => resp.tipo === 'assincrono').length;
					const totalNaoAssincronos = respostasNps.length - totalAssincronos;
					$('#total-assincronos').text(totalAssincronos);
					$('#total-nao-assincronos').text(totalNaoAssincronos);
					filtroFeedbackAtivo = 'assincrono';
					$('.filtro-feedback-nps').removeClass('btn-primary active').addClass('btn-outline-primary');
					$('.filtro-feedback-nps[data-filtro="assincrono"]').removeClass('btn-outline-primary').addClass('btn-primary active');
					renderizarFeedbacks();
					// ==========================================

                    // 2. Destrói gráfico antigo se ele existir
                    if(meuGrafico !== null) {
                        meuGrafico.destroy();
                    }

                    // 3. Renderiza o novo gráfico de Rosca (Donut Chart)
                    let ctx = document.getElementById('chartNps').getContext('2d');
                    meuGrafico = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Promotores', 'Neutros', 'Detratores'],
                            datasets: [{
                                data: [dados.promotores, dados.neutros, dados.detratores],
                                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });

                    // Exibe a div de resultados
                    $('#container-resultado-nps').removeClass('d-none');
                    $('#btn-exportar-pdf').prop('disabled', false);

                } else {
                    alert(response.mensagem);
                }
            },
            error: function() {
                $('#nps-loading').addClass('d-none');
                alert('Erro crítico ao processar requisição Ajax.');
            }
        });
    });

	<?php if (!empty($courseidSelecionado)): ?>
	$('#select-curso').trigger('change');
	<?php endif; ?>

    $('#btn-exportar-pdf').on('click', function() {
        const courseid = $('#select-curso').val();
        if (!courseid || meuGrafico === null) return;

        const canvasGrafico = document.getElementById('chartNps');
        const canvasPdf = document.createElement('canvas');
        canvasPdf.width = canvasGrafico.width;
        canvasPdf.height = canvasGrafico.height;

        const contextoPdf = canvasPdf.getContext('2d');
        contextoPdf.fillStyle = '#ffffff';
        contextoPdf.fillRect(0, 0, canvasPdf.width, canvasPdf.height);
        contextoPdf.drawImage(canvasGrafico, 0, 0);

        const formulario = $('<form>', {
            method: 'POST',
            action: '<?= base_url("nps/exportar_pdf"); ?>',
            target: '_blank'
        }).append(
            $('<input>', { type: 'hidden', name: 'courseid', value: courseid }),
            $('<input>', { type: 'hidden', name: 'grafico', value: canvasPdf.toDataURL('image/jpeg', 0.92) })
        );

        formulario.appendTo('body').trigger('submit').remove();
    });
});
</script>
