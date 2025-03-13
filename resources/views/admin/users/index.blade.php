<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport content="width=device-width, initial-scale="1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                    <a href="{{ route('users.index') }}"
                        class="block py-2 px-4 bg-indigo-50 text-indigo-600 rounded-md">
                        <i class="fas fa-users mr-2"></i>Usuarios
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="container mx-auto px-4 py-6 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h1>
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
                    <h2 class="text-xl font-semibold">Listado de Usuarios</h2>
                    <button onclick="openUserModal()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </button>
                </div>

                <!-- Filtros -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <form method="POST" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4" id="formfiltros"
                        onsubmit="mostrardatosusuarios(event.preventDefault())">
                        @csrf
                        <div>
                            <label for="rol_id" class="block text-sm font-medium text-gray-700">Rol</label>
                            <select name="rol_id" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todos</option>
                                <span class="mostrar_roles"></span>
                            </select>
                        </div>
                        <div>
                            <label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
                            <select name="sede_id" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todas</option>
                                <span class="mostrar_sedes"></span>
                            </select>
                        </div>
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="estado" class="w-full px-3 py-2 border rounded-md">
                                <option value="">Todos</option>
                                <span class="mostrar_estados"></span>
                            </select>
                        </div>
                        <div class="md:col-span-3 lg:col-span-4 flex justify-end space-x-4">
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button type="button" id="btnBorrarFiltros"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                <i class="fas fa-times"></i> Limpiar
                            </button>
                        </div>
                    </form>
                </div>

                <!-- User Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="datosusuarios"></div>
            </main>
        </div>
    </div>

    <!-- Modal para crear/editar usuarios -->
    <div id="userModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Crear Nuevo Usuario</h3>
                <form class="mt-4 space-y-4" method="POST" id="userForm">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="user_id" id="user_id">
                    <div>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre completo"
                            class="w-full px-3 py-2 border rounded-md" autocomplete="name">
                        <div id="nombre-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="email" name="email" id="email" placeholder="Correo electrónico"
                            class="w-full px-3 py-2 border rounded-md" autocomplete="email">
                        <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="password" name="password" id="password" placeholder="Contraseña"
                            class="w-full px-3 py-2 border rounded-md" autocomplete="new-password">
                        <div id="password-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="rol_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione un rol</option>
                            <span class="mostrar_roles"></span>
                        </select>
                        <div id="rol-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="sede_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una sede</option>
                            <span class="mostrar_sedes"></span>
                        </select>
                        <div id="sede-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="estado" class="w-full px-3 py-2 border rounded-md">
                            <span class="mostrar_estados"></span>
                        </select>
                        <div id="estado-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeUserModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/users/modals.js') }}"></script>
    <script src="{{ asset('js/users/datosusuarios.js') }}"></script>
    <script src="{{ asset('js/users/acciones.js') }}"></script>
</body>

</html>
