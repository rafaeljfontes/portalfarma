<style>
	/* ====== CARD PRINCIPAL ====== */
.form-card {
  background-color: #ffffff;
  border-radius: 0.75rem;
  padding: 2rem;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
  max-width: 900px;
  margin: 0 auto;
}

/* ====== TÍTULO ====== */
.form-title {
  background-color: #0d6efd; /* azul Bootstrap */
  color: #ffffff;
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  font-size: 1.4rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
}

/* ====== TEXTO INTRODUTÓRIO ====== */
.form-texto {
  font-size: 0.95rem;
  color: #333;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  text-align: justify;
}

/* ====== LABELS ====== */
.form-label {
  font-weight: 500;
  color: #212529;
}

/* ====== INPUTS ====== */
.form-control,
.form-select {
  border-radius: 0.5rem;
}

/* ====== RADIO BUTTONS ====== */
.form-check {
  margin-right: 1.5rem;
}

.form-check-label {
  font-weight: 400;
}

/* ====== GRUPOS DE CAMPOS ====== */
.form-group {
  margin-bottom: 1rem;
}

/* ====== BOTÃO ====== */
.btn-enviar {
  padding: 0.6rem 2.5rem;
  font-size: 1rem;
  font-weight: 500;
  border-radius: 0.5rem;
}

/* ====== RESPONSIVO ====== */
@media (max-width: 576px) {
  .form-card {
    padding: 1.5rem 1rem;
  }

  .form-title {
    font-size: 1.2rem;
    text-align: center;
  }
}

</style>


<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
		<li class="breadcrumb-item">Inscrição de alunos</li>
		<li class="breadcrumb-item active" aria-current="page">Cadastro</li>
	</ol>
</nav>

<form action="<?=base_url()?>Capacitacao/InscricaoMeritoAcademico" method="POST">
	<div class="container box px-3 py-2">

        <!--  msg de retorno -->
			<?php if($this->session->flashdata('tipo') != ""){?>
			<div class="alert alert-<?=$this->session->flashdata('tipo');?>" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span style="font-size: 16px;"><?=$this->session->flashdata('msg');?></span>  
			</div>
			<?php } ?>
		<!--  fim msg de retorno -->

		<div class="form-card">
			<h2 class="form-title">
				Ficha de Solicitação da Comenda Lúcio Guedes Barra. </br>
			</h2>
			
			<div class="alert alert-info" role="alert" style="line-height:22px;">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<p class="form-texto">
					O Professor Lúcio Guedes Barra foi um dos principais personagens da profissão em nosso estado, desempenhando importante papel no ensino farmacêutico e no Conselho De Farmácia De Minas Gerais. Com dedicação e competência, encabeçou as principais lutas em favor do reconhecimento da profissão e ajudou a construir bases sólidas para a formação e atuação do farmacêutico.
					<br><br>
					Como homenagem à esta importante figura histórica da profissão, o CRF/MG criou a comenda de mérito acadêmico, prêmio Lúcio Guedes Barra, concedida presencial por um representante do conselho ao graduando de farmácia destaque da Instituição, durante a cerimônia de colação de grau.
					Para solicitar a participação do CRF/MG na entrega da medalha Lúcio Guedes Barra durante a colação de grau basta preencher o formulário de solicitação.

				</p>
			</div>
			
			<!-- dados pessoais -->
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-7 box_servicos">
					<div class="form-group">
						<label for="instituicao">Nome da Instituição</label> <input type="text"
							class="form-control" id="instituicao" name="instituicao"
							placeholder="Nome da Instituição de Ensino" value="" required>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-5 box_servicos">
					<div class="form-group">
						<label for="cidade">Cidade</label> <input type="text"
							class="form-control" id="cidade" name="cidade"
							placeholder="Cidade" value="" required>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-7 box_servicos">
					<div class="form-group">
						<label for="endereco">Endereço</label> <input type="text"
							class="form-control" id="endereco" name="endereco"
							placeholder="Endereço" value="" required>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-5 box_servicos">
					<div class="form-group">
						<label for="responsavel">Nome do Responsável</label> <input type="text"
							class="form-control" id="responsavel" name="responsavel" placeholder="Nome do responsável pela solicitação"
							value="" required>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-5 box_servicos">
					<div class="form-group">
						<label for="cargo_responsavel">Cargo do Responsável</label> <input type="text"
							class="form-control" id="cargo_responsavel" name="cargo_responsavel"
							placeholder="Cargo do responsável pela solicitação" value="" required>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 box_servicos">
					<div class="form-group">
						<label for="telefone">Telefone do Responsável</label> <input type="text"
							class="form-control" id="telefone_responsavel" name="telefone_responsavel"
							placeholder="Tel. do responsável" value="" required>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_servicos">
					<div class="form-group">
						<label for="email">Email do Responsável</label> <input type="text"
							class="form-control" id="email_responsavel" name="email_responsavel"
							placeholder="email do responsável pela solicitação" value="" required>
					</div>
				</div>			
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 box_servicos">
					<div class="form-group">
						<label for="data_evento">Data da Colação de Grau</label> <input type="date"
							class="form-control" id="data_evento" name="data_evento"
							placeholder="Data" value="" required>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-2 box_servicos">
					<div class="form-group">
						<label for="hora_evento">Horário </label> <input type="time"
							class="form-control" id="hora_evento" name="hora_evento"
							placeholder="Hora" value="" required>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
					<div class="form-group">
						<label for="local_cerimonia">local da Cerimônia </label> <input type="text"
							class="form-control" id="local_cerimonia" name="local_cerimonia"
							placeholder="Local onde a cerimônia será realizada" value="" required>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
					<div class="form-group">
						<label for="periodo">O representante do CRF/MG irá compor a mesa honra? </label> 
						<input type="radio" id="mesa_de_honra" name="mesa_de_honra" value="s">Sim
						<input type="radio" id="mesa_de_honra" name="mesa_de_honra" value="n">Não
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
					<div class="form-group">
						<label for="discurso_entrega">Haverá espaço para discurso/fala na estrega da medalha?</label> 
						<input type="radio" id="discurso_entrega" name="discurso_entrega" value="s">Sim
						<input type="radio" id="discurso_entrega" name="discurso_entrega" value="n">Não
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-12 box_servicos">
					<div class="form-group">
						<label for="graduando_homenageado">Nome do graduando homenageado. (se houver)</label> <input type="text"
							class="form-control" id="graduando_homenageado" name="graduando_homenageado"
							placeholder="Nome do graduando homenageado. (se houver)" value="" required>
					</div>
				</div>
				
			</div>

			<!-- send -->
			<div class="row my-5">
				<!-- Só gerar espaço -->
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
