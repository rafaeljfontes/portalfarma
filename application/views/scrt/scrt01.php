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
        $hora = '<option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option>';
        $minuto = '<option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option>';
?>
            <div class="row">
                <div class="col-md-12"><h5><u>Horário do Estabelecimento</u></h5><br><br></div>
            </div>
<!--msg de retorno-->
<?php if (!empty($this -> session -> flashdata('tipo'))) { ?>
            <div class="alert alert-<?= $this -> session -> flashdata('tipo'); ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span style="font-size: 16px;"><?= $this -> session -> flashdata('msg'); ?></span>
            </div>
<?php } ?>
<!--fim msg de retorno-->
            <div class="row">
                <div class="col-md-9"><p align="justify"><i>***A coluna <b>-Horário de Intervalo-</b> só deverá ser preenchida caso o estabelecimento interrompa seu funcionamento durante o expediente, por exemplo uma parada para o horário de almoço.</i></p><br></div>
            </div>
            <form name="frm01" action="<?= base_url(); ?>Scrt/frm01" method="POST" id="form-send">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="table-responsive">
                        <table border="0" cellpadding="0" cellspacing="0" class="table table-hover table-striped">
                            <tr class="d-flex">
                                <th class="col-lg-2 text-right" nowrap>Dia da Semana</th>
                                <th class="col-lg-5 text-center" nowrap>Horário de Funcionamento</th>
                                <th class="col-lg-5 text-center" nowrap>Horário de Intervalo</th>
                            </tr>
                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap> Segunda-Feira</td>

                                <td class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_seg_i')) ? 'is-invalid' : ''; ?>" id="hf_seg_i" name="hf_seg_i" placeholder="hh:mm" value="<?=set_value('hf_seg_i', $hf_seg_i);?>">
                                    <?=form_error('hf_seg_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_seg_f')) ? 'is-invalid' : ''; ?>" id="hf_seg_f" name="hf_seg_f" placeholder="hh:mm" value="<?=set_value('hf_seg_f', $hf_seg_f);?>">
                                    <?=form_error('hf_seg_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hf_seg" destino="hf_ter"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>

                                <td style="border-left:1px solid #000;" class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_seg_i')) ? 'is-invalid' : ''; ?>" id="hi_seg_i" name="hi_seg_i" placeholder="hh:mm" value="<?=set_value('hi_seg_i', $hi_seg_i);?>">
                                    <?=form_error('hi_seg_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_seg_f')) ? 'is-invalid' : ''; ?>" id="hi_seg_f" name="hi_seg_f" placeholder="hh:mm" value="<?=set_value('hi_seg_f', $hi_seg_f);?>">
                                    <?=form_error('hi_seg_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi_seg" destino="hi_ter"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>
                            </tr>

                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap> Terça-Feira</td>

                                <td class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_ter_i')) ? 'is-invalid' : ''; ?>" id="hf_ter_i" name="hf_ter_i" placeholder="hh:mm" value="<?=set_value('hf_ter_i', $hf_ter_i);?>">
                                    <?=form_error('hf_ter_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_ter_f')) ? 'is-invalid' : ''; ?>" id="hf_ter_f" name="hf_ter_f" placeholder="hh:mm" value="<?=set_value('hf_ter_f', $hf_ter_f);?>">
                                    <?=form_error('hf_ter_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hf_ter" destino="hf_qua"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>

                                <td style="border-left:1px solid #000;" class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_ter_i')) ? 'is-invalid' : ''; ?>" id="hi_ter_i" name="hi_ter_i" placeholder="hh:mm" value="<?=set_value('hi_ter_i', $hi_ter_i);?>">
                                    <?=form_error('hi_ter_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_ter_f')) ? 'is-invalid' : ''; ?>" id="hi_ter_f" name="hi_ter_f" placeholder="hh:mm" value="<?=set_value('hi_ter_f', $hi_ter_f);?>">
                                    <?=form_error('hi_ter_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi_ter" destino="hi_qua"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>
                            </tr>

                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap> Quarta-Feira</td>

                                <td class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_qua_i')) ? 'is-invalid' : ''; ?>" id="hf_qua_i" name="hf_qua_i" placeholder="hh:mm" value="<?=set_value('hf_qua_i', $hf_qua_i);?>">
                                    <?=form_error('hf_qua_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_qua_f')) ? 'is-invalid' : ''; ?>" id="hf_qua_f" name="hf_qua_f" placeholder="hh:mm" value="<?=set_value('hf_qua_f', $hf_qua_f);?>">
                                    <?=form_error('hf_qua_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hf_qua" destino="hf_qui"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>

                                <td style="border-left:1px solid #000;" class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_qua_i')) ? 'is-invalid' : ''; ?>" id="hi_qua_i" name="hi_qua_i" placeholder="hh:mm" value="<?=set_value('hi_qua_i', $hi_qua_i);?>">
                                    <?=form_error('hi_qua_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_qua_f')) ? 'is-invalid' : ''; ?>" id="hi_qua_f" name="hi_qua_f" placeholder="hh:mm" value="<?=set_value('hi_qua_f', $hi_qua_f);?>">
                                    <?=form_error('hi_qua_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi_qua" destino="hi_qui"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>
                            </tr>

                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap> Quinta-Feira</td>

                                <td class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_qui_i')) ? 'is-invalid' : ''; ?>" id="hf_qui_i" name="hf_qui_i" placeholder="hh:mm" value="<?=set_value('hf_qui_i', $hf_qui_i);?>">
                                    <?=form_error('hf_qui_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_qui_f')) ? 'is-invalid' : ''; ?>" id="hf_qui_f" name="hf_qui_f" placeholder="hh:mm" value="<?=set_value('hf_qui_f', $hf_qui_f);?>">
                                    <?=form_error('hf_qui_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hf_qui" destino="hf_sex"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>

                                <td style="border-left:1px solid #000;" class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_qui_i')) ? 'is-invalid' : ''; ?>" id="hi_qui_i" name="hi_qui_i" placeholder="hh:mm" value="<?=set_value('hi_qui_i', $hi_qui_i);?>">
                                    <?=form_error('hi_qui_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_qui_f')) ? 'is-invalid' : ''; ?>" id="hi_qui_f" name="hi_qui_f" placeholder="hh:mm" value="<?=set_value('hi_qui_f', $hi_qui_f);?>">
                                    <?=form_error('hi_qui_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi_qui" destino="hi_sex"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>
                            </tr>

                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap> Sexta-Feira</td>

                                <td class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_sex_i')) ? 'is-invalid' : ''; ?>" id="hf_sex_i" name="hf_sex_i" placeholder="hh:mm" value="<?=set_value('hf_sex_i', $hf_sex_i);?>">
                                    <?=form_error('hf_sex_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_sex_f')) ? 'is-invalid' : ''; ?>" id="hf_sex_f" name="hf_sex_f" placeholder="hh:mm" value="<?=set_value('hf_sex_f', $hf_sex_f);?>">
                                    <?=form_error('hf_sex_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hf_sex" destino="hf_sab"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>

                                <td style="border-left:1px solid #000;" class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_sex_i')) ? 'is-invalid' : ''; ?>" id="hi_sex_i" name="hi_sex_i" placeholder="hh:mm" value="<?=set_value('hi_sex_i', $hi_sex_i);?>">
                                    <?=form_error('hi_sex_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_sex_f')) ? 'is-invalid' : ''; ?>" id="hi_sex_f" name="hi_sex_f" placeholder="hh:mm" value="<?=set_value('hi_sex_f', $hi_sex_f);?>">
                                    <?=form_error('hi_sex_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi_sex" destino="hi_sab"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>
                            </tr>

                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap> Sábado</td>

                                <td class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_sab_i')) ? 'is-invalid' : ''; ?>" id="hf_sab_i" name="hf_sab_i" placeholder="hh:mm" value="<?=set_value('hf_sab_i', $hf_sab_i);?>">
                                    <?=form_error('hf_sab_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hf_sab_f')) ? 'is-invalid' : ''; ?>" id="hf_sab_f" name="hf_sab_f" placeholder="hh:mm" value="<?=set_value('hf_sab_f', $hf_sab_f);?>">
                                    <?=form_error('hf_sab_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hf_sab" destino="hf_dom"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>

                                <td style="border-left:1px solid #000;" class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_sab_i')) ? 'is-invalid' : ''; ?>" id="hi_sab_i" name="hi_sab_i" placeholder="hh:mm" value="<?=set_value('hi_sab_i', $hi_sab_i);?>">
                                    <?=form_error('hi_sab_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="mask_hour form-control <?=(form_error('hi_sab_f')) ? 'is-invalid' : ''; ?>" id="hi_sab_f" name="hi_sab_f" placeholder="hh:mm" value="<?=set_value('hi_sab_f', $hi_sab_f);?>">
                                    <?=form_error('hi_sab_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;<a href="#" class="btn btn-sm btn-dark btn-replicar-hora" origem="hi_sab" destino="hi_dom"><i class="fa fa-level-down-alt"></i></a></div>
                                </td>
                            </tr>

                            <tr class="d-flex">
                                <td class="col-lg-2 text-right" nowrap>Domingo</td>

                                <td class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('hf_dom_i')) ? 'is-invalid' : ''; ?>" id="hf_dom_i" name="hf_dom_i" placeholder="hh:mm" value="<?=set_value('hf_dom_i', $hf_dom_i);?>">
                                    <?=form_error('hf_dom_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('hf_dom_f')) ? 'is-invalid' : ''; ?>" id="hf_dom_f" name="hf_dom_f" placeholder="hh:mm" value="<?=set_value('hf_dom_f', $hf_dom_f);?>">
                                    <?=form_error('hf_dom_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

                                </td>

                                <td style="border-left:1px solid #000;" class="col-lg-5 text-center d-flex justify-content-center align-items-center " nowrap>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('hi_dom_i')) ? 'is-invalid' : ''; ?>" id="hi_dom_i" name="hi_dom_i" placeholder="hh:mm" value="<?=set_value('hi_dom_i', $hi_dom_i);?>">
                                    <?=form_error('hi_dom_i','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div><span>&nbsp; - &nbsp;</span></div>
                                    <div>
                                    <input type="text" inputmode="numeric" style="width:100px" class="form-control mask_hour <?=(form_error('hi_dom_f')) ? 'is-invalid' : ''; ?>" id="hi_dom_f" name="hi_dom_f" placeholder="hh:mm" value="<?=set_value('hi_dom_f', $hi_dom_f);?>">
                                    <?=form_error('hi_dom_f','<small class="form-text text-muted label-error">', '</small>'); ?>
                                    </div>
                                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                </td>

                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-5 text-center">
                <?php
                    if($mode_edit){
                ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <input type="hidden" name="acao" value="alterar">
                        <input type="hidden" name="mode_edit" value="true">
                        <input type="hidden" name="id_hf" value="<?=$id_hf?>">
                        <input type="hidden" name="id_hi" value="<?=$id_hi?>">
                        <button class="btn btn-success col-md-6 col-lg-6" id="btn-salvar">
                            <i class="fa fa-edit"></i> Alterar Informações
                        </button>
                    </div>
                </div>

                <?php
                    }else{
                ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <input type="hidden" name="acao" value="salvar">
                        <button type="button" class="btn btn-success col-md-6 col-lg-6" id="btn-salvar">
                            <i class="fa fa-check"></i> Salvar
                        </button>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
            <div class="row mt-1 text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <a href="<?= base_url(); ?>Scrt/scrt00" target="_self"><input type="button" name="voltar" value="Resumo da Solicitação" class="btn btn-warning col-md-6 col-lg-6" id="btn-back"></a>
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



<div class="modal" id="modalConfirmarHorario" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirme o Horário de Funcionamento!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="text-align:center;">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Dia da Semana</th>
                    <th>Horário de Funcionamento</th>
                    <th>Horário de Intervalo</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Segunda-Feira</td>
                        <td id="modal_hf_seg"></td>
                        <td id="modal_hi_seg"></td>
                    </tr>
                    <tr>
                        <td>Terça-Feira</td>
                        <td id="modal_hf_ter"></td>
                        <td id="modal_hi_ter"></td>
                    </tr>
                    <tr>
                        <td>Quarta-Feira</td>
                        <td id="modal_hf_qua"></td>
                        <td id="modal_hi_qua"></td>
                    </tr>
                    <tr>
                        <td>Quinta-Feira</td>
                        <td id="modal_hf_qui"></td>
                        <td id="modal_hi_qui"></td>
                    </tr>
                    <tr>
                        <td>Sexta-Feira</td>
                        <td id="modal_hf_sex"></td>
                        <td id="modal_hi_sex"></td>
                    </tr>
                    <tr>
                        <td>Sábado</td>
                        <td id="modal_hf_sab"></td>
                        <td id="modal_hi_sab"></td>
                    </tr>
                    <tr>
                        <td>Domingo</td>
                        <td id="modal_hf_dom"></td>
                        <td id="modal_hi_dom"></td>
                    </tr>
                </tbody>
            </table>
        </p>

      </div>
      <div class="modal-footer" style="display:flex; justify-content:flex-end;">
            <button type="button" id="btn-confirmar-horario" class="btn btn-success">
                <i class="fa fa-check"></i> Salvar Horário de Funcionamento
            </button>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?=base_url()?>assets/js/input-mask/dist/jquery.inputmask.min.js"></script>
<script src="<?=base_url()?>assets/js/inscricao_pf/util.js"></script>
<script>
    $(function(){

        $('form').attr('autocomplete', 'off');
        $('.mask_hour').inputmask({alias:'datetime', placeholder: 'hh:mm', inputFormat: "HH:MM", max: 24});

        $("#form-send").submit(function(){
            $("#modalConfirmarHorario").modal('hide');
            $("#btn-salvar").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
        });

        $("#form-send").submit(function(){
            $("#modalConfirmarHorario").modal('hide');
            $("#btn-send").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
        });

        $("#btn-confirmar-horario").click(function(e){
            e.preventDefault();
            $("#form-send").submit();
        });

        $("#btn-salvar").click(function(e){
            e.preventDefault();

            $("#modal_hf_seg").empty().text( $("input[name='hf_seg_i']").val() +' - '+ $("input[name='hf_seg_f']").val() );
            $("#modal_hi_seg").empty().text( $("input[name='hi_seg_i']").val() +' - '+ $("input[name='hi_seg_f']").val() );

            $("#modal_hf_ter").empty().text( $("input[name='hf_ter_i']").val() +' - '+ $("input[name='hf_ter_f']").val() );
            $("#modal_hi_ter").empty().text( $("input[name='hi_ter_i']").val() +' - '+ $("input[name='hi_ter_f']").val() );

            $("#modal_hf_qua").empty().text( $("input[name='hf_qua_i']").val() +' - '+ $("input[name='hf_qua_f']").val() );
            $("#modal_hi_qua").empty().text( $("input[name='hi_qua_i']").val() +' - '+ $("input[name='hi_qua_f']").val() );

            $("#modal_hf_qui").empty().text( $("input[name='hf_qui_i']").val() +' - '+ $("input[name='hf_qui_f']").val() );
            $("#modal_hi_qui").empty().text( $("input[name='hi_qui_i']").val() +' - '+ $("input[name='hi_qui_f']").val() );

            $("#modal_hf_sex").empty().text( $("input[name='hf_sex_i']").val() +' - '+ $("input[name='hf_sex_f']").val() );
            $("#modal_hi_sex").empty().text( $("input[name='hi_sex_i']").val() +' - '+ $("input[name='hi_sex_f']").val() );

            $("#modal_hf_sab").empty().text( $("input[name='hf_sab_i']").val() +' - '+ $("input[name='hf_sab_f']").val() );
            $("#modal_hi_sab").empty().text( $("input[name='hi_sab_i']").val() +' - '+ $("input[name='hi_sab_f']").val() );

            $("#modal_hf_dom").empty().text( $("input[name='hf_dom_i']").val() +' - '+ $("input[name='hf_dom_f']").val() );
            $("#modal_hi_dom").empty().text( $("input[name='hi_dom_i']").val() +' - '+ $("input[name='hi_dom_f']").val() );

            $("#modalConfirmarHorario").modal('show');

        });


        $("#btn-send").click(function(e){
            e.preventDefault();

            $("#modal_hf_seg").empty().text( $("input[name='hf_seg_i']").val() +' - '+ $("input[name='hf_seg_f']").val() );
            $("#modal_hi_seg").empty().text( $("input[name='hi_seg_i']").val() +' - '+ $("input[name='hi_seg_f']").val() );

            $("#modal_hf_ter").empty().text( $("input[name='hf_ter_i']").val() +' - '+ $("input[name='hf_ter_f']").val() );
            $("#modal_hi_ter").empty().text( $("input[name='hi_ter_i']").val() +' - '+ $("input[name='hi_ter_f']").val() );

            $("#modal_hf_qua").empty().text( $("input[name='hf_qua_i']").val() +' - '+ $("input[name='hf_qua_f']").val() );
            $("#modal_hi_qua").empty().text( $("input[name='hi_qua_i']").val() +' - '+ $("input[name='hi_qua_f']").val() );

            $("#modal_hf_qui").empty().text( $("input[name='hf_qui_i']").val() +' - '+ $("input[name='hf_qui_f']").val() );
            $("#modal_hi_qui").empty().text( $("input[name='hi_qui_i']").val() +' - '+ $("input[name='hi_qui_f']").val() );

            $("#modal_hf_sex").empty().text( $("input[name='hf_sex_i']").val() +' - '+ $("input[name='hf_sex_f']").val() );
            $("#modal_hi_sex").empty().text( $("input[name='hi_sex_i']").val() +' - '+ $("input[name='hi_sex_f']").val() );

            $("#modal_hf_sab").empty().text( $("input[name='hf_sab_i']").val() +' - '+ $("input[name='hf_sab_f']").val() );
            $("#modal_hi_sab").empty().text( $("input[name='hi_sab_i']").val() +' - '+ $("input[name='hi_sab_f']").val() );

            $("#modal_hf_dom").empty().text( $("input[name='hf_dom_i']").val() +' - '+ $("input[name='hf_dom_f']").val() );
            $("#modal_hi_dom").empty().text( $("input[name='hi_dom_i']").val() +' - '+ $("input[name='hi_dom_f']").val() );

            $("#modalConfirmarHorario").modal('show');

        });

        $(".btn-replicar-hora").click(function(e){
            e.preventDefault();
            var origem  = $(this).attr('origem');
            var destino = $(this).attr('destino');
            $("input[name='"+destino+"_i']").val( $("input[name='"+origem+"_i']").val() );
            $("input[name='"+destino+"_f']").val( $("input[name='"+origem+"_f']").val() );
        });

    });
</script>

<script language="javascript" type="text/javascript">
function dias(p1, p2, p3, p4) {
    if ((isNaN(p1) == false) && (isNaN(p2) == false) && (isNaN(p3) == false) && (isNaN(p4) == false)) {
        return true;//o usuário escolheu os números
    }else if ((isNaN(p1) == true) && (isNaN(p2) == true) && (isNaN(p3) == true) && (isNaN(p4) == true)) {
        return true;//o usuário não mexeu
    }else{
        return false;//marcação inválida
    }
}
function f2() {
    var horario_domingo = false;
    var h_ini_hor = parseInt(document.frm01.h_dom_i_h.value);
    var h_ini_min = parseInt(document.frm01.h_dom_i_m.value);
    var h_fin_hor = parseInt(document.frm01.h_dom_f_h.value);
    var h_fin_min = parseInt(document.frm01.h_dom_f_m.value);
    var i_ini_hor = parseInt(document.frm01.i_dom_i_h.value);
    var i_ini_min = parseInt(document.frm01.i_dom_i_m.value);
    var i_fin_hor = parseInt(document.frm01.i_dom_f_h.value);
    var i_fin_min = parseInt(document.frm01.i_dom_f_m.value);
    if (dias(h_ini_hor, h_ini_min, h_fin_hor, h_fin_min)) {//horario
        horario_domingo = true;
        if (dias(i_ini_hor, i_ini_min, i_fin_hor, i_fin_min) == false) {//intervalo 1
            alert('Preencha o -Horário de Intervalo de Domingo- corretamente.');
            return false;
        }
    }else{
        alert('Preencha o -Horário de Funcionamento de Domingo- corretamente.');
        return false;
    }
    var horario_segunda = false;
    var h_ini_hor = parseInt(document.frm01.h_seg_i_h.value);
    var h_ini_min = parseInt(document.frm01.h_seg_i_m.value);
    var h_fin_hor = parseInt(document.frm01.h_seg_f_h.value);
    var h_fin_min = parseInt(document.frm01.h_seg_f_m.value);
    var i_ini_hor = parseInt(document.frm01.i_seg_i_h.value);
    var i_ini_min = parseInt(document.frm01.i_seg_i_m.value);
    var i_fin_hor = parseInt(document.frm01.i_seg_f_h.value);
    var i_fin_min = parseInt(document.frm01.i_seg_f_m.value);
    if (dias(h_ini_hor, h_ini_min, h_fin_hor, h_fin_min)) {//horario
        horario_segunda = true;
        if (dias(i_ini_hor, i_ini_min, i_fin_hor, i_fin_min) == false) {//intervalo 1
            alert('Preencha o -Horário de Intervalo de Segunda- corretamente.');
            return false;
        }
    }else{
        alert('Preencha o -Horário de Funcionamento de Segunda- corretamente.');
        return false;
    }
    var horario_terca = false;
    var h_ini_hor = parseInt(document.frm01.h_ter_i_h.value);
    var h_ini_min = parseInt(document.frm01.h_ter_i_m.value);
    var h_fin_hor = parseInt(document.frm01.h_ter_f_h.value);
    var h_fin_min = parseInt(document.frm01.h_ter_f_m.value);
    var i_ini_hor = parseInt(document.frm01.i_ter_i_h.value);
    var i_ini_min = parseInt(document.frm01.i_ter_i_m.value);
    var i_fin_hor = parseInt(document.frm01.i_ter_f_h.value);
    var i_fin_min = parseInt(document.frm01.i_ter_f_m.value);
    if (dias(h_ini_hor, h_ini_min, h_fin_hor, h_fin_min)) {//horario
        horario_terca = true;
        if (dias(i_ini_hor, i_ini_min, i_fin_hor, i_fin_min) == false) {//intervalo 1
            alert('Preencha o -Horário de Intervalo de Terça- corretamente.');
            return false;
        }
    }else{
        alert('Preencha o -Horário de Funcionamento de Terça- corretamente.');
        return false;
    }
    var horario_quarta = false;
    var h_ini_hor = parseInt(document.frm01.h_qua_i_h.value);
    var h_ini_min = parseInt(document.frm01.h_qua_i_m.value);
    var h_fin_hor = parseInt(document.frm01.h_qua_f_h.value);
    var h_fin_min = parseInt(document.frm01.h_qua_f_m.value);
    var i_ini_hor = parseInt(document.frm01.i_qua_i_h.value);
    var i_ini_min = parseInt(document.frm01.i_qua_i_m.value);
    var i_fin_hor = parseInt(document.frm01.i_qua_f_h.value);
    var i_fin_min = parseInt(document.frm01.i_qua_f_m.value);
    if (dias(h_ini_hor, h_ini_min, h_fin_hor, h_fin_min)) {//horario
        horario_quarta = true;
        if (dias(i_ini_hor, i_ini_min, i_fin_hor, i_fin_min) == false) {//intervalo 1
            alert('Preencha o -Horário de Intervalo de Quarta- corretamente.');
            return false;
        }
    }else{
        alert('Preencha o -Horário de Funcionamento de Quarta- corretamente.');
        return false;
    }
    var horario_quinta = false;
    var h_ini_hor = parseInt(document.frm01.h_qui_i_h.value);
    var h_ini_min = parseInt(document.frm01.h_qui_i_m.value);
    var h_fin_hor = parseInt(document.frm01.h_qui_f_h.value);
    var h_fin_min = parseInt(document.frm01.h_qui_f_m.value);
    var i_ini_hor = parseInt(document.frm01.i_qui_i_h.value);
    var i_ini_min = parseInt(document.frm01.i_qui_i_m.value);
    var i_fin_hor = parseInt(document.frm01.i_qui_f_h.value);
    var i_fin_min = parseInt(document.frm01.i_qui_f_m.value);
    if (dias(h_ini_hor, h_ini_min, h_fin_hor, h_fin_min)) {//horario
        horario_quinta = true;
        if (dias(i_ini_hor, i_ini_min, i_fin_hor, i_fin_min) == false) {//intervalo 1
            alert('Preencha o -Horário de Intervalo de Quinta- corretamente.');
            return false;
        }
    }else{
        alert('Preencha o -Horário de Funcionamento de Quinta- corretamente.');
        return false;
    }
    var horario_sexta = false;
    var h_ini_hor = parseInt(document.frm01.h_sex_i_h.value);
    var h_ini_min = parseInt(document.frm01.h_sex_i_m.value);
    var h_fin_hor = parseInt(document.frm01.h_sex_f_h.value);
    var h_fin_min = parseInt(document.frm01.h_sex_f_m.value);
    var i_ini_hor = parseInt(document.frm01.i_sex_i_h.value);
    var i_ini_min = parseInt(document.frm01.i_sex_i_m.value);
    var i_fin_hor = parseInt(document.frm01.i_sex_f_h.value);
    var i_fin_min = parseInt(document.frm01.i_sex_f_m.value);
    if (dias(h_ini_hor, h_ini_min, h_fin_hor, h_fin_min)) {//horario
        horario_sexta = true;
        if (dias(i_ini_hor, i_ini_min, i_fin_hor, i_fin_min) == false) {//intervalo 1
            alert('Preencha o -Horário de Intervalo de Sexta- corretamente.');
            return false;
        }
    }else{
        alert('Preencha o -Horário de Funcionamento de Sexta- corretamente.');
        return false;
    }
    var horario_sabado = false;
    var h_ini_hor = parseInt(document.frm01.h_sab_i_h.value);
    var h_ini_min = parseInt(document.frm01.h_sab_i_m.value);
    var h_fin_hor = parseInt(document.frm01.h_sab_f_h.value);
    var h_fin_min = parseInt(document.frm01.h_sab_f_m.value);
    var i_ini_hor = parseInt(document.frm01.i_sab_i_h.value);
    var i_ini_min = parseInt(document.frm01.i_sab_i_m.value);
    var i_fin_hor = parseInt(document.frm01.i_sab_f_h.value);
    var i_fin_min = parseInt(document.frm01.i_sab_f_m.value);
    if (dias(h_ini_hor, h_ini_min, h_fin_hor, h_fin_min)) {//horario
        horario_sabado = true;
        if (dias(i_ini_hor, i_ini_min, i_fin_hor, i_fin_min) == false) {//intervalo 1
            alert('Preencha o -Horário de Intervalo de Sábado- corretamente.');
            return false;
        }
    }else{
        alert('Preencha o -Horário de Funcionamento de Sábado- corretamente.');
        return false;
    }
    if ((horario_domingo == true) && (horario_segunda == true) && (horario_terca == true) && (horario_quarta == true) && (horario_quinta == true) && (horario_sexta == true) && (horario_sabado == true)) {
        if (confirm('Confirma essa escolha?')) {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
</script>