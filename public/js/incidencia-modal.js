console.log('JavaScript cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('incidenciaForm');
    const fields = {
        descripcion: { required: true, message: 'La descripción es obligatoria.' },
        categoria_id: { required: true, message: 'Seleccione una categoría.' },
        subcategoria_id: { required: true, message: 'Seleccione una subcategoría.' }
    };

    // Función para validar un campo
    function validateField(input, rules) {
        if (!input) return true;
        const errorDiv = document.getElementById(`${input.id}-error`);
        if (!input.value && rules.required) {
            if (errorDiv) {
                errorDiv.textContent = rules.message;
                errorDiv.classList.remove('hidden');
            }
            input.classList.add('border-red-500');
            return false;
        }
        if (errorDiv) {
            errorDiv.classList.add('hidden');
        }
        input.classList.remove('border-red-500');
        return true;
    }

    // Agregar eventos blur a todos los campos
    Object.keys(fields).forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (input) {
            input.addEventListener('blur', () => validateField(input, fields[fieldId]));
        }
    });

    // Validar formulario al enviar
    form.addEventListener('submit', function(event) {
        console.log('Formulario enviado');
        let isValid = true;
        Object.keys(fields).forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input && !validateField(input, fields[fieldId])) {
                isValid = false;
            }
        });

        if (!isValid) {
            event.preventDefault();
            // Show a general error message
            const errorMessage = document.getElementById('form-error');
            if (errorMessage) {
                errorMessage.textContent = 'Por favor, complete todos los campos requeridos correctamente.';
                errorMessage.classList.remove('hidden');
            }
        } else {
            // Remove any existing error message
            const errorMessage = document.getElementById('form-error');
            if (errorMessage) {
                errorMessage.classList.add('hidden');
            }
        }
    });
});

function confirmarCierre(incidenciaId) {
    if (confirm('¿Estás seguro de que deseas cerrar esta incidencia?')) {
        fetch(`/incidencias/${incidenciaId}/cerrar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Recargar la página para ver los cambios
            } else {
                alert(data.message || 'Hubo un error al intentar cerrar la incidencia');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error en la solicitud');
        });
    }
}