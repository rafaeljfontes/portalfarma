<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
   .form-select {
   --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
   display: block;
   width: 100%;
   padding: .375rem 2.25rem .375rem .75rem;
   font-size: 1rem;
   font-weight: 400;
   line-height: 1.5;
   color: var(--bs-body-color);
   -webkit-appearance: none;
   -moz-appearance: none;
   appearance: none;
   background-color: var(--bs-body-bg);
   background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
   background-repeat: no-repeat;
   background-position: right .75rem center;
   background-size: 16px 12px;
   border: 1px solid #ced4da;
   border-radius: .25rem;
   transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
   }
   select {
   word-wrap: normal;
   }
   .form-control[type=file]:not(:disabled):not([readonly]) {
   cursor: pointer;
   }
   .form-control[type=file] {
   overflow: hidden;
   }
   .form-control {
   display: block;
   width: 100%;
   padding: .375rem .75rem;
   font-size: 1rem;
   font-weight: 400;
   line-height: 1.5;
   color: #212529;
   background-color: #fff;
   background-clip: padding-box;
   border: 1px solid #ced4da;
   -webkit-appearance: none;
   -moz-appearance: none;
   appearance: none;
   border-radius: .25rem;
   transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
   }
</style>
<style>
    /* Efeito de hover e estilo premium para o container da imagem */
    .course-image-preview {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e0e0e0;
        background-color: #f8f9fa;
    }

    .course-image-preview:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .image-overlay-label {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        backdrop-filter: blur(4px);
    }

	.course-image-preview {
		width: 100%;
		aspect-ratio: 16 / 9;
		position: relative;
	}

	.course-image-preview img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
	}

	.course-photo-upload {
		min-height: 140px;
		border: 1px dashed #b2ccff;
		border-radius: 10px;
		background: #f9faff;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		text-align: center;
		padding: 18px;
		cursor: pointer;
		transition: .2s ease;
	}

	.course-photo-upload:hover { border-color: #465fff; background: #f5f7ff; }
	.course-photo-upload i { color: #465fff; font-size: 30px; margin-bottom: 8px; }
	.course-photo-upload strong { color: #344054; font-size: 14px; }
	.course-photo-upload span { color: #667085; font-size: 12px; margin-top: 4px; }
	.course-file-name { margin-top: 14px; padding: 12px; background: #f9fafb; border: 1px solid #e4e7ec; border-radius: 8px; }
	.course-file-name small { color: #667085; display: block; margin-bottom: 3px; }
	.course-file-name code { color: #344054; font-weight: 600; overflow-wrap: anywhere; }
	.cursos-semelhantes { margin-top: 9px; overflow: hidden; background: #fffcf5; border: 1px solid #fedf89; border-radius: 8px; }
	.cursos-semelhantes-header { display: flex; align-items: center; gap: 7px; padding: 9px 11px; color: #93370d; background: #fffaeb; border-bottom: 1px solid #fedf89; font-size: 12px; font-weight: 600; }
	.cursos-semelhantes-lista { margin: 0; padding: 0; list-style: none; }
	.curso-semelhante-item { padding: 9px 11px; border-bottom: 1px solid #fef0c7; }
	.curso-semelhante-item:last-child { border-bottom: 0; }
	.curso-semelhante-titulo { display: block; color: #344054; font-size: 12px; font-weight: 600; }
	.curso-semelhante-detalhes { display: block; margin-top: 2px; color: #667085; font-size: 10px; }
</style>
<?php

	$topicos= "";
	$id 			= null;
	$tipo_evento 	= $tipo_evento_padrao ?? null;
	$courseid 		= $courseid_padrao ?? null;
	$titulo 		= null;
	$nome_curto		= null;
	$topicos 		= null;
	$descricao 		= null;
	$local 			= null;
	$data_inicio 	= null;
	$data_fim 		= null;
	$dificuldade 	= null;
	$carga_horaria 	= null;
	$publico_alvo 	= null;
	$link 			= null;
	
	if(isset($tabela) && !empty($tabela)){
		foreach($tabela as $l){
			$id 			= $l->id;
			$tipo_evento 	= $l->tipo_evento;
			$courseid 		= $l->courseid ;
			$titulo 		= $l->titulo ;
			$nome_curto		= $l->nome_curto ;
			$topicos 		= $l->topicos ;
			$descricao 		= $l->descricao ;
			$local 			= $l->local ;
			$data_inicio 	= $l->data_inicio ;
			$data_fim 		= $l->data_fim ;
			$dificuldade 	= $l->dificuldade ;
			$carga_horaria 	= $l->carga_horaria ;
			$publico_alvo 	= $l->publico_alvo ;
			$link 			= $l->link ;
		}
	}	
	
	//print_r($courseid);
	//print_r($cursos);
?>
<div class="container py-4 tail-settings-page">
	<div class="tail-page-header">
		<div>
			<h2><?=$id ? 'Editar evento' : 'Cadastrar evento'?></h2>
			<p class="tail-page-subtitle">Gerencie as informações, período e imagem exibidos no PortalFarma.</p>
		</div>
		<a href="<?=base_url('restrito/capacifar/listar')?>" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Voltar para a listagem de cursos"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
	</div>

	<form method="POST" id="formCurso">
				<input type="hidden" name="data_cadastro" value="<?= date('Y-m-d H:i:s') ?>">
				
				<input type="hidden" id="id_registro" name="id" value="<?= $id ?? ''; ?>">

		<div class="tail-settings-grid">
			<section class="tail-section-card">
				<div class="tail-section-header">
					<h3>Informações do evento</h3>
					<p>Dados de identificação, conteúdo, período e participação.</p>
				</div>
				<div class="tail-section-body">
				<div class="row g-3">
					<div class="col-md-6">
						<label class="form-label">Tipo Evento *</label>
						<select name="tipo_evento" id="tipo_evento" class="form-select" aria-label="Default select example" required>
							<option value="">Selecione</option>
							<option value="1" <?php if($tipo_evento == 1) echo "selected"; ?>>Presencial</option>
							<option value="2" <?php if($tipo_evento == 2) echo "selected"; ?>>On-line</option>
							<option value="3" <?php if($tipo_evento == 3) echo "selected"; ?>>URM</option>
							<option value="4" <?php if($tipo_evento == 4) echo "selected"; ?>>Fiscalização Humanizada</option>
							<option value="5" <?php if($tipo_evento == 5) echo "selected"; ?>>Universitário Presencial</option>
							<option value="6" <?php if($tipo_evento == 6) echo "selected"; ?>>Universitário Online</option>
							<option value="7" <?php if($tipo_evento == 7) echo "selected"; ?>>Seminário de Vigilância e Saúde</option>
						</select>
					</div>
					<div class="col-md-6">
						<label for="courseid_input" class="form-label fw-bold">CourseID / Nome do Curso *</label>
						
						<input 
							class="form-control" 
							list="cursosOptions" 
							id="courseid_input" 
							name="courseid" 
							placeholder="Digite para buscar um curso..." 
							value="<?= $courseid ?? ''; ?>" 
							required
						>

						<datalist id="cursosOptions">
							<?php if(!empty($cursos)): ?>
								<?php foreach($cursos as $c): ?>
									<option value="<?= $c->courseid; ?>">
										<?= $c->courseid; ?> - <?= $c->nome_do_curso; ?>
									</option>
								<?php endforeach; ?>
							<?php endif; ?>
						</datalist>
						
						<small class="text-muted" id="courseid_ajuda">
							Insira o ID numérico ou selecione na lista acima.
						</small>
					</div>
					<div class="col-md-6">
						<label class="form-label">Título *</label>
						<input type="text" name="titulo" id="titulo_curso" class="form-control" value="<?=$titulo ?? '';?>" autocomplete="off" required>
						<div id="cursos-semelhantes" class="cursos-semelhantes" hidden aria-live="polite">
							<div class="cursos-semelhantes-header"><i class="bi bi-exclamation-triangle"></i>Possíveis cursos já cadastrados</div>
							<ul id="cursos-semelhantes-lista" class="cursos-semelhantes-lista"></ul>
						</div>
					</div>
					<div class="col-md-6">
						<label class="form-label">Nome Curto *</label>
						<input type="text" name="nome_curto" id="nome_curto" class="form-control" value="<?=$nome_curto ?? '';?>" required>
						<small class="text-muted">Nome curto igual ao do Portal do Aluno, em minúsculo.</small>
					</div>
					<div class="col-12">
						<label class="form-label">Tópicos *</label>
						<textarea id="topicos" name="topicos" class="form-control" rows="3" value="<?=$topicos ?? '';?>" required></textarea>
						<small class="text-muted">
							cada tópico deverá ser separado pela tecla enter
						</small>
					</div>
					<div class="col-12">
						<label class="form-label">Objetivo *</label>
						
							<input type="hidden" id="descricao_db" value="<?= htmlspecialchars($descricao ?? '', ENT_QUOTES, 'UTF-8'); ?>">

						<div id="editor" style="height:200px;"></div>

						<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

						<script>
						var quill = new Quill('#editor', {
						  theme: 'snow'
						});
						
						var descricao = document.getElementById("descricao_db").value;

						if (descricao && descricao.trim() !== "") {
							quill.root.innerHTML = descricao;
						}
						</script>
						<!--<textarea name="descricao" class="form-control" rows="4" style="display:none;"></textarea>-->
					</div>
					<div class="col-md-12">
						<label class="form-label">Local *</label>
						<input type="text" name="local" id="local" class="form-control" value="<?=$local ?? '';?>" required>
					</div>
					<div class="col-md-4">
						<label class="form-label">Data Início *</label>
						<input type="datetime-local" name="data_inicio" id="data_inicio" class="form-control" value="<?=$data_inicio ?? '';?>" required>
						<small class="text-muted">
							preencher para configuração da hora inicial do evento
						</small>
					</div>
					<div class="col-md-4">
						<label class="form-label">Data Fim</label>
						<input type="datetime-local" name="data_fim" class="form-control" value="<?=$data_fim ?? '';?>" required>
						<small class="text-muted">
							preencher para configuração da hora final do evento
						</small>
					</div>
				   
					<div class="col-md-4">
						<label class="form-label">Carga Horária (em minutos) *</label>
						<input type="number" name="carga_horaria" value="<?=$carga_horaria ?? '';?>" class="form-control" required>
						<small class="text-muted">
							Preencher com o valor em minutos
						</small>
					</div>
					
					<div class="col-md-4">
						<label class="form-label">Dificuldade *</label>
						<select name="dificuldade"  class="form-select" aria-label="Default select example" required>
							<option value="fácil" 	<?php if($dificuldade == 'fácil') 	echo "selected"; ?>>Fácil</option>
							<option value="média" 	<?php if($dificuldade == 'média') 	echo "selected"; ?>>Média</option>
							<option value="difícil" <?php if($dificuldade == 'difícil') echo "selected"; ?>>Difícil</option>
						</select>
					</div>
					
					<div class="col-md-4">
						<label class="form-label">Público Alvo *</label>
						<select name="publico_alvo" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
							<option value="">Selecioneo Público alvo</option>
							<option value="3" <?php if($publico_alvo == 3) 	echo "selected"; ?>>Farmacêuticos</option>
							<option value="5" <?php if($publico_alvo == 5) 	echo "selected"; ?>>Estudantes</option>
							<option value="7" <?php if($publico_alvo == 7) 	echo "selected"; ?>>Geral</option>
						</select>
					</div>
					<div class="col-md-4">
						<label class="form-label">Link</label>
						<input type="text" name="link" value="<?=$link ?? '';?>" class="form-control">
						<small class="text-muted">
							preencher caso tenha link do whatsapp criado
						</small>
					</div>
					<!--<div class="col-12">
						<label class="form-label">Imagem do Curso</label>
						<input type="file" name="imagem" class="form-control" accept="image/*">
						<small class="text-muted">Opcional. Nome será igual ao Nome Curto.</small>
					</div>
					<div class="col-12">
					<?php
						//if (!empty($nome_curto)) {
					?>
						<img src="<?= base_url() ?>uploads/cursos/<?= $nome_curto ?>.png">
					<?php
						//}
					
					?>
					</div>-->
					
				</div>
				</div>
			</section>

			<section class="tail-section-card">
				<div class="tail-section-header">
					<h3>Foto do curso</h3>
					<p>Imagem utilizada nos cards e na apresentação do evento.</p>
				</div>
				<div class="tail-section-body">
					<?php if(!empty($nome_curto)): ?>
						<div class="position-relative course-image-preview">
							<span class="image-overlay-label" id="previewLabel">Imagem atual</span>
							<img id="imgPreview" src="<?=base_url('uploads/cursos/'.$nome_curto.'.png')?>" alt="Imagem atual do curso" onerror="this.src='https://placehold.co/600x338?text=Sem+Imagem';">
						</div>
					<?php else: ?>
						<div id="newPreviewContainer" class="course-image-preview mb-3 d-none"><img id="newImgPreview" src="#" alt="Prévia da imagem do curso"></div>
					<?php endif; ?>

					<label for="formFile" class="course-photo-upload mt-3">
						<i class="bi bi-cloud-arrow-up"></i>
						<strong><?=!empty($nome_curto) ? 'Atualizar imagem' : 'Clique para enviar a imagem'?></strong>
						<span>PNG, JPG ou WEBP — recomendado 1200 × 675 px</span>
					</label>
					<input type="file" name="imagem" class="visually-hidden" id="formFile" accept="image/png,image/jpeg,image/webp" onchange="previewImage(this, <?=!empty($nome_curto) ? 'false' : 'true'?>)">

					<div class="course-file-name">
						<small>Nome final do arquivo</small>
						<code id="fileNameDestiny"><?=!empty($nome_curto) ? $nome_curto : 'nome-do-arquivo'?>.png</code>
					</div>
				</div>
			</section>
		</div>

		<div class="tail-form-actions">
			<a href="<?=base_url('restrito/capacifar/listar')?>" class="btn btn-outline-secondary">Cancelar</a>
			<button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Salvar curso</button>
		</div>
	</form>
</div>
<script>
	//preenchendo campo de imagem com o nome curto 
    const inputNomeCurto = document.getElementById('nome_curto');
    const displayFileName = document.getElementById('fileNameDestiny');

    // Escuta cada tecla digitada no campo Nome Curto
    inputNomeCurto.addEventListener('input', function() {
        let valor = this.value.trim();
        
        if (valor !== "") {
            // Atualiza o texto em tempo real
            displayFileName.textContent = valor + ".png";
        } else {
            // Caso o campo seja limpo, volta para um padrão
            displayFileName.textContent = "nome-do-arquivo.png";
        }
    });
</script>
<script>
(function () {
	const campoTituloCurso = document.getElementById('titulo_curso');
	const painelSemelhantes = document.getElementById('cursos-semelhantes');
	const listaSemelhantes = document.getElementById('cursos-semelhantes-lista');
	const idCursoAtual = document.getElementById('id_registro').value;
	let temporizadorBusca = null;
	let controleBusca = null;

	if (!campoTituloCurso || idCursoAtual !== '') return;

	function ocultarSemelhantes() {
		painelSemelhantes.hidden = true;
		listaSemelhantes.replaceChildren();
	}

	function formatarDataCurso(data) {
		if (!data) return 'data não informada';
		const partes = data.substring(0, 10).split('-');
		return partes.length === 3 ? partes[2] + '/' + partes[1] + '/' + partes[0] : data;
	}

	function mostrarSemelhantes(cursos) {
		listaSemelhantes.replaceChildren();
		if (!Array.isArray(cursos) || cursos.length === 0) {
			ocultarSemelhantes();
			return;
		}

		cursos.forEach(function (curso) {
			const item = document.createElement('li');
			item.className = 'curso-semelhante-item';
			const titulo = document.createElement('span');
			titulo.className = 'curso-semelhante-titulo';
			titulo.textContent = curso.titulo || 'Curso sem título';
			const detalhes = document.createElement('span');
			detalhes.className = 'curso-semelhante-detalhes';
			detalhes.textContent = 'CourseID: ' + curso.courseid + ' · ' + formatarDataCurso(curso.data_inicio) + ' · ' + (Number(curso.status) === 1 ? 'Ativo' : 'Inativo');
			item.append(titulo, detalhes);
			listaSemelhantes.appendChild(item);
		});
		painelSemelhantes.hidden = false;
	}

	campoTituloCurso.addEventListener('input', function () {
		clearTimeout(temporizadorBusca);
		const termo = this.value.trim();
		if (controleBusca) controleBusca.abort();
		if (termo.length < 3) {
			ocultarSemelhantes();
			return;
		}

		temporizadorBusca = setTimeout(async function () {
			controleBusca = new AbortController();
			try {
				const resposta = await fetch('<?=base_url('restrito/cursos/buscar_titulos')?>?q=' + encodeURIComponent(termo), {
					headers: {'X-Requested-With': 'XMLHttpRequest'},
					signal: controleBusca.signal
				});
				if (!resposta.ok) throw new Error('Falha ao consultar cursos.');
				mostrarSemelhantes(await resposta.json());
			} catch (erro) {
				if (erro.name !== 'AbortError') ocultarSemelhantes();
			}
		}, 300);
	});
})();
</script>
<script>
    const selectEvento = document.getElementById('tipo_evento');
    const inputLocal = document.getElementById('local');
	const inputCourseId = document.getElementById('courseid_input');
	const inputDataInicio = document.getElementById('data_inicio');
	const ajudaCourseId = document.getElementById('courseid_ajuda');
	const editandoCurso = document.getElementById('id_registro').value !== '';
	const cadastroUrm = <?= json_encode(!empty($preenchimento_urm)) ?>;
	const courseIdUrmSugerido = <?= json_encode((string) ($courseid_padrao ?? '')) ?>;
	const tiposCourseIdAutomatico = ['3', '4', '7'];
	let requisicaoCourseId = 0;

	async function atualizarCourseIdAutomatico() {
		const tipoEvento = selectEvento.value;
		const tipoAutomatico = tiposCourseIdAutomatico.includes(tipoEvento);
		// Invalida respostas pendentes quando o usuário muda de tipo.
		const numeroRequisicao = ++requisicaoCourseId;
		if (cadastroUrm && tipoEvento === '3') {
			if (inputCourseId.readOnly || inputCourseId.dataset.geradoAutomaticamente === 'true') {
				inputCourseId.value = courseIdUrmSugerido;
			}
			inputCourseId.dataset.geradoAutomaticamente = 'false';
			inputCourseId.readOnly = false;
			inputCourseId.style.backgroundColor = '';
			ajudaCourseId.textContent = 'CourseID sugerido: URM + próximo sequencial + ano atual. Você pode alterá-lo antes de salvar.';
			return;
		}

		if (!tipoAutomatico) {
			inputCourseId.readOnly = false;
			inputCourseId.style.backgroundColor = '';
			ajudaCourseId.textContent = 'Insira o ID numérico ou selecione na lista acima.';
			if (!editandoCurso && inputCourseId.dataset.geradoAutomaticamente === 'true') inputCourseId.value = '';
			inputCourseId.dataset.geradoAutomaticamente = 'false';
			return;
		}

		inputCourseId.readOnly = true;
		inputCourseId.style.backgroundColor = '#e9ecef';
		ajudaCourseId.textContent = 'CourseID preenchido automaticamente conforme o tipo e o ano do evento.';
		if (editandoCurso) return;

		const anoEvento = inputDataInicio.value ? new Date(inputDataInicio.value).getFullYear() : new Date().getFullYear();
		inputCourseId.value = 'Calculando...';

		try {
			const resposta = await fetch('<?=base_url('restrito/cursos/proximo_courseid')?>?tipo_evento=' + encodeURIComponent(tipoEvento) + '&ano=' + encodeURIComponent(anoEvento), {
				headers: {'X-Requested-With': 'XMLHttpRequest'}
			});
			const retorno = await resposta.json();
			if (numeroRequisicao !== requisicaoCourseId) return;
			if (retorno.status === 'success') {
				inputCourseId.value = retorno.courseid;
				inputCourseId.dataset.geradoAutomaticamente = 'true';
			} else {
				inputCourseId.value = '';
				ajudaCourseId.textContent = retorno.message || 'Não foi possível calcular o CourseID.';
			}
		} catch (erro) {
			if (numeroRequisicao !== requisicaoCourseId) return;
			inputCourseId.value = '';
			ajudaCourseId.textContent = 'Não foi possível calcular o CourseID automaticamente.';
		}
	}

    selectEvento.addEventListener('change', function() {
        if (this.value === "2") {
            // 1. Preenche com "Online"
            inputLocal.value = "Online";
            // 2. Bloqueia a edição
            inputLocal.readOnly = true;
            // Opcional: Adiciona um fundo cinza para indicar visualmente o bloqueio
            inputLocal.style.backgroundColor = "#e9ecef"; 
        } else {
            // 1. Limpa o campo
            inputLocal.value = "";
            // 2. Libera a edição
            inputLocal.readOnly = false;
            // Restaura a cor original
            inputLocal.style.backgroundColor = ""; 
        }
		atualizarCourseIdAutomatico();
    });

	inputDataInicio.addEventListener('change', atualizarCourseIdAutomatico);

    // Executa uma vez ao carregar a página para o caso de já vir preenchido do PHP
    window.addEventListener('load', function() {
        if (selectEvento.value === "2") {
            inputLocal.readOnly = true;
            inputLocal.style.backgroundColor = "#e9ecef";
        }
		atualizarCourseIdAutomatico();
		document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
			bootstrap.Tooltip.getOrCreateInstance(el);
		});
    });
</script>
<script>
// PREVIA DA IMAGEM SELECIONADA	
function previewImage(input, isNew = false) {
    const file = input.files[0];
    const preview = isNew ? document.getElementById('newImgPreview') : document.getElementById('imgPreview');
    const label = document.getElementById('previewLabel');
    const container = document.getElementById('newPreviewContainer');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            // Atualiza a imagem com o conteúdo do arquivo selecionado
            preview.src = e.target.result;
            
            if (!isNew) {
                // Efeito visual para mostrar que mudou
                preview.style.opacity = '0.5';
                setTimeout(() => { preview.style.opacity = '1'; }, 100);
                label.innerHTML = "✨ Nova Imagem Selecionada";
                label.classList.replace('bg-dark', 'bg-success');
                label.style.background = "#198754"; // Verde sucesso
            } else {
                container.classList.remove('d-none');
            }
        }

        reader.readAsDataURL(file);
    }
}
</script>
<script>
	
	let html = <?= json_encode($topicos) ?> ? <?= json_encode($topicos) ?> : "";
		
	if (html !== "") {
		let texto = html
			.replace(/<\/li>/g, "\n")
			//.replace(/;/g, "")
			.replace(/<li>/g, "")
			.replace(/<\/?ul>/g, "")
			.trim();

		//console.log(texto);

		document.getElementById("topicos").value = texto;
	}
</script>
<script>
	$("#formCurso").submit(async function(e) {
		e.preventDefault();
		
		
			console.log('Cadastrando Evento...');
				
			try {
			
				// Atualiza conteúdo do Quill
				var descricao = quill.root.innerHTML;
	
				var form = document.getElementById("formCurso");
				var fd = new FormData(form);
				//Adicionar ao FormData
				fd.append("descricao", descricao);
				
				let id = $("#id_registro").val();
				console.log(id);
				
				console.log(fd);

				const resposta = await $.ajax({
						type: "POST",
						url: '<?=base_url()?>restrito/cursos/salvar',
						data: fd,
						dataType: 'text',
						enctype: "multipart/form-data",
						contentType: false,
						processData: false,
						beforeSend: function() {
							console.log('Enviando dados...');
						}
					});

				let retorno;
				try {
					retorno = JSON.parse(resposta.trim());
				} catch (erroJson) {
					const inicioJson = resposta.indexOf('{');
					const fimJson = resposta.lastIndexOf('}');
					if (inicioJson === -1 || fimJson < inicioJson) throw erroJson;
					retorno = JSON.parse(resposta.substring(inicioJson, fimJson + 1));
				}

				if (retorno.status === 'success' && retorno.id) {
					$('#id_registro').val(retorno.id);
				}
				const mensagem = document.createElement('div');
				const confirmacao = document.createElement('p');
				confirmacao.textContent = retorno.message || 'Não foi possível concluir a operação.';
				mensagem.appendChild(confirmacao);
				if (retorno.warning) {
					const aviso = document.createElement('p');
					aviso.className = 'text-danger small mb-0';
					aviso.textContent = retorno.warning;
					mensagem.appendChild(aviso);
				}
				await Swal.fire({
					title: retorno.status === 'success' ? 'Sucesso!' : 'Erro!',
					html: mensagem,
					icon: retorno.status === 'success' ? 'success' : 'error',
					confirmButtonText: 'OK'
				});

				if (retorno.status === 'success' && !id) {
					window.location.href = <?= json_encode(base_url('restrito/urm/listar')) ?>;
				}

				return retorno;
			} catch (error) {
				console.log('Erro geral:', error);
				let mensagemErro = error.responseJSON?.message || null;
				if (!mensagemErro && typeof error.responseText === 'string') {
					try {
						const respostaTexto = error.responseText.trim();
						const inicioJson = respostaTexto.indexOf('{');
						const fimJson = respostaTexto.lastIndexOf('}');
						const respostaErro = JSON.parse(
							inicioJson >= 0 && fimJson >= inicioJson
								? respostaTexto.substring(inicioJson, fimJson + 1)
								: respostaTexto
						);
						mensagemErro = respostaErro.message;
					} catch (erroResposta) {
						console.log('Resposta inválida do servidor:', error.responseText);
					}
				}
				Swal.fire({
					title: 'Erro!',
					text: mensagemErro || 'Não foi possível salvar o curso.',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				return false;
			}	
	});
</script>

