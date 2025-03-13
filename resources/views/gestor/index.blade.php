<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Panel de manager</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/manager/style.css') }}">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
</head>

<body>
    <div>
        <form action="" method="post" id="frmbusqueda">
            @csrf
            <div>
                <select name="prioridad" id="" onchange="datosincidencias()">
                    <option value="">Seleccionar prioridad</option>
                    <option value="1">alta</option>
                    <option value="2">media</option>
                    <option value="3">baja</option>
                </select>
            </div>
            <div>
                <label for="">fecha creacion</label>
                <input type="date" name="fechacreacion" id="" onchange="datosincidencias()">
            </div>
            <div>
                <label for="">fecha fin</label>
                <input type="date" name="fechafin" id="" onchange="datosincidencias()">
            </div>
            <button id="borrarfiltros">Limpiar filtros</button>
        </form>
    </div>

    <div id="infoincidencias">
        <div class="restaurante">
            <p>Incidencia:#3</p>
            <p>no funciona</p>
            <p>tecnico: juan</p>
            <p>cliente: albert</p>
            <p>estado: asignado</p>
            <form action="" method="post" id="frmaprioridadincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignaprioridad" onchange="prioridad(incidencia.id)">
                    <option value="">Asignar una prioridad</option>
                    <option value="1">alta</option>
                    <option value="2">baja</option>
                </select>
            </form>
            <form action="" method="post" id="frmasignarincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignadopara" onchange="asignar(incidencia.id)">
                    <option value="">Asignar a un tecnico</option>
                    <option value="1">juan</option>
                    <option value="2">pedro</option>
                </select>
            </form>
        </div>
        <div class="restaurante">
            <p>Incidencia:#3</p>
            <p>no funciona</p>
            <p>tecnico: juan</p>
            <p>cliente: albert</p>
            <p>estado: asignado</p>
            <form action="" method="post" id="frmaprioridadincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignaprioridad" onchange="prioridad(incidencia.id)">
                    <option value="">Asignar una prioridad</option>
                    <option value="1">alta</option>
                    <option value="2">baja</option>
                </select>
            </form>
            <form action="" method="post" id="frmasignarincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignadopara" onchange="asignar(incidencia.id)">
                    <option value="">Asignar a un tecnico</option>
                    <option value="1">juan</option>
                    <option value="2">pedro</option>
                </select>
            </form>
        </div>
        <div class="restaurante">
            <p>Incidencia:#3</p>
            <p>no funciona</p>
            <p>tecnico: juan</p>
            <p>cliente: albert</p>
            <p>estado: asignado</p>
            <form action="" method="post" id="frmaprioridadincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignaprioridad" onchange="prioridad(incidencia.id)">
                    <option value="">Asignar una prioridad</option>
                    <option value="1">alta</option>
                    <option value="2">baja</option>
                </select>
            </form>
            <form action="" method="post" id="frmasignarincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignadopara" onchange="asignar(incidencia.id)">
                    <option value="">Asignar a un tecnico</option>
                    <option value="1">juan</option>
                    <option value="2">pedro</option>
                </select>
            </form>
        </div>
        <div class="restaurante">
            <p>Incidencia:#3</p>
            <p>no funciona</p>
            <p>tecnico: juan</p>
            <p>cliente: albert</p>
            <p>estado: asignado</p>
            <form action="" method="post" id="frmaprioridadincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignaprioridad" onchange="prioridad(incidencia.id)">
                    <option value="">Asignar una prioridad</option>
                    <option value="1">alta</option>
                    <option value="2">baja</option>
                </select>
            </form>
            <form action="" method="post" id="frmasignarincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignadopara" onchange="asignar(incidencia.id)">
                    <option value="">Asignar a un tecnico</option>
                    <option value="1">juan</option>
                    <option value="2">pedro</option>
                </select>
            </form>
        </div>
        <div class="restaurante">
            <p>Incidencia:#3</p>
            <p>no funciona</p>
            <p>tecnico: juan</p>
            <p>cliente: albert</p>
            <p>estado: asignado</p>
            <form action="" method="post" id="frmaprioridadincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignaprioridad" onchange="prioridad(incidencia.id)">
                    <option value="">Asignar una prioridad</option>
                    <option value="1">alta</option>
                    <option value="2">baja</option>
                </select>
            </form>
            <form action="" method="post" id="frmasignarincidencia.id" onsubmit="event.preventDefault()">
                <select name="assignadopara" onchange="asignar(incidencia.id)">
                    <option value="">Asignar a un tecnico</option>
                    <option value="1">juan</option>
                    <option value="2">pedro</option>
                </select>
            </form>
        </div>
    </div>
</body>

</html>
<script src="{{ asset('js/manager/datosincidencias.js') }}"></script>
