<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\User;
use App\Models\Sede;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\EstadoIncidencia;
use App\Models\Prioridad;
use Illuminate\Support\Facades\Auth;

class IncidenciaClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el formulario para crear una nueva incidencia.
     */
    public function create()
    {
        // Obtener el usuario autenticado (cliente)
        /** @var User $cliente */
        $cliente = Auth::user();

        // Obtener la sede del cliente
        $sede = $cliente->sede;

        // Obtener categorías y subcategorías
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();

        // Obtener estados y prioridades
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();

        // Pasar los datos a la vista
        return view('client.dashboard', compact(
            'cliente',
            'sede',
            'categorias',
            'subcategorias',
            'estados',
            'prioridades'
        ));
    }

    /**
     * Almacena una nueva incidencia en la base de datos.
     */
    public function store(Request $request)
    {
        // Obtener el usuario autenticado (cliente)
        /** @var User $cliente */
        $cliente = Auth::user();

        // Validar los datos del formulario
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'descripcion' => 'required|string|min:10|max:1000',
            'estado_id' => 'required|exists:estado_incidencias,id',
            'prioridad_id' => 'required|exists:prioridades,id'
        ], [
            'categoria_id.required' => 'Seleccione una categoría',
            'subcategoria_id.required' => 'Seleccione una subcategoría',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
            'descripcion.max' => 'La descripción no puede exceder los 1000 caracteres',
            'estado_id.required' => 'Seleccione un estado',
            'prioridad_id.required' => 'Seleccione una prioridad'
        ]);

        // Crear la incidencia
        Incidencia::create([
            'cliente_id' => $cliente->id, // Asignar el ID del cliente autenticado
            'sede_id' => $cliente->sede_id, // Asignar la sede del cliente autenticado
            'categoria_id' => $request->categoria_id,
            'subcategoria_id' => $request->subcategoria_id,
            'descripcion' => $request->descripcion,
            'estado_id' => $request->estado_id,
            'prioridad_id' => $request->prioridad_id,
            'fecha_creacion' => now(), // Asignar la fecha de creación automáticamente
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Incidencia creada exitosamente');
    }

    /**
     * Muestra el formulario para editar una incidencia existente.
     */
    public function edit(Incidencia $incidencia)
    {
        // Devolver los datos de la incidencia en formato JSON
        return response()->json([
            'id' => $incidencia->id,
            'cliente_id' => $incidencia->cliente_id,
            'tecnico_id' => $incidencia->tecnico_id,
            'sede_id' => $incidencia->sede_id,
            'categoria_id' => $incidencia->categoria_id,
            'subcategoria_id' => $incidencia->subcategoria_id,
            'descripcion' => $incidencia->descripcion,
            'estado_id' => $incidencia->estado_id,
            'prioridad_id' => $incidencia->prioridad_id,
        ]);
    }

    /**
     * Elimina una incidencia existente.
     */
    public function destroy(Incidencia $incidencia)
    {
        // Verificar si la incidencia existe
        if (!$incidencia) {
            return redirect()->route('incidencias.index')->with('error', 'Incidencia no encontrada');
        }

        // Eliminar la incidencia
        $incidencia->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada exitosamente');
    }
}