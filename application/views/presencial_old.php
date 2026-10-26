    
<style>

    .box_search{
        display:flex; 
        justify-content:center; 
        align-content:center; 
        align-items:center;
        margin: 0 auto;
        flex-direction: column;
        padding: 0% 2%;
    }

    .box_item{
        flex: 1;
        text-align: center; 
        font-weight: bold;
    }

    .title_search{
        color:#000;
        font-size: 1.3em; 
        line-height: 28px; 
    }

    .box_servicos{
        /*border: 1px solid #000;*/
        padding: 0 !important;
        margin: 1% 0 !important;
    }

    .card_servicos{
        /*border: 1px solid #069;*/
        height: 310px;
        margin: 5%;
        border-radius: 10px;
        background: #eee;
    }

    .card_icon_servicos{
        background: #e15454;
        height: 70px;
        width: 45px;
        display: flex; 
        justify-content:center;
        align-items: center;
        color:#FFF;
        border-radius: 5px;
        position: absolute;
        top: -5px;
        left: 35px;
    }

    .card_title_servicos{
       text-align:center;
       width:100%;
       padding: 4% 2%;
       /*margin-left:17%;*/
       font-size:1.1em;
    }

    .card_tutor_servicos{
        /*margin-top: 5%; 
        margin-left: 5%;*/
        padding: 5%;
        font-size: 12px;
        line-height: 12px; 
    }

    .card_public_servicos{
        color:#c40000;
        /*padding: 5%;*/
        /*margin-left: 5%;*/
        font-size: 12px;
        /*line-height: 5px; */
    }

    .card_description_servicos{
        padding: 5%;
        font-size: 14px;
        line-height: 20px; 
    }

    .card_button_servicos{
        position: absolute;
        margin-left:50px;
        bottom: 30px;
        text-align:center;
        width: 60%;
    }

    .card_image_servicos{
        margin-top: 5%;
        position: relative;
        text-align:center;
        
    }

    .card_register_servicos{
        margin-left:100px;
        position: relative;
        text-align:center;
        margin-bottom:5px;
    }
    

    @media screen and (max-width: 600px) {
        .title_search{
            font-size: 1em; 
            line-height: 22px; 
        }
    }
</style>

    <section class="mb-3" style="width:100%;">

           <nav aria-label="breadcrumb">
			    <ol class="breadcrumb">
			        <li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
			        <li class="breadcrumb-item active" aria-current="page">Capacifar Presencial</li>
			    </ol>
			</nav>

        </div>
            
        </div>

    </section>

