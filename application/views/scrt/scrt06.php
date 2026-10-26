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
?>
            <div class="row">
                <div class="col-md-12"><h5><u>Emissão do Termo de Compromisso</u></h5><br><br></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group"><i>***O Termo de Compromisso deverá ser <b>impresso, assinado por ambas as partes, digitalizado e anexado</b> quando for solicitado!</i></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
<?php
        require_once('../classes/carregador.php');
        $banco = new mysql_site();
        $metodos = new metodos();
        $row = $banco -> pdo -> query("SELECT crfmg,protocolo,data_solicitacao,hora_solicitacao FROM scrt where id=".$this -> session -> userdata['SOLICITACAO'].";");
        foreach ($row as $r) {
            $condicao = true;
            echo '
                <tr class="d-flex">
                    <td class="col-lg-2" align="left"><b>Registro</b><br><br>'.$r["crfmg"].'</td>
                    <td class="col-lg-4" align="center"><b>Protocolo</b><br><br>'.$r["protocolo"].'</td>
                    <td class="col-lg-2" align="center"><b>Data</b><br><br>'.$metodos -> mascara_data($r["data_solicitacao"]).'</td>
                    <td class="col-lg-2" align="center"><b>Hora</b><br><br>'.$metodos -> mascara_hora($r["hora_solicitacao"]).'</td>
                    <td class="col-lg-2" align="right"><a href="../scrt_termo_compromisso.php?solicitacao='.base64_encode($this -> session -> userdata['SOLICITACAO']).'&protocolo='.base64_encode($this -> session -> userdata['PROTOCOLO']).'" target="_blank"><input type="button" name="emitir" value="Emitir Termo" class="btn btn-info" id="btn-send"></a></td>
                </tr>
            ';
        }
?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group"><i>
                        ***Quando o Termo de Compromisso estiver emitido clique em <b>Concluir</b>!
                        <br><br>
                        ***A <b>Emissão do Termo de Compromisso</b> será concluída e não poderá ser alterada!
                    </i></div>
                </div>
            </div>
            <form name="frm06" action="<?= base_url(); ?>Scrt/frm06" method="POST" id="form-send">
            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="form-group">
                        <input type="hidden" name="finalizar" value="Concluir">
                        <button type="submit" class="btn btn-success col-md-6 col-lg-6" id="btn-send">
                            <i class="fa fa-check"></i> Concluir
                        </button>
                    </div>
                </div>
            </div>
            </form>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="form-group">
                    <a href="<?= base_url(); ?>Scrt/scrt00" target="_self" class="btn btn-warning col-md-6 col-lg-6"><i class="fa fa-chevron-left"></i> Resumo da Solicitação</a>
                    </div>
                </div>
            </div>
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
function numero(caracter) {
    return ((caracter >= "0") && (caracter <= "9"));
}
function f1() {
    if (confirm('Confirma essa escolha?')) {
        return true;
    }else{
        return false;
    }
}
</script>