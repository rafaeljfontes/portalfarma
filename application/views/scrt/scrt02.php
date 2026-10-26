<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Serviços</a></li>
        <li class="breadcrumb-item active" aria-current="page">Renovação da Certidão de Regularidade Técnica</li>
    </ol>
</nav>
<div class="container px-3 py-2" >
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php
    if ((!empty($this -> session -> userdata['PROTOCOLO'])) && (!empty($this -> session -> userdata['SOLICITACAO'])) && (isset($this -> session -> LOGIN_ID)) && (!empty($this -> session -> LOGIN_ID))) {
        require_once('../classes/carregador.php');
        $metodos = new metodos();
        $profissionais_estabelecimento = '';
        $banco = new BancoSite();
        $row = $banco -> pdo -> query("SELECT syscrf.tblCRTResponsabilidade.InscricaoPFId,syscrf.tblPF.NomePF,syscrf.refTipoResponsabilidade.TipoResponsabilidade,(SELECT count(*) as total FROM syscrf.tblPJPropriedade WHERE syscrf.tblPJPropriedade.InscricaoPFId=syscrf.tblCRTResponsabilidade.InscricaoPFId and syscrf.tblPJPropriedade.InscricaoPJId=syscrf.tblCRTResponsabilidade.InscricaoPJId) as propriedade FROM (((syscrf.tblPF INNER JOIN ((syscrf.tblCRTResponsabilidade INNER JOIN syscrf.tblPJ ON syscrf.tblCRTResponsabilidade.InscricaoPJId = syscrf.tblPJ.InscricaoPJId) INNER JOIN syscrf.tblCRT ON (syscrf.tblCRTResponsabilidade.CRTId = syscrf.tblCRT.CRTId) AND (syscrf.tblPJ.InscricaoPJId = syscrf.tblCRT.InscricaoPJId)) ON syscrf.tblPF.InscricaoPFId = syscrf.tblCRTResponsabilidade.InscricaoPFId) INNER JOIN syscrf.refTipoResponsabilidade ON syscrf.tblCRTResponsabilidade.TipoResponsabilidadeId = syscrf.refTipoResponsabilidade.TipoResponsabilidadeId) INNER JOIN syscrf.refStatusCadastralCRT ON syscrf.tblCRTResponsabilidade.StatusId = syscrf.refStatusCadastralCRT.StatusId) LEFT JOIN syscrf.tblPJPropriedade ON (syscrf.tblCRTResponsabilidade.InscricaoPJId = syscrf.tblPJPropriedade.InscricaoPJId) AND (syscrf.tblCRTResponsabilidade.InscricaoPFId = syscrf.tblPJPropriedade.InscricaoPFId) inner join syscrf.refTipoPJ on (syscrf.tblPJ.tipopjid=syscrf.refTipoPJ.TipoPJId) WHERE (((syscrf.tblCRTResponsabilidade.InscricaoPJId)=".$this -> session -> INSCRICAO.") AND ((syscrf.tblCRTResponsabilidade.StatusId) In (1,2))) ORDER BY syscrf.tblCRTResponsabilidade.StatusId, syscrf.tblCRTResponsabilidade.DataInicial DESC , syscrf.tblCRTResponsabilidade.DataFinal DESC;");
        foreach ($row as $r) {
            if (empty($r["propriedade"])) {
                $profissionais_estabelecimento .= '<option value="'.$r["InscricaoPFId"].'">'.$metodos -> texto_simples($r["NomePF"]).' | '.$metodos -> texto_simples($r["TipoResponsabilidade"]).'</option>';
            }
        }
        $banco = new mysql_site();
        $condicao = false;
        $responsaveis = '
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
        ';
        $row = $banco -> pdo -> query("SELECT id,crfmg,data_saida FROM scrt_baixa where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by data_saida,crfmg;");
        foreach ($row as $r) {
            $condicao = true;
            $responsaveis .= '
                <form name="frm02_'.$r["id"].'" action="'.base_url().'Scrt/frm02" method="POST" onSubmit="javascript: return f1();">
                <tr class="d-flex">
                    <td class="col-lg-5" align="left">Inscrição: '.$r["crfmg"].'</td>
                    <td class="col-lg-5" align="center">Data da Saída: '.$metodos -> mascara_data($r["data_saida"]).'</td>
                    <td class="col-lg-2" align="right">
                        <input type="hidden" name="id_responsavel" value="'.$r["id"].'">
                        <input type="submit" name="remover" value="(-) Remover" class="btn btn-danger" id="btn-send">
                    </td>
                </tr>
                </form>
            ';
        }
        $responsaveis .= '
                    </table>
                </div>
            </div>
        ';
        if ($condicao == true) {
?>
            <div class="row">
                <div class="col-md-12"><h5><u>Baixa Solicitada</u></h5><br><br></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group"><?php echo $responsaveis; ?></div>
                </div>
            </div>
<?php
        }
?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group"><i>
                        ***Quando todas as Baixas estiverem cadastradas clique em <b>Concluir Cadastro</b>!
                        <br><br>
                        ***A <b>Baixa de Responsabilidade Técnica</b> será concluída e não poderá ser alterada!
                        <br><br>
                        ***Caso não necessite realizar a Baixa de Responsabilidade Técnica clique em <b>Concluir Cadastro</b>!
                    </i></div>
                </div>
            </div>
            <form name="frm02_" action="<?= base_url(); ?>Scrt/frm02" method="POST" onSubmit="javascript: return f1();">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <div class="form-group"><input type="submit" name="finalizar" value="Concluir Cadastro" class="btn btn-success col-md-6 col-lg-6" id="btn-send"></div>
                </div>
            </div>
            </form>
            <hr>
            <div class="row">
                <div class="col-md-12"><h5><u>Baixa de Responsabilidade Técnica</u></h5><br><br></div>
            </div>
            <div class="row">
                <div class="col-md-12"><p style="font-size:0.9em;" class="mx-1" align="justify"><i>***Resolução 596 do CFF: O farmacêutico, durante o tempo em que permanecer inscrito em um Conselho Regional de Farmácia, independentemente de estar ou não no exercício efetivo da profissão, deve comunicar ao Conselho Regional de Farmácia, em 5 (cinco) dias, o encerramento de seu vínculo profissional de qualquer natureza, independentemente de retenção de documentos pelo empregador.<br><br>***O Profissional Farmacêutico Proprietário/Sócio do Estabelecimento deverá solicitar a Baixa de Responsabilidade Técnica pela Área do Farmacêutico!<br><br>***O campo -Data da Saída do Estabelecimento- deverá ser igual a data atual ou retroativa. Não pode ser uma data futura!</i></p></div>
            </div>
<!--msg de retorno-->
<?php if (!empty($this -> session -> flashdata('tipo'))) { ?>
            <div class="alert alert-<?= $this -> session -> flashdata('tipo'); ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span style="font-size: 16px;"><?= $this -> session -> flashdata('msg'); ?></span>
            </div>
<?php } ?>
<!--fim msg de retorno-->
            <form name="frm02" action="<?= base_url(); ?>Scrt/frm02" method="POST" id="form-send">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <b>Selecione o Profissional para dar Baixa:</b><br>
                        <select name="crfmg" class="form-control" required="required">
                            <option value="0" selected disabled>-Selecione-</option>
                            <?php echo $profissionais_estabelecimento; ?>
                        </select>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div>
                        <b>Data da Saída do Estabelecimento:</b><br>
                        <input type="text" inputmode="numeric" name="data_saida" maxlength="10" required="required" id="data_saida" value="<?=set_value('data_saida');?>" placeholder="dd/mm/aaaa" class='form-control mask_date'>
                        <?=form_error('data_saida','<small class="form-text text-muted label-error">', '</small>'); ?>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="form-group">
                        <input type="hidden" name="acao" value="cadastrar">
                        <button type="submit" class="btn btn-success col-md-6 col-lg-6" id="btn-send">
                            <i class="fa fa-plus"></i> Cadastrar
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="form-group">
                    <a href="<?= base_url(); ?>Scrt/scrt00" target="_self" class="btn btn-warning col-md-6 col-lg-6"><i class="fa fa-chevron-left"></i> Resumo da Solicitação</a>
                    </div>
                </div>
            </div>
            </form>
<?php
    }else{
        redirect(base_url().'scrt/index');
    }
?>
        </div>
    </div>
</div>


<script src="<?=base_url()?>assets/js/input-mask/dist/jquery.inputmask.min.js"></script>
<script>
    $(function(){
        $('.mask_date').inputmask({alias:'datetime', placeholder: 'dd/mm/aaaa', inputFormat: "dd/mm/yyyy" });
    })
</script>