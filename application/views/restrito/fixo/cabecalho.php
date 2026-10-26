<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?=base_url()?>assets/imagens/logo/logo.png">
   
    
    <!-- fontawesome -->
    <link href="<?=base_url()?>assets/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- jquery-3.7.1 -->
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	
	<!-- Popper (somente Bootstrap 4) -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap  v5.3.3 -->
    <link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/restrito/painel.css?v=tailadmin-1">
    <script src="<?=base_url()?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    
	<!-- Icons -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
	
	<!-- SweetAlert2 CDN -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        :root {
    --sidebar-width: 260px;
    --primary-gradient: linear-gradient(135deg, #054589 0%, #0d6efd 100%);
    --bg-light: #f4f7fa;
    --text-muted: #8391a2;
	}

	body { background-color: var(--bg-light); font-family: 'Inter', sans-serif; }

	/* HEADER SUPREME */
	.header-supreme {
		background: #ffffff;
		box-shadow: 0 2px 15px rgba(0,0,0,0.05);
		z-index: 1030;
	}

	.user-profile-btn {
		background: #f8f9fa;
		border-radius: 50px;
		padding: 5px 15px 5px 5px;
		transition: all 0.3s ease;
		border: 1px solid #eee;
	}

	.user-profile-btn:hover { background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }

	/* SIDEBAR SUPREME */
	.sidebar {
		width: var(--sidebar-width);
		background: #ffffff;
		box-shadow: 4px 0 10px rgba(0,0,0,0.02);
		border-right: 1px solid #edf2f9 !important;
	}

	.sidebar-title {
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		color: var(--text-muted);
		padding: 20px 25px 10px;
		display: block;
		letter-spacing: 1.2px;
	}

	.sidebar-link {
		display: flex;
		align-items: center;
		padding: 12px 25px;
		color: #555;
		text-decoration: none;
		font-weight: 500;
		transition: all 0.2s ease;
		border-left: 3px solid transparent;
		margin: 2px 0;
	}

	/* Ícones Coloridos e Efeitos */
	.sidebar-link i {
		font-size: 1.2rem;
		margin-right: 12px;
		transition: transform 0.3s ease;
	}

	/* Cores específicas por categoria para ícones */
	.bi-speedometer2 { color: #0d6efd; }
	.bi-gear { color: #6610f2; }
	.bi-mortarboard { color: #fd7e14; }
	.bi-people { color: #20c997; }
	.bi-heart-pulse { color: #dc3545; }
	.bi-flask { color: #0dcaf0; }

	.sidebar-link:hover {
		background: rgba(13, 110, 253, 0.05);
		color: #0d6efd;
		border-left: 3px solid #0d6efd;
	}

	.sidebar-link:hover i { transform: scale(1.2); }

	.sidebar-link.active {
		background: var(--primary-gradient);
		color: white !important;
		border-left: 3px solid #054589;
	}

	.sidebar-link.active i { color: white !important; }

	.menu-count-badge {
		min-width: 22px;
		height: 22px;
		padding: 0 7px;
		margin-left: auto;
		border-radius: 999px;
		background: #dc3545;
		color: #fff;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-size: 11px;
		font-weight: 700;
		line-height: 1;
	}

	/* Submenus */
	.submenu { background: #fcfdfe; padding-left: 15px; }
	.sidebar .collapse {
		visibility: visible;
	}
	.sidebar .collapse:not(.show) {
		display: none;
	}
	.sidebar .collapse.show {
		display: block;
	}
	.submenu a {
		padding: 8px 25px 8px 45px;
		font-size: 0.9rem;
		color: #777;
		display: block;
		text-decoration: none;
		transition: 0.2s;
		position: relative;
	}

	.submenu a::before {
		content: "•";
		position: absolute;
		left: 30px;
		color: #ddd;
	}

	.submenu a:hover { color: #0d6efd; }

	.arrow::after {
		content: "\F282"; /* Bootstrap icon chevron */
		font-family: "bootstrap-icons";
		float: right;
		transition: 0.3s;
		font-size: 0.8rem;
	}

	.sidebar-link[aria-expanded="true"] .arrow::after { transform: rotate(180deg); }
    </style>
    <title>Restrito PortalFarma</title>
</head>

<body style="background-color: var(--backgroud); display: flex; flex-direction: column; min-height: 100vh; ">
<?php
	$totalUniversitarioPendente = $this->db
		->where('status', 0)
		->from('web_site.tbl_capacifar_universitario')
		->count_all_results();

	$totalMeritoPendente = $this->db
		->where('status', 0)
		->from('merito_academico')
		->count_all_results();

	$permissoesMenu = portalfarma_permissoes($this->session->userdata('permissao'));
	$totalAtitudePendente = 0;
	if (in_array('atitudes', $permissoesMenu, true)) {
		$debugAtitude = $this->db->db_debug;
		$this->db->db_debug = false;
		try {
			$consultaAtitude = $this->db->query('SELECT COUNT(*) AS total FROM web_site.tbl_atitudefarmaceutica_inscricao WHERE status = 0');
			if ($consultaAtitude) {
				$totalAtitudePendente = (int) $consultaAtitude->row()->total;
			}
		} finally {
			$this->db->db_debug = $debugAtitude;
		}
	}
?>

	<header class="container-fluid py-3 border-bottom bg-white header-supreme sticky-top">
        <div class="container">
            
            <div class="d-flex" style="justify-content: space-between; align-items: center;">
                <div class="col">
                   <h5 class="mb-0 fw-bold text-primary">PORTAL<span class="text-dark">FARMA</span> <small class="text-muted fw-light fs-6 ms-2">| Acesso Restrito</small></h5>
                </div>
                <div class="dropdown">
					<div class="user-profile-btn d-flex align-items-center" data-bs-toggle="dropdown" style="cursor:pointer;">
						<img src="<?=base_url()?>assets/palestrantes/avatar_palestrante.png" alt="AVATAR" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;" class="me-2">
						<div class="d-none d-md-block">
							<span class="d-block fw-bold small" style="line-height: 1;"><?=explode(' ', (string) ($this->session->userdata('usuario_logado')['nome'] ?? 'Usuário'))[0]?></span>
							<small class="text-muted" style="font-size: 10px;">Administrador</small>
						</div>
					</div>
					<ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
						<li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Perfil</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item py-2 text-danger" href="<?=base_url()?>restrito/login/sair"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
					</ul>
				</div>
            </div>
        </div>
    </header>


<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-md-block bg-white vh-100 sidebar collapse border-end" id="menuEsquerda">
            <div class="position-sticky pt-3">
				<?php if (in_array('dashboard', $permissoesMenu, true)) { ?>
				<a href="<?=base_url()?>restrito/inicio" class="sidebar-link active">
					<i class="bi bi-speedometer2"></i>
					Dashboard
				</a>
				<?php } ?>
				<a href="<?=base_url()?>restrito/calendario" class="sidebar-link">
					<i class="bi bi-calendar"></i>
					Calendário
				</a>
				<?php if (in_array('capacifar', $permissoesMenu, true)) {?>
				<span class="sidebar-title">CAPACIFAR</span>
					<a class="sidebar-link"
					   data-bs-toggle="collapse"
					   href="#menuCapacitacoes"
					   role="button"
					   aria-expanded="false">
						<i class="bi bi-gear"></i>
						Capacitações
						<span class="arrow"></span>
					</a>

					<div class="collapse submenu" id="menuCapacitacoes">
						<a href="<?=base_url()?>restrito/capacifar/listar">Cursos</a>
						<a href="<?=base_url()?>restrito/cursos/categorias">Categorias</a>
						<a href="<?=base_url()?>restrito/cursos/para">Cursos por público</a>
						<a href="<?=base_url()?>restrito/programacao/index">Programação</a>
						<a href="<?=base_url()?>restrito/palestrantes">Palestrantes</a>
					</div>
				
				<span class="sidebar-title">CAPACIFAR UNIVERSITÁRIO</span>
					<a class="sidebar-link" href="<?=base_url()?>restrito/universitario">
						<i class="bi bi-mortarboard"></i>
						Listar
						<?php if ($totalUniversitarioPendente > 0): ?>
							<span class="menu-count-badge"><?=$totalUniversitarioPendente?></span>
						<?php endif; ?>
					</a>
				<?php } ?>
				<span class="sidebar-title">EVENTOS</span>
				<?php if (in_array('capacifar', $permissoesMenu, true)) { ?>
					<a class="sidebar-link"
					   data-bs-toggle="collapse"
					   href="#menuURM"
					   role="button"
					   aria-expanded="false">
						<i class="bi bi-people"></i>
						URM
						<span class="arrow"></span>
					</a>
					<div class="collapse submenu" id="menuURM">
						<a href="<?=base_url()?>restrito/urm/listar">Cursos</a>
						<a href="<?=base_url()?>restrito/urm/local">Local</a>
						<a href="<?=base_url()?>restrito/programacao">Programação</a>
						<a href="<?=base_url()?>restrito/palestrantes">Palestrantes</a>
					</div>
			   
					<a class="sidebar-link"
					   data-bs-toggle="collapse"
					   href="#menuFH"
					   role="button"
					   aria-expanded="false">
						<i class="fas fa-user-shield"></i>
						Fisc. Humanizada
						<span class="arrow"></span>
					</a>
					<div class="collapse submenu" id="menuFH">
						<a href="<?=base_url()?>restrito/fiscalizacao/listar">Cursos</a>
						<a href="<?=base_url()?>restrito/programacao">Programação</a>
						<a href="<?=base_url()?>restrito/palestrantes">Palestrantes</a>
					</div>
					
					<a class="sidebar-link"
					   data-bs-toggle="collapse"
					   href="#menuSV"
					   role="button"
					   aria-expanded="false">
						<i class="bi bi-heart-pulse"></i>
						Seminário de Vigilância
						<span class="arrow"></span>
					</a>
					<div class="collapse submenu" id="menuSV">
						<a href="<?=base_url()?>restrito/seminario/listar">Cursos</a>
						<a href="<?=base_url()?>restrito/programacao">Programação</a>
						<a href="<?=base_url()?>restrito/palestrantes">Palestrantes</a>
					</div>
					<a class="sidebar-link" href="<?=base_url()?>nps/listar">
						<i class="bi bi-search"></i>
						NPS
					</a>
					
				<span class="sidebar-title">PROJETOS</span>
					<a class="sidebar-link" href="<?=base_url()?>restrito/merito/listar">
						<i class="bi bi-mortarboard"></i>
						Mérito Acadêmico
						<?php if ($totalMeritoPendente > 0): ?>
							<span class="menu-count-badge"><?=$totalMeritoPendente?></span>
						<?php endif; ?>
					</a>
					<a class="sidebar-link" href="<?=base_url()?>restrito/pesquisa/listar">
						<i class="bi bi-flask"></i>
						Pesquisa Científica
					</a>
				<?php } ?>
				<?php if (in_array('atitudes', $permissoesMenu, true)) { ?>
					<a class="sidebar-link" href="<?= site_url('restrito/atitude_farmaceutica') ?>">
						<i class="bi bi-clipboard-heart"></i>
						Atitude Farmacêutica
						<span id="atitude-pendentes-badge" class="menu-count-badge" <?= $totalAtitudePendente > 0 ? '' : 'hidden' ?>><?= $totalAtitudePendente ?></span>
					</a>
				<?php } ?>
				<?php if (in_array('tragadevolta', $permissoesMenu, true)) { ?>
					<a class="sidebar-link" href="#">
						<i class="bi bi-arrow-repeat"></i>
						Traga de Volta
					</a>
				<?php } ?>
				<?php if (in_array('receitas', $permissoesMenu, true)) { ?>
					<a class="sidebar-link" href="#">
						<i class="bi bi-file-earmark-text"></i>
						Receita Ilegível
					</a>
				<?php } ?>
				<?php if (in_array('cientificos', $permissoesMenu, true)) { ?>
					<span class="sidebar-title">CIENTÍFICO</span>
					<a class="sidebar-link" href="<?=base_url('restrito/doc_tecnico/listar')?>">
						<i class="bi bi-file-text"></i>
						Doc. Técnicos
					</a>
                <?php } ?>
				<?php if (in_array('cientificos', $permissoesMenu, true)) { ?>
					<span class="sidebar-title">CIENTÍFICO</span>
					<a class="sidebar-link" href="<?=base_url()?>restrito/plenaria/listar">
						<i class="bi bi-file-text"></i>
						Plenárias
					</a>
                <?php } ?>
				<?php if (in_array('BJHP', $permissoesMenu, true)) { ?>
                    <a class="sidebar-link" data-bs-toggle="collapse" href="#menuBjhp" role="button" aria-expanded="false" aria-controls="menuBjhp">
                        <i class="bi bi-journal-text"></i>BJHP<span class="arrow"></span>
                    </a>
                    <div class="collapse submenu" id="menuBjhp">
                        <a href="<?=base_url('restrito/bjhp/importar')?>">Importar dados</a>
                        <a href="<?=base_url('restrito/bjhp/corpo_editorial')?>">Corpo editorial</a>
                    </div>
                <?php } ?>
				<?php if (in_array('admin', $permissoesMenu, true)) { ?>
					<span class="sidebar-title">ADMINISTRAÇÃO</span>
					<a class="sidebar-link" href="<?=site_url('restrito/gerenciar_usuarios')?>">
						<i class="bi bi-person-gear"></i>
						Usuários
					</a>
					<a class="sidebar-link" href="<?=site_url('restrito/logs-inscricoes')?>">
						<i class="bi bi-journal-text"></i> Logs de inscrições
					</a>
				<?php } ?>
            </div>
        </nav>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const menuEsquerda = document.getElementById('menuEsquerda');

				if (!menuEsquerda) {
					return;
				}

				menuEsquerda.querySelectorAll('.sidebar-link[data-bs-toggle="collapse"][href^="#"]').forEach(function (link) {
					link.addEventListener('click', function (event) {
						const seletorSubmenu = link.getAttribute('href');
						const submenu = document.querySelector(seletorSubmenu);

						if (!submenu) {
							return;
						}

						event.preventDefault();
						event.stopPropagation();

						const estaAberto = submenu.classList.contains('show');

						submenu.classList.toggle('show', !estaAberto);
						link.setAttribute('aria-expanded', estaAberto ? 'false' : 'true');
					});
				});

				const caminhoAtual = window.location.pathname.replace(/\/$/, '').toLowerCase();
				menuEsquerda.querySelectorAll('a[href]').forEach(function (link) {
					if (link.getAttribute('href').startsWith('#')) return;
					let caminhoLink;
					try { caminhoLink = new URL(link.href, window.location.origin).pathname.replace(/\/$/, '').toLowerCase(); } catch (e) { return; }
					const ativo = caminhoAtual === caminhoLink || (caminhoLink !== '' && caminhoAtual.startsWith(caminhoLink + '/'));
					link.classList.toggle('active', ativo);
					if (ativo && link.closest('.submenu')) {
						const submenu = link.closest('.submenu');
						submenu.classList.add('show');
						const acionador = menuEsquerda.querySelector('[href="#' + submenu.id + '"]');
						if (acionador) acionador.setAttribute('aria-expanded', 'true');
					}
				});
			});
		</script>

		<main class="admin-main" style="flex: 1; min-width: 0;">
            <nav class="navbar navbar-light bg-light d-md-none">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuEsquerda" aria-controls="menuEsquerda" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
			<div class="mb-4"></div>
