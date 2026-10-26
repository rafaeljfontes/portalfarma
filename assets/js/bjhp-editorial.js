(function () {
    'use strict';
    var input = document.getElementById('foto');
    var preview = document.getElementById('bjhp-photo-preview');
    var placeholder = document.getElementById('bjhp-photo-placeholder');
    var error = document.getElementById('bjhp-photo-error');
    var objectUrl;
    var currentPhoto = preview.getAttribute('src');
    function clear() {
        if (objectUrl) URL.revokeObjectURL(objectUrl);
        objectUrl = null;
        if (currentPhoto) preview.src = currentPhoto;
        else preview.removeAttribute('src');
        preview.hidden = !currentPhoto;
        placeholder.hidden = !!currentPhoto;
        error.textContent = '';
        input.setCustomValidity('');
    }
    input.addEventListener('change', function () {
        clear();
        var file = input.files[0];
        if (!file) return;
        if (!/\.(png|jpe?g)$/i.test(file.name) || (file.type && !['image/png', 'image/jpeg'].includes(file.type))) {
            error.textContent = 'Selecione uma imagem PNG ou JPG.';
        } else if (file.size > 2 * 1024 * 1024) {
            error.textContent = 'A foto deve ter no máximo 2 MB.';
        }
        if (error.textContent) { input.setCustomValidity(error.textContent); return; }
        objectUrl = URL.createObjectURL(file);
        preview.src = objectUrl;
        preview.hidden = false;
        placeholder.hidden = true;
    });
    preview.addEventListener('error', function () {
        if (!objectUrl) return;
        clear();
        error.textContent = 'Não foi possível abrir esta imagem. Selecione outro arquivo.';
        input.setCustomValidity(error.textContent);
    });
    document.getElementById('bjhp-form').addEventListener('reset', clear);
}());
