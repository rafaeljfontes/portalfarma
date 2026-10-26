<?php
	require_once('estados_cidades.php');
	
	
	$today = date("Y-m-d H:i:s");
	$trava_inscricao = "2025-07-21 21:00:00";
	//$trava = "2025-06-24 10:13:00";
	
	if($today <= $trava_inscricao){
		$none = "";
	} else {
		$none = "d-none";
	}
	
	
	
?>
<section class="mb-3" style="width:100%;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fiscalizacao Humanizada</li>
            </ol>
        </nav>

    </div>
        
    </div>

</section>
<style>
	
	/* --- BREADCRUMB --- */
	
	.breadcrumb {
		font-size: 0.85rem;
		color: #666;
		margin-bottom: 20px;
	}
	.breadcrumb a {
		color: #0056b3;
		text-decoration: none;
	}
	.breadcrumb a:hover {
		text-decoration: underline;
	}
	.breadcrumb span {
		margin: 0 8px;
		color: #ccc;
	}
		
	.block-title-separador{
		background-color: #fd7b00;
		border: 2px solid #fd7b00 !important;
		width: 5%;
		margin-left: 48%;
		margin-top: 6px;
	}
	label{
		color:#2a417c;font-weight: bold;
	}
	
	.card_public_servicos{
		color:#800000;		
	}
	
	.action-bar {
		display: flex;
		padding-top: 0;
		justify-content: space-between;
		margin: 15px;
	}
	
	.card-header {
		background-color: #00598D;
		color: white;
		font-weight: bold;
		font-size: 1.1rem;
		padding: 15px 20px;
	}
	
	
	.btnDefault {
		background-color: #ffffff;
		border: 2px solid #1ab0c1;
		border-radius: 0.25rem;
		transition: color .15s
		color: #fff;
		font-weight: 500;
		line-height: 1.2em;
		padding: 10px 50px 10px 30px;
		position: relative;
		text-align: left;
		white-space: normal;
	}
</style>
<style>
  .grandiv {
    display: flex;
    justify-content: space-between; /* Espaça as divs */
    width: 100%;
  }
  .mini_div {
    width: 30%; /* Define a largura para as 3 */
    
  }
