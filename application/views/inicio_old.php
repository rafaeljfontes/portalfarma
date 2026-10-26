    
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
	color:#FFF;
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
        /*
		max-width: 400px;
        margin: 5%;
        border-radius: 10px;
		*/
		height: 450px;
		border-radius: 15px;
		margin-bottom: 3%;
        background: #eee;
    }

    .card_icon_servicos{
        background: #dc3545;
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

    .card_description_servicos{
        padding: 5%;
        font-size: 1em;
        line-height: 20px; 
		/* height: 170px; */
    }

    .card_button_servicos{
        position: absolute;
        margin-left:150px;
        bottom: 30px;
        text-align:center;
        width: 60%;
		
    }
	
	#botao{ 
		text-align: center; 
		background-color: #12455e; 
		color:#fff !important;
		margin-bottom: 10px;
	}
	

    @media screen and (max-width: 600px) {
        .title_search{
            font-size: 1em; 
            line-height: 22px; 
        }
    }
	
	#alertava{
		/*background-color: #F8F8FF !important;*/
		background-color: #04043b !important;
		color: #FFF !important;
	}
	
	.card_image img{
		/*margin-left:35px;*/
		max-width:320px;
		/*margin: auto;*/
		margin: 10px 38px 10px;
		display: block;
	}
	

</style>
<script>
$('.carousel').carousel({
  interval: 2000
})
</script>

    <section class="mb-3" style="width:100%;">

        <!--<div class="container-fluid" style="padding:0!important; margin:0!important; background: url('<?=base_url()?>assets/home_search.png') no-repeat center center; background-size: cover; height: 270px;">
            
            <div class="row box_search">
                <div class="box_item title_search col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-5">
                Agora o Conselho Regional de Farmácia de Minas Gerais oferece aos farmacêuticos mineiros
                uma área exclusiva para aprimorar seus conhecimentos.
                </div>
                
            </div>

        </div>-->
		
		<div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item">
				  <a href="https://www.crfmg.org.br/portalfarma/Interativo">
					<img class="d-block w-100" src="<?=base_url()?>assets/img/portal-farma-interativo-2022-banner.png" alt="Primeiro Slide">
				  </a>
				</div>
				
				<div class="carousel-item active">
					<a href="https://ava.crfmg.org.br">
						<img class="d-block w-100" src="<?=base_url()?>assets/img/portal-farma-2022-banner-principal-tela1.png" alt="Segundo Slide">
					</a>
				</div>
				
				<div class="carousel-item">
				  <a href="https://ava.crfmg.org.br">
					<img class="d-block w-100" src="<?=base_url()?>assets/img/portal-farma-2022-banner-principal-tela2.png" alt="Terceiro Slide">
				  </a>
				</div>
				
			</div>
				<a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Anterior</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Próximo</span>
				</a>
		</div>
            
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 box_servicos">
					<div class="alert alert-warning" role="alert"  style=" line-height: 22px;">
					<span style="font-size: 20px;text-align:center;">
						Sugira as áreas de maior interesse para capacitação <a href="https://www.crfmg.org.br/portalfarma/Interativo" target="_blank"> Capacifar Interativo</a>.
					</span>
					</div>
				</div>-->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 box_servicos">
					<a href="https://ava.crfmg.org.br/" target="_blank">
						<div class="alert text-center" role="alert" id="alertava"  style=" line-height: 42px;">
							<span style="font-size: 20px;text-align:center;">
								Acesse o conteúdo dos Cursos no <b>AVA</b>  clicando aqui.
							</span>
						</div>
					</a>
				</div>
			</div>
			
			
			
        </div>
    </section>