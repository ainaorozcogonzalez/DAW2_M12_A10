mostrardatosusuarios()

function mostrardatosusuarios() {
    let datosusuarios = document.getElementById("datosusuarios");
    var form = document.getElementById("formfiltros");
    var formData = new FormData(form);
    fetch("/users/datosusuarios", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            // console.log(data)
            datosusuarios.innerHTML = "";
            data.users.forEach(user => {
                let respuesta = ""
                respuesta += '<div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition-shadow">';
                respuesta += '    <div class="flex items-center space-x-4">';
                respuesta += '        <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center">';
                respuesta += '            <i class="fas fa-user text-indigo-600"></i>';
                respuesta += '        </div>';
                respuesta += '        <div>';
                respuesta += '            <h3 class="text-lg font-semibold">' + user.nombre + '</h3>';
                respuesta += '            <p class="text-sm text-gray-500">' + user.email + '</p>';
                respuesta += '        </div>';
                respuesta += '    </div>';
                respuesta += '    <div class="mt-4 space-y-2">';
                respuesta += '        <p class="text-sm"><span class="font-medium">Rol: </span>' + user.rol.nombre + '</p>';
                respuesta += '        <p class="text-sm"><span class="font-medium">Sede: </span>' + user.sede.nombre + '</p>';
                respuesta += '        <p class="text-sm">';
                respuesta += '            <span class="font-medium">Estado:</span>';
                respuesta += '            <span class="px-2 py-1 text-sm rounded-full ' + (user.estado == "activo" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800") + '">' + user.estado[0].toUpperCase() + user.estado.substring(1); + ' </span>';
                respuesta += '        </p>';
                respuesta += '    </div>';
                respuesta += '    <div class="mt-4 flex space-x-2">';
                respuesta += '        <button class="text-indigo-600 hover:text-indigo-900">';
                respuesta += '            <i class="fas fa-edit"></i> Editar';
                respuesta += '        </button>';
                respuesta += '        <form class="inline" id="formeliminar" onsubmit="eliminar(event, ' + user.id + ')">';
                respuesta += '        <input type="hidden" name="id" value="' + user.id + '">';
                respuesta += '            <button type="submit" class="text-red-600 hover:text-red-900">';
                respuesta += '                <i class="fas fa-trash"></i> Eliminar';
                respuesta += '            </button>';
                respuesta += '        </form>';
                respuesta += '    </div>';
                respuesta += '</div>';
                datosusuarios.innerHTML += respuesta;
            });
        })
}


function eliminar(event, id) {
    event.preventDefault();
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');

    var formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('_method', 'DELETE');
    formData.append('id', id);

    fetch("/users/eliminaruario", {
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

datosfiltros()

function datosfiltros() {
    let mostrarroles = document.getElementById("mostrar_roles");
    let mostrarsedes = document.getElementById("mostrar_sedes");
    let mostrarestados = document.getElementById("mostrar_estados");
    var form = document.getElementById("formfiltros");
    var formData = new FormData(form);
    fetch("/users/datosusuarios", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            mostrarroles.innerHTML = "";
            mostrarsedes.innerHTML = "";
            mostrarestados.innerHTML = "";
            data.roles.forEach(rol => {
                let respuesta = ""
                respuesta += ' <option value="' + rol.id + '" >' + rol.nombre + '</option>';
                mostrarroles.innerHTML += respuesta;
            });

            data.sedes.forEach(sede => {
                let respuesta = ""
                respuesta += ' <option value="' + sede.id + '" >' + sede.nombre + '</option>';
                mostrarsedes.innerHTML += respuesta;
            });

            data.estados.forEach(estado => {
                let respuesta = ""
                respuesta += ' <option value="' + estado + '" >' + estado + '</option>';
                mostrarestados.innerHTML += respuesta;
            });
        })
}

document.getElementById('btnBorrarFiltros').onclick = () => {
    // Restablecer los valores de los selectores a la opción vacía
    let formfiltros = document.getElementById("formfiltros");
    formfiltros.reset()
    datosfiltros();
    mostrardatosusuarios();
};