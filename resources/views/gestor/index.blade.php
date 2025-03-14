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
            <form action="" method="post" id="frmbusqueda" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
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
                    <label for="fechacreacion" class="block text-sm font-medium text-gray-700 mb-1">Fecha creación</label>
                    <input type="date" name="fechacreacion" id="fechacreacion" onchange="datosincidencias()" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200">
                </div>
                <div>
                    <label for="fechafin" class="block text-sm font-medium text-gray-700 mb-1">Fecha fin</label>
                    <input type="date" name="fechafin" id="fechafin" onchange="datosincidencias()" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 transition duration-200">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center space-x-2 transition duration-200">
                        <i class="fas fa-filter"></i>
                        <span>Filtrar</span>
                    </button>
                    <button type="button" id="borrarfiltros" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded flex items-center space-x-2 transition duration-200">
                        <i class="fas fa-sync"></i>
                        <span>Limpiar</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Incidencias mejoradas -->
        <div id="infoincidencias" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Incidencia 1 -->
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Incidencia #1</h3>
                            <p class="text-sm text-gray-500">Creada: 01/01/2023</p>
                        </div>
                        <span class="px-2 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                            Asignada
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4">La pantalla no enciende</p>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user-cog text-indigo-500 mr-2"></i>
                            <span>Técnico: Técnico</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user text-green-500 mr-2"></i>
                            <span>Cliente: Cliente</span>
                        </div>
                        <div class="flex items-center space-x-1 text-red-500">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Alta</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incidencia 2 -->
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Incidencia #2</h3>
                            <p class="text-sm text-gray-500">Creada: 01/01/2023</p>
                        </div>
                        <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">
                            Resuelta
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4">El sistema operativo no arranca</p>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user-cog text-indigo-500 mr-2"></i>
                            <span>Técnico: Técnico</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user text-green-500 mr-2"></i>
                            <span>Cliente: Cliente</span>
                        </div>
                        <div class="flex items-center space-x-1 text-yellow-500">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Media</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incidencia 3 -->
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Incidencia #3</h3>
                            <p class="text-sm text-gray-500">Creada: 01/01/2023</p>
                        </div>
                        <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                            Cerrada
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4">No hay conexión WiFi</p>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user-cog text-indigo-500 mr-2"></i>
                            <span>Técnico: Técnico</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user text-green-500 mr-2"></i>
                            <span>Cliente: Cliente</span>
                        </div>
                        <div class="flex items-center space-x-1 text-gray-500">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Baja</span>
                        </div>
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
