<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\ClientIncidenciaController;
use App\Models\EstadoIncidencia;
use App\Models\Incidencia;
use App\Models\Prioridad;
use App\Models\Sede;
use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Http\Controllers\GestorEquiposController;
use App\Http\Controllers\TecnicoController;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Response;

// Redirigir la ruta raíz al login
Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/admin/dashboard', [UserController::class, 'create'])->name('admin.dashboard');

    // User routes
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/admincrearusuario', [UserController::class, 'store']);
        Route::post('/{user}/edit', [UserController::class, 'edit']);
        Route::put('/editar', [UserController::class, 'update']);
        Route::delete('/eliminaruario', [UserController::class, 'destroy']);
        Route::post('/datosusuarios', [UserController::class, 'datosusuarios']);
    });

    // Incidencia routes
    Route::prefix('incidencias')->group(function () {
        Route::get('/', [IncidenciaController::class, 'index'])->name('incidencias.index');
        Route::get('/create', [IncidenciaController::class, 'create'])->name('incidencias.create');
        Route::post('/admincrearincidencia', [IncidenciaController::class, 'store']);
        Route::post('/{incidencia}/edit', [IncidenciaController::class, 'edit']);
        Route::put('/{incidencia}', [IncidenciaController::class, 'update'])->name('incidencias.update');
        Route::delete('/{incidencia}', [IncidenciaController::class, 'destroy'])->name('incidencias.destroy');
        Route::post('/{incidencia}/cerrar', [IncidenciaController::class, 'cerrar'])->name('incidencias.cerrar');
        Route::post('/datosincidencias', [IncidenciaController::class, 'datosincidencias']);
    });

    // Report routes
    Route::prefix('reportes')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
    });

    // Configuration routes
    Route::prefix('configuracion')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    });

    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');

    Route::get('/tecnico/dashboard', [TecnicoController::class, 'dashboard'])->name('tecnico.dashboard');
    Route::post('/incidencias/{incidencia}/cambiar-estado', [TecnicoController::class, 'cambiarEstado'])->name('incidencias.cambiar-estado');
    Route::post('/incidencias/{incidencia}/comentar', [TecnicoController::class, 'enviarComentario'])->name('incidencias.comentar');

    // Categoría routes
    Route::prefix('categorias')->group(function () {
        // Route::post('/admincrearcategoria', [CategoriaController::class, 'store'])->name('categorias.store');
        Route::post('/admincrearcategoria', [CategoriaController::class, 'store']);
    });

    // Subcategoría routes
    Route::prefix('subcategorias')->group(function () {
        Route::post('/admincrearsubcategoria', [SubcategoriaController::class, 'store']);
        // Route::post('/', [SubcategoriaController::class, 'store'])->name('subcategorias.store');
    });

    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');

    // Gestor

    Route::controller(GestorEquiposController::class)->group(function () {
        Route::get('/manager/dashboard', 'vistagestor')->name('manager.dashboard');
        Route::post('/datosincidencias', 'datosincidencias');
        Route::post('/editarassignar', 'editarassignar');
        Route::post('/editarprioridad', 'editarprioridad');
    });

    Route::get('/incidencias/{incidencia}/mensajes', [TecnicoController::class, 'obtenerMensajes'])->name('incidencias.mensajes');
    Route::post('/incidencias/mensajes', [TecnicoController::class, 'enviarMensaje'])->name('incidencias.enviar-mensaje');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('storage/archivos/{filename}', function ($filename) {
    $path = storage_path('app/public/archivos/' . $filename);

    if (!file_exists($path)) {
        abort(404, 'Archivo no encontrado: ' . $path);
    }

    $file = file_get_contents($path);
    $type = mime_content_type($path);

    return Response::make($file, 200, [
        'Content-Type' => $type,
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
    ]);
})->name('archivos.serve');
Route::resource('users', UserController::class);

Route::prefix('client')->middleware('auth')->group(function() {
    // Route::get('/dashboard', [ClientIncidenciaController::class, 'index'])->name('client.dashboard');
    Route::post('/dashboard', [ClientIncidenciaController::class, 'indexCliente'])->name('client.dashboard');

    Route::post('/dashboard/filtrar', [ClientIncidenciaController::class, 'index'])->name('client.dashboard.filtrar');
    Route::post('/incidencias', [ClientIncidenciaController::class, 'store'])->name('client.incidencias.store');
});

Route::get('/subcategorias/{categoria_id}', function ($categoria_id) {
    $subcategorias = Subcategoria::where('categoria_id', $categoria_id)->get();
    return response()->json($subcategorias);
});

Route::get('/cliente/dashboard', [ClientIncidenciaController::class, 'indexCliente'])->name('client.dashboard');
