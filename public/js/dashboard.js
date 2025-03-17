document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const filtrosForm = document.getElementById('filtrosForm');
    const incidenciasContainer = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3.gap-6');
    const contadorTotal = document.querySelector('.bg-blue-50 .text-2xl');
    const contadorPendientes = document.querySelector('.bg-yellow-50 .text-2xl');
    const contadorCerradas = document.querySelector('.bg-green-50 .text-2xl');

    // Verificar que los elementos existen
    if (!filtrosForm || !incidenciasContainer || !contadorTotal || !contadorPendientes || !contadorCerradas) {
        console.error('No se encontraron algunos elementos del DOM:', {
            filtrosForm,
            incidenciasContainer,
            contadorTotal,
            contadorPendientes,
            contadorCerradas
        });
        return;
    }

    // Evento para filtrar incidencias
    if (filtrosForm) {
        filtrosForm.addEventListener('submit', function(e) {
            e.preventDefault();
            filtrarIncidencias();
        });

        document.getElementById('limpiarFiltros').addEventListener('click', function() {
            limpiarFiltros();
        });
    }

    // Función para filtrar incidencias
    async function filtrarIncidencias() {
        const formData = new FormData(filtrosForm);
        const params = new URLSearchParams(formData);

        try {
            const response = await fetch(`/cliente/dashboard?${params.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Error al filtrar incidencias');

            const data = await response.json();
            actualizarUI(data);
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al filtrar las incidencias'
            });
        }
    }

    // Función para limpiar filtros
    function limpiarFiltros() {
        filtrosForm.reset();
        filtrarIncidencias();
    }

    // Función para actualizar la UI con los datos recibidos
    function actualizarUI(data) {
        // Actualizar contadores
        contadorTotal.textContent = data.contadores.total;
        contadorPendientes.textContent = data.contadores.pendientes;
        contadorCerradas.textContent = data.contadores.cerradas;

        // Actualizar listado de incidencias
        incidenciasContainer.innerHTML = data.incidencias.map(incidencia => `
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-sm text-gray-500">${new Date(incidencia.fecha_creacion).toLocaleString()}</span>
                            <h3 class="text-lg font-semibold mt-1">${incidencia.descripcion.substring(0, 40)}${incidencia.descripcion.length > 40 ? '...' : ''}</h3>
                        </div>
                        <div class="flex space-x-2">
                            <span class="px-2 py-1 text-xs rounded-full ${getEstadoColor(incidencia.estado.nombre)}">
                                ${incidencia.estado.nombre}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-600 mb-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-tag text-gray-400"></i>
                            <span>${incidencia.categoria?.nombre || 'Sin categoría'}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                            <span>${incidencia.sede?.nombre || 'Sin sede'}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <span class="${getPrioridadColor(incidencia.prioridad?.nombre)}">
                                <i class="fas fa-exclamation-circle"></i>
                            </span>
                            <span class="text-sm ${getPrioridadColor(incidencia.prioridad?.nombre)}">
                                ${incidencia.prioridad?.nombre || 'Sin prioridad'}
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="openChatModal(${incidencia.id})" class="text-green-500 hover:text-green-700 transition duration-200" title="Chat">
                                <i class="fas fa-comments"></i>
                            </button>
                            <button onclick="confirmarCierre(${incidencia.id})" class="text-red-500 hover:text-red-700 transition duration-200" title="Cerrar incidencia" ${incidencia.estado_id == 5 ? 'disabled' : ''}>
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
                ${incidencia.fecha_resolucion ? `
                    <div class="bg-green-50 px-6 py-3 border-t">
                        <div class="text-sm text-green-700 flex items-center space-x-2">
                            <i class="fas fa-check-circle"></i>
                            <span>Resuelta el ${new Date(incidencia.fecha_resolucion).toLocaleDateString()}</span>
                        </div>
                    </div>
                ` : ''}
            </div>
        `).join('');

        if (data.incidencias.length === 0) {
            incidenciasContainer.innerHTML = `
                <div class="bg-white p-8 rounded-lg shadow-md text-center col-span-full">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay incidencias</h3>
                    <p class="text-gray-500 mb-4">Parece que no has reportado ninguna incidencia todavía.</p>
                    <button onclick="openIncidenciaModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Crear nueva incidencia
                    </button>
                </div>
            `;
        }
    }

    // Funciones de utilidad
    function getEstadoColor(estado) {
        const estadoColors = {
            'Resuelta': 'bg-green-100 text-green-800',
            'Pendiente': 'bg-yellow-100 text-yellow-800',
            'En progreso': 'bg-blue-100 text-blue-800',
            'default': 'bg-gray-100 text-gray-800'
        };
        return estadoColors[estado] || estadoColors['default'];
    }

    function getPrioridadColor(prioridad) {
        const prioridadColors = {
            'Alta': 'text-red-500',
            'Media': 'text-yellow-500',
            'Baja': 'text-gray-500',
            'default': 'text-gray-500'
        };
        return prioridadColors[prioridad] || prioridadColors['default'];
    }

    // Funciones del modal de incidencias
    window.openIncidenciaModal = function() {
        document.getElementById('incidenciaModal').classList.remove('hidden');
    }

    window.closeIncidenciaModal = function() {
        document.getElementById('incidenciaModal').classList.add('hidden');
    }

    // Manejo del formulario de nueva incidencia
    const incidenciaForm = document.getElementById('incidenciaForm');
    if (incidenciaForm) {
        incidenciaForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(incidenciaForm);

            try {
                const response = await fetch('/cliente/incidencias', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Incidencia creada',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    closeIncidenciaModal();
                    filtrarIncidencias();
                } else {
                    throw new Error(data.message || 'Error al crear la incidencia');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message
                });
            }
        });
    }

    // Cargar subcategorías al cambiar categoría
    const categoriaSelect = document.getElementById('categoria_id');
    if (categoriaSelect) {
        categoriaSelect.addEventListener('change', function() {
            const categoriaId = this.value;
            const subcategoriaSelect = document.getElementById('subcategoria_id');
            subcategoriaSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';

            if (categoriaId) {
                fetch(`/subcategorias/${categoriaId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subcategoria => {
                            const option = document.createElement('option');
                            option.value = subcategoria.id;
                            option.text = subcategoria.nombre;
                            subcategoriaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar subcategorías:', error);
                    });
            }
        });
    }

    // Confirmar cierre de incidencia
    window.confirmarCierre = function(incidenciaId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas cerrar esta incidencia?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cerrar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/incidencias/${incidenciaId}/cerrar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Incidencia cerrada',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        filtrarIncidencias();
                    } else {
                        throw new Error(data.message || 'Error al cerrar la incidencia');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message
                    });
                }
            }
        });
    }

    // Manejo del menú desplegable del usuario
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');

    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }

    // Cargar incidencias al iniciar
    filtrarIncidencias();
});