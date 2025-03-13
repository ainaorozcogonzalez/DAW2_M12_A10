<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50" data-user-id="{{ auth()->id() }}">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Panel del Técnico</h1>
                <div class="flex items-center space-x-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-4 py-8">
            <!-- Contadores de incidencias -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-700">Incidencias Totales</h3>
                        <p class="text-2xl font-semibold text-blue-900">{{ $incidencias->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-yellow-700">Incidencias Pendientes</h3>
                        <p class="text-2xl font-semibold text-yellow-900">{{ $incidencias->where('estado.nombre', 'Pendiente')->count() }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-green-700">Incidencias Resueltas</h3>
                        <p class="text-2xl font-semibold text-green-900">{{ $incidencias->where('estado.nombre', 'Resuelta')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Sección de incidencias -->
            <div class="mb-8 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Incidencias Asignadas</h2>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="hideClosed" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 transition duration-200">
                    <label for="hideClosed" class="text-sm text-gray-600">Ocultar cerradas</label>
                </div>
            </div>

            <div id="incidenciasContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($incidencias as $incidencia)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 fade-in">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Incidencia #{{ $incidencia->id }}</h3>
                                <p class="text-sm text-gray-500">Creada: {{ $incidencia->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <span class="px-2 py-1 text-sm rounded-full estado-badge
                                @if($incidencia->estado->nombre == 'Pendiente') bg-yellow-100 text-yellow-800
                                @elseif($incidencia->estado->nombre == 'En progreso') bg-blue-100 text-blue-800
                                @elseif($incidencia->estado->nombre == 'Resuelta') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $incidencia->estado->nombre }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ Str::limit($incidencia->descripcion, 100) }}</p>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-user mr-2"></i>
                                <span>{{ $incidencia->cliente->nombre }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <span class="flex items-center space-x-1
                                    @if($incidencia->prioridad->nombre == 'Baja') text-gray-500
                                    @elseif($incidencia->prioridad->nombre == 'Media') text-yellow-500
                                    @elseif($incidencia->prioridad->nombre == 'Alta') text-red-500
                                    @elseif($incidencia->prioridad->nombre == 'Urgente') text-red-600
                                    @else text-gray-500 @endif">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $incidencia->prioridad->nombre }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            <div class="flex items-center justify-between">
                                <form action="{{ route('incidencias.cambiar-estado', $incidencia) }}" method="POST" class="cambiar-estado-form flex-1 mr-2">
                                    @csrf
                                    <select name="estado_id" class="w-full px-2 py-1 text-sm border rounded-md bg-gray-50 focus:ring-2 focus:ring-blue-500">
                                        @foreach($estados as $estado)
                                            @if(!in_array($estado->nombre, ['Sin asignar', 'Cerrada']))
                                                <option value="{{ $estado->id }}" {{ $incidencia->estado_id == $estado->id ? 'selected' : '' }}>
                                                    {{ $estado->nombre }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </form>
                                <button onclick="openChatModal({{ $incidencia->id }})" class="text-green-500 hover:text-green-700 transition duration-200" title="Chat">
                                    <i class="fas fa-comments"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <!-- Modal de Chat -->
    <div id="chatModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-5 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Chat con el Cliente</h3>
                <div class="mt-4">
                    <!-- Área de mensajes -->
                    <div id="chatMessages" class="h-80 overflow-y-auto mb-4 border p-4 rounded-md">
                        @if(isset($mensajes) && count($mensajes) > 0)
                            @foreach($mensajes as $mensaje)
                                <div class="mb-2 {{ $mensaje->usuario_id == auth()->id() ? 'text-right' : 'text-left' }}">
                                    <div class="inline-block max-w-2/3 px-4 py-2 rounded-lg {{ $mensaje->usuario_id == auth()->id() ? 'bg-blue-100' : 'bg-gray-100' }}">
                                        @if($mensaje->mensaje)
                                            <p class="text-sm">{{ $mensaje->mensaje }}</p>
                                        @endif
                                        @if($mensaje->archivo)
                                            <a href="{{ $mensaje->archivo->url_archivo }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                                Ver archivo adjunto
                                            </a>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">{{ $mensaje->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 text-center">No hay mensajes para mostrar.</p>
                        @endif
                    </div>

                    <!-- Formulario para enviar mensajes -->
                    <form id="chatForm" class="space-y-4" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        @csrf
                        <input type="hidden" name="incidencia_id" id="chatIncidenciaId">
                        <div>
                            <textarea name="mensaje" id="chatMensaje" class="w-full px-3 py-2 border rounded-md" placeholder="Escribe tu mensaje..."></textarea>
                        </div>
                        <div class="relative">
                            <input type="file" name="archivo" id="chatArchivo" class="hidden">
                            <label for="chatArchivo" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 cursor-pointer flex items-center justify-center space-x-2">
                                <i class="fas fa-paperclip"></i>
                                <span>Adjuntar archivo</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 text-center">Formatos aceptados: JPG, PNG, PDF, WEBP, ZIP, RAR, TAR, GZ (máximo 20MB)</p>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="closeChatModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Cerrar
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                <i class="fas fa-paper-plane"></i> Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Referencia al archivo JavaScript externo -->
    <script src="{{ asset('js/chat.js') }}"></script>
    <script>
        document.getElementById('hideClosed').addEventListener('change', function() {
            const incidencias = document.querySelectorAll('#incidenciasContainer > div');
            incidencias.forEach(incidencia => {
                const estado = incidencia.querySelector('.estado-badge').textContent.trim();
                if (estado === 'Cerrada') {
                    incidencia.style.display = this.checked ? 'none' : 'block';
                }
            });
        });
    </script>
</body>
</html>

