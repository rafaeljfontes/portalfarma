<?php 

$dataatual = date("Y-m-d");

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>">HOME</a></li>
		<li class="breadcrumb-item">Relatórios</li>
		<li class="breadcrumb-item active" aria-current="page">Listagem</li>
	</ol>
</nav>
<style>
	.total{
		background-color: #ff9999;
		color: #0a0000;
		font-size: 30px;
		font-weight: bold;
	}
	
	h3{
		font-size: 26px;
		color: #c87e7e;
		font-weight: bold;
	}
</style>
<script>
$(document).ready(function(){
	$("#demo_pre").on("hide.bs.collapse", function(){
		$(".demo_pre").html('<span class="glyphicon glyphicon-collapse-down"></span> Cursos AVA Presenciais');
  });
  $("#demo_pre").on("show.bs.collapse", function(){
    $(".demo_pre").html('<span class="glyphicon glyphicon-collapse-up"></span> Cursos AVA Presenciais');
  });
	
  $("#demo_one").on("hide.bs.collapse", function(){
    $(".demo_one").html('<span class="glyphicon glyphicon-collapse-down"></span> Cursos AVA 2025');
  });
  $("#demo_one").on("show.bs.collapse", function(){
    $(".demo_one").html('<span class="glyphicon glyphicon-collapse-up"></span> Cursos AVA 2025');
  });
  
  $("#demo_two").on("hide.bs.collapse", function(){
    $(".demo_two").html('<span class="glyphicon glyphicon-collapse-down"></span> Seminários ');
  });
  $("#demo_two").on("show.bs.collapse", function(){
    $(".demo_two").html('<span class="glyphicon glyphicon-collapse-up"></span> Seminários');
  });
  
  $("#demo_thr").on("hide.bs.collapse", function(){
    $(".demo_thr").html('<span class="glyphicon glyphicon-collapse-down"></span> Fiscalização Humanizada');
  });
  $("#demo_thr").on("show.bs.collapse", function(){
    $(".demo_thr").html('<span class="glyphicon glyphicon-collapse-up"></span> Fiscalização Humanizada');
  });
  
  $("#demo_for").on("hide.bs.collapse", function(){
    $(".demo_for").html('<span class="glyphicon glyphicon-collapse-down"></span> Saúde da Mulher');
  });
  $("#demo_for").on("show.bs.collapse", function(){
    $(".demo_for").html('<span class="glyphicon glyphicon-collapse-up"></span> Saúde da Mulher');
  });
});
</script>

	<div class="container box px-3 py-2">
		
		<h2 class="title">
			 </br>
		</h2>
		
		
		<div class="container">
			<h2>Clique para ver o Relatórios</h2>
				<button type="button" class="btn btn-danger demo_pre" data-toggle="collapse" data-target="#demo_pre">
				  <span class="glyphicon glyphicon-collapse-down"></span> Cursos AVA Presenciais
				  </button>
				
				<button type="button" class="btn btn-danger demo_one" data-toggle="collapse" data-target="#demo_one">
				  <span class="glyphicon glyphicon-collapse-down"></span> Cursos AVA 2025
				</button>
				
				<button type="button" class="btn btn-danger demo_two" data-toggle="collapse" data-target="#demo_two">
				  <span class="glyphicon glyphicon-collapse-down"></span> Seminários
				</button>
				
				<button type="button" class="btn btn-danger demo_thr" data-toggle="collapse" data-target="#demo_thr">
				  <span class="glyphicon glyphicon-collapse-down"></span> Fiscalização Humanizada
				</button>
				
				<button type="button" class="btn btn-danger demo_for" data-toggle="collapse" data-target="#demo_for">
				  <span class="glyphicon glyphicon-collapse-down"></span> Saúde da Mulher
				</button>
			
			<!-- dados cursos AVA Presenciais-->
			<div id="demo_pre" class="collapse">
				<div class="row">
					<h3>Relatório Cursos AVA Presenciais</h3>
					<table class="table table-striped">
					  <thead>
						<tr>
						  <th scope="col">#</th>
						  <th scope="col">Nome</th>
						  <th scope="col">Quantidade Inscritos</th>
						  <th scope="col">Acessos ao AVA</th>
						  <th scope="col">Data de Abertura</th>
						  <!--<th scope="col">Data de Encerramentos</th>-->
						</tr>
					  </thead>
					  <tbody>
						<?php 
						
						
						//print_r($tabelaCursosAva);
						$indice = 1;
						if(empty($arraycursosPres)){
							echo "<tr><th colspan='7'>Nenhuma pesquisa cadastrada até o momento</th></tr>";
						} else {
						foreach($arraycursosPres as $r){ 
						
						?>
							<tr>
								<th scope="row"><?=$r['id']?></th>
								<td><?=$r['fullname']?></td>
								<td><?=$r['Inscritos']?></td>
								<td><?=$r['Acessos']?></td>
								<td><?=$r['Data_abertura']?></td>
								<!--<td></td>-->
							</tr>
						<?php 
						$indice++;
						} } ?>				
					  </tbody>
					</table>
				
				</div>
			</div>
			
			<div id="demo_one" class="collapse">
				<!-- dados cursos AVA -->
				<div class="row">
					<h3>Relatório Cursos AVA Liberados 2025</h3>
					<table class="table table-striped">
					  <thead>
						<tr>
						  <th scope="col">#</th>
						  <th scope="col">Nome</th>
						  <th scope="col">Quantidade Inscritos</th>
						  <th scope="col">Acessos ao AVA</th>
						  <th scope="col">Data de Abertura</th>
						  <!--<th scope="col">Data de Encerramentos</th>-->
						</tr>
					  </thead>
					  <tbody>
						<?php 
						
						
						//print_r($tabelaCursosAva);
						$indice = 1;
						if(empty($tabelaCursosAva)){
							echo "<tr><th colspan='7'>Nenhuma pesquisa cadastrada até o momento</th></tr>";
						} else {
						foreach($tabelaCursosAva as $r){ 
						
						?>
							<tr>
								<th scope="row"><?=$r['id']?></th>
								<td><?=$r['fullname']?></td>
								<td><?=$r['Inscritos']?></td>
								<td><?=$r['Acessos']?></td>
								<td><?=$r['Data_abertura']?></td>
								<!--<td></td>-->
							</tr>
						<?php 
						$indice++;
						} } ?>				
					  </tbody>
					</table>
				
				</div>
			</div>
			<div id="demo_two" class="collapse">
				<!-- dados cursos AVA -->
				<div class="row">
					<h3>Relatório Seminário de Vigilância e Saúde</h3>
					<table class="table table-striped">
					  <thead>
						<tr>
						  <th scope="col">Tipo Inscrição</th>
						  <th scope="col">Quantidade</th>
						</tr>
					  </thead>
					  <tbody>
						<?php 
						$valortotal = 0;
						if(empty($tabelaSeminario)){
							echo "<tr><th colspan='7'>Nenhuma pesquisa cadastrada até o momento</th></tr>";
						} else {
						
							foreach($tabelaSeminario as $r){
							 $valortotal += $r->qtd;
							?>
								<tr>
									<td scope="row"><?=$r->tipo?></td>
									<td><?=$r->qtd?></td>
								</tr>
							<?php 
							
							
							} 
							echo "<tr>
									<td class='total'>TOTAL</td>
									<td class='total'>".$valortotal."</td>
								</tr>";
							
							} ?>				
					  </tbody>
					</table>
				
				</div>
			</div>
			
			<div id="demo_thr" class="collapse">
				<!-- dados cursos AVA -->
				<div class="row">
					<h3>Relatório Seminário Fiscalização Humanizada - UNAÍ</h3>
					<table class="table table-striped">
					  <thead>
						<tr>
						  <th scope="col">Tipo Inscrição</th>
						  <th scope="col">Quantidade</th>
						</tr>
					  </thead>
					  <tbody>
						<?php 
						$valortotal = 0;
						if(empty($tabelaHumanizada)){
							echo "<tr><th colspan='7'>Nenhuma pesquisa cadastrada até o momento</th></tr>";
						} else {
						
							foreach($tabelaHumanizada as $r){
							 $valortotal += $r->quantdade;
							?>
								<tr>
									<td scope="row">Nº de Inscritos</td>
									<td><?=$r->quantdade?></td>
								</tr>
							<?php 
							
							
							} 
							echo "<tr class='total'>
									<td scope='row'>TOTAL</td>
									<td>".$valortotal."</td>
								</tr>";
							
							} ?>				
					  </tbody>
					</table>
				
				</div>
			</div>
			
			
			<div id="demo_for" class="collapse">
				<!-- dados cursos AVA -->
				<div class="row">
					<h3>Relatório Saúde da mulher e & Gestante</h3>
					<table class="table table-striped">
					  <thead>
						<tr>
						  <th scope="col">Tipo Inscrição</th>
						  <th scope="col">Quantidade</th>
						</tr>
					  </thead>
					  <tbody>
						<?php 
						$valortotal = 0;
						$farmatotal = 0;
						if(empty($tabelaSaudemulher)){
							echo "<tr><th colspan='7'>Nenhuma pesquisa cadastrada até o momento</th></tr>";
						} else {
						
							foreach($tabelaSaudemulher as $r){
							 $valortotal += $r->Qtd;
							?>
								<tr>
									<td scope="row"><?=$r->tipo_inscricao?></td>
									<td><?=$r->Qtd?></td>
								</tr>
							<?php 
							
							
							} 
							echo "<tr>
									<td  class='total'>TOTAL</td>
									<td  class='total'>".$valortotal."</td>
								</tr>";
							
							echo "<tr>
									<th colspan='2'>Somente Farmacêuticos inscritos no CRFMG</th>
								</tr>";
							foreach($tabelaSaudemulher_farmas as $f){
								$farmatotal += $r->Qtd;
								echo "<tr>
									<td >".$f->inscricao."</td>
									<td >".$f->Qtd."</td>
								</tr>";
							}
							echo "<tr>
									<td  class='total'>TOTAL</td>
									<td  class='total'>".$farmatotal."</td>
								</tr>";
							
						} ?>				
					  </tbody>
					</table>
				
				</div>
			</div>
		</div>		
		

		        

    <?php 
		
		echo form_close();?>
    
</div>