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
    cargausuarioscrear(sede_id)
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

    cargasubcat(categoria_id)
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
        validarDescripcion();
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

            Swal.fire({
                title: resto,
                icon: primeraParte,
            });

            if (primeraParte == 'success') {
                document.getElementById('incidenciaModal').classList.add('hidden');
                form.reset();
                datosfiltros()
                mostrardatosincidencias();
            }
        })
}

function cargausuarioscrear(id) {
    resultadousers = document.getElementById('cliente_id_incidencia');
    resultadotecnics = document.getElementById('tecnico_id_incidencia');
    if (id == '') {
        resultadousers.innerHTML = '<option value="">Primero seleccione una sede</option>';
        resultadotecnics.innerHTML = '<option value="">Primero seleccione una sede</option>';
    } else {
        var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
        var formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('id', id);
        fetch("/datos/usuarios", {
            method: "POST",
            body: formData
        })
            .then(response => {
                if (!response.ok) throw new Error("Error al cargar los datos");
                return response.json();
            })
            .then(data => {
                if (data.usuarios.length != "0") {
                    resultadousers.innerHTML = '<option value="">Seleccione una cliente</option>';
                    data.usuarios.forEach(usario => {
                        resultadousers.innerHTML += '<option value="' + usario.id + '">' + usario.nombre + '</option>';
                    });
                } else {
                    resultadousers.innerHTML = '<option value="">No hay clientes</option>';
                }

                if (data.tecnicos.length != "0") {
                    resultadotecnics.innerHTML = '<option value="">Seleccione una tecnico</option>';
                    data.tecnicos.forEach(usario => {
                        resultadotecnics.innerHTML += '<option value="' + usario.id + '">' + usario.nombre + '</option>';
                    });
                } else {
                    resultadotecnics.innerHTML = '<option value="">No hay tecnico</option>';
                }
            })
    }
}

// function cargatecnico(id) {
//     resultado = document.getElementById('tecnico_id_incidencia');
//     if (id == '') {
//         resultado.innerHTML = '<option value="">Primero seleccione una sede</option>';
//     } else {
//         var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
//         var formData = new FormData();
//         formData.append('_token', csrfToken);
//         formData.append('id', id);
//         fetch("/datos/tecnicos", {
//             method: "POST",
//             body: formData
//         })
//             .then(response => {
//                 if (!response.ok) throw new Error("Error al cargar los datos");
//                 return response.json();
//             })
//             .then(data => {
//                 if (data.length != "0") {
//                     resultado.innerHTML = '<option value="">Seleccione un tecnico</option>';
//                     data.forEach(usario => {
//                         resultado.innerHTML += '<option value="' + usario.id + '">' + usario.nombre + '</option>';
//                     });
//                 } else {
//                     resultado.innerHTML = '<option value="">No hay tecnicos</option>';
//                 }
//             })
//     }
// }

function cargasubcat(id) {
    resultado = document.getElementById('subcategoria_id_incidencia');
    if (id == '') {
        resultado.innerHTML = '<option value="">Primero seleccione una categoría</option>';
    } else {
        var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
        var formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('id', id);
        fetch("/datos/subcat", {
            method: "POST",
            body: formData
        })
            .then(response => {
                if (!response.ok) throw new Error("Error al cargar los datos");
                return response.json();
            })
            .then(data => {
                resultado.innerHTML = '<option value="">Seleccione una subcategoría</option>';
                data.forEach(subcat => {
                    resultado.innerHTML += '<option value="' + subcat.id + '">' + subcat.nombre + '</option>';
                });
            })
    }
}
