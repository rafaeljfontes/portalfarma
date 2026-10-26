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
        $banco = new mysql_site();
        $condicao = false;
        $responsaveis = '
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
        ';
        $row = $banco -> pdo -> query("select sdpj.id,sta.nome from scrt_documentacao_pj as sdpj inner join scrt_tipo_anexo as sta on (sdpj.id_tipo_anexo=sta.id) where sdpj.ativo='s' and sdpj.id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by sta.nome;");
        foreach ($row as $r) {
            $condicao = true;
            $arquivo1 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PJ_'.$r["id"].'.png';
            $arquivo2 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PJ_'.$r["id"].'.pdf';
            $link = null;
            if (file_exists($arquivo1)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PJ_'.$r["id"].'.png'.'" target="_blank">visualizar</a>';
            }
            if (file_exists($arquivo2)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PJ_'.$r["id"].'.pdf'.'" target="_blank">visualizar</a>';
            }
            $responsaveis .= '
                <form name="frm07_'.$r["id"].'" action="'.base_url().'Scrt/frm07" method="POST" onSubmit="javascript: return f1();">
                <tr class="d-flex">
                    <td class="col-lg-8" align="left">'.$r["nome"].'</td>
                    <td class="col-lg-2" align="center" nowrap>'.$link.'</td>
                    <td class="col-lg-2" align="right">
                        <input type="hidden" name="id_documentacao_pj" value="'.$r["id"].'">
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
                <div class="col-md-12"><h5><u>Documentação do Estabelecimento Anexada</u></h5><br><br></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group"><?php echo $responsaveis; ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group"><i>
                        ***Quando todos os Documentos estiverem anexados clique em <b>Concluir</b>!
                        <br><br>
                        ***O <b>Anexo da Documentação do Estabelecimento</b> será concluído e não poderá ser alterado!
                    </i></div>
                </div>
            </div>
            <form name="frm07_" action="<?= base_url(); ?>Scrt/frm07" method="POST" onSubmit="javascript: return f1();">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <div class="form-group"><input type="submit" name="finalizar" value="Concluir" class="btn btn-success col-md-6 col-lg-6" id="btn-send"></div>
                </div>
            </div>
            </form>
            <hr>
<?php
        }
?>
            <div class="row">
                <div class="col-md-12"><h5><u>Anexar Documentação do Estabelecimento</u></h5><br><br></div>
            </div>
<!--msg de retorno-->
<?php if (!empty($this -> session -> flashdata('tipo'))) { ?>
            <div class="alert alert-<?= $this -> session -> flashdata('tipo'); ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span style="font-size: 16px;"><?= $this -> session -> flashdata('msg'); ?></span>
            </div>
<?php } ?>
<!--fim msg de retorno-->
            <form name="frm07" action="<?= base_url(); ?>Scrt/frm07" method="POST" enctype="multipart/form-data" id="form-send-file">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <b>Documento:&nbsp;</b>
                        <br><br>
                        <select name="id_tipo_anexo" class="form-control" required="required">
                            <option value="0" selected disabled>-Selecione-</option>
                            <?php
                                $row = $banco -> pdo -> query("SELECT id,nome FROM scrt_tipo_anexo where ativo='s' and pessoa='PJ' order by nome;");
                                foreach ($row as $r) {
                                    echo '<option value="'.$r["id"].'">'.$r["nome"].'</option>';
                                }
                            ?>
                        </select>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="arquivo" class="btn btn-primary"> Escolher Arquivo</label>
                        <input name="arquivo" type="file" id="arquivo" readonly="readonly" style="display:none;"  accept="application/pdf,image/*" capture="camera" required />
                        <span class='ml-3' id='boxArquivoSelecionado' style='display:none;'></span>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="form-group">
                        <input type="hidden" name="acao" value="enviar">
                        <button class="btn btn-success col-md-6 col-lg-6" id="btn-enviar-anexo" >
                            Enviar Anexo
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

<script>
    $(function(){

        $('form').attr('autocomplete', 'off');
        $("#form-send-file").submit(function(){
            $("#btn-enviar-anexo").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
        });

        $("input[name='arquivo']").change(function(){
            $("#boxArquivoSelecionado").show().html("<b>Arquivo Selecionado: </b>" + document.getElementById('arquivo').files[0].name);
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