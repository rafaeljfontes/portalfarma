
<!-- CSS GERAL -->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css">
<style>
	.kpi-filtro { cursor: pointer; transition: transform .2s ease, box-shadow .2s ease, outline-color .2s ease; }
	.kpi-filtro:hover { transform: translateY(-2px); }
	.kpi-filtro.active { outline: 2px solid #0d6efd; outline-offset: 2px; }
	.status-curso.success { color: #198754; }
	.status-curso.danger { color: #dc3545; }
	.tipo-evento-universitario {
		background: #dcecf2;
		color: #004761;
		border: 1px solid #004761;
	}
	#paginacao-cursos { gap: .35rem; justify-content: center; }
	#paginacao-cursos .page-link {
		border-radius: .65rem !important;
		min-width: 34px;
		text-align: center;
	}
</style>
<script>
document.querySelectorAll('.btn-filtro').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.btn-filtro')
            .forEach(b => b.classList.remove('active'));

        btn.classList.add('active');

        const filtro = btn.dataset.filtro;
        console.log('Filtro selecionado:', filtro);
    });
});
</script>
<?php
	
	$totalLinhas = count($tabelaCurso);
	$qtdOnline = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '2';
	}));
	$qtdPresencial = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '1';
	}));
	$qtdurm = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '3';
	}));
	$qtdfh = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '4';
	}));
	$qtdUNI = count(array_filter($tabelaCurso, function($cursos) {
    	return in_array($cursos->tipo_evento, ['5', '6'], true);
	}));
	$qtdSVS = count(array_filter($tabelaCurso, function($cursos) {
		return $cursos->tipo_evento === '7';
	}));
	
