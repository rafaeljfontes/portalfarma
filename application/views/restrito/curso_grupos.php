<div class="container py-4">
    <a href="<?=base_url('restrito/Capacifar/listar')?>" class="btn btn-outline-primary mb-3">Voltar aos eventos</a>
    <h1 class="h4">Grupos do Moodle</h1>
    <p><?=htmlspecialchars($curso->titulo, ENT_QUOTES, 'UTF-8')?> · Curso #<?=(int) $curso->courseid?></p>
    <?php if ($indisponivel): ?>
        <div class="alert alert-warning" role="alert">Não foi possível consultar os grupos no Moodle. Tente novamente mais tarde.</div>
    <?php elseif (empty($grupos)): ?>
        <div class="alert alert-info" role="status">Nenhum grupo criado neste curso.</div>
    <?php else: ?>
        <p><?=count($grupos)?> grupo(s) encontrado(s). Os IDs abaixo são os IDs dos usuários no Moodle.</p>
        <?php foreach ($grupos as $grupo): ?>
            <section class="card mb-3">
                <div class="card-header">
                    <h2 class="h5 mb-1"><?=htmlspecialchars($grupo['nome'], ENT_QUOTES, 'UTF-8')?></h2>
                    <small>Grupo #<?=(int) $grupo['id']?> · <?=count($grupo['membros'])?> participante(s)</small>
                </div>
                <div class="card-body">
                    <?php if (empty($grupo['membros'])): ?>
                        <p class="mb-0">Este grupo não possui participantes.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead><tr><th scope="col">ID Moodle</th><th scope="col">Nome</th></tr></thead>
                                <tbody>
                                <?php foreach ($grupo['membros'] as $membro): ?>
                                    <tr><td><?=(int) $membro['id']?></td><td><?=htmlspecialchars($membro['nome'], ENT_QUOTES, 'UTF-8')?></td></tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
