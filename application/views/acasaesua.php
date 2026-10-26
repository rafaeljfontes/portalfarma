<?php

$form = false;

?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
		<li class="breadcrumb-item">Inscrição de alunos</li>
		<li class="breadcrumb-item active" aria-current="page">Cadastro</li>
	</ol>
</nav>
<?php 

if($form){ 
	
?>
<form action="<?=base_url()?>Capacitacao/InscricaoCasaESua" method="POST">
	<div class="container box px-3 py-2">
		
		<div class="alert alert-info" role="alert" style="line-height: 22px;">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p>
			Como bons mineiros, queremos reforçar que o CRF/MG é a casa do farmacêutico.<br><br>
			Por isso, estamos preparados para lhe receber em nossa nova casa.<br><br>
			“A CASA É SUA” é o programa de visitas técnicas à nova sede do CRF/MG, em que todas as primeiras quintas-feiras do mês abriremos as portas para receber farmacêuticos, estudantes e convidados.<br><br>
			Durante a visita, os participantes terão uma palestra institucional sobre o “O Conselho de Farmácia e a Profissão Farmacêutica”, além de visitarem as dependências do CRF/MG.<br><br>
			As inscrições devem ser feitas por meio do formulário disponível abaixo, indicando o data desejada para a visita.
			Inicialmente, por conta da pandemia, receberemos um grupo limitado a 15 pessoas, cuja participação é condicionada ao cumprimento das medidas de biossegurança e distanciamento.<br><br>
			Venha conhecer o CRF/MG porque A CASA É SUA!
			</p>
				
		</div>
		
        <!--  msg de retorno -->
			<?php if($this->session->flashdata('tipo') != ""){?>
			<div class="alert alert-<?=$this->session->flashdata('tipo');?>" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span style="font-size: 16px;"><?=$this->session->flashdata('msg');?></span>  
			</div>
			<?php } ?>
		<!--  fim msg de retorno -->
        
		<h2 class="title">
			Para efetuar sua inscrição no "A Casa é sua" do CRF/MG preencha o
			formulário abaixo: </br>
		</h2>
		<div class="alert alert-warning" role="alert">
            O sua inscrição será validada mediante a verificação previa.
        </div>

		<!-- dados pessoais -->
		<div class="row">
            <!--
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
				<div class="form-group">
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                            <option selected>Você é um(a)?</option>
                            <option value="5">Farmacêutica</option>
                            <option value="6">Estudante de Farmacia</option>
                            <option value="7">Tec. em Farmacia</option>
                            <option value="8">outros</option>
                        </select>
				</div>
			</div>
            -->
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-5 box_servicos">
				<div class="form-group">
					<label for="nome">Nome Completo</label> <input type="text"
						class="form-control" id="nome" name="nome"
						placeholder="Primeiro Nome" value="" required>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-7 box_servicos">
				<div class="form-group">
					<label for="cpf">CPF</label> <input type="text"
						class="form-control" id="cpf" name="cpf"
						placeholder="seu cpf" value="" required>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 box_servicos">
				<div class="form-group">
					<label for="crfmg">Nº registro CRF</label> <input type="text"
						class="form-control" id="crfmg" name="crfmg"
						placeholder="nº registro CRF/MG." value="" required>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_servicos">
				<div class="form-group">
					<label for="telefone">telefone</label> <input type="text"
						class="form-control" id="telefone" name="telefone"
						placeholder="telefone" value="" required>
				</div>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-5 box_servicos">
				<div class="form-group">
					<label for="email">E-mail</label> <input type="text"
						class="form-control" id="email" name="email"
						placeholder="email" value="" required>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 box_servicos">
				<label for="ocupacao">Ocupação</label>
				<div class="form-group">
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="ocupacao" name="ocupacao">
                            <option selected>Ocupação?</option>
                            <option value="1">Farmacêutico inscrito no CRF/MG</option>
                            <option value="2">Estudante de Farmácia</option>
                            <option value="3">Farmacêutico de outro estado</option>
                            <option value="4">Farmacêutico não inscrito no CRF/MG</option>
							<option value="5">Outros</option>
                        </select>
				</div>
			</div>
			
			
			<?php
			$dia = new DateTime();
			//$dia['date'] = '2021-06-30 13:34:07.571973';
			//print_r($dia);
				$dia->modify( 'next tuesday' );

				$nextMondaysNeed = range(1,10);
				$nextMondaysArray = array($dia->format('Y-m-d'));

				foreach($nextMondaysNeed as $number)
				{
					$nextMondaysArray[] = $dia->modify('+28 day')->format('Y-m-d');
				}

				//print_r($nextMondaysArray);
				$arraydatas = array('2021-08-05', '2021-09-02', '2021-10-07', '2021-11-04', '2021-12-02');
			?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 box_servicos">
				<div class="form-group">
					<label for="datavisita">Data</label>
					<select class="form-select form-select-lg mb-3" name="data_visita" id="data_visita" aria-label=".form-select-lg example">
                        <option selected>Selecione a Data?</option>
							
                            <?php
								//foreach($nextMondaysArray as $row){
								foreach($nextMondaysArray as $row){
							?>		
								<option value="<?=$row?>"><?=date('d/m/Y', strtotime($row));?></option>
							<?php
								}
							?>		
								
                    </select>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
				<div class="form-group">
					<label for="motivo">Motivo da visita </label> <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="motivo" name="motivo" required></textarea>
				</div>
			</div>

		</div>

		<!-- send -->
		<div class="row my-5">
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
				<input type="hidden" id="data_cadastro" name="data_cadastro" value="<?=date('Y/m/d');?>">
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
				<div class="form-group">
					<button type="submit" class="btn btn-success" id="btn-send">
						<i class="fas fa-check"></i> Enviar
					</button>
				</div>
			</div>


		</div>
		<!-- / send -->
       
        

    <?php echo form_close();?>
    
</div>
</form>
<?php } ?>
<script>
        $(function (){
            <?php
				if (validation_errors () != "") {
			?>
            new Toast({
                message: 'N�o foi poss�vel enviar os dados. Verifique o preenchimento do formul�rio.',
                type: 'danger'
            });
            <?php
				}
			?>
        });