?>
<div class="container">
    <?php if (empty($designacoesDisponiveis)): ?>
    <div class="alert alert-warning">As designações ainda não estão disponíveis. Execute a migração <code>database/tbl_portalfarma_func_designado.sql</code> no banco do PortalFarma.</div>
    <?php endif; ?>
    <?php if (!empty($avaIndisponivel)): ?>
    <div class="alert alert-warning" role="alert">Os totais de inscritos no AVA estão temporariamente indisponíveis. Os dados dos eventos continuam disponíveis.</div>
    <?php endif; ?>
    <div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
		<div class="d-flex align-items-center mb-2 mb-md-0">
			<i class="fas fa-calendar-alt text-primary me-2 fs-4"></i>
			<h4 class="mb-0 text-primary">Gerenciar Eventos</h4>
		</div>
		
		<div class="d-flex gap-2 flex-wrap">
		<a href="<?=htmlspecialchars(base_url('restrito/capacifar/listar'.(!empty($filtro) ? '/'.rawurlencode($filtro) : '')).(!empty($designadosAMim) ? '' : '?designados=1'), ENT_QUOTES, 'UTF-8')?>" class="btn btn-<?=!empty($designadosAMim) ? 'primary' : 'outline-primary'?>" aria-pressed="<?=!empty($designadosAMim) ? 'true' : 'false'?>"><i class="bi bi-person-check me-1"></i>Designados a mim</a>
		<a href="<?=base_url()?>restrito/cursos/cadastrar" class="btn btn-primary btn-cadastrar" data-bs-toggle="tooltip" title="Cadastrar um novo evento">
			<i class="fas fa-plus"></i> Cadastrar Evento
		</a>
		</div>
	</div>
	
	
	
	<div class="kpi-container">
		<div class="kpi-card shadow-sm kpi-filtro active" role="button" tabindex="0" data-filtro-tipo="todos" data-tooltip="true" title="Mostrar todos os eventos">
			<div class="kpi-icon bg-primary text-white"><i class="bi bi-collection"></i></div>
			<div class="kpi-info">
				<h6>Total Eventos</h6>
				<span><?=$totalLinhas;?></span>
			</div>
		</div>
		<div class="kpi-card shadow-sm kpi-filtro" role="button" tabindex="0" data-filtro-tipo="Online" data-tooltip="true" title="Mostrar somente eventos online">
			<div class="kpi-icon bg-success text-white"><i class="bi bi-globe"></i></div>
			<div class="kpi-info">
				<h6>Online</h6>
				<span><?=$qtdOnline;?></span>
			</div>
		</div>
		<div class="kpi-card shadow-sm kpi-filtro" role="button" tabindex="0" data-filtro-tipo="Presencial" data-tooltip="true" title="Mostrar somente eventos presenciais">
			<div class="kpi-icon bg-info text-white"><i class="bi bi-people"></i></div>
			<div class="kpi-info">
				<h6>Presencial</h6>
				<span><?=$qtdPresencial;?></span>
			</div>
		</div>
		<div class="kpi-card shadow-sm kpi-filtro" role="button" tabindex="0" data-filtro-tipo="Universitário" data-tooltip="true" title="Mostrar somente eventos universitários">
			<div class="kpi-icon bg-info text-white"><i class="bi bi-people"></i></div>
			<div class="kpi-info">
				<h6>Universitário</h6>
				<span><?=$qtdUNI;?></span>
			</div>
		</div>
	</div>
	
	<?php
	if ($totalLinhas == 0){
		echo "nenhum retorno";
	} else {

	?>
    <div class="row">
        <div class="col">
            <table class="table table-hover border shadow-sm" id="table_programacao" style="font-size: 12px; background: white;">
				<thead>
					<tr>
						<th class="align-top">
							MOODLE
							<input type="text" class="filter-input" placeholder="ID..." onkeyup="filterTable(0, this.value)">
							<select class="filter-input mt-1" id="filtro-status-curso" onchange="definirFiltroStatus(this.value)" data-tooltip="true" title="Filtrar cursos ativos ou inativos">
								<option value="todos">Todos os status</option>
								<option value="ativo">Ativos</option>
								<option value="inativo">Inativos</option>
							</select>
						</th>
						<th class="align-top">IMG</th>
						<th class="align-top">
							TIPO
							<select class="filter-input" onchange="filterTable(2, this.value)">
								<option value="">Todos</option>
								<option value="Online">Online</option>
								<option value="Presencial">Presencial</option>
								<option value="Universitário">Universitário</option>
							</select>
						</th>
						<th class="align-top">
							NOME
							<input type="text" class="filter-input" placeholder="Buscar nome..." onkeyup="filterTable(3, this.value)">
						</th>
						<th class="align-top text-center">DATAS</th>
						<th class="align-top text-center">CH</th>
						<th class="align-top text-center">INFOS</th>
						<th class="align-top">Designado</th>
						<th class="align-top text-center">AÇÕES</th>
					</tr>
				</thead>
                <tbody>
					<?php 
					
					foreach ($tabelaCurso as $campo){
						
						// Lógica de Status
						$is_ativo = ($campo->status == 1);
						$status_label = $is_ativo ? 'Ativo' : 'Inativo';
						$status_class = $is_ativo ? 'bg-ativo' : 'bg-desativado';
						$status_icon = $is_ativo ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
						
						// Lógica de Tipo 
						$campo_evento = "Outro";
						if($campo->tipo_evento == 1) $campo_evento = "Presencial";
						if($campo->tipo_evento == 2) $campo_evento = "Online";
						if($campo->tipo_evento == 3) $campo_evento = "Evento";
						if (in_array($campo->tipo_evento, [5, 6])) {
							$campo_evento = "Universitário";
						}
						$classe_tipo = strtolower($campo_evento);
						//if($campo->tipo_evento == 5) $classe_tipo = 'universitario';
						$totalInscritosAva = !empty($avaIndisponivel) ? 'Indisponível' : ($inscritosAvaPorCurso[(int) $campo->courseid] ?? 0);
						$palestrantesModal = !empty($campo->palestrantes) ? implode("\n", array_map('trim', explode(',', $campo->palestrantes))) : 'Nenhum palestrante informado.';
					?>
					<tr class="position-relative linha-curso" data-tipo-evento="<?=htmlspecialchars($campo_evento, ENT_QUOTES, 'UTF-8')?>" data-status-curso="<?=$is_ativo ? 'ativo' : 'inativo'?>">
						<td class="text-center align-middle">
							<div class="status-indicator <?= $status_class ?>"></div>
							<small class="text-muted d-block">ID MOODLE</small>
							<span class="fw-bold">#<?= $campo->courseid; ?></span>
							<div class="status-curso mt-1 fw-bold <?=$is_ativo ? 'success' : 'danger'?>" title="Curso <?=$status_label?>">
								<i class="bi <?=$status_icon?> me-1"></i><?=strtoupper($status_label)?>
							</div>
						</td>

						<td class="align-middle" style="width: 80px;">
							<img src="<?=base_url()?>uploads/cursos/<?= $campo->nome_curto; ?>.png" 
								 class="img-curso" loading="lazy" decoding="async"
								 style="width: 70px; height: 45px;" >
						</td>

						<td class="align-middle">
							<span class="badge-tipo tipo-evento-<?= $classe_tipo; ?>"><?= $campo_evento; ?></span>
						</td>

						<td class="align-middle">
							<div class="fw-bold" style="color:#054589; font-size: 14px;"><?= $campo->titulo; ?></div>
							<small class="text-muted">Cadastrado em: <?= date('d/m/Y', strtotime($campo->data_cadastro)); ?></small>
						</td>

						<td class="align-middle text-center">
							<div class="d-flex flex-column align-items-center">
								<span class="fw-bold text-dark" style="font-size: 14px;">
									<i class="bi bi-calendar-check text-success me-1"></i> 
									<?= date('d/m/Y', strtotime($campo->data_inicio)); ?>
									<span class="text-muted fw-normal ms-1">
										<i class="bi bi-clock"></i> <?= date('H:i', strtotime($campo->data_inicio)); ?>
									</span>
								</span>

								<small class="text-muted">
									<i class="bi bi-calendar-x me-1"></i> 
									<?php if(!empty($campo->data_fim)): ?>
										<?= date('d/m/Y', strtotime($campo->data_fim)); ?>
										<span class="ms-1"><i class="bi bi-clock"></i> <?= date('H:i', strtotime($campo->data_fim)); ?></span>
									<?php else: ?>
										---
									<?php endif; ?>
								</small>
							</div>
						</td>

						<td class="text-center align-middle">
							<span class="badge bg-light text-dark border" style="font-size: 14px;"><?= $campo->carga_horaria / 60; ?>h</span>
						</td>

						<td class="align-middle">
							<div class="d-flex flex-column align-items-center gap-1">
								<div><span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 14px;" data-bs-toggle="tooltip" title="<?=$totalInscritosAva?> inscritos ativos no AVA"><i class="bi bi-people-fill me-1"></i><?=$totalInscritosAva?></span></div>
								<div class="d-flex gap-1 justify-content-center">
									<button type="button" class="btn btn-sm btn-outline-primary info-link btn-info-modal" data-titulo="Tópicos" data-conteudo="<?=htmlspecialchars(strip_tags((string) $campo->topicos), ENT_QUOTES, 'UTF-8')?>" data-tooltip="true" title="Visualizar os tópicos do curso"><i class="bi bi-card-list"></i></button>
									<button type="button" class="btn btn-sm btn-outline-primary info-link btn-info-modal" data-titulo="Descrição" data-conteudo="<?=htmlspecialchars(strip_tags((string) $campo->descricao), ENT_QUOTES, 'UTF-8')?>" data-tooltip="true" title="Visualizar a descrição do curso"><i class="bi bi-card-text"></i></button>
								</div>
								<div class="d-flex gap-1 justify-content-center">
									<button type="button" class="btn btn-sm btn-outline-primary info-link btn-info-modal" data-titulo="Palestrantes" data-conteudo="<?=htmlspecialchars($palestrantesModal, ENT_QUOTES, 'UTF-8')?>" data-tooltip="true" title="Visualizar os palestrantes do curso"><i class="bi bi-mic"></i></button>
									<button type="button" class="btn btn-sm btn-outline-primary info-link btn-info-modal" data-titulo="Programação" data-conteudo="<?=htmlspecialchars(strip_tags((string) $campo->programacao), ENT_QUOTES, 'UTF-8')?>" data-tooltip="true" title="Visualizar a programação do curso"><i class="bi bi-calendar3"></i></button>
								</div>
							</div>
						</td>
						
						<td class="align-middle" style="min-width:150px">
							<div style="white-space:pre-line"><?=htmlspecialchars(($campo->designados_nomes ?? '') ?: 'Nenhum usuário designado', ENT_QUOTES, 'UTF-8')?></div>
							<button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-designar" data-courseid="<?=htmlspecialchars((string) $campo->courseid, ENT_QUOTES, 'UTF-8')?>" data-titulo="<?=htmlspecialchars($campo->titulo, ENT_QUOTES, 'UTF-8')?>" data-usuarios="<?=htmlspecialchars($campo->designados_ids ?? '', ENT_QUOTES, 'UTF-8')?>" <?=empty($designacoesDisponiveis) ? 'disabled' : ''?> title="Gerenciar usuários designados"><i class="bi bi-person-plus"></i> Designar</button>
						</td>
						<td class="text-center align-middle">
							<div class="btn-group shadow-sm">
                                <a href="<?=base_url('restrito/Capacifar/grupos/'.(int) $campo->courseid)?>" class="btn btn-sm btn-outline-primary px-3" title="Ver grupos e participantes do Moodle">Grupos</a>
								<a href="https://portalfarma.crfmg.org.br/moodle/course/view.php?id=<?=$campo->courseid?>" 
								   class="btn btn-sm btn-outline-primary px-3" 
								   data-bs-toggle="tooltip" title="Abrir este curso no Portal do Aluno" target="_blank">
									<i class="bi bi-box-arrow-up-right"></i>
								</a>
								<a href="<?=base_url()?>restrito/Capacifar/lista_inscritos/<?=$campo->courseid?>" 
								   class="btn btn-sm btn-outline-primary px-3" 
								   data-bs-toggle="tooltip" title="Visualizar a lista de inscritos deste curso">
									<i class="bi bi-people"></i>
								</a>
								<a href="<?=base_url()?>restrito/cursos/editar/<?=$campo->id?>" class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="tooltip" title="Editar os dados deste curso">
									<i class="bi bi-pencil"></i>
								</a>
								<button type="button" class="btn btn-sm btn-outline-primary px-3 btn-opcoes-nps"
									data-url-acessar="<?=base_url('nps/listar')?>?courseid=<?=urlencode($campo->courseid)?>"
									data-url-gerar="<?=base_url('nps/')?><?=urlencode($campo->courseid)?>"
									data-url-relatorios="<?=base_url('restrito/capacifar/relatorios/'.(int) $campo->courseid)?>"
									data-courseid="<?=htmlspecialchars($campo->courseid, ENT_QUOTES, 'UTF-8')?>"
									data-bs-toggle="tooltip" title="Acessar o painel ou gerar o link público do NPS deste curso">
									<i class="bi bi-bar-chart-line"></i>
								</button>
								<button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" data-tooltip="true" title="Abrir opções de ativação ou inativação"></button>
								<ul class="dropdown-menu dropdown-menu-end shadow border-0">
									<li><h6 class="dropdown-header">Status: <?= $status_label ?></h6></li>
									<li>
										<button type="button" class="dropdown-item btn-historico-curso d-flex align-items-center gap-2" data-id="<?= $campo->id ?>" data-curso="<?=htmlspecialchars($campo->titulo, ENT_QUOTES, 'UTF-8')?>" data-tooltip="true" title="Visualizar o histórico de alterações deste curso">
											<i class="bi bi-clock-history text-primary"></i> <span>Histórico</span>
										</button>
									</li>
									<li><hr class="dropdown-divider"></li>
									<li>
										<button type="button" class="dropdown-item btn-status d-flex align-items-center gap-2" data-id="<?= $campo->id ?>" data-status="<?= $campo->status ?>" data-tooltip="true" title="<?=$is_ativo ? 'Inativar este curso' : 'Ativar este curso'?>">
											<?php if($is_ativo): ?>
												<i class="bi bi-ban text-danger"></i> <span class="text-danger">Desativar</span>
											<?php else: ?>
												<i class="bi bi-check2-circle text-success"></i> <span class="text-success">Ativar</span>
											<?php endif; ?>
										</button>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<?php } ?>
					</tbody>
			</table>
			<div class="d-flex flex-column justify-content-center align-items-center gap-2 mt-3 text-center">
				<small class="text-muted" id="resumo-paginacao-cursos"></small>
				<nav aria-label="Paginação dos cursos">
					<ul class="pagination pagination-sm mb-0" id="paginacao-cursos"></ul>
				</nav>
			</div>
        </div>
    </div>
	<?php
	}
	?>
