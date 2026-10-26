<link rel="stylesheet" href="<?=base_url('assets/plugins/select2/select2.bundle.css')?>">
<script src="<?=base_url('assets/plugins/select2/select2.bundle.js')?>"></script>
<div class="container">
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap gap-2">
		<div class="d-flex align-items-center"><i class="fas fa-file-signature text-primary me-2 fs-4"></i><h4 class="mb-0 text-primary">Vincular Curso Para</h4></div>
		<a href="<?=base_url('restrito/cursos/para')?>" class="btn btn-outline-primary d-inline-flex align-items-center gap-2"><i class="bi bi-arrow-return-left"></i> Voltar</a>
	</div>
	<form method="post" action="<?=base_url('restrito/cursos/para_vincular')?>" id="form-curso-para">
		<div class="mb-4">
			<label for="courseid" class="form-label">Selecione o Curso</label>
			<select name="courseid" class="form-select" id="courseid" required>
				<option value="">Selecione ou digite o código ou nome do curso</option>
				<?php foreach ($cursos as $curso): ?>
					<option value="<?=htmlspecialchars((string) $curso->courseid, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($curso->courseid . ' - ' . $curso->titulo, ENT_QUOTES, 'UTF-8')?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<fieldset class="mb-4">
			<legend class="form-label">Este curso é para</legend>
			<?php foreach ([1 => 'Para Farmacêutico', 2 => 'Para Empresa', 3 => 'Para Sociedade'] as $valor => $rotulo): ?>
				<div class="form-check border rounded p-3 ps-5 mb-2 bg-white">
					<input class="form-check-input" type="checkbox" name="para[]" id="para-<?=$valor?>" value="<?=$valor?>">
					<label class="form-check-label fw-semibold w-100" for="para-<?=$valor?>"><?=$rotulo?></label>
				</div>
			<?php endforeach; ?>
			<small class="text-muted">Selecione uma ou mais opções. Ao salvar novamente, os públicos anteriormente vinculados serão atualizados.</small>
		</fieldset>
		<button type="submit" class="btn btn-primary mb-3"><i class="bi bi-check-lg"></i> Salvar</button>
	</form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
	var curso = document.getElementById('courseid');
	if (window.jQuery && jQuery.fn.select2) jQuery(curso).select2({placeholder: 'Selecione ou digite o código ou nome do curso', allowClear: true, width: '100%'});
	function carregar() {
		document.querySelectorAll('input[name="para[]"]').forEach(function (opcao) { opcao.checked = false; });
		if (!curso.value) return;
		var dados = new FormData(); dados.append('courseid', curso.value);
		fetch('<?=base_url('restrito/cursos/para_curso_listar')?>', {method: 'POST', body: dados})
			.then(function (resposta) { return resposta.json(); })
			.then(function (retorno) {
				if (retorno.status === 'ok') {
					(retorno.publicos || []).forEach(function (idpara) {
						var opcao = document.getElementById('para-' + idpara);
						if (opcao) opcao.checked = true;
					});
				}
			});
	}
	if (window.jQuery) jQuery(curso).on('change', carregar); else curso.addEventListener('change', carregar);
	document.getElementById('form-curso-para').addEventListener('submit', function (evento) {
		if (!document.querySelector('input[name="para[]"]:checked')) {
			evento.preventDefault();
			Swal.fire({title: 'Selecione um público', text: 'Marque pelo menos uma das opções disponíveis.', icon: 'warning', confirmButtonText: 'OK'});
		}
	});
});
</script>
<?php $retornoPara = $this->input->get('retorno_para', true); $mensagemPara = $this->input->get('mensagem', true); ?>
<?php if (in_array($retornoPara, ['sucesso', 'erro'], true)): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	Swal.fire({
		title: <?=json_encode($retornoPara === 'sucesso' ? 'Vínculo salvo!' : 'Não foi possível salvar')?>,
		text: <?=json_encode((string) $mensagemPara)?>,
		icon: <?=json_encode($retornoPara === 'sucesso' ? 'success' : 'error')?>,
		confirmButtonText: 'OK', confirmButtonColor: '#465fff'
	}).then(function () { window.history.replaceState({}, document.title, <?=json_encode(base_url('restrito/cursos/para_curso'))?>); });
});
</script>
<?php endif; ?>
