(function () {
    'use strict';
    var form = document.getElementById('bjhp-form');
    if (!form) return;
    var button = document.getElementById('bjhp-submit');
    var alert = document.getElementById('bjhp-alert');
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        if (button.disabled) return;
        var original = button.textContent;
        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        button.textContent = 'Processando…';
        alert.className = 'd-none';
        try {
            var response = await fetch(form.action, {
                method: 'POST', credentials: 'same-origin',
                headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'},
                body: new FormData(form)
            });
            var data;
            try { data = await response.json(); }
            catch (_) { throw new Error('Resposta inesperada. Atualize a página para verificar o resultado antes de tentar novamente.'); }
            if (!response.ok) throw new Error(data.message || 'Não foi possível concluir a operação.');
            if (data.historico) {
                var row = document.createElement('tr');
                ['criado_em', 'usuario_nome', 'usuario_id', 'artigos', 'edicoes'].forEach(function (key) {
                    var cell = document.createElement('td');
                    cell.textContent = data.historico[key];
                    row.appendChild(cell);
                });
                document.getElementById('bjhp-history').replaceChildren(row);
            } else if (data.redirect) {
                window.location.assign(data.redirect);
                return;
            } else { form.reset(); }
            alert.className = 'alert alert-success';
            alert.textContent = data.message;
        } catch (error) {
            alert.className = 'alert alert-danger';
            alert.textContent = error.message || 'Falha de conexão. Verifique o histórico antes de tentar novamente.';
        } finally {
            button.disabled = false;
            button.removeAttribute('aria-busy');
            button.textContent = original;
        }
    });
}());
