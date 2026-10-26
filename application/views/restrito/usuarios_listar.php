<main class="col-md-10 ms-sm-auto px-md-4 py-4">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<div>
			<h3 class="mb-1">Usuários</h3>
			<p class="text-muted mb-0">Gerencie os acessos dos usuários do PortalFarma.</p>
		</div>
		<div class="d-flex align-items-center gap-3">
			<span class="badge bg-primary rounded-pill"><?=count($usuarios)?> usuário(s)</span>
			<a href="<?=base_url('restrito/usuarios/novo')?>" class="btn btn-primary">
				<i class="bi bi-plus-lg me-1"></i> Novo usuário
			</a>
		</div>
	</div>

	<?php if ($this->session->flashdata('usuarios_sucesso')): ?>
		<div class="alert alert-success"><?=html_escape($this->session->flashdata('usuarios_sucesso'))?></div>
	<?php endif; ?>
	<?php if ($this->session->flashdata('usuarios_erro')): ?>
		<div class="alert alert-danger"><?=html_escape($this->session->flashdata('usuarios_erro'))?></div>
	<?php endif; ?>

	<div class="card border-0 shadow-sm">
		<div class="table-responsive">
			<table class="table table-hover align-middle mb-0">
				<thead class="table-light">
					<tr><th class="ps-4">ID</th><th>Usuário</th><th>Status</th><th style="min-width: 620px;">Permissões e acesso</th></tr>
				</thead>
				<tbody>
				<?php if (empty($usuarios)): ?>
					<tr><td colspan="4" class="text-center text-muted py-5">Nenhum usuário encontrado.</td></tr>
				<?php else: foreach ($usuarios as $usuario): $ativas = portalfarma_permissoes($usuario->permissao ?? ''); ?>
					<tr>
						<td class="ps-4"><?=(int) $usuario->id?></td>
						<td class="fw-semibold"><?=html_escape($usuario->user ?? '')?></td>
						<td>
							<?php if ((int) ($usuario->status ?? 0) === 1): ?>
								<span class="badge bg-success">Ativo</span>
							<?php else: ?>
								<span class="badge bg-secondary">Inativo</span>
							<?php endif; ?>
						</td>
						<td>
							<form method="post" action="<?=base_url('restrito/usuarios/permissoes')?>" class="d-flex flex-wrap align-items-center gap-2">
								<input type="hidden" name="id" value="<?=(int) $usuario->id?>">
								<div class="form-check form-switch me-2">
									<input class="form-check-input" type="checkbox" role="switch" name="status" value="1" id="status-<?=(int) $usuario->id?>" <?=(int) ($usuario->status ?? 0) === 1 ? 'checked' : ''?>>
									<label class="form-check-label fw-semibold small" for="status-<?=(int) $usuario->id?>">Ativo</label>
								</div>
								<?php foreach ($permissoesPermitidas as $permissao): ?>
									<div class="form-check form-check-inline m-0 border rounded px-2 py-1">
										<input class="form-check-input ms-0 me-1" type="checkbox" name="permissoes[]" value="<?=html_escape($permissao)?>" id="permissao-<?=(int) $usuario->id?>-<?=html_escape($permissao)?>" <?=in_array($permissao, $ativas, true) ? 'checked' : ''?>>
										<label class="form-check-label small" for="permissao-<?=(int) $usuario->id?>-<?=html_escape($permissao)?>"><?=html_escape($permissao)?></label>
									</div>
								<?php endforeach; ?>
								<button type="submit" class="btn btn-sm btn-primary ms-auto"><i class="bi bi-check2-circle me-1"></i>Salvar</button>
							</form>
						</td>
					</tr>
				<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</main>
