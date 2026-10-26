<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Serviços</a></li>
        <li class="breadcrumb-item active" aria-current="page">Renovação da Certidão de Regularidade Técnica</li>
    </ol>
</nav>
<div class="container px-3 py-2" >
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<!--msg de retorno-->
<?php if (!empty($this -> session -> flashdata('tipo'))) { ?>
            <div class="alert alert-<?= $this -> session -> flashdata('tipo'); ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span style="font-size: 16px;"><?= $this -> session -> flashdata('msg'); ?></span>
            </div>
<?php } ?>
<!--fim msg de retorno-->
<?php
    require_once('../classes/carregador.php');
    $metodos = new metodos();
    $banco = new mysql_site();
    $condicao = false;
    $solicitacoes = '';
    //após definidos todos os status é necessário completar os status que permitem uma nova solicitacao
    if ((isset($this -> session -> LOGIN_ID)) && (!empty($this -> session -> LOGIN_ID))) {
        $row = $banco -> pdo -> query("SELECT id,crfmg,protocolo,data_solicitacao,hora_solicitacao FROM scrt where crfmg=".$this -> session -> INSCRICAO." and id_status in(1,4,7,10,13,65,25,67,68,69,70,35,36) order by id desc limit 1;");
        foreach ($row as $r) {
            $condicao = true;
            $solicitacoes .= '
                <form name="frm_index_'.$r["id"].'" action="'.base_url().'Scrt/frm_index" method="POST" onSubmit="javascript: return f1();">
                    <b>Registro:&nbsp;</b><i>'.$r["crfmg"].'</i><br><br>
                    <b>Protocolo:&nbsp;</b><i>'.$r["protocolo"].'</i><br><br>
                    <b>Data:&nbsp;</b><i>'.$metodos -> mascara_data($r["data_solicitacao"]).'</i><br><br>
                    <b>Hora:&nbsp;</b><i>'.$metodos -> mascara_hora($r["hora_solicitacao"]).'</i><br><br>
                    <input type="hidden" name="solicitacao" value="'.$r["id"].'">
                    <input type="hidden" name="protocolo" value="'.$r["protocolo"].'">
                    <input type="submit" name="continuar" value="Continuar Solicitação" class="btn btn-success col-md-6 col-lg-6" id="btn-send">
                    <br><br>
                    <a href="'.base_url().'" target="_self"><input type="button" name="voltar" value="Voltar" class="btn btn-warning col-md-6 col-lg-6" id="btn-send"></a>
                </form>
            ';
        }
    }
    if ($condicao == true) {
?>
            <div class="row">
                <div class="col-md-12"><h5><u>Continuar Solicitação</u></h5><br><br></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group"><?php echo $solicitacoes; ?></div>
                </div>
            </div>
<?php
    }else{
?>
            <div class="row">
                <div class="col-md-12">
                    <h5><u>Iniciar Solicitação</u></h5>
                </div>
            </div>
            <form name="frm_index" action="<?= base_url(); ?>Scrt/frm_index" method="POST" onSubmit="javascript: return f1();">
            <div class="row">
                <p style="font-size:0.9em;" class="mx-1" align="justify"><i>***A Certidão de Regularidade Técnica perderá  a validade conforme o inciso 5º do artigo 55 da Resolução 638 do CFF.<br><br>***Você deverá anexar o Vínculo Empregatício e/ou Acordo de Horas Extras caso necessário.<br><br>***Você deverá anexar o Comprovante de Pagamento da Anuidade caso o pagamento ainda não tenha sido confirmado pela Instituição Financeira.<br><br>***Você deverá anexar uma declaração (<a href="outras_atividades.pdf" target="_blank">baixe aqui</a>) informando o nome da empresa, cidade, horário de trabalho e função quando possuir outra atividade, mesmo não vinculada a profissão farmacêutica ou atividade de fiscal da vigilância sanitária.</i></p>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="form-group">
                        <input type="submit" name="avancar" value="Iniciar Solicitação" class="btn btn-success col-md-6 col-lg-6" id="btn-send">
                        <br><br>
                        <a href="<?= base_url(); ?>" target="_self"><input type="button" name="voltar" value="Voltar" class="btn btn-warning col-md-6 col-lg-6" id="btn-send"></a>
                    </div>
                </div>
            </div>
            </form>
<?php
    }
?>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
function f1() {
    if (confirm('Confirma essa escolha?')) {
        return true;
    }else{
        return false;
    }
}
</script>