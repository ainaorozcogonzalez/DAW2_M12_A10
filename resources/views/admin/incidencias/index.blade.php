<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
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
                    <form method="GET" id="formfiltros" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4"
                        onsubmit="mostrardatosincidencias(event.preventDefault())">
                        @csrf
                        <div>
                            <label for="estado_id" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="estado_id" class="w-full px-3 py-2 border rounded-md mostrar_estado">
                                <option value="">Intentelo más tarde</option>
                            </select>
                        </div>
                        <div>
                            <label for="prioridad_id" class="block text-sm font-medium text-gray-700">Prioridad</label>
                            <select name="prioridad_id"
                                class="w-full px-3 py-2 border rounded-md prioridad_id_incidencia">
                                <option value="">Intentelo más tarde</option>
                            </select>
                        </div>
                        <div>
                            <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                            <select name="cliente_id" class="w-full px-3 py-2 border rounded-md mostrar_clientes">
                                <option value="">Intentelo más tarde</option>
                            </select>
                        </div>
                        <div>
                            <label for="tecnico_id" class="block text-sm font-medium text-gray-700">Técnico</label>
                            <select name="tecnico_id" class="w-full px-3 py-2 border rounded-md mostrartecnicos">
                                <option value="">Intentelo más tarde</option>
                            </select>
                        </div>
                        <div>
                            <label for="sede_id" class="block text-sm font-medium text-gray-700">Sede</label>
                            <select name="sede_id" class="w-full px-3 py-2 border rounded-md mostrar_sedes">
                                <option value="">Intentelo más tarde</option>
                            </select>
                        </div>
                        <div>
                            <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                            <select name="categoria_id" class="w-full px-3 py-2 border rounded-md mostrar_categorias">
                                <option value="">Intentelo más tarde</option>
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
                        <tbody id="resultadostabla" class="bg-white divide-y divide-gray-200">

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
                    <input type="hidden" name="incidencia_id" id="incidencia_id">
                    <div>
                        <textarea name="descripcion" id="descripcion_incidencia" placeholder="Descripción de la incidencia"
                            class="w-full px-3 py-2 border rounded-md"></textarea>
                        <div id="descripcion_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="sede_id" id="incidencia_sede_id"
                            class="w-full px-3 py-2 border rounded-md mostrar_sedes">
                            <option value="">Seleccione una sede</option>
                        </select>
                        <div id="sede_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="cliente_id" id="cliente_id_incidencia"
                            class="w-full px-3 py-2 border rounded-md">
                            <option value="">Primero seleccione una sede</option>
                        </select>
                        <div id="cliente_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
                    </div>
                    <div>
                        <select name="tecnico_id" id="tecnico_id_incidencia"
                            class="w-full px-3 py-2 border rounded-md ">
                            <option value="">Primero seleccione una sede</option>
                        </select>
                        <div id="tecnico_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
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
                            class="w-full px-3 py-2 border rounded-md">
                            <option value="">Primero seleccione una categoría</option>
                        </select>
                        <div id="subcategoria_id_incidencia-error" class="text-red-500 text-sm mt-1"></div>
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
                            class="w-full px-3 py-2 border rounded-md prioridad_id_incidencia">
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

    <script src="{{ asset('js/admin/incidencias/acciones.js') }}"></script>
    <script src="{{ asset('js/admin/incidencias/modals.js') }}"></script>
    <script src="{{ asset('js/admin/incidencias/datosincidencias.js') }}"></script>
    <script src="{{ asset('js/admin/incidencias/validacionincidencia.js') }}"></script>
</body>

</html>
