<?php

//$senhaHash 	= password_hash('09747252694', PASSWORD_DEFAULT);
//echo $senhaHash;
?>
<script src="https://kit.fontawesome.com/65f22fe718.js" crossorigin="anonymous"></script>
<section class="mb-3" style="width:100%;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
                <li class="breadcrumb-item active" aria-current="page">URM</li>
            </ol>
        </nav>

    </div>
        
    </div>

</section>
<style>
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
	
	.div_evento_o{
		background-color: #fafafa;
		border-radius: 10px; /* Define o raio da borda (arredondamento) */
		padding: 15px;
		margin: 10px;
		font-size: 14px;
	}
	.div_evento {
		background-color: #d5b8cf;
		border-radius: 10px; /* Define o raio da borda (arredondamento) */
		padding: 15px;
		margin: 10px;
		font-size: 18px;
	}
</style>
<section>
    <div class="container-fluid">

		<!--<div class="alert alert-danger" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span style="font-size: 20px;">
				Se você já efetuou sua inscrição, acesse o curso <a href="https://ava.crfmg.org.br/" target="_blank"> clicando aqui</a>.
			</span>  
		</div>
		-->
		
		
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
										
										<div class="certificado" id="certificado">
											<div class="container">
												<div class="row justify-content-center text-center">
													<div class="col-md-8 purity-block-intro">
														<h3 class="block-main-title">Resetar Senha</h3>
														<div class="block-title-separator"></div>
													</div>
												</div>

												<div class="row justify-content-center">
													<div class="col-md-6">
														<div class="card">
															<div class="card-header text-center">
																Informe seu Email para emitir o certificado
															</div>
															<div class="card-body">
																<form action="#" method="POST" id="form_resetar_senha">
																	<div class="form-group">
																		<label for="email">E-mail*</label>
																		<input type="text" class="form-control" placeholder="Digite seu E-mail" name="email" id="email" required>
																		
																		<label for="email">CPF*</label>
																		<input type="numeric" inputmode="numeric" class="form-control mask_cpf" placeholder="Digite seu E-mail" name="cpf" id="cpf" required>
																	</div>
																	<button type="submit" class="btn btn-success mt-3" id="btn-gerar-certificado">Resetar Senha</button>
																</form>

																<div id="box_retorno_capacitacao" class="mt-4 alert d-none">
																	<div id="titulo_retorno_capacitacao" class="mb-1 font-weight-bold"></div>
																	<div id="menssagem_retorno_capacitacao"></div>
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
	
	/* GERAR CERTIFICADO */
                $("#form_resetar_senha").submit(async function(e) {
                    e.preventDefault();
                    console.log('Gerando Certificado');

                    try {
                        $("#btn-gerar-certificado").prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");

                        var form = document.getElementById("form_resetar_senha");
                        var fd = new FormData(form);
                        console.log(fd);

                        // Removendo classes de alerta antes de exibir novas mensagens
                        $("#box_retorno_capacitacao").removeClass("alert-success alert-danger alert-warning");

                        $("#titulo_retorno_capacitacao").html('');
                        $("#menssagem_retorno_capacitacao").html('');
                        $("#link_retorno_certificado").html('');

                        const result = await $.ajax({
                                type: "POST",
                                url: '<?=base_url()?>RecuperaSenhaAva/resetarSenha',
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
                                    
                                    $("#box_retorno_capacitacao").removeClass('d-none').addClass(`alert-${retorno.type}`);
                                    $("#titulo_retorno_capacitacao").html(retorno.title);
                                    $("#menssagem_retorno_capacitacao").html(`${retorno.message} <br> Clique <a href="${retorno.url}" target="_blank">aqui para abrir seu certificado</a>.`);
                                    
                                    if (retorno.url) {
                                        $("#link_retorno_certificado").html(`<a href="${retorno.url}" target="_blank">Baixar Certificado</a>`);
                                    }
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






