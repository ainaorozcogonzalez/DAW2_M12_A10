mostrardatosincidencias()

function mostrardatosincidencias() {
    let resultadostabla = document.getElementById("resultadostabla");
    var form = document.getElementById("formfiltros");
    var formData = new FormData(form);
    fetch("/incidencias/datosincidencias", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            resultadostabla.innerHTML = '';
            data.incidencias.forEach(incidencia => {
                let respuesta = ""
                respuesta += '<tr class="hover:bg-gray-50 transition-colors">';
                respuesta += '<td class="px-6 py-4 whitespace-nowrap">Incidencia #' + incidencia.id + '</td>';
                respuesta += '<td class="px-6 py-4 whitespace-nowrap">' + incidencia.descripcion + '</td>';
                respuesta += '<td class="px-6 py-4 whitespace-nowrap">' + incidencia.estado.nombre + '</td>';
                respuesta += '<td class="px-6 py-4 whitespace-nowrap">' + incidencia.prioridad.nombre + '</td>';
                respuesta += '<td class="px-6 py-4 whitespace-nowrap">' + incidencia.cliente.nombre + '</td>';
                respuesta += '<td class="px-6 py-4 whitespace-nowrap">';
                respuesta += incidencia.tecnico ? incidencia.tecnico.nombre : 'Sin asignar';
                respuesta += '</td>';
                respuesta += '<td class="px-6 py-4 whitespace-nowrap">';
                respuesta += '    <button onclick="cargadatoseditar(' + incidencia.id + ')"';
                respuesta += '        class="text-indigo-600 hover:text-indigo-900 mr-2">';
                respuesta += '        <i class="fas fa-edit"></i>';
                respuesta += '    </button>';
                respuesta += '    <button onclick="eliminar(' + incidencia.id + ')" class="text-red-600 hover:text-red-900">';
                respuesta += '        <i class="fas fa-trash"></i>';
                respuesta += '     </button>';
                respuesta += ' </td>';
                respuesta += '  </tr>';
                resultadostabla.innerHTML += respuesta;
            });
        })
}

datosfiltros()

function datosfiltros() {
    let mostrarclientes = document.getElementsByClassName("mostrar_clientes");
    let mostrarsedes = document.getElementsByClassName("mostrar_sedes");
    let mostrarcategorias = document.getElementsByClassName("mostrar_categorias");
    let mostrarsubcategorias = document.getElementById("subcategoria_id_incidencia");
    let mostrarestados = document.getElementsByClassName("mostrar_estado");
    let mostrarprioridades = document.getElementsByClassName("prioridad_id_incidencia");

    let mostrartecnicos = document.getElementsByClassName("mostrartecnicos");
    var form = document.getElementById("formfiltros");
    var formData = new FormData(form);
    fetch("/incidencias/datosincidencias", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            Array.from(mostrarestados).forEach(estados => {
                estados.innerHTML = '<option value="" >Seleccionar estado</option>';
                data.estados.forEach(estado => {
                    estados.innerHTML += '<option value="' + estado.id + '" >' + estado.nombre + '</option>';
                });
            });

            Array.from(mostrarprioridades).forEach(prioridades => {
                prioridades.innerHTML = '<option value="" >Seleccionar prioridad</option>';
                data.prioridades.forEach(prioridad => {
                    prioridades.innerHTML += ' <option value="' + prioridad.id + '" >' + prioridad.nombre + '</option>';
                });
            });

            Array.from(mostrarclientes).forEach(cliente => {
                cliente.innerHTML = '<option value="">Seleccionar cliente</option>';
                data.clientes.forEach(client => {
                    cliente.innerHTML += ' <option value="' + client.id + '" >' + client.nombre + '</option>';
                });
            });

            Array.from(mostrartecnicos).forEach(tecnicos => {
                tecnicos.innerHTML = '<option value="">Seleccionar tecnico</option>';
                data.tecnicos.forEach(tecnico => {
                    tecnicos.innerHTML += ' <option value="' + tecnico.id + '" >' + tecnico.nombre + '</option>';
                });
            });

            Array.from(mostrarsedes).forEach(sedes => {
                sedes.innerHTML = '<option value="">Seleccionar sede</option>';
                data.sedes.forEach(sede => {
                    sedes.innerHTML += ' <option value="' + sede.id + '" >' + sede.nombre + '</option>';
                });
            });

            Array.from(mostrarcategorias).forEach(categorias => {
                categorias.innerHTML = '<option value="">Seleccionar categoria</option>';
                data.categorias.forEach(categoria => {
                    categorias.innerHTML += ' <option value="' + categoria.id + '" >' + categoria.nombre + '</option>';
                });
            });

            mostrarsubcategorias.innerHTML = '<option value="">Seleccionar subcategoria</option>';
            data.subcategorias.forEach(subcategoria => {
                mostrarsubcategorias.innerHTML += ' <option value="' + subcategoria.id + '" >' + subcategoria.nombre + '</option>';
            });
        })
}