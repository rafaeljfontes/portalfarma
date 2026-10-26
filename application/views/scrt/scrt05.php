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
        $crfmg_excluidos = '0';
        $banco = new mysql_site();
        $row = $banco -> pdo -> query("select crfmg FROM scrt_baixa where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." union select crfmg FROM scrt_assuncao where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." union select crfmg FROM scrt_assistencia where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." union select crfmg FROM scrt_renovacao where id_solicitacao=".$this -> session -> userdata['SOLICITACAO'].";");
        foreach ($row as $r) {
            $crfmg_excluidos .= ','.$r["crfmg"];
        }
        $profissionais_estabelecimento = '';
        $banco = new BancoSite();
        $row = $banco -> pdo -> query("SELECT syscrf.tblCRTResponsabilidade.InscricaoPFId,syscrf.tblPF.NomePF,syscrf.refTipoResponsabilidade.TipoResponsabilidade,(SELECT count(*) as total FROM syscrf.tblPJPropriedade WHERE syscrf.tblPJPropriedade.InscricaoPFId=syscrf.tblCRTResponsabilidade.InscricaoPFId and syscrf.tblPJPropriedade.InscricaoPJId=syscrf.tblCRTResponsabilidade.InscricaoPJId) as propriedade FROM (((syscrf.tblPF INNER JOIN ((syscrf.tblCRTResponsabilidade INNER JOIN syscrf.tblPJ ON syscrf.tblCRTResponsabilidade.InscricaoPJId = syscrf.tblPJ.InscricaoPJId) INNER JOIN syscrf.tblCRT ON (syscrf.tblCRTResponsabilidade.CRTId = syscrf.tblCRT.CRTId) AND (syscrf.tblPJ.InscricaoPJId = syscrf.tblCRT.InscricaoPJId)) ON syscrf.tblPF.InscricaoPFId = syscrf.tblCRTResponsabilidade.InscricaoPFId) INNER JOIN syscrf.refTipoResponsabilidade ON syscrf.tblCRTResponsabilidade.TipoResponsabilidadeId = syscrf.refTipoResponsabilidade.TipoResponsabilidadeId) INNER JOIN syscrf.refStatusCadastralCRT ON syscrf.tblCRTResponsabilidade.StatusId = syscrf.refStatusCadastralCRT.StatusId) LEFT JOIN syscrf.tblPJPropriedade ON (syscrf.tblCRTResponsabilidade.InscricaoPJId = syscrf.tblPJPropriedade.InscricaoPJId) AND (syscrf.tblCRTResponsabilidade.InscricaoPFId = syscrf.tblPJPropriedade.InscricaoPFId) inner join syscrf.refTipoPJ on (syscrf.tblPJ.tipopjid=syscrf.refTipoPJ.TipoPJId) WHERE (((syscrf.tblCRTResponsabilidade.InscricaoPJId)=".$this -> session -> INSCRICAO.") AND ((syscrf.tblCRTResponsabilidade.StatusId) In (1,2)) and syscrf.tblCRTResponsabilidade.InscricaoPFId not in (".$crfmg_excluidos.")) ORDER BY syscrf.tblCRTResponsabilidade.StatusId, syscrf.tblCRTResponsabilidade.DataInicial DESC , syscrf.tblCRTResponsabilidade.DataFinal DESC;");
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
        $row = $banco -> pdo -> query("SELECT id,crfmg,acordo,declaracao,vinculo FROM scrt_renovacao where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by crfmg;");
        foreach ($row as $r) {
            $condicao = true;
            $responsaveis .= '
                <form name="frm05_'.$r["id"].'" action="'.base_url().'Scrt/frm05" method="POST" onSubmit="javascript: return f1();">
                <tr class="d-flex">
                    <td class="col-lg-2" align="left">'.$r["crfmg"].'</td>
                    <td class="col-lg-2" align="left">'.$r["vinculo"].'</td>
                    <td class="col-lg-3" align="left">'.(($r["acordo"] == 's') ? 'possui acordo de horas extras' : 'não possui acordo de horas extras').'</td>
                    <td class="col-lg-3" align="left">'.(($r["declaracao"] == 's') ? 'declara outras atividades' : 'não declara outras atividades').'</td>
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
                <div class="col-md-12"><h5><u>Atualização de Documentação Solicitada</u></h5><br><br></div>
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
                        ***Quando todas as Atualizações de Documentação estiverem cadastradas clique em <b>Concluir Cadastro</b>!
                        <br><br>
                        ***A <b>Atualização de Documentação</b> será concluída e não poderá ser alterada!
                        <br><br>
                        ***Caso não necessite realizar a Atualização de Documentação clique em <b>Concluir Cadastro</b>!
                    </i></div>
                </div>
            </div>
            <form name="frm05_" action="<?= base_url(); ?>Scrt/frm05" method="POST" onSubmit="javascript: return f1();">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <div class="form-group"><input type="submit" name="finalizar" value="Concluir Cadastro" class="btn btn-success col-md-6 col-lg-6" id="btn-send"></div>
                </div>
            </div>
            </form>
            <hr>
            <div class="row">
                <div class="col-md-12"><h5><u>Atualização de Documentação</u></h5><br><br></div>
            </div>
<!--msg de retorno-->
<?php if (!empty($this -> session -> flashdata('tipo'))) { ?>
            <div class="alert alert-<?= $this -> session -> flashdata('tipo'); ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span style="font-size: 16px;"><?= $this -> session -> flashdata('msg'); ?></span>
            </div>
<?php } ?>
<!--fim msg de retorno-->
            <form name="frm05" action="<?= base_url(); ?>Scrt/frm05" method="POST" id="form-send">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <b>Selecione o Profissional para Atualizar a Documentação:</b><br>
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
                    <div class="form-group">
                        <b>Possui Acordo de Horas Extras?</b><br>
                        <?=form_error('acordo','<p class="mt-2"><small style="color:red">', '</small></p>'); ?>
                        <p class='mt-3' align="justify">
                            <input type="radio" class='ml-5' name="acordo" value="s" id="acordo_s" <?=set_radio('acordo', 's');?>>
                            &nbsp;<label for="acordo_s">Sim</label></p>
                        <p class='mt-3' align="justify">
                            <input type="radio" class='ml-5' name="acordo" value="n" id="acordo_n" <?=set_radio('acordo', 'n');?>>
                            &nbsp;<label for="acordo_n">Não</label></p>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <b>Possui outra atividade, mesmo não vínculada a profissão farmacêutica ou atividade de fiscal da vigilância sanitária?</b><br>
                        <?=form_error('declaracao','<p class="mt-2"><small style="color:red">', '</small></p>'); ?>
                        <p class='mt-3' align="justify">
                        <input type="radio" class='ml-5' name="declaracao" id='declaracao_s' value="s" <?=set_radio('declaracao', 's');?> >
                        &nbsp;<label for="declaracao_s">Sim</label>
                        <a href="<?= base_url(); ?>/uploads/arquivos/ANEXO_XVIII_DECLARACAO_DE_OUTRAS_ATIVIDADES_DE_FARMACEUTICO_RES_CFF_700_2021.pdf" target="_blank"><i>clique aqui para baixar a Declaração de Outras Atividades</i></a></p>
                        <p class='mt-3' align="justify">
                        <input type="radio" class='ml-5' name="declaracao" id='declaracao_n' value="n" <?=set_radio('declaracao', 'n');?> >
                        &nbsp;<label for="declaracao_n">Não</label>
                        </p>
                        <p class='mt-3' align="justify">
                            <div class="alert alert-info"><small>Caso sim, a declaração deve ser <b>baixada, preenchida, assinada, digitalizada e anexada</b> quando solicitada.</small></div>
                        </p>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <b>Vínculo Empregatício:</b><br>
                        <?=form_error('vinculo','<p class="mt-2"><small style="color:red">', '</small></p>'); ?>
                        <p class='mt-3' align="justify">
                            <input type="radio" class='ml-5' name="vinculo" id="vinculo_ct" value="Carteira de Trabalho" <?=set_radio('vinculo', 'Carteira de Trabalho');?>>
                            &nbsp; <label for="vinculo_ct">Carteira de Trabalho</label>
                        </p>
                        <p class='mt-3' align="justify">
                            <input type="radio" class='ml-5' name="vinculo" id="vinculo_outro" value="Outro" <?=set_radio('vinculo', 'Outro');?>>
                            &nbsp; <label for="vinculo_outro">Outro</label>
                        </p>
                        <p class='mt-3' align="justify">
                            <input type="radio" class='ml-5' name="vinculo" id="vinculo_nao" value="Não se aplica" <?=set_radio('vinculo', 'Não se aplica');?>>
                            &nbsp; <label for="vinculo_nao">Não se aplica&nbsp;(Proprietário/Sócio)</label>
                        </p>
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

        $('form').attr('autocomplete', 'off');

        $("#form-send").submit(function(){
            $("#btn-send").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
        });

    });
</script>
<script language="javascript" type="text/javascript">
function f1() {
    if (confirm('Confirma essa escolha?')) {
        return true;
    }else{
        return false;
    }
}
</script>