<section>
    <div class="container-fluid">

            <div class="alert alert-secondary" role="alert"  style=" line-height: 22px;">
                <p>
				O Capacifar é o programa de capacitações do CRF/MG que há mais de 10 anos promove cursos, palestras e eventos presenciais e todo Estado de Minas Gerais.
				</p><p>
				Alinhado à missão do CRF/MG, o Capacifar promove a valorização da profissão farmacêutica por meio da qualificação profissional.					
				</p>
            </div>
			<!--
			<div class="alert alert-warning" role="alert">
				<p>
					<b>Temporariamente por causa da pandemia, os eventos presenciais do Capacifar estão suspensos, 
						mas assim que possível, você encontrará aqui, no Portal Farma, os cursos disponíveis para inscrição.</b>
				</p>
            </div>
			-->
			<!--  msg de retorno -->
			<?php if($this->session->flashdata('tipo') != ""){?>
			<div class="alert alert-<?=$this->session->flashdata('tipo');?>" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span style="font-size: 16px;"><?=$this->session->flashdata('msg');?></span>  
			</div>
			<?php } ?>
			<?php if($this->session->flashdata('tipo') != ""){?>
			<div class="alert alert-<?=$this->session->flashdata('tipo');?>" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span style="font-size: 16px;">
					Para acessar o <b>AVA</b> ("<a href="https://ava.crfmg.org.br/" target="_blank">https://ava.crfmg.org.br/</a>"), insira o seu CPF nos campos de usuário e senha.
				</span>  
			</div>
			<?php } ?>
		<!--  fim msg de retorno -->
		
            <div class="row">
                <!-- Inicio Caixa de curso -->
               
                <?php 
                //print_r($tabelaCurso);
                foreach ($tabelaCurso as $campos){ 
                    $campo_descricao = substr($campos->descricao, 0, 70);
                ?>
                
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 box_servicos">
					<div class="card_servicos">
						<div class="container">
							<div class="row">
							   
								<div class="card" style="width: 25rem; height: 33rem">
									
									<img src="<?=base_url()?>assets/img/cursos/<?=$campos->imagem?>" class="card-img-top" alt="<?=$campos->nome?>">
									
									<div class="card-body">
									<h5 class="card-title"><?=$campos->nome?></h5>
									<p class="card-text">
										<a href="#" class="abrirModal"
										nomeCurso = "<?=$campos->nome?>"
										descricao = "<?=$campos->descricao?>"
										mestresCurso = "<?=$campos->mestres?>"
										data_inicial = "<?=$campos->data_inicial?>"
										data_encerramento = "<?=$campos->data_encerramento?>"
										publico_alvo = "<?=$campos->publico_alvo?>"
										conteudo_programatico = "<?=$campos->conteudo_programatico?>"
										
										
										>Veja as Informações do curso</a>
										</br></br>
										<?php
										if($campos->publico_alvo == '5'){
											echo '<spam class="card_public_servicos"><b>Somente Farmacêuticos inscritos</b></spam>';
										} elseif($campos->publico_alvo == '7'){
											echo '<spam class="card_public_servicos"><b>Farmacêuticos e estudantes</b></spam>';
										} elseif($campos->publico_alvo == '1'){
											echo '<spam class="card_public_servicos"><b>Publico Livre</b></spam>';
										} elseif($campos->publico_alvo == '9'){
											echo '<spam class="card_public_servicos"><b>Somente Estudantes</b></spam>';
										} 							
										if($campos->data_inicial != '' && $campos->data_inicial != '0000-00-00'){ 
											echo '<br>';
											echo '<spam class="card_tutor_servicos"><b>Inicio:</b> '.date('d/m', strtotime($campos->data_inicial)).'</spam>';
											
										}
										if($campos->data_encerramento != '' && $campos->data_encerramento != '0000-00-00'){
											
											echo '<spam class="card_tutor_servicos"><b> até:</b> '.date('d/m', strtotime($campos->data_encerramento)).'</spam>';
										}
										?>
									</p>
										<form action="<?=base_url()?>Capacitacao/Inscricao" method="POST" >
											<input type="hidden" value="<?=$campos->nome?>" name="txtCurso">
											<input type="hidden" value="<?=$campos->nome_curto?>" name="txtnomecurto">
											<input type="hidden" value="<?=$campos->courseid?>" name="txtcourseid">
											<input type="hidden" value="<?=$campos->menu_id?>" name="txtmenuid">
											<input type="hidden" value="<?=$campos->publico_alvo?>" name="txtpublicoalvo">
											<?php if($campos->status == "1"){ ?>
											
											<button class="btn btn-danger" type="submit" name='btnInscricao' >
												<span style="font-size:12px;text-align:center;"> 
													<i class='fa fa-pencil-alt'></i>&nbsp; Incrições Abertas
												</span>
											</button>
											<?php } else { ?>
											
											<button class="btn btn-danger" type="submit" name='btnInscricao' disabled>
												<span style="font-size:12px;text-align:center;"> 
													<i class='fa fa-pencil-alt'></i>&nbsp; Incrições fechadas
												</span>
											</button>
											<?php } ?>
										</form>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<!-- Fim Caixa de curso -->
				
				<?php } ?>
				
			</div>
        </div>
    </section>
<!-- Inicio do JS -->
<script>

$(function(){
	    
    $(".abrirModal").click(function(e){
		e.preventDefault();
		
		$("#modalNomeCurso").empty().html( $(this).attr('nomeCurso') );
		$("#modalDescricao").empty().html( $(this).attr('descricao') );
		$("#modalMestres").empty().html( $(this).attr('mestresCurso') );
		$("#modalDatainicio").empty().html( $(this).attr('data_inicial') );
		$("#modalDataFinal").empty().html( $(this).attr('data_encerramento') );		
		$("#modalConteudo").empty().html( $(this).attr('conteudo_programatico') );		
		
		$("#myModal").modal('show');
	});
		//Modal imageCursos
		$(".abrirModalImg").click(function() {
		 
			var url = $(this).find("img").attr("src");
			var alt = $(this).find("img").attr("alt");

			
			$(".modal-body").html('<img src="'+url+'" alt="" style="width:100%;  max-height:900px;">');
			$(".modal-title").html(''+alt+'');
			$('#myImgModal').modal('show');
		 
		});
	/*$(".abrirModalImg").click(function(e){
		e.preventDefault();
		$("#myImgModal").modal('show');
	});*/
});
</script>
	
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<h4 class="modal-title" id="modalNomeCurso" style="color:#006cc4;"></h4>
				<p><br></p>				
				<p><b>Professor(es):</b> <span id="modalMestres" ></span></p>
				<p><b>Data Inicio:</b> <span id="modalDatainicio" ></span></p>
				<p><b>Data Encerramento:</b> <span id="modalDataFinal" ></span></p>
				<p><br></p>
				<p style="line-height:1.3em;" id="modalDescricao"></p>
				<p style="line-height:1.3em;margin-left:30px;" id="modalConteudo"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<!-- The Modal -->

<script src="<?=base_url()?>assets/js/modal-image.js"></script>


<!-- Modal -->
<div class="modal fade" id="myImgModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>

	</div>
</div>


<!-- Inicio do JS -->
<script>
$(document).ready(function () {
    $(".content").hide();
    $(".show_hide").on("click", function () {
        var txt = $(".content").is(':visible') ? 'Read More' : 'Read Less';
        $(".show_hide").text(txt);
        $(this).next('.content').slideToggle(200);
    });
});
</script>



