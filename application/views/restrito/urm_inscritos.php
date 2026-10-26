<link rel="stylesheet" href="<?=base_url('assets/css/restrito/painel.css')?>">
<div class="container">
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="text-primary mb-1">Inscritos e presença</h4>
            <div><?=html_escape($evento->titulo)?> · <?=count($inscritos)?> inscrito(s)</div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="<?=site_url('restrito/urm/listar')?>">Voltar</a>
            <button id="salvarTodasPresencas" type="button" class="btn btn-success" data-url="<?=site_url('restrito/urm/salvar_todas_presencas/' . $evento->id)?>"><i class="bi bi-check2-all me-1"></i> Salvar todas as presenças</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importarInscritos"><i class="bi bi-upload me-1"></i> Importar inscritos</button>
        </div>
    </div>
    <?php foreach (['sucesso' => 'success', 'erro' => 'danger'] as $tipo => $classe): ?>
        <?php if ($mensagem = $this->session->flashdata('inscritos_' . $tipo)): ?>
            <div class="alert alert-<?=$classe?>" role="alert"><?=html_escape($mensagem)?></div>
        <?php endif; ?>
    <?php endforeach; ?>
    <p class="text-muted">Marque ou desmarque a presença e clique em Salvar na linha do inscrito.</p>
    <div class="card shadow-sm border-0 mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th class="text-center">Presença</th><th>Nome / CPF</th><th>Contato</th><th>Instituição</th><th></th></tr></thead>
                <tbody>
                <?php if (!$inscritos): ?>
                    <tr><td colspan="5" class="text-center py-4">Nenhum inscrito neste curso.</td></tr>
                <?php endif; ?>
                <?php foreach ($inscritos as $inscrito): ?>
                    <tr>
                        <td class="text-center">
                            <form id="presenca-<?=(int) $inscrito->id?>" class="form-presenca" action="<?=site_url('restrito/urm/salvar_presenca/' . $evento->id)?>" method="post">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                                <input type="hidden" name="inscricao_id" value="<?=(int) $inscrito->id?>">
                                <input class="form-check-input mt-0" type="checkbox" name="presenca" value="1" aria-label="Presença de <?=html_escape($inscrito->nome)?>" <?=(int) $inscrito->presenca === 1 ? 'checked' : ''?>>
                            </form>
                        </td>
                        <td>
                            <div class="fw-semibold text-primary"><?=html_escape($inscrito->nome)?></div>
                            <small class="d-block text-muted mt-1">CPF: <?=html_escape($inscrito->cpf)?></small>
                        </td>
                        <td>
                            <div><i class="bi bi-envelope me-1 text-muted" aria-hidden="true"></i> <?=html_escape($inscrito->email)?></div>
                            <small class="d-block text-muted mt-1"><i class="bi bi-telephone me-1" aria-hidden="true"></i> <?=html_escape(trim((string) $inscrito->telefone) !== '' ? $inscrito->telefone : 'Não informado')?></small>
                        </td>
                        <td><?=html_escape($inscrito->instituicao)?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" type="submit" form="presenca-<?=(int) $inscrito->id?>">Salvar</button>
                            <small class="resultado-presenca d-block" data-inscricao="<?=(int) $inscrito->id?>" role="status" aria-live="polite"></small>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="importarInscritos" tabindex="-1" aria-labelledby="tituloImportarInscritos" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content">
        <form action="<?=site_url('restrito/urm/importar_inscritos/' . $evento->id)?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloImportarInscritos">Importar inscritos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Selecione um CSV de até 5 MB, separado por vírgula ou ponto e vírgula, com o cabeçalho:</p>
                <pre class="bg-light p-2">nome;cpf;email;telefone;instituicao</pre>
                <p class="small text-muted">Mantenha os 11 dígitos do CPF, incluindo zeros iniciais. CPFs já inscritos neste curso serão ignorados. Novas inscrições terão a data e hora atuais e presença desmarcada.</p>
                <label for="arquivoCsv" class="form-label">Arquivo CSV</label>
                <input id="arquivoCsv" class="form-control" type="file" name="csv" accept=".csv,text/csv" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Importar inscritos</button>
            </div>
        </form>
    </div></div>
</div>
<script>
$(function () {
	$('#salvarTodasPresencas').on('click', function () {
		const botao = $(this);
		const dados = $('form.form-presenca').first().find('input[type="hidden"]').first().serializeArray();
		$('form.form-presenca').each(function () {
			const form = $(this);
			const inscricaoId = form.find('[name="inscricao_id"]').val();
			dados.push({name: 'presencas[' + inscricaoId + ']', value: form.find('[name="presenca"]').prop('checked') ? '1' : '0'});
		});
		if (!dados.length || !$('form.form-presenca').length) { return; }
		botao.prop('disabled', true).text('Salvando...');
		$.ajax({url: botao.data('url'), type: 'POST', dataType: 'json', data: dados})
			.done(function (resposta) { Swal.fire('Tudo certo!', resposta.message, 'success'); })
			.fail(function (xhr) { Swal.fire('Erro!', (xhr.responseJSON || {}).message || 'Falha ao salvar as presenças.', 'error'); })
			.always(function () { botao.prop('disabled', false).html('<i class="bi bi-check2-all me-1"></i> Salvar todas as presenças'); });
	});

    $('.form-presenca').on('submit', function (event) {
        event.preventDefault();
        const form = $(this);
        const botao = $('[form="' + form.attr('id') + '"]');
        const resultado = $('.resultado-presenca[data-inscricao="' + form.find('[name="inscricao_id"]').val() + '"]');
        const dados = form.serializeArray().filter(function (campo) { return campo.name !== 'presenca'; });
        dados.push({name: 'presenca', value: form.find('[name="presenca"]').prop('checked') ? '1' : '0'});
        botao.prop('disabled', true);
        resultado.removeClass('text-success text-danger').text('Salvando...');
        $.ajax({url: form.attr('action'), type: 'POST', dataType: 'json', data: dados})
            .done(function (resposta) { resultado.addClass('text-success').text(resposta.message); })
            .fail(function (xhr) { resultado.addClass('text-danger').text((xhr.responseJSON || {}).message || 'Falha ao salvar. Tente novamente.'); })
            .always(function () { botao.prop('disabled', false); });
    });
});
</script>
