<div class="container py-4">
    <h2>BJHP — Importar dados</h2>
    <p>Atualize os artigos e as edições publicados na revista.</p>
    <div id="bjhp-alert" role="alert" aria-live="polite" class="<?= $erro ? 'alert alert-danger' : 'd-none' ?>"><?= html_escape($erro ?? '') ?></div>
    <?= form_open('restrito/bjhp/importar_api', array('id' => 'bjhp-form')) ?>
        <input type="hidden" name="bjhp_csrf" value="<?= html_escape($this->session->userdata('bjhp_csrf')) ?>">
        <button type="submit" id="bjhp-submit" class="btn btn-primary mb-4" <?= $erro ? 'disabled' : '' ?>>Importar dados API</button>
    </form>
    <div class="card"><div class="card-body">
        <h3 class="h5">Histórico de importação</h3>
        <div class="table-responsive"><table class="table">
            <thead><tr><th>Data/Hora da última importação</th><th>Usuário</th><th>ID do usuário</th><th>Artigos</th><th>Edições</th></tr></thead>
            <tbody id="bjhp-history" aria-live="polite">
            <?php if ($historico): ?><tr>
                <?php foreach (array('criado_em', 'usuario_nome', 'usuario_id', 'artigos', 'edicoes') as $key): ?>
                    <td><?= html_escape($historico[$key]) ?></td>
                <?php endforeach; ?>
            </tr><?php else: ?><tr><td colspan="5">Nenhuma importação realizada.</td></tr><?php endif; ?>
            </tbody>
        </table></div>
    </div></div>
</div>
<script src="<?= base_url('assets/js/bjhp.js') ?>"></script>
