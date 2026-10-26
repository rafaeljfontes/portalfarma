 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.bundle.css') ?>">
<script src="<?= base_url('assets/plugins/select2/select2.bundle.js') ?>"></script>
<style>
	#categorias option.categoria-salva {
		background-color: #0d6efd;
		color: #fff;
	}

	#categorias option.categoria-nova {
		background-color: #ffc107;
		color: #212529;
	}
</style>

<div class="container">
	<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-file-signature text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Vincular Categorias ao Curso</h4>
		</div>
		<a href="<?=base_url('restrito/cursos/categorias')?>"
		   class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
		   title="Voltar para Gerenciar Categorias">
			<i class="bi bi-arrow-return-left"></i> Voltar
		</a>
	</div>

	<form method="post" action="<?= base_url('restrito/cursos/categorias_vincular') ?>" id="form-categorias-curso">

		<div id="alerta-categorias" class="alert alert-danger d-none" role="alert"></div>

		<!-- CURSO -->
		<div class="mb-3">
			<label class="form-label">Selecione o Curso</label>
			<select name="courseid" class="form-select" id="courseid" required>
				<option value="">Selecione ou digite o código ou nome do curso</option>
				<?php foreach($cursos as $curso): ?>
					<option value="<?= $curso->courseid ?>">
						<?= $curso->courseid ?> - <?= $curso->titulo ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<!-- CATEGORIA PRINCIPAL -->
		<div class="mb-3">
			<label class="form-label" for="categoria-principal">Principal</label>
			<select name="categoria_principal" class="form-select" id="categoria-principal" required>
				<option value="">Selecione a categoria principal</option>
				<?php foreach($categorias as $p): ?>
					<option value="<?= $p->id;?>"><?= $p->descricao;?></option>
				<?php endforeach; ?>
			</select>
			<small class="text-muted">Esta categoria será salva como principal para o curso.</small>
		</div>

		<!-- categorias -->
		<div class="mb-3">
			<label class="form-label">Selecione as Categorias</label>

			<select name="categorias[]" 
					class="form-select" 
					id="categorias"
					multiple 
					size="6" 
					required>
						
				<?php foreach($categorias as $p): ?>
					<option value="<?= $p->id;?>">
						<?= $p->descricao;?>
					</option>
				<?php endforeach; ?>

			</select>

			<small class="text-muted">
				Selecione até duas categorias complementares.
			</small>
		</div>

		<div class="mb-3">
			<label class="form-label d-flex align-items-center gap-2">
				Categorias selecionadas
				<span id="contador-categorias" class="badge bg-secondary">0/2</span>
			</label>
			<div id="categorias-selecionadas" class="border rounded p-3 bg-light">
				<span class="text-muted">Selecione um curso para carregar as categorias.</span>
			</div>
		</div>

		<button type="submit" class="btn btn-primary mb-3">
			Salvar
		</button>

	</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const limiteCategorias = 2;
	const selectCurso = document.getElementById('courseid');
	const selectPrincipal = document.getElementById('categoria-principal');
	const selectCategorias = document.getElementById('categorias');
	const boxSelecionadas = document.getElementById('categorias-selecionadas');
	const contadorCategorias = document.getElementById('contador-categorias');
	const alertaCategorias = document.getElementById('alerta-categorias');
	let vinculosSalvos = {};
	let selecaoAnterior = new Set();

	function normalizarBusca(texto) {
		return (texto || '')
			.toString()
			.normalize('NFD')
			.replace(/[\u0300-\u036f]/g, '')
			.toLowerCase()
			.trim();
	}

	if (window.jQuery && jQuery.fn.select2) {
		jQuery(selectCurso).select2({
			placeholder: 'Selecione ou digite o código ou nome do curso',
			allowClear: true,
			width: '100%',
			matcher: function (params, data) {
				const busca = normalizarBusca(params.term);

				if (!busca) {
					return data;
				}

				const textoCurso = normalizarBusca(data.text);
				const palavras = busca.split(/\s+/).filter(Boolean);

				return palavras.every(function (palavra) {
					return textoCurso.indexOf(palavra) !== -1;
				}) ? data : null;
			}
		});
	}

	function mostrarAlerta(mensagem) {
		alertaCategorias.textContent = mensagem;
		alertaCategorias.classList.remove('d-none');
	}

	function esconderAlerta() {
		alertaCategorias.textContent = '';
		alertaCategorias.classList.add('d-none');
	}

	function selecionadas() {
		return Array.from(selectCategorias.selectedOptions).map(function (option) {
			return option.value;
		});
	}

	function optionPorId(id) {
		return selectCategorias.querySelector('option[value="' + id + '"]');
	}

	function atualizarCoresOpcoes() {
		Array.from(selectCategorias.options).forEach(function (option) {
			option.classList.remove('categoria-salva', 'categoria-nova');

			if (!option.selected) {
				return;
			}

			option.classList.add(vinculosSalvos[option.value] ? 'categoria-salva' : 'categoria-nova');
		});
	}

	function renderizarSelecionadas() {
		const ids = selecionadas();
		contadorCategorias.textContent = ids.length + '/' + limiteCategorias;
		atualizarCoresOpcoes();

		if (!selectCurso.value) {
			boxSelecionadas.innerHTML = '<span class="text-muted">Selecione um curso para carregar as categorias.</span>';
			return;
		}

		if (!ids.length) {
			boxSelecionadas.innerHTML = '<span class="text-muted">Nenhuma categoria selecionada.</span>';
			return;
		}

		boxSelecionadas.innerHTML = ids.map(function (id) {
			const option = optionPorId(id);
			const texto = option ? option.textContent.trim() : id;
			const vinculoId = vinculosSalvos[id] || '';
			const classeCategoria = vinculoId ? 'bg-primary' : 'bg-warning text-dark';

			return '<span class="badge ' + classeCategoria + ' me-2 mb-2 p-2">' +
				texto +
				' <button type="button" class="btn btn-sm btn-light ms-2 py-0 px-1 btn-remover-categoria" data-id-categoria="' + id + '" data-id-vinculo="' + vinculoId + '" aria-label="Excluir categoria">X</button>' +
			'</span>';
		}).join('');
	}

	function sincronizarSelecaoAnterior() {
		selecaoAnterior = new Set(selecionadas());
	}

	function atualizarDisponibilidadeCategorias() {
		Array.from(selectCategorias.options).forEach(function (option) {
			const ehPrincipal = selectPrincipal.value && option.value === selectPrincipal.value;
			option.disabled = Boolean(ehPrincipal);

			if (ehPrincipal) {
				option.selected = false;
			}
		});
	}

	function aplicarLimiteCategorias() {
		const ids = selecionadas();

		if (ids.length <= limiteCategorias) {
			esconderAlerta();
			atualizarDisponibilidadeCategorias();
			sincronizarSelecaoAnterior();
			renderizarSelecionadas();
			return true;
		}

		const adicionadas = ids.filter(function (id) {
			return !selecaoAnterior.has(id);
		});
		const excedentes = adicionadas.length ? adicionadas : ids.slice(limiteCategorias);

		excedentes.forEach(function (id) {
			const option = optionPorId(id);

			if (option) {
				option.selected = false;
			}
		});

		mostrarAlerta('Você só pode selecionar até 2 categorias complementares.');
		atualizarDisponibilidadeCategorias();
		sincronizarSelecaoAnterior();
		renderizarSelecionadas();
		return false;
	}

	function limparCategorias() {
		Array.from(selectCategorias.options).forEach(function (option) {
			option.selected = false;
			option.disabled = false;
		});

		vinculosSalvos = {};
		selectPrincipal.value = '';
		sincronizarSelecaoAnterior();
		renderizarSelecionadas();
		atualizarDisponibilidadeCategorias();
	}

	function carregarCategoriasCurso(courseid) {
		esconderAlerta();
		limparCategorias();

		if (!courseid) {
			return;
		}

		const formData = new FormData();
		formData.append('courseid', courseid);

		fetch('<?= base_url('restrito/cursos/categorias_curso_listar') ?>', {
			method: 'POST',
			body: formData
		})
		.then(function (response) { return response.json(); })
		.then(function (retorno) {
			if (retorno.status !== 'ok') {
				mostrarAlerta(retorno.mensagem || 'Não foi possível carregar as categorias do curso.');
				return;
			}

			const categoriasCurso = retorno.categorias || [];
			let categoriaPrincipal = categoriasCurso.find(function (categoria) {
				return Number(categoria.principal) === 1;
			});

			// Compatibilidade com vínculos antigos que ainda não possuíam principal.
			if (!categoriaPrincipal && categoriasCurso.length) {
				categoriaPrincipal = categoriasCurso[0];
			}

			if (categoriaPrincipal) {
				selectPrincipal.value = String(categoriaPrincipal.id_categoria);
			}

			categoriasCurso.forEach(function (categoria) {
				const idCategoria = String(categoria.id_categoria);
				const option = optionPorId(idCategoria);
				const ehPrincipal = categoriaPrincipal && idCategoria === String(categoriaPrincipal.id_categoria);

				if (option && !ehPrincipal && selecionadas().length < limiteCategorias) {
					option.selected = true;
					vinculosSalvos[idCategoria] = categoria.vinculo_id;
				}
			});

			sincronizarSelecaoAnterior();
			renderizarSelecionadas();
			atualizarDisponibilidadeCategorias();
		})
		.catch(function () {
			mostrarAlerta('Não foi possível carregar as categorias do curso.');
		});
	}

	function removerCategoria(idCategoria, idVinculo) {
		const option = optionPorId(idCategoria);

		if (!idVinculo) {
			if (option) {
				option.selected = false;
			}

			delete vinculosSalvos[idCategoria];
			sincronizarSelecaoAnterior();
			renderizarSelecionadas();
			atualizarDisponibilidadeCategorias();
			esconderAlerta();
			return;
		}

		const formData = new FormData();
		formData.append('id', idVinculo);

		fetch('<?= base_url('restrito/cursos/categoria_curso_excluir') ?>', {
			method: 'POST',
			body: formData
		})
		.then(function (response) { return response.json(); })
		.then(function (retorno) {
			if (retorno.status !== 'ok') {
				mostrarAlerta(retorno.mensagem || 'Não foi possível remover a categoria.');
				return;
			}

			if (option) {
				option.selected = false;
			}

			delete vinculosSalvos[idCategoria];
			sincronizarSelecaoAnterior();
			renderizarSelecionadas();
			atualizarDisponibilidadeCategorias();
			esconderAlerta();
		})
		.catch(function () {
			mostrarAlerta('Não foi possível remover a categoria.');
		});
	}

	function cursoAlterado() {
		carregarCategoriasCurso(selectCurso.value);
	}

	if (window.jQuery) {
		jQuery(selectCurso).on('change', cursoAlterado);
	} else {
		selectCurso.addEventListener('change', cursoAlterado);
	}

	selectPrincipal.addEventListener('change', function () {
		atualizarDisponibilidadeCategorias();
		sincronizarSelecaoAnterior();
		renderizarSelecionadas();
		esconderAlerta();
	});

	selectCategorias.addEventListener('mousedown', function (event) {
		const option = event.target;

		if (option.tagName !== 'OPTION') {
			return;
		}

		event.preventDefault();
		selectCategorias.focus();

		if (option.selected) {
			option.selected = false;
			esconderAlerta();
			sincronizarSelecaoAnterior();
			renderizarSelecionadas();
			return;
		}

		if (option.value === selectPrincipal.value) {
			mostrarAlerta('A categoria principal não pode ser repetida nas categorias complementares.');
			return;
		}

		if (selecionadas().length >= limiteCategorias) {
			mostrarAlerta('Você só pode selecionar até 2 categorias complementares.');
			return;
		}

		option.selected = true;
		aplicarLimiteCategorias();
	});

	selectCategorias.addEventListener('change', function () {
		aplicarLimiteCategorias();
	});

	document.getElementById('form-categorias-curso').addEventListener('submit', function (event) {
		if (!selectPrincipal.value) {
			event.preventDefault();
			mostrarAlerta('Selecione a categoria principal.');
			return;
		}

		if (selecionadas().length > limiteCategorias) {
			event.preventDefault();
			aplicarLimiteCategorias();
		}
	});

	boxSelecionadas.addEventListener('click', function (event) {
		if (!event.target.classList.contains('btn-remover-categoria')) {
			return;
		}

		removerCategoria(event.target.dataset.idCategoria, event.target.dataset.idVinculo);
	});
});
</script>


