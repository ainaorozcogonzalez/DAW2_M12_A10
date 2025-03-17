document.addEventListener('DOMContentLoaded', () => {
    // Asignar eventos keyup a los inputs
    document.getElementById('nombre_user').addEventListener('keyup', validarNombre);
    document.getElementById('email_user').addEventListener('keyup', validarEmail);
    document.getElementById('password_user').addEventListener('keyup', validarPassword);

    // Asignar eventos change a los selects
    document.getElementById('rol_id_user').addEventListener('change', validarRol);
    document.getElementById('sede_id_user').addEventListener('change', validarSede);
    document.getElementById('estado_user').addEventListener('change', validarEstado);
});

// ✅ Validar nombre
function validarNombre() {
    const nombre = document.getElementById('nombre_user').value.trim();
    const error = document.getElementById('nombre_user-error');

    // Expresión regular que permite solo letras (mayúsculas y minúsculas) y espacios
    const nombreRegex = /^[a-zA-Z\s]+$/;

    if (nombre === "") {
        error.innerText = "El nombre es obligatorio";
        error.classList.remove('hidden');
        return false;
    } else if (!nombreRegex.test(nombre)) {
        error.innerText = "El nombre solo puede contener letras y espacios";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar email
function validarEmail() {
    const email = document.getElementById('email_user').value.trim();
    const error = document.getElementById('email_user-error');

    if (email === "") {
        error.innerText = "El correo electrónico es obligatorio";
        error.classList.remove('hidden');
        return false;
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        error.innerText = "El correo electrónico no es válido ejemplo: ejemplo@gmail.com";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar contraseña
function validarPassword() {
    const password = document.getElementById('password_user').value.trim();
    const error = document.getElementById('password_user-error');

    // Validar que la contraseña no esté vacía, tenga al menos 8 caracteres y contenga una mayúscula, una minúscula y un número
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

    if (password === "") {
        error.innerText = "La contraseña es obligatoria";
        error.classList.remove('hidden');
        return false;
    } else if (password.length < 8) {
        error.innerText = "La contraseña debe tener al menos 8 caracteres";
        error.classList.remove('hidden');
        return false;
    } else if (!passwordRegex.test(password)) {
        error.innerText = "La contraseña debe contener al menos una mayúscula, una minúscula y un número";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar rol
function validarRol() {
    const rol_id = document.getElementById('rol_id_user').value;
    const error = document.getElementById('rol_user-error');

    if (rol_id === "") {
        error.innerText = "Seleccione un rol";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar sede
function validarSede() {
    const sede_id = document.getElementById('sede_id_user').value;
    const error = document.getElementById('sede_user-error');

    if (sede_id === "") {
        error.innerText = "Seleccione una sede";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar estado
function validarEstado() {
    const estado = document.getElementById('estado_user').value;
    const error = document.getElementById('estado_user-error');

    if (estado === "") {
        error.innerText = "Seleccione un estado";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validación antes de enviar el formulario
function validarFormularioUsers(event) {
    event.preventDefault();
    const isValid =
        validarNombre() &
        validarEmail() &
        validarPassword() &
        validarRol() &
        validarSede() &
        validarEstado();
    return isValid;
}

// Función para crear usuario
function Crearusuario(event) {
    if (!validarFormularioUsers(event)) {
        return; // Si hay errores, no se envía el formulario
    }

    var form = document.getElementById("userForm");
    var formData = new FormData(form);

    fetch("/users/admincrearusuario", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            const [primeraParte, resto] = data.split(/ (.+)/);

            if (primeraParte === 'success') {
                form.reset();
                mostrardatosusuarios();
                document.getElementById('userModal').classList.add('hidden');
            }

            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
}
