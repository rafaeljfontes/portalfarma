<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .atitude-projetos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 340px), 1fr)); gap: 28px; }
    .atitude-projeto { background: #f7fafc; border: 1px solid #a7becb; border-radius: 30px; overflow: hidden; box-shadow: 0 12px 28px rgba(18, 69, 94, .12); display: flex; flex-direction: column; }
    .atitude-projeto:has(.atitude-voto-checkbox:checked) { border-color: #3b5fc0; box-shadow: 0 0 0 3px rgba(59, 95, 192, .22); }
    .atitude-voto-selecao { display: flex; align-items: center; gap: 10px; padding: 14px 24px; background: #eaf0fa; color: #12455e; font-weight: 600; cursor: pointer; }
    .atitude-voto-checkbox { width: 20px; height: 20px; accent-color: #3b5fc0; }
    .atitude-projeto-imagem { width: 100%; aspect-ratio: 16 / 9; object-fit: cover; display: block; }
    .atitude-projeto-sem-imagem { background: #e4edf2; color: #12455e; display: grid; place-items: center; }
    .atitude-projeto-conteudo { padding: 24px; display: flex; flex-direction: column; flex: 1; }
    .atitude-projeto-titulo { color: #12455e; font-size: 24px; line-height: 1.3; font-weight: 700; margin: 0 0 10px; overflow-wrap: anywhere; }
    .atitude-projeto-cidade { color: #566174; margin: 0 0 14px; }
    .atitude-projeto-cidade i, .atitude-projeto-data i { color: #ee302c; }
    .atitude-projeto-resumo { color: #526078; font-size: 17px; line-height: 1.6; white-space: pre-wrap; overflow-wrap: anywhere; margin: 0 0 20px; }
    .atitude-projeto-rodape { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-top: auto; }
    .atitude-projeto-ver-mais { background: #3b5fc0; color: #fff; border: 0; border-radius: 12px; padding: 12px 20px; font-weight: 600; }
    .atitude-projeto-ver-mais:hover { background: #2d4da4; }
    .atitude-projeto-data { color: #5c6980; font-size: 15px; }
    .atitude-projeto-popup { border-radius: 24px; padding-bottom: 24px; }
    .atitude-projeto-popup .swal2-title { color: #12455e; font-size: 24px; }
    .swal2-html-container.atitude-projeto-modal { margin: 28px 32px 0; padding-top: 24px; border-top: 1px solid #e2eaf0; text-align: left; color: #526078; font-size: 16px; line-height: 1.65; max-height: 60vh; }
    .atitude-projeto-modal p { white-space: pre-wrap; overflow-wrap: anywhere; margin: 0; }
    .atitude-projeto-modal h3 { color: #12455e; font-size: 24px; font-weight: 700; margin: 0 0 16px; overflow-wrap: anywhere; }
    .atitude-projeto-modal h4 { color: #12455e; font-size: 16px; font-weight: 700; margin: 0 0 8px; }
    .atitude-modal-resumo { margin-bottom: 24px; }
    .atitude-modal-local-data { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
    .atitude-modal-local-data > div { padding: 16px; border: 1px solid #e2eaf0; background: #f7fafc; border-radius: 12px; }
    .atitude-modal-resultado { border-left: 3px solid #3b5fc0; padding-left: 16px; margin-bottom: 24px; }
    .atitude-projeto-modal-galeria { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-top: 16px; }
    .atitude-projeto-modal-galeria img { width: 100%; height: 180px; object-fit: cover; border-radius: 12px; }
    @media (max-width: 576px) {
        .swal2-html-container.atitude-projeto-modal { margin: 24px 18px 0; font-size: 15px; }
        .atitude-modal-local-data { grid-template-columns: 1fr; }
    }
</style>
<div class="atitude-projetos-grid" id="atitude-projetos-publicos">
    <?php if (!$projetosAceitos): ?>
        <p class="text-center text-muted">Nenhum projeto disponível no momento.</p>
    <?php endif; ?>
    <?php foreach ($projetosAceitos as $projeto):
        $principal = (string) $projeto->imagem_principal;
        $imagemValida = preg_match('/\A[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)\z/i', $principal);
        $imagens = json_decode((string) $projeto->imagens, true);
        $imagens = is_array($imagens) ? $imagens : array();
        $dataInicio = DateTime::createFromFormat('!Y-m-d', (string) $projeto->data_inicio);
    ?>
        <article class="atitude-projeto">
            <?php if (!empty($modoVotacao)): ?>
                <label class="atitude-voto-selecao"><input type="checkbox" name="projetos[]" class="atitude-voto-checkbox" value="<?= (int) $projeto->id ?>" aria-label="Selecionar <?= html_escape($projeto->nome_projeto) ?>">Selecionar projeto</label>
            <?php endif; ?>
            <?php if ($imagemValida): ?>
                <img class="atitude-projeto-imagem" src="<?= html_escape(base_url('uploads/atitude-farmaceutica/' . rawurlencode($principal))) ?>" alt="<?= html_escape($projeto->nome_projeto) ?>" loading="lazy">
            <?php else: ?>
                <div class="atitude-projeto-imagem atitude-projeto-sem-imagem">Imagem indisponível</div>
            <?php endif; ?>
            <div class="atitude-projeto-conteudo">
                <h3 class="atitude-projeto-titulo"><?= html_escape($projeto->nome_projeto) ?></h3>
                <!--<p class="atitude-projeto-cidade"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <?= html_escape($projeto->cidade_projeto) ?></p>-->
                <p class="atitude-projeto-resumo"><?= html_escape($projeto->resumo_projeto ?? '') ?></p>
                <?php if (!empty($modoVotacao)): ?>
                    <div class="atitude-voto-avaliacao" hidden>
                        <p class="small">Atribua uma nota de 1 a 5 em cada critério.</p>
                        <p class="small text-muted fst-italic mt-1 mb-3"><strong>Nota:</strong> <strong>1</strong> representa a menor nota (Péssimo) e <strong>5</strong> a maior nota (Ótimo).</p>
                        <?php foreach ($criteriosVotacao as $criterio => $rotulo): ?>
                            <fieldset class="atitude-voto-criterio" disabled>
                                <legend><?= html_escape($rotulo) ?></legend>
                                <div class="atitude-voto-escala">
                                    <?php for ($nota = 1; $nota <= 5; $nota++): ?>
                                        <label><input type="radio" name="notas[<?= (int) $projeto->id ?>][<?= html_escape($criterio) ?>]" value="<?= $nota ?>" required><span><?= $nota ?></span></label>
                                    <?php endfor; ?>
                                </div>
                            </fieldset>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="atitude-projeto-rodape">
                    <button type="button" class="atitude-projeto-ver-mais" aria-label="Ver mais sobre <?= html_escape($projeto->nome_projeto) ?>">Ver mais</button>
                    <?php if ($dataInicio): ?>
                        <time class="atitude-projeto-data" datetime="<?= html_escape($projeto->data_inicio) ?>"><i class="bi bi-calendar" aria-hidden="true"></i> <?= $dataInicio->format('d/m/Y') ?></time>
                    <?php endif; ?>
                </div>
            </div>
            <template class="atitude-projeto-detalhes">
                <div>
                    <h3><?= html_escape($projeto->nome_projeto) ?></h3>
                    <div class="atitude-modal-resumo">
                        <h4>Resumo</h4>
                        <p><?= html_escape($projeto->resumo_projeto ?? 'Não informado') ?></p>
                    </div>
                    <div class="atitude-modal-local-data">
                        <div>
                            <h4><i class="bi bi-geo-alt" aria-hidden="true"></i> Espaço de realização do projeto</h4>
                            <p><?= html_escape($projeto->local_projeto ?: 'Não informado') ?></p>
                        </div>
                        <div>
                            <h4><i class="bi bi-calendar" aria-hidden="true"></i> Data de Início do projeto</h4>
                            <p><?= $dataInicio ? $dataInicio->format('d/m/Y') : 'Não informado' ?></p>
                        </div>
                    </div>
                    <?php foreach (array(
                        'Pessoas alcançadas' => $projeto->pessoas_alcancadas,
                        'Benefícios alcançados' => $projeto->beneficios_alcancados,
                        'Objetivos alcançados' => $projeto->objetivos_alcancados
                    ) as $rotulo => $valor): ?>
                        <div class="atitude-modal-resultado">
                            <h4><?= html_escape($rotulo) ?></h4>
                            <p><?= html_escape($valor !== null && trim((string) $valor) !== '' ? $valor : 'Não informado') ?></p>
                        </div>
                    <?php endforeach; ?>
                    <h4>Imagens do projeto</h4>
                    <div class="atitude-projeto-modal-galeria">
                        <?php foreach ($imagens as $imagem):
                            if (!is_string($imagem) || !preg_match('/\A[a-zA-Z0-9_-]+\.(jpg|jpeg|png|webp)\z/i', $imagem)) continue;
                            $url = base_url('uploads/atitude-farmaceutica/' . rawurlencode($imagem));
                        ?>
                            <a href="<?= html_escape($url) ?>" target="_blank" rel="noopener noreferrer"><img src="<?= html_escape($url) ?>" alt="Imagem do projeto <?= html_escape($projeto->nome_projeto) ?>" loading="lazy"></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </template>
        </article>
    <?php endforeach; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('atitude-projetos-publicos').addEventListener('click', event => {
    const botao = event.target.closest('.atitude-projeto-ver-mais');
    if (!botao) return;
    const conteudo = document.createElement('div');
    conteudo.appendChild(botao.closest('.atitude-projeto').querySelector('.atitude-projeto-detalhes').content.cloneNode(true));
    Swal.fire({ title: 'Sobre o projeto', html: conteudo, width: 850, customClass: { popup: 'atitude-projeto-popup', htmlContainer: 'atitude-projeto-modal' }, showCloseButton: true, confirmButtonText: 'Fechar', confirmButtonColor: '#12455e' });
});
</script>
