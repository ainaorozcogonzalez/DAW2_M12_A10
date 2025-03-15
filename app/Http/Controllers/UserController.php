<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Rol;
use App\Models\Sede;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\EstadoIncidencia;
use App\Models\Prioridad;
use App\Models\Incidencia;
use App\Models\Comentario;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $roles = Rol::all();
        $sedes = Sede::all();

        // Datos para incidencias
        $clientes = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'cliente');
        })->get();

        $tecnicos = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'tecnico');
        })->get();

        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();

        return view('admin.dashboard', compact(
            'roles',
            'sedes',
            'clientes',
            'tecnicos',
            'categorias',
            'subcategorias',
            'estados',
            'prioridades'
        ));
    }

    public function store(Request $request)
    {
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
        //         'unique:users',
        //         'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
        //     ],
        //     'password' => [
        //         'required',
        //         'string',
        //         'min:8',
        //         'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
        //     ],
        //     'rol_id' => 'required|exists:roles,id',
        //     'sede_id' => 'required|exists:sedes,id',
        //     'estado' => 'required|in:activo,inactivo'
        // ], [
        //     'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
        //     'email.regex' => 'El formato del email no es válido.',
        //     'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.'
        // ]);
        try {
            User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol_id' => $request->rol_id,
                'sede_id' => $request->sede_id,
                'estado' => $request->estado,
            ]);

            echo "success " . $request->nombre . " creado correctamente";
            die();
        } catch (\PDOException $e) {
            echo "error No se pudo crear a: " . $request->nombre;
            die();
        }
        echo "Invalido Intentelo mas tarde";
    }

    public function index(Request $request)
    {
        // Obtener listas para los selectores del formulario
        $roles = Rol::all();
        $sedes = Sede::all();
        $estados = ['activo', 'inactivo'];

        // Construir la consulta base
        $query = User::with(['rol', 'sede']);

        // Aplicar filtros si están presentes en la solicitud
        if ($request->has('rol_id') && $request->rol_id) {
            $query->where('rol_id', $request->rol_id);
        }

        if ($request->has('sede_id') && $request->sede_id) {
            $query->where('sede_id', $request->sede_id);
        }

        if ($request->has('estado') && $request->estado) {
            $query->where('estado', $request->estado);
        }

        // Obtener los usuarios filtrados
        $users = $query->get();

        // Pasar los datos a la vista
        return view('admin.users.index', compact(
            'users',
            'roles',
            'sedes',
            'estados'
        ));
    }

    public function datosusuarios(Request $request)
    {
        $nombre = Auth::user()->nombre;
        $estadosincidenas = EstadoIncidencia::all();
        $roles = Rol::all();
        $sedes = Sede::all();
        $clientes = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'tecnico');
        })->get();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $estados = ['Activo', 'Inactivo'];

        $prioridad = Prioridad::all();
        $totalusers = User::count();
        $totalincidencias = Incidencia::count();

        // Construir la consulta base
        $query = User::with(['rol', 'sede']);

        // Aplicar filtros si están presentes en la solicitud
        if ($request->has('rol_id') && $request->rol_id) {
            $query->where('rol_id', $request->rol_id);
        }

        if ($request->has('sede_id') && $request->sede_id) {
            $query->where('sede_id', $request->sede_id);
        }

        if ($request->has('estado') && $request->estado) {
            $query->where('estado', $request->estado);
        }

        // Obtener los usuarios filtrados
        $users = $query->get();

        $roles = Rol::all();;
        return response()->json([
            'roles' => $roles,
            'sedes' => $sedes,
            'estados' => $estados,
            'users' => $users,
            'nombre' => $nombre,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'clientes' => $clientes,
            'estadosincidenas' => $estadosincidenas,
            'totalusers' => $totalusers,
            'totalincidencias' => $totalincidencias,
            'prioridad' => $prioridad
        ]);
    }


    public function edit(User $user)
    {
        return response()->json([
            'id' => $user->id,
            'nombre' => $user->nombre,
            'email' => $user->email,
            'rol_id' => $user->rol_id,
            'sede_id' => $user->sede_id,
            'estado' => $user->estado
        ]);
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
            $user = User::find($request->user_id);
            $updateData = [
                'nombre' => $request->nombre,
                'email' => $request->email,
                'rol_id' => $request->rol_id,
                'sede_id' => $request->sede_id,
                'estado' => $request->estado
            ];
            if ($request->password) {
                $updateData['password'] = bcrypt($request->password);
            }
            $user->update($updateData);
            echo "success " . $request->nombre . " editado correctamente";
            die();
        } catch (\PDOException $e) {
            echo "error No se pudo editar a: " . $request->nombre;
            // echo  $e;
            die();
        }
        echo "Invalido Intentelo mas tarde";
        // return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $usuario)
    {
        DB::beginTransaction();
        try {
            $incidencias = Incidencia::where('cliente_id', $usuario->id)
                ->orWhere('tecnico_id', $usuario->id)
                ->get();

            if ($incidencias->isNotEmpty()) {
                foreach ($incidencias as $incidencia) {
                    // Eliminar los comentarios asociados a cada incidencia y luego la incidencia
                    Comentario::where('incidencia_id', $incidencia->id)->delete();
                    $incidencia->delete();
                }
            }

            $usuario->delete();
            DB::commit();
            echo "success Usuario eliminado correctamente";
            die();
        } catch (\PDOException $e) {
            DB::rollback();
            echo "error Intentelo más tarde";
            // echo "error " . $e;
            die();
        }
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
