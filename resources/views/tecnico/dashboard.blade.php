<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <button type="submit" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <h2 class="text-xl font-semibold mb-6">Incidencias Asignadas</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($incidencias as $incidencia)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-2">Incidencia #{{ $incidencia->id }}</h3>
                    <p class="text-gray-600 mb-4">{{ $incidencia->descripcion }}</p>
                    
                    <div class="space-y-2">
                        <p><span class="font-medium">Cliente:</span> {{ $incidencia->cliente->nombre }}</p>
                        <p><span class="font-medium">Estado:</span> {{ $incidencia->estado->nombre }}</p>
                        <p><span class="font-medium">Prioridad:</span> {{ $incidencia->prioridad->nombre }}</p>
                    </div>

                    <div class="mt-4 space-y-4">
                        <!-- Cambiar estado -->
                        <form action="{{ route('incidencias.cambiar-estado', $incidencia) }}" method="POST">
                            @csrf
                            <select name="estado_id" class="w-full px-3 py-2 border rounded-md" onchange="this.form.submit()">
                                @foreach($estados as $estado)
                                    @if(!in_array($estado->nombre, ['Sin asignar', 'Cerrada']))
                                        <option value="{{ $estado->id }}" {{ $incidencia->estado_id == $estado->id ? 'selected' : '' }}>
                                            {{ $estado->nombre }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </form>

                        <!-- Botón de Chat -->
                        <button onclick="openChatModal({{ $incidencia->id }})" class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            <i class="fas fa-comments"></i> Chat
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <!-- Modal de Chat -->
    <div id="chatModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Chat con el Cliente</h3>
                <div class="mt-4">
                    <!-- Área de mensajes -->
                    <div id="chatMessages" class="h-64 overflow-y-auto mb-4 border p-4 rounded-md">
                        <!-- Los mensajes se cargarán aquí -->
                    </div>

                    <!-- Formulario para enviar mensajes -->
                    <form id="chatForm" class="space-y-4" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        @csrf
                        <input type="hidden" name="incidencia_id" id="chatIncidenciaId">
                        <div>
                            <textarea name="mensaje" id="chatMensaje" class="w-full px-3 py-2 border rounded-md" placeholder="Escribe tu mensaje..."></textarea>
                        </div>
                        <div>
                            <input type="file" name="archivo" id="chatArchivo" class="w-full px-3 py-2 border rounded-md">
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
</body>
</html>

