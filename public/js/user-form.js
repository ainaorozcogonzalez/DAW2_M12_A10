document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const nombre = document.getElementById('nombre');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const rol = document.getElementById('rol_id');
    const sede = document.getElementById('sede_id');
    const estado = document.getElementById('estado');

    const nombreError = document.getElementById('nombre-error');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');
    const rolError = document.getElementById('rol-error');
    const sedeError = document.getElementById('sede-error');
    const estadoError = document.getElementById('estado-error');

    function validateNombre() {
        const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        if (!regex.test(nombre.value)) {
            nombreError.textContent = 'El nombre solo puede contener letras y espacios.';
            nombreError.classList.remove('hidden');
            nombre.classList.add('border-red-500');
            return false;
        }
        nombreError.classList.add('hidden');
        nombre.classList.remove('border-red-500');
        return true;
    }

    function validateEmail() {
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!regex.test(email.value)) {
            emailError.textContent = 'El formato del email no es válido.';
            emailError.classList.remove('hidden');
            email.classList.add('border-red-500');
            return false;
        }
        emailError.classList.add('hidden');
        email.classList.remove('border-red-500');
        return true;
    }

    function validatePassword() {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        if (!regex.test(password.value)) {
            passwordError.textContent = 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.';
            passwordError.classList.remove('hidden');
            password.classList.add('border-red-500');
            return false;
        }
        passwordError.classList.add('hidden');
        password.classList.remove('border-red-500');
        return true;
    }

    function validateSelect(select, errorElement) {
        if (select.value === '') {
            errorElement.textContent = 'Este campo es obligatorio.';
            errorElement.classList.remove('hidden');
            select.classList.add('border-red-500');
            return false;
        }
        errorElement.classList.add('hidden');
        select.classList.remove('border-red-500');
        return true;
    }

    function validateForm() {
        const isNombreValid = validateNombre();
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();
        const isRolValid = validateSelect(rol, rolError);
        const isSedeValid = validateSelect(sede, sedeError);
        const isEstadoValid = validateSelect(estado, estadoError);

        return isNombreValid && isEmailValid && isPasswordValid && 
               isRolValid && isSedeValid && isEstadoValid;
    }

    // Event listeners
    nombre.addEventListener('blur', validateNombre);
    email.addEventListener('blur', validateEmail);
    password.addEventListener('blur', validatePassword);
    rol.addEventListener('change', () => validateSelect(rol, rolError));
    sede.addEventListener('change', () => validateSelect(sede, sedeError));
    estado.addEventListener('change', () => validateSelect(estado, estadoError));

    form.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
}); 