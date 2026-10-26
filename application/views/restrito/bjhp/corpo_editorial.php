<link rel="stylesheet" href="<?= base_url('assets/css/bjhp-editorial.css') ?>?v=2">
<div class="container py-4 tail-settings-page">
    <div class="tail-page-header">
        <div><h2>BJHP — Corpo editorial</h2><p class="tail-page-subtitle">Pessoas cadastradas no corpo editorial da revista.</p></div>
        <a href="<?= base_url('restrito/bjhp/editorial') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Cadastrar Corpo Editorial</a>
    </div>
    <?php if ($erro): ?>
        <div class="alert alert-danger" role="alert"><?= html_escape($erro) ?></div>
    <?php else: ?>
    <section class="tail-section-card">
        <div class="tail-section-header"><h3>Membros cadastrados</h3><p><?= count($membros) ?> pessoa(s) cadastrada(s), incluindo ativos e inativos.</p></div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th scope="col">Ordem</th><th scope="col">Nome</th><th scope="col">Categoria</th><th scope="col">Titulação</th><th scope="col">Instituição</th><th scope="col">Localização</th><th scope="col">E-mail</th><th scope="col">Status</th><th scope="col">Ações</th></tr></thead>
                <tbody>
                <?php if (!$membros): ?>
                    <tr><td colspan="9" class="text-center text-muted py-4">Nenhuma pessoa cadastrada no corpo editorial.</td></tr>
                <?php endif; ?>
                <?php foreach ($membros as $membro): ?>
                    <tr>
                        <td><?= (int) $membro['ordem_exibicao'] ?></td>
                        <td><span class="bjhp-editorial-name">
                            <?php if (!empty($membro['foto'])): ?>
                                <img class="bjhp-editorial-avatar" src="<?= html_escape(base_url($membro['foto'])) ?>" alt="">
                            <?php else: ?>
                                <span class="bjhp-editorial-avatar bjhp-editorial-avatar-empty" aria-hidden="true"><i class="bi bi-person"></i></span>
                            <?php endif; ?>
                            <span><?= html_escape($membro['nome'] ?? '') ?></span>
                        </span></td>
                        <td><?= html_escape($categorias[$membro['categoria']] ?? ($membro['categoria'] ?? '—')) ?></td>
                        <td><?= html_escape($membro['titulacao'] ?: '—') ?></td>
                        <td><?= html_escape($membro['instituicao'] ?: '—') ?></td>
                        <td><?= html_escape(implode(' / ', array_filter(array($membro['cidade'], $membro['estado'], $membro['pais']))) ?: '—') ?></td>
                        <td><?= html_escape($membro['email'] ?: '—') ?></td>
                        <td><span class="badge <?= $membro['status'] === 'ativo' ? 'bg-success' : 'bg-secondary' ?>"><?= $membro['status'] === 'ativo' ? 'Ativo' : ($membro['status'] === 'inativo' ? 'Inativo' : 'Não informado') ?></span></td>
                        <td><a class="btn btn-sm btn-outline-primary" href="<?= base_url('restrito/bjhp/editorial') . '?id=' . (int) $membro['id'] ?>"><i class="bi bi-pencil-square me-1"></i>Editar</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php endif; ?>
</div>
