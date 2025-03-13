datosincidencias();

function datosincidencias() {
    var resultado = document.getElementById("infoincidencias");
    var form = document.getElementById("frmbusqueda");
    var formData = new FormData(form);
    fetch("/datosincidencias", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            resultado.innerHTML = "";
            // mostrar los datos de las incidencias
            data.incidencias.forEach(incidencia => {
                var tecnico = incidencia.tecniconombre ? incidencia.tecniconombre : "Sin assignar";
                let indicendiadato = ""
                indicendiadato += '<div class="restaurante">';
                indicendiadato += '<p>Incidencia:#' + incidencia.id + '</p>';
                indicendiadato += '<p>' + incidencia.descripcion + '</p>';
                indicendiadato += '<p>tecnico: ' + tecnico + '</p>'
                indicendiadato += '<p>cliente: ' + incidencia.clientenombre + '</p>';
                indicendiadato += '<p>estado: ' + incidencia.nombreestado + '</p>';
                // forumario para asignar la prioridad
                indicendiadato += '<form action="" method="post" id="frmaprioridad' + incidencia.id + '" onsubmit="event.preventDefault()">';
                indicendiadato += '<select name="assignaprioridad" onchange="prioridad(' + incidencia.id + ')" >';
                indicendiadato += '<option value="">Asignar una prioridad</option>';
                data.prioridades.forEach(prioridad => {
                    var prioridadnom = incidencia.prioridad_id == prioridad.id ? "selected" : ''
                    indicendiadato += '<option value="' + prioridad.id + '" ' + prioridadnom + '>' + prioridad.nombre + '</option>';
                });
                indicendiadato += '</select>';
                indicendiadato += '</form>';
                // forumario para asignar al tecnico
                indicendiadato += '<form action="" method="post" id="frmasignar' + incidencia.id + '" onsubmit="event.preventDefault()">';
                indicendiadato += '<select name="assignadopara" onchange="asignar(' + incidencia.id + ')" >';
                indicendiadato += '<option value="">Asignar a un tecnico</option>';
                data.tecnicos.forEach(tecnico => {
                    var tecniconom = incidencia.tecnico_id == tecnico.id ? "selected" : ''
                    indicendiadato += '<option value="' + tecnico.id + '" ' + tecniconom + '>' + tecnico.nombre + '</option>';
                });
                indicendiadato += '</select>';
                indicendiadato += '</form>';
                indicendiadato += '</div>'
                resultado.innerHTML += indicendiadato;
            });
        })
}

function prioridad(id) {
    var form = document.getElementById('frmaprioridad' + id);
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    var formData = new FormData(form);
    formData.append('id', id);
    formData.append('_token', csrfToken);
    fetch("/editarprioridad", {
        method: "POST",
        body: formData
    }).then(response => {
        return response.text();
    })
        .then(data => {
            if (data == 'Sin asignar' || data == "Asignada prioridad") {
                Swal.fire({
                    title: data,
                    icon: "success",
                    // draggable: true,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    title: data,
                    icon: "error",
                    timer: 1500
                });
            }
            datosincidencias()
        })
}

function asignar(id) {
    var form = document.getElementById('frmasignar' + id);
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    var formData = new FormData(form);
    formData.append('id', id);
    formData.append('_token', csrfToken);
    fetch("/editarassignar", {
        method: "POST",
        body: formData
    }).then(response => {
        return response.text();
    })
        .then(data => {
            if (data == 'Sin asignar' || data == "Tecnico asignado") {
                Swal.fire({
                    title: data,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500
                });
                datosincidencias()
            } else {
                Swal.fire({
                    title: data,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        })
}

document.getElementById("borrarfiltros").addEventListener("click", function (event) {
    event.preventDefault();
    document.getElementById("frmbusqueda").reset();
    datosincidencias();
});