<div class="container py-4">
    <h2>Inscritos do curso #<?=(int) $courseid?></h2>
    <div class="alert alert-warning" role="alert">
        <h3 class="h5">Lista de inscritos temporariamente indisponível</h3>
        <p>Não foi possível consultar os inscritos no Moodle. Isso não significa que o curso esteja sem inscrições.</p>
        <p>Se o problema persistir, solicite à equipe responsável a verificação da conexão e da autorização de acesso ao banco do Moodle.</p>
        <a href="<?=base_url('restrito/Capacifar/lista_inscritos/'.(int) $courseid)?>" class="btn btn-outline-primary">Tentar novamente</a>
        <a href="<?=base_url('restrito/Capacifar/listar')?>" class="btn btn-outline-secondary">Voltar aos eventos</a>
    </div>
</div>
