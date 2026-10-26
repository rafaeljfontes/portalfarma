(() => {
    'use strict';
    const form = document.getElementById('atitude-votacao-form');
    if (!form) return;
    const lista = document.getElementById('atitude-projetos-publicos');
    const botao = document.getElementById('atitude-votar-botao');
    const emailInput = document.getElementById('atitude-voto-email');
    const contador = document.getElementById('atitude-votos-contador');
    const ajuda = document.getElementById('atitude-votos-ajuda');
    const csrf = document.getElementById('atitude-voto-csrf');
    const limite = Number(form.dataset.limite);
    const opcoes = Array.from(lista.querySelectorAll('.atitude-voto-checkbox'));
    let enviando = false, concluido = false;
    const selecionados = () => opcoes.filter(input => input.checked);
    function atualizar() {
        let avaliados = 0;
        opcoes.forEach(input => {
            const card = input.closest('.atitude-projeto');
            card.querySelector('.atitude-voto-avaliacao').hidden = !input.checked;
            card.querySelectorAll('fieldset').forEach(campo => { campo.disabled = enviando || concluido || !input.checked; });
            input.disabled = enviando || concluido;
            if (input.checked && card.querySelectorAll('input[type="radio"]:checked').length === 5) avaliados++;
        });
        const total = selecionados().length;
        contador.textContent = `${total}/${limite} projetos selecionados · ${avaliados}/${limite} avaliados`;
        ajuda.textContent = concluido ? 'Sua participação foi registrada. Obrigado!' : total !== limite
            ? `Selecione exatamente ${limite} projeto(s).` : avaliados !== limite
                ? 'Preencha os cinco critérios de cada projeto.' : !emailInput.validity.valid
                    ? 'Informe um e-mail válido para confirmar.' : 'Avaliação pronta para envio.';
        botao.disabled = enviando || concluido || total !== limite || avaliados !== limite || !emailInput.validity.valid;
        emailInput.readOnly = enviando || concluido;
    }
    lista.addEventListener('change', event => {
        if (event.target.matches('.atitude-voto-checkbox') && selecionados().length > limite) {
            event.target.checked = false;
            Swal.fire({ icon: 'warning', title: 'Limite de projetos', text: `Você pode selecionar exatamente ${limite} projeto(s). Desmarque um projeto antes de selecionar outro.` });
        }
        atualizar();
    });
    emailInput.addEventListener('input', atualizar);
    form.addEventListener('submit', async event => {
        event.preventDefault();
        if (enviando || concluido) return;
        const escolhas = selecionados();
        if (escolhas.length !== limite) {
            await Swal.fire({ icon: 'warning', title: 'Confira a seleção', text: `Selecione exatamente ${limite} projeto(s) para votar.` });
            return;
        }
        if (escolhas.some(input => input.closest('.atitude-projeto').querySelectorAll('input[type="radio"]:checked').length !== 5)) {
            await Swal.fire({ icon: 'warning', title: 'Avaliação incompleta', text: 'Atribua uma nota de 1 a 5 nos cinco critérios de todos os projetos selecionados.' });
            return;
        }
        if (!emailInput.reportValidity()) return;
        // Congela os projetos e as notas durante o envio da avaliação.
        const dados = new URLSearchParams();
        dados.set('email', emailInput.value.trim());
        dados.set('token', form.elements.token.value);
        escolhas.forEach(input => {
            dados.append('projetos[]', input.value);
            input.closest('.atitude-projeto').querySelectorAll('input[type="radio"]:checked').forEach(nota => dados.append(nota.name, nota.value));
        });
        enviando = true;
        atualizar();
        async function enviar() {
            const body = new URLSearchParams(dados);
            if (csrf.name && csrf.value) body.set(csrf.name, csrf.value);
            const response = await fetch(form.action, { method: 'POST', body, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (response.redirected) throw new Error('Sua sessão expirou. Atualize a página e tente novamente.');
            let data;
            try { data = await response.json(); }
            catch (error) { throw new Error('O servidor não conseguiu processar a solicitação. Atualize a página e tente novamente.'); }
            if (data.csrf_hash) { csrf.name = data.csrf_name; csrf.value = data.csrf_hash; }
            if (!response.ok || !data.status) throw new Error(data.message || 'Não foi possível registrar o voto.');
            return data;
        }
        try {
            const resultado = await Swal.fire({
                title: 'Confirme sua avaliação', text: `Confirma o envio da avaliação de ${limite} projeto(s) com o e-mail ${dados.get('email')}? É permitido um único envio por e-mail e por IP.`,
                showCancelButton: true, confirmButtonText: 'Confirmar voto', cancelButtonText: 'Continuar avaliando',
                showLoaderOnConfirm: true, allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: async () => {
                    try { return await enviar(); }
                    catch (error) { Swal.showValidationMessage(error.message); return false; }
                }
            });
            if (!resultado.isConfirmed) return;
            concluido = true;
            await Swal.fire({ icon: 'success', title: 'Voto registrado com sucesso!', text: resultado.value.message + ' Protocolo: ' + resultado.value.codigo });
        } catch (error) {
            await Swal.fire({ icon: 'error', title: 'Não foi possível votar', text: error.message });
        } finally { enviando = false; atualizar(); }
    });
    atualizar();
})();