</div>
<style>
#modalDesignacoes .designacao-usuario { display:flex; align-items:center; gap:12px; padding:12px 0; margin:0; cursor:pointer; }
#modalDesignacoes .designacao-usuario input[type="checkbox"] { position:static !important; float:none !important; margin:0 !important; transform:none !important; opacity:1 !important; width:18px; height:18px; flex:0 0 18px; }
#modalDesignacoes .designacao-avatar { width:36px; height:36px; flex:0 0 36px; border-radius:50%; object-fit:cover; border:1px solid #e4e7ec; background:#f2f4f7; }
#modalDesignacoes .designacao-nome { min-width:0; flex:1; overflow-wrap:anywhere; line-height:1.4; }
</style>
<div class="modal fade" id="modalDesignacoes" tabindex="-1" aria-labelledby="tituloDesignacoes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title" id="tituloDesignacoes">Usuários designados</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button></div>
        <form id="formDesignacoes">
            <div class="modal-body">
                <p id="cursoDesignacoes" class="fw-semibold"></p>
                <p class="small text-muted">Marque os usuários responsáveis. Desmarcar remove a designação. Salvar sem selecionar ninguém remove todos os vínculos.</p>
                <?php foreach (($usuariosDesignacao ?? []) as $usuarioDesignacao):
                    $avatarPadrao = base_url('assets/palestrantes/avatar_palestrante.png');
                    $fotoUsuario = trim((string) ($usuarioDesignacao->foto ?? ''));
                    if ($fotoUsuario === '' || preg_match('/^(?!https?:\/\/)[a-z][a-z0-9+.-]*:/i', $fotoUsuario) || strpos($fotoUsuario, '//') === 0) {
                        $fotoUsuario = $avatarPadrao;
                    } elseif (!preg_match('/^https?:\/\//i', $fotoUsuario) && strpos($fotoUsuario, '/') !== 0) {
                        $fotoUsuario = base_url($fotoUsuario);
                    }
                ?>
                    <label class="designacao-usuario border-bottom">
                        <input type="checkbox" class="form-check-input" name="usuarios[]" value="<?=(int) $usuarioDesignacao->id?>">
                        <img class="designacao-avatar" src="<?=htmlspecialchars($fotoUsuario, ENT_QUOTES, 'UTF-8')?>" alt="" loading="lazy" onerror="this.onerror=null;this.src=<?=htmlspecialchars(json_encode($avatarPadrao), ENT_QUOTES, 'UTF-8')?>;">
                        <span class="designacao-nome"><?=htmlspecialchars($usuarioDesignacao->nome, ENT_QUOTES, 'UTF-8')?></span>
                    </label>
                <?php endforeach; ?>
                <?php if (empty($usuariosDesignacao)): ?><p class="text-muted">Nenhum usuário ativo disponível.</p><?php endif; ?>
                <div id="retornoDesignacoes" class="small mt-3" role="status" aria-live="polite"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary" id="salvarDesignacoes">Salvar designações</button></div>
        </form>
    </div></div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formDesignacoes');
    const elemento = document.getElementById('modalDesignacoes');
    const status = document.getElementById('retornoDesignacoes');
    const salvar = document.getElementById('salvarDesignacoes');
    let courseid = '', enviando = false;
    elemento.addEventListener('hide.bs.modal', function (e) { if (enviando) e.preventDefault(); });
    document.querySelectorAll('.btn-designar').forEach(function (botao) {
        botao.addEventListener('click', function () {
            courseid = botao.dataset.courseid;
            document.getElementById('cursoDesignacoes').textContent = botao.dataset.titulo;
            const selecionados = (botao.dataset.usuarios || '').split(',');
            form.querySelectorAll('input[name="usuarios[]"]').forEach(c => c.checked = selecionados.includes(c.value));
            status.textContent = '';
            bootstrap.Modal.getOrCreateInstance(elemento).show();
        });
    });
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (enviando) return;
        enviando = true; salvar.disabled = true; status.className = 'small mt-3'; status.textContent = 'Salvando...';
        try {
            const resposta = await fetch(<?=json_encode(base_url('restrito/Capacifar/salvar_designacoes'))?>, {
                method: 'POST', credentials: 'same-origin', headers: {'Content-Type':'application/json'},
                body: JSON.stringify({csrf: <?=json_encode($designacoesCsrf ?? '')?>, courseid,
                    usuarios: Array.from(form.querySelectorAll('input[name="usuarios[]"]:checked'), c => c.value)})
            });
            const retorno = await resposta.json();
            if (!resposta.ok || !retorno.ok) throw new Error(retorno.message || 'Falha ao salvar designações.');
            status.className = 'small mt-3 text-success'; status.textContent = retorno.message;
            window.location.reload();
        } catch (erro) {
            status.className = 'small mt-3 text-danger'; status.textContent = erro.message || 'Não foi possível salvar. Tente novamente.';
            enviando = false; salvar.disabled = false;
        }
    });
});
</script>
<div class="modal fade" id="modalHistoricoCurso" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h5 class="modal-title"><i class="bi bi-clock-history text-primary me-2"></i>Histórico do curso</h5>
					<small class="text-muted" id="nomeCursoHistorico"></small>
				</div>
				<button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" data-tooltip="true" title="Fechar o histórico"><i class="bi bi-x-lg text-white me-1"></i>Fechar</button>
			</div>
			<div class="modal-body">
				<div id="carregandoHistoricoCurso" class="py-5 text-center text-muted">
					<div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>Carregando histórico...
				</div>
				<div id="listaHistoricoCurso" class="list-group list-group-flush"></div>
			</div>
			<div class="modal-footer"><button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-tooltip="true" title="Fechar o histórico"><i class="bi bi-x-lg text-white me-1"></i>Fechar</button></div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalInformacaoCurso" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tituloInformacaoCurso">Informações do curso</h5>
				<button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" data-tooltip="true" title="Fechar as informações"><i class="bi bi-x-lg text-white me-1"></i>Fechar</button>
			</div>
			<div class="modal-body"><div id="conteudoInformacaoCurso" class="p-3 bg-light border rounded" style="white-space: pre-wrap;"></div></div>
			<div class="modal-footer"><button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-tooltip="true" title="Fechar as informações"><i class="bi bi-x-lg text-white me-1"></i>Fechar</button></div>
		</div>
	</div>
