<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="p-4" style="color:#12455e">
    <a class="btn btn-outline-primary mb-3" href="<?= site_url('restrito/atitude_farmaceutica') ?>">Voltar aos projetos</a>
    <h1 class="h3">Comissão — Atitude Farmacêutica</h1>
    <p>Cadastre os membros autorizados. Para atualizar ou desativar um cadastro, clique em Editar.</p>
    <form id="cadastro-comissao" class="card p-4 mb-4" action="<?= site_url('restrito/atitude_farmaceutica/comissao/salvar') ?>" method="post">
        <input type="hidden" name="token" value="<?= html_escape($token) ?>">
        <input type="hidden" id="membro-csrf" name="<?= html_escape($this->security->get_csrf_token_name()) ?>" value="<?= html_escape($this->security->get_csrf_hash()) ?>">
        <label class="mb-3">Nome<input class="form-control" name="nome" maxlength="150" required></label>
        <label class="mb-3">E-mail<input class="form-control" name="email" type="email" maxlength="254" required></label>
        <label class="mb-3">Situação<select class="form-control" name="ativo"><option value="1">Ativo — pode votar</option><option value="0">Inativo — acesso bloqueado</option></select></label>
        <button class="btn btn-primary" type="submit">Salvar membro</button>
    </form>
    <?php if ($membros === null): ?>
        <p class="alert alert-warning">Não foi possível consultar os membros da comissão.</p>
    <?php else: ?>
    <div class="table-responsive card p-3">
        <table class="table"><thead><tr><th>Nome</th><th>E-mail</th><th>Situação</th><th>Ações</th></tr></thead><tbody>
        <?php foreach ($membros as $membro): ?>
            <tr><td><?= html_escape($membro->nome) ?></td><td><?= html_escape($membro->email) ?></td><td><?= $membro->ativo ? 'Ativo' : 'Inativo' ?></td><td><button type="button" class="btn btn-outline-primary editar-membro" data-nome="<?= html_escape($membro->nome) ?>" data-email="<?= html_escape($membro->email) ?>" data-ativo="<?= (int) $membro->ativo ?>">Editar</button></td></tr>
        <?php endforeach; ?>
        <?php if (!$membros): ?><tr><td colspan="4">Nenhum membro cadastrado.</td></tr><?php endif; ?>
        </tbody></table>
    </div>
    <?php endif; ?>
    <a class="btn btn-outline-primary mt-3" href="<?= site_url('atitude_farmaceutica/votacao_comissao') ?>" target="_blank" rel="noopener">Abrir página de votação da comissão</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(() => {
    const form = document.getElementById('cadastro-comissao');
    document.querySelectorAll('.editar-membro').forEach(botao => botao.addEventListener('click', () => {
        ['nome', 'email', 'ativo'].forEach(campo => { form.elements[campo].value = botao.dataset[campo]; });
        form.elements.nome.focus(); form.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }));
    form.addEventListener('submit', async event => {
        event.preventDefault();
        if (!form.reportValidity()) return;
        const botao = form.querySelector('button');
        if (botao.disabled) return;
        botao.disabled = true;
        try {
            const response = await fetch(form.action, { method: 'POST', body: new FormData(form), credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            let data;
            try { data = await response.json(); } catch (error) { throw new Error('Atualize a página e tente novamente.'); }
            if (data.csrf_hash) { const csrf = document.getElementById('membro-csrf'); csrf.name = data.csrf_name; csrf.value = data.csrf_hash; }
            if (response.redirected || !response.ok || !data.success) throw new Error(data.message || 'Não foi possível salvar.');
            await Swal.fire({ icon: 'success', title: data.message });
            window.location.reload();
        } catch (error) { await Swal.fire({ icon: 'error', title: 'Cadastro não salvo', text: error.message }); }
        finally { botao.disabled = false; }
    });
})();
</script>
