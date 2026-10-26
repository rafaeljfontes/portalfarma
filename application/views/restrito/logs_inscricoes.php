<?php
$esc = function ($valor) { return htmlspecialchars(is_scalar($valor) ? (string) $valor : '', ENT_QUOTES, 'UTF-8'); };
$urlPagina = function ($numero) use ($busca) {
    return site_url('restrito/logs-inscricoes').'?'.http_build_query(['busca'=>$busca, 'pagina'=>$numero]);
};
?>
<main class="col-md-10 ms-sm-auto px-md-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div><h3 class="mb-1">Logs de inscrições</h3><p class="text-muted mb-0">Consulte as tentativas de inscrição e seus resultados.</p></div>
        <span class="badge bg-primary rounded-pill"><?=(int) $total?> tentativa(s)</span>
    </div>
    <form method="get" action="<?=$esc(site_url('restrito/logs-inscricoes'))?>" class="card border-0 shadow-sm p-3 mb-4">
        <label for="busca-logs" class="form-label">CPF, nome do inscrito ou nome do curso</label>
        <div class="d-flex gap-2 flex-wrap">
            <input type="search" name="busca" id="busca-logs" class="form-control flex-grow-1" style="flex-basis:300px" maxlength="200" value="<?=$esc($busca)?>" placeholder="Digite o CPF, nome ou curso">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search me-1"></i> Buscar</button>
            <a href="<?=$esc(site_url('restrito/logs-inscricoes'))?>" class="btn btn-outline-secondary">Limpar</a>
        </div>
    </form>
    <?php if ($avisos): ?><div class="alert alert-warning">Algumas linhas ou arquivos de log não puderam ser lidos. Os registros válidos estão disponíveis abaixo.</div><?php endif; ?>
    <div class="card border-0 shadow-sm"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Data e hora</th><th>Inscrito</th><th>CPF</th><th>Curso</th><th>Resultado</th><th>Mensagem / detalhes</th></tr></thead>
            <tbody>
            <?php if (!$registros): ?><tr><td colspan="6" class="text-center text-muted py-5"><?= $busca === '' ? 'Nenhum log de inscrição disponível.' : 'Nenhuma inscrição encontrada para a busca.' ?></td></tr><?php endif; ?>
            <?php foreach ($registros as $registro):
                $dados = $registro['dados'];
                $status = $registro['evento'] === 'resultado' ? ($registro['resultado'] ?? 'erro') : 'em_andamento';
                $rotulo = $status === 'sucesso' ? 'Sucesso' : ($status === 'erro' ? 'Erro' : 'Sem resultado');
                $classe = $status === 'sucesso' ? 'success' : ($status === 'erro' ? 'danger' : 'secondary');
                try { $data = (new DateTimeImmutable($registro['data_hora']))->setTimezone(new DateTimeZone('America/Sao_Paulo'))->format('d/m/Y H:i:s'); }
                catch (Exception $e) { $data = $registro['data_hora']; }
            ?>
                <tr>
                    <td class="text-nowrap"><?=$esc($data)?></td>
                    <td><?=$esc($dados['nome'] ?? 'Não informado')?></td>
                    <td class="text-nowrap"><?=$esc($dados['cpf'] ?? '')?></td>
                    <td><?=$esc($dados['curso_titulo'] ?? 'Não informado')?><small class="d-block text-muted">ID: <?=$esc($dados['course_id'] ?? '')?></small></td>
                    <td><span class="badge bg-<?=$classe?>"><?=$rotulo?></span></td>
                    <td style="min-width:260px">
                        <?=$esc($registro['mensagem'] ?? 'Tentativa iniciada, sem resultado registrado.')?>
                        <details class="mt-2"><summary class="text-primary" style="cursor:pointer">Ver detalhes</summary>
                            <dl class="small mt-2 mb-0">
                                <dt>E-mail</dt><dd><?=$esc($dados['email'] ?? '')?></dd>
                                <dt>Telefone / cidade</dt><dd><?=$esc($dados['telefone'] ?? '')?> / <?=$esc($dados['cidade'] ?? '')?></dd>
                                <dt>Identificador da tentativa</dt><dd><?=$esc($registro['tentativa'])?></dd>
                            </dl>
                            <?php if (!empty($registro['erros'])): ?><pre class="small bg-light p-2 mt-2 mb-0" style="white-space:pre-wrap;overflow-wrap:anywhere"><?=$esc(json_encode($registro['erros'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))?></pre><?php endif; ?>
                        </details>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div></div>
    <nav class="d-flex justify-content-between align-items-center mt-3" aria-label="Paginação dos logs">
        <span class="text-muted small">Página <?=(int) $pagina?> de <?=(int) $paginas?></span>
        <div class="d-flex gap-2">
            <?php if ($pagina > 1): ?><a class="btn btn-outline-primary btn-sm" href="<?=$esc($urlPagina($pagina - 1))?>">Anterior</a><?php endif; ?>
            <?php if ($pagina < $paginas): ?><a class="btn btn-outline-primary btn-sm" href="<?=$esc($urlPagina($pagina + 1))?>">Próxima</a><?php endif; ?>
        </div>
    </nav>
</main>
