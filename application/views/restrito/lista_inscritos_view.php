<style>
    .header-table { width: 100%; border-bottom: 2px solid #069; padding-bottom: 15px; margin-bottom: 20px; }
        .col-logo { width: 45%; vertical-align: middle; }
        .course-img { width: 80%; max-height: 650px; border-radius: 5px; }
        .col-title { width: 55%; padding-left: 15px; vertical-align: middle; }
        .course-title { font-size: 18pt; color: #069; font-weight: bold; }
		
	.supreme-container { background-color: #f4f6f9; padding: 20px; border-radius: 8px; }
    
    /* Cabeçalho de Filtros Estilo Supreme */
    .supreme-header { 
        background-color: #005691; 
        color: white; 
        padding: 15px 25px; 
        border-radius: 8px 8px 0 0;
        display: flex;
        gap: 20px;
        align-items: center;
        font-weight: bold;
        font-size: 0.85rem;
    }

    /* Card de Aluno */
    .student-row {
        background: white;
        border-bottom: 1px solid #dee2e6;
        padding: 15px 25px;
        display: flex;
        align-items: center;
        transition: background 0.2s;
    }
    .student-row:hover { background-color: #f8f9fa; }
    .student-row:last-child { border-radius: 0 0 8px 8px; border-bottom: none; }

    /* Indicador Lateral (Verde para ativos, Vermelho para pendentes) */
    .status-indicator {
        width: 5px;
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        background-color: #28a745; /* Verde */
    }

    /* Colunas Estilizadas */
    .col-id { width: 10%; text-align: center; color: #6c757d; font-size: 0.85rem; }
	.col-info { width: 40%; }
	.col-enrolment { width: 20%; }
	.col-contact { width: 30%; }
    .presencas-salvar { position: fixed; right: 24px; bottom: 24px; z-index: 1040; box-shadow: 0 4px 16px #0003; }
    .supreme-container { margin-bottom: 100px; }
    .col-actions { width: 15%; text-align: right; }

    .student-name { color: #005691; font-weight: bold; font-size: 1.1rem; display: block; }
    .student-meta { font-size: 0.8rem; color: #adb5bd; }
    
    .btn-supreme {
        border: 1px solid #005691;
        color: #005691;
        background: transparent;
        padding: 5px 12px;
        border-radius: 4px;
    }
    .btn-supreme:hover { background: #005691; color: white; }
</style>
<style>
    .contact-item { 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        margin-bottom: 4px;
        font-size: 0.85rem;
    }
    .contact-link {
        color: #333;
        text-decoration: none;
        transition: color 0.2s;
    }
    .contact-link:hover { color: #005691; }
    .btn-copy { 
        padding: 0; 
        border: none; 
        background: none; 
        cursor: pointer;
    }
</style>

<table class="header-table" cellpadding="0" cellspacing="0">
        <?php foreach($curso as $linha):   
		
		$courseid = $linha->courseid;
		
		?>
		<tr>
            <td class="col-logo">
                <?php $caminho_imagem = base_url()."uploads/cursos/". $linha->nome_curto .".png"; ?>
                <img src="<?= $caminho_imagem ?>" class="course-img">
            </td>
            <td class="col-title">
                <div class="course-title">LISTA DE PRESENÇA:</div>
                <div style="font-size: 13pt; color: #555; margin-top: 5px;">
                    <?= mb_strtoupper($linha->titulo) ?>
                </div>
            </td>
        </tr>
		<?php endforeach; ?>
    </table>
	
	<div class="container">
		<div class="bg-white p-3 rounded shadow-sm mb-4 border d-flex align-items-center justify-content-between flex-wrap">
			<div class="d-flex align-items-center mb-2 mb-md-0">
				<i class="fas fa-calendar-alt text-primary me-2 fs-4"></i>
				<h4 class="mb-0 text-primary">Gerenciar Lista de Presença</h4>
			</div>
			
			<div class="d-flex gap-2 flex-wrap">
			<a href="<?=base_url()?>restrito/Capacifar/exportar_excel/<?=$courseid;?>"
			   class="btn btn-sm btn-outline-success px-3"
			   title="Exportar inscritos para Excel">
				<i class="bi bi-file-earmark-excel"></i>
				Exportar Excel
			</a>

			<a href="<?=base_url()?>restrito/Capacifar/lista_portaria/<?=$courseid;?>"
			   target="_blank"
			   class="btn btn-sm btn-outline-danger px-3"
			   title="Gerar Lista Portaria em PDF">
				<i class="bi bi-file-earmark-pdf"></i>
				Lista Portaria
			</a>

			<a href="javascript:void(0)" 
			   onclick="escolherOrientacao('<?=base_url()?>restrito/cursos/lista_inscritos/<?=$courseid;?>')"
			   class="btn btn-sm btn-outline-primary px-3" 
			   title="Lista de Inscritos">
				<i class="bi bi-people"></i>
				Imprimir a Lista de Presença
			</a>
			</div>
		</div>
	</div>
	
<script>
	function escolherOrientacao(baseUrl) {
		Swal.fire({
			title: 'Configuração da Impressão',
			text: "Como deseja gerar a lista de presença?",
			icon: 'question',
			showCancelButton: true,
			showDenyButton: true,
			confirmButtonText: '<i class="bi bi-file-earmark-ruled"></i> Vertical',
			denyButtonText: '<i class="bi bi-file-earmark-ruled-fill"></i> Horizontal',
			cancelButtonText: 'Cancelar',
			confirmButtonColor: '#0d6efd', // Cor Primary do Bootstrap
			denyButtonColor: '#6c757d',    // Cor Secondary do Bootstrap
		}).then((result) => {
			let orientacao = '';
			
			if (result.isConfirmed) {
				orientacao = 'portrait'; // Vertical
			} else if (result.isDenied) {
				orientacao = 'landscape'; // Horizontal
			} else {
				return; // Cancelou
			}

			// Abre o link em uma nova aba passando o parâmetro via GET
			window.open(baseUrl + '?orientacao=' + orientacao, '_blank');
		});
	}
</script>
	
<div class="supreme-container">
    <div class="supreme-header">
        <div style="width: 10%">MOODLE</div>
		<div style="width: 40%">NOME / CPF</div>
		<div style="width: 20%">DATA DA INSCRIÇÃO</div>
		<div style="width: 30%">CONTATO</div>
    </div>

    <div class="shadow-sm">
        <?php if(!empty($inscritos)): ?>
            <?php foreach($inscritos as $aluno): 
                $tel_limpo = preg_replace('/[^0-9]/', '', $aluno->telefone);
                $nome_completo = mb_strtoupper($aluno->nome_completo);
            ?>
            <div class="student-row position-relative">
                <div class="status-indicator"></div>
                
                <div class="col-id">
                    <label class="d-block mb-2"><input type="checkbox" class="form-check-input presenca-aluno" value="<?=(int) $aluno->id_moodle?>" <?=in_array((int) $aluno->id_moodle, $presencas, TRUE) ? 'checked' : ''?> aria-label="Presença de <?=htmlspecialchars($aluno->nome_completo, ENT_QUOTES, 'UTF-8')?>"> Presença</label>
                    ID MOODLE<br>
                    <strong>#<?= $aluno->id_moodle ?? '---' ?></strong>
                </div>

                <div class="col-info px-3">
                    <span class="student-name"><?= $nome_completo ?></span>
                    <span class="student-meta">CPF: <?= $aluno->cpf ?></span>
                </div>

				<div class="col-enrolment px-3">
					<i class="bi bi-calendar-check text-muted"></i>
					<span><?= htmlspecialchars($aluno->data_inscricao ?: 'Não informada', ENT_QUOTES, 'UTF-8') ?></span>
					<div class="small text-muted mt-1">
						<i class="bi bi-geo-alt"></i>
						Cidade: <?= htmlspecialchars(trim($aluno->cidade ?? '') ?: 'Não informada', ENT_QUOTES, 'UTF-8') ?>
					</div>
				</div>
				
				<div class="col-contact px-3">
					<div class="contact-item">
						<i class="bi bi-envelope text-muted"></i>
						<button class="btn-copy" onclick="copyToClipboard('<?= $aluno->email ?>')" title="Copiar E-mail">
							<?= $aluno->email ?>
						</button>
					</div>

					<div class="contact-item">
						<?php if($tel_limpo): ?>
							<i class="bi bi-whatsapp text-success"></i>
							<a href="https://wa.me/55<?= $tel_limpo ?>" target="_blank" class="contact-link">
								<?= $aluno->telefone ?> 
							</a>
						<?php else: ?>
							<i class="bi bi-telephone text-muted"></i>
							<span class="text-muted small">Não informado</span>
						<?php endif; ?>
					</div>
				</div>

            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="student-row justify-content-center text-muted">
                Nenhum estudante encontrado para este curso.
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="presencas-salvar bg-white rounded p-2">
    <span id="presencas-status" role="status" aria-live="polite" class="d-block small mb-1"></span>
    <button type="button" id="salvar-presencas" class="btn btn-primary" disabled>Salvar Presenças</button>
</div>
<script>
(function () {
    const caixas = Array.from(document.querySelectorAll('.presenca-aluno'));
    const inicial = new Map(caixas.map(c => [c.value, c.checked]));
    const botao = document.getElementById('salvar-presencas');
    const status = document.getElementById('presencas-status');
    let salvando = false;
    const pendentes = () => caixas.filter(c => c.checked !== inicial.get(c.value));
    caixas.forEach(c => c.addEventListener('change', () => {
        botao.disabled = salvando || pendentes().length === 0;
        status.textContent = pendentes().length ? 'Alterações não salvas' : '';
    }));
    window.addEventListener('beforeunload', e => {
        if (pendentes().length) { e.preventDefault(); e.returnValue = ''; }
    });
    botao.addEventListener('click', async () => {
        if (salvando) return;
        const alteracoes = Object.fromEntries(pendentes().map(c => [c.value, c.checked]));
        salvando = true;
        botao.disabled = true;
        caixas.forEach(c => c.disabled = true);
        status.textContent = 'Salvando...';
        try {
            const resposta = await fetch(<?=json_encode(base_url('restrito/Capacifar/salvar_presencas/'.(int) $courseid))?>, {
                method: 'POST', credentials: 'same-origin', headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({csrf: <?=json_encode($presencas_csrf)?>, alteracoes})
            });
            const dados = await resposta.json();
            if (!resposta.ok || !dados.ok) throw new Error(dados.message || 'Falha ao salvar.');
            caixas.forEach(c => inicial.set(c.value, c.checked));
            status.textContent = 'Presenças salvas.';
        } catch (erro) {
            status.textContent = 'Não foi possível salvar. Suas marcações foram mantidas; tente novamente.';
        } finally {
            salvando = false;
            caixas.forEach(c => c.disabled = false);
            botao.disabled = pendentes().length === 0;
        }
    });
})();
</script>

