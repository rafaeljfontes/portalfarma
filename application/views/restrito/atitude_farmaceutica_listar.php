<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .atitudes-area { padding: 24px; color: #39465d; }
    .atitudes-area .fase-evento-card { display: grid; grid-template-columns: minmax(0, 1fr) auto; align-items: center; gap: 20px 28px; padding: 24px; margin: 20px 0 24px; border: 1px solid #dce5ed; border-radius: 18px; background: linear-gradient(120deg, #fff, #f5f9fc); box-shadow: 0 4px 16px rgba(18, 69, 94, .05); }
    .atitudes-area .fase-evento-heading { display: flex; align-items: center; gap: 14px; }
    .atitudes-area .fase-evento-icone { display: grid; place-items: center; flex-shrink: 0; width: 48px; height: 48px; background: #e6eff6; color: #12455e; border-radius: 14px; font-size: 23px; }
    .atitudes-area .fase-evento-titulo { margin: 0 0 5px; color: #12455e; font-size: 19px; font-weight: 700; }
    .atitudes-area .fase-evento-ajuda { margin: 0; color: #728095; font-size: 13px; line-height: 1.5; }
    .atitudes-area .fase-evento-botoes { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .atitudes-area .fase-evento-botao { display: inline-flex; justify-content: center; align-items: center; gap: 10px; min-height: 50px; padding: 12px 20px; border: 1px solid #cbd9e5; border-radius: 12px; background: #fff; color: #12455e; font-size: 14px; font-weight: 600; cursor: pointer; transition: background .2s, border-color .2s, box-shadow .2s; }
    .atitudes-area .fase-evento-botao i { font-size: 19px; }
    .atitudes-area .fase-evento-botao:hover { background: #eaf1f8; border-color: #12455e; }
    .atitudes-area .fase-evento-botao.is-active { background: #12455e; border-color: #12455e; color: #fff; box-shadow: 0 4px 10px rgba(18, 69, 94, .15); }
    .atitudes-area .fase-evento-botao:focus-visible { outline: 3px solid #80aac8; outline-offset: 3px; }
    .atitudes-area .fase-evento-botao:disabled { opacity: .55; cursor: wait; }
    .atitudes-area .fase-evento-rodape { grid-column: 1 / -1; display: flex; align-items: center; flex-wrap: wrap; gap: 12px; padding-top: 16px; border-top: 1px solid #e1e9f0; }
    .atitudes-area .fase-evento-status { display: inline-flex; align-items: center; gap: 8px; border-radius: 20px; padding: 6px 12px; background: #e9edf2; color: #556174; font-size: 12px; font-weight: 700; }
    .atitudes-area .fase-evento-status::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
    .atitudes-area .fase-evento-status--inscricao { background: #e3f3ed; color: #227354; }
    .atitudes-area .fase-evento-status--votacao { background: #e5ecfc; color: #3656ad; }
    .atitudes-area .fase-evento-descricao { margin: 0; font-size: 13px; color: #65738a; line-height: 1.5; }
    .atitudes-area .fase-evento-resultados { grid-column: 1 / -1; justify-self: end; }
    .atitude-resultados { text-align: left; color: #39465d; }
    .atitude-resultados h2 { color: #12455e; font-size: 21px; margin: 24px 0 14px; }
    .atitude-resultados-formula { padding: 15px; background: #edf4f8; border-radius: 10px; color: #12455e; font-weight: 700; }
    .atitude-resultados-pendente { padding: 16px; border: 1px solid #dce5ed; border-radius: 10px; }
    .atitude-resultados-tabela-scroll { overflow-x: auto; margin: 16px 0; }
    .atitude-resultados-tabela { width: 100%; min-width: 900px; border-collapse: collapse; font-size: 13px; }
    .atitude-resultados-tabela caption { font-size: 12px; color: #65738a; }
    .atitude-resultados-tabela th { background: #12455e; color: #fff; text-align: left; padding: 12px; }
    .atitude-resultados-tabela td { padding: 12px; border-bottom: 1px solid #e1e9f0; vertical-align: top; overflow-wrap: anywhere; }
    .atitude-resultados-tabela tbody tr:nth-child(even) { background: #f7fafc; }
    .atitude-resultados-tabela details { min-width: 160px; }
    .atitude-resultados-tabela summary { cursor: pointer; color: #12455e; }
    .atitude-resultados-tabela details p { margin: 7px 0; font-size: 12px; }
    .atitude-podio-lugar span { display: block; margin-top: 6px; }
    .atitude-resultados-resumo { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
    .atitude-resultados-resumo span { background: #eef4fa; padding: 10px 16px; border-radius: 12px; font-size: 14px; }
    .atitude-resultados-podio { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin: 20px 0; }
    .atitude-podio-lugar { border: 1px solid #e0e5ed; border-radius: 16px; padding: 18px; background: #f7fafc; text-align: center; overflow-wrap: anywhere; }
    .atitude-podio-lugar.lugar-1 { background: #fff8e2; border-color: #efd486; }
    .atitude-podio-lugar.lugar-2 { background: #f0f4f8; border-color: #ced7e2; }
    .atitude-podio-lugar.lugar-3 { background: #fcf0e9; border-color: #e3bea5; }
    .atitude-podio-lugar h3 { font-size: 21px; color: #12455e; margin: 0 0 12px; }
    .atitude-podio-lugar p { font-size: 14px; margin: 10px 0 0; }
    .atitude-podio-lugar strong { display: block; }
    .atitude-resultados-nota { font-size: 12px; color: #748095; }
    .atitude-resultados h2 { font-size: 18px; color: #12455e; margin: 24px 0 16px; }
    .atitude-resultados-grafico { display: grid; gap: 16px; max-height: 340px; overflow-y: auto; padding-right: 8px; }
    .atitude-grafico-linha { display: grid; gap: 6px; }
    .atitude-grafico-label { display: flex; justify-content: space-between; gap: 16px; font-size: 13px; overflow-wrap: anywhere; }
    .atitude-grafico-trilho { height: 14px; border-radius: 8px; background: #edf1f6; overflow: hidden; }
    .atitude-grafico-barra { height: 100%; background: #3b5fc0; border-radius: 8px; }
    @media(max-width: 576px) { .atitude-resultados-podio { grid-template-columns: 1fr; } .atitudes-area .fase-evento-resultados { justify-self: stretch; } }
    @media (max-width: 1050px) { .atitudes-area .fase-evento-card { grid-template-columns: 1fr; } }
    @media (max-width: 576px) { .atitudes-area .fase-evento-card { padding: 18px; } .atitudes-area .fase-evento-botoes { grid-template-columns: 1fr; } }
    .atitudes-area .tabela-container { background: #fff; border: 1px solid #e0e5ed; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 4px rgba(0, 0, 0, .04); margin-bottom: 24px; }
    .atitudes-area .tabela-scroll { overflow-x: auto; }
    .atitudes-area .tabela-projetos { width: 100%; min-width: 1120px; border-collapse: collapse; table-layout: fixed; font-size: 12px; }
    .atitudes-area .tabela-projetos th { background: #004b60; color: #fff; padding: 15px 14px; font-size: 12px; font-weight: 700; text-transform: uppercase; text-align: left; }
    .atitudes-area .tabela-projetos td { padding: 16px 14px; border-bottom: 1px solid #edf0f5; vertical-align: middle; overflow-wrap: anywhere; }
    .atitudes-area .tabela-projetos tr:last-child td { border-bottom: 0; }
    .atitudes-area .tabela-projetos tbody tr:hover { background: #fafcff; }
    .atitudes-area .solicitacao-numero { display: inline-flex; align-items: center; justify-content: center; min-width: 54px; height: 54px; padding: 8px; border-radius: 11px; background: #fad34d; color: #463900; font-size: 14px; font-weight: 800; box-shadow: 0 3px 8px rgba(0, 0, 0, .12); margin-bottom: 8px; }
    .atitudes-area .nome-projeto { display: block; color: #00539b; font-weight: 700; font-size: 13px; margin-bottom: 8px; }
    .atitudes-area .linha-info { display: block; font-size: 11px; color: #707b89; margin-top: 4px; }
    .atitudes-area .linha-info i { color: #4381ff; margin-right: 5px; }
    .atitudes-area .descricao-resumo { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin: 8px 0; }
    .atitudes-area .outras-informacoes { color: #00539b; background: transparent; border: 0; padding: 0; text-decoration: underline; font-size: 12px; }
    .atitudes-modal { text-align: left; font-size: 14px; }
    .atitudes-modal p { white-space: pre-wrap; overflow-wrap: anywhere; margin: 12px 0; }
    .atitudes-area .data-projeto { display: inline-block; background: #f7f9fc; border: 1px solid #dce5f2; border-radius: 10px; padding: 10px; color: #5668ff; white-space: nowrap; }
    .atitudes-area .cidade-projeto { color: #00539b; }
    .atitudes-area .projeto-texto, .atitudes-area .motivo-texto { white-space: pre-wrap; overflow-wrap: anywhere; }
    .atitudes-area .projeto-galeria { display: flex; flex-wrap: wrap; gap: 6px; max-height: 144px; overflow-y: auto; }
    .atitudes-area .projeto-galeria img { width: 58px; height: 58px; object-fit: cover; border-radius: 6px; border: 1px solid #e0e5ed; }
    .atitudes-area .projeto-galeria small { display: block; font-size: 9px; }
    .atitudes-area .status-projeto { display: inline-block; border-radius: 20px; padding: 3px 8px; font-size: 10px; font-weight: 600; }
    .atitudes-area .status-0 { background: #fff3cd; color: #664d03; }
    .atitudes-area .status-1 { background: #d1e7dd; color: #0f5132; }
    .atitudes-area .status-2 { background: #f8d7da; color: #842029; }
    .atitudes-area .acoes-botoes { display: grid; gap: 7px; max-width: 160px; margin: 0 auto; }
    .atitudes-area .acoes-botoes .btn { background: #fff; border-radius: 9px; font-size: 12px; padding: 6px 10px; }
    .atitudes-area .btn-aceitar { color: #5668ff; border: 1px solid #c8d0ff; }
    .atitudes-area .btn-aceitar:hover { color: #fff; background: #5668ff; }
    .atitudes-area .btn-recusar { color: #ff3045; border: 1px solid #ff3045; }
    .atitudes-area .btn-recusar:hover { color: #fff; background: #ff3045; }
    .atitudes-area .acoes-botoes .btn:disabled { opacity: .45; cursor: default; }
    .atitudes-area .projeto-card[data-status="1"] .btn-aceitar { background: #198754; border-color: #198754; color: #fff; opacity: 1; }
    .atitudes-area .projeto-card[data-status="2"] .btn-recusar { background: #dc3545; border-color: #dc3545; color: #fff; opacity: 1; }
    .atitudes-area .motivo-recusa { margin-top: 12px; font-size: 11px; }
    @media (max-width: 900px) {
        .atitudes-area { padding: 12px; }
    }
</style>
<div class="atitudes-area" id="atitudes-lista">
    <h1 class="h3">Atitude Farmacêutica</h1>
    <a href="<?= site_url('restrito/atitude_farmaceutica/comissao') ?>" class="btn btn-outline-primary">Gerenciar comissão</a>
    <section class="fase-evento-card" aria-labelledby="fase-evento-titulo">
        <div class="fase-evento-heading">
            <span class="fase-evento-icone" aria-hidden="true"><i class="bi bi-calendar-event"></i></span>
            <div>
                <h2 class="fase-evento-titulo" id="fase-evento-titulo">Fase do evento</h2>
                <p class="fase-evento-ajuda">Controle o que está disponível na página pública.</p>
            </div>
        </div>
        <div id="atitude-fase-botoes" class="fase-evento-botoes" data-fase="<?= html_escape($faseEvento ?? 'inscricao') ?>">
            <?php foreach (array('inscricao' => 'inscrições', 'votacao' => 'votação') as $fase => $rotulo): $ativa = ($faseEvento ?? 'inscricao') === $fase; ?>
                <button type="button" data-fase-alvo="<?= $fase ?>" class="fase-evento-botao<?= $ativa ? ' is-active' : '' ?>" aria-pressed="<?= $ativa ? 'true' : 'false' ?>"><i class="bi <?= $fase === 'inscricao' ? 'bi-pencil-square' : 'bi-check2-square' ?>" aria-hidden="true"></i><span data-fase-label><?= $ativa ? 'Encerrar ' : 'Abrir ' ?><?= $rotulo ?></span></button>
            <?php endforeach; ?>
        </div>
        <button type="button" id="atitude-ver-resultados" class="fase-evento-botao fase-evento-resultados"><i class="bi bi-bar-chart" aria-hidden="true"></i>Ver resultados</button>
        <div class="fase-evento-rodape">
            <span id="atitude-fase-status" class="fase-evento-status fase-evento-status--<?= html_escape($faseEvento ?? 'inscricao') ?>"><?= ($faseEvento ?? 'inscricao') === 'encerrado' ? 'Evento encerrado' : (($faseEvento ?? 'inscricao') === 'votacao' ? 'Votação aberta' : 'Inscrições abertas') ?></span>
            <p class="fase-evento-descricao" id="atitude-fase-descricao" aria-live="polite"><?= ($faseEvento ?? 'inscricao') === 'encerrado' ? 'Inscrições e votação encerradas' : (($faseEvento ?? 'inscricao') === 'votacao' ? 'Votação aberta · inscrições encerradas' : 'Inscrições abertas · votação fechada') ?></p>
        </div>
    </section>
    <form id="atitude-limite-votacao" class="card p-3 mb-4" data-atual="<?= (int) $limiteProjetosVotacao ?>">
        <label for="limite-projetos-votacao" class="fw-bold mb-2">Projetos por voto popular</label>
        <p class="text-muted small">O eleitor deverá selecionar exatamente esta quantidade e avaliar todos os cinco critérios. Padrão: 3. Caso existam menos projetos aprovados que o limite, a votação aguardará o ajuste.</p>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <input id="limite-projetos-votacao" class="form-control" style="max-width:120px" type="number" min="1" max="100" step="1" required value="<?= (int) $limiteProjetosVotacao ?>">
            <button type="submit" class="btn btn-primary">Salvar limite</button>
        </div>
    </form>
    <p class="text-muted">Projetos cadastrados: <?= (int) $total ?></p>
    <div class="tabela-container">
        <div class="tabela-scroll">
            <table class="tabela-projetos" aria-label="Projetos da Atitude Farmacêutica">
                <colgroup><col style="width: 8%"><col style="width: 25%"><col style="width: 36%"><col style="width: 17%"><col style="width: 14%"></colgroup>
                <thead><tr>
                    <th scope="col">Solicitação</th><th scope="col">Responsável</th><th scope="col">Projeto</th><th scope="col">Imagens</th><th scope="col">Ações</th>
                </tr></thead>
                <tbody>
                <?php if (!$projetos): ?>
                    <tr><td colspan="5" class="text-center py-4">Nenhum projeto cadastrado.</td></tr>
                <?php endif; ?>
    <?php foreach ($projetos as $projeto):
        $statusProjeto = (int) ($projeto->status ?? 0);
        $rotulos = array(0 => 'Pendente', 1 => 'Aceito', 2 => 'Recusado');
        $imagens = json_decode((string) $projeto->imagens, true);
        $imagens = is_array($imagens) ? $imagens : array();
        $nome = $projeto->nome_farmaceutico ?? $projeto->nome ?? 'Não informado na inscrição';
        $motivo = (string) ($projeto->motivo_recusa ?? '');
    ?>
        <tr class="projeto-card" data-id="<?= (int) $projeto->id ?>" data-status="<?= $statusProjeto ?>">
            <td>
                <span class="solicitacao-numero">#<?= (int) $projeto->id ?></span><br>
                <span class="status-projeto status-<?= $statusProjeto ?>" aria-live="polite"><?= html_escape($rotulos[$statusProjeto] ?? 'Desconhecido') ?></span>
            </td>
            <td>
                <span><strong>Nome:</strong> <?= html_escape($nome) ?></span>
                <span class="linha-info"><i class="bi bi-person-vcard"></i><strong>CRFMG:</strong> <?= html_escape($projeto->numero_crf ?: 'Não informado') ?></span>
                <span class="linha-info"><i class="bi bi-envelope"></i><strong>Email:</strong> <?= html_escape($projeto->email ?: 'Não informado') ?></span>
                <span class="linha-info"><i class="bi bi-telephone"></i><strong>Telefone:</strong> <?= html_escape($projeto->celular) ?></span>
            </td>
            <td>
                <strong class="nome-projeto"><?= html_escape($projeto->nome_projeto) ?></strong>
                <span class="linha-info"><i class="bi bi-calendar-check"></i>Cad: <?= html_escape(date('d/m/Y H:i', strtotime($projeto->criado_em))) ?></span>
                <span class="linha-info"><strong>Eixo:</strong> <?= html_escape($projeto->eixo_projeto) ?></span>
                <span class="linha-info"><strong>Cidade:</strong> <?= html_escape($projeto->cidade_projeto) ?></span>
                <span class="linha-info"><strong>Início:</strong> <?= html_escape(date('d/m/Y', strtotime($projeto->data_inicio))) ?></span>
                <p class="descricao-resumo"><strong>Resumo:</strong> <?= html_escape($projeto->resumo_projeto ?? 'Não informado') ?></p>
                <button type="button" class="outras-informacoes" data-detalhes>Outras informações</button>
                <template class="detalhes-projeto">
                    <div>
                    <p><strong>Nome do projeto:</strong> <?= html_escape($projeto->nome_projeto) ?></p>
                    <p><strong>Data de inscrição:</strong> <?= html_escape(date('d/m/Y H:i', strtotime($projeto->criado_em))) ?></p>
                    <p><strong>Eixo:</strong> <?= html_escape($projeto->eixo_projeto) ?></p>
                    <p><strong>Cidade:</strong> <?= html_escape($projeto->cidade_projeto) ?></p>
                    <p><strong>Local:</strong> <?= html_escape($projeto->local_projeto) ?></p>
                    <p><strong>Início:</strong> <?= html_escape(date('d/m/Y', strtotime($projeto->data_inicio))) ?></p>
                    <p><strong>Número de pessoas:</strong> <?= html_escape($projeto->numero_pessoas) ?></p>
                <?php foreach (array('Resumo' => $projeto->resumo_projeto ?? 'Não informado', 'Descrição' => $projeto->descricao_projeto, 'Recursos' => $projeto->recursos,
                    'Justificativa' => $projeto->justificativa, 'Pessoas alcançadas' => $projeto->pessoas_alcancadas,
                    'Benefícios alcançados' => $projeto->beneficios_alcancados, 'Objetivos alcançados' => $projeto->objetivos_alcancados) as $rotulo => $valor): ?>
                    <p><strong><?= html_escape($rotulo) ?>:</strong><br><span class="projeto-texto"><?= html_escape($valor ?: 'Não informado') ?></span></p>
                <?php endforeach; ?>
                    </div>
                </template>
            </td>
            <td>
                <div class="projeto-galeria">
                    <?php foreach ($imagens as $indice => $imagem):
                        if (!is_string($imagem) || !preg_match('/\A[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)\z/i', $imagem)) continue;
                        $url = base_url('uploads/atitude-farmaceutica/' . rawurlencode($imagem));
                    ?>
                        <a href="<?= html_escape($url) ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?= html_escape($url) ?>" loading="lazy" alt="Imagem <?= (int) $indice + 1 ?> do projeto <?= html_escape($projeto->nome_projeto) ?>">
                            <?php if ($imagem === $projeto->imagem_principal): ?><small>Imagem principal</small><?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                    <?php if (!$imagens): ?><p class="text-muted">Sem imagens cadastradas.</p><?php endif; ?>
                </div>
            </td>
            <td class="projeto-acoes">
                <div class="acoes-botoes">
                    <button type="button" class="btn btn-aceitar" data-acao="1" <?= $statusProjeto !== 0 ? 'disabled' : '' ?>><i class="bi bi-check-circle"></i> Aceitar</button>
                    <button type="button" class="btn btn-recusar" data-acao="2" <?= $statusProjeto !== 0 ? 'disabled' : '' ?>><i class="bi bi-x-circle"></i> Recusar</button>
                </div>
                <div class="motivo-recusa" <?= $motivo === '' ? 'hidden' : '' ?>>
                    <strong>Motivo da recusa</strong>
                    <p class="motivo-texto"><?= html_escape($motivo) ?></p>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if ($paginas > 1): ?>
        <nav aria-label="Paginação dos projetos" class="d-flex align-items-center gap-3">
            <?php if ($pagina > 1): ?><a class="btn btn-outline-secondary" href="<?= site_url('restrito/atitude_farmaceutica') ?>?pagina=<?= $pagina - 1 ?>">Anterior</a><?php endif; ?>
            <span>Página <?= (int) $pagina ?> de <?= (int) $paginas ?></span>
            <?php if ($pagina < $paginas): ?><a class="btn btn-outline-secondary" href="<?= site_url('restrito/atitude_farmaceutica') ?>?pagina=<?= $pagina + 1 ?>">Próxima</a><?php endif; ?>
        </nav>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('assets/js/atitude-resultados.js') ?>?v=20261016-3"></script>
<script>
(() => {
    const lista = document.getElementById('atitudes-lista');
    const endpoint = <?= json_encode(site_url('restrito/atitude_farmaceutica/alterar_status'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    const token = <?= json_encode($token) ?>;
    let csrfName = <?= json_encode($this->security->get_csrf_token_name()) ?>;
    let csrfHash = <?= json_encode($this->security->get_csrf_hash()) ?>;
    const limiteForm = document.getElementById('atitude-limite-votacao');
    limiteForm.addEventListener('submit', async event => {
        event.preventDefault();
        if (!limiteForm.reportValidity()) return;
        const botao = limiteForm.querySelector('button');
        if (botao.disabled) return;
        botao.disabled = true;
        try {
            const body = new URLSearchParams({ token, limite: document.getElementById('limite-projetos-votacao').value, limite_atual: limiteForm.dataset.atual });
            if (csrfName && csrfHash) body.set(csrfName, csrfHash);
            const response = await fetch(<?= json_encode(site_url('restrito/atitude_farmaceutica/limite_votacao')) ?>, { method: 'POST', body, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            let data;
            try { data = await response.json(); } catch (error) { throw new Error('Atualize a página e tente novamente.'); }
            if (data.csrf_hash) { csrfName = data.csrf_name; csrfHash = data.csrf_hash; }
            if (response.redirected || !response.ok || !data.success) throw new Error(data.message || 'Não foi possível salvar o limite.');
            limiteForm.dataset.atual = String(data.limite);
            await Swal.fire({ icon: 'success', title: data.message });
        } catch (error) { await Swal.fire({ icon: 'error', title: 'Limite não salvo', text: error.message }); }
        finally { botao.disabled = false; }
    });
    let enviando = false;
    const resultadosBotao = document.getElementById('atitude-ver-resultados');
    resultadosBotao.addEventListener('click', async () => {
        if (resultadosBotao.disabled || enviando) return;
        resultadosBotao.disabled = true;
        try {
            const response = await fetch(<?= json_encode(site_url('restrito/atitude_farmaceutica/resultados')) ?>, { credentials: 'same-origin', cache: 'no-store', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();
            if (!response.ok || !data.success) throw new Error(data.message || 'Não foi possível consultar os resultados.');
            const conteudo = window.AtitudeResultados.montar(data);
            await Swal.fire({ title: 'Apuração dos resultados', html: conteudo, width: 1200, showCloseButton: true, confirmButtonText: 'Fechar', confirmButtonColor: '#12455e' });
        } catch (error) {
            await Swal.fire({ icon: 'error', title: 'Não foi possível carregar os resultados', text: error.message });
        } finally { resultadosBotao.disabled = false; }
    });
    const fases = document.getElementById('atitude-fase-botoes');
    fases.addEventListener('click', async event => {
        const botao = event.target.closest('button[data-fase-alvo]');
        if (!botao || enviando) return;
        const faseAnterior = fases.dataset.fase;
        const novaFase = faseAnterior === botao.dataset.faseAlvo ? 'encerrado' : botao.dataset.faseAlvo;
        enviando = true;
        fases.querySelectorAll('button').forEach(button => { button.disabled = true; });
        try {
            const body = new URLSearchParams({ fase: novaFase, fase_atual: faseAnterior, token });
            if (csrfName && csrfHash) body.set(csrfName, csrfHash);
            const response = await fetch(<?= json_encode(site_url('restrito/atitude_farmaceutica/alterar_fase')) ?>, { method: 'POST', body, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();
            if (data.csrf_hash) { csrfName = data.csrf_name; csrfHash = data.csrf_hash; }
            if (!response.ok || !data.success) throw new Error(data.message || 'Não foi possível alterar a fase.');
            fases.dataset.fase = data.fase;
            fases.querySelectorAll('button').forEach(button => {
                const ativa = button.dataset.faseAlvo === data.fase;
                button.classList.toggle('is-active', ativa);
                button.setAttribute('aria-pressed', String(ativa));
                button.querySelector('[data-fase-label]').textContent = (ativa ? 'Encerrar ' : 'Abrir ') + (button.dataset.faseAlvo === 'inscricao' ? 'inscrições' : 'votação');
            });
            const status = document.getElementById('atitude-fase-status');
            status.className = 'fase-evento-status fase-evento-status--' + data.fase;
            status.textContent = data.fase === 'encerrado' ? 'Evento encerrado' : (data.fase === 'votacao' ? 'Votação aberta' : 'Inscrições abertas');
            document.getElementById('atitude-fase-descricao').textContent = data.message;
            await Swal.fire({ icon: 'success', title: 'Fase atualizada', text: data.message });
        } catch (error) {
            await Swal.fire({ icon: 'error', title: 'Não foi possível alterar a fase', text: error.message });
        } finally { fases.querySelectorAll('button').forEach(button => { button.disabled = false; }); enviando = false; }
    });
    lista.addEventListener('click', async event => {
        const detalhes = event.target.closest('button[data-detalhes]');
        if (detalhes) {
            const conteudo = document.createElement('div');
            conteudo.appendChild(detalhes.closest('.projeto-card').querySelector('.detalhes-projeto').content.cloneNode(true));
            await Swal.fire({ title: 'Informações do projeto', html: conteudo, width: 800, customClass: { htmlContainer: 'atitudes-modal' }, confirmButtonText: 'Fechar' });
            return;
        }
        const botao = event.target.closest('button[data-acao]');
        if (!botao || botao.disabled || enviando) return;
        const card = botao.closest('.projeto-card');
        const status = botao.dataset.acao;
        enviando = true;
        try {
            let motivo = '';
            if (status === '2') {
                const resultado = await Swal.fire({
                    title: 'Recusar projeto', input: 'textarea', inputLabel: 'Motivo da recusa',
                    inputPlaceholder: 'Descreva o motivo da recusa', inputAttributes: { maxlength: '4000' },
                    showCancelButton: true, confirmButtonText: 'Confirmar recusa', cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc3545',
                    inputValidator: valor => !valor.trim() ? 'Informe o motivo da recusa.' : undefined
                });
                if (!resultado.isConfirmed) return;
                motivo = resultado.value.trim();
            }
            lista.querySelectorAll('button[data-acao]').forEach(button => { button.disabled = true; });
            const body = new URLSearchParams({ id: card.dataset.id, status, status_atual: card.dataset.status, motivo, token });
            if (csrfName && csrfHash) body.set(csrfName, csrfHash);
            const response = await fetch(endpoint, { method: 'POST', body, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();
            if (data.csrf_hash) { csrfName = data.csrf_name; csrfHash = data.csrf_hash; }
            if (!response.ok || !data.success) throw new Error(data.message || 'Não foi possível salvar a decisão.');
            if (card.dataset.status === '0') {
                const contador = document.getElementById('atitude-pendentes-badge');
                if (contador) {
                    const pendentes = Math.max(0, Number(contador.textContent) - 1);
                    contador.textContent = String(pendentes);
                    contador.hidden = pendentes === 0;
                }
            }
            card.dataset.status = String(data.status_projeto);
            const badge = card.querySelector('.status-projeto');
            badge.className = 'status-projeto status-' + data.status_projeto;
            badge.textContent = data.status_projeto === 1 ? 'Aceito' : 'Recusado';
            card.querySelector('.motivo-recusa').hidden = !data.motivo_recusa;
            card.querySelector('.motivo-texto').textContent = data.motivo_recusa || '';
            await Swal.fire({ icon: 'success', title: data.status_projeto === 1 ? 'Projeto habilitado' : 'Decisão salva', text: data.message });
        } catch (error) {
            await Swal.fire({ icon: 'error', title: 'Não foi possível atualizar', text: error.message || 'Tente novamente.' });
        } finally {
            enviando = false;
            lista.querySelectorAll('.projeto-card').forEach(projeto => {
                projeto.querySelectorAll('button[data-acao]').forEach(button => {
                    button.disabled = projeto.dataset.status !== '0';
                });
            });
        }
    });
})();
</script>
