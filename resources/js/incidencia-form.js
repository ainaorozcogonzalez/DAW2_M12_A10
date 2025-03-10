document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('incidenciaForm');
    const fields = {
        cliente_id: { required: true, message: 'Seleccione un cliente' },
        incidencia_sede_id: { required: true, message: 'Seleccione una sede' },
        categoria_id: { required: true, message: 'Seleccione una categoría' },
        subcategoria_id: { required: true, message: 'Seleccione una subcategoría' },
        descripcion: { 
            required: true, 
            minLength: 10, 
            maxLength: 1000, 
            messages: {
                required: 'La descripción es obligatoria',
                minLength: 'La descripción debe tener al menos 10 caracteres',
                maxLength: 'La descripción no puede exceder los 1000 caracteres'
            }
        },
        estado_id: { required: true, message: 'Seleccione un estado' },
        prioridad_id: { required: true, message: 'Seleccione una prioridad' }
    };

    // Agregar eventos blur a todos los campos
    Object.keys(fields).forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (input) {
            input.addEventListener('blur', () => validateField(input, fields[fieldId]));
        }
    });

    // Validar formulario al enviar
    form.addEventListener('submit', function(event) {
        let isValid = true;
        Object.keys(fields).forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input && !validateField(input, fields[fieldId])) {
                isValid = false;
            }
        });

        if (!isValid) {
            event.preventDefault();
        }
    });

    function validateField(input, rules) {
        const value = input.value.trim();
        const errorDiv = input.parentNode.querySelector('.error-message') || 
                        document.createElement('div');
        
        errorDiv.className = 'text-red-500 text-sm mt-1 error-message';
        input.classList.remove('border-red-500');

        // Limpiar mensajes anteriores
        errorDiv.textContent = '';

        // Validar campo requerido
        if (rules.required && !value) {
            errorDiv.textContent = rules.message;
            input.classList.add('border-red-500');
            if (!input.parentNode.contains(errorDiv)) {
                input.parentNode.appendChild(errorDiv);
            }
            return false;
        }

        // Validar longitud mínima
        if (rules.minLength && value.length < rules.minLength) {
            errorDiv.textContent = rules.messages.minLength;
            input.classList.add('border-red-500');
            if (!input.parentNode.contains(errorDiv)) {
                input.parentNode.appendChild(errorDiv);
            }
            return false;
        }

        // Validar longitud máxima
        if (rules.maxLength && value.length > rules.maxLength) {
            errorDiv.textContent = rules.messages.maxLength;
            input.classList.add('border-red-500');
            if (!input.parentNode.contains(errorDiv)) {
                input.parentNode.appendChild(errorDiv);
            }
            return false;
        }

        // Si pasa todas las validaciones
        if (input.parentNode.contains(errorDiv)) {
            input.parentNode.removeChild(errorDiv);
        }
        return true;
    }
}); 