</div>
<!-- MOdal Confirmação --> 
<div class="modal fade" id="modalConfirmar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmação</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" data-tooltip="true" title="Fechar a confirmação"></button>
            </div>

            <div class="modal-body">
                <p id="textoConfirmacao"></p>
            </div>

            <div class="modal-footer">
				<button class="btn btn-secondary" data-bs-dismiss="modal" data-tooltip="true" title="Cancelar a alteração de status">Cancelar</button>
				<button id="confirmarAlteracao" class="btn btn-primary" data-tooltip="true" title="Confirmar a alteração de status">Confirmar</button>
            </div>

        </div>
    </div>
</div>
<!-- MOdal REtorno --> 
<div class="modal fade" id="modalRetorno" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Resultado</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" data-tooltip="true" title="Fechar a mensagem de resultado"></button>
            </div>

            <div class="modal-body">
                <p id="mensagemRetorno"></p>
            </div>

        </div>
    </div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(){
		document.querySelectorAll('[data-bs-toggle="tooltip"], [data-tooltip="true"]').forEach(function (el) {
			bootstrap.Tooltip.getOrCreateInstance(el);
		});

		document.querySelectorAll('.btn-info-modal').forEach(function (botao) {
			botao.addEventListener('click', function () {
				document.getElementById('tituloInformacaoCurso').textContent = botao.dataset.titulo || 'Informações do curso';
				document.getElementById('conteudoInformacaoCurso').textContent = botao.dataset.conteudo || 'Informação não cadastrada.';
				bootstrap.Modal.getOrCreateInstance(document.getElementById('modalInformacaoCurso')).show();
			});
		});

		document.querySelectorAll('.btn-historico-curso').forEach(function (botao) {
			botao.addEventListener('click', function () {
				var idCurso = botao.dataset.id;
				var modalElemento = document.getElementById('modalHistoricoCurso');
				var carregando = document.getElementById('carregandoHistoricoCurso');
				var lista = document.getElementById('listaHistoricoCurso');
				document.getElementById('nomeCursoHistorico').textContent = botao.dataset.curso || '';
				lista.innerHTML = '';
				carregando.style.display = '';
				bootstrap.Modal.getOrCreateInstance(modalElemento).show();

				fetch('<?=base_url('restrito/cursos/historico/')?>' + encodeURIComponent(idCurso), {
					headers: {'X-Requested-With': 'XMLHttpRequest'}
				})
				.then(function (resposta) { return resposta.json(); })
				.then(function (retorno) {
					carregando.style.display = 'none';
					if (retorno.status !== 'success') throw new Error(retorno.message || 'Erro ao carregar histórico.');

					if (!retorno.historico.length) {
						lista.innerHTML = '<div class="text-center text-muted py-5"><i class="bi bi-clock-history fs-2 d-block mb-2"></i>Nenhuma alteração registrada para este curso.</div>';
						return;
					}

					retorno.historico.forEach(function (registro, indice) {
						var item = document.createElement('div');
						item.className = 'list-group-item px-0 py-3';
						var linha = document.createElement('div');
						linha.className = 'd-flex justify-content-between align-items-start gap-3';
						var dados = document.createElement('div');
						var acao = document.createElement('div');
						acao.className = 'fw-semibold text-dark';
						acao.textContent = registro.acao;
						var usuario = document.createElement('small');
						usuario.className = 'text-muted d-block mt-1';
						usuario.innerHTML = '<i class="bi bi-person me-1"></i>';
						usuario.appendChild(document.createTextNode(registro.usuario));
						var data = document.createElement('span');
						data.className = 'badge bg-light text-dark border text-nowrap';
						data.textContent = registro.data_formatada;
						dados.appendChild(acao); dados.appendChild(usuario);
						linha.appendChild(dados); linha.appendChild(data); item.appendChild(linha); lista.appendChild(item);
					});
				})
				.catch(function (erro) {
					carregando.style.display = 'none';
					lista.innerHTML = '<div class="alert alert-danger mb-0"></div>';
					lista.firstElementChild.textContent = erro.message || 'Não foi possível carregar o histórico.';
				});
			});
		});

		document.querySelectorAll('.btn-opcoes-nps').forEach(function (botao) {
			botao.addEventListener('click', function () {
				Swal.fire({
					title: 'Opções do curso ' + botao.dataset.courseid,
					text: 'Escolha o que deseja fazer:',
					html: '<p>Escolha o que deseja fazer:</p><a id="link-relatorios-curso" class="btn btn-outline-primary w-100"><i class="bi bi-graph-up me-1"></i> Relatórios</a>',
					didOpen: function () {
						document.getElementById('link-relatorios-curso').href = botao.dataset.urlRelatorios;
					},
					icon: 'question',
					showDenyButton: true,
					showCancelButton: true,
					confirmButtonText: '<i class="bi bi-bar-chart-line me-1"></i> Acessar NPS',
					denyButtonText: '<i class="bi bi-link-45deg me-1"></i> Gerar link NPS',
					cancelButtonText: 'Cancelar',
					confirmButtonColor: '#465fff',
					denyButtonColor: '#198754'
				}).then(function (resultado) {
					if (resultado.isConfirmed) {
						window.location.href = botao.dataset.urlAcessar;
					} else if (resultado.isDenied) {
						window.location.href = botao.dataset.urlGerar;
					}
				});
			});
		});

		document.querySelectorAll('.kpi-filtro').forEach(function (kpi) {
			function aplicarKpi() {
				filtroKpiAtual = kpi.dataset.filtroTipo || 'todos';
				document.querySelectorAll('.kpi-filtro').forEach(function (item) { item.classList.remove('active'); });
				kpi.classList.add('active');
				filtrarPorKpi();
			}
			kpi.addEventListener('click', aplicarKpi);
			kpi.addEventListener('keydown', function (event) {
				if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); aplicarKpi(); }
			});
		});

});
</script>
<script>
	let idSelecionado = null;
		let statusAtual = null;

		$(document).on("click",".btn-status",function(){

			idSelecionado = $(this).data("id");
			statusAtual = $(this).data("status");

			let texto = statusAtual == 1 
				? "Deseja desativar este curso?" 
				: "Deseja ativar este curso?";

			$("#textoConfirmacao").text(texto);

			const modal = new bootstrap.Modal(document.getElementById('modalConfirmar'));
			modal.show();

		});
