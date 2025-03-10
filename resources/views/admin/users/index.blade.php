<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport content="width=device-width, initial-scale=1.0">
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
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-md transition-colors">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('users.index') }}" class="block py-2 px-4 bg-indigo-50 text-indigo-600 rounded-md">
                        <i class="fas fa-users mr-2"></i>Usuarios
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
                    <h1 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h1>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div class="relative">
                            <button class="flex items-center space-x-2">
                                <img src="https://ui-avatars.com/api/?name=Admin" alt="Admin" class="w-8 h-8 rounded-full">
                                <span class="text-gray-700">Admin</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Listado de Usuarios</h2>
            <button onclick="openUserModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                <i class="fas fa-plus"></i> Nuevo Usuario
            </button>
        </div>

        <!-- User Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($users as $user)
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-indigo-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">{{ $user->nombre }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    <p class="text-sm"><span class="font-medium">Rol:</span> {{ $user->rol->nombre }}</p>
                    <p class="text-sm"><span class="font-medium">Sede:</span> {{ $user->sede->nombre }}</p>
                    <p class="text-sm">
                        <span class="font-medium">Estado:</span>
                        <span class="px-2 py-1 text-sm rounded-full {{ $user->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($user->estado) }}
                        </span>
                    </p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button onclick="openEditModal({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
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
                        <select name="rol_id" id="rol_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione un rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="rol-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="sede_id" id="sede_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una sede</option>
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                            @endforeach
                        </select>
                        <div id="sede-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="estado" id="estado" class="w-full px-3 py-2 border rounded-md">
                            <option value="inactivo">Inactivo</option>
                            <option value="activo">Activo</option>
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

    <script src="{{ asset('js/user-modal.js') }}"></script>
</body>
</html> 