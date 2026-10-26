<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6F8JD9HFEM"></script>


<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-6F8JD9HFEM');
</script>

<footer class="footer-portal">
    <div class="footer-container">

        <!-- TEXTO + BOTÃO -->
        <div class="footer-cta">
            <h2>Portal do Aluno: seu espaço personalizado de evolução</h2>

            <a href="https://crfmg.org.br/portalfarma/entrar" class="footer-btn" rel="noopener noreferrer">
                ACESSE AQUI
            </a>


        </div>
        

        <!-- LOGOS -->
        <div class="footer-logos">
            <img class="logo-portal" src="<?= base_url('assets/img/logo-portal-farma-branco.png') ?>" alt="Portal Farma">
            <a href="https://www.crfmg.org.br">
                <img class="logo-crfmg" src="<?= base_url('assets/img/crfmg_logo.png') ?>" alt="CRFMG">
            </a>
        </div>

        <!-- CONTATOS + REDES -->
        <div class="footer-contatos">

            <!-- REDES SOCIAIS -->
            <div class="footer-redes">
                <a href="https://www.instagram.com/crfmg/" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://www.facebook.com/crfminas/?locale=pt_BR" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://www.youtube.com/channel/UC6lljExqeDVdHPZOVWBx3xQ" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                <a href="https://www.linkedin.com/company/crfmg/posts/?feedView=all" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
            </div>

            <!-- WHATSAPP -->
            <div class="footer-item">
                <a href="https://wa.me/5531999999999" aria-label="WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                </a>
                <span>(31) 9 3218-1026</span>
            </div>

            <!-- EMAIL -->
            <div class="footer-item">
                <a href="mailto:contato@portalfarma.com.br" aria-label="E-mail">
                    <i class="bi bi-envelope"></i>
                </a>
                <span>capacifar@crfmg.org.br</span>
            </div>

        </div>

        <!-- ENDEREÇO -->
        <div class="footer-endereco">
            Rua Rodrigues Caldas, 493 | CEP 30190-120 | Santo Agostinho<br>
            Belo Horizonte | Minas Gerais
        </div>

        <!-- DIREITOS -->
        <div class="footer-direitos">
            <a href="https://www.crfmg.org.br/portalfarma/login" class="none">CRF/MG</a>
			© 2025 | 
			<a href="https://www.crfmg.org.br/portalfarma/certificado_palestrantes" class="none">Todos os direitos reservados.</a>
        </div>

        <div class="btn-topo-container">
            <button class="btn-topo" id="btnTopo">
                <i class="fa-solid fa-chevron-up"></i>
            </button>

            <style>
				.none{
					text-decoration: none;
					color:#fff;
				}
                .btn-topo-container {
                    position: fixed;
                    right: 34px;
                    bottom: 34px;
                    z-index: 9998;

                    opacity: 0;
                    pointer-events: none;
                    transform: translateY(20px);

                    transition:
                        opacity .3s ease,
                        transform .3s ease;
                }

                .btn-topo-container.visivel {
                    opacity: 1;
                    pointer-events: auto;
                    transform: translateY(0);
                }

                .btn-topo {
                    width: 56px;
                    height: 56px;
                    border-radius: 50%;
                    border: none;

                    background: #111827bb;
                    color: #ffffff;

                    display: flex;
                    align-items: center;
                    justify-content: center;

                    font-size: 18px;
                    cursor: pointer;

                    box-shadow: 0 10px 26px rgba(0, 0, 0, .35);

                    transition:
                        transform .25s ease,
                        box-shadow .25s ease,
                        background .25s ease;
                }

                .btn-topo:hover {
                    background: #1f2937;
                    transform: translateY(-3px) scale(1.05);
                    box-shadow:
                        0 16px 34px rgba(0, 0, 0, .45),
                        0 0 0 6px rgba(255, 255, 255, .9);
                }

                @media (max-width: 768px) {
                    .btn-topo-container {
                        display: none !important;
                    }
                }
            </style>

            <script>
                const btnTopo = document.getElementById('btnTopo');
                const topoContainer = document.querySelector('.btn-topo-container');

                // aparece ao descer
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 300) {
                        topoContainer.classList.add('visivel');
                    } else {
                        topoContainer.classList.remove('visivel');
                    }
                });

                // sobe a página
                btnTopo.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            </script>

        </div>
    </div>
</footer>

<style>
    /* ÍCONES GERAIS DO FOOTER */
    .footer-portal i {
        font-size: 24px;
        color: #ffffff;
        line-height: 1;
    }

    /* ÍCONES DAS REDES SOCIAIS */
    .footer-redes {
        display: flex;
        gap: 10px;
        align-items: center;
    }


    /* WHATSAPP E EMAIL */
    .footer-item i {
        font-size: 22px;
    }

    /* REMOVE QUALQUER HOVER */
    .footer-portal a:hover,
    .footer-portal a:focus,
    .footer-portal i:hover {
        color: #ffffff;
        transform: none;
        text-decoration: none;
    }

    .footer-portal {
        background-color: #E4231B;
        color: #ffffff;
        padding: 45px 20px 20px;
        text-align: center;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* CTA */
    .footer-cta h2 {
        font-size: 29px;
        margin-bottom: 38px;
    }


    .footer-btn {
        display: inline-block;
        background: #680a0300;
        color: #fff;
        padding: 8px 25px;
        border-radius: 13px;
        font-weight: 700;
        font-size: 19px;
        text-decoration: none;
        border: 2px solid #ffffff;
        transition: all 0.3s ease;
    }


    /* LOGOS */
    .footer-logos {
        margin: 35px 0 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 70px;
        flex-wrap: wrap;
    }

    /* LOGO PORTAL FARMA */
    .footer-logos .logo-portal {
        height: 90px;
        width: auto;
    }

    /* LOGO CRFMG */
    .footer-logos .logo-crfmg {
        height: 50px;
        width: auto;
    }

    .footer-logos img {
        max-height: 90px;
    }

    /* CONTATOS */
    .footer-contatos {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 80px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    /* WHATS / EMAIL */
    .footer-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .footer-item img {
        width: 20px;
        height: 20px;
    }

    .footer-portal i {
        font-size: 26px;
    }

    .footer-portal i {
        font-size: 26px;
    }


    /* ENDEREÇO */
    .footer-endereco {
        font-size: 13px;
        opacity: 0.9;
        line-height: 1.6;
    }

    .footer-direitos {
        margin-top: 25px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        margin-top: 20px;
        font-size: 12px;
        opacity: 0.7;
        text-align: center;
    }

    .footer-portal {
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, #E4231B, #C60C05);
        color: #ffffff;
        padding: 45px 20px 20px;
        text-align: center;
    }

    .footer-portal::before {
        content: "";
        position: absolute;
        inset: 0;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        opacity: 0.35;
        pointer-events: none;
        z-index: 1;
    }

    @media (max-width: 768px) {

        /* Título menor */
        .footer-cta h2 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        /* Contatos e redes empilhados com espaço */
        .footer-contatos {
            flex-direction: column;
            gap: 16px;
            align-items: center;
        }

        /* Logos lado a lado */
        .footer-logos {
            flex-direction: row;
            /* força na horizontal */
            justify-content: center;
            gap: 30px;
            /* menos espaço para caber na tela */
            flex-wrap: nowrap;
            /* sem quebrar em duas linhas */
            margin: 25px 0 35px;
        }

        /* Ajusta tamanho das logos para mobile */
        .footer-logos .logo-portal {
            height: 70px;
        }

        .footer-logos .logo-crfmg {
            height: 40px;
        }

        /* Botão menor para mobile */
        .footer-btn {
            font-size: 17px;
            padding: 7px 20px;
        }

        /* Footer container padding menor */
        .footer-portal {
            padding: 35px 15px 15px;
        }
    }
</style>