</script>
<script>
	$("#confirmarAlteracao").click(function(){

    $.ajax({

        url: "<?=base_url()?>restrito/cursos/alterar_status",
        type: "POST",
        dataType: "json",
        data:{
            id:idSelecionado,
            status:statusAtual
        },

        success:function(res){

            $("#mensagemRetorno").text(res.message);

            const modalRetorno = new bootstrap.Modal(document.getElementById('modalRetorno'));
            modalRetorno.show();

            setTimeout(function(){
                location.reload();
            },1500);

        },

        error:function(){

            $("#mensagemRetorno").text("Erro ao alterar status.");

            const modalRetorno = new bootstrap.Modal(document.getElementById('modalRetorno'));
            modalRetorno.show();
        }

    });

});
</script>
<script>
	/*new DataTable('#table_programacao', {
        info: false,
        ordering: false,
        paging: false,
    });*/


    $(".mudar_status").change(async function(e){
        e.preventDefault();

        try {
            var id      = $(this).data('id-inscrito');
            var status  = $(this).val();

            var data = new FormData();
            data.append('id', id);
            data.append('status', status);

            const result = await $.ajax({
                type: 'POST',
                method: 'POST',
                url: `<?=base_url()?>restrito/mudar-status-inscritos`,
                data: data,
                dataType: 'html',
                enctype:"multipart/form-data",
                contentType: false,
                processData: false,
                beforeSend: function(){
                    // console.log('beforeSend');
                },
                success: function(res){
                    // console.log('success', res);
                }
            }).done(function( res ) {
                // console.log('done',res);

            }).fail(function(res) {
                //console.log('fail',res);

            }).always(function( res ) {
                console.log('always',res);
                var retorno = JSON.parse(res);
                var type = 'default';

                if(retorno.type == 'danger'){
                    type = 'error';
                }
                if(retorno.type == 'success'){
                    type = 'notice';
                }
                $.growl({
                    title: retorno.title,
                    message: retorno.message,
                    style: type,
                });
               
                return res;
            }); 
            
            return result;
        } catch (error) {
            Swal.showValidationMessage(`Falha na requisição: ${error}`);
            return false;
        }

        
    });


</script>

<script>
let filtroKpiAtual = 'todos';
let filtroStatusAtual = 'todos';
let paginaCursosAtual = 1;
const cursosPorPagina = 10;
const filtrosColunaCursos = {};

function definirFiltroStatus(status) {
	filtroStatusAtual = status || 'todos';
	filtrarPorKpi(true);
}

function obterLinhasCursosFiltradas() {
	return Array.from(document.querySelectorAll('#table_programacao tbody .linha-curso')).filter(function (linha) {
		const correspondeTipo = filtroKpiAtual === 'todos' || linha.dataset.tipoEvento === filtroKpiAtual;
		const correspondeStatus = filtroStatusAtual === 'todos' || linha.dataset.statusCurso === filtroStatusAtual;
		const correspondeColunas = Object.keys(filtrosColunaCursos).every(function (indice) {
			const termo = filtrosColunaCursos[indice];
			if (!termo) return true;
			const celula = linha.getElementsByTagName('td')[Number(indice)];
			const texto = celula ? (celula.textContent || celula.innerText).toUpperCase() : '';
			return texto.indexOf(termo) !== -1;
		});
		return correspondeTipo && correspondeStatus && correspondeColunas;
	});
}

function montarPaginacaoCursos(totalPaginas) {
	const paginacao = document.getElementById('paginacao-cursos');
	if (!paginacao) return;
	paginacao.innerHTML = '';

	function adicionarBotao(rotulo, pagina, desabilitado, ativo, ariaLabel) {
		const item = document.createElement('li');
		item.className = 'page-item' + (desabilitado ? ' disabled' : '') + (ativo ? ' active' : '');
		const botao = document.createElement('button');
		botao.type = 'button';
		botao.className = 'page-link';
		botao.innerHTML = rotulo;
		if (ariaLabel) botao.setAttribute('aria-label', ariaLabel);
		if (!desabilitado) {
			botao.addEventListener('click', function () {
				paginaCursosAtual = pagina;
				atualizarTabelaCursos();
			});
		}
		item.appendChild(botao);
		paginacao.appendChild(item);
	}

	adicionarBotao('&laquo;', paginaCursosAtual - 1, paginaCursosAtual === 1, false, 'Página anterior');
	for (let pagina = 1; pagina <= totalPaginas; pagina++) {
		adicionarBotao(String(pagina), pagina, false, pagina === paginaCursosAtual, 'Página ' + pagina);
	}
	adicionarBotao('&raquo;', paginaCursosAtual + 1, paginaCursosAtual === totalPaginas, false, 'Próxima página');
}

