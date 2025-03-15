<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
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
                        <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name=Admin" alt="Admin"
                                class="w-8 h-8 rounded-full">
                            <span class="text-gray-700"> <span class="nombreusuario"></span></span>
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
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-lg p-6 text-white mb-8">
                <h2 class="text-2xl font-bold mb-2">Bienvenido, <span class="nombreusuario"></span>!</h2>
                <p class="text-gray-100">Aquí puedes gestionar todos los aspectos del sistema de incidencias.</p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <a href="{{ route('users.index') }}" class="flex items-center space-x-4">
                        <div class="p-3 bg-indigo-50 rounded-full">
                            <i class="fas fa-users text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Usuarios</p>
                            <p class="text-2xl font-bold" id="totalusuarios"></p>
                        </div>
                    </a>
                </div>
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <a href="{{ route('incidencias.index') }}" class="flex items-center space-x-4">
                        <div class="p-3 bg-green-50 rounded-full">
                            <i class="fas fa-tasks text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Incidencias</p>
                            <p class="text-2xl font-bold" id="totalincidencias"></p>
                        </div>
                    </a>
                </div>
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <i class="fas fa-chart-line text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Reportes</p>
                            <p class="text-2xl font-bold">
                                {{ App\Models\Incidencia::whereNotNull('fecha_resolucion')->count() }}</p>
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
                        <button onclick="openUserModal()"
                            class="p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                            <i class="fas fa-user-plus text-indigo-600 mb-2"></i>
                            <p class="text-sm font-medium">Agregar Usuario</p>
                        </button>
                        <button onclick="openIncidenciaModal()"
                            class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-plus-circle text-green-600 mb-2"></i>
                            <p class="text-sm font-medium">Crear Incidencia</p>
                        </button>
                        <button onclick="openCategoriaModal()"
                            class="p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                            <i class="fas fa-plus text-yellow-600 mb-2"></i>
                            <p class="text-sm font-medium">Crear Categoría</p>
                        </button>
                        <button onclick="openSubcategoriaModal()"
                            class="p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <i class="fas fa-plus text-red-600 mb-2"></i>
                            <p class="text-sm font-medium">Crear Subcategoría</p>
                        </button>
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
                <form class="mt-4 space-y-4" method="POST" id="userForm" onsubmit="Crearusuario(event)">
                    @csrf
                    @method('POST')
                    <div>
                        <input type="text" name="nombre" id="nombre_user" placeholder="Nombre completo"
                            class="w-full px-3 py-2 border rounded-md" autocomplete="username">
                        <div id="nombre_user-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="email" name="email" id="email_user" placeholder="Correo electrónico"
                            class="w-full px-3 py-2 border rounded-md" autocomplete="email">
                        <div id="email_user-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="password" name="password" id="password_user" placeholder="Contraseña"
                            class="w-full px-3 py-2 border rounded-md" autocomplete="current-password">
                        <div id="password_user-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="rol_id" id="rol_id_user"
                            class="w-full px-3 py-2 border rounded-md mostrar_roles">
                            <option value="">Seleccione un rol</option>
                        </select>
                        <div id="rol_user-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="sede_id" id="sede_id_user"
                            class="w-full px-3 py-2 border rounded-md mostrar_sedes">
                            <option value="">Seleccione una sede</option>
                        </select>
                        <div id="sede_user-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="estado" id="estado_user"
                            class="w-full px-3 py-2 border rounded-md mostrar_estadousuario">
                            <option value="">Seleccione un estado</option>
                        </select>
                        <div id="estado_user-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeUserModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Crear
                            Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incidencia Modal -->
    <div id="incidenciaModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Nueva Incidencia</h3>
                <form class="mt-4 space-y-4" method="POST" id="incidenciaForm" onsubmit="crearincidencia(event)">
                    @csrf
                    <div>
                        <select name="cliente_id" id="cliente_id_incidencia"
                            class="w-full px-3 py-2 border rounded-md mostrar_clientes">
                            <option value="">Seleccione un cliente</option>
                        </select>
                        <div id="cliente_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="sede_id" id="incidencia_sede_id"
                            class="w-full px-3 py-2 border rounded-md mostrar_sedes">
                            <option value="">Seleccione una sede</option>
                        </select>
                        <div id="sede_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="categoria_id" id="categoria_id_incidencia"
                            class="w-full px-3 py-2 border rounded-md mostrar_categorias">
                            <option value="">Seleccione una categoría</option>
                        </select>
                        <div id="categoria_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="subcategoria_id" id="subcategoria_id_incidencia"
                            class="w-full px-3 py-2 border rounded-md mostrar_subcategorias">
                            <option value="">Seleccione una subcategoría</option>
                        </select>
                        <div id="subcategoria_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <textarea name="descripcion" id="descripcion_incidencia" placeholder="Descripción de la incidencia"
                            class="w-full px-3 py-2 border rounded-md"></textarea>
                        <div id="descripcion_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="estado_id" id="estado_id_incidencia"
                            class="w-full px-3 py-2 border rounded-md mostrar_estado">
                            <option value="">Seleccione un estado</option>
                        </select>
                        <div id="estado_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="prioridad_id" id="prioridad_id_incidencia"
                            class="w-full px-3 py-2 border rounded-md mostrar_prioridades">
                            <option value="">Seleccione una prioridad</option>
                        </select>
                        <div id="prioridad_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeIncidenciaModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Crear
                            Incidencia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Categoría Modal -->
    <div id="categoriaModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Nueva Categoría</h3>
                <form class="mt-4 space-y-4" method="POST" id="categoriaForm" onsubmit="crearcategoria(event)">
                    @csrf
                    <div>
                        <input type="text" name="nombre" id="nombre_categoria_modal"
                            placeholder="Nombre de la categoría" class="w-full px-3 py-2 border rounded-md">
                        <div id="nombre_categoria_modal-error" class="error-message"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeCategoriaModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Crear
                            Categoría</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Subcategoria Modal -->
    <div id="subcategoriaModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Nueva Subcategoría</h3>
                <form class="mt-4 space-y-4" method="POST" id="subcategoriaForm"
                    onsubmit="crearsubcategoria(event)">
                    @csrf
                    <div>
                        <select name="categoria_id" id="categoria_id_subcategoria"
                            class="w-full px-3 py-2 border rounded-md mostrar_categorias">
                            <option value="">Seleccione una categoría</option>
                        </select>
                        <div id="categoria_id_subcategoria-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="text" name="nombre" id="nombre_subcategoria_modal"
                            placeholder="Nombre de la subcategoría" class="w-full px-3 py-2 border rounded-md">
                        <div id="nombre_subcategoria_modal-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeSubcategoriaModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancelar</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/modals.js') }}"></script>
    <script src="{{ asset('js/admin/validacionuser.js') }}"></script>
    <script src="{{ asset('js/admin/validacionincidencia.js') }}"></script>
    <script src="{{ asset('js/admin/validacioncategoria.js') }}"></script>
    <script src="{{ asset('js/admin/validacionsubcategoria.js') }}"></script>



    <style>
        .border-red-500 {
            border-color: #ef4444 !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</body>

</html>
