<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição - Atitude Farmacêutica (CRF/MG)</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>tailwind.config = { important: '#atitude-inscricao', corePlugins: { preflight: false } };</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #atitude-inscricao .hero-actions {
            padding: 28px 0;
        }
        #atitude-inscricao .btn-voltar {
            display: inline-flex;
            align-items: center;
            padding: 9px 20px;
            border: 1px solid #12455e;
            border-radius: 10px;
            background: #fff;
            color: #12455e;
            font-size: 17px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: background-color .25s ease, color .25s ease;
        }
        #atitude-inscricao .btn-voltar:hover {
            background: #0b4f63;
            color: #fff;
        }
        #atitude-inscricao *, #atitude-inscricao ::before, #atitude-inscricao ::after { box-sizing: border-box; border-width: 0; border-style: solid; border-color: #e5e7eb; }
        #atitude-inscricao h2, #atitude-inscricao h3, #atitude-inscricao h4, #atitude-inscricao p { margin: 0; }
        #atitude-inscricao input, #atitude-inscricao select, #atitude-inscricao textarea, #atitude-inscricao button { font: inherit; }
        #atitude-inscricao button { cursor: pointer; }
        #atitude-inscricao img { display: block; max-width: 100%; }
        #atitude-inscricao .step-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        #atitude-inscricao .step-active {
            background-color: #3b5998;
            color: #ffffff;
        }
        #atitude-inscricao .step-inactive {
            background-color: #ffffff;
            color: #6b7280;
            border: 2px solid #e5e7eb;
        }
        #atitude-inscricao .step-completed {
            background-color: #10b981;
            color: #ffffff;
        }
        #atitude-inscricao .resumo-titulo { font-size: 22px; font-weight: 700; color: #12455e; }
        #atitude-inscricao #resumo-responsavel strong,
        #atitude-inscricao #resumo-projeto strong { font-size: 16px; font-weight: 700; color: #12455e; }
        #atitude-inscricao #resumo-projeto strong { display: block; margin-bottom: 6px; }
        #atitude-inscricao #resumo-projeto span { display: block; line-height: 1.65; }
        .atitude-preview-card { max-width: 420px; margin: auto; border: 1px solid #a7becb; border-radius: 26px; overflow: hidden; background: #f7fafc; text-align: left; }
        .atitude-preview-card img { display: block; width: 100%; aspect-ratio: 16 / 9; object-fit: cover; }
        .atitude-preview-conteudo { padding: 22px; }
        .atitude-preview-card h3 { margin: 0 0 12px; color: #12455e; font-size: 24px; font-weight: 700; overflow-wrap: anywhere; }
        .atitude-preview-card p { color: #526078; line-height: 1.65; white-space: pre-wrap; overflow-wrap: anywhere; margin: 0 0 22px; }
        .atitude-preview-data { display: flex; align-items: center; justify-content: flex-end; gap: 7px; color: #526078; font-size: 14px; }
        .atitude-preview-data i { color: #ed3348; }
        #atitude-inscricao .campo-com-ajuda { position: relative; padding-left: 32px; min-width: 0; }
        #atitude-inscricao .ajuda-campo {
            position: absolute; left: 0; top: 31px; width: 22px; height: 22px;
            padding: 0; border-radius: 50%; background: #ed3348; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; line-height: 1; border: 0;
        }
        #atitude-inscricao .ajuda-campo:hover { background: #c91e34; }
        #atitude-inscricao .ajuda-campo:focus-visible { outline: 3px solid #12455e; outline-offset: 3px; }
        .atitude-ajuda-popover {
            position: fixed; z-index: 1100; width: 440px; max-width: calc(100vw - 24px);
            max-height: min(440px, calc(100vh - 24px)); overflow-y: auto;
            padding: 18px; background: #fff; color: #374151; border: 1px solid #d1d5db;
            border-radius: 10px; box-shadow: 0 8px 28px rgba(0,0,0,.16);
            font: 14px/1.6 Arial, sans-serif; box-sizing: border-box;
        }
        .atitude-ajuda-popover[hidden] { display: none; }
        .atitude-ajuda-popover strong { display: block; margin-bottom: 8px; color: #12455e; }
        .atitude-ajuda-popover p { margin: 0; white-space: pre-line; }
    </style>
</head>
<body>
    <?php $this->load->view('fixo/cabecalho'); ?>
    <main id="atitude-inscricao" class="bg-gray-100 min-h-screen text-gray-800 font-sans pb-12">

    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="hero-actions">
            <a href="javascript:history.back()" class="btn-voltar">VOLTAR</a>
        </div>
        <!-- Stepper Visual -->
        <div class="flex items-center justify-between mb-8 relative">
            <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gray-200 -z-10 -translate-y-1/2"></div>
            
            <div class="flex flex-col items-center bg-gray-100 px-2" id="stepper-head-1">
                <div class="step-circle step-active" id="step-num-1">1</div>
                <span class="text-xs md:text-sm font-medium mt-2 text-center text-gray-700">Dados do Solicitante</span>
            </div>
            
            <div class="flex flex-col items-center bg-gray-100 px-2" id="stepper-head-2">
                <div class="step-circle step-inactive" id="step-num-2">2</div>
                <span class="text-xs md:text-sm font-medium mt-2 text-center text-gray-500">Dados do Projeto</span>
            </div>
            
            <div class="flex flex-col items-center bg-gray-100 px-2" id="stepper-head-3">
                <div class="step-circle step-inactive" id="step-num-3">3</div>
                <span class="text-xs md:text-sm font-medium mt-2 text-center text-gray-500">Imagens do Projeto</span>
            </div>

            <div class="flex flex-col items-center bg-gray-100 px-2" id="stepper-head-4">
                <div class="step-circle step-inactive" id="step-num-4">4</div>
                <span class="text-xs md:text-sm font-medium mt-2 text-center text-gray-500">Confirmar e Enviar</span>
            </div>
        </div>

        <!-- Formulário Container -->
        <form id="form-inscricao" method="post" action="<?= site_url('atitude_farmaceutica/salvar') ?>" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <input type="hidden" id="inscricao-csrf" name="<?= html_escape($this->security->get_csrf_token_name()) ?>" value="<?= html_escape($this->security->get_csrf_hash()) ?>">
            
            <!-- Passo 1 -->
            <div id="step-1" class="step-content">
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center gap-3">
                    <i class="fa-solid fa-user-doctor text-gray-600 text-lg"></i>
                    <h2 class="font-semibold text-gray-800 text-lg">Passo 1 - Dados do Solicitante</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <fieldset class="md:col-span-2">
                        <legend class="block text-sm font-medium text-gray-700 mb-2">Você é Farmacêutico ou Empresa?</legend>
                        <div class="flex gap-6 flex-wrap">
                            <label class="flex items-center gap-2"><input type="radio" name="tipo_solicitante" value="farmaceutico" checked required> Farmacêutico</label>
                            <label class="flex items-center gap-2"><input type="radio" name="tipo_solicitante" value="empresa" required> Empresa</label>
                        </div>
                    </fieldset>
                    <div class="md:col-span-2">
                        <label for="numero_crf" class="block text-sm font-medium text-gray-700 mb-1">*Número de registro no CRF/MG:</label>
                        <div class="flex gap-2">
                            <input type="text" id="numero_crf" name="numero_crf" inputmode="numeric" pattern="[0-9]+" maxlength="50" required placeholder="Informe o número do registro" data-pf-url="<?= site_url('atitude_farmaceutica/consultar_pf') ?>" data-pj-url="<?= site_url('atitude_farmaceutica/consultar_pj') ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                            <button type="button" id="buscar-solicitante" class="shrink-0 px-4 py-2 rounded bg-blue-600 text-white font-medium"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Buscar</button>
                        </div>
                        <p id="solicitante-status" role="status" aria-live="polite" class="text-sm text-gray-600 mt-2">Consulte o cadastro no CRF/MG para liberar sua inscrição.</p>
                    </div>
                    <div>
                        <label id="solicitante-nome-label" for="nome" class="block text-sm font-medium text-gray-700 mb-1">*Nome:</label>
                        <input type="text" id="nome" name="nome" maxlength="255" required readonly class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <!--<div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">*CPF/CNPJ</label>
                        <input type="text" id="cpf" name="cpf" inputmode="numeric" maxlength="14" pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}" required placeholder="000.000.000-00" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nº CRF: (opcional)</label>
                        <input type="text" name="numero_crf" placeholder="Número do CRF" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>-->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email: (opcional)</label>
                        <input type="email" name="email" placeholder="seu@email.com" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Celular:</label>
                        <input type="text" id="celular" name="celular" inputmode="numeric" maxlength="15" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" required placeholder="(00) 00000-0000" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Cidade:</label>
                        <select id="cidade" name="cidade_farmaceutico" required disabled class="w-full border border-gray-300 rounded px-3 py-2 bg-white disabled:bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">Selecione o município...</option>
                            <?php foreach ($cidades_mineiras as $cidadeMineira): ?>
                                <option value="<?= html_escape($cidadeMineira) ?>"><?= html_escape($cidadeMineira) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="cidade-empresa" name="cidade_farmaceutico" disabled>
                    </div>
                </div>
            </div>

            <!-- Passo 2 -->
            <div id="step-2" class="step-content hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center gap-3">
                    <i class="fa-solid fa-folder-open text-gray-600 text-lg"></i>
                    <h2 class="font-semibold text-gray-800 text-lg">Passo 2 - Dados do Projeto</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Título do Projeto:</label>
                        <input type="text" name="nome_projeto" maxlength="150" placeholder="Título do Projeto" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Eixo Projeto:</label>
                        <select name="eixo_projeto" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Selecione um eixo...</option>
                            <option value="Eixo 1: Envolvimento e desenvolvimento da comunidade">Eixo 1: Envolvimento e desenvolvimento da comunidade</option>
                            <option value="Eixo 2: Práticas exitosas de trabalho">Eixo 2: Práticas exitosas de trabalho</option>
                            <option value="Eixo 3: Respeito e proteção do Meio Ambiente">Eixo 3: Respeito e proteção do Meio Ambiente</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Nº de pessoas atuantes no projeto:</label>
                        <input type="number" name="numero_pessoas" min="1" max="999" maxlength="3" step="1" inputmode="numeric" placeholder="Quantidade de pessoas atuantes" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Municipio da Realização:</label>
                        <select name="cidade_projeto" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Selecione o município...</option>
                            <?php foreach ($cidades_mineiras as $cidadeMineira): ?>
                                <option value="<?= html_escape($cidadeMineira) ?>"><?= html_escape($cidadeMineira) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Espaço de realização do projeto:</label>
                        <input type="text" name="local_projeto" placeholder="Espaço de realização do projeto" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Data de Início:</label>
                        <input type="date" name="data_inicio" max="<?= html_escape($dataInicioMaxima) ?>" aria-describedby="data-inicio-ajuda" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <p id="data-inicio-ajuda" class="text-xs text-gray-500 mt-1">O projeto deve ter iniciado há pelo menos 6 meses. Data máxima: <?= date('d/m/Y', strtotime($dataInicioMaxima)) ?>.</p>
                    </div>
                   
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Recursos:</label>
                        <input type="text" name="recursos" maxlength="100" placeholder="Fontes de recursos/financiamento do projeto" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

 <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Resumo:</label>
                        <textarea name="resumo_projeto" rows="3" placeholder="Escreva um breve resumo do projeto" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Descrição do Projeto:</label>
                        <textarea name="descricao_projeto" rows="3" placeholder="Como o projeto foi desenvolvido? Descreva o mais detalhadamente possível." required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Justificativa:</label>
                        <textarea name="justificativa" maxlength="150" rows="3" placeholder="Explicar a necessidade ou o problema que mtivou a criaçao do projeto/ação" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pessoas Alcançadas:</label>
                        <textarea name="pessoas_alcancadas" rows="2" placeholder="Número de pessoas alcançadas pelo projeto" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Benefícios já alcançados:</label>
                        <textarea name="beneficios_alcancados" maxlength="250" rows="3" placeholder="Benefícios/Melhorias alcançadas a partir do projeto para o público" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">*Objetivos já alcançados:</label>
                        <textarea name="objetivos_alcancados" maxlength="250" rows="3" placeholder="Objetivos/metas efetivamentes alcançadas" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                </div>
            </div>

            <!-- Passo 3 -->
            <div id="step-3" class="step-content hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center gap-3">
                    <i class="fa-solid fa-images text-gray-600 text-lg"></i>
                    <h2 class="font-semibold text-gray-800 text-lg">Passo 3 - Imagens do Projeto</h2>
                </div>
                <div class="p-6">
                    <div id="drop-area" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-blue-500 transition-colors bg-gray-50">
                        <p class="text-sm text-gray-600 mb-3">Envie até 5 imagens do projeto, com no máximo 5MB cada.</p>
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-700 font-medium">Arraste e solte suas imagens aqui ou <span class="text-blue-600 underline">clique para selecionar</span></p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG ou WEBP (Max 5MB cada)</p>
                        <input type="file" id="image-input" name="imagens[]" multiple accept="image/*" class="hidden">
                    </div>

                    
                    <p class="text-sm text-gray-600 mt-4">preferencialmente foto na horizontal</p>
                    <p class="text-sm text-gray-600 mt-4">Ajuste cada imagem abaixo. O recorte 16:9 será usado na página pública e enviado com a inscrição.</p>

                    <div id="file-preview-list" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6"></div>
                    <!-- Seleção Imagem Principal -->
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-800 mb-2">Selecione a Imagem Principal do Projeto:</h3>
                        <div id="galeria-principal-container" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                        <input type="hidden" name="imagem_principal_idx" id="imagem_principal_idx" value="0">
                    </div>
                </div>
            </div>

            <!-- Passo 4 -->
            <div id="step-4" class="step-content hidden">
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center gap-3">
                    <i class="fa-solid fa-check-double text-gray-600 text-lg"></i>
                    <h2 class="font-semibold text-gray-800 text-lg">Passo 4 - Revisão, Preview e Aceite</h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Resumo Dados -->
                    <div class="bg-gray-50 p-4 rounded border border-gray-200">
                        <h3 class="resumo-titulo border-b pb-2 mb-3">Dados do Solicitante</h3>
                        <div id="resumo-responsavel" class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700"></div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded border border-gray-200">
                        <h3 class="resumo-titulo border-b pb-2 mb-3">Dados do Projeto</h3>
                        <div id="resumo-projeto" class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700"></div>
                    </div>

                    <button type="button" id="btn-preview-projeto" class="px-5 py-3 rounded-lg bg-blue-600 text-white font-semibold"><i class="fa-solid fa-eye" aria-hidden="true"></i> Preview de apresentação da Atitude Farmacêutica</button>

                    <!-- Termo de Aceite Box -->
                    <div class="border border-gray-300 rounded p-4" style="background-color: #f2dede;">
                        <h4 class="font-bold text-gray-800 text-sm mb-2">TERMO DE ACEITE</h4>
                        <div class="h-36 overflow-y-auto text-xs text-gray-600 space-y-2 pr-2 border-b border-gray-200 pb-3 mb-3">
                            <p>Declaro estar ciente de que o Atitude Farmacêutica é um projeto do CRF/MG, sem ônus de participação, que tem por objetivo a congratulação e projeção gratuita de ações beneficentes desenvolvidas por profissionais e/ou empresas farmacêuticas do Estado de Minas Gerais. Declaro concordar com os termos de participação e submissão divulgados no site do CRF/MG, assim como os critérios de avaliação e premiação dos projetos inscritos, independentemente de possíveis mudanças na organização, avaliação, divulgação e premiação dos projetos avaliados.</p>
                            <p>A presente autorização é concedida a título gratuito, abrangendo o uso das imagens e marcas por mim disponibilizadas, assim como meu nome, nome do projeto e email para contato, sendo de minha total responsabilidade a veracidade e disponibilidade dos dados.</p>
                            <p>Estou ciente de que as imagens e/ou marcas por mim disponibilizadas poderão ser utilizadas pelo CRF/MG em todo território nacional e no exterior, em todas as suas modalidades e, em destaque, das seguintes formas:<br>
                            (I) homepage;<br>
                            (II) redes sociais;<br>
                            (III) revistas;<br>
                            (IV) divulgação em geral, em materiais e campanhas única e exclusivamente voltados para a divulgação e promoção de minha participação no Atitude Farmacêutica. Por esta ser a expressão da minha vontade declaro que autorizo o uso acima descrito sem que nada haja a ser reclamado a título de direitos conexos à minha imagem ou a qualquer outro.</p>
                        </div>
                        <label class="flex items-start gap-2 cursor-pointer">
                            <input type="checkbox" name="aceite_termos" id="aceite_termos" required class="mt-1 h-4 w-4 text-blue-600 rounded border-gray-300">
                            <span class="text-sm text-gray-700">Li e aceito os termos e condições veja os termos aqui.</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Botões de Navegação -->
            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex justify-between items-center">
                <button type="button" id="btn-prev" class="px-5 py-2 rounded border border-gray-300 text-gray-600 font-medium hover:bg-gray-100 hidden">Anterior</button>
                <div class="ml-auto">
                    <button type="button" id="btn-next" class="px-6 py-2 rounded bg-blue-600 text-white font-medium hover:bg-blue-700">Próximo</button>
                    <button type="submit" id="btn-submit" class="px-6 py-2 rounded bg-green-600 text-white font-medium hover:bg-green-700 hidden">Finalizar e Enviar Inscrição</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Consulta PF/PJ centralizada no arquivo abaixo -->
    <script src="<?= base_url('assets/js/atitude-solicitante.js') ?>?v=20261019-2"></script>
    <!-- Scripts da Aplicação -->
    <script>
        let currentStep = 1;
        let errosValidacao = [];
        const totalSteps = 4;
        let selectedFiles = [];
        let adjustedFiles = [];
        let ajustesConfirmados = false;
        const imageAdjustments = new WeakMap();
        let miniaturasPrincipal = new WeakMap();
        function invalidarAjustes() { ajustesConfirmados = false; adjustedFiles = []; }
        function obterAjuste(file) {
            if (!imageAdjustments.has(file)) {
                const state = { zoom: 1, x: 50, y: 50, image: new Image() };
                state.ready = new Promise((resolve, reject) => {
                    const url = URL.createObjectURL(file);
                    state.image.onload = () => { URL.revokeObjectURL(url); resolve(state); };
                    state.image.onerror = () => { URL.revokeObjectURL(url); reject(new Error('Não foi possível abrir a imagem. Remova o arquivo e selecione outra imagem.')); };
                    state.image.src = url;
                });
                imageAdjustments.set(file, state);
            }
            return imageAdjustments.get(file);
        }
        function desenharRecorte(canvas, state) {
            const image = state.image;
            const escala = Math.max(canvas.width / image.naturalWidth, canvas.height / image.naturalHeight) * state.zoom;
            const largura = image.naturalWidth * escala, altura = image.naturalHeight * escala;
            const contexto = canvas.getContext('2d');
            contexto.fillStyle = '#fff';
            contexto.fillRect(0, 0, canvas.width, canvas.height);
            contexto.drawImage(image, -(largura - canvas.width) * state.x / 100, -(altura - canvas.height) * state.y / 100, largura, altura);
        }
        async function gerarImagensAjustadas() {
            return Promise.all(selectedFiles.map(async (file, index) => {
                const state = await obterAjuste(file).ready;
                const canvas = document.createElement('canvas');
                canvas.width = 1600; canvas.height = 900;
                desenharRecorte(canvas, state);
                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', .9));
                if (!blob) throw new Error('Não foi possível gerar o recorte. Tente novamente.');
                return new File([blob], `projeto-${index + 1}.jpg`, { type: 'image/jpeg' });
            }));
        }

        const orientacoesCampos = {
            nome_projeto: ['Título do Projeto', 'Informar o nome do projeto desenvolvido. O título deve ser claro, objetivo e representar a iniciativa inscrita.'],
            eixo_projeto: ['Eixo do Projeto', `Selecionar o eixo temático que melhor corresponde à finalidade principal e às ações desenvolvidas pelas iniciativas.

Eixo 1: Envolvimento e desenvolvimento da comunidade – está relacionado à promoção de quaisquer ações de cunho assistencial e/ou educacional destinadas à comunidade onde operam, ou a grupos específicos que careçam de apoio especial.

Eixo 2: Práticas exitosas de trabalho – Este eixo está relacionado à promoção de políticas internas, destinadas a parceiros, colegas e/ou colaboradores, que contribuem individual ou coletivamente para o desenvolvimento e benefício do ser humano, que vão além do cumprimento das obrigações legais nas relações de trabalho.

Eixo 3: Respeito e proteção do Meio Ambiente – Envolve as ações individuais e coletivas ou programas organizacionais que visam recuperar ou minimizar os impactos ambientais provenientes das ações da empresa ou da comunidade onde está inserida.`],
            numero_pessoas: ['Número de participantes', 'Informar o número de pessoas que participaram diretamente da realização do projeto, como profissionais envolvidos, voluntários, colaboradores ou integrantes da equipe executora.'],
            cidade_projeto: ['Cidade', 'Informar o município onde o projeto foi desenvolvido. Caso a iniciativa tenha ocorrido em mais de uma cidade, detalhar essa informação no campo de descrição, quando aplicável.'],
            local_projeto: ['Local', 'Informar o local em que as atividades foram realizadas, como instituição, estabelecimento, comunidade, unidade de saúde, escola ou outro espaço relacionado à execução do projeto.'],
            data_inicio: ['Data de início', 'Indicar a data em que o projeto começou a ser executado.'],
            recursos: ['Recursos', 'Informar os recursos utilizados para a realização do projeto, incluindo, quando aplicável, recursos financeiros, materiais, humanos, estruturais e parcerias. Se forem utilizados recursos próprios, indicar essa condição.'],
            resumo_projeto: ['Resumo', 'Apresentar uma síntese do projeto, destacando sua finalidade, o público atendido, as principais atividades realizadas e os resultados mais relevantes. O texto deve permitir uma compreensão rápida da iniciativa, sendo o número máximo de caracteres de 480.'],
            descricao_projeto: ['Descrição do Projeto', 'Descrever como o projeto foi desenvolvido, incluindo o contexto em que surgiu, as etapas de execução, as atividades realizadas, a participação dos envolvidos e as estratégias utilizadas para alcançar os resultados. Sempre que possível, apresentar informações concretas sobre a realização da iniciativa, sendo o número máximo de caracteres de 600.'],
            justificativa: ['Justificativa', 'Explicar a necessidade ou o problema que motivou a criação do projeto. Apresentar sua relevância para o público beneficiado e para a comunidade, indicando a situação que a iniciativa buscou transformar.'],
            pessoas_alcancadas: ['Pessoas Alcançadas', 'Informar o número estimado ou contabilizado de pessoas alcançadas pelas ações do projeto. Considerar o público beneficiado direta ou indiretamente, conforme os registros disponíveis, evitando duplicidade na contagem sempre que possível.'],
            beneficios_alcancados: ['Benefícios já alcançados', 'Descrever os benefícios observados a partir da realização do projeto, indicando mudanças, melhorias ou contribuições para o público atendido, a comunidade, os serviços ou as instituições envolvidas. Quando houver dados, registros ou exemplos que demonstrem os resultados, eles poderão ser mencionados.'],
            objetivos_alcancados: ['Objetivos já alcançados', 'Informar quais objetivos previstos para o projeto foram efetivamente alcançados até o momento da inscrição. Quando pertinente, indicar os objetivos parcialmente alcançados e aqueles que ainda estão em andamento, distinguindo resultados obtidos de metas futuras.']
        };
        const ajudaPopover = document.createElement('div');
        ajudaPopover.id = 'atitude-ajuda-preenchimento';
        ajudaPopover.className = 'atitude-ajuda-popover';
        ajudaPopover.hidden = true;
        ajudaPopover.setAttribute('role', 'region');
        ajudaPopover.setAttribute('aria-label', 'Orientações de preenchimento');
        document.body.appendChild(ajudaPopover);
        let ajudaAberta = null;
        function fecharAjuda() {
            if (ajudaAberta) ajudaAberta.setAttribute('aria-expanded', 'false');
            ajudaAberta = null;
            ajudaPopover.hidden = true;
        }
        Object.entries(orientacoesCampos).forEach(([nome, [titulo, texto]]) => {
            const campo = document.querySelector(`#step-2 [name="${nome}"]`);
            const container = campo.parentElement;
            container.classList.add('campo-com-ajuda');
            const botao = document.createElement('button');
            botao.type = 'button';
            botao.className = 'ajuda-campo';
            botao.textContent = '?';
            botao.setAttribute('aria-label', `Como preencher: ${titulo}`);
            botao.setAttribute('aria-expanded', 'false');
            botao.setAttribute('aria-controls', ajudaPopover.id);
            container.appendChild(botao);
            botao.addEventListener('click', () => {
                const estavaAberta = ajudaAberta === botao;
                fecharAjuda();
                if (estavaAberta) return;
                const cabecalho = document.createElement('strong');
                const conteudo = document.createElement('p');
                cabecalho.textContent = titulo;
                conteudo.textContent = texto;
                ajudaPopover.replaceChildren(cabecalho, conteudo);
                ajudaPopover.hidden = false;
                ajudaPopover.scrollTop = 0;
                ajudaAberta = botao;
                botao.setAttribute('aria-expanded', 'true');
                const posicao = botao.getBoundingClientRect();
                ajudaPopover.style.left = `${Math.max(12, Math.min(posicao.right + 10, window.innerWidth - ajudaPopover.offsetWidth - 12))}px`;
                ajudaPopover.style.top = `${Math.max(12, Math.min(posicao.top - 8, window.innerHeight - ajudaPopover.offsetHeight - 12))}px`;
            });
        });
        document.addEventListener('click', event => {
            if (ajudaAberta && !ajudaAberta.contains(event.target) && !ajudaPopover.contains(event.target)) fecharAjuda();
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && ajudaAberta) {
                ajudaAberta.focus();
                fecharAjuda();
            }
        });
        window.addEventListener('resize', fecharAjuda);
        window.addEventListener('scroll', fecharAjuda);

        const campoDataInicio = document.querySelector('input[name="data_inicio"]');
        function validarDataInicio(avisar = false) {
            campoDataInicio.setCustomValidity('');
            if (campoDataInicio.value && campoDataInicio.value > campoDataInicio.max) {
                const limite = campoDataInicio.max.split('-').reverse().join('/');
                const mensagem = `O projeto deve ter iniciado há pelo menos 6 meses. Informe uma data até ${limite}.`;
                campoDataInicio.setCustomValidity(mensagem);
                if (avisar) Swal.fire({ icon: 'warning', title: 'Confira a data de início', text: mensagem });
                return false;
            }
            return true;
        }
        campoDataInicio.addEventListener('input', () => validarDataInicio());
        campoDataInicio.addEventListener('change', () => validarDataInicio(true));

        const limitesTextos = {
            nome_projeto: [150, 'Título do projeto'],
            numero_pessoas: [3, 'Número de pessoas atuantes'],
            recursos: [100, 'Recursos'],
            resumo_projeto: [480, 'Resumo do projeto'],
            descricao_projeto: [600, 'Descrição do projeto'],
            justificativa: [150, 'Justificativa'],
            beneficios_alcancados: [250, 'Benefícios alcançados'],
            objetivos_alcancados: [250, 'Objetivos alcançados']
        };
        Object.entries(limitesTextos).forEach(([nome, [limite, titulo]]) => {
            const campo = document.querySelector(`[name="${nome}"]`);
            const numerico = nome === 'numero_pessoas';
            campo.setAttribute('maxlength', limite);
            const contador = document.createElement('p');
            contador.id = `${nome}-contador`;
            contador.className = 'text-xs text-gray-500 text-right mt-1';
            contador.setAttribute('aria-live', 'polite');
            campo.setAttribute('aria-describedby', contador.id);
            campo.insertAdjacentElement('afterend', contador);
            let limiteAvisado = false;
            let ultimoNumero = '';
            function atualizarContador(avisar) {
                if (numerico && !/^[0-9]*$/.test(campo.value)) campo.value = ultimoNumero;
                const caracteres = Array.from(campo.value);
                if (caracteres.length > limite) campo.value = caracteres.slice(0, limite).join('');
                if (numerico) ultimoNumero = campo.value;
                const quantidade = Math.min(caracteres.length, limite);
                const atingido = quantidade >= limite;
                campo.dataset.limiteAtingido = String(atingido);
                campo.classList.toggle('border-red-500', atingido);
                campo.classList.toggle('border-gray-300', !atingido);
                const unidade = numerico ? 'dígitos' : 'caracteres';
                contador.textContent = `${quantidade}/${limite} ${unidade}` + (atingido ? ` — Limite máximo atingido${numerico ? ' (até 999)' : ''}.` : '');
                contador.className = `text-xs text-right mt-1 ${atingido ? 'text-red-600 font-medium' : 'text-gray-500'}`;
                if (avisar && atingido && !limiteAvisado && ['resumo_projeto', 'descricao_projeto'].includes(nome)) {
                    limiteAvisado = true;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limite de caracteres atingido',
                        text: `${titulo} permite no máximo ${limite} caracteres. O texto excedente não será incluído.`,
                        confirmButtonText: 'Entendi'
                    });
                }
                if (quantidade < limite) limiteAvisado = false;
            }
            if (numerico) campo.addEventListener('keydown', event => {
                if (['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();
            });
            campo.addEventListener('input', () => atualizarContador(true));
            atualizarContador(false);
        });

        const dropArea = document.getElementById('drop-area');
        const imageInput = document.getElementById('image-input');
        const filePreviewList = document.getElementById('file-preview-list');

        const celularInput = document.getElementById('celular');
        function aplicarMascaraCelular() {
            const posicao = celularInput.selectionStart || 0;
            const digitosAntes = celularInput.value.slice(0, posicao).replace(/\D/g, '').length;
            const digitos = celularInput.value.replace(/\D/g, '').slice(0, 11);
            let formatado = digitos ? '(' + digitos.slice(0, 2) : '';
            if (digitos.length > 2) formatado += ') ' + digitos.slice(2, 7);
            if (digitos.length > 7) formatado += '-' + digitos.slice(7, 11);
            celularInput.value = formatado;
            let cursor = 0;
            let contagem = 0;
            while (cursor < formatado.length && contagem < digitosAntes) {
                if (/\d/.test(formatado[cursor])) contagem++;
                cursor++;
            }
            celularInput.setSelectionRange(cursor, cursor);
        }
        celularInput.addEventListener('input', aplicarMascaraCelular);
        aplicarMascaraCelular();
        // Drag and drop event listeners
        dropArea.addEventListener('click', () => imageInput.click());
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => { e.preventDefault(); dropArea.classList.add('border-blue-500'); });
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => { e.preventDefault(); dropArea.classList.remove('border-blue-500'); });
        });
        dropArea.addEventListener('drop', (e) => {
            handleFiles(e.dataTransfer.files);
        });
        imageInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        function handleFiles(files) {
            let limiteExcedido = false;
            let imagemInvalida = false;
            Array.from(files).forEach(file => {
                if (['image/jpeg', 'image/png', 'image/webp'].includes(file.type) && file.size <= 5 * 1024 * 1024) {
                    if (selectedFiles.length >= 5) {
                        limiteExcedido = true;
                        return;
                    }
                    selectedFiles.push(file);
                } else {
                    imagemInvalida = true;
                }
            });
            imageInput.value = '';
            renderPreviews();
            const avisos = [];
            if (limiteExcedido) avisos.push('É permitido enviar no máximo 5 imagens por projeto. As imagens excedentes não foram adicionadas.');
            if (imagemInvalida) avisos.push('Envie imagens JPG, PNG ou WEBP com até 5MB cada.');
            if (avisos.length) Swal.fire({ icon: 'warning', title: limiteExcedido ? 'Limite de imagens' : 'Imagem inválida', text: avisos.join(' ') });
        }

        function renderPreviews() {
            invalidarAjustes();
            filePreviewList.replaceChildren();
            selectedFiles.forEach((file, index) => {
                const state = obterAjuste(file);
                const card = document.createElement('div');
                card.className = 'border rounded-lg p-4 bg-white shadow-sm min-w-0';
                const title = document.createElement('strong');
                title.textContent = `Imagem ${index + 1}: ${file.name}`;
                title.className = 'block text-sm mb-3 break-words';
                const canvas = document.createElement('canvas');
                canvas.width = 800; canvas.height = 450;
                canvas.style.cssText = 'display:block;width:100%;height:auto;border-radius:8px;background:#f1f5f9';
                canvas.setAttribute('aria-label', `Prévia do recorte da imagem ${index + 1}`);
                card.append(title, canvas);
                const controls = [];
                [['zoom', 'Zoom', 1, 3, .01], ['x', 'Horizontal', 0, 100, 1], ['y', 'Vertical', 0, 100, 1]].forEach(([key, label, min, max, step]) => {
                    const wrapper = document.createElement('label');
                    wrapper.className = 'block text-sm mt-3';
                    const caption = document.createElement('span');
                    const input = document.createElement('input');
                    input.type = 'range'; input.min = min; input.max = max; input.step = step;
                    input.value = state[key]; input.disabled = true;
                    input.style.cssText = 'width:100%;display:block;accent-color:#12455e';
                    const atualizar = () => { caption.textContent = `${label}: ${Math.round(state[key] * (key === 'zoom' ? 100 : 1))}%`; };
                    atualizar();
                    input.addEventListener('input', () => {
                        state[key] = Number(input.value); invalidarAjustes(); atualizar(); desenharRecorte(canvas, state);
                        const miniatura = miniaturasPrincipal.get(file);
                        if (miniatura) desenharRecorte(miniatura, state);
                    });
                    controls.push(input);
                    wrapper.append(caption, input); card.appendChild(wrapper);
                });
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'mt-3 inline-flex items-center gap-2 rounded-lg bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm font-medium';
                const trash = document.createElement('i');
                trash.className = 'fa-solid fa-trash-can bg-white text-red-600 rounded p-1';
                trash.setAttribute('aria-hidden', 'true');
                remove.append(trash, document.createTextNode('Remover imagem'));
                remove.addEventListener('click', () => removeFile(index));
                card.appendChild(remove); filePreviewList.appendChild(card);
                state.ready.then(() => { desenharRecorte(canvas, state); controls.forEach(input => { input.disabled = false; }); })
                    .catch(error => { title.textContent = error.message; title.classList.add('text-red-600'); });
            });
            renderGaleriaPrincipal();
        }

        function removeFile(index) {
            const principal = Number(document.getElementById('imagem_principal_idx').value);
            document.getElementById('imagem_principal_idx').value = principal === index ? 0 : principal > index ? principal - 1 : principal;
            selectedFiles.splice(index, 1);
            renderPreviews();
        }

        // Navegação Steps
        document.getElementById('btn-next').addEventListener('click', async () => {
            const next = document.getElementById('btn-next');
            const prev = document.getElementById('btn-prev');
            if (next.disabled) return;
            if (validateStep(currentStep)) {
                if (currentStep === 3) {
                    next.disabled = true; prev.disabled = true;
                    filePreviewList.inert = true; dropArea.inert = true; imageInput.disabled = true;
                    document.getElementById('galeria-principal-container').inert = true;
                    try {
                        const imagens = await gerarImagensAjustadas();
                        const confirmacao = await Swal.fire({
                            icon: 'question', title: 'Confirmar ajustes das imagens',
                            text: 'Você revisou todas as imagens e concorda com os recortes, o zoom e o posicionamento apresentados?',
                            showCancelButton: true, confirmButtonText: 'Sim, concordo com os ajustes',
                            cancelButtonText: 'Continuar ajustando', focusCancel: true
                        });
                        if (!confirmacao.isConfirmed) return;
                        adjustedFiles = imagens; ajustesConfirmados = true;
                    } catch (error) {
                        await Swal.fire({ icon: 'error', title: 'Confira as imagens', text: error.message });
                        return;
                    } finally {
                        next.disabled = false; prev.disabled = false;
                        filePreviewList.inert = false; dropArea.inert = false; imageInput.disabled = false;
                        document.getElementById('galeria-principal-container').inert = false;
                    }
                }
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateUI();
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Confira os dados',
                    text: currentStep === 1 && !window.AtitudeSolicitante.confirmado()
                        ? window.AtitudeSolicitante.mensagem()
                        : currentStep === 3 && selectedFiles.length === 0
                        ? 'Por favor, adicione pelo menos uma imagem do projeto.'
                        : currentStep === 2 && !campoDataInicio.checkValidity()
                        ? campoDataInicio.validationMessage
                        : errosValidacao.join('\n') || 'Por favor, preencha todos os campos obrigatórios (*).'
                });
            }
        });

        document.getElementById('btn-prev').addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateUI();
            }
        });

        function validateStep(step) {
            errosValidacao = [];
            if (step === 1 && !window.AtitudeSolicitante.confirmado()) return false;
            if (step === 2) validarDataInicio();
            const stepDiv = document.getElementById(`step-${step}`);
            const inputs = stepDiv.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            inputs.forEach(input => {
                if (input.disabled) return;
                const valor = input.value.trim();
                const rotulo = { numero_crf: 'Número de registro no CRF/MG', celular: 'Celular', cidade_farmaceutico: 'Cidade' }[input.name] || input.name;
                let erro = '';
                if (!valor) {
                    erro = input.tagName === 'SELECT' ? `Selecione uma opção no campo ${rotulo}.` : `Preencha o campo ${rotulo}.`;
                } else if (input.name === 'numero_crf' && !/^[0-9]{1,50}$/.test(valor)) {
                    erro = 'Informe somente os números do registro no CRF/MG.';
                } else if (input.name === 'celular' && valor.replace(/\D/g, '').length !== 11) {
                    erro = 'Informe o celular completo com DDD e 9 dígitos. Exemplo: (31) 99999-9999.';
                } else if (!input.checkValidity()) {
                    erro = `${rotulo}: ${input.validationMessage || 'Confira o valor informado.'}`;
                }
                if (erro) {
                    input.classList.add('border-red-500');
                    errosValidacao.push(erro);
                    isValid = false;
                } else {
                    if (input.dataset?.limiteAtingido !== 'true') input.classList.remove('border-red-500');
                }
            });

            if (step === 3 && selectedFiles.length === 0) {
                return false;
            }

            return isValid;
        }

        function updateUI() {
            // Alternar containers
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step-${i}`).classList.toggle('hidden', i !== currentStep);
                
                const stepNum = document.getElementById(`step-num-${i}`);
                if (i < currentStep) {
                    stepNum.className = 'step-circle step-completed';
                    stepNum.innerText = '✓';
                } else if (i === currentStep) {
                    stepNum.className = 'step-circle step-active';
                    stepNum.innerText = i;
                } else {
                    stepNum.className = 'step-circle step-inactive';
                    stepNum.innerText = i;
                }
            }

            // Botões
            document.getElementById('btn-prev').classList.toggle('hidden', currentStep === 1);
            document.getElementById('btn-next').classList.toggle('hidden', currentStep === totalSteps);
            document.getElementById('btn-submit').classList.toggle('hidden', currentStep !== totalSteps);

            if (currentStep === 4) {
                carregarResumo();
            }
        }

        function carregarResumo() {
            const form = document.getElementById('form-inscricao');
            const formData = new FormData(form);
            function preencherResumo(id, campos) {
                const container = document.getElementById(id);
                container.replaceChildren();
                campos.forEach(([campo, rotulo, completo]) => {
                    const item = document.createElement('div');
                    item.className = 'min-w-0 break-words' + (completo ? ' md:col-span-2' : '');
                    const label = document.createElement('strong');
                    label.textContent = rotulo + ': ';
                    const valor = document.createElement('span');
                    valor.className = 'whitespace-pre-wrap';
                    let texto = String(formData.get(campo) || '').trim();
                    if (campo === 'tipo_solicitante') texto = texto === 'empresa' ? 'Empresa' : 'Farmacêutico';
                    if (campo === 'data_inicio' && /^\d{4}-\d{2}-\d{2}$/.test(texto)) {
                        texto = texto.split('-').reverse().join('/');
                    }
                    valor.textContent = texto || 'Não informado';
                    item.append(label, valor);
                    container.appendChild(item);
                });
            }
            preencherResumo('resumo-responsavel', [
                ['tipo_solicitante', 'Tipo de solicitante'],
                ['nome', 'Nome / Razão social'],
                ['numero_crf', 'Número do CRF'],
                ['email', 'Email'],
                ['celular', 'Celular'],
                ['cidade_farmaceutico', 'Cidade']
            ]);
            preencherResumo('resumo-projeto', [
                ['nome_projeto', 'Nome do projeto', true],
                ['eixo_projeto', 'Eixo do projeto', true],
                ['numero_pessoas', 'Número de pessoas'],
                ['cidade_projeto', 'Cidade de realização'],
                ['local_projeto', 'Local de realização'],
                ['data_inicio', 'Data de início'],
                ['recursos', 'Recursos / financiamento', true],
                ['resumo_projeto', 'Resumo do projeto', true],
                ['descricao_projeto', 'Descrição do projeto', true],
                ['justificativa', 'Justificativa', true],
                ['pessoas_alcancadas', 'Pessoas alcançadas', true],
                ['beneficios_alcancados', 'Benefícios já alcançados', true],
                ['objetivos_alcancados', 'Objetivos e perspectivas futuras', true]
            ]);

        }

        function renderGaleriaPrincipal() {
            const container = document.getElementById('galeria-principal-container');
            container.replaceChildren(); miniaturasPrincipal = new WeakMap();
            let principal = Number(document.getElementById('imagem_principal_idx').value);
            if (!Number.isInteger(principal) || principal < 0 || principal >= selectedFiles.length) principal = 0;
            document.getElementById('imagem_principal_idx').value = principal;
            selectedFiles.forEach((file, index) => {
                const label = document.createElement('label');
                label.className = 'cursor-pointer border-2 rounded-lg p-2 block bg-white';
                const radio = document.createElement('input');
                radio.type = 'radio'; radio.name = 'select_img_principal'; radio.value = index;
                radio.checked = index === principal;
                radio.setAttribute('aria-label', `Usar imagem ${index + 1} como principal`);
                radio.addEventListener('change', () => setImagemPrincipal(index));
                const titulo = document.createElement('span'); titulo.textContent = ` Imagem ${index + 1}`;
                const canvas = document.createElement('canvas'); canvas.width = 320; canvas.height = 180;
                canvas.style.cssText = 'display:block;width:100%;height:auto;border-radius:6px;margin-top:8px';
                label.append(radio, titulo, canvas); container.appendChild(label);
                miniaturasPrincipal.set(file, canvas);
                const state = obterAjuste(file);
                state.ready.then(() => desenharRecorte(canvas, state)).catch(() => { titulo.textContent = ' Imagem indisponível'; });
            });
            setImagemPrincipal(principal);
        }

        function setImagemPrincipal(index) {
            document.getElementById('imagem_principal_idx').value = index;
            document.querySelectorAll('#galeria-principal-container input[type="radio"]').forEach(radio => {
                const selecionada = Number(radio.value) === index;
                radio.checked = selecionada;
                radio.parentElement.style.borderColor = selecionada ? '#3b5fc0' : '#d1d5db';
            });
        }

        document.getElementById('btn-preview-projeto').addEventListener('click', async () => {
            const index = Number(document.getElementById('imagem_principal_idx').value);
            if (!ajustesConfirmados || !adjustedFiles[index]) {
                await Swal.fire({ icon: 'warning', title: 'Confira a imagem principal', text: 'Selecione a imagem principal e confirme os ajustes no passo 3.' });
                return;
            }
            const form = document.getElementById('form-inscricao');
            const dados = new FormData(form), url = URL.createObjectURL(adjustedFiles[index]);
            try {
                const card = document.createElement('article'); card.className = 'atitude-preview-card';
                const imagem = document.createElement('img'); imagem.src = url;
                imagem.alt = String(dados.get('nome_projeto') || 'Imagem principal do projeto');
                const conteudo = document.createElement('div'); conteudo.className = 'atitude-preview-conteudo';
                const titulo = document.createElement('h3'); titulo.textContent = String(dados.get('nome_projeto') || '');
                const resumo = document.createElement('p'); resumo.textContent = String(dados.get('resumo_projeto') || '');
                const rodape = document.createElement('div'); rodape.className = 'atitude-preview-data';
                const calendario = document.createElement('i'); calendario.className = 'fa-regular fa-calendar'; calendario.setAttribute('aria-hidden', 'true');
                const data = document.createElement('time'); data.dateTime = String(dados.get('data_inicio') || '');
                data.textContent = /^\d{4}-\d{2}-\d{2}$/.test(data.dateTime) ? data.dateTime.split('-').reverse().join('/') : data.dateTime;
                rodape.append(calendario, data); conteudo.append(titulo, resumo, rodape); card.append(imagem, conteudo);
                await Swal.fire({ title: 'Preview do projeto', html: card, width: 500, showCloseButton: true, confirmButtonText: 'Fechar', confirmButtonColor: '#12455e' });
            } finally { URL.revokeObjectURL(url); }
        });

        // Submissão via AJAX
        document.getElementById('form-inscricao').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!ajustesConfirmados || currentStep !== 4) {
                Swal.fire({ icon: 'warning', title: 'Confirme os ajustes das imagens', text: 'Revise as imagens no passo 3 e confirme os recortes antes de enviar.' });
                return;
            }
            if (!this.reportValidity()) return;
            const submitButton = document.getElementById('btn-submit');
            if (submitButton.disabled) return;
            submitButton.disabled = true;
            const formData = new FormData(this);
            // Sobrescrever imagens do input file padrão pelo array manipulado no JS
            formData.delete('imagens[]');
            adjustedFiles.forEach(file => {
                formData.append('imagens[]', file);
            });

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(async data => {
                if (data.csrf_hash) {
                    const csrf = document.getElementById('inscricao-csrf'); csrf.name = data.csrf_name; csrf.value = data.csrf_hash;
                }
                if (data.status) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Inscrição enviada',
                        text: data.message || 'Inscrição enviada com sucesso!',
                        confirmButtonText: 'OK'
                    });
                    window.location.reload();
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Não foi possível enviar a inscrição',
                        text: data.message || (data.erros || []).join('\n') || 'Confira os dados e tente novamente.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                return Swal.fire({ icon: 'error', title: 'Erro ao enviar', text: 'Ocorreu um erro ao enviar o formulário. Tente novamente.', confirmButtonText: 'OK' });
            })
            .finally(() => { submitButton.disabled = false; });
        });
    </script>
    </main>
    <?php $this->load->view('fixo/rodape'); ?>
</body>
</html>
