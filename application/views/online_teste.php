
<section class="mb-3" style="width:100%;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
                <li class="breadcrumb-item active" aria-current="page">Capacifar Online</li>
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
<section>
    <div class="container-fluid">

		<div class="alert alert-danger" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span style="font-size: 20px;">
				Se você já efetuou sua inscrição, acesse o curso <a href="https://ava.crfmg.org.br/" target="_blank"> clicando aqui</a>.
			</span>  
		</div>
		
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
			<!--<div class="alert alert-<?=$this->session->flashdata('tipo');?>" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span style="font-size: 16px;">
					Capacifar Interativo ("<a href="<?=base_url()?>Interativo"> Sugestão aqui</a>")
				</span>  
			</div>
		  fim msg de retorno -->
		
        <div class="row">
            <!-- Inicio Caixa de curso -->
           
            <section id="region-fp-utility" class="fp-utility" data-region="blocks-fp-utility" aria-label="Blocks" style="background-color:#fdfeff; width: 98%; margin-left: 1%;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <aside id="block-region-fp-utility" class="block-region" data-blockregion="fp-utility" data-droptarget="1"><a href="#sb-3" class="sr-only sr-only-focusable">Skip Our Featured Courses</a>

<section id="inst248"
     class=" block_purity_courses_pro block block_not_card style1  card"
     role="complementary"
     data-block="purity_courses_pro"
          aria-labelledby="instance-248-header"
     >

    <div class="card-header">
        <div class="card-header-inner">

            <h3 id="instance-248-header" class="card-title mb-0">Capacifar Online</h3>

        </div>    
    </div>
	<script>
		$(document).ready(function() {
		  $('#categoria').change(function() {
			$('#busca_categoria').submit();
		  });
		});
	</script>
    <div class="card-body">

        <div class="card-text content">
            <div class="container-fluid tertiary-navigation" id="action_bar">
				<div class="row" id="yui_3_17_2_1_1745680399732_22">
						<!--<div class="navitem" id="yui_3_17_2_1_1745680399732_21">
							<div class="urlselect text-truncate w-100" id="categoria_select">
								<form method="post" action="<?=base_url()?>Online_teste/categoria" class="form-inline" id="busca_categoria">
									<label for="categoria" class="sr-only">
										Course categories
									</label>
									<select id="categoria" class="custom-select urlselect text-truncate w-100" name="categoria" >
										<option value="" selected="">Busque por Categorias</option>
										<option value="todas">Todas Categorias</option>
										<?php foreach($tabelaCategoria as $categoria){ ?>
												<option value="<?=$categoria->categoria;?>"><?=$categoria->categoria;?></option>
										<?php } ?>
									</select>										
								</form>
							</div>
						</div>
						<div class="navitem" id="yui_3_17_2_1_1745680399732_29">
							<div class="simplesearchform " id="yui_3_17_2_1_1745680399732_28">
								<form autocomplete="off" action="https://demo.purity-moodle-theme.com/classic/course/search.php" method="get" accept-charset="utf-8" class="mform form-inline simplesearchform" id="yui_3_17_2_1_1745680399732_27">
								<div class="input-group" id="yui_3_17_2_1_1745680399732_26">
									<label for="searchinput-680cf82f2c782680cf82f25b7c3">
										<span class="sr-only">Buscar Cursos</span>
									</label>
									<input type="text" id="searchinput-680cf82f2c782680cf82f25b7c3" class="form-control" placeholder="Search courses" aria-label="Search courses" name="search" data-region="input" autocomplete="off" value="">
									<div class="input-group-append" id="yui_3_17_2_1_1745680399732_31">
										<button type="submit" class="btn  btn-primary search-icon" id="yui_3_17_2_1_1745680399732_30">
											<i class="icon fa fa-search fa-fw " aria-hidden="true"></i>
											<span class="sr-only">Buscar Cursos</span>
										</button>
									</div>
							
								</div>
								</form>
								</div>            
						</div>-->
				</div>
			</div>
	    	<div class="courses-pro-container">
	    		
				<div class="purity-block-intro">
					<h3 class="block-main-title">Capacifar Online</h3>
					<div class="block-title-separator"></div>
					<div class="block-subtitle">
						Aliando inovação e tecnologia o Capacifar Online amplia as oportunidades de capacitação a todos os farmacêuticos e estudantes de Farmácia do estado. Por isso, o Capacifar Online conta com cursos EaD cuidadosamente estruturados, para que você desenvolva habilidades e competências necessárias para o aprimoramento profissional. 
						<!--
						São duas modalidades de cursos:
						<br><br>
						O <b>Capacifar Online tutor</b> – cursos que contam com aulas/tutorias remotas com o professor. Por isso, o Capacifar Online tutor tem turmas limitadas e um cronograma definido.
						<br><br>
						O <b>Capacifar Online smart</b> – cursos autoinstrucionais, sem tutoria remota, onde você tem a liberdade de iniciar e finalizar o curso quando e onde quiser.
						-->
					</div>
				</div>
			
	    		<div class="container">
					<div class="row">
						<?php 
							
							foreach ($tabelaCurso as $campos){ 
								$campo_informacoes = substr($campos->informacoes, 0, 80);
								
							?>
						<!-- INICIO QUADRO CURSO -->
						
						<div class="col-4">
							<div class="card_cursos">
								<div class="card">
									
								<a href="<?=base_url()?>Curso/Listar/<?=$campos->course_id;?>">
									<div class="course-image card-img-top" style="background-image: url(<?=base_url()?>assets/img/cursos/<?=$campos->nome_curto;?>.png); height: 200px;">
										
									</div>
								</a>
									<span class="course-price-badge course-free bg-success show-top">
										<?=$campos->categoria;?></span>
									<div class="card-body">
										<h3 class="course-title">
											<a href="<?=base_url()?>Curso/Listar/<?=$campos->course_id;?>">
												<?=$campos->nome_curso;?>
											</a>
										</h3>
										<div class="course-summary" style="font-size:font-size: 0.9em;"><?=$campo_informacoes;?>[...]</div>
										
									</div>
									
									<div class="card-footer">
										<div class="course-ec-container">											
											<div class="course-category" data-toggle="tooltip" title="Category">
												<i class="fa fa-folder fa-fw icon" aria-hidden="true"></i>
												<a href="<?=base_url()?>Online_teste/categoria/<?=$campos->categoria;?>"><?=$campos->categoria;?></a>
											</div>
													
											<div class="course-enrolments" data-toggle="tooltip" title="Students Enrolled">
												<i class="fa fa-users fa-fw icon" aria-hidden="true"></i>
												3
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						
						<!-- FIM QUADRO CURSO -->
						<?php } ?>
					</div>
				</div>
	    		
            <div class="footer"></div>
            
        </div>

    </div>

