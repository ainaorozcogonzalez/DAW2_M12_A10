document.addEventListener('DOMContentLoaded', function() {
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');
    const submitButton = document.getElementById('submitButton');

    let emailInteracted = false;
    let passwordInteracted = false;

    function validateEmail() {
        if (!emailInteracted) return true;
        
        const emailRegex = /\S+@\S+\.\S+/;
        if (!emailRegex.test(email.value)) {
            emailError.textContent = 'Por favor, introduce un email válido.';
            emailError.classList.remove('hidden');
            email.classList.add('border-red-500');
            return false;
        } else {
            emailError.classList.add('hidden');
            email.classList.remove('border-red-500');
            return true;
        }
    }

    function validatePassword() {
        if (!passwordInteracted) return true;
        
        if (password.value.length < 8) {
            passwordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
            passwordError.classList.remove('hidden');
            password.classList.add('border-red-500');
            return false;
        } else {
            passwordError.classList.add('hidden');
            password.classList.remove('border-red-500');
            return true;
        }
    }

    function validateForm() {
        const emailValid = validateEmail();
        const passwordValid = validatePassword();
        submitButton.disabled = !(emailValid && passwordValid);
    }

    // Validación al interactuar
    email.addEventListener('blur', () => {
        emailInteracted = true;
        validateEmail();
        validateForm();
    });

    password.addEventListener('blur', () => {
        passwordInteracted = true;
        validatePassword();
        validateForm();
    });

    // Validación al escribir
    email.addEventListener('input', () => {
        if (emailInteracted) {
            validateEmail();
            validateForm();
        }
    });

    password.addEventListener('input', () => {
        if (passwordInteracted) {
            validatePassword();
            validateForm();
        }
    });

    // Validación al enviar el formulario
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        emailInteracted = true;
        passwordInteracted = true;
        if (!validateEmail() || !validatePassword()) {
            event.preventDefault();
        }
    });
}); 