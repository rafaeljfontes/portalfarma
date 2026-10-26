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
</style>
<section>
    <div class="container-fluid">

        <div class="alert alert-secondary" role="alert" style=" line-height: 22px;">
            <p>
				Olá, <?=$campos->nome?>!

				Você se inscreveu no curso <?=$campos->curso?>!
			</p>
        </div>
		
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 box_servicos">
                <div class="card_servicos">
                    <div class="container">
                        <div class="row">
							
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim Caixa de curso -->
            
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
	




