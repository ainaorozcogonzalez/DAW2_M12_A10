@foreach($incidencias as $incidencia)
    @include('cliente.partials.incidencia-card', ['incidencia' => $incidencia])
@endforeach
