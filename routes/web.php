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
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Incidencia routes
    Route::prefix('incidencias')->group(function () {
        Route::get('/', [IncidenciaController::class, 'index'])->name('incidencias.index');
        Route::get('/create', [IncidenciaController::class, 'create'])->name('incidencias.create');
        Route::post('/', [IncidenciaController::class, 'store'])->name('incidencias.store');
        Route::get('/{incidencia}/edit', [IncidenciaController::class, 'edit'])->name('incidencias.edit');
        Route::put('/{incidencia}', [IncidenciaController::class, 'update'])->name('incidencias.update');
        Route::delete('/{incidencia}', [IncidenciaController::class, 'destroy'])->name('incidencias.destroy');
        Route::post('/{incidencia}/cerrar', [IncidenciaController::class, 'cerrar'])->name('incidencias.cerrar');
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

    Route::get('/tech/dashboard', function () {
        return view('tech.dashboard');
    })->name('tech.dashboard');

    // Categoría routes
    Route::prefix('categorias')->group(function () {
        Route::post('/', [CategoriaController::class, 'store'])->name('categorias.store');
    });

    // Subcategoría routes
    Route::prefix('subcategorias')->group(function () {
        Route::post('/', [SubcategoriaController::class, 'store'])->name('subcategorias.store');
    });

    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');
});

Route::resource('users', UserController::class);

Route::prefix('client')->middleware('auth')->group(function() {
    Route::get('/dashboard', [ClientIncidenciaController::class, 'index'])->name('client.dashboard');
    Route::post('/incidencias', [ClientIncidenciaController::class, 'store'])->name('incidencias.store');
});

Route::get('/subcategorias/{categoria_id}', function ($categoria_id) {
    $subcategorias = Subcategoria::where('categoria_id', $categoria_id)->get();
    return response()->json($subcategorias);
});

Route::get('/cliente/dashboard', [IncidenciaController::class, 'indexCliente'])->name('client.dashboard');
