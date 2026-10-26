<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conselho Regional de Farmácia - CRF/MG</title>
</head>
<body>

<section style="display:flex; justify-content: center; align-items:flex-start; align-content: flex-start;">

    <div>
    <img src="<?=base_url()?>assets/emails/default/header.png" alt="CRF/MG">
    <div>

    <article style="padding: 1% 5%;">
        
        <?php
            if(isset($user) && !empty($user)){
        ?>
        <div>
            <h2>Olá, <?=$user?> !</h2>
        </div>
        <?php } ?>

        <div style="text-align:center; font-size:1.3em;">
            <?=$body?>
        </div>

        
    </article>


    <div><hr></div>
    
    <div>
        <img src="<?=base_url()?>assets/emails/default/footer.png" alt="CRF/MG">
    <div>

    <div style="text-align:center;">
        
        Esse é um e-mail automático. não responder.
    </div>

</section>    

</body>
</html>