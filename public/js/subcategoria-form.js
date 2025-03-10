document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('subcategoriaForm');
    const categoriaInput = document.getElementById('categoria_id');
    const nombreInput = document.getElementById('nombre_subcategoria');
    const categoriaError = document.getElementById('categoria_id-error');
    const nombreError = document.getElementById('nombre_subcategoria-error');

    categoriaInput.addEventListener('blur', validateCategoria);
    nombreInput.addEventListener('blur', validateNombre);
    form.addEventListener('submit', function(event) {
        if (!validateCategoria() || !validateNombre()) {
            event.preventDefault();
        }
    });

    function validateCategoria() {
        const value = categoriaInput.value.trim();
        categoriaError.textContent = '';
        categoriaInput.classList.remove('border-red-500');

        if (!value) {
            showError(categoriaError, 'Seleccione una categoría', categoriaInput);
            return false;
        }

        return true;
    }

    function validateNombre() {
        const value = nombreInput.value.trim();
        nombreError.textContent = '';
        nombreInput.classList.remove('border-red-500');

        if (!value) {
            showError(nombreError, 'El nombre de la subcategoría es obligatorio', nombreInput);
            return false;
        }

        if (value.length > 255) {
            showError(nombreError, 'El nombre no puede exceder los 255 caracteres', nombreInput);
            return false;
        }

        return true;
    }

    function showError(errorElement, message, inputElement) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        inputElement.classList.add('border-red-500');
    }
}); 