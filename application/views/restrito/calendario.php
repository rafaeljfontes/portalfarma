<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/pt-br.js"></script>
<style>
    .calendar-page { padding: 24px; }
    .calendar-heading { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
    .calendar-heading h2 { margin: 0; color: #101828; font-size: 24px; font-weight: 700; }
    .calendar-breadcrumb { color: #667085; font-size: 14px; margin-top: 7px; }
    .calendar-breadcrumb a { color: #667085; text-decoration: none; }
    .calendar-breadcrumb span { color: #465fff; }
    .calendar-card { overflow: hidden; background: #fff; border: 1px solid #e4e7ec; border-radius: 12px; box-shadow: 0 1px 2px rgba(16, 24, 40, .04); }
    .calendar-card-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 20px 24px; border-bottom: 1px solid #e4e7ec; }
    .calendar-card-header h3 { margin: 0; color: #101828; font-size: 18px; font-weight: 600; }
    .calendar-card-header p { margin: 4px 0 0; color: #667085; font-size: 13px; }
    .calendar-card-icon { width: 42px; height: 42px; display: grid; place-items: center; flex: 0 0 auto; color: #465fff; background: #eef0ff; border-radius: 10px; font-size: 20px; }
    .calendar-card-body { padding: 24px; }
    #calendar-programacao { width: 100%; font-family: inherit; }
    .fc .fc-toolbar.fc-header-toolbar { margin-bottom: 24px; }
    .fc .fc-toolbar-title { color: #101828; font-size: 18px; font-weight: 600; text-transform: capitalize; }
    .fc .fc-button-primary { padding: 8px 13px; color: #344054; background: #fff; border: 1px solid #d0d5dd; box-shadow: 0 1px 2px rgba(16,24,40,.05); font-size: 13px; font-weight: 500; text-transform: capitalize; }
    .fc .fc-button-primary:hover, .fc .fc-button-primary:focus, .fc .fc-button-primary:not(:disabled).fc-button-active { color: #fff; background: #465fff; border-color: #465fff; box-shadow: none; }
    .fc .fc-prev-button { border-radius: 8px 0 0 8px; }
    .fc .fc-next-button { border-radius: 0 8px 8px 0; }
    .fc .fc-today-button { margin-left: 10px !important; border-radius: 8px !important; }
    .fc-theme-standard th, .fc-theme-standard td, .fc-theme-standard .fc-scrollgrid { border-color: #e4e7ec; }
    .fc-theme-standard .fc-scrollgrid { overflow: hidden; border-radius: 10px; }
    .fc .fc-col-header-cell { background: #f9fafb; }
    .fc .fc-col-header-cell-cushion { padding: 13px 8px; color: #475467; font-size: 12px; font-weight: 600; text-transform: uppercase; text-decoration: none; }
    .fc .fc-daygrid-day-frame { min-height: 112px; }
    .fc .fc-daygrid-day-number { margin: 5px; padding: 6px; color: #344054; font-size: 13px; font-weight: 500; text-decoration: none; }
    .fc .fc-day-other .fc-daygrid-day-number { color: #98a2b3; }
    .fc .fc-day-today { background: #f5f7ff !important; box-shadow: inset 0 0 0 1px #b2ccff; }
    .fc .fc-day-today .fc-daygrid-day-number { width: 28px; height: 28px; display: grid; place-items: center; padding: 0; color: #fff; background: #465fff; border-radius: 50%; }
    .fc .fc-daygrid-day-events { color: #004761; }
    .fc .fc-daygrid-event { margin: 2px 5px; padding: 5px 7px; color: #004761 !important; background: #eef0ff !important; border: 0 !important; border-left: 3px solid #465fff !important; border-radius: 4px; cursor: pointer; transition: transform .15s ease, background .15s ease; }
    .fc .fc-daygrid-event:hover { background: #e0e4ff !important; transform: translateY(-1px); }
    .fc .fc-event-title { overflow: hidden; color: #004761; font-size: 12px; font-weight: 600; text-overflow: ellipsis; }
    .fc .fc-daygrid-more-link { margin: 3px 7px; color: #465fff; font-size: 12px; font-weight: 600; }
    .badge-tipo { display: inline-block; padding: 6px 14px; border-radius: 999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; background: transparent; }
    .tipo-evento-1 { border: 1px solid #e53845; color: #e53845; }
    .tipo-evento-2 { border: 1px solid #0ea5b7; color: #0ea5b7; }
    .tipo-evento-3 { border: 1px solid #e3251e; color: #e3251e; }
    .tipo-evento-4 { border: 1px solid #007961; color: #007961; }
    .tipo-evento-5, .tipo-evento-6 { border: 1px solid #004761; color: #004761; }
    .tipo-evento-7 { border: 1px solid #105e8f; color: #105e8f; }
    .calendar-modal .modal-content { overflow: hidden; border: 1px solid #e4e7ec !important; border-radius: 12px; }
    .calendar-modal .modal-header { padding: 20px 24px; background: #fff; border-bottom: 1px solid #e4e7ec; }
    .calendar-modal .modal-title { color: #101828; font-size: 18px; font-weight: 600; }
    .calendar-modal .modal-body { padding: 24px; }
    .calendar-modal-summary { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 16px; }
    .calendar-enrollments { display: inline-flex; align-items: center; gap: 9px; padding: 9px 13px; color: #344054; background: #eef0ff; border: 1px solid #dfe3ff; border-radius: 10px; font-size: 13px; }
    .calendar-enrollments i { color: #465fff; font-size: 19px; }
    .calendar-enrollments strong { color: #101828; font-size: 18px; font-weight: 700; }
    .calendar-modal .modal-footer { padding: 16px 24px; background: #f9fafb; border-top: 1px solid #e4e7ec; }
    .programacao-item { padding: 16px; margin-bottom: 12px; background: #f9fafb; border: 1px solid #e4e7ec; border-left: 3px solid #465fff; border-radius: 8px; }
    @media (max-width: 767.98px) {
        .calendar-page { padding: 16px; }
        .calendar-card-body { padding: 12px; }
        .calendar-card-header { padding: 16px; }
        .fc .fc-toolbar { align-items: stretch; flex-direction: column; gap: 12px; }
        .fc .fc-toolbar-chunk { display: flex; justify-content: center; }
        .fc .fc-daygrid-day-frame { min-height: 78px; }
        .fc .fc-col-header-cell-cushion { font-size: 10px; }
    }
</style>
<div class="calendar-page">
    <div class="calendar-heading">
        <div>
            <h2>Calendário</h2>
            <div class="calendar-breadcrumb"><a href="<?=base_url('restrito')?>">Dashboard</a> <span class="mx-1">/</span> <span>Calendário</span></div>
        </div>
    </div>

    <div class="calendar-card">
        <div class="calendar-card-header">
            <div class="d-flex align-items-center gap-3">
                <div class="calendar-card-icon"><i class="bi bi-calendar3"></i></div>
                <div>
                    <h3>Calendário de programação</h3>
                    <p>Consulte os cursos e suas programações por data.</p>
                </div>
            </div>
        </div>
        <div class="calendar-card-body">
            <div id="calendar-programacao"></div>
        </div>
    </div>
</div>

<div class="modal fade calendar-modal" id="modalDetalhes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTituloCurso"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="calendar-modal-summary">
                    <div id="modalBadgesHeader"></div>
                    <div class="calendar-enrollments" role="status" aria-live="polite"><i class="bi bi-people" aria-hidden="true"></i><span id="modalTotalInscritos">Carregando inscritos...</span></div>
                </div>
                <div id="listaProgramacao"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="bi bi-x-lg me-1"></i>Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var calendarEl = document.getElementById('calendar-programacao');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        buttonText: {
            today: 'Hoje'
        },
        dayMaxEvents: 3,
        height: 'auto',
        
        // Passamos apenas o básico para o calendário não ficar pesado
        events: [
            <?php foreach ($tabelaCurso as $campo): 
                $data_iso = $campo->data_evento;
                if (empty($data_iso) || $data_iso === '0000-00-00') continue;
            ?>
            {
                title: '<?= htmlspecialchars($campo->titulo_curso, ENT_QUOTES, 'UTF-8') ?>',
                start: '<?= $data_iso ?>',
                // Guardamos IDs para a busca AJAX
                extendedProps: {
                    courseid: '<?= $campo->courseid ?>',
                    data_busca: '<?= $data_iso ?>'
                }
            },
            <?php endforeach; ?>
        ],

        eventClick: function(info) {
            var props = info.event.extendedProps;

            $('#modalTituloCurso').text('Carregando...');
            $('#modalBadgesHeader').empty();
            $('#modalTotalInscritos').text('Carregando inscritos...');
            $('#listaProgramacao').html('<div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Carregando programação...</div>');
            var myModal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
            myModal.show();

            // Requisição AJAX para buscar detalhes completos
            $.ajax({
                url: '<?= base_url("restrito/calendario/detalhes") ?>',
                type: 'POST',
                data: {
                    courseid: props.courseid,
                    data_evento: props.data_busca
                },
                dataType: 'json',
                success: function(res) {
					var total = res.total_inscritos;
					if (total === null || total === undefined) {
						$('#modalTotalInscritos').text('Inscritos indisponíveis');
					} else {
						$('#modalTotalInscritos').empty().append($('<strong>').text(Number(total).toLocaleString('pt-BR'))).append(document.createTextNode(Number(total) === 1 ? ' inscrito' : ' inscritos'));
					}
					var tipoEvento = res.tipo_evento;
					res = res.programacao || [];
					const tipos = {1: 'Presencial', 2: 'Online', 3: 'URM (Presencial)', 4: 'Fiscalização Humanizada', 5: 'Universitário', 7: 'Seminário (Híbrido)'};
					$('#modalBadgesHeader').append($('<span>').addClass('badge-tipo tipo-evento-' + Number(tipoEvento)).text(tipos[tipoEvento] || 'Outro'));
					if (res && res.length > 0) {
					
						// Pegamos os dados gerais do primeiro item para o cabeçalho
						var dadosGerais = res[0];
						$('#modalTituloCurso').text(dadosGerais.titulo_curso);
						
						// Definição das configurações de cada tipo de evento
						const configEventos = {
							1: { label: 'Presencial', class: 'tipo-evento-1' },
							2: { label: 'Online', class: 'tipo-evento-2' },
							3: { label: 'URM (Presencial)', class: 'tipo-evento-3' },
							4: { label: 'Fiscalização Humanizada', class: 'tipo-evento-4' },
							5: { label: 'Universitário', class: 'tipo-evento-5' },
							7: { label: 'Seminário (Híbrido)', class: 'tipo-evento-7' }
						};

						// Obtém a configuração baseada no ID (dadosGerais.tipo_evento)
						// Caso o ID não exista no mapeamento, define um padrão (Outro)
						//var config = configEventos[dadosGerais.tipo_evento] || { label: 'Outro', class: 'badge bg-secondary text-white' };
						var config = configEventos[dadosGerais.tipo_evento] || { label: 'Outro', class: 'border text-secondary' };

						var badge = `<span class="badge-tipo ${config.class}">${config.label}</span>`;
						$('#modalBadgesHeader').html(badge);

						// Limpamos a lista anterior e montamos a nova programação
						var htmlLista = '';
							$.each(res, function(index, item) {
								htmlLista += `
									<div class="programacao-item">
										<div class="d-flex justify-content-between align-items-start">
											<h6 class="fw-bold mb-1">${item.titulo_programacao}</h6>
											<span class="badge bg-white text-dark border shadow-sm">
												<i class="bi bi-clock"></i> ${item.hora_inicio} às ${item.hora_final}
											</span>
										</div>
										<p class="small text-muted mb-2"><i class="bi bi-geo-alt"></i> ${item.local}</p>
										<div class="small">${item.descricao || '<i class="text-muted">Sem descrição.</i>'}</div>
									</div>`;
							});
        
						$('#listaProgramacao').html(htmlLista);
					} else {
						$('#modalTituloCurso').text(info.event.title);
						$('#listaProgramacao').html('<p class="text-center">Nenhuma programação encontrada.</p>');
					}
				},
                error: function() {
                    $('#modalTotalInscritos').text('Inscritos indisponíveis');
                    alert('Erro ao buscar dados do evento.');
                }
            });
        }
    });

    calendar.render();
});
</script>