<?php
$retornoCategorias = $this->input->get('retorno_categorias', true);
$mensagemCategorias = $this->input->get('mensagem', true);
$categoriaPrincipalRetorno = $this->input->get('principal', true);
$categoriasSecundariasRetorno = $this->input->get('secundarias', true);
?>
<?php if (in_array($retornoCategorias, ['sucesso', 'erro'], true)): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function escaparHtml(valor) {
        var elemento = document.createElement('div');
        elemento.textContent = valor || '';
        return elemento.innerHTML;
    }

    var sucesso = <?= json_encode($retornoCategorias === 'sucesso'); ?>;
    var principal = <?= json_encode((string) $categoriaPrincipalRetorno); ?>;
    var secundarias = <?= json_encode((string) $categoriasSecundariasRetorno); ?>;
    var mensagemErro = <?= json_encode((string) $mensagemCategorias); ?>;

    Swal.fire({
        title: sucesso ? 'Categorias vinculadas!' : 'Não foi possível salvar',
        html: sucesso
            ? '<div style="text-align:left"><strong>Principal:</strong> ' + escaparHtml(principal)
                + '<br><strong>Secundárias:</strong> ' + escaparHtml(secundarias) + '</div>'
            : escaparHtml(mensagemErro),
        icon: sucesso ? 'success' : 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#465fff'
    }).then(function () {
        window.history.replaceState({}, document.title, <?= json_encode(base_url('restrito/cursos/categorias_curso')); ?>);
    });
});
</script>
<?php endif; ?>