</style>
<section>
    <div class="container-fluid">
		
        <div class="row">
            <!-- Inicio Caixa de curso -->
           
            <section id="region-fp-utility" class="fp-utility" data-region="blocks-fp-utility" aria-label="Blocks" style="background-color:#fdfeff; width: 98%; margin-left: 1%;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        

						<section id="inst248"
							 class=" block_purity_courses_pro block block_not_card style1  card"
							 role="complementary"
							 data-block="purity_courses_pro"
								  aria-labelledby="instance-248-header"
							 >

							<div class="card-body">

								<div class="card-text content">
									
									<div class="courses-pro-container">
										
										
										<div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-4 rounded grandiv" style="background:#f2f9f5; color: #203879;">
											<div class="my-3 mini_div">
												<img src="https://www.crfmg.org.br/portalfarma/assets/img/FiscalizaçãoHumanizada-logo_cor-assinatura.png" width="500px" class="img-fluid" alt="banner Fiscalização Humanizada">
											</div>
											<div class="my-9 mini_div">
												<p style="line-height: 25px;">
												"FISCALIZAÇÃO HUMANIZADA - PARCEIROS NA PRÁTICA FARMACÊUTICA: Confiança e Excelência" é um projeto do Conselho Regional de Farmácia de Minas Gerais (CRF/MG), em parceria com a Vigilância Sanitária. Aprenda sobre as principais normas e legislações da área, tire suas dúvidas e contribua para um futuro mais promissor para a farmácia em Minas Gerais.
												</p>
												<div class="text-center p-3 rounded mt-3" style="border: 1px solid #FF7b00; color: #00785f;">
													<b>Participe deste encontro e descubra como a parceria entre o CRF/MG e a VISA pode ajudar você a alcançar a excelência profissional.</b>
												</div>
											</div>
										</div>
										
										<div class="purity-block-intro" style="margin-top:25px;">
											<h3 class="block-main-title" style="color:#00598D;">ACESSO RÁPIDO</h3>
											<div class="block-title-separador"></div>
										</div>
										
										<div class="container">
											<div class="row text-center" style="max-width: 850px; margin: 0 auto;">
												<div class="col">
													<a href="https://wa.me/5531994590355">
														<button style="background: #00785f; border-radius: 6px; padding: 15px; cursor: pointer; color: #fff; border: none; font-size: 16px; min-width: 260px;">
															&nbsp; Faça aqui suas perguntas &nbsp;
														</button>
													</a>
												</div>
												<div class="col">
													<a href="https://drive.google.com/drive/folders/1PNIyefzUdnOj6Et0mOSMfkM6ZvN9C1hp">
														<button style="background: #00785f; border-radius: 6px; padding: 15px; cursor: pointer; color: #fff; border: none; font-size: 16px; min-width: 260px;">
															&nbsp; Veja as fotos do evento &nbsp;
															</button>
													</a>
												</div>
												<div class="col">
													<a href="#certificado">
														<button style="background: #FF7b00; border-radius: 6px; padding: 15px; cursor: pointer; color: #fff; border: none; font-size: 16px; min-width: 260px;">
															&nbsp; Ir para o Certificado &nbsp;
														</button>
													</a>
												</div>
											</div>
										</div>								
										
										<div class="purity-block-intro" style="margin-top:25px;">
											<h3 class="block-main-title" style="color:#00598D;">PROGRAMAÇÃO</h3>
											<div class="block-title-separador"></div>
										</div>
										
										
										<div class="col-12 col-md mb-12 text-left p-12 " style="background: #fff; border-style: solid; border-color:#00598D; border-radius: 10px; margin: 0 10px;">
											<div class="card-form">
												<div class="card-body">
													 <div class="col-12 col-md-12 mb-12 p-3">
														<h3 class="text-center" style="color:#00785f; font-weight: bold;">
																FISCALIZAÇÃO HUMANIZADA - Montes Claros/MG
															<br><b style="color:#fd7b00;">DATA:</b> 29 de Agosto
															<br><b style="color:#fd7b00;">Horário:</b> 08h às 13h
															<br><b style="color:#203879;font-size:14px;">Local: Auditório AMAMS - Av. Maj. Alexandre Rodrigues, 416 - Ibituruna, Montes Claros - MG</b>
															&nbsp;<a href="https://maps.app.goo.gl/xaZ7e9eGDwPHaqib9" alt="Mapa do local">ver no mapa</a>
														</h3>
														<hr style="border: 2px solid #ff7b00;">
														<div class="text-left" style="color:#2a417c;">
															<p><b style="color:#fd7b00;">08h00</b> - <b>Credenciamento</b></p>
															<p><b style="color:#fd7b00;">08h30</b> - <b>Abertura</b>
															</p>
															<p><b style="color:#fd7b00;">09h00 às 10h00</b> - <b>Conhecendo o CRF/MG e as diretrizes farmacêuticas</b>
																<br><i>Palestrante: Dr. Sebastião José Ferreira</i>
																<br><i>Palestrante: Dra. Juliana Bastos</i>
															</p>
															<p><b style="color:#fd7b00;">10h00 às 11h00</b> - <b>Fiscalização Sanitária de Farmácias e Drogarias</b>
																<br><i>Palestrante: Dr. Luis Paulo Ribeiro Ruas</i>
															</p>
															<p><b style="color:#fd7b00;">11h00 às 13h00</b> - <b>Mesa-redonda: Fiscalização Humanizada</b>
																<br><i>Palestrante: Dr. Marcos Viera Batista</i>
																<br><i>Palestrante: Dr. Rodrigo Mota</i>
															</p>
															<p><b style="color:#fd7b00;">13h00</b> - <b>Encerramento</b></p>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="purity-block-intro" style="margin-top:25px;">
											<h3 class="block-main-title" style="color:#00598D;">INSCRIÇÃO</h3>
											<div class="block-title-separador"></div>
										</div>
										
										<div class="col-12 col-md mb-4 text-left p-4 " style="background: #fff; border-style: solid; border-color:#00598D; border-radius: 10px; margin: 0 10px;">
											<div class="card-form">
												<div class="card-body text-center d-none">INSCRIÇÕES ENCERRADAS - CERTIFICADOS LIBERADOS APENAS DIA 22/07 ÀS 09HS APÓS CONFIRMAÇÃO DE PRESENÇA</div>
												
												<div class="card-body ">
													<form method="POST" autocomplete="off" id="form" novalidate>

														<div class="form-group" style="padding:10px;">
															<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio" name="id_evento" id="id_evento" value="5" checked>
																<label class="form-check-label" for="id_evento"><b style="color:#00785f;font-size:20px">FISCALIZAÇÃO HUMANIZADA - Montes Claros/MG</b>
																<br><b style="color:#fd7b00;font-size:18px">29 de Agosto</b></label>
															</div>
														</div>
														
														<div class="form-group">
															<div class="row">
																<div class="col-12">
																	<label for="nome">*Nome Completo</label>
																	<input type="text" class="form-control" placeholder="Nome completo" name="nome" id="nome" required>
																</div>
															</div>
														</div>

														<div class="form-group my-2">
															<div class="row">
																<div class="col-6">
																	<label for="cpf">*CPF</label>
																	<input type="number" inputmode="numeric" class="form-control" placeholder="CPF" name="cpf" id="cpf" required value="">
																</div>
																<div class="col-6">
																	<label for="crfmg">Nº CRF/MG "Se houver"</label>
																	<input type="text" inputmode="numeric" class="form-control" placeholder="Número de inscrição no CRF/MG" name="crfmg" id="crfmg" maxlength="6">
																</div>
															</div>
														</div>

														<div class="form-group my-2">
															<div class="row">
																<div class="col-6">
																	<label for="email">*E-mail</label>
																	<input type="email" class="form-control" placeholder="Informe seu e-mail" name="email" id="email" required>
																</div>
															
																<div class="col-6">
																	<label for="telefone">*Telefone</label>
																	<input type="text" inputmode="numeric" class="form-control mask_phone" placeholder="Telefone" name="telefone" id="telefone" required>
																</div>
															</div>
														</div>

														<div class="form-group my-2">
															<div class="row">
																<div class="col-12">
																	<label for="email">*Municipio</label>
																	<select class="form-control" id="municipio" name="municipio" required="required">
																			<option value="MG" selected>Selecione</option>
																		<?php foreach ( $cidades_mineiras as $cidades ) { ?>
																			<option value="<?=$cidades?>" ><?=$cidades;?></option>
																		<?php } ?>
																	</select>
																</div>
															</div>
														</div>

														<div class="form-group my-2">
															<div class="row">
																<div class="col-12">
																	<label for="email">*Local de Trabalho</label>
																	<input type="text" class="form-control " id="local_trabalho" name="local_trabalho">
																	</select>
																</div>
															</div>
														</div>

														<!--<div class="form-group" id="bloco_imagem">
															<div class="col">
																<label for="formFile" class="form-label" id="labelformFile"></label>
																<input class="form-control" type="file" name="formFile">
															</div>
														</div>
														
														<div class="form-group" style="padding:10px;">
															<label for="aceite"><input type="checkbox" name="aceite" id="aceite" required> *Li e concordo com o <a href='/uploads/termo-de-aceite-e-participacao_SUS_12.08.pdf' target="_blank">TERMO DE ADESÃO E NORMAS DE PARTICIPAÇÃO</a></label>
														</div>
														-->

														<div class="form-group text-center">
															<input type="hidden" class="form-control" placeholder="" name="presenca" id="presenca" value="0">
															<button type="submit" class="btn" id="btn-send" style="background: #00598D; color: #FFF; border: none; padding: 10px 20px; border-radius: 10px; margin-top:10px;">ME INSCREVER</button>
														</div>
													</form>
													<div class="alert text-center mt-2" id="box_retorno" style="display: none;">
														<div id="titulo_retorno"></div>
														<div id="menssagem_retorno"></div>
														<div id="link_retorno_certificado"></div>
													</div>
												</div>
											</div>
										</div>
										
										<!-- CONFIRMAR PRESENÇA -->
										<div class="col-12 col-md mb-12 text-left p-12" style="background-color:#f2f9f5;border-style:solid;border-color:#00785f;border-radius:10px;margin: 0 10px;">
											
											<div class="certificado" id="presenca">
												<div class="container">
													
													<div class="row justify-content-center">
														<div class="col-md-6">
															<div class="card">
																<div class="text-center" style="background-color: #027860;color: #fff;border-radius: 10px 10px 0px 0px;height: 30px;padding: 10px;">
																	Informe seu CPF para confirmar presença
																</div>
																<div class="card-body">
																	<form action="#" method="POST" id="form_gerar_presenca">
																		<div class="form-group">
																			<label for="cpf" style="color:#00598D;font-weight: bold;">*Digite seu CPF</label>
																			<input type="text" class="form-control" placeholder="Digite seu CPF" name="cpf" id="cpf_presenca" required>
																			<input type="hidden" name="id_evento" id="id_evento_presenca" value="5">
																		</div>
																		<button type="submit" class="btn btn-success col-6 " id="btn-gerar-presenca">Confirmar Presença</button>
																	</form>

																	<div id="box_retorno_presenca" class="mt-4 alert">
																		<div id="titulo_retorno_presenca" class="mb-1 font-weight-bold"></div>
																		<div id="menssagem_retorno_presenca"></div>
																	</div>
																</div>
															</div>
															
														</div>
													</div>
												</div>
											</div>
										</div>
										
										
										<!-- CERTIFICADO -->
										<div class="purity-block-intro">
												<h3 class="block-main-title" style="color:#00598D;">Certificado</h3>
												<div class="block-title-separador"></div>
										</div>
										
										<div class="col-12 col-md mb-12 text-left p-12 " style="background-color:#f2f9f5; border-style: solid; border-color:#00785f; border-radius: 10px; margin: 0 10px;">
											
											<div class="certificado" id="certificado">
												<div class="container">
													
													<div class="row justify-content-center">
														<div class="col-md-6">
															<div class="card">
																<div class="card-header">
																	Informe seu CPF ou e-mail para emitir o certificado
																</div>
																<div class="card-body">
																	<form action="#" method="POST" id="form_gerar_certificado">
																		<div class="form-group">
																			<label for="email" style="color:#00598D;font-weight: bold;">*Digite seu E-Mail ou CPF cadastrado</label>
																			<input type="text" class="form-control" placeholder="Digite seu E-mail" name="email" id="email_certificado" required>
																		</div>
																		<button type="submit" class="btn btn-success mt-3" id="btn-gerar-certificado">Gerar Certificado</button>
																	</form>

																	<div id="box_retorno_certificado" class="mt-4 alert d-none">
																		<div id="titulo_retorno_certificado" class="mb-1 font-weight-bold"></div>
																		<div id="menssagem_retorno_certificado"></div>
																	</div>
																</div>
															</div>

															<!-- Aviso de geração, caso queira usar -->
															<div class="card mt-3 d-none">
																<div class="card-body text-center text-muted">
																	Os certificados estão sendo gerados.<br>Estarão disponíveis em até 10 dias úteis.
																</div>
															</div>
															</div>
													</div>
												</div>
											</div>
										</div>
										
										
										
									</div>
								</div>
										
									<div class="footer"></div>
									
							</div>

					</div>

						</section>
							<!-- Fim Caixa de curso -->

            
				</div>
			</div>
		</div>
	</div>
	</section>



