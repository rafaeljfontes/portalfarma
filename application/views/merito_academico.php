<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Farma - Mérito Acadêmico</title>
	
	<style>
    :root{
        --brand:#0d6efd;
        --brand-2:#2f4bd1;
        --ink:#0f172a;
        --muted:#64748b;
        --line:#e2e8f0;
        --bg:#f6f8ff;
    }

    body{
        background: radial-gradient(1200px 600px at 10% 10%, #eef2ff, transparent),
                    radial-gradient(900px 500px at 90% 20%, #f1f5ff, transparent),
                    linear-gradient(135deg, #f8faff, #ffffff);
    }

    /* ====== WRAP ====== */
    .page-wrap{
        padding: 18px 0 40px;
    }

    /* ====== CARD PRINCIPAL ====== */
    .form-card{
        background:#fff;
        border:1px solid rgba(226,232,240,.9);
        border-radius: 18px;
        overflow:hidden;
        box-shadow: 0 18px 50px rgba(15, 23, 42, .10);
        max-width: 980px;
        margin: 0 auto;
    }

    /* ====== HEADER ====== */
    .form-header{
        padding: 18px 22px;
        background: linear-gradient(135deg, rgba(13,110,253,.10), rgba(47,75,209,.06));
        border-bottom: 1px solid var(--line);
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap: 12px;
    }
    .form-header h2{
        margin:0;
        font-size: 18px;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -.2px;
        line-height: 1.25;
    }
    .form-header .sub{
        margin-top:6px;
        font-size: 13px;
        color: var(--muted);
        max-width: 680px;
    }
    .badge-soft{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding: 8px 12px;
        border-radius: 999px;
        font-weight:700;
        font-size: 12px;
        color:#1e40af;
        background:#dbeafe;
        border:1px solid #bfdbfe;
        white-space:nowrap;
        height: fit-content;
    }

    /* ====== BODY ====== */
    .form-body{
        padding: 20px 22px 22px;
    }

    /* ====== INFO BOX ====== */
    .info-box{
        background:#eff6ff;
        border:1px solid #bfdbfe;
        border-radius: 14px;
        padding: 14px 14px;
        color:#0f172a;
        line-height: 1.6;
        margin-bottom: 18px;
        position: relative;
    }
    .info-box .title{
        font-weight: 800;
        color:#1e40af;
        margin-bottom: 6px;
        display:flex;
        align-items:center;
        gap:10px;
        font-size: 14px;
    }
    .info-box p{
        margin:0;
        font-size: 13px;
        color:#0f172a;
    }

    /* ====== FLASH ALERT (BOOTSTRAP + CLEAN) ====== */
    .alert-clean{
        border-radius: 14px;
        border:1px solid rgba(226,232,240,.9);
        box-shadow: 0 10px 26px rgba(15, 23, 42, .08);
        padding: 12px 14px;
        display:flex;
        gap: 12px;
        align-items:flex-start;
    }
    .alert-clean .ico{
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display:flex;
        align-items:center;
        justify-content:center;
        flex: 0 0 34px;
    }
    .alert-clean .txt{
        flex:1;
    }
    .alert-clean .txt .t{
        font-weight: 800;
        margin-bottom: 2px;
        font-size: 14px;
        line-height:1.2;
    }
    .alert-clean .txt .m{
        font-size: 13px;
        color:#0f172a;
        line-height:1.35;
    }
    .alert-clean .close{
        opacity: .8;
        margin-left: 6px;
    }

    .alert-success.alert-clean{ background:#ecfdf5; border-color:#a7f3d0; }
    .alert-success.alert-clean .ico{ background: rgba(16,185,129,.12); color:#065f46; }
    .alert-danger.alert-clean{ background:#fef2f2; border-color:#fecaca; }
    .alert-danger.alert-clean .ico{ background: rgba(239,68,68,.12); color:#991b1b; }
    .alert-warning.alert-clean{ background:#fffbeb; border-color:#fde68a; }
    .alert-warning.alert-clean .ico{ background: rgba(245,158,11,.12); color:#92400e; }
    .alert-info.alert-clean{ background:#eff6ff; border-color:#bfdbfe; }
    .alert-info.alert-clean .ico{ background: rgba(59,130,246,.12); color:#1e40af; }

    /* ====== FORM ====== */
    .form-label{
        font-weight: 700;
        color: var(--ink);
        font-size: 13px;
        margin-bottom: 6px;
    }
    .form-control{
        border-radius: 12px;
        border-color: #d1d5db;
        padding: 12px 12px;
        font-size: 14px;
    }
    .form-control:focus{
        border-color: var(--brand);
        box-shadow: 0 0 0 .2rem rgba(13,110,253,.12);
    }

    /* ====== RADIO CHIPS ====== */
    .radio-row{
        display:flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 6px;
    }
    .radio-chip{
        /*border:1px solid #d1d5db;*/
        border-radius: 999px;
        padding: 8px 12px;
        cursor:pointer;
        display:flex;
        align-items:center;
        gap: 8px;
        user-select:none;
        background:#fff;
        transition: all .15s ease;
        font-size: 13px;
        font-weight:700;
        color:#0f172a;
    }
    .radio-chip input{ accent-color: var(--brand); }
    .radio-chip:hover{
        border-color: #b6c7ff;
        box-shadow: 0 10px 22px rgba(15, 23, 42, .08);
        transform: translateY(-1px);
    }

    /* ====== FOOTER ====== */
    .form-footer{
        padding: 16px 22px;
        border-top: 1px solid var(--line);
        background: #fbfcff;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .hint{
        font-size: 12px;
        color: var(--muted);
        margin:0;
    }
    .btn-enviar{
        padding: 12px 22px;
        font-size: 14px;
        font-weight: 800;
        border-radius: 14px;
        box-shadow: 0 14px 30px rgba(13,110,253,.20);
    }

    @media (max-width: 576px){
        .form-header{ padding: 16px 16px; }
        .form-body{ padding: 16px 16px; }
        .form-footer{ padding: 14px 16px; }
        .badge-soft{ display:none; }
    }
</style>
<style>
	/* Alert */
.alert{
    display:flex; gap:12px; align-items:flex-start;
    padding:14px 14px;
    border-radius:14px;
    margin: 0 0 18px 0;
    border:1px solid transparent;
    box-shadow: 0 10px 28px rgba(0,0,0,.08);
    animation: alertIn .22s ease-out;
}
@keyframes alertIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }

.alert .icon{
    width:34px;height:34px;border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    flex:0 0 34px;
}
.alert .content{flex:1}
.alert .title{font-weight:800;font-size:14px;margin-bottom:2px}
.alert .msg{font-size:13px;line-height:1.35;color:#111827}
.alert .close{
    border:none;background:transparent;cursor:pointer;
    font-size:18px;line-height:1;color:rgba(0,0,0,.45);
    padding:2px 6px;border-radius:10px;
}
.alert .close:hover{background:rgba(0,0,0,.06);color:rgba(0,0,0,.70)}

.alert-success{background:#ecfdf5;border-color:#a7f3d0}
.alert-success .icon{background:#10b9811a}
.alert-success .title{color:#065f46}

.alert-danger{background:#fef2f2;border-color:#fecaca}
.alert-danger .icon{background:#ef44441a}
.alert-danger .title{color:#991b1b}

.alert-warning{background:#fffbeb;border-color:#fde68a}
.alert-warning .icon{background:#f59e0b1a}
.alert-warning .title{color:#92400e}

.alert-info{background:#eff6ff;border-color:#bfdbfe}
.alert-info .icon{background:#3b82f61a}
.alert-info .title{color:#1e40af}

/* Campos */
.form-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.form-group{margin-bottom: 2px}
.form-group label{
    display:block;font-size:13px;font-weight:700;margin:0 0 6px;color:#111827
}
.form-group input{
    width:100%;
    padding:12px 14px;
    border-radius:12px;
    border:1px solid #d1d5db;
    font-size:14px; outline:none;
    background:#fff;
    transition: box-shadow .15s, border-color .15s, transform .05s;
}
.form-group input:focus{
    border-color:#3b5bdb;
    box-shadow:0 0 0 3px rgba(59,91,219,.14);
}
.form-group input::placeholder{color:#9ca3af}
.form-group input:active{transform:scale(.999)}

/* Linha única */
.form-row-1{grid-column: 1 / -1}

/* Botão */
.btn-submit{
    margin-top:16px;
    width:100%;
    padding:14px 16px;
    background: linear-gradient(135deg, #3b5bdb, #2f4bd1);
    color:#fff;border:none;border-radius:14px;
    font-size:16px;font-weight:800;cursor:pointer;
    transition: transform .2s, box-shadow .2s, filter .2s;
}
.btn-submit:hover{transform: translateY(-2px); box-shadow:0 12px 25px rgba(59,91,219,.32)}
.btn-submit:active{transform: translateY(-1px); filter: brightness(.98)}

.btn-voltar {
	margin: 2% 75% 2% 25%;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 52px;
    padding: 9px 20px;
    border-radius: 10px;
    background: #ffffffde;
    border: 1px solid #12455e;
    color: #12455e;
    font-size: 17px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    transition: background-color .25s ease, color .25s ease, border-color .25s ease, box-shadow .25s ease;
}
</style>
</head>

<body>
<div class="page-wrap">

    <!--
	<nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
            <li class="breadcrumb-item">Inscrição de alunos</li>
            <li class="breadcrumb-item active" aria-current="page">Cadastro</li>
        </ol>
    </nav>
	-->
	<a href="javascript:history.back()" class="btn-voltar">
                VOLTAR
            </a>

    <form action="<?=base_url()?>mertitoacademico/salvar" method="POST" id="form-send" autocomplete="on">
        <div class="form-card">

            <div class="form-header">
                <div>
                    <h2>Ficha de Solicitação da Comenda Lúcio Guedes Barra</h2>
                    <div class="sub">Preencha os dados abaixo para solicitar a participação do CRF/MG na entrega da medalha durante a colação de grau.</div>
                </div>
                <span class="badge-soft">
                    <i class="fas fa-award"></i> Mérito Acadêmico
                </span>
            </div>

            <div class="form-body">

                <!-- msg de retorno (flashdata) -->
                <?php if($this->session->flashdata('tipo') != ""){ ?>
                    <?php
                        $tipo = $this->session->flashdata('tipo'); // success | danger | warning | info
                        $msg  = $this->session->flashdata('msg');
                        $titleMap = [
                            'success' => 'Enviado com sucesso',
                            'danger'  => 'Não foi possível concluir',
                            'warning' => 'Atenção',
                            'info'    => 'Informação',
                        ];
                        $t = $titleMap[$tipo] ?? 'Mensagem';
                        $icoMap = [
                            'success' => '<i class="fas fa-check"></i>',
                            'danger'  => '<i class="fas fa-triangle-exclamation"></i>',
                            'warning' => '<i class="fas fa-circle-exclamation"></i>',
                            'info'    => '<i class="fas fa-circle-info"></i>',
                        ];
                        $ico = $icoMap[$tipo] ?? $icoMap['info'];
                    ?>
                    <div class="alert alert-<?=$tipo?> alert-clean mb-3" role="alert">
                        <div class="ico"><?=$ico?></div>
                        <div class="txt">
                            <div class="t"><?=$t?></div>
                            <div class="m" style="font-size:16px;"><?=$msg?></div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <!-- / msg de retorno -->

                <div class="info-box mb-4">
                    <div class="title">
                        <i class="fas fa-circle-info"></i>
                        Sobre a comenda
                    </div>
                    <p>
                        O Professor Lúcio Guedes Barra foi um dos principais personagens da profissão em nosso estado, com papel marcante no ensino farmacêutico e no CRF/MG.
                        <br><br>
                        Como homenagem, o CRF/MG criou a comenda de mérito acadêmico, concedida por representante do Conselho ao graduando de farmácia destaque da instituição durante a colação de grau.
                        Para solicitar a participação do CRF/MG na entrega da medalha, basta preencher o formulário abaixo.
                    </p>
                </div>

                <div class="form-grid">

                    <div class="form-group form-row-1">
                        <label for="instituicao" class="form-label">Nome da Instituição</label>
                        <input type="text" class="form-control" id="instituicao" name="instituicao"
                               placeholder="Nome da Instituição de Ensino" required>
                    </div>

                    <div class="form-group">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" required>
                    </div>

                    <div class="form-group">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" required>
                    </div>

                    <div class="form-group">
                        <label for="responsavel" class="form-label">Nome do Responsável</label>
                        <input type="text" class="form-control" id="responsavel" name="responsavel"
                               placeholder="Responsável pela solicitação" required>
                    </div>

                    <div class="form-group">
                        <label for="cargo_responsavel" class="form-label">Cargo do Responsável</label>
                        <input type="text" class="form-control" id="cargo_responsavel" name="cargo_responsavel"
                               placeholder="Cargo do responsável" required>
                    </div>

                    <div class="form-group">
                        <label for="telefone_responsavel" class="form-label">Telefone do Responsável</label>
                        <input type="text" class="form-control" id="telefone_responsavel" name="telefone_responsavel"
                               placeholder="(00) 00000-0000" required>
                    </div>

                   <div class="form-group">
                        <label for="email_responsavel" class="form-label">Email do Responsável</label>
                        <input type="email" class="form-control" id="email_responsavel" name="email_responsavel"
                               placeholder="email@exemplo.com" required>
                    </div>

                    <div class="form-group">
                        <label for="data_evento" class="form-label">Data da Colação de Grau</label>
                        <input type="date" class="form-control" id="data_evento" name="data_evento" required>
                    </div>

                    <div class="form-group">
                        <label for="hora_evento" class="form-label">Horário</label>
                        <input type="time" class="form-control" id="hora_evento" name="hora_evento" required>
                    </div>
                   
                    <div class="form-group">
                        <label class="form-label">O representante do CRF/MG irá compor a mesa de honra?</label>
                        <div class="radio-row">
                            <label class="radio-chip">
                                <input type="radio" name="mesa_de_honra" value="s" required>
                                <span>Sim</span>
                            </label>
                            <label class="radio-chip">
                                <input type="radio" name="mesa_de_honra" value="n" required>
                                <span>Não</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Haverá espaço para discurso/fala na entrega da medalha?</label>
                        <div class="radio-row">
                            <label class="radio-chip">
                                <input type="radio" name="discurso_entrega" value="s" required>
                                <span>Sim</span>
                            </label>
                            <label class="radio-chip">
                                <input type="radio" name="discurso_entrega" value="n" required>
                                <span>Não</span>
                            </label>
                        </div>
                    </div>
					
					 <div class="form-group form-row-1">
                        <label for="local_cerimonia" class="form-label">Local da Cerimônia</label>
                        <input type="text" class="form-control" id="local_cerimonia" name="local_cerimonia"
                               placeholder="Local onde a cerimônia será realizada" required>
                    </div>

                    <div class="form-group form-row-1">
                        <label for="graduando_homenageado" class="form-label">Nome do graduando homenageado (se houver)</label>
                        <input type="text" class="form-control" id="graduando_homenageado" name="graduando_homenageado"
                               placeholder="Nome do graduando homenageado" required>
                    </div>

                </div>

                <input type="hidden" id="data_cadastro" name="data_cadastro" value="<?=date('Y/m/d');?>">

            </div>

            <div class="form-footer">
                <p class="hint">
                    Ao enviar, você confirma que os dados informados estão corretos.
                </p>

                <button type="submit" class="btn btn-primary btn-enviar" id="btn-send">
                    <i class="fas fa-paper-plane"></i> Enviar
                </button>
            </div>

        </div>
    </form>

</div>
</body>
<script>
    $(function (){
        <?php if (validation_errors() != "") { ?>
            new Toast({
                message: 'Não foi possível enviar os dados. Verifique o preenchimento do formulário.',
                type: 'danger'
            });
        <?php } ?>

        $("#form-send").on('submit', function(){
            $("#btn-send").prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Enviando...");
        });
    });
</script>
