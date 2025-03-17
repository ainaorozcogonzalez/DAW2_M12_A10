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
                respuesta += '        <form class="inline" id="formeliminar" onsubmit="cargadatoseditar(event, ' + user.id + ')">';
                respuesta += '        <button class="text-indigo-600 hover:text-indigo-900">';
                respuesta += '            <i class="fas fa-edit"></i> Editar';
                respuesta += '        </button>';
                respuesta += '        </form>';
                respuesta += '            <button onclick="eliminar(' + user.id + ', \'' + user.nombre + '\')"  class="text-red-600 hover:text-red-900">';
                respuesta += '                <i class="fas fa-trash"></i> Eliminar';
                respuesta += '            </button>';
                respuesta += '    </div>';
                respuesta += '</div>';
                datosusuarios.innerHTML += respuesta;
            });
        })
}

datosfiltros()

function datosfiltros() {
    let mostrarroles = document.getElementsByClassName("mostrar_roles");
    let mostrarsedes = document.getElementsByClassName("mostrar_sedes");
    let mostrarestados = document.getElementsByClassName("mostrar_estadousuario");
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

            Array.from(mostrarroles).forEach(rols => {
                rols.innerHTML = '<option value="" >Seleccionar rol</option>';
                data.roles.forEach(rol => {
                    let respuesta = ""
                    respuesta += ' <option value="' + rol.id + '" >' + rol.nombre + '</option>';
                    rols.innerHTML += respuesta;
                });
            });

            Array.from(mostrarsedes).forEach(sedes => {
                sedes.innerHTML = '<option value="" >Seleccionar sede</option>';
                data.sedes.forEach(sede => {
                    sedes.innerHTML += ' <option value="' + sede.id + '" >' + sede.nombre + '</option>';
                });
            });

            Array.from(mostrarestados).forEach(mostrarestado => {
                mostrarestado.innerHTML = '<option value="" >Seleccionar estado</option>';
                data.estados.forEach(estado => {
                    mostrarestado.innerHTML += ' <option value="' + estado + '" >' + estado + '</option>';
                });
            });
        })
}
