
document.getElementById('btnBorrarFiltros').onclick = () => {
    // Restablecer los valores de los selectores a la opción vacía
    let formfiltros = document.getElementById("formfiltros");
    formfiltros.reset()
    datosfiltros();
    mostrardatosincidencias();
};

function eliminar(id) {
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');

    var formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('_method', 'DELETE');
    formData.append('id', id);

    fetch("/incidencias/" + id, {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            const [primeraParte, resto] = data.split(/ (.+)/);
            console.log(primeraParte)
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
            mostrardatosincidencias()
        })
}

function cargadatoseditar(id) {
    const modalTitle = document.getElementById('modalTitle');

    document.getElementById('incidenciaModal').classList.remove('hidden');
    var form = document.getElementById("incidenciaForm");
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');

    var formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('id', id);

    fetch("/incidencias/" + id + "/edit", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            form.onsubmit = function (event) {
                event.preventDefault();
                editar();
            };
            modalTitle.innerText = 'Editando la Incidencia #' + data.id;
            document.getElementById('incidencia_id').value = data.id || '';
            document.getElementById('descripcion').value = data.descripcion || '';

            let estado_id = form.querySelector('select[name="estado_id"]');
            if (data.estado) {
                estado_id.value = data.estado;
            }

            let prioridad_id = form.querySelector('select[name="prioridad_id"]');
            if (data.sede_id) {
                prioridad_id.value = data.sede_id;
            }

            let cliente_id = form.querySelector('select[name="cliente_id"]');
            if (data.estado) {
                // convierte la primera letra en mayuscula
                cliente_id.value = data.estado.charAt(0).toUpperCase() + data.estado.slice(1).toLowerCase();
            }

            let tecnico_id = form.querySelector('select[name="tecnico_id"]');
            if (data.estado) {
                // convierte la primera letra en mayuscula
                tecnico_id.value = data.estado.charAt(0).toUpperCase() + data.estado.slice(1).toLowerCase();
            }

            let sede_id = form.querySelector('select[name="sede_id"]');
            if (data.estado) {
                // convierte la primera letra en mayuscula
                sede_id.value = data.estado.charAt(0).toUpperCase() + data.estado.slice(1).toLowerCase();
            }

            let categoria_id = form.querySelector('select[name="categoria_id"]');
            if (data.estado) {
                // convierte la primera letra en mayuscula
                categoria_id.value = data.estado.charAt(0).toUpperCase() + data.estado.slice(1).toLowerCase();
            }

            let subcategoria_id = form.querySelector('select[name="subcategoria_id"]');
            if (data.estado) {
                // convierte la primera letra en mayuscula
                subcategoria_id.value = data.estado.charAt(0).toUpperCase() + data.estado.slice(1).toLowerCase();
            }
        })
}


function editar() {
    var form = document.getElementById("userForm");
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    var formData = new FormData(form);
    formData.append('_token', csrfToken);
    formData.append('_method', 'PUT');

    fetch("/users/editar", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            form.reset();
            form.onsubmit = function (event) {
                event.preventDefault();
                Crearusuario();
            };
            document.getElementById('userModal').classList.add('hidden');
            mostrardatosusuarios()
        })
}

function Crearusuario() {
    var form = document.getElementById("userForm");
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    var formData = new FormData(form);
    formData.append('_token', csrfToken);
    formData.append('_method', 'POST');

    fetch("/users/admincrearusuario", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.text();
        })
        .then(data => {
            mostrardatosusuarios()
        })
}