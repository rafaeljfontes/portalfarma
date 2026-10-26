<link rel="stylesheet" href="<?=base_url('assets/plugins/select2/select2.bundle.css')?>">
<script src="<?=base_url('assets/plugins/select2/select2.bundle.js')?>"></script>
<style>
body{
    font-family: Arial, sans-serif;
    background:#f4f6f9;
    margin:0;
    padding:20px;
}

.container{
    max-width:900px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:8px;
    box-shadow:0 0 15px rgba(0,0,0,0.05);
}

h2{
    margin-bottom:20px;
}

select, input, textarea{
    width:100%;
    padding:8px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

textarea{
    resize:vertical;
}

.programacao-item{
    border:1px solid #ddd;
    padding:20px;
    border-radius:6px;
    margin-bottom:20px;
    background:#fafafa;
    position:relative;
}

.btn{
    padding:10px 15px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.btn-add{
    background:#28a745;
    color:white;
}

.btn-remove{
    background:#dc3545;
    color:white;
    position:absolute;
    top:10px;
    right:10px;
}

.btn-submit{
    background:#007bff;
    color:white;
    width:100%;
    font-size:16px;
}

#curso_id + .select2-container {
    width:100% !important;
    margin-top:5px;
    margin-bottom:15px;
}

.select2-container .select2-search__field {
    margin:0 !important;
    padding:4px !important;
}
</style>

<div class="container">

<h2>Inserir Programação</h2>

<form method="POST" id="formUpdate">

    <label>Selecione o Curso</label>
    <select name="curso_id" id="curso_id" required>
        <option value="">Selecione ou digite o código ou nome do curso</option>
		<?php foreach($cursos as $linha): ?>
			<option value="<?=htmlspecialchars($linha->courseid, ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($linha->courseid . ' - ' . $linha->titulo, ENT_QUOTES, 'UTF-8')?></option>
		<?php endforeach; ?>
    </select>

    <div id="programacoes"></div>

    <button type="button" id="btnAdd" class="btn btn-add">
        + Acrescentar Programação
    </button>

    <br><br>
	
	 <div id="box_retorno"></div>
	
    <button type="submit" class="btn btn-submit">
        Salvar Programação
    </button>

</form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const selectCurso = document.getElementById('curso_id');

	function normalizarBusca(texto) {
		return (texto || '')
			.toString()
			.normalize('NFD')
			.replace(/[\u0300-\u036f]/g, '')
			.toLowerCase()
			.trim();
	}

	if (window.jQuery && jQuery.fn.select2) {
		jQuery(selectCurso).select2({
			placeholder: 'Selecione ou digite o código ou nome do curso',
			allowClear: true,
			width: '100%',
			matcher: function (params, data) {
				const busca = normalizarBusca(params.term);
				if (!busca) return data;

				const textoCurso = normalizarBusca(data.text);
				const palavras = busca.split(/\s+/).filter(Boolean);
				return palavras.every(function (palavra) {
					return textoCurso.indexOf(palavra) !== -1;
				}) ? data : null;
			}
		});
	}
});

$("#formUpdate").submit(async function(e) {
	
	e.preventDefault();
				console.log('Programando...');
				
			try {
				var form = document.getElementById("formUpdate");
				var fd = new FormData(form);
				console.log(fd);

				const result = await $.ajax({
						type: "POST",
						url: '<?=base_url()?>restrito/programacao/salvar',
						data: fd,
						dataType: 'html',
						enctype: "multipart/form-data",
						contentType: false,
						processData: false,
						beforeSend: function() {
							console.log('Enviando programação...');
						}
					})
					.done(function(res) {
						console.log('Sucesso:', res);
					})
					.fail(function(res) {
						console.log('Erro na requisição:', res);
					})
					.always(function(res) {
						console.log('retorno:', res);
						var retorno = typeof res === "string" ? JSON.parse(res) : res;
						if(retorno.type == "sucess"){
							$("#box_retorno").html('<div class="alert alert-success">'+retorno.message+'</div>');
						} else {
							$("#box_retorno").html('<div class="alert alert-danger">'+retorno.message+'</div>');
						}
					});

				return result;
			} catch (error) {
				console.log('Erro geral:', error);
				return false;
			}	
	});
</script>
<script>
$(document).ready(function(){

    let contador = 0;

    // Adicionar programação
    $('#btnAdd').click(function(){

        contador++;

		let html = `
			<div class="programacao-item">
				<h3 style="margin-top:0; margin-bottom:15px;">Programação #${contador}</h3>
				<button type="button" class="btn btn-remove">X</button>
				<label>Data e Hora Inicial</label>
				<input type="datetime-local" name="programacao[${contador}][inicio]" required>
				<label>Data e Hora Final</label>
				<input type="time" name="programacao[${contador}][fim]" required>
				<label>Título</label>
				<input type="text" name="programacao[${contador}][titulo]" required>
				<label>Descrição / Palestrantes</label>
				<textarea name="programacao[${contador}][descricao]" rows="4"></textarea>
			</div>`;
		
        $('#programacoes').append(html);
    });

    // Remover programação (delegação de evento)
    $('#programacoes').on('click', '.btn-remove', function(){
        $(this).closest('.programacao-item').remove();
    });

});
</script>
