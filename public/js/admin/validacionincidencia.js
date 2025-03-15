document.addEventListener('DOMContentLoaded', () => {
    // Asignar eventos keyup a los inputs
    document.getElementById('descripcion_incidencia').addEventListener('keyup', validarDescripcion);

    // Asignar eventos change a los selects
    document.getElementById('cliente_id_incidencia').addEventListener('change', validarCliente);
    document.getElementById('incidencia_sede_id').addEventListener('change', validarSedeincidencia);
    document.getElementById('categoria_id_incidencia').addEventListener('change', validarCategoriaSedeincidencia);
    document.getElementById('subcategoria_id_incidencia').addEventListener('change', validarSubcategoria);
    document.getElementById('estado_id_incidencia').addEventListener('change', validarEstado);
    document.getElementById('prioridad_id_incidencia').addEventListener('change', validarPrioridad);
    document.getElementById('tecnico_id_incidencia').addEventListener('change', validarTecnico);
});

// ✅ Validar cliente
function validarCliente() {
    const cliente_id = document.getElementById('cliente_id_incidencia').value;
    const error = document.getElementById('cliente_id_incidencia-error');

    if (cliente_id === "") {
        error.innerText = "Seleccione un cliente";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar sede
function validarSedeincidencia() {
    const sede_id = document.getElementById('incidencia_sede_id').value;
    const error = document.getElementById('sede_id_incidencia-error');

    if (sede_id === "") {
        error.innerText = "Seleccione una sede";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar categoría
function validarCategoriaSedeincidencia() {
    const categoria_id = document.getElementById('categoria_id_incidencia').value;
    const error = document.getElementById('categoria_id_incidencia-error');

    if (categoria_id === "") {
        error.innerText = "Seleccione una categoría";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar subcategoría
function validarSubcategoria() {
    const subcategoria_id = document.getElementById('subcategoria_id_incidencia').value;
    const error = document.getElementById('subcategoria_id_incidencia-error');

    if (subcategoria_id === "") {
        error.innerText = "Seleccione una subcategoría";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar estado
function validarEstado() {
    const estado_id = document.getElementById('estado_id_incidencia').value;
    const error = document.getElementById('estado_id_incidencia-error');

    if (estado_id === "") {
        error.innerText = "Seleccione un estado";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar prioridad
function validarPrioridad() {
    const prioridad_id = document.getElementById('prioridad_id_incidencia').value;
    const error = document.getElementById('prioridad_id_incidencia-error');

    if (prioridad_id === "") {
        error.innerText = "Seleccione una prioridad";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar descripción
function validarDescripcion() {
    const descripcion = document.getElementById('descripcion_incidencia').value.trim();
    const error = document.getElementById('descripcion_incidencia-error');

    if (descripcion === "") {
        error.innerText = "La descripción es obligatoria";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validar tecnico
function validarTecnico() {
    const tecnico_id = document.getElementById('tecnico_id_incidencia').value;
    const error = document.getElementById('tecnico_id_incidencia-error');

    if (tecnico_id === "") {
        error.innerText = "Seleccione una tecnico";
        error.classList.remove('hidden');
        return false;
    }
    error.classList.add('hidden');
    return true;
}

// ✅ Validación antes de enviar el formulario
function validarFormularioincidencia(event) {
    event.preventDefault();
    const isValid =
        validarCliente() &
        validarSedeincidencia() &
        validarCategoriaSedeincidencia() &
        validarSubcategoria() &
        validarEstado() &
        validarPrioridad() &
        validarDescripcion() &
        validarTecnico();
    return isValid;
}

// Función para crear incidencia
function crearincidencia(event) {
    if (!validarFormularioincidencia(event)) {
        return;
    }
    var form = document.getElementById("incidenciaForm");
    var formData = new FormData(form);
    fetch("/incidencias/admincrearincidencia", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            const [primeraParte, resto] = data.split(/ (.+)/);
            if (primeraParte == 'success') {
                form.reset();
                datosadicionales();
                document.getElementById('incidenciaModal').classList.add('hidden');
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
}
