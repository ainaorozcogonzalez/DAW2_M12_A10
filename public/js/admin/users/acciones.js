
document.getElementById('btnBorrarFiltros').onclick = () => {
    // Restablecer los valores de los selectores a la opción vacía
    let formfiltros = document.getElementById("formfiltros");
    formfiltros.reset()
    datosfiltros();
    mostrardatosusuarios();
};

function eliminar(id, nombre) {
    Swal.fire({
        title: "Seguro de eliminar al usuario <br>" + nombre + '?',
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
            fetch("/users/" + id, {
                method: "POST",
                body: formData
            })
                .then(response => {
                    if (!response.ok) throw new Error("Error al cargar los datos");
                    return response.text();
                })
                .then(data => {
                    const [primeraParte, resto] = data.split(/ (.+)/);
                    console.log(resto)
                    if (primeraParte == 'success') {
                        document.getElementById('userModal').classList.add('hidden');
                        mostrardatosusuarios()
                    }
                    Swal.fire({
                        title: resto,
                        icon: primeraParte,
                    });
                })
        }
    });
}

function cargadatoseditar(event, id) {
    event.preventDefault();
    const modalTitle = document.getElementById('modalTitle');
    const btfrmcrear = document.getElementById('btfrmcrear');
    btfrmcrear.innerHTML = 'Confirmar cambios';

    document.getElementById('userModal').classList.remove('hidden');
    var userForm = document.getElementById("userForm");
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');

    var formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('id', id);

    fetch("/users/" + id + "/edit", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            userForm.onsubmit = function (event) {
                event.preventDefault();
                editar();
            };
            modalTitle.innerText = 'Editando a ' + data.nombre;
            document.getElementById('user_id').value = data.id || '';
            document.getElementById('nombre_user').value = data.nombre || '';
            document.getElementById('email_user').value = data.email || '';

            let rolSelect = userForm.querySelector('select[name="rol_id"]');
            if (data.rol_id) {
                rolSelect.value = data.rol_id;
            }

            let sedeSelect = userForm.querySelector('select[name="sede_id"]');
            if (data.sede_id) {
                sedeSelect.value = data.sede_id;
            }

            let estadoSelect = userForm.querySelector('select[name="estado"]');
            if (data.estado) {
                // convierte la primera letra en mayuscula
                estadoSelect.value = data.estado.charAt(0).toUpperCase() + data.estado.slice(1).toLowerCase();
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
            const [primeraParte, resto] = data.split(/ (.+)/);
            if (primeraParte == 'success') {
                form.reset()
                document.getElementById('userModal').classList.add('hidden');
                mostrardatosusuarios()
            }
            Swal.fire({
                title: resto,
                icon: primeraParte,
            });
        })
}
