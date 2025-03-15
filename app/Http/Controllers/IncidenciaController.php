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
use App\Models\Comentario;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $clientes = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'cliente');
        })->get();

        $tecnicos = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'tecnico');
        })->get();

        $sedes = Sede::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();

        return view('incidencias.create', compact(
            'clientes',
            'tecnicos',
            'sedes',
            'categorias',
            'subcategorias',
            'estados',
            'prioridades'
        ));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'cliente_id' => 'required|exists:users,id',
        //     'tecnico_id' => 'nullable|exists:users,id',
        //     'sede_id' => 'required|exists:sedes,id',
        //     'categoria_id' => 'required|exists:categorias,id',
        //     'subcategoria_id' => 'required|exists:subcategorias,id',
        //     'descripcion' => 'required|string|min:10|max:1000',
        //     'estado_id' => 'required|exists:estado_incidencias,id',
        //     'prioridad_id' => 'required|exists:prioridades,id'
        // ], [
        //     'cliente_id.required' => 'Seleccione un cliente',
        //     'sede_id.required' => 'Seleccione una sede',
        //     'categoria_id.required' => 'Seleccione una categoría',
        //     'subcategoria_id.required' => 'Seleccione una subcategoría',
        //     'descripcion.required' => 'La descripción es obligatoria',
        //     'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
        //     'descripcion.max' => 'La descripción no puede exceder los 1000 caracteres',
        //     'estado_id.required' => 'Seleccione un estado',
        //     'prioridad_id.required' => 'Seleccione una prioridad'
        // ]);


        try {
            Incidencia::create([
                'cliente_id' => $request->cliente_id,
                'tecnico_id' => $request->tecnico_id,
                'sede_id' => $request->sede_id,
                'categoria_id' => $request->categoria_id,
                'subcategoria_id' => $request->subcategoria_id,
                'descripcion' => $request->descripcion,
                'estado_id' => $request->estado_id,
                'prioridad_id' => $request->prioridad_id
            ]);

            echo "success Incidencia: " . $request->descripcion . " creada correctamente";
            die();
        } catch (\PDOException $e) {
            echo "error No se pudo crear la incidencia: " . $request->descripcion;
            die();
        }
        echo "error Intentelo mas tarde";
    }

    public function edit(Incidencia $incidencia)
    {
        return response()->json([
            'id' => $incidencia->id,
            'descripcion' => $incidencia->descripcion,
            'estado' => $incidencia->estado,
            'prioridad' => $incidencia->prioridad,
            'cliente_id' => $incidencia->cliente_id,
            'tecnico_id' => $incidencia->tecnico_id,
            'sede' => $incidencia->sede,
            'categoria' => $incidencia->categoria,
        ]);
    }

    public function index(Request $request)
    {
        // Obtener listas para los selectores del formulario
        $clientes = User::where('rol_id', 2)->get(); // Suponiendo que el rol 2 es para clientes
        $tecnicos = User::where('rol_id', 4)->get(); // Suponiendo que el rol 4 es para técnicos
        $sedes = Sede::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();

        // Construir la consulta base
        $query = Incidencia::with(['cliente', 'tecnico', 'estado', 'prioridad']);

        // Aplicar filtros si están presentes en la solicitud
        if ($request->has('estado_id') && $request->estado_id) {
            $query->where('estado_id', $request->estado_id);
        }

        if ($request->has('prioridad_id') && $request->prioridad_id) {
            $query->where('prioridad_id', $request->prioridad_id);
        }

        if ($request->has('cliente_id') && $request->cliente_id) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->has('tecnico_id') && $request->tecnico_id) {
            $query->where('tecnico_id', $request->tecnico_id);
        }

        if ($request->has('sede_id') && $request->sede_id) {
            $query->where('sede_id', $request->sede_id);
        }

        if ($request->has('categoria_id') && $request->categoria_id) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->has('subcategoria_id') && $request->subcategoria_id) {
            $query->where('subcategoria_id', $request->subcategoria_id);
        }

        // Excluir incidencias cerradas si el filtro está activo
        if ($request->has('excluir_cerradas') && $request->excluir_cerradas) {
            $estadoCerrada = EstadoIncidencia::where('nombre', 'Cerrada')->first();
            if ($estadoCerrada) {
                $query->where('estado_id', '!=', $estadoCerrada->id);
            }
        }

        // Obtener las incidencias filtradas
        $incidencias = $query->get();

        // Pasar los datos a la vista
        return view('admin.incidencias.index', compact(
            'incidencias',
            'clientes',
            'tecnicos',
            'sedes',
            'categorias',
            'subcategorias',
            'estados',
            'prioridades'
        ));
    }

    public function destroy(Incidencia $incidencia)
    {
        DB::beginTransaction();
        try {
            Comentario::where('incidencia_id', $incidencia->id)->delete();
            $incidencia->delete();
            DB::commit();
            echo "success incidencia #" . $incidencia->id . " eliminada correctamente";
            die();
        } catch (\PDOException $e) {
            DB::rollback();
            echo "error no se ha podido borrar la incidencia #" . $incidencia->id;
            // echo $e;
            die();
        }
    }

    public function datosincidencias(Request $request)
    {
        $clientes = User::where('rol_id', 2)->get();
        $tecnicos = User::where('rol_id', 4)->get();
        $sedes = Sede::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();

        // Construir la consulta base
        $query = Incidencia::with(['cliente', 'tecnico', 'estado', 'prioridad']);

        // Aplicar filtros si están presentes en la solicitud
        if ($request->has('estado_id') && $request->estado_id) {
            $query->where('estado_id', $request->estado_id);
        }

        if ($request->has('prioridad_id') && $request->prioridad_id) {
            $query->where('prioridad_id', $request->prioridad_id);
        }

        if ($request->has('cliente_id') && $request->cliente_id) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->has('tecnico_id') && $request->tecnico_id) {
            $query->where('tecnico_id', $request->tecnico_id);
        }

        if ($request->has('sede_id') && $request->sede_id) {
            $query->where('sede_id', $request->sede_id);
        }

        if ($request->has('categoria_id') && $request->categoria_id) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->has('subcategoria_id') && $request->subcategoria_id) {
            $query->where('subcategoria_id', $request->subcategoria_id);
        }

        // Obtener las incidencias filtradas
        $incidencias = $query->get();

        return response()->json([
            'incidencias' => $incidencias,
            'clientes' => $clientes,
            'tecnicos' => $tecnicos,
            'sedes' => $sedes,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'estados' => $estados,
            'prioridades' => $prioridades,
        ]);
    }

    public function indexCliente()
    {
        $prioridades = Prioridad::all();
        $estados = EstadoIncidencia::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $sedes = Sede::all();

        // Obtener las incidencias filtradas
        $incidencias = Incidencia::where('cliente_id', auth()->id())
            ->when(request('estado_id'), function ($query, $estado_id) {
                return $query->where('estado_id', $estado_id);
            })
            ->when(request('excluir_cerradas'), function ($query) {
                $estadoCerrada = EstadoIncidencia::where('nombre', 'Cerrada')->first();
                if ($estadoCerrada) {
                    return $query->where('estado_id', '!=', $estadoCerrada->id);
                }
            })
            ->when(request('sort') == 'fecha_creacion', function ($query) {
                return $query->orderBy('fecha_creacion', request('direction', 'asc'));
            })
            ->get();

        // Contadores de incidencias
        $contadorTotal = Incidencia::where('cliente_id', auth()->id())->count(); // Total de incidencias
        $contadorCerradas = Incidencia::where('cliente_id', auth()->id())
            ->whereHas('estado', function ($query) {
                $query->where('nombre', 'Cerrada');
            })
            ->count();
        $contadorPendientes = $contadorTotal - $contadorCerradas; // Incidencias pendientes

        return view('cliente.dashboard', compact(
            'estados',
            'incidencias',
            'prioridades',
            'categorias',
            'subcategorias',
            'contadorTotal',
            'contadorCerradas',
            'contadorPendientes'
        ));
    }

    public function cerrar(Incidencia $incidencia)
    {
        try {
            // Verificar si el estado "Cerrada" existe
            $estadoCerrada = EstadoIncidencia::where('nombre', 'Cerrada')->first();

            if (!$estadoCerrada) {
                return response()->json([
                    'success' => false,
                    'message' => 'El estado "Cerrada" no existe en la base de datos'
                ], 404);
            }

            // Actualizar el estado de la incidencia
            $incidencia->estado_id = $estadoCerrada->id;
            $incidencia->save();

            return response()->json([
                'success' => true,
                'message' => 'Incidencia cerrada correctamente'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al cerrar la incidencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar la incidencia: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        // Verificar que los datos requeridos están presentes
        // if (!$request->has('rol_id') || !$request->has('sede_id')) {
        //     return back()->withErrors(['error' => 'Faltan campos requeridos']);
        // }

        // $request->validate([
        //     'nombre' => [
        //         'required',
        //         'string',
        //         'max:255',
        //         'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
        //     ],
        //     'email' => [
        //         'required',
        //         'string',
        //         'email',
        //         'max:255',
        //         'unique:users,email,' . $user->id,
        //         'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0.9.-]+\.[a-zA-Z]{2,}$/'
        //     ],
        //     'password' => [
        //         'nullable',
        //         'string',
        //         'min:8',
        //         'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
        //     ],
        //     'rol_id' => 'required|exists:roles,id',
        //     'sede_id' => 'required|exists:sedes,id',
        //     'estado' => 'required|in:activo,inactivo'
        // ]);


        try {
            $user = Incidencia::find($request->incidencia_id);
            $updateData = [
                'cliente_id' => $request->cliente_id,
                'tecnico_id' => $request->tecnico_id,
                'sede_id' => $request->sede_id,
                'categoria_id' => $request->categoria_id,
                'subcategoria_id' => $request->subcategoria_id,
                'descripcion' => $request->descripcion,
                'estado_id' => $request->estado_id,
                'prioridad_id' => $request->prioridad_id
            ];
            if ($request->password) {
                $updateData['password'] = bcrypt($request->password);
            }
            $user->update($updateData);
            echo "success Incidencia #" . $request->incidencia_id . " editada correctamente";
            die();
        } catch (\PDOException $e) {
            echo "error No se pudo editar la incidencia: " . $request->nombre;
            // echo  $e;
            die();
        }
        echo "Invalido Intentelo mas tarde";
        // return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }
}