</section>
            <!-- Fim Caixa de curso -->

            
        </div>
    </div>
</section>


<!-- Modal Success/Whatsapp-->
<div class="modal fade" id="modal_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header text-justify">
				<?php 
					if(!empty($this->session->flashdata('success'))) {
				?>
					<h5 class="modal-title text-justify" id="exampleModalLongTitle" style="color: #0a7d10;*/">Atenção!!!</h5>				
				<?php } else { ?>
					<h5 class="modal-title" id="exampleModalLongTitle" style="color: #0a7d10;*/">Inscrição realizada com sucesso!</h5>
				<?php } ?>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" role="alert">
				  
					<h5><?=$this->session->flashdata('msg');?></h5>
					
					<p>
						<span style="font-size: 16px;">
							Para acessar o <b>AVA</b> ("<a href="https://ava.crfmg.org.br/" target="_blank">https://ava.crfmg.org.br/</a>"), insira o seu CPF nos campos de usuário e senha.
						</span>
					</p>
				</div>
				
				<hr>
				<div class="container">
					<div class="alert alert-info" role="alert">
						<div class="row">
							<div class="col-4">
								<img  src="https://www.crfmg.org.br/portalfarma/assets/img/whatsapp_icon.png" style="max-height:80px;" alt="Whatsapp logo" />							
							</div>
							<div class="col-9">
								<p style="line-height: 1.5;">
									Confira novidades em primeira mão e <b>CONFIRME SUA PRESENÇA</b> em nosso grupo exclusivo desta capacitação.
								</p>
								<a href="<?=$this->session->flashdata('link');?>" class="tooltip-test" title="Link Whatsapp"><button style="background: #069cc2; border-radius: 6px; padding: 15px; cursor: pointer; color: #fff; border: none; font-size: 16px; width: 250px;">Clique aqui</button></a>
							</div>
						</div>					
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Success/Whatsapp-->
<!-- Inicio do JS -->
<script>

$(function(){
	
	<?php if($teste != ""):
	//if($this->session->flashdata('tipo') != ""): ?>
   
		$("#modal_alert").modal('show');
	
	<?php endif ?>
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
				<p style="line-height:1.3em;" id="modalDescricao"></p>
				<p style="line-height:1.3em;margin-left:30px;" id="modalConteudo"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
	




