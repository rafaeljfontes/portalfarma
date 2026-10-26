<style>
    body { background-color: #f4f7f6; }
    .status-icon {
        font-size: 60px;
        margin-bottom: 20px;
    }
    .card-validacao {
        max-width: 700px;
        margin: 50px auto;
        border: none;
        border-radius: 15px;
    }
    .table-validacao th {
        background-color: #f8f9fa;
        color: #666;
        width: 35%;
        font-size: 13px;
        text-transform: uppercase;
    }
    .badge-check {
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
    }
</style>

<div class="container">
    <div class="card card-validacao shadow-lg">
        <div class="card-body p-5 text-center">
            
            <?php if ($valido): ?>
                <div class="status-icon text-success">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <h2 class="fw-bold text-dark">Certificado Autêntico</h2>
                <p class="text-muted">As informações abaixo foram validadas em nosso sistema oficial.</p>
                
                <div class="mt-4">
                    <span class="badge-check bg-success-subtle text-success">
                        <i class="bi bi-check2-all me-1"></i> Validação Concluída
                    </span>
                </div>

                <div class="table-responsive mt-5">
                    <table class="table table-bordered align-middle text-start table-validacao">
                        <tbody>
                            <tr>
                                <th>Aluno / Portador</th>
                                <td class="fw-bold"><?= $info->nome_aluno ?></td>
                            </tr>
                            <tr>
                                <th>Evento / Curso</th>
                                <td><?= str_replace("Edição - ", "", $info->evento) ?></td>
                            </tr>
                            <tr>
                                <th>Carga Horária</th>
                                <td><span class="badge bg-primary"><?= $info->carga_horaria ?> Horas</span></td>
                            </tr>
                            <tr>
                                <th>Data de Emissão</th>
                                <td><?= date('d/m/Y', strtotime($info->data_emissao)) ?></td>
                            </tr>
                            <tr>
                                <th>Código de Registro</th>
                                <td class="text-muted font-monospace small">#<?= str_pad($info->id, 8, '0', STR_PAD_LEFT) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <div class="status-icon text-danger">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <h2 class="fw-bold text-dark">Certificado não Encontrado</h2>
                <p class="text-muted">Não foi possível validar as informações deste certificado. Verifique o link ou entre em contato com o suporte.</p>
                
                <div class="mt-4">
                    <a href="<?= base_url() ?>" class="btn btn-primary px-4 py-2 rounded-pill">Voltar ao Portal</a>
                </div>
            <?php endif; ?>

        </div>
        <div class="card-footer bg-white border-0 text-center pb-4">
            <img src="<?= base_url('assets/img/logo-crf.png') ?>" alt="Logo" style="height: 40px; opacity: 0.6;">
        </div>
    </div>
</div>