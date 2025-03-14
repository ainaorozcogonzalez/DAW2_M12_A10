@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Incidencia</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('client.incidencias.store') }}" method="POST">
        @csrf

        <!-- Campo oculto para el ID del cliente -->
        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

        <!-- Campo oculto para el ID de la sede -->
        <input type="hidden" name="sede_id" value="{{ $sede->id }}">

        <!-- Selección de categoría -->
        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <select name="categoria_id" id="categoria_id" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Selección de subcategoría -->
        <div class="form-group">
            <label for="subcategoria_id">Subcategoría</label>
            <select name="subcategoria_id" id="subcategoria_id" class="form-control" required>
                <option value="">Seleccione una subcategoría</option>
                @foreach($subcategorias as $subcategoria)
                    <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Descripción de la incidencia -->
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Crear Incidencia</button>
    </form>
</div>
@endsection