function atualizarTabelaCursos() {
	const todasAsLinhas = Array.from(document.querySelectorAll('#table_programacao tbody .linha-curso'));
	const linhasFiltradas = obterLinhasCursosFiltradas();
	const totalPaginas = Math.max(1, Math.ceil(linhasFiltradas.length / cursosPorPagina));
	if (paginaCursosAtual > totalPaginas) paginaCursosAtual = totalPaginas;

	const inicio = (paginaCursosAtual - 1) * cursosPorPagina;
	const fim = inicio + cursosPorPagina;
	const linhasDaPagina = new Set(linhasFiltradas.slice(inicio, fim));
	todasAsLinhas.forEach(function (linha) {
		linha.style.display = linhasDaPagina.has(linha) ? '' : 'none';
	});

	montarPaginacaoCursos(totalPaginas);
	const resumo = document.getElementById('resumo-paginacao-cursos');
	if (resumo) {
		resumo.textContent = linhasFiltradas.length
			? 'Mostrando ' + (inicio + 1) + ' a ' + Math.min(fim, linhasFiltradas.length) + ' de ' + linhasFiltradas.length + ' cursos'
			: 'Nenhum curso encontrado';
	}
}

function filtrarPorKpi(reiniciarPagina) {
	if (reiniciarPagina !== false) paginaCursosAtual = 1;
	atualizarTabelaCursos();
}

function filterTable(colIndex, query) {
	filtrosColunaCursos[colIndex] = (query || '').toUpperCase();
	paginaCursosAtual = 1;
	atualizarTabelaCursos();
}

document.addEventListener('DOMContentLoaded', atualizarTabelaCursos);
</script>
