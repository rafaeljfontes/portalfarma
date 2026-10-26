
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

        <div class="alert alert-secondary" role="alert">
            Um texto aqui referente ao Tipo do Capacifar....
        </div>

        <div class="row">
            <!-- Inicio Caixa de curso -->



            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <p style="font-size:0.9em; text-align:center;" class="mx-1">
                    <b>Site indisponível no momento...</b>
                    <br><br>
                    <b>Retornaremos em breve!!!</b>

                    <br><br>
                    <br><br>
                    <br><br>
                    <br><br>
                    <br><br>
                    <br><br>
                </p>
            </div>
            <!-- Fim Caixa de curso -->
<?php
   
   $cURL = curl_init();
    curl_setopt( $cURL, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/teste.php' );
    curl_setopt( $cURL, CURLOPT_POST, true );
    curl_setopt( $cURL, CURLOPT_POSTFIELDS, Array('cep' => '12898430668'));
    curl_setopt( $cURL, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($cURL);
    $resposta = json_decode(trim($result), true);
    var_dump($resposta);
	
?>

        </div>
    </div>
</section>





