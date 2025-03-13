<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800">Menú</h2>
                <nav class="mt-6">
                    <a href="{{ route('admin.dashboard') }}"
                        class="block py-2 px-4 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-md transition-colors">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('incidencias.index') }}"
                        class="block py-2 px-4 bg-indigo-50 text-indigo-600 rounded-md">
                        <i class="fas fa-tasks mr-2"></i>Incidencias
                    </a>
                    <!-- Puedes añadir más opciones de menú aquí -->
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="container mx-auto px-4 py-6 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Gestión de Incidencias</h1>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                <img src="https://ui-avatars.com/api/?name=Admin" alt="Admin"
                                    class="w-8 h-8 rounded-full">
                                <span class="text-gray-700">Admin</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <!-- Menú desplegable -->
                            <div id="user-menu"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                                <form method="POST" action="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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

            <!-- Main Content -->
            <main class="container mx-auto px-4 py-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Listado de Incidencias</h2>
                    <button onclick="openIncidenciaModal()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        <i class="fas fa-plus"></i> Nueva Incidencia
                    </button>
                </div>

                <!-- Filtros -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="estado_id" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="estado_id" id="estado_id" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todos</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}"
                                        {{ request('estado_id') == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="prioridad_id" class="block text-sm font-medium text-gray-700">Prioridad</label>
                            <select name="prioridad_id" id="prioridad_id" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todas</option>
                                @foreach ($prioridades as $prioridad)
                                    <option value="{{ $prioridad->id }}"
                                        {{ request('prioridad_id') == $prioridad->id ? 'selected' : '' }}>
                                        {{ $prioridad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                            <select name="cliente_id" id="cliente_id" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todos</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="tecnico_id" class="block text-sm font-medium text-gray-700">Técnico</label>
                            <select name="tecnico_id" id="tecnico_id" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todos</option>
                                @foreach ($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}"
                                        {{ request('tecnico_id') == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
                            <select name="sede_id" id="sede_id" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todas</option>
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}"
                                        {{ request('sede_id') == $sede->id ? 'selected' : '' }}>{{ $sede->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                            <select name="categoria_id" id="categoria_id" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todas</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3 lg:col-span-4 flex justify-end space-x-4">
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <a href="{{ route('incidencias.index') }}"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Incidencias Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Título</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Descripción</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prioridad</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cliente</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Técnico</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($incidencias as $incidencia)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $incidencia->titulo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $incidencia->descripcion }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $incidencia->estado->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $incidencia->prioridad->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $incidencia->cliente->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $incidencia->tecnico ? $incidencia->tecnico->nombre : 'Sin asignar' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="openEditIncidenciaModal({{ $incidencia->id }})"
                                            class="text-indigo-600 hover:text-indigo-900 mr-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('incidencias.destroy', $incidencia) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('¿Estás seguro de eliminar esta incidencia?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal para crear/editar incidencias -->
    <div id="incidenciaModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Crear Nueva Incidencia</h3>
                <form class="mt-4 space-y-4" method="POST" id="incidenciaForm">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="incidencia_id" id="incidencia_id">
                    <div>
                        <input type="text" name="titulo" id="titulo" placeholder="Título"
                            class="w-full px-3 py-2 border rounded-md" autocomplete="off">
                        <div id="titulo-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <textarea name="descripcion" id="descripcion" placeholder="Descripción" class="w-full px-3 py-2 border rounded-md"
                            autocomplete="off"></textarea>
                        <div id="descripcion-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="estado_id" id="estado_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="estado_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="prioridad_id" id="prioridad_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una prioridad</option>
                            @foreach ($prioridades as $prioridad)
                                <option value="{{ $prioridad->id }}">{{ $prioridad->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="prioridad_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="cliente_id" id="cliente_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione un cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="cliente_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="tecnico_id" id="tecnico_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione un técnico</option>
                            @foreach ($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="tecnico_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="sede_id" id="sede_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una sede</option>
                            @foreach ($sedes as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="sede_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="categoria_id" id="categoria_id_modal"
                            class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="categoria_id_modal-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="subcategoria_id" id="subcategoria_id"
                            class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una subcategoría</option>
                            @foreach ($subcategorias as $subcategoria)
                                <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="subcategoria_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeIncidenciaModal()"
                            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">Cancelar</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/incidencia-form.js') }}"></script>
    <script src="{{ asset('js/subcategoria-form.js') }}"></script>
    <script src="{{ asset('js/categoria-form.js') }}"></script>
    <script src="{{ asset('js/user-form.js') }}"></script>
    <script>
        // Funciones para abrir/cerrar el modal
        function openIncidenciaModal() {
            document.getElementById('modalTitle').innerText = 'Crear Nueva Incidencia';
            document.getElementById('formMethod').value = 'POST';
            resetForm();
            document.getElementById('incidenciaModal').classList.remove('hidden');
        }

        function openEditIncidenciaModal(incidenciaId) {
            axios.get(`/incidencias/${incidenciaId}/edit`)
                .then(response => {
                    const incidencia = response.data;
                    document.getElementById('modalTitle').innerText = 'Editar Incidencia';
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('incidenciaForm').action = `/incidencias/${incidenciaId}`;
                    document.getElementById('incidencia_id').value = incidencia.id;
                    document.getElementById('titulo').value = incidencia.titulo;
                    document.getElementById('descripcion').value = incidencia.descripcion;
                    document.getElementById('estado_id').value = incidencia.estado_id;
                    document.getElementById('prioridad_id').value = incidencia.prioridad_id;
                    document.getElementById('cliente_id').value = incidencia.cliente_id;
                    document.getElementById('tecnico_id').value = incidencia.tecnico_id;
                    document.getElementById('sede_id').value = incidencia.sede_id;
                    document.getElementById('categoria_id_modal').value = incidencia.categoria_id;
                    document.getElementById('subcategoria_id').value = incidencia.subcategoria_id;
                    document.getElementById('incidenciaModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching incidencia data:', error);
                });
        }

        function closeIncidenciaModal() {
            document.getElementById('incidenciaModal').classList.add('hidden');
            resetForm();
        }

        function resetForm() {
            document.getElementById('incidenciaForm').reset();
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(error => error.classList.add('hidden'));
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => input.classList.remove('border-red-500'));
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            if (event.target == document.getElementById('incidenciaModal')) {
                closeIncidenciaModal();
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
