<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <form class="mt-4 space-y-4" method="POST" id="userForm"
                    onsubmit="Crearusuario(event.preventDefault())">
                    @csrf
                    @method('POST')
                    <div>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre completo"
                            class="w-full px-3 py-2 border rounded-md" required value="asdASD">
                        <div id="nombre-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="email" name="email" id="email" placeholder="Correo electrónico"
                            class="w-full px-3 py-2 border rounded-md" required value="asd@asd.com">
                        <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="password" name="password" id="password" placeholder="Contraseña"
                            class="w-full px-3 py-2 border rounded-md" autocomplete="current-password"
                            value="asdASD123" required>
                        <div id="password-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="rol_id" id="rol_id_dashboard" class="w-full px-3 py-2 border rounded-md"
                            required>
                            <option value="">Seleccione un rol</option>
                            <span class="mostrar_roles"></span>
                        </select>
                        <div id="rol-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="sede_id" id="sede_id_dashboard" class="w-full px-3 py-2 border rounded-md"
                            required>
                            <option value="">Seleccione una sede</option>
                            <span class="mostrar_sedes"></span>
                        </select>
                        <div id="sede-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <select name="estado" id="estado_dashboard" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione un estado</option>
                            <span class="mostrar_estadousuario"></span>
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

    <!-- Incidencia Modal -->
    <div id="incidenciaModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Nueva Incidencia</h3>
                <form class="mt-4 space-y-4" method="POST" id="incidenciaForm"
                    onsubmit="crearincidencia(event.preventDefault())">
                    @csrf
                    <div>
                        <select name="cliente_id" id="cliente_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione un cliente</option>
                            <span class="mostrar_clientes"></span>
                        </select>
                        <div id="cliente_id-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="sede_id" id="incidencia_sede_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una sede</option>
                            <span class="mostrar_sedes"></span>
                        </select>
                        <div id="sede_id-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="categoria_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una categoría</option>
                            <span class="mostrar_categorias"></span>
                        </select>
                        <div id="categoria_id-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="subcategoria_id" id="subcategoria_id"
                            class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una subcategoría</option>
                            <span class="mostrar_subcategorias"></span>
                        </select>
                        <div id="subcategoria_id-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <textarea name="descripcion" id="descripcion" placeholder="Descripción de la incidencia"
                            class="w-full px-3 py-2 border rounded-md"></textarea>
                        <div id="descripcion-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="estado_id" id="estado_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione un estado</option>
                            <span class="mostrar_estado"></span>
                        </select>
                        <div id="estado_id-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="prioridad_id" id="prioridad_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una prioridad</option>
                            <span class="mostrar_prioridades"></span>
                        </select>
                        <div id="prioridad_id-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeIncidenciaModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Crear Incidencia
                        </button>
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
                <form class="mt-4 space-y-4" method="POST" id="categoriaForm"
                    onsubmit="crearcategoria(event.preventDefault())">
                    @csrf
                    <div>
                        <input type="text" name="nombre" id="nombre_categoria"
                            placeholder="Nombre de la categoría" class="w-full px-3 py-2 border rounded-md">
                        <div id="nombre_categoria-error" class="error-message"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeCategoriaModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Crear Categoría
                        </button>
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
                    onsubmit="crearsubcategoria(event.preventDefault())">
                    @csrf
                    <div>
                        <select name="categoria_id" class="w-full px-3 py-2 border rounded-md">
                            <option value="">Seleccione una categoría</option>
                            <span class="mostrar_categorias"></span>
                        </select>
                        <div id="categoria_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div>
                        <input type="text" name="nombre" id="nombre_subcategoria"
                            placeholder="Nombre de la subcategoría" class="w-full px-3 py-2 border rounded-md">
                        <div id="nombre_subcategoria-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="closeSubcategoriaModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Crear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    {{-- <script src="{{ asset('js/user-form.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/incidencia-form.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/categoria-form.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/subcategoria-form.js') }}"></script> --}}
    <script src="{{ asset('js/admin/acciones.js') }}"></script>

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

        function openIncidenciaModal() {
            document.getElementById('incidenciaModal').classList.remove('hidden');
        }

        function closeIncidenciaModal() {
            document.getElementById('incidenciaModal').classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('incidenciaModal');
            if (event.target == modal) {
                closeIncidenciaModal();
            }
        }

        function openCategoriaModal() {
            document.getElementById('categoriaModal').classList.remove('hidden');
        }

        function closeCategoriaModal() {
            document.getElementById('categoriaModal').classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('categoriaModal');
            if (event.target == modal) {
                closeCategoriaModal();
            }
        }

        function openSubcategoriaModal() {
            document.getElementById('subcategoriaModal').classList.remove('hidden');
        }

        function closeSubcategoriaModal() {
            document.getElementById('subcategoriaModal').classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('subcategoriaModal');
            if (event.target == modal) {
                closeSubcategoriaModal();
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

        // Validaciones JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('userForm');
            if (!form) return;

            const fields = {
                nombre: {
                    required: true,
                    regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
                    message: 'El nombre solo puede contener letras y espacios.'
                },
                email: {
                    required: true,
                    regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                    message: 'El formato del email no es válido.'
                },
                password: {
                    required: true,
                    regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/,
                    message: 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.'
                },
                rol_id: {
                    required: true,
                    message: 'Seleccione un rol'
                },
                sede_id: {
                    required: true,
                    message: 'Seleccione una sede'
                },
                estado: {
                    required: true,
                    message: 'Seleccione un estado'
                }
            };

            Object.keys(fields).forEach(fieldId => {
                const input = document.getElementById(fieldId);
                if (input) {
                    input.addEventListener('blur', () => validateField(input, fields[fieldId]));
                }
            });

            form.addEventListener('submit', function(event) {
                let isValid = true;
                Object.keys(fields).forEach(fieldId => {
                    const input = document.getElementById(fieldId);
                    if (input && !validateField(input, fields[fieldId])) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                }
            });

            function validateField(input, rules) {
                const errorDiv = document.getElementById(`${input.id}-error`);
                errorDiv.textContent = '';
                input.classList.remove('border-red-500');

                const value = input.value.trim();

                if (rules.required && !value) {
                    showError(errorDiv, 'Este campo es obligatorio', input);
                    return false;
                }

                if (rules.regex && value && !rules.regex.test(value)) {
                    showError(errorDiv, rules.message, input);
                    return false;
                }

                return true;
            }

            function showError(errorDiv, message, input) {
                errorDiv.textContent = message;
                errorDiv.classList.remove('hidden');
                input.classList.add('border-red-500');
            }
        });
    </script>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div id="alerts"></div>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
