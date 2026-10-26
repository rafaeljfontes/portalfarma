	<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
		<li class="breadcrumb-item">Capacifar</li>
		<li class="breadcrumb-item active" aria-current="page">Interativo</li>
	</ol>
</nav>

<form action="<?=base_url()?>Capacitacao/Interativo" method="POST" id="formInscricao">
	<div class="container box px-3 py-2">

        <!--  msg de retorno -->
			<?php if($this->session->flashdata('tipo') != ""){?>
			<div class="alert alert-<?=$this->session->flashdata('tipo');?>" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span style="font-size: 16px;"><?=$this->session->flashdata('msg');?></span>  
			</div>
			<?php } ?>
		<!--  fim msg de retorno -->
		<p>
			<!--Objetivo: coletar dados de opinião sobre as áreas de mais interesse dos farmacêuticos, nas diferentes regiões do estado, para melhor planejamento das capacitações.-->
			<h5>Indique abaixo sua cidade e a sugira as áreas de maior interesse para capacitação.
			Com a sua ajuda, iremos criar um CRF/MG cada vez mais alinhado com você.</h5>
		</p>
        
		<h2 class="title">
			Capacifar Interativo: </br>
		</h2>
        <!--
		<div class="alert alert-warning" role="alert">
            O sua inscrição será validada mediante ao cadastro prévio na área de Acesso-Restrito do site do CRF/MG.
        </div>
        -->
        <?php if($this->session->flashdata('publicoalvo') == '5'){
            echo '<div class="alert alert-danger" role="alert">
               O Curso <b>'.$this->session->flashdata('curso').'</b> é permitido apenas para Farmacêuticos cadastrados no CRF/MG.
            </div>';
        }
        ?>
		<?php if(isset($mensagens)) echo $mensagens; ?>

		<!-- dados selecionavais -->
		<div class="row">
		
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
				<div class="form-group">
                        <select class="selectpicker form-control" aria-label=".form-select-lg example" id="publico" name="publico">
							<option selected>Você é um(a)?</option>
                            <option value="Farm.">Farmacêutico(a) do CRF/MG</option>
                            <option value="Estudante">Estudante de Farmacia</option>
                        </select>
				</div>
			</div>
            
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
				<div class="form-group">
					<label for="crfmg">Area de interresse</label>					
					<select class="selectpicker form-control" aria-label=".form-select-lg example" id="area" name="area">
						<?php
						var_dump($areaInteresse);
							foreach ($areaInteresse as $campos)
							{?>
								<option value="<?=$campos->id?>"><?=$campos->descricao?></option>
						<?php
							} 
						  ?>
                    </select>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
				<div class="form-group">
					<label for="uf_natural">Estado</label>
                    <select class="form-control <?=(form_error('uf_natural')) ? 'is-invalid' : ''; ?>" id="uf_natural" name="uf_natural">
                        <option selected value="MG">Minas Gerais</option>
                    </select>
                    <?=form_error('uf_natural','<small class="form-text text-muted label-error">', '</small>'); ?>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
				<div class="form-group">
					<label for="naturalidade">Cidade</label>
                    <select class="form-control <?=(form_error('naturalidade')) ? 'is-invalid' : ''; ?>" id="naturalidade" name="naturalidade">
                        <option selected disabled>Selecione</option>
                    </select>
                    <?=form_error('naturalidade','<small class="form-text text-muted label-error">', '</small>'); ?>
				</div>
			</div>
			
			<input type="hidden" id="data" name="data" value="<?=date("Y-m-d")?>" >
			<input type="hidden" id="ip_user" name="ip_user" value="<?=$_SERVER['REMOTE_ADDR']?>" >

			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-lg " id="btn-send">
							<i class="fas fa-check"></i> Enviar
						</button>
					</div>
			</div>
			
		</div>

    <?php echo form_close();
	
	
	?>
    
</div>
</form>
<script src="<?=base_url()?>assets/js/cidades-estados/cidades-estados.js"></script>
<script>
	$(function(){
        /* iniciar a pagina chamando a function para setar o select do UF e cidades */
		setSelectUf('uf_natural', 'naturalidade', "MG", "");	
        		
		function setSelectUf(select_estado, select_cidade, estadoVal, cidadeVal){
				new dgCidadesEstados({
					estado: document.getElementById(select_estado),
					cidade: document.getElementById(select_cidade),
					estadoVal,
					cidadeVal,
				});
			}
			
		$("#form-send").submit(function(){
            $("#btn-send").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
        });	
	});	
</script>


