document.addEventListener('DOMContentLoaded', function() {
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const modalTitle = document.getElementById('modalTitle');
    const formMethod = document.getElementById('formMethod');
    const userIdInput = document.getElementById('user_id');

    // Funciones para abrir/cerrar el modal
    window.openUserModal = function() {
        modalTitle.innerText = 'Crear Nuevo Usuario';
        formMethod.value = 'POST';
        userForm.action = userForm.dataset.storeUrl;
        userIdInput.value = '';
        resetForm();
        userModal.classList.remove('hidden');
    }

    window.openEditModal = function(userId) {
        console.log('Editando usuario con ID:', userId);
        fetch(`/users/${userId}/edit`)
            .then(response => response.json())
            .then(user => {
                console.log('Datos del usuario recibidos:', user);
                
                modalTitle.innerText = 'Editar Usuario';
                formMethod.value = 'PUT';
                userForm.action = `/users/${userId}`;
                userIdInput.value = user.id;
                
                // Verificar que los elementos existen
                const rolField = document.getElementById('rol_id');
                const sedeField = document.getElementById('sede_id');
                console.log('Campo rol_id:', rolField);
                console.log('Campo sede_id:', sedeField);
                
                if (rolField) {
                    rolField.value = user.rol_id;
                    console.log('Valor de rol_id establecido:', rolField.value);
                }
                if (sedeField) {
                    sedeField.value = user.sede_id;
                    console.log('Valor de sede_id establecido:', sedeField.value);
                }
                
                document.getElementById('nombre').value = user.nombre;
                document.getElementById('email').value = user.email;
                document.getElementById('estado').value = user.estado;
                document.getElementById('password').required = false;
                
                userModal.classList.remove('hidden');
            });
    }

    window.closeUserModal = function() {
        userModal.classList.add('hidden');
    }

    // Cerrar modal al hacer clic fuera de él
    window.onclick = function(event) {
        if (event.target == userModal) {
            closeUserModal();
        }
    }

    // Función para resetear el formulario
    function resetForm() {
        userForm.reset();
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.classList.add('hidden'));
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => input.classList.remove('border-red-500'));
    }

    // Validaciones del formulario
    const fields = {
        nombre: { 
            required: true, 
            regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
            message: 'El nombre solo puede contener letras y espacios.'
        },
        email: {
            required: true,
            regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
            message: 'El formato del email no es válido.'
        },
        password: {
            required: function() { return formMethod.value === 'POST'; },
            regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/,
            message: 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.'
        },
        rol_id: { required: true, message: 'Seleccione un rol' },
        sede_id: { required: true, message: 'Seleccione una sede' },
        estado: { required: true, message: 'Seleccione un estado' }
    };

    // Agregar eventos blur a todos los campos
    // Object.keys(fields).forEach(fieldId => {
    //     const input = document.getElementById(fieldId);
    //     if (input) {
    //         input.addEventListener('blur', () => validateField(input, fields[fieldId]));
    //     }
    // });

    // Validar formulario al enviar
    userForm.addEventListener('submit', function(event) {
        console.log('Formulario enviado:', {
            action: userForm.action,
            method: formMethod.value,
            data: new FormData(userForm)
        });
        
        // Verificar valores de los campos
        console.log('rol_id:', document.getElementById('rol_id').value);
        console.log('sede_id:', document.getElementById('sede_id').value);
        
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

    // function validateField(input, rules) {
    //     const errorDiv = document.getElementById(`${input.id}-error`);
    //     errorDiv.textContent = '';
    //     input.classList.remove('border-red-500');

    //     const value = input.value.trim();

    //     if (rules.required && (typeof rules.required === 'function' ? rules.required() : rules.required) && !value) {
    //         showError(errorDiv, 'Este campo es obligatorio', input);
    //         return false;
    //     }

    //     if (rules.regex && value && !rules.regex.test(value)) {
    //         showError(errorDiv, rules.message, input);
    //         return false;
    //     }

    //     return true;
    // }

    function showError(errorDiv, message, input) {
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
        input.classList.add('border-red-500');
    }
}); 