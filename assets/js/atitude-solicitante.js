(() => {
    'use strict';
    const form = document.getElementById('form-inscricao');
    const registro = document.getElementById('numero_crf');
    const botaoBuscar = document.getElementById('buscar-solicitante');
    const nome = document.getElementById('nome');
    const cidade = document.getElementById('cidade');
    const cidadeEmpresa = document.getElementById('cidade-empresa');
    const status = document.getElementById('solicitante-status');
    const csrf = document.getElementById('inscricao-csrf');
    const tipos = Array.from(form.querySelectorAll('input[name="tipo_solicitante"]'));
    const camposSolicitante = Array.from(form.querySelectorAll('#step-1 input:not([name="tipo_solicitante"]):not([name="numero_crf"]), #step-1 select, #step-1 textarea'));
    const tipoAtual = () => tipos.find(input => input.checked).value;
    const chaveAtual = () => `${tipoAtual()}:${registro.value.trim()}`;
    let chaveConfirmada = '', buscando = false;
    let ultimaBuscaAutomatica = '';
    let cidadeExtra = null;
    let mensagem = 'Consulte o cadastro do solicitante na base do CRF/MG antes de continuar a inscrição.';
    window.AtitudeSolicitante = {
        confirmado: () => !buscando && chaveConfirmada !== '' && chaveConfirmada === chaveAtual() && nome.value !== '',
        mensagem: () => mensagem
    };
    function invalidar() {
        camposSolicitante.forEach(campo => { campo.disabled = true; });
        if (cidadeExtra) { cidadeExtra.remove(); cidadeExtra = null; }
        chaveConfirmada = ''; nome.value = ''; cidade.value = ''; cidadeEmpresa.value = '';
        mensagem = 'Consulte o cadastro do solicitante na base do CRF/MG antes de continuar a inscrição.';
        status.textContent = mensagem; status.className = 'text-sm text-gray-600 mt-2';
        document.getElementById('solicitante-nome-label').textContent = tipoAtual() === 'empresa' ? '*Razão social:' : '*Nome:';
    }
    function alterarCadastro() {
        invalidar();
        ultimaBuscaAutomatica = '';
    }
    tipos.forEach(input => input.addEventListener('change', alterarCadastro));
    registro.addEventListener('input', alterarCadastro);
    registro.addEventListener('blur', buscarSolicitante);
    jQuery(function () {
        jQuery(botaoBuscar).on('click', buscarSolicitante);
    });
    registro.addEventListener('keydown', event => { if (event.key === 'Enter') event.preventDefault(); });
    invalidar();
    async function buscarSolicitante(event) {
        if (event) event.preventDefault();
        if (buscando) return;
        const numero = registro.value.trim(), tipo = tipoAtual(), chave = chaveAtual();
        if (chave === ultimaBuscaAutomatica || numero === '') return;
        invalidar();
        if (!/^[0-9]{1,50}$/.test(numero)) {
            await Swal.fire({ icon: 'warning', title: 'Informe o registro', text: 'Digite o número de registro no CRF/MG para consultar o cadastro.' });
            return;
        }
        ultimaBuscaAutomatica = chave;
        buscando = true; registro.disabled = true; botaoBuscar.disabled = true;
        tipos.forEach(input => { input.disabled = true; });
        document.getElementById('btn-next').disabled = true;
        status.textContent = 'Consultando a base do CRF/MG…';
        try {
            const parametros = { crfmg: numero, contexto: 'atitude_farmaceutica' };
            if (csrf.name && csrf.value) parametros[csrf.name] = csrf.value;
            const response = await new Promise((resolve, reject) => {
                jQuery.ajax({
                    url: tipo === 'empresa' ? registro.dataset.pjUrl : registro.dataset.pfUrl,
                    type: 'POST', dataType: 'json', data: parametros, timeout: 30000,
                    success: (dados, textStatus, xhr) => resolve({ dados, status: xhr.status, ok: true }),
                    error: (xhr, textStatus, errorThrown) => {
                        console.error('[Atitude Farmacêutica] Erro na consulta:', xhr.status, textStatus, errorThrown);
                        if (xhr.responseJSON) resolve({ dados: xhr.responseJSON, status: xhr.status, ok: false });
                        else reject(new Error('Não foi possível consultar a base do CRF/MG. Atualize a página e tente novamente.'));
                    }
                });
            });
            const dados = response.dados;
            if (!dados || typeof dados !== 'object' || Array.isArray(dados)) {
                console.error('Resposta inválida de ' + (tipo === 'empresa' ? 'ConsultaPJ' : 'ConsultaPF') + ':', dados);
                throw new Error('A consulta retornou uma resposta vazia ou inválida. Tente novamente.');
            }
            const { csrf_name, csrf_hash, ...retornoConsulta } = dados;
            console.log('Retorno de ' + (tipo === 'empresa' ? 'ConsultaPJ' : 'ConsultaPF') + ':', retornoConsulta);
            console.log('Registro consultado:', numero, 'Status HTTP:', response.status);
            if (dados.csrf_hash) { csrf.name = dados.csrf_name; csrf.value = dados.csrf_hash; }
            if (!response.ok || dados.type !== 'success' || !dados.status) throw new Error(dados.message || 'Não foram encontrados dados na base de dados do CRF/MG. Não será possível realizar a inscrição.');
            const nomeRetornado = tipo === 'empresa' ? dados.RazaoSocial : dados.Nome;
            if (typeof nomeRetornado !== 'string' || !nomeRetornado.trim() || typeof dados.Cidade !== 'string' || (!dados.Cidade.trim() && dados.cidade_manual !== true)) throw new Error('O cadastro retornou dados incompletos. Não será possível realizar a inscrição.');
            if (chave !== chaveAtual()) return;
            nome.value = nomeRetornado; chaveConfirmada = chave;
            camposSolicitante.forEach(campo => { campo.disabled = false; });
            const empresa = tipo === 'empresa';
            cidade.disabled = empresa;
            cidadeEmpresa.disabled = !empresa;
            if (empresa) {
                const opcao = Array.from(cidade.options).find(item => item.value.localeCompare(dados.Cidade.trim(), 'pt-BR', { sensitivity: 'base' }) === 0);
                if (!opcao) {
                    cidadeExtra = document.createElement('option');
                    cidadeExtra.value = dados.Cidade.trim(); cidadeExtra.textContent = dados.Cidade.trim();
                    cidade.appendChild(cidadeExtra);
                }
                cidade.value = opcao ? opcao.value : cidadeExtra.value;
                cidadeEmpresa.value = dados.Cidade.trim();
            }
            mensagem = 'Cadastro localizado. Confira os demais dados para continuar.';
            if (!empresa) mensagem += ' Selecione sua cidade no campo abaixo.';
            status.textContent = mensagem; status.className = 'text-sm text-green-700 mt-2';
        } catch (error) {
            mensagem = error.message; status.textContent = mensagem; status.className = 'text-sm text-red-600 mt-2';
            await Swal.fire({ icon: 'warning', title: 'Inscrição não liberada', text: mensagem });
        } finally {
            buscando = false; registro.disabled = false; botaoBuscar.disabled = false;
            tipos.forEach(input => { input.disabled = false; });
            document.getElementById('btn-next').disabled = false;
        }
    }
})();
