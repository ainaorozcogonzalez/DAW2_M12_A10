<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="{{ asset('js/incidencia-modal.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Panel del Cliente</h1>
            <div class="flex items-center space-x-4">
                <button class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-bell"></i>
                </button>
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nombre }}" alt="{{ auth()->user()->nombre }}" class="w-8 h-8 rounded-full">
                        <span class="text-gray-700">{{ auth()->user()->nombre }}</span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>
                    <!-- Menú desplegable -->
                    <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                        <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            @csrf
                            <button type="submit" class="w-full text-left">
                                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Mis Incidencias</h1>
            <button onclick="openIncidenciaModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center space-x-2 transition duration-200">
                <i class="fas fa-plus"></i>
                <span>Nueva Incidencia</span>
            </button>
        </div>

        <!-- Filtros y ordenación mejorados -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <form action="{{ route('client.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="estado_id" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="estado_id" id="estado_id" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <option value="">Todos</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id }}" {{ request('estado_id') == $estado->id ? 'selected' : '' }}>{{ $estado->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="prioridad_id" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                    <select name="prioridad_id" id="prioridad_id" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <option value="">Todas</option>
                        @foreach($prioridades as $prioridad)
                            <option value="{{ $prioridad->id }}" {{ request('prioridad_id') == $prioridad->id ? 'selected' : '' }}>{{ $prioridad->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="excluir_cerradas" id="excluir_cerradas" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 transition duration-200" {{ request('excluir_cerradas') ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">Excluir cerradas</span>
                    </label>
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center space-x-2 transition duration-200">
                        <i class="fas fa-filter"></i>
                        <span>Filtrar</span>
                    </button>
                    <a href="{{ route('client.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded flex items-center space-x-2 transition duration-200">
                        <i class="fas fa-sync"></i>
                        <span>Limpiar</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-700">Incidencias Totales</h3>
                    <p class="text-2xl font-semibold text-blue-900">{{ $contadorTotal }}</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-yellow-700">Incidencias Pendientes</h3>
                    <p class="text-2xl font-semibold text-yellow-900">{{ $contadorPendientes }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-green-700">Incidencias Cerradas</h3>
                    <p class="text-2xl font-semibold text-green-900">{{ $contadorCerradas }}</p>
                </div>
            </div>
        </div>

        <!-- Sección de incidencias con título y descripción -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Mis Incidencias Reportadas</h2>
        </div>

        <!-- Listado de incidencias mejorado con tarjetas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($incidencias as $incidencia)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-sm text-gray-500">{{ $incidencia->fecha_creacion?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                                <h3 class="text-lg font-semibold mt-1">{{ Str::limit($incidencia->descripcion, 40) }}</h3>
                            </div>
                            <div class="flex space-x-2">
                                @php
                                    $estadoColors = [
                                        'Resuelta' => 'bg-green-100 text-green-800',
                                        'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'En progreso' => 'bg-blue-100 text-blue-800',
                                        'Baja' => 'bg-gray-100 text-gray-800',
                                        'Urgente' => 'bg-red-100 text-red-800',
                                        'default' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $estadoColor = $estadoColors[$incidencia->estado->nombre] ?? $estadoColors['default'];
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full {{ $estadoColor }}">
                                    {{ $incidencia->estado->nombre }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-600 mb-4">
                            <div class="flex items-center space-x-2 mb-2">
                                <i class="fas fa-tag text-gray-400"></i>
                                <span>{{ $incidencia->categoria->nombre }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                                <span>{{ $incidencia->sede->nombre }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                @php
                                    $prioridadColors = [
                                        'Alta' => 'text-red-500',
                                        'Media' => 'text-yellow-500',
                                        'Baja' => 'text-gray-500',
                                        'default' => 'text-gray-500'
                                    ];
                                    $prioridadColor = $prioridadColors[$incidencia->prioridad->nombre] ?? $prioridadColors['default'];
                                @endphp
                                <span class="{{ $prioridadColor }}">
                                    <i class="fas fa-exclamation-circle"></i>
                                </span>
                                <span class="text-sm {{ $prioridadColor }}">
                                    {{ $incidencia->prioridad->nombre }}
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="text-green-500 hover:text-green-700 transition duration-200" title="Chat">
                                    <i class="fas fa-comments"></i>
                                </a>
                                <button onclick="confirmarCierre({{ $incidencia->id }})" class="text-red-500 hover:text-red-700 transition duration-200" title="Cerrar incidencia" {{ $incidencia->estado_id == 5 ? 'disabled' : '' }}>
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($incidencia->fecha_resolucion)
                        <div class="bg-green-50 px-6 py-3 border-t">
                            <div class="text-sm text-green-700 flex items-center space-x-2">
                                <i class="fas fa-check-circle"></i>
                                <span>Resuelta el {{ $incidencia->fecha_resolucion->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($incidencias->isEmpty())
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay incidencias</h3>
                <p class="text-gray-500 mb-4">Parece que no has reportado ninguna incidencia todavía.</p>
                <button onclick="openIncidenciaModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-plus mr-2"></i>Crear nueva incidencia
                </button>
            </div>
        @endif
    </div>

    <!-- Modal para crear incidencias -->
    <div id="incidenciaModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Nueva Incidencia</h3>
                <div id="form-error" class="text-red-500 text-sm mt-1 hidden"></div>
                <form class="mt-4 space-y-4" method="POST" action="{{ route('incidencias.store') }}" id="incidenciaForm">
                    @csrf
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="w-full px-3 py-2 border rounded-md" required></textarea>
                        <div id="descripcion-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="w-full px-3 py-2 border rounded-md" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="categoria_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <label for="subcategoria_id" class="block text-sm font-medium text-gray-700">Subcategoría</label>
                        <select name="subcategoria_id" id="subcategoria_id" class="w-full px-3 py-2 border rounded-md" required>
                            <option value="">Seleccione una subcategoría</option>
                        </select>
                        <div id="subcategoria_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeIncidenciaModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Crear Incidencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Funciones para abrir/cerrar el modal
        function openIncidenciaModal() {
            document.getElementById('incidenciaModal').classList.remove('hidden');
        }

        function closeIncidenciaModal() {
            document.getElementById('incidenciaModal').classList.add('hidden');
        }

        document.getElementById('categoria_id').addEventListener('change', function() {
            var categoriaId = this.value;
            var subcategoriaSelect = document.getElementById('subcategoria_id');
            subcategoriaSelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';

            if (categoriaId) {
                fetch(`/subcategorias/${categoriaId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subcategoria => {
                            var option = document.createElement('option');
                            option.value = subcategoria.id;
                            option.text = subcategoria.nombre;
                            subcategoriaSelect.appendChild(option);
                        });
                    });
            }
        });

        function confirmarCierre(incidenciaId) {
            if (confirm('¿Estás seguro de que deseas cerrar esta incidencia?')) {
                fetch(`/incidencias/${incidenciaId}/cerrar`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
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

        // Manejar el menú desplegable
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Cerrar el menú si se hace clic fuera de él
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>