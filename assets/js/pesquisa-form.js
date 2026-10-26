(function () {
    'use strict';
    const form = document.getElementById('form');
    const button = document.getElementById('btn-send');
    const feedback = document.getElementById('nps-feedback');
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        if (!form.reportValidity() || button.disabled) return;
        button.disabled = true;
        feedback.textContent = 'Enviando respostas…';
        try {
            const response = await fetch(form.action, {method: 'POST', body: new FormData(form)});
            if (!response.ok) throw new Error('Falha no envio');
            const result = await response.json();
            if (result.status !== 'success') {
                feedback.textContent = result.message || 'Não foi possível salvar suas respostas.';
                button.disabled = false;
                return;
            }
            feedback.textContent = 'Obrigado pelo seu feedback!';
            if (form.dataset.embedded === '1' && window.parent !== window) {
                setTimeout(function () {
                    window.parent.postMessage({type: 'portalfarma:nps-success', courseId: form.dataset.courseId}, window.location.origin);
                }, 900);
            } else {
                form.reset();
                button.disabled = false;
            }
        } catch (error) {
            feedback.textContent = 'Não foi possível enviar. Verifique sua conexão e tente novamente.';
            button.disabled = false;
        }
    });
}());
