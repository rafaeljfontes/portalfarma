 <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Container Principal (Card) */
    .card-validacao {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden; /* Garante que a faixa verde respeite o arredondamento */
        background-color: #fff;
        max-width: 900px;
        margin: 30px auto;
    }

    /* Faixa de Status (Verde) */
    .status-valido-top {
        background-color: #d4e3d5; /* Verde claro da imagem */
        color: #3c5a3d;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: 400;
        border-bottom: 1px solid #c3d6c4;
    }

    /* Tabela Estilo Zebra */
    .table-validacao {
        width: 100%;
        border-collapse: collapse;
    }

    .table-validacao td {
        padding: 18px 20px;
        border-bottom: 1px solid #eee;
        font-size: 15px;
        color: #333;
        vertical-align: middle;
    }

    /* Coluna de Títulos (Labels) */
    .table-validacao td:first-child {
        width: 35%;
        color: #555;
    }

    /* Cores das Linhas Alternadas (Zebra) */
    .table-validacao tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .table-validacao tr:nth-child(even) {
        background-color: #f8f9fa; /* Cinza bem claro da imagem */
    }
	
    /* Ajuste para o texto Válido no final */
    .text-status-verde {
        color: #2d572c;
        font-weight: 500;
    }

    /* Remover borda da última linha */
    .table-validacao tr:last-child td {
        border-bottom: none;
    }
</style>

    <div class="card card-validacao shadow-lg">
        <div class="card-body p-5 text-center">
            
            <?php if (!empty($inscricao)): ?>
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

               <div class="container mt-5">
					<div class="card shadow border-0" style="border-radius: 15px;">
						<div class="card-body p-5">
							<h3 class="text-center fw-bold mb-4">Informações do Certificado</h3>
							
							<table class="table table-hover">
								<tbody>
									<tr>									
										<th class="text-muted"><?=($certificado['palestrante_tipo'] == 'p') ? 'Palestrante' : 'Nome';?></th>										
										<td class="fw-bold text-uppercase"><?= $certificado['nome'] ?></td>
									</tr>
									<tr>
										<th class="text-muted">EVENTO</th>
										<td><?= $certificado['titulo'] ?></td>
									</tr>
									<tr>
										<th class="text-muted">TIPO</th>
										<td>
											<?php 
												// Usando a lógica de cores que criamos antes
												$classe = "tipo-evento-" . $certificado['tipo_evento'];
												$labels = [1=>'Presencial', 2=>'Online', 3=>'URM', 4=>'Fiscalização Humanizada', 7=>'Seminário'];
												$label = $labels[$certificado['tipo_evento']] ?? 'Outro';
											?>
											<span class="badge-tipo <?= $classe ?>"><?= $label ?></span>
										</td>
									</tr>
									<tr>
										<th class="text-muted">CARGA HORÁRIA</th>
										<td><span class="badge bg-dark"><?= $certificado['carga_horaria'] ?></span></td>
									</tr>
									<tr>
										<th class="text-muted">DATA DE CONCLUSÃO</th>
										<td><?= $certificado['data_fim'] ?></td>
									</tr>
								</tbody>
							</table>

							<div class="alert alert-success text-center mt-4">
								<i class="bi bi-check-circle-fill me-2"></i> Este certificado é válido e autêntico.
							</div>
						</div>
					</div>
				</div>

            <?php else: ?>
                <div class="status-icon text-danger">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <h2 class="fw-bold text-dark">Certificado não Encontrado</h2>
                <p class="text-muted">Não foi possível validar as informações deste certificado. Verifique o link ou entre em contato com o suporte.</p>
                
                <div class="mt-4">
					<a href="<?= base_url() ?>"  class="btn-voltar">Voltar ao Portal</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
