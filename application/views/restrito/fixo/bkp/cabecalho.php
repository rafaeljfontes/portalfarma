<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?=base_url()?>assets/imagens/logo/logo.png">
   
    <!-- Bootstrap  v5.3.3 -->
    <link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    
    <!-- sweetalert2 -->
    <link href="<?=base_url()?>assets/plugins/sweetalert/css/sweetalert2.min.css" rel="stylesheet"> 

    <!-- select2 -->
    <link href="<?=base_url()?>assets/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- fontawesome -->
    <link href="<?=base_url()?>assets/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- toast -->
    <link href="<?=base_url()?>assets/plugins/toast/css/jquery.growl.css" rel="stylesheet" type="text/css" />

    <!-- datatables -->
    <link href="<?=base_url()?>assets/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />

    <!-- jquery-3.7.1 -->
    <script src="<?=base_url()?>assets/plugins/jquery/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap  v5.3.3 -->
    <script src="<?=base_url()?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- sweetalert2 -->
    <script src="<?=base_url()?>assets/plugins/sweetalert/js/sweetalert2.all.min.js"></script>

    <!-- select2 -->
    <script src="<?=base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>

    <!-- fontawesome -->
    <script src="<?=base_url()?>assets/fontawesome/js/all.min.js"></script>

    <!-- toast -->
    <script src="<?=base_url()?>assets/plugins/toast/js/jquery.growl.js" type="text/javascript"></script>
       
    <!-- datatables -->
    <script src="<?=base_url()?>assets/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        :root {
            --backgroud: #f8f8fc;
        }
    </style>
    <title>6º CMF</title>
</head>

<body style="background-color: var(--backgroud); display: flex; flex-direction: column; min-height: 100vh; ">

    <header class="container-fluid py-3 border-bottom bg-white">
        <div class="container">
            
            <div class="d-flex" style="justify-content: space-between; align-items: center;">
                <div class="col">
                   <h3> Acesso Restrito - VI FÓRUM DE FARMÁCIA CLÍNICA DO SUS</h3>
                </div>
                <div style="display: flex; flex-direction: column; align-self: center; align-items: center;">
                    <div class="dropdown" style="width: 45px; height: 45px; border-radius: 50%; border:1px solid rgba(0,0,0,0.3);">
                        <div  data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                            <img src="<?=base_url()?>assets/imagens/avatar/default.png" class="img-fluid" alt="AVATAR" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?=base_url()?>sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                        </ul>
                    </div>
                    <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                        <?=$this->session->userdata('usuario_logado')['usuario'] ?? ''?>
                    </div>
                </div>
            </div>
        </div>
    </header>


<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-md-block bg-white vh-100 sidebar collapse border-end" id="menuEsquerda">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a  href="<?=base_url()?>restrito" class="nav-link <?=isset($menu_ativo) && $menu_ativo=='inicio' ? 'bg-primary text-white' :''?>">
                            Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a  href="<?=base_url()?>restrito/palestrantes" class="nav-link <?=isset($menu_ativo) && $menu_ativo=='palestrantes' ? 'bg-primary text-white' :''?>">
                            Palestrantes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a  href="<?=base_url()?>restrito/inscritos/sem-status" class="nav-link <?=isset($menu_ativo) && $menu_ativo=='inscritos' ? 'bg-primary text-white' :''?>">
                            Inscritos
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main style="flex: 1;">
            <nav class="navbar navbar-light bg-light d-md-none">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuEsquerda" aria-controls="menuEsquerda" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <div class="mb-4"></div>
            