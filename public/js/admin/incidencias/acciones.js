
document.getElementById('btnBorrarFiltros').onclick = () => {
    // Restablecer los valores de los selectores a la opción vacía
    let formfiltros = document.getElementById("formfiltros");
    formfiltros.reset()
    datosfiltros();
    mostrardatosincidencias();
};

function closeUserModal() {
    var form = document.getElementById("userForm");
    form.reset()
    document.getElementById('userModal').classList.add('hidden');
}

function eliminar(id) {
    Swal.fire({
        title: "Eliminar la<br>Incidencia #" + id + '?',
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#4f46e5",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
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
    });
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
            estado_id.value = data.estado.id;

            let prioridad_id = form.querySelector('select[name="prioridad_id"]');
            prioridad_id.value = data.prioridad.id;

            let cliente_id = form.querySelector('select[name="cliente_id"]');
            cliente_id.value = data.cliente_id;

            let tecnico_id = form.querySelector('select[name="tecnico_id"]');
            tecnido = data.tecnico_id == null ? "" : data.tecnico_id
            tecnico_id.value = tecnido;

            let sede_id = form.querySelector('select[name="sede_id"]');
            sede_id.value = data.sede.id;

            let categoria_id = form.querySelector('select[name="categoria_id"]');
            categoria_id.value = data.categoria.id;

            let subcategoria_id = form.querySelector('select[name="subcategoria_id"]');
            subcategoria_id.value = data.estado.id;
        })
}


function editar() {
    var form = document.getElementById("incidenciaForm");
    var formData = new FormData(form);
    formData.append('_method', 'PUT');
    fetch("/incidencias/editar", {
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
                form.reset()
                document.getElementById('incidenciaModal').classList.add('hidden');
                mostrardatosincidencias()
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
}

function crearincidencia() {
    var form = document.getElementById("incidenciaForm");
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    var formData = new FormData(form);
    formData.append('_token', csrfToken);
    formData.append('_method', 'POST');

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
                form.reset()
                document.getElementById('incidenciaModal').classList.add('hidden');
                mostrardatosincidencias()
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
}