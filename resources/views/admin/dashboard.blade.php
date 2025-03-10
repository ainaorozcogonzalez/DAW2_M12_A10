<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Panel de Administración</h1>
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
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-lg p-6 text-white mb-8">
                <h2 class="text-2xl font-bold mb-2">Bienvenido, Administrador!</h2>
                <p class="text-gray-100">Aquí puedes gestionar todos los aspectos del sistema de incidencias.</p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-indigo-50 rounded-full">
                            <i class="fas fa-users text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Usuarios</p>
                            <p class="text-2xl font-bold">{{ App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-green-50 rounded-full">
                            <i class="fas fa-tasks text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Incidencias</p>
                            <p class="text-2xl font-bold">{{ App\Models\Incidencia::count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <i class="fas fa-chart-line text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Reportes</p>
                            <p class="text-2xl font-bold">{{ App\Models\Incidencia::whereNotNull('fecha_resolucion')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-red-50 rounded-full">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Urgentes</p>
                            <p class="text-2xl font-bold">
                                @php
                                    $prioridadUrgente = App\Models\Prioridad::where('nombre', 'Urgente')->first();
                                    echo $prioridadUrgente ? $prioridadUrgente->incidencias()->count() : 0;
                                @endphp
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Actividad Reciente</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-blue-50 rounded-full">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-gray-700">Nuevo usuario registrado</p>
                                <p class="text-sm text-gray-500">Hace 2 horas</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-green-50 rounded-full">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-gray-700">Incidencia #123 resuelta</p>
                                <p class="text-sm text-gray-500">Hace 4 horas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold mb-4">Acciones Rápidas</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button onclick="openUserModal()" class="p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                            <i class="fas fa-user-plus text-indigo-600 mb-2"></i>
                            <p class="text-sm font-medium">Agregar Usuario</p>
                        </button>
                        <a href="{{ route('incidencias.create') }}" class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-plus-circle text-green-600 mb-2"></i>
                            <p class="text-sm font-medium">Crear Incidencia</p>
                        </a>
                        <a href="{{ route('reportes.index') }}" class="p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                            <i class="fas fa-chart-pie text-yellow-600 mb-2"></i>
                            <p class="text-sm font-medium">Generar Reporte</p>
                        </a>
                        <a href="{{ route('configuracion.index') }}" class="p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <i class="fas fa-cog text-red-600 mb-2"></i>
                            <p class="text-sm font-medium">Configuración</p>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- User Modal -->
    <div id="userModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Nuevo Usuario</h3>
                <form class="mt-4 space-y-4" method="POST" action="{{ route('users.store') }}" id="userForm">
                    @csrf
                    <div>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre completo"
                            class="w-full px-3 py-2 border rounded-md">
                        <div id="nombre-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="email" name="email" id="email" placeholder="Correo electrónico"
                            class="w-full px-3 py-2 border rounded-md">
                        <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="password" name="password" id="password" placeholder="Contraseña"
                            class="w-full px-3 py-2 border rounded-md">
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
                        <select name="estado" id="estado" class="w-full px-3 py-2 border rounded-md" required>
                            <option value="inactivo" selected>Inactivo</option>
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
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/user-form.js') }}"></script>

    <script>
        function openUserModal() {
            document.getElementById('userModal').classList.remove('hidden');
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('userModal');
            if (event.target == modal) {
                closeUserModal();
            }
        }
    </script>
</body>
</html> 