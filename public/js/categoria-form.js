document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('categoriaForm');
    const nombreInput = document.getElementById('nombre_categoria');
    const errorDiv = document.getElementById('nombre_categoria-error');

    nombreInput.addEventListener('blur', validateNombre);
    form.addEventListener('submit', function(event) {
        if (!validateNombre()) {
            event.preventDefault();
        }
    });

    function validateNombre() {
        const value = nombreInput.value.trim();
        errorDiv.textContent = '';
        nombreInput.classList.remove('border-red-500');

        if (!value) {
            showError('El nombre de la categoría es obligatorio');
            return false;
        }

        if (value.length > 255) {
            showError('El nombre no puede exceder los 255 caracteres');
            return false;
        }

        return true;
    }

    function showError(message) {
        errorDiv.textContent = message;
        nombreInput.classList.add('border-red-500');
    }
}); 