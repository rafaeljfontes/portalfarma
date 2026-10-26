(function () {
    'use strict';
    const page = document.getElementById('cert-page');
    const modal = document.getElementById('cert-modal');
    const frame = document.getElementById('cert-nps');
    const cpf = document.getElementById('cert-cpf');
    const button = document.getElementById('cert-download');
    const feedback = document.getElementById('cert-feedback');
    function unlock(message) {
        document.getElementById('cert-question').hidden = true;
        document.getElementById('cert-help').textContent = 'Informe o CPF utilizado na inscrição do curso.';
        cpf.disabled = button.disabled = false;
        feedback.textContent = message;
        cpf.focus();
    }
    document.getElementById('cert-skip').onclick = function () { unlock(''); };
    document.getElementById('cert-yes').onclick = function () {
        if (!frame.getAttribute('src')) frame.src = frame.dataset.src;
        modal.showModal();
    };
    document.getElementById('cert-close').onclick = function () { modal.close(); };
    window.addEventListener('message', function (event) {
        if (event.origin !== window.location.origin || event.source !== frame.contentWindow || !event.data ||
            event.data.type !== 'portalfarma:nps-success' || String(event.data.courseId) !== page.dataset.courseId) return;
        modal.close();
        unlock('Obrigado pelo seu feedback!');
    });
    cpf.addEventListener('input', function () {
        const digits = cpf.value.replace(/\D/g, '').slice(0, 11);
        cpf.value = digits.replace(/^(\d{3})(\d)/, '$1.$2').replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3').replace(/(\d{3})(\d{1,2})$/, function (match, a, b, offset) { return digits.length > 9 && offset > 5 ? a + '-' + b : match; });
        cpf.setCustomValidity('');
    });
    function validCpf(value) {
        const digits = value.replace(/\D/g, '');
        if (!/^\d{11}$/.test(digits) || /^(\d)\1{10}$/.test(digits)) return false;
        for (let t = 9; t < 11; t++) {
            let sum = 0;
            for (let i = 0; i < t; i++) sum += Number(digits[i]) * (t + 1 - i);
            if (Number(digits[t]) !== (sum * 10 % 11) % 10) return false;
        }
        return true;
    }
    document.getElementById('cert-form').addEventListener('submit', async function (event) {
        event.preventDefault();
        if (cpf.disabled || button.disabled) return;
        if (!validCpf(cpf.value)) { cpf.setCustomValidity('Informe um CPF válido.'); cpf.reportValidity(); return; }
        button.disabled = true;
        feedback.textContent = 'Verificando participação e preparando o certificado…';
        try {
            const response = await fetch(this.action, {method: 'POST', body: new FormData(this)});
            if (!response.ok || !(response.headers.get('content-type') || '').includes('application/pdf')) {
                let message = 'Não foi possível gerar o certificado. Tente novamente.';
                try { message = (await response.json()).message || message; } catch (_) { /* resposta não JSON */ }
                throw new Error(message);
            }
            const url = URL.createObjectURL(await response.blob());
            const link = document.createElement('a');
            link.href = url;
            link.download = 'certificado-' + page.dataset.courseId + '.pdf';
            document.body.appendChild(link); link.click(); link.remove();
            setTimeout(function () { URL.revokeObjectURL(url); }, 30000);
            feedback.textContent = 'Certificado gerado. O download foi iniciado.';
        } catch (error) { feedback.textContent = error.message; }
        finally { button.disabled = false; }
    });
}());
