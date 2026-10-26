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
        $row = $banco -> pdo -> query("SELECT id,id_ha,id_hi1,id_hi2,crfmg,responsabilidade,jornada12x36 FROM scrt_assuncao where id_solicitacao=".$this -> session -> userdata['SOLICITACAO']." order by crfmg,responsabilidade;");
        foreach ($row as $r) {
            $condicao = true;
            $responsaveis .= '
                <form name="frm03_'.$r["id"].'" action="'.base_url().'Scrt/frm03" method="POST" onSubmit="javascript: return f1();">
                <tr class="d-flex">
                    <td class="col-lg-6" align="left">'.$r["responsabilidade"].'</td>
                    <td class="col-lg-2" align="center">'.$r["crfmg"].'</td>
                    <td class="col-lg-2" align="center">'.(($r["jornada12x36"] == 's') ? 'jornada 12x36' : 'jornada normal').'</td>
                    <td class="col-lg-2" align="right">
                        <input type="hidden" name="id_responsavel" value="'.$r["id"].'">
                        <input type="hidden" name="id_ha" value="'.$r["id_ha"].'">
                        <input type="hidden" name="id_hi1" value="'.$r["id_hi1"].'">
                        <input type="hidden" name="id_hi2" value="'.$r["id_hi2"].'">
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
                <div class="col-md-12"><h5><u>Assunção Cadastrada</u></h5><br><br></div>
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
                        ***Quando todas as Assunções estiverem cadastradas clique em <b>Concluir Cadastro</b>!
                        <br><br>
                        ***A <b>Assunção de Responsabilidade Técnica</b> será concluída e não poderá ser alterada!
                        <br><br>
                        ***Caso não necessite realizar a Assunção de Responsabilidade Técnica clique em <b>Concluir Cadastro</b>!
                    </i></div>
                </div>
            </div>
            <form name="frm03_" action="<?= base_url(); ?>Scrt/frm03" method="POST" onSubmit="javascript: return f1();">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <div class="form-group"><input type="submit" name="finalizar" value="Concluir Cadastro" class="btn btn-success col-md-6 col-lg-6" id="btn-send"></div>
                </div>
            </div>
            </form>
            <hr>
<?php
        $hora = '<option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option>';
        $minuto = '<option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option>';
?>
            <div class="row">
                <div class="col-md-12"><h5><u>Assunção de Responsabilidade Técnica</u></h5><br><br></div>
            </div>
<!--msg de retorno-->
<?php if (!empty($this -> session -> flashdata('tipo'))) { ?>
            <div class="alert alert-<?= $this -> session -> flashdata('tipo'); ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span style="font-size: 16px;"><?= $this -> session -> flashdata('msg'); ?></span>
            </div>
<?php } ?>
<!--fim msg de retorno-->
            <form name="frm04" action="<?= base_url(); ?>Scrt/frm03" method="POST" id="form-send">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label for="crfmg">Número de Inscrição no CRF/MG:</label>
                        <input type="text" inputmode="numeric" class="form-control <?=(form_error('crfmg')) ? 'is-invalid' : ''; ?>" id="crfmg" name="crfmg" placeholder="Informe o Número de Inscrição do Resonsável Técnico" value="<?=set_value('crfmg');?>">
                        <?=form_error('crfmg','<small class="form-text text-muted label-error">', '</small>'); ?>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <b>Tipo de Responsabilidade (Res. 556/CFF):</b><br>
                        <?=form_error('responsabilidade','<p class="mt-2"><small style="color:red">', '</small></p>'); ?>
                        <p class='mt-3' align="justify">
                            <input type="radio" class="ml-5" name="responsabilidade" id="fdt" value="Farmacêutico Diretor Técnico" <?=set_radio('responsabilidade', 'Farmacêutico Diretor Técnico');?>>
                            &nbsp; <label style="font-weight:bold" for="fdt">Farmacêutico Diretor Técnico</label><br><i>Farmacêutico titular que assume a direção técnica ou responsabilidade técnica da empresa e/ou estabelecimento perante o respectivo Conselho Regional de Farmácia (CRF) e os órgãos de vigilância sanitária, nos termos da legislação vigente, ficando sob sua responsabilidade a realização, supervisão e coordenação de todos os serviços técnico-científicos da empresa e/ou estabelecimento, respeitado, ainda, o preconizado pela legislação laboral ou acordo trabalhista.</i></p>
                        <p class='mt-3' align="justify">
                            <input type="radio" class="ml-5" name="responsabilidade" id="fat" value="Farmacêutico Assistente Técnico" <?=set_radio('responsabilidade', 'Farmacêutico Assistente Técnico');?>>
                            &nbsp; <label style="font-weight:bold" for="fat">Farmacêutico Assistente Técnico</label><br><i>Farmacêutico subordinado hierarquicamente ao diretor técnico ou responsável técnico que, requerendo a assunção de farmacêutico assistente técnico de uma empresa e/ou de um estabelecimento, por meio dos formulários próprios do CRF, seja designado para complementar carga horária ou auxiliar o titular na prestação da assistência farmacêutica.</i></p>
                        <p class='mt-3' align="justify">
                            <input type="radio" class="ml-5" name="responsabilidade" id="fs" value="Farmacêutico Substituto" <?=set_radio('responsabilidade', 'Farmacêutico Substituto');?>>
                            &nbsp; <label style="font-weight:bold" for="fs">Farmacêutico Substituto</label><br><i>Farmacêutico designado perante o CRF para prestar assistência e responder tecnicamente nos casos de impedimentos ou ausências do farmacêutico diretor técnico ou farmacêutico responsável técnico, ou ainda do farmacêutico assistente técnico da empresa e/ou estabelecimento, respeitado o preconizado pela Consolidação das Leis do Trabalho (CLT) ou acordo trabalhista.</i></p>
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
                        <b>Relação Trabalhista:</b><br>
                        <?=form_error('relacao_trabalhista','<p class="mt-2"><small style="color:red">', '</small></p>'); ?>
                        <p class='mt-3' align="justify">
                        <input type="radio" class='toggleRelacaoTrabalhista ml-5' name="relacao_trabalhista" value="proprietario" id="relacao_trabalhista_p" <?=set_radio('relacao_trabalhista', 'proprietario');?>>
                        &nbsp;<label for="relacao_trabalhista_p"> Proprietário/Sócio</label>
                        </p>
                        <p class='mt-3' align="justify">
                        <input type="radio" class='toggleRelacaoTrabalhista ml-5' name="relacao_trabalhista" value="empregado" id="relacao_trabalhista_e" <?=set_radio('relacao_trabalhista', 'empregado');?>>
                        &nbsp;<label for="relacao_trabalhista_e"> Empregado/Funcionário</label>
                        </p>
                        <hr>
                    </div>
                </div>
            </div>

            <div id="box_proprietario" style="display: none;">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="cotas">Digite a porcentagem (%) de cotas: </label>
                            <input type="text" inputmode="numeric" class="form-control mask_percent <?=(form_error('cotas')) ? 'is-invalid' : ''; ?>" id="cotas" name="cotas" placeholder="0.00 %" value="<?=set_value('cotas');?>">
                            <?=form_error('cotas','<small class="form-text text-muted label-error">', '</small>'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="box_empregado" style="display: none;">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="remuneracao">Remuneração:</label>
                            <input type="text" inputmode="numeric" class="form-control mask_money <?=(form_error('remuneracao')) ? 'is-invalid' : ''; ?>" id="remuneracao" name="remuneracao" placeholder="R$ 0,00" value="<?=set_value('remuneracao');?>">
                            <?=form_error('remuneracao','<small class="form-text text-muted label-error">', '</small>'); ?>
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
                            <hr>
                        </div>
                    </div>
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
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <b>A Jornada de Trabalho é 12x36?</b><br>
                            <?=form_error('jornada12x36','<p class="mt-2"><small style="color:red">', '</small></p>'); ?>
                            <p class='mt-3' align="justify">
                                <input type="radio" class='ml-5' name="jornada12x36" value="s" id="jornada12x36_s" <?=set_radio('jornada12x36', 's');?>>
                                &nbsp;<label for="jornada12x36_s">Sim</label></p>
                            <p class='mt-3' align="justify">
                                <input type="radio" class='ml-5' name="jornada12x36" value="n" id="jornada12x36_n" <?=set_radio('jornada12x36', 'n');?>>
                                &nbsp;<label for="jornada12x36_n">Não</label></p>
                            <hr>
                        </div>
                    </div>
                </div>


                <div id="box_assistencia_normal" style="display:none">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive">
                                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
                                    <tr class="d-flex">
                                        <th class="col-lg-2 text-center" nowrap>Dia da <br>Semana</th>
                                        <th class="col-lg-4 text-center" nowrap>Horário de <br>Assistência</th>
                                        <th class="col-lg-3 text-center" nowrap>Horário de <br>Intervalo (1)</th>
                                        <th class="col-lg-3 text-center" nowrap>Horário de <br>Intervalo (2)</th>
                                    </tr>

                                    <tr class="d-flex">
                                        <td class="col-lg-2 text-center" nowrap> Segunda-Feira</td>

                                        <td class="col-lg-4 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_seg_i')) ? 'is-invalid' : ''; ?>" id="ha_seg_i" name="ha_seg_i" placeholder="hh:mm" value="<?=set_value('ha_seg_i');?>">
                                            <?=form_error('ha_seg_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_seg_f')) ? 'is-invalid' : ''; ?>" id="ha_seg_f" name="ha_seg_f" placeholder="hh:mm" value="<?=set_value('ha_seg_f');?>">
                                            <?=form_error('ha_seg_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="ha_seg" destino="ha_ter"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_seg_i')) ? 'is-invalid' : ''; ?>" id="hi1_seg_i" name="hi1_seg_i" placeholder="hh:mm" value="<?=set_value('hi1_seg_i');?>">
                                            <?=form_error('hi1_seg_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_seg_f')) ? 'is-invalid' : ''; ?>" id="hi1_seg_f" name="hi1_seg_f" placeholder="hh:mm" value="<?=set_value('hi1_seg_f');?>">
                                            <?=form_error('hi1_seg_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi1_seg" destino="hi1_ter"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_seg_i')) ? 'is-invalid' : ''; ?>" id="hi2_seg_i" name="hi2_seg_i" placeholder="hh:mm" value="<?=set_value('hi2_seg_i');?>">
                                            <?=form_error('hi2_seg_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_seg_f')) ? 'is-invalid' : ''; ?>" id="hi2_seg_f" name="hi2_seg_f" placeholder="hh:mm" value="<?=set_value('hi2_seg_f');?>">
                                            <?=form_error('hi2_seg_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi2_seg" destino="hi2_ter"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                    </tr>

                                    <tr class="d-flex">
                                        <td class="col-lg-2 text-center" nowrap> Terça-Feira</td>

                                        <td class="col-lg-4 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_ter_i')) ? 'is-invalid' : ''; ?>" id="ha_ter_i" name="ha_ter_i" placeholder="hh:mm" value="<?=set_value('ha_ter_i');?>">
                                            <?=form_error('ha_ter_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_ter_f')) ? 'is-invalid' : ''; ?>" id="ha_ter_f" name="ha_ter_f" placeholder="hh:mm" value="<?=set_value('ha_ter_f');?>">
                                            <?=form_error('ha_ter_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="ha_ter" destino="ha_qua"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_ter_i')) ? 'is-invalid' : ''; ?>" id="hi1_ter_i" name="hi1_ter_i" placeholder="hh:mm" value="<?=set_value('hi1_ter_i');?>">
                                            <?=form_error('hi1_ter_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_ter_f')) ? 'is-invalid' : ''; ?>" id="hi1_ter_f" name="hi1_ter_f" placeholder="hh:mm" value="<?=set_value('hi1_ter_f');?>">
                                            <?=form_error('hi1_ter_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi1_ter" destino="hi1_qua"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_ter_i')) ? 'is-invalid' : ''; ?>" id="hi2_ter_i" name="hi2_ter_i" placeholder="hh:mm" value="<?=set_value('hi2_ter_i');?>">
                                            <?=form_error('hi2_ter_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_ter_f')) ? 'is-invalid' : ''; ?>" id="hi2_ter_f" name="hi2_ter_f" placeholder="hh:mm" value="<?=set_value('hi2_ter_f');?>">
                                            <?=form_error('hi2_ter_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi2_ter" destino="hi2_qua"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                    </tr>

                                    <tr class="d-flex">
                                        <td class="col-lg-2 text-center" nowrap> Quarta-Feira</td>

                                        <td class="col-lg-4 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_qua_i')) ? 'is-invalid' : ''; ?>" id="ha_qua_i" name="ha_qua_i" placeholder="hh:mm" value="<?=set_value('ha_qua_i');?>">
                                            <?=form_error('ha_qua_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_qua_f')) ? 'is-invalid' : ''; ?>" id="ha_qua_f" name="ha_qua_f" placeholder="hh:mm" value="<?=set_value('ha_qua_f');?>">
                                            <?=form_error('ha_qua_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="ha_qua" destino="ha_qui"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_qua_i')) ? 'is-invalid' : ''; ?>" id="hi1_qua_i" name="hi1_qua_i" placeholder="hh:mm" value="<?=set_value('hi1_qua_i');?>">
                                            <?=form_error('hi1_qua_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_qua_f')) ? 'is-invalid' : ''; ?>" id="hi1_qua_f" name="hi1_qua_f" placeholder="hh:mm" value="<?=set_value('hi1_qua_f');?>">
                                            <?=form_error('hi1_qua_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi1_qua" destino="hi1_qui"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_qua_i')) ? 'is-invalid' : ''; ?>" id="hi2_qua_i" name="hi2_qua_i" placeholder="hh:mm" value="<?=set_value('hi2_qua_i');?>">
                                            <?=form_error('hi2_qua_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_qua_f')) ? 'is-invalid' : ''; ?>" id="hi2_qua_f" name="hi2_qua_f" placeholder="hh:mm" value="<?=set_value('hi2_qua_f');?>">
                                            <?=form_error('hi2_qua_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi2_qua" destino="hi2_qui"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                    </tr>

                                    <tr class="d-flex">
                                        <td class="col-lg-2 text-center" nowrap> Quinta-Feira</td>

                                        <td class="col-lg-4 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_qui_i')) ? 'is-invalid' : ''; ?>" id="ha_qui_i" name="ha_qui_i" placeholder="hh:mm" value="<?=set_value('ha_qui_i');?>">
                                            <?=form_error('ha_qui_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_qui_f')) ? 'is-invalid' : ''; ?>" id="ha_qui_f" name="ha_qui_f" placeholder="hh:mm" value="<?=set_value('ha_qui_f');?>">
                                            <?=form_error('ha_qui_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="ha_qui" destino="ha_sex"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_qui_i')) ? 'is-invalid' : ''; ?>" id="hi1_qui_i" name="hi1_qui_i" placeholder="hh:mm" value="<?=set_value('hi1_qui_i');?>">
                                            <?=form_error('hi1_qui_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_qui_f')) ? 'is-invalid' : ''; ?>" id="hi1_qui_f" name="hi1_qui_f" placeholder="hh:mm" value="<?=set_value('hi1_qui_f');?>">
                                            <?=form_error('hi1_qui_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi1_qui" destino="hi1_sex"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_qui_i')) ? 'is-invalid' : ''; ?>" id="hi2_qui_i" name="hi2_qui_i" placeholder="hh:mm" value="<?=set_value('hi2_qui_i');?>">
                                            <?=form_error('hi2_qui_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_qui_f')) ? 'is-invalid' : ''; ?>" id="hi2_qui_f" name="hi2_qui_f" placeholder="hh:mm" value="<?=set_value('hi2_qui_f');?>">
                                            <?=form_error('hi2_qui_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi2_qui" destino="hi2_sex"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                    </tr>

                                    <tr class="d-flex">
                                        <td class="col-lg-2 text-center" nowrap> Sexta-Feira</td>

                                        <td class="col-lg-4 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_sex_i')) ? 'is-invalid' : ''; ?>" id="ha_sex_i" name="ha_sex_i" placeholder="hh:mm" value="<?=set_value('ha_sex_i');?>">
                                            <?=form_error('ha_sex_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_sex_f')) ? 'is-invalid' : ''; ?>" id="ha_sex_f" name="ha_sex_f" placeholder="hh:mm" value="<?=set_value('ha_sex_f');?>">
                                            <?=form_error('ha_sex_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="ha_sex" destino="ha_sab"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_sex_i')) ? 'is-invalid' : ''; ?>" id="hi1_sex_i" name="hi1_sex_i" placeholder="hh:mm" value="<?=set_value('hi1_sex_i');?>">
                                            <?=form_error('hi1_sex_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_sex_f')) ? 'is-invalid' : ''; ?>" id="hi1_sex_f" name="hi1_sex_f" placeholder="hh:mm" value="<?=set_value('hi1_sex_f');?>">
                                            <?=form_error('hi1_sex_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi1_sex" destino="hi1_sab"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_sex_i')) ? 'is-invalid' : ''; ?>" id="hi2_sex_i" name="hi2_sex_i" placeholder="hh:mm" value="<?=set_value('hi2_sex_i');?>">
                                            <?=form_error('hi2_sex_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_sex_f')) ? 'is-invalid' : ''; ?>" id="hi2_sex_f" name="hi2_sex_f" placeholder="hh:mm" value="<?=set_value('hi2_sex_f');?>">
                                            <?=form_error('hi2_sex_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi2_sex" destino="hi2_sab"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                    </tr>

                                    <tr class="d-flex">
                                        <td class="col-lg-2 text-center" nowrap> Sábado</td>

                                        <td class="col-lg-4 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_sab_i')) ? 'is-invalid' : ''; ?>" id="ha_sab_i" name="ha_sab_i" placeholder="hh:mm" value="<?=set_value('ha_sab_i');?>">
                                            <?=form_error('ha_sab_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('ha_sab_f')) ? 'is-invalid' : ''; ?>" id="ha_sab_f" name="ha_sab_f" placeholder="hh:mm" value="<?=set_value('ha_sab_f');?>">
                                            <?=form_error('ha_sab_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="ha_sab" destino="ha_dom"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_sab_i')) ? 'is-invalid' : ''; ?>" id="hi1_sab_i" name="hi1_sab_i" placeholder="hh:mm" value="<?=set_value('hi1_sab_i');?>">
                                            <?=form_error('hi1_sab_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi1_sab_f')) ? 'is-invalid' : ''; ?>" id="hi1_sab_f" name="hi1_sab_f" placeholder="hh:mm" value="<?=set_value('hi1_sab_f');?>">
                                            <?=form_error('hi1_sab_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi1_sab" destino="hi1_dom"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_sab_i')) ? 'is-invalid' : ''; ?>" id="hi2_sab_i" name="hi2_sab_i" placeholder="hh:mm" value="<?=set_value('hi2_sab_i');?>">
                                            <?=form_error('hi2_sab_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi2_sab_f')) ? 'is-invalid' : ''; ?>" id="hi2_sab_f" name="hi2_sab_f" placeholder="hh:mm" value="<?=set_value('hi2_sab_f');?>">
                                            <?=form_error('hi2_sab_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi2_sab" destino="hi2_dom"><i class="fa fa-level-down-alt"></i></a></div>
                                        </td>

                                    </tr>

                                    <tr class="d-flex">
                                        <td class="col-lg-2 text-center" nowrap>Domingo</td>

                                        <td class="col-lg-4 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('ha_dom_i')) ? 'is-invalid' : ''; ?>" id="ha_dom_i" name="ha_dom_i" placeholder="hh:mm" value="<?=set_value('ha_dom_i');?>">
                                            <?=form_error('ha_dom_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('ha_dom_f')) ? 'is-invalid' : ''; ?>" id="ha_dom_f" name="ha_dom_f" placeholder="hh:mm" value="<?=set_value('ha_dom_f');?>">
                                            <?=form_error('ha_dom_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('hi1_dom_i')) ? 'is-invalid' : ''; ?>" id="hi1_dom_i" name="hi1_dom_i" placeholder="hh:mm" value="<?=set_value('hi1_dom_i');?>">
                                            <?=form_error('hi1_dom_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('hi1_dom_f')) ? 'is-invalid' : ''; ?>" id="hi1_dom_f" name="hi1_dom_f" placeholder="hh:mm" value="<?=set_value('hi1_dom_f');?>">
                                            <?=form_error('hi1_dom_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('hi1_dom_i')) ? 'is-invalid' : ''; ?>" id="hi1_dom_i" name="hi1_dom_i" placeholder="hh:mm" value="<?=set_value('hi1_dom_i');?>">
                                            <?=form_error('hi1_dom_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('hi1_dom_f')) ? 'is-invalid' : ''; ?>" id="hi1_dom_f" name="hi1_dom_f" placeholder="hh:mm" value="<?=set_value('hi1_dom_f');?>">
                                            <?=form_error('hi1_dom_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                        </td>

                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="box_assistencia_12x36" style="display:none">

                  <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive">
                                <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
                                    <tr class="d-flex">
                                        <th class="col-lg-2 text-center" nowrap>Jornada 12x36</th>
                                        <th class="col-lg-4 text-center" nowrap>Horário de <br>Assistência</th>
                                        <th class="col-lg-3 text-center" nowrap>Horário de <br>Intervalo</th>
                                        <th class="col-lg-3 text-center" nowrap></th>
                                    </tr>

                                    <tr class="d-flex">
                                        <td class="col-lg-2 text-center" nowrap> 12x36</td>

                                        <td class="col-lg-4 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hesp_i')) ? 'is-invalid' : ''; ?>" id="hesp_i" name="hesp_i" placeholder="hh:mm" value="<?=set_value('hesp_i');?>">
                                            <?=form_error('hesp_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hesp_f')) ? 'is-invalid' : ''; ?>" id="hesp_f" name="hesp_f" placeholder="hh:mm" value="<?=set_value('hesp_f');?>">
                                            <?=form_error('hesp_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hiesp_1_i')) ? 'is-invalid' : ''; ?>" id="hiesp_1_i" name="hiesp_1_i" placeholder="hh:mm" value="<?=set_value('hiesp_1_i');?>">
                                            <?=form_error('hiesp_1_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                            <div><span>&nbsp; - &nbsp;</span></div>
                                            <div>
                                            <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hiesp_1_f')) ? 'is-invalid' : ''; ?>" id="hiesp_1_f" name="hiesp_1_f" placeholder="hh:mm" value="<?=set_value('hiesp_1_f');?>">
                                            <?=form_error('hiesp_1_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                            </div>
                                        </td>

                                        <td style="border-left:1px solid #000;" class="col-lg-3 text-center d-flex justify-content-center align-items-center " nowrap>
                                        </td>
                                    </tr>
                                </table>
                            </div>
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

        $('.mask_hour').inputmask({alias:'datetime', placeholder: 'hh:mm', inputFormat: "HH:MM", max: 24});
        $(".mask_money").inputmask( 'currency',{"autoUnmask": true,
            radixPoint:",",
            groupSeparator: ".",
            allowMinus: false,
            prefix: 'R$ ',
            digits: 2,
            digitsOptional: false,
            rightAlign: false,
            unmaskAsNumber: true
        });

        $(".mask_percent").inputmask({
                alias:"numeric",
                groupSeparator: ".",
                integerDigits:3,
                digits: 2,
                max:100,
                allowMinus:false,
                suffix: ' %',
                digitsOptional: false,
                rightAlign: false,
        });

        $("#form-send").submit(function(){
            $("#btn-send").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
        });

        $("input[name='relacao_trabalhista']").click(function(){
            toggleRelacaoTrabalhista();
        });

        $("input[name='jornada12x36']").click(function(){
            toggleAssistencia();
        });


        $(".btn-replicar-hora").click(function(e){
            e.preventDefault();
            var origem  = $(this).attr('origem');
            var destino = $(this).attr('destino');
            $("input[name='"+destino+"_i']").val( $("input[name='"+origem+"_i']").val() );
            $("input[name='"+destino+"_f']").val( $("input[name='"+origem+"_f']").val() );
        });

        function toggleAssistencia() {
            if ( $("input[name='jornada12x36']:checked").val() == "s" ){
                $("#box_assistencia_12x36").show();
                $("#box_assistencia_normal").hide();
            }else if ( $("input[name='jornada12x36']:checked").val() == "n" ){
                $("#box_assistencia_normal").show();
                $("#box_assistencia_12x36").hide();
            }else{
                $("#box_assistencia_normal").hide();
                $("#box_assistencia_12x36").hide();
            }
        }

        function toggleRelacaoTrabalhista() {
            if ( $("input[name='relacao_trabalhista']:checked").val() == "proprietario" ){
                $("#box_proprietario").show();
                $("#box_empregado").hide();
            }else if ( $("input[name='relacao_trabalhista']:checked").val() == "empregado" ){
                $("#box_empregado").show();
                $("#box_proprietario").hide();
            }else{
                $("#box_empregado").hide();
                $("#box_proprietario").hide();
            }
        }
        toggleRelacaoTrabalhista();
        toggleAssistencia();
    });
</script>