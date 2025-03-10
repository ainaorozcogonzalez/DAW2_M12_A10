document.addEventListener('DOMContentLoaded', function() {
    const incidenciaModal = document.getElementById('incidenciaModal');
    const incidenciaForm = document.getElementById('incidencia-form');

    window.openIncidenciaModal = function(incidencia) {
        if (incidencia) {
            document.getElementById('titulo').value = incidencia.titulo;
            document.getElementById('descripcion').value = incidencia.descripcion;
            document.getElementById('estado').value = incidencia.estado;
            document.getElementById('prioridad').value = incidencia.prioridad;
            document.getElementById('cliente_id').value = incidencia.cliente_id;
            document.getElementById('tecnico_id').value = incidencia.tecnico_id;
            incidenciaModal.classList.remove('hidden');
        }
    }

    window.closeIncidenciaModal = function() {
        incidenciaModal.classList.add('hidden');
    }

    // Cerrar modal al hacer clic fuera de él
    window.onclick = function(event) {
        if (event.target == incidenciaModal) {
            closeIncidenciaModal();
        }
    }

    // Función para resetear el formulario
    function resetForm() {
        incidenciaForm.reset();
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.classList.add('hidden'));
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => input.classList.remove('border-red-500'));
    }

    // Validaciones del formulario
    const fields = {
        titulo: { required: true, message: 'El título es obligatorio.' },
        descripcion: { required: true, message: 'La descripción es obligatoria.' },
        estado: { required: true, message: 'Seleccione un estado.' },
        prioridad: { required: true, message: 'Seleccione una prioridad.' },
        cliente_id: { required: true, message: 'Seleccione un cliente.' },
        tecnico_id: { required: true, message: 'Seleccione un técnico.' }
    };

    // Función para validar un campo
    function validateField(input, rules) {
        const value = input.value.trim();
        const errorDiv = document.getElementById(`${input.id}-error`);
        
        if (!errorDiv) {
            console.error(`No se encontró el div de error para el input: ${input.id}`);
            return false;
        }

        errorDiv.className = 'text-red-500 text-sm mt-1';
        input.classList.remove('border-red-500');

        // Limpiar mensajes anteriores
        errorDiv.textContent = '';

        // Validar campo requerido
        if (rules.required && !value) {
            errorDiv.textContent = rules.message;
            errorDiv.classList.remove('hidden');
            input.classList.add('border-red-500');
            return false;
        }

        // Si pasa todas las validaciones
        errorDiv.classList.add('hidden');
        input.classList.remove('border-red-500');
        return true;
    }

    // Agregar eventos blur a todos los campos
    Object.keys(fields).forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (input) {
            input.addEventListener('blur', () => {
                console.log(`Validando campo: ${fieldId}`); // Para depuración
                validateField(input, fields[fieldId]);
            });
        } else {
            console.error(`No se encontró el input: ${fieldId}`);
        }
    });

    // Validar formulario al enviar
    incidenciaForm.addEventListener('submit', function(event) {
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
}); 