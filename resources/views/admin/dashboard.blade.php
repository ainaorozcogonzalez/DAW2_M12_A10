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
                        <a href="{{ route('users.create') }}" class="p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                            <i class="fas fa-user-plus text-indigo-600 mb-2"></i>
                            <p class="text-sm font-medium">Agregar Usuario</p>
                        </a>
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
</body>
</html> 