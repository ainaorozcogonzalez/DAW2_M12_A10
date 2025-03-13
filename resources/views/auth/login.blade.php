<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistema de Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/auth/login.css'])
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-lg card-shadow overflow-hidden">
        <div class="px-10 py-12">
            <div class="text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="mx-auto h-16 w-auto">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Bienvenido
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Por favor, inicia sesión para acceder al sistema
                </p>
            </div>

            <form class="mt-8 space-y-6" id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email"
                            class="appearance-none rounded-md relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 input-focus focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Correo electrónico"
                            value="admin@incidencias.com">
                        <div id="email-error" class="text-red-500 text-sm mt-1 hidden">Por favor, introduce un email válido.</div>
                    </div>
                    <div>
                        <label for="password" class="sr-only">Contraseña</label>
                        <input id="password" name="password" type="password" autocomplete="current-password"
                            class="appearance-none rounded-md relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 input-focus focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Contraseña" value="qweQWE123">
                        <div id="password-error" class="text-red-500 text-sm mt-1 hidden">La contraseña debe tener al menos 8 caracteres.</div>
                    </div>
                </div>

                @if ($errors->has('general'))
                    <div class="text-red-600 text-sm mt-4 text-center">
                        {{ $errors->first('general') }}
                    </div>
                @endif

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 btn-login focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        id="submitButton">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </div>
        
        <div class="px-6 py-4 bg-gray-50">
            <p class="text-center text-sm text-gray-500">
                ¿No tienes una cuenta? 
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Contacta al administrador
                </a>
            </p>
        </div>
    </div>

    <script src="{{ asset('js/auth/login.js') }}"></script>
</body>
</html> 