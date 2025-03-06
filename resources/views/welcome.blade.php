<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redirección</title>
    <script>
        // Redirigir automáticamente al login
        window.location.href = "{{ route('login') }}";
    </script>
    </head>
<body>
    <p>Redirigiendo al login...</p>
    </body>
</html>
