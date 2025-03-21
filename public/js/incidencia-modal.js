console.log('JavaScript cargado correctamente');

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('incidenciaForm');
    const fields = {
        descripcion: { required: true, message: 'La descripción es obligatoria.' },
        categoria_id: { required: true, message: 'Seleccione una categoría.' },
        subcategoria_id: { required: true, message: 'Seleccione una subcategoría.' }
    };

    const categoriaSelect = document.getElementById('categoria_id');
    const subcategoriaSelect = document.getElementById('subcategoria_id');

    if (categoriaSelect && subcategoriaSelect) {
        categoriaSelect.addEventListener('change', function() {
            const categoriaId = this.value;
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

    // Función para validar un campo
    function validateField(input, rules) {
        if (!input) return true;
        const errorDiv = document.getElementById(`${input.id}-error`);
        if (!input.value && rules.required) {
            if (errorDiv) {
                errorDiv.textContent = rules.message;
                errorDiv.classList.remove('hidden');
            }
            input.classList.add('border-red-500');
            return false;
        }
        if (errorDiv) {
            errorDiv.classList.add('hidden');
        }
        input.classList.remove('border-red-500');
        return true;
    }

    // Agregar eventos blur a todos los campos
    Object.keys(fields).forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (input) {
            input.addEventListener('blur', () => validateField(input, fields[fieldId]));
        }
    });

    // Manejar el envío del formulario de creación de incidencias
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        let isValid = true;
        Object.keys(fields).forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input && !validateField(input, fields[fieldId])) {
                isValid = false;
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, complete todos los campos requeridos correctamente.'
            });
            return;
        }

        const formData = new FormData(this);
        const token = document.querySelector('meta[name="csrf-token"]')?.content;

        fetch('/client/incidencias', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Incidencia creada correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                
                // Cerrar el modal
                closeIncidenciaModal();
                
                // Limpiar el formulario
                this.reset();
                
                // Crear y añadir la nueva tarjeta de incidencia
                const contenedorIncidencias = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3.gap-6');
                const nuevaTarjeta = crearTarjetaIncidencia(data.incidencia);
                contenedorIncidencias.insertAdjacentHTML('afterbegin', nuevaTarjeta);

                // Actualizar los contadores
                actualizarContadores(data.contadores);
                
                // Si no hay incidencias, eliminar el mensaje de "No hay incidencias"
                const mensajeNoIncidencias = document.querySelector('.bg-white.p-8.rounded-lg.shadow-md.text-center');
                if (mensajeNoIncidencias) {
                    mensajeNoIncidencias.remove();
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Hubo un error al crear la incidencia'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al procesar la solicitud'
            });
        });
    });
});

// Función para crear la tarjeta de incidencia HTML
function crearTarjetaIncidencia(incidencia) {
    const estadoColors = {
        'Resuelta': 'bg-green-100 text-green-800',
        'Pendiente': 'bg-yellow-100 text-yellow-800',
        'En progreso': 'bg-blue-100 text-blue-800',
        'Baja': 'bg-gray-100 text-gray-800',
        'Urgente': 'bg-red-100 text-red-800',
        'default': 'bg-gray-100 text-gray-800'
    };

    const prioridadColors = {
        'Alta': 'text-red-500',
        'Media': 'text-yellow-500',
        'Baja': 'text-gray-500',
        'default': 'text-gray-500'
    };

    const estadoColor = estadoColors[incidencia.estado?.nombre] || estadoColors.default;
    const prioridadColor = prioridadColors[incidencia.prioridad?.nombre] || prioridadColors.default;

    return `
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-sm text-gray-500">${new Date(incidencia.fecha_creacion).toLocaleString()}</span>
                        <h3 class="text-lg font-semibold mt-1">${incidencia.descripcion}</h3>
                    </div>
                    <div class="flex space-x-2">
                        <span class="px-2 py-1 text-xs rounded-full ${estadoColor}">
                            ${incidencia.estado?.nombre || 'Sin estado'}
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
                        <span class="${prioridadColor}">
                            <i class="fas fa-exclamation-circle"></i>
                        </span>
                        <span class="text-sm ${prioridadColor}">
                            ${incidencia.prioridad?.nombre || 'Sin prioridad'}
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="openChatModal(${incidencia.id})" class="text-green-500 hover:text-green-700 transition duration-200" title="Chat">
                            <i class="fas fa-comments"></i>
                        </button>
                        <button onclick="confirmarCierre(${incidencia.id})" class="text-red-500 hover:text-red-700 transition duration-200" title="Cerrar incidencia">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Función para actualizar los contadores
function actualizarContadores(contadores) {
    if (contadores) {
        document.querySelector('.text-blue-900').textContent = contadores.total;
        document.querySelector('.text-yellow-900').textContent = contadores.pendientes;
        document.querySelector('.text-green-900').textContent = contadores.cerradas;
    }
}

// Funciones para abrir/cerrar el modal
function openIncidenciaModal() {
    document.getElementById('incidenciaModal').classList.remove('hidden');
}

function closeIncidenciaModal() {
    document.getElementById('incidenciaModal').classList.add('hidden');
}

// Función para confirmar el cierre de una incidencia
function confirmarCierre(incidenciaId) {
    if (confirm('¿Estás seguro de que deseas cerrar esta incidencia?')) {
        fetch(`/incidencias/${incidenciaId}/cerrar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Recargar la página para ver los cambios
            } else {
                alert(data.message || 'Hubo un error al intentar cerrar la incidencia');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error en la solicitud');
        });
    }
}

// Función para manejar el envío del formulario de filtros
document.getElementById('filtrosForm').addEventListener('submit', function(event) {
    event.preventDefault();
    aplicarFiltros();
});

// Función para limpiar los filtros
document.getElementById('limpiarFiltros').addEventListener('click', function() {
    document.getElementById('filtrosForm').reset();
    aplicarFiltros();
});

// Función para aplicar los filtros
function aplicarFiltros() {
    const formData = new FormData(document.getElementById('filtrosForm'));
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    fetch('/client/dashboard/filtrar', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const contenedorIncidencias = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3.gap-6');
        contenedorIncidencias.innerHTML = '';

        if (data.incidencias && data.incidencias.length > 0) {
            data.incidencias.forEach(incidencia => {
                const nuevaTarjeta = crearTarjetaIncidencia(incidencia);
                contenedorIncidencias.insertAdjacentHTML('beforeend', nuevaTarjeta);
            });
        } else {
            // Mostrar mensaje de "No hay incidencias"
            contenedorIncidencias.innerHTML = `
                <div class="bg-white p-8 rounded-lg shadow-md text-center col-span-full">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay incidencias</h3>
                    <p class="text-gray-500 mb-4">No se encontraron incidencias con los filtros aplicados.</p>
                </div>
            `;
        }

        // Actualizar los contadores
        actualizarContadores(data.contadores);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al aplicar los filtros'
        });
    });
}