</script>


<script>

    $(function(){
        /* iniciar a pagina chamando a function para setar o select do UF e cidades */
        toggleSelectNaturalidade( $("input[name=nacionalidade]:checked").val() );
        setSelectUf('uf_natural', 'naturalidade', "<?=$uf_natural_val?>", "<?=$naturalidade_val?>");
        setSelectUf('uf_instituicao_ensino', 'cidade_instituicao_ensino', "<?=$uf_instituicao_ensino_val?>", "<?=$cidade_instituicao_ensino_val?>");
        setSelectUf('uf_origem', 'cidade_origem', "<?=$uf_origem_val?>", "<?=$cidade_origem_val?>");
        setSelectUf('uf_titulo_eleitoral', 'cidade_origem', "<?=$uf_titulo_eleitoral_val?>", "<?=$cidade_origem_val?>");
        getInstituicaoEnsino();
        toggleUfOrigem();


        $("input[name=nacionalidade]").click(function(){
            toggleSelectNaturalidade( $(this).val() );
        });


        $("select[name='cidade_instituicao_ensino']").change(function(){
            getInstituicaoEnsino();
        });

        $("select[name='select_instituicao_ensino']").change(function(){
            if( $("select[name='select_instituicao_ensino'] option:selected").val() == "outro" ) {
                $("input[name='instituicao_ensino']").show();
            }else{
                $("input[name='instituicao_ensino']").hide();
            }
        });


        $("select[name='forma_ingresso']").change(function(){
            toggleUfOrigem();
        });

        function toggleUfOrigem() {
            if( $("select[name='forma_ingresso'] option:selected").val() == "Transfer�ncia" ) {
                $("#box_uf_origem").show();
            }else{
                $("#box_uf_origem").hide();
            }
        }
        



        function getInstituicaoEnsino() {
            
            var fd = new FormData();
            fd.append('uf', $("select[name='uf_instituicao_ensino'] option:selected").val() );
            fd.append('cidade', $("select[name='cidade_instituicao_ensino'] option:selected").val() );
           
            $.ajax({
                type: "POST",
                method: 'POST',
                url: "<?=base_url()?>inscricao_pf/getInstituicaoEnsino",
                data: fd,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                
                beforeSend: function(){
                    $("select[name='select_instituicao_ensino']").fadeOut('fast');
                },
                success: function(res){
                    // console.log(res);   
                }
                }).done(function( res ) {
                    // console.log(res);
                }).fail(function(res) {
                    // console.log(res);
                }).always(function( res ) {
                    $("select[name='select_instituicao_ensino']").fadeIn('fast');
                    $("select[name='select_instituicao_ensino']").removeAttr('disabled');
                    if(res != ""){
                        res.forEach(element => {
                            
                            var label = element.Sigla === null ? element.Instituicao : element.Sigla+" - "+element.Instituicao;
                            var value = element.InstituicaoId;

                            $("select[name='select_instituicao_ensino']").append('<option value='+value+'>'+label+'</option>');    
                        });                        
                        $("select[name='select_instituicao_ensino']").append('<option value="outro">Outros</option>');    
                    }
                });
        }

        function toggleSelectNaturalidade( nacionalidade ){
            $("#uf_natural").removeAttr("disabled", "disabled");
            $("#naturalidade").removeAttr("disabled", "disabled");
            setSelectUf('uf_natural', 'naturalidade', "<?=$uf_natural_val?>", "<?=$naturalidade_val?>");

            if(nacionalidade != "brasileiro"){
                $("#outra_nacionalidade").show();
                if(nacionalidade == "estrangeiro_nao_naturalizado"){
                    $("#uf_natural").html('<option>Selecione</option>').attr("disabled", "disabled");
                    $("#naturalidade").html('<option>Selecione</option>').attr("disabled", "disabled");
                }
            }else{
                $("#outra_nacionalidade").hide();
            }
        }

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
