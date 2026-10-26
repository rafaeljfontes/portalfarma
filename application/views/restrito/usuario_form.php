<?php
	$dadosAnteriores = $this->session->flashdata('usuario_form_dados');
	$dadosAnteriores = is_array($dadosAnteriores) ? $dadosAnteriores : array();
	$permissoesSelecionadas = $dadosAnteriores['permissoes'] ?? array();
?>
<main class="col-md-10 ms-sm-auto px-md-4 py-4">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<div>
			<h3 class="mb-1">Novo usuário</h3>
			<p class="text-muted mb-0">Cadastre um usuário e defina seus acessos ao PortalFarma.</p>
		</div>
		<a href="<?=base_url('restrito/usuarios')?>" class="btn btn-outline-secondary">
			<i class="bi bi-arrow-left me-1"></i> Voltar
		</a>
	</div>

	<?php if ($this->session->flashdata('usuario_form_erro')): ?>
		<div class="alert alert-danger"><?=html_escape($this->session->flashdata('usuario_form_erro'))?></div>
	<?php endif; ?>

	<div class="card border-0 shadow-sm">
		<div class="card-body p-4">
			<form method="post" action="<?=base_url('restrito/usuarios/salvar')?>">
				<div class="mb-4">
					<label for="nome" class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="nome" name="nome" maxlength="255" value="<?=html_escape($dadosAnteriores['nome'] ?? '')?>" placeholder="Nome completo" required autofocus>
				</div>
				<div class="mb-4">
					<label for="user" class="form-label fw-semibold">Usuário <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="user" name="user" maxlength="255" value="<?=html_escape($dadosAnteriores['user'] ?? '')?>" placeholder="Ex.: nome.sobrenome" required>
				</div>

				<div class="mb-4">
					<label class="form-label fw-semibold d-block">Status</label>
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" role="switch" name="status" value="1" id="status" <?=!isset($dadosAnteriores['status']) || (int) $dadosAnteriores['status'] === 1 ? 'checked' : ''?>>
						<label class="form-check-label" for="status">Usuário ativo</label>
					</div>
				</div>

				<div class="mb-4">
					<label class="form-label fw-semibold d-block">Permissões</label>
					<div class="row g-2">
						<?php foreach ($permissoesPermitidas as $permissao): ?>
							<div class="col-sm-6 col-lg-4">
								<div class="form-check border rounded p-3 h-100">
									<input class="form-check-input ms-0 me-2" type="checkbox" name="permissoes[]" value="<?=html_escape($permissao)?>" id="nova-permissao-<?=html_escape($permissao)?>" <?=in_array($permissao, $permissoesSelecionadas, true) ? 'checked' : ''?>>
									<label class="form-check-label" for="nova-permissao-<?=html_escape($permissao)?>"><?=html_escape($permissao)?></label>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="d-flex justify-content-end gap-2">
					<a href="<?=base_url('restrito/usuarios')?>" class="btn btn-light">Cancelar</a>
					<button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i> Cadastrar usuário</button>
				</div>
			</form>
		</div>
	</div>
</main>
