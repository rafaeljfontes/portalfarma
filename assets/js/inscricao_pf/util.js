
$(function(){
    

    $('form').attr('autocomplete', 'off');

    $(':input').inputmask();
    $('.mask_cpf').inputmask("999-999-999.99");
    $('.mask_phone').inputmask("(99) 9999[9]-9999");
    $('.mask_cep').inputmask("99999-999");

    $(".mask_phone").change(function(){
        var phone = $(this).val().replace(/([^\d])+/gim, '');
        
        if(phone.length == 10){
           var new_phone = "("+phone.substr(0, 2)+") "+phone.substr(2, 4)+"-"+phone.substr(6, 4);
           $(this).val(new_phone);
        }

    });

   
    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        if ($(this).val() == "") {
            limpar_endereco();
        }else{

            var cep = $(this).val().replace(/([^\d])+/gim, '');

            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                limpar_endereco();
                $(".input-loader").css("display","block");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    sleep(100);
                    if (("erro" in dados)) {
                        limpar_endereco();
                        console.log("CEP não encontrado.");
                    }else {

                        $("#logradouro").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);

                        if(dados.logradouro == ""){
                            $("#logradouro").attr("readonly", false);
                        }
                        if(dados.bairro == ""){
                            $("#bairro").attr("readonly", false);
                        }
                        if(dados.cidade == ""){
                            $("#cidade").attr("readonly", false);
                        }
                        if(dados.uf == ""){
                            $("#uf").attr("readonly", false);
                        }

                    }
                })
                .done(function() {
                    console.log( "second success" );
                })
                .fail(function() {
                    limpar_endereco();
                    console.log( "error" );
                })
                .always(function() {
                    $(".input-loader").css("display","none");
                    console.log( "complete" );
                    
                });

            }else {
                //cep é inválido.
                limpar_endereco();
                console.log("Formato de CEP inválido.");
            }
        } //end if.
     
    });

    function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds){
            break;
            }
        }
    }
    
   

    function limpar_endereco(){
        $("#logradouro").val("").attr("readonly", true);
        $("#bairro").val("").attr("readonly", true);
        $("#cidade").val("").attr("readonly", true);
        $("#uf").val("").attr("readonly", true);
    }

    
});



