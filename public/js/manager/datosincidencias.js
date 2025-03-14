datosincidencias();

function datosincidencias() {
    var resultado = document.getElementById("infoincidencias");
    var form = document.getElementById("frmbusqueda");
    var formData = new FormData(form);
    
    // Guardar el valor seleccionado actual del técnico
    var selectedTecnico = document.getElementById("tecnico").value;
    
    fetch("/datosincidencias", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            // Llenar el select de técnicos
            var tecnicoSelect = document.getElementById("tecnico");
            tecnicoSelect.innerHTML = '<option value="">Todos</option>';
            data.tecnicos.forEach(tecnico => {
                tecnicoSelect.innerHTML += `<option value="${tecnico.id}" ${tecnico.id == selectedTecnico ? 'selected' : ''}>${tecnico.nombre}</option>`;
            });
            
            resultado.innerHTML = "";
            data.incidencias.forEach(incidencia => {
                var tecnico = incidencia.tecniconombre ? incidencia.tecniconombre : "Sin asignar";
                
                // Determinar el color del estado
                let estadoColor = 'bg-gray-100 text-gray-800';
                switch(incidencia.nombreestado) {
                    case 'Asignada':
                        estadoColor = 'bg-blue-100 text-blue-800';
                        break;
                    case 'Resuelta':
                        estadoColor = 'bg-green-100 text-green-800';
                        break;
                    case 'Cerrada':
                        estadoColor = 'bg-gray-100 text-gray-800';
                        break;
                }

                // Determinar el color de la prioridad
                let prioridadColor = 'text-gray-500';
                switch(incidencia.nombreprioridades) {
                    case 'Alta':
                        prioridadColor = 'text-red-500';
                        break;
                    case 'Media':
                        prioridadColor = 'text-yellow-500';
                        break;
                    case 'Baja':
                        prioridadColor = 'text-gray-500';
                        break;
                }

                let indicendiadato = `
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Incidencia #${incidencia.id}</h3>
                                    <p class="text-sm text-gray-500">Creada: ${new Date(incidencia.created_at).toLocaleDateString()}</p>
                                </div>
                                <span class="px-2 py-1 text-sm rounded-full ${estadoColor}">
                                    ${incidencia.nombreestado}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 mb-4">${incidencia.descripcion}</p>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-user-cog text-indigo-500 mr-2"></i>
                                    <span>Técnico: ${tecnico}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-user text-green-500 mr-2"></i>
                                    <span>Cliente: ${incidencia.clientenombre}</span>
                                </div>
                                <div class="flex items-center space-x-1 ${prioridadColor}">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>${incidencia.nombreprioridades ? incidencia.nombreprioridades : 'Sin asignar'}</span>
                                </div>
                            </div>

                            <!-- Formulario para asignar prioridad -->
                            <div class="mt-4 space-y-2">
                                <form action="" method="post" id="frmaprioridad${incidencia.id}" onsubmit="event.preventDefault()" class="space-y-2">
                                    <select name="assignaprioridad" onchange="prioridad(${incidencia.id})" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200 text-sm">
                                        <option value="">Asignar prioridad</option>
                                        ${data.prioridades.map(prioridad => `
                                            <option value="${prioridad.id}" ${incidencia.prioridad_id == prioridad.id ? 'selected' : ''}>${prioridad.nombre}</option>
                                        `).join('')}
                                    </select>
                                </form>

                                <!-- Formulario para asignar técnico -->
                                <form action="" method="post" id="frmasignar${incidencia.id}" onsubmit="event.preventDefault()" class="space-y-2">
                                    <select name="assignadopara" onchange="asignar(${incidencia.id})" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200 text-sm">
                                        <option value="">Asignar técnico</option>
                                        ${data.tecnicos.map(tecnico => `
                                            <option value="${tecnico.id}" ${incidencia.tecnico_id == tecnico.id ? 'selected' : ''}>${tecnico.nombre}</option>
                                        `).join('')}
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>`;
                resultado.innerHTML += indicendiadato;
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
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
    // Limpiar el select de técnicos
    document.getElementById("tecnico").innerHTML = '<option value="">Todos</option>';
    datosincidencias();
});

document.getElementById('ocultarCerradas').addEventListener('change', function() {
    const incidencias = document.querySelectorAll('#infoincidencias > div');
    incidencias.forEach(incidencia => {
        const estado = incidencia.querySelector('.px-2.py-1.text-sm.rounded-full').textContent.trim();
        if (estado === 'Cerrada') {
            incidencia.style.display = this.checked ? 'none' : 'block';
        }
    });
});