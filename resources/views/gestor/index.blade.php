<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Panel de manager</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/manager/style.css') }}"> --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Panel del Gestor</h1>
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
        <!-- Filtros mejorados -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <form action="" method="post" id="frmbusqueda" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @csrf
                <div>
                    <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                    <select name="prioridad" id="prioridad" onchange="datosincidencias()" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <option value="">Todas</option>
                        <option value="1">Alta</option>
                        <option value="2">Media</option>
                        <option value="3">Baja</option>
                    </select>
                </div>
                <div>
                    <label for="tecnico" class="block text-sm font-medium text-gray-700 mb-1">Técnico</label>
                    <select name="tecnico" id="tecnico" onchange="datosincidencias()" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <option value="">Todos</option>
                    </select>
                </div>
                <div>
                    <label for="orden" class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                    <select name="orden" id="orden" onchange="datosincidencias()" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <option value="numerico" selected>Numérico</option>
                        <option value="desc">Prioridad: Menor a mayor</option>
                        <option value="asc">Prioridad: Mayor a menor</option>
                    </select>
                </div>
                <div>
                    <label for="fecha_creacion" class="block text-sm font-medium text-gray-700 mb-1">Fecha de creación</label>
                    <input type="date" name="fecha_creacion" id="fecha_creacion" onchange="datosincidencias()" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200">
                </div>
                <div class="flex items-end space-x-2">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="ocultarCerradas" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 transition duration-200">
                        <label for="ocultarCerradas" class="text-sm text-gray-600">Ocultar cerradas</label>
                    </div>
                    <button type="button" id="borrarfiltros" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded flex items-center space-x-2 transition duration-200">
                        <i class="fas fa-sync"></i>
                        <span>Limpiar</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Incidencias mejoradas -->
        <div id="infoincidencias" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($incidencias as $incidencia)
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Incidencia #{{ $incidencia['id'] }}</h3>
                            <p class="text-sm text-gray-500">Creada: {{ $incidencia['created_at']->format('d/m/Y H:i') }}</p>
                        </div>
                        <span class="px-2 py-1 text-sm rounded-full estado-badge">
                            {{ $incidencia['nombreestado'] }}
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4">{{ $incidencia['descripcion'] }}</p>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user-cog text-indigo-500 mr-2"></i>
                            <span>Técnico: {{ $incidencia['tecniconombre'] }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user text-green-500 mr-2"></i>
                            <span>Cliente: {{ $incidencia['clientenombre'] }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $incidencia['nombreprioridades'] }}</span>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal de Chat -->
    <div id="chatModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-5 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Chat de la Incidencia</h3>
                <div class="mt-4">
                    <!-- Área de mensajes -->
                    <div id="chatMessages" class="h-96 overflow-y-auto mb-4 border p-4 rounded-md">
                        <p class="text-gray-500 text-center">Cargando mensajes...</p>
                    </div>

                    <!-- Botón para cerrar -->
                    <div class="flex justify-end">
                        <button onclick="closeChatModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/manager/datosincidencias.js') }}"></script>

    <script>
        // Toggle user menu
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>

</body>

</html>
