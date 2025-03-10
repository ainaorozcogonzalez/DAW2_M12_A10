<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Rol;
use App\Models\Sede;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\EstadoIncidencia;
use App\Models\Prioridad;

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
        $clientes = User::whereHas('rol', function($query) {
            $query->where('nombre', 'cliente');
        })->get();

        $tecnicos = User::whereHas('rol', function($query) {
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
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ],
            'rol_id' => 'required|exists:roles,id',
            'sede_id' => 'required|exists:sedes,id',
            'estado' => 'required|in:activo,inactivo'
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'email.regex' => 'El formato del email no es válido.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'sede_id' => $request->sede_id,
            'estado' => $request->estado,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Usuario creado exitosamente');
    }

    public function index()
    {
        $users = User::with('rol', 'sede')->get();
        $roles = Rol::all();
        $sedes = Sede::all();
        return view('admin.users.index', compact('users', 'roles', 'sedes'));
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
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ],
            'rol_id' => 'required|exists:roles,id',
            'sede_id' => 'required|exists:sedes,id',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $user->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'rol_id' => $request->rol_id,
            'sede_id' => $request->sede_id,
            'estado' => $request->estado
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }
} 