<!-- Inicio do JS -->
<script>

$(function(){
	
	//$('.cpf').mask('000.000.000-00', {reverse: true});

	
	/* INSCRICAO */
                $("#form").submit(async function(e) {
                    e.preventDefault();
                    console.log('inscrição iniciada');
                    try {

                       // $("#btn-send").prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");

                        var form = document.getElementById("form");
                        var fd = new FormData(form);
                        $("#box_retorno").hide();

                        $("#box_retorno").removeClass(`alert-succes`);
                        $("#box_retorno").removeClass(`alert-danger`);
                        $("#box_retorno").removeClass(`alert-warning`);

                        $("#titulo_retorno").html('');
                        $("#menssagem_retorno").html('');
                        $("#link_retorno_certificado").html('');

                        $("#box_retorno").show();

                        console.log('validando form');

                        const result = await $.ajax({
                            type: "POST",
                            method: 'POST',
                            url: '<?=base_url()?>FiscalizacaoHumanizada/Inscricao',
                            data: fd,
                            dataType: 'html',
                            enctype: "multipart/form-data",
                            contentType: false,
                            processData: false,

                            beforeSend: function() {

                            },
                            success: function(res) {

                            }

                        }).done(function(res) {


                        }).fail(function(res) {

                        }).always(function(res) {

                            console.log('always', res);
                            var retorno = JSON.parse(res);
                            console.log('retorno', retorno);


                            $("#btn-send").prop('disabled', false).html('INSCREVER');
                            if (retorno.type == 'success') {
                                $("#btn-send").hide();
                            }

                            $("#box_retorno").addClass(`alert-${retorno.type}`)
                            $("#titulo_retorno").html(retorno.title);
                            $("#menssagem_retorno").html(retorno.message);
                            //$("#link_retorno_certificado").html(retorno.url);

                        });

                        return result;

                    } catch (error) {
                        console.log('error', error);
                        return false;
                    }
                });
				
				
	/* PRESENÇA */
                $("#form_gerar_presenca").submit(async function(e) {
                    e.preventDefault();
                    console.log('Confirmar Presença');
                    try {

                       //$("#btn-gerar-presenca").prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");

                        var form_gerar_presenca = document.getElementById("form_gerar_presenca");
						var cpf 		= document.getElementById("cpf_presenca");
						var id_evento 	= document.getElementById("id_evento_presenca");
                        var fd = new FormData(form_gerar_presenca);
                        $("#box_retorno").hide();

                        $("#box_retorno_presenca").removeClass(`alert-succes`);
                        $("#box_retorno_presenca").removeClass(`alert-danger`);
                        $("#box_retorno_presenca").removeClass(`alert-warning`);

                        $("#titulo_retorno_presenca").html('');
                        $("#menssagem_retorno_presenca").html('');

                        $("#box_retorno_presenca").show();

                        console.log('validando form');
						//console.log(fd);
						console.log(cpf.value);
						console.log(id_evento.value);
						
						
                        const result = await $.ajax({
                            type: "POST",
                            method: 'POST',
                            url: '<?=base_url()?>FiscalizacaoHumanizada/ConfirmarPresenca',
                            data: fd,                            
                            dataType: 'html',
                            enctype: "multipart/form-data",
                            contentType: false,
                            processData: false,

                            beforeSend: function() {

                            },
                            success: function(res) {

                            }

                        }).done(function(res) {


                        }).fail(function(res) {

                        }).always(function(res) {

                            //console.log('always', res);
                            var retorno = JSON.parse(res);
                            console.log('retorno', retorno);


                           // $("#btn-gerar-presenca").prop('disabled', false).html('Confirmar Presença');
                            if (retorno.type == 'success') {
                                $("#btn-gerar-presenca").hide();
                            }

                            $("#box_retorno_presenca").addClass(`alert-${retorno.type}`)
                            $("#titulo_retorno_presenca").html(retorno.title);
                            $("#menssagem_retorno_presenca").html(retorno.message);
                            //$("#link_retorno_certificado").html(retorno.url);

                        });

                        return result;

                    } catch (error) {
                        console.log('error', error);
                        return false;
                    }
                });
				
	
	/* GERAR CERTIFICADO */
                $("#form_gerar_certificado").submit(async function(e) {
                    e.preventDefault();
                    console.log('Gerando Certificado');

                    try {
                        $("#btn-gerar-certificado").prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");

                        var form = document.getElementById("form_gerar_certificado");
                        var fd = new FormData(form);
                        console.log(fd);

                        // Removendo classes de alerta antes de exibir novas mensagens
                        $("#box_retorno_certificado").removeClass("alert-success alert-danger alert-warning");

                        $("#titulo_retorno_certificado").html('');
                        $("#menssagem_retorno_certificado").html('');
                        $("#link_retorno_certificado").html('');

                        const result = await $.ajax({
                                type: "POST",
                                url: '<?=base_url()?>FiscalizacaoHumanizada/gerarCertificado',
                                data: fd,
                                dataType: 'html',
                                enctype: "multipart/form-data",
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                    console.log('Enviando solicitação...');
                                }
                            })
                            .done(function(res) {
                                console.log('Sucesso:', res);
                            })
                            .fail(function(res) {
                                console.log('Erro na requisição:', res);
                            })
                            .always(function(res) {
                                $("#btn-gerar-certificado").prop('disabled', false).html("Gerar Certificado");

                                try {
                                    var retorno = typeof res === "string" ? JSON.parse(res) : res;
                                    console.log('Resposta final:', retorno);
                                    
                                    $("#box_retorno_certificado").removeClass('d-none').addClass(`alert-${retorno.type}`);
                                    $("#titulo_retorno_certificado").html(retorno.title);
                                    if (retorno.url) {
										$("#menssagem_retorno_certificado").html(`${retorno.message} <br> Clique <a href="${retorno.url}" target="_blank">aqui para abrir seu certificado</a>.`);
									}else{
										$("#menssagem_retorno_certificado").html(`${retorno.message}`);
									}
										
                                    
                                    /*if (retorno.url) {
                                        $("#link_retorno_certificado").html(`<a href="${retorno.url}" target="_blank">Baixar Certificado</a>`);
                                    }*/
                                } catch (error) {
                                    console.log('Erro ao processar resposta JSON:', error);
                                }
                            });

                        return result;
                    } catch (error) {
                        console.log('Erro geral:', error);
                        return false;
                    }
                });
	
});
</script>





