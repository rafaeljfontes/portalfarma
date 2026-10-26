<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Serviços</a></li>
        <li class="breadcrumb-item active" aria-current="page">Renovação da Certidão de Regularidade Técnica</li>
    </ol>
</nav>
<div class="container px-3 py-2" >
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-md-12"><h5><u>Resumo da Solicitação</u></h5><br><br></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                    <form name="frm00" action="<?=base_url()?>Scrt/frm00" method="POST" onSubmit="javascript: return f1();">
<?php
    if ((!empty($this -> session -> userdata['PROTOCOLO'])) && (!empty($this -> session -> userdata['INSCRICAO'])) && (!empty($this -> session -> userdata['SOLICITACAO'])) && (isset($this -> session -> LOGIN_ID)) && (!empty($this -> session -> LOGIN_ID))) {
        require_once('../classes/carregador.php');
        $contador = 0;
        $cabecalho = '';
        $corpo = '';
        $rodape = '';
        $baixa = null;
        $assuncao = null;
        $assistencia = null;
        $renovacao = null;
        $metodos = new metodos();
        $banco = new mysql_site();
        $row = $banco -> pdo -> query("SELECT s.baixa,s.assuncao,s.assistencia,s.renovacao,s.id,s.id_status,s.crfmg,s.protocolo,s.data_solicitacao,s.hora_solicitacao,s.id_hf,s.id_hi,s.funcionamento,s.baixa,s.assuncao,s.assistencia,s.renovacao,ss0.nome as status_solicitacao,shf.dom_i as dom_ih,shf.dom_f as dom_fh,shi.dom_i as dom_ii,shi.dom_f as dom_fi,shf.seg_i as seg_ih,shf.seg_f as seg_fh,shi.seg_i as seg_ii,shi.seg_f as seg_fi,shf.ter_i as ter_ih,shf.ter_f as ter_fh,shi.ter_i as ter_ii,shi.ter_f as ter_fi,shf.qua_i as qua_ih,shf.qua_f as qua_fh,shi.qua_i as qua_ii,shi.qua_f as qua_fi,shf.qui_i as qui_ih,shf.qui_f as qui_fh,shi.qui_i as qui_ii,shi.qui_f as qui_fi,shf.sex_i as sex_ih,shf.sex_f as sex_fh,shi.sex_i as sex_ii,shi.sex_f as sex_fi,shf.sab_i as sab_ih,shf.sab_f as sab_fh,shi.sab_i as sab_ii,shi.sab_f as sab_fi FROM scrt as s inner join scrt_status as ss0 on (s.id_status=ss0.id) left join scrt_horario as shf on (s.id_hf=shf.id) left join scrt_horario as shi on (s.id_hi=shi.id) where s.crfmg=".$this -> session -> INSCRICAO." order by s.id desc limit 1;");
        foreach ($row as $r) {
            $baixa = $r["baixa"];
            $assuncao = $r["assuncao"];
            $assistencia = $r["assistencia"];
            $renovacao = $r["renovacao"];
            $id_status = $r["id_status"];
            if (empty($contador)) {
                $cabecalho = '
                    <input type="hidden" name="status" value="'.$r["id_status"].'">
                    <b>Registro:&nbsp;</b><i>'.$r["crfmg"].'</i><br><br>
                    <b>Protocolo:&nbsp;</b><i>'.$r["protocolo"].'</i><br><br>
                    <b>Data:&nbsp;</b><i>'.$metodos -> mascara_data($r["data_solicitacao"]).'</i><br><br>
                    <b>Hora:&nbsp;</b><i>'.$metodos -> mascara_hora($r["hora_solicitacao"]).'</i><br><br>
                ';
                if ((!empty($r["id_hf"])) && (!empty($r["id_hi"]))) {
                    if ( $id_status != 35 ){
                        $cabecalho .= '<a href="'.base_url().'scrt/scrt01" class="btn btn-success"><i class="fa fa-edit"></i> Editar Horário de Funcionamento</a><br><br>';
                    }
                    $cabecalho .= '
                    <div class="table-responsive">
                        <br><b>Horário de Funcionamento do Estabelecimento&nbsp;</b>
                        <br><br>
                        <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
                            <tr class="d-flex">
                                <th class="col-lg-2 text-right" nowrap>Dia da Semana</th>
                                <th class="col-lg-5 text-center" nowrap>Horário de Funcionamento</th>
                                <th class="col-lg-5 text-center" nowrap>Horário de Intervalo</th>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap>Domingo</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["dom_ih"]).' - '.$metodos -> mascara_hora($r["dom_fh"]).'</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["dom_ii"]).' - '.$metodos -> mascara_hora($r["dom_fi"]).'</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap>Segunda</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["seg_ih"]).' - '.$metodos -> mascara_hora($r["seg_fh"]).'</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["seg_ii"]).' - '.$metodos -> mascara_hora($r["seg_fi"]).'</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap>Terça</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["ter_ih"]).' - '.$metodos -> mascara_hora($r["ter_fh"]).'</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["ter_ii"]).' - '.$metodos -> mascara_hora($r["ter_fi"]).'</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap>Quarta</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["qua_ih"]).' - '.$metodos -> mascara_hora($r["qua_fh"]).'</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["qua_ii"]).' - '.$metodos -> mascara_hora($r["qua_fi"]).'</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap>Quinta</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["qui_ih"]).' - '.$metodos -> mascara_hora($r["qui_fh"]).'</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["qui_ii"]).' - '.$metodos -> mascara_hora($r["qui_fi"]).'</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap>Sexta</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["sex_ih"]).' - '.$metodos -> mascara_hora($r["sex_fh"]).'</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["sex_ii"]).' - '.$metodos -> mascara_hora($r["sex_fi"]).'</td>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap>Sábado</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["sab_ih"]).' - '.$metodos -> mascara_hora($r["sab_fh"]).'</td>
                                <td class="col-lg-5 text-center" nowrap>'.$metodos -> mascara_hora($r["sab_ii"]).' - '.$metodos -> mascara_hora($r["sab_fi"]).'</td>
                            </tr>
                        </table>
                    </div>
                    ';
                }
                $rodape = '
                    <br><b>Status:&nbsp;</b><i>'.$r["status_solicitacao"].'</i><br><br>
                    <input type="submit" name="continuar" value="Continuar Solicitação" class="btn btn-success col-md-6 col-lg-6" id="btn-send"><br><br>
                    <input type="submit" name="cancelar" value="Cancelar Solicitação" class="btn btn-danger col-md-6 col-lg-6" id="btn-send"><br><br>
                    <a href="'.base_url().'Scrt/index" target="_self"><input type="button" name="voltar" value="Voltar" class="btn btn-warning col-md-6 col-lg-6" id="btn-send"></a>
                ';
            }
            $contador++;
        }
        echo $cabecalho.$corpo;
        $condicao = false;
        if ($baixa == 's') {
            $corpo = '
                <br><b>Baixa de Responsabilidade Técnica&nbsp;</b>
                <br><br>
                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
            ';
            $row = $banco -> pdo -> query("SELECT crfmg,data_saida FROM scrt_baixa where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by data_saida,crfmg;");
            foreach ($row as $r) {
                $condicao = true;
                $corpo .= '
                    <tr class="d-flex">
                        <td class="col-lg-6" align="left">Inscrição: '.$r["crfmg"].'</td>
                        <td class="col-lg-6" align="right">Data da Saída: '.$metodos -> mascara_data($r["data_saida"]).'</td>
                    </tr>
                ';
            }
            $corpo .= '</table>';
        }
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        if ($assuncao == 's') {
            $corpo = '
                <br><b>Assun&ccedil;&atilde;o de Responsabilidade Técnica&nbsp;</b>
                <br><br>
                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
            ';
            $row = $banco -> pdo -> query("SELECT sa.crfmg,sa.responsabilidade,sa.declaracao,sa.proprietario,sa.cotas,sa.empregado,sa.remuneracao,sa.vinculo,sa.acordo,sa.jornada12x36,sha.dom_i as dom_ih,sha.dom_f as dom_fh,shi.dom_i as dom_ii,shi.dom_f as dom_fi,shf.dom_i as dom_if,shf.dom_f as dom_ff,sha.seg_i as seg_ih,sha.seg_f as seg_fh,shi.seg_i as seg_ii,shi.seg_f as seg_fi,shf.seg_i as seg_if,shf.seg_f as seg_ff,sha.ter_i as ter_ih,sha.ter_f as ter_fh,shi.ter_i as ter_ii,shi.ter_f as ter_fi,shf.ter_i as ter_if,shf.ter_f as ter_ff,sha.qua_i as qua_ih,sha.qua_f as qua_fh,shi.qua_i as qua_ii,shi.qua_f as qua_fi,shf.qua_i as qua_if,shf.qua_f as qua_ff,sha.qui_i as qui_ih,sha.qui_f as qui_fh,shi.qui_i as qui_ii,shi.qui_f as qui_fi,shf.qui_i as qui_if,shf.qui_f as qui_ff,sha.sex_i as sex_ih,sha.sex_f as sex_fh,shi.sex_i as sex_ii,shi.sex_f as sex_fi,shf.sex_i as sex_if,shf.sex_f as sex_ff,sha.sab_i as sab_ih,sha.sab_f as sab_fh,shi.sab_i as sab_ii,shi.sab_f as sab_fi,shf.sab_i as sab_if,shf.sab_f as sab_ff,sha.esp_i as esp_ih,sha.esp_f as esp_fh,shi.esp_i as esp_ii,shi.esp_f as esp_fi,shf.esp_i as esp_if,shf.esp_f as esp_ff FROM scrt_assuncao as sa inner join scrt_horario as sha on (sa.id_ha=sha.id) inner join scrt_horario as shi on (sa.id_hi1=shi.id) inner join scrt_horario as shf on (sa.id_hi2=shf.id) where sa.id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by sa.crfmg,sa.responsabilidade;");
            foreach ($row as $r) {
                $condicao = true;
                $corpo .= '
                    <tr class="d-flex">
                        <td class="col-lg-6" colspan="2" align="left">Inscrição no CRF/MG: '.$r["crfmg"].'</td>
                        <td class="col-lg-6" colspan="2" align="right">Responsabilidade Técnica: '.$r["responsabilidade"].'</td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-lg-6" colspan="2" align="left">Declaração de Outras Atividades? '.(($r["declaracao"] == 's') ? 'Sim' : 'Não').'</td>
                        <td class="col-lg-6" colspan="2" align="right">Jornada de Trabalho 12x36? '.(($r["jornada12x36"] == 's') ? 'Sim' : 'Não').'</td>
                    </tr>
                ';
                if ($r["proprietario"] == 's') {
                    $corpo .= '
                        <tr class="d-flex">
                            <td class="col-lg-6" colspan="2" align="left">Proprietário/Sócio? Sim</td>
                            <td class="col-lg-6" colspan="2" align="right">Cotas: '.$r["cotas"].'</td>
                        </tr>
                    ';
                }
                if ($r["empregado"] == 's') {
                    $corpo .= '
                        <tr class="d-flex">
                            <td class="col-lg-6" colspan="2" align="left">Empregado/Funcionário? Sim</td>
                            <td class="col-lg-6" colspan="2" align="right">Remuneração: '.$r["remuneracao"].'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-6" colspan="2" align="left">Vínculo Empregatício: '.$r["vinculo"].'</td>
                            <td class="col-lg-6" colspan="2" align="right">Acordo de Horas Extras? '.(($r["acordo"] == 's') ? 'Sim' : 'Não').'</td>
                        </tr>
                    ';
                }
                if ($r["jornada12x36"] == 's') {
                    $corpo .= '
                        <tr class="d-flex">
                            <th class="col-lg-3 text-right" nowrap>Escala</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Assistência</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Intervalo</th>
                            <th class="col-lg-3 text-center" nowrap></th>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>12x36</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["esp_ih"]).' - '.$metodos -> mascara_hora($r["esp_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["esp_ii"]).' - '.$metodos -> mascara_hora($r["esp_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap></td>
                        </tr>
                    ';
                }else{
                    $corpo .= '
                        <tr class="d-flex">
                            <th class="col-lg-3 text-right" nowrap>Dia da Semana</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Assistência</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Intervalo 01</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Intervalo 02</th>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Domingo</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["dom_ih"]).' - '.$metodos -> mascara_hora($r["dom_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["dom_ii"]).' - '.$metodos -> mascara_hora($r["dom_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["dom_if"]).' - '.$metodos -> mascara_hora($r["dom_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Segunda</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["seg_ih"]).' - '.$metodos -> mascara_hora($r["seg_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["seg_ii"]).' - '.$metodos -> mascara_hora($r["seg_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["seg_if"]).' - '.$metodos -> mascara_hora($r["seg_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Terça</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["ter_ih"]).' - '.$metodos -> mascara_hora($r["ter_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["ter_ii"]).' - '.$metodos -> mascara_hora($r["ter_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["ter_if"]).' - '.$metodos -> mascara_hora($r["ter_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Quarta</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qua_ih"]).' - '.$metodos -> mascara_hora($r["qua_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qua_ii"]).' - '.$metodos -> mascara_hora($r["qua_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qua_if"]).' - '.$metodos -> mascara_hora($r["qua_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Quinta</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qui_ih"]).' - '.$metodos -> mascara_hora($r["qui_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qui_ii"]).' - '.$metodos -> mascara_hora($r["qui_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qui_if"]).' - '.$metodos -> mascara_hora($r["qui_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Sexta</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sex_ih"]).' - '.$metodos -> mascara_hora($r["sex_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sex_ii"]).' - '.$metodos -> mascara_hora($r["sex_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sex_if"]).' - '.$metodos -> mascara_hora($r["sex_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Sábado</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sab_ih"]).' - '.$metodos -> mascara_hora($r["sab_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sab_ii"]).' - '.$metodos -> mascara_hora($r["sab_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sab_if"]).' - '.$metodos -> mascara_hora($r["sab_ff"]).'</td>
                        </tr>
                    ';
                }
            }
            $corpo .= '</table>';
        }
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        if ($assistencia == 's') {
            $corpo = '
                <br><b>Atualização do Horário de Assistência&nbsp;</b>
                <br><br>
                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
            ';
            $row = $banco -> pdo -> query("SELECT sa.crfmg,sa.acordo,sa.declaracao,sa.vinculo,sa.jornada12x36,sha.dom_i as dom_ih,sha.dom_f as dom_fh,shi.dom_i as dom_ii,shi.dom_f as dom_fi,shf.dom_i as dom_if,shf.dom_f as dom_ff,sha.seg_i as seg_ih,sha.seg_f as seg_fh,shi.seg_i as seg_ii,shi.seg_f as seg_fi,shf.seg_i as seg_if,shf.seg_f as seg_ff,sha.ter_i as ter_ih,sha.ter_f as ter_fh,shi.ter_i as ter_ii,shi.ter_f as ter_fi,shf.ter_i as ter_if,shf.ter_f as ter_ff,sha.qua_i as qua_ih,sha.qua_f as qua_fh,shi.qua_i as qua_ii,shi.qua_f as qua_fi,shf.qua_i as qua_if,shf.qua_f as qua_ff,sha.qui_i as qui_ih,sha.qui_f as qui_fh,shi.qui_i as qui_ii,shi.qui_f as qui_fi,shf.qui_i as qui_if,shf.qui_f as qui_ff,sha.sex_i as sex_ih,sha.sex_f as sex_fh,shi.sex_i as sex_ii,shi.sex_f as sex_fi,shf.sex_i as sex_if,shf.sex_f as sex_ff,sha.sab_i as sab_ih,sha.sab_f as sab_fh,shi.sab_i as sab_ii,shi.sab_f as sab_fi,shf.sab_i as sab_if,shf.sab_f as sab_ff,sha.esp_i as esp_ih,sha.esp_f as esp_fh,shi.esp_i as esp_ii,shi.esp_f as esp_fi,shf.esp_i as esp_if,shf.esp_f as esp_ff FROM scrt_assistencia as sa inner join scrt_horario as sha on (sa.id_ha=sha.id) inner join scrt_horario as shi on (sa.id_hi1=shi.id) inner join scrt_horario as shf on (sa.id_hi2=shf.id) where sa.id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by sa.crfmg;");
            foreach ($row as $r) {
                $condicao = true;
                $corpo .= '
                    <tr class="d-flex">
                        <td class="col-lg-12" colspan="4" align="left">Inscrição no CRF/MG: '.$r["crfmg"].'</td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-lg-6" colspan="2" align="left">Acordo de Horas Extras? '.(($r["acordo"] == 's') ? 'Sim' : 'Não').'</td>
                        <td class="col-lg-6" colspan="2" align="right">Declaração de Outras Atividades? '.(($r["declaracao"] == 's') ? 'Sim' : 'Não').'</td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-lg-6" colspan="2" align="left">Vínculo Empregatício: '.$r["vinculo"].'</td>
                        <td class="col-lg-6" colspan="2" align="right">Jornada de Trabalho 12x36? '.(($r["jornada12x36"] == 's') ? 'Sim' : 'Não').'</td>
                    </tr>
                ';
                if ($r["jornada12x36"] == 's') {
                    $corpo .= '
                        <tr class="d-flex">
                            <th class="col-lg-3 text-right" nowrap>Escala</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Assistência</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Intervalo</th>
                            <th class="col-lg-3 text-center" nowrap></th>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>12x36</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["esp_ih"]).' - '.$metodos -> mascara_hora($r["esp_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["esp_ii"]).' - '.$metodos -> mascara_hora($r["esp_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap></td>
                        </tr>
                    ';
                }else{
                    $corpo .= '
                        <tr class="d-flex">
                            <th class="col-lg-3 text-right" nowrap>Dia da Semana</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Assistência</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Intervalo 01</th>
                            <th class="col-lg-3 text-center" nowrap>Horário de Intervalo 02</th>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Domingo</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["dom_ih"]).' - '.$metodos -> mascara_hora($r["dom_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["dom_ii"]).' - '.$metodos -> mascara_hora($r["dom_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["dom_if"]).' - '.$metodos -> mascara_hora($r["dom_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Segunda</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["seg_ih"]).' - '.$metodos -> mascara_hora($r["seg_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["seg_ii"]).' - '.$metodos -> mascara_hora($r["seg_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["seg_if"]).' - '.$metodos -> mascara_hora($r["seg_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Terça</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["ter_ih"]).' - '.$metodos -> mascara_hora($r["ter_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["ter_ii"]).' - '.$metodos -> mascara_hora($r["ter_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["ter_if"]).' - '.$metodos -> mascara_hora($r["ter_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Quarta</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qua_ih"]).' - '.$metodos -> mascara_hora($r["qua_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qua_ii"]).' - '.$metodos -> mascara_hora($r["qua_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qua_if"]).' - '.$metodos -> mascara_hora($r["qua_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Quinta</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qui_ih"]).' - '.$metodos -> mascara_hora($r["qui_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qui_ii"]).' - '.$metodos -> mascara_hora($r["qui_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["qui_if"]).' - '.$metodos -> mascara_hora($r["qui_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Sexta</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sex_ih"]).' - '.$metodos -> mascara_hora($r["sex_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sex_ii"]).' - '.$metodos -> mascara_hora($r["sex_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sex_if"]).' - '.$metodos -> mascara_hora($r["sex_ff"]).'</td>
                        </tr>
                        <tr class="d-flex">
                            <td class="col-lg-3 text-right" nowrap>Sábado</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sab_ih"]).' - '.$metodos -> mascara_hora($r["sab_fh"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sab_ii"]).' - '.$metodos -> mascara_hora($r["sab_fi"]).'</td>
                            <td class="col-lg-3 text-center" nowrap>'.$metodos -> mascara_hora($r["sab_if"]).' - '.$metodos -> mascara_hora($r["sab_ff"]).'</td>
                        </tr>
                    ';
                }
            }
            $corpo .= '</table>';
        }
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        if ($renovacao == 's') {
            $corpo = '
                <br><b>Atualização  de Documentação&nbsp;</b>
                <br><br>
                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
            ';
            $row = $banco -> pdo -> query("SELECT crfmg,acordo,declaracao,vinculo FROM scrt_renovacao where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by crfmg;");
            foreach ($row as $r) {
                $condicao = true;
                $corpo .= '
                    <tr class="d-flex">
                        <td class="col-lg-6" colspan="2" align="left">Inscrição no CRF/MG: '.$r["crfmg"].'</td>
                        <td class="col-lg-6" colspan="2" align="right">Acordo de Horas Extras? '.(($r["acordo"] == 's') ? 'Sim' : 'Não').'</td>
                    </tr>
                    <tr class="d-flex">
                        <td class="col-lg-6" colspan="2" align="left">Declaração de Outras Atividades? '.(($r["declaracao"] == 's') ? 'Sim' : 'Não').'</td>
                        <td class="col-lg-6" colspan="2" align="right">Vínculo Empregatício: '.$r["vinculo"].'</td>
                    </tr>
                ';
            }
            $corpo .= '</table>';
        }
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        $corpo = '
            <br><b>Termo de Compromisso Emitido&nbsp;</b>
            <br><br>
            <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
        ';
        $row = $banco -> pdo -> query("SELECT crfmg,protocolo,data_solicitacao,hora_solicitacao,(select count(*) from scrt_historico where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." and id_status=66) as total FROM scrt where id=".$this -> session -> userdata['SOLICITACAO'].";");
        foreach ($row as $r) {
            if (!empty($r["total"])) {
                $condicao = true;
                $corpo .= '
                    <tr class="d-flex">
                        <td class="col-lg-2" align="left"><b>Registro</b><br><br>'.$r["crfmg"].'</td>
                        <td class="col-lg-4" align="center"><b>Protocolo</b><br><br>'.$r["protocolo"].'</td>
                        <td class="col-lg-2" align="center"><b>Data</b><br><br>'.$metodos -> mascara_data($r["data_solicitacao"]).'</td>
                        <td class="col-lg-2" align="center"><b>Hora</b><br><br>'.$metodos -> mascara_hora($r["hora_solicitacao"]).'</td>
                        <td class="col-lg-2" align="right"><a href="../scrt_termo_compromisso.php?solicitacao='.base64_encode($this -> session -> userdata['SOLICITACAO']).'&protocolo='.base64_encode($this -> session -> userdata['PROTOCOLO']).'" target="_blank"><input type="button" name="emitir" value="Emitir Termo" class="btn btn-info" id="btn-send"></a></td>
                    </tr>
                ';
            }
        }
        $corpo .= '</table>';
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        $corpo = '
            <br><b>Documentação do Estabelecimento Anexada&nbsp;</b>
            <br><br>
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
            $corpo .= '
                <tr class="d-flex">
                    <td class="col-lg-10" align="left">'.$r["nome"].'</td>
                    <td class="col-lg-2" align="right" nowrap>'.$link.'</td>
                </tr>
            ';
        }
        $corpo .= '</table>';
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        $corpo = '
            <br><b>Documentação do Profissional Farmacêutico Anexada - Baixa de Responsabilidade T&eacute;cnica&nbsp;</b>
            <br><br>
            <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
        ';
        $row = $banco -> pdo -> query("select sdpf.id,sta.nome,s.crfmg from scrt_documentacao_pf as sdpf inner join scrt_tipo_anexo as sta on (sdpf.id_tipo_anexo=sta.id) inner join scrt_baixa as s on (sdpf.id_baixa=s.id) where sdpf.ativo='s' and s.id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by s.crfmg,sta.nome;");
        foreach ($row as $r) {
            $condicao = true;
            $arquivo1 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.png';
            $arquivo2 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.pdf';
            $link = null;
            if (file_exists($arquivo1)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.png'.'" target="_blank">visualizar</a>';
            }
            if (file_exists($arquivo2)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.pdf'.'" target="_blank">visualizar</a>';
            }
            $corpo .= '
                <tr class="d-flex">
                    <td class="col-lg-8" align="left">'.$r["nome"].'</td>
                    <td class="col-lg-2" align="left">'.$r["crfmg"].'</td>
                    <td class="col-lg-2" align="right" nowrap>'.$link.'</td>
                </tr>
            ';
        }
        $corpo .= '</table>';
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        $corpo = '
            <br><b>Documentação do Profissional Farmacêutico Anexada - Assun&ccedil;&atilde;o de Responsabilidade T&eacute;cnica&nbsp;</b>
            <br><br>
            <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
        ';
        $row = $banco -> pdo -> query("select sdpf.id,sta.nome,s.crfmg from scrt_documentacao_pf as sdpf inner join scrt_tipo_anexo as sta on (sdpf.id_tipo_anexo=sta.id) inner join scrt_assuncao as s on (sdpf.id_assuncao=s.id) where sdpf.ativo='s' and s.id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by s.crfmg,sta.nome;");
        foreach ($row as $r) {
            $condicao = true;
            $arquivo1 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.png';
            $arquivo2 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.pdf';
            $link = null;
            if (file_exists($arquivo1)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.png'.'" target="_blank">visualizar</a>';
            }
            if (file_exists($arquivo2)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.pdf'.'" target="_blank">visualizar</a>';
            }
            $corpo .= '
                <tr class="d-flex">
                    <td class="col-lg-8" align="left">'.$r["nome"].'</td>
                    <td class="col-lg-2" align="left">'.$r["crfmg"].'</td>
                    <td class="col-lg-2" align="right" nowrap>'.$link.'</td>
                </tr>
            ';
        }
        $corpo .= '</table>';
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        $corpo = '
            <br><b>Documentação do Profissional Farmacêutico Anexada - Atualiza&ccedil;&atilde;o do Hor&aacute;rio de Assist&ecirc;ncia&nbsp;</b>
            <br><br>
            <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
        ';
        $row = $banco -> pdo -> query("select sdpf.id,sta.nome,s.crfmg from scrt_documentacao_pf as sdpf inner join scrt_tipo_anexo as sta on (sdpf.id_tipo_anexo=sta.id) inner join scrt_assistencia as s on (sdpf.id_assistencia=s.id) where sdpf.ativo='s' and s.id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by s.crfmg,sta.nome;");
        foreach ($row as $r) {
            $condicao = true;
            $arquivo1 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.png';
            $arquivo2 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.pdf';
            $link = null;
            if (file_exists($arquivo1)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.png'.'" target="_blank">visualizar</a>';
            }
            if (file_exists($arquivo2)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.pdf'.'" target="_blank">visualizar</a>';
            }
            $corpo .= '
                <tr class="d-flex">
                    <td class="col-lg-8" align="left">'.$r["nome"].'</td>
                    <td class="col-lg-2" align="left">'.$r["crfmg"].'</td>
                    <td class="col-lg-2" align="right" nowrap>'.$link.'</td>
                </tr>
            ';
        }
        $corpo .= '</table>';
        echo ($condicao == true) ? $corpo : '';
        $condicao = false;
        $corpo = '
            <br><b>Documentação do Profissional Farmacêutico Anexada - Atualiza&ccedil;&atilde;o de Documenta&ccedil;&atilde;o&nbsp;</b>
            <br><br>
            <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
        ';
        $row = $banco -> pdo -> query("select sdpf.id,sta.nome,s.crfmg from scrt_documentacao_pf as sdpf inner join scrt_tipo_anexo as sta on (sdpf.id_tipo_anexo=sta.id) inner join scrt_renovacao as s on (sdpf.id_renovacao=s.id) where sdpf.ativo='s' and s.id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by s.crfmg,sta.nome;");
        foreach ($row as $r) {
            $condicao = true;
            $arquivo1 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.png';
            $arquivo2 = 'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.pdf';
            $link = null;
            if (file_exists($arquivo1)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.png'.'" target="_blank">visualizar</a>';
            }
            if (file_exists($arquivo2)) {
                $link = '<a href="'.base_url().'anexo/'.$this -> session -> userdata['PROTOCOLO'].'_'.$this -> session -> userdata['SOLICITACAO'].'/PF_'.$r["id"].'.pdf'.'" target="_blank">visualizar</a>';
            }
            $corpo .= '
                <tr class="d-flex">
                    <td class="col-lg-8" align="left">'.$r["nome"].'</td>
                    <td class="col-lg-2" align="left">'.$r["crfmg"].'</td>
                    <td class="col-lg-2" align="right" nowrap>'.$link.'</td>
                </tr>
            ';
        }
        $corpo .= '</table>';
        echo ($condicao == true) ? $corpo : '';


        echo $rodape;
    }else{
        redirect(base_url().'scrt/index');
    }
?>
                    </form>
                    </div>
                </div>
            </div>
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