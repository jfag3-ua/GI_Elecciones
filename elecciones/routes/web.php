<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\CandidaturaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\ResultadosController;
use App\Http\Controllers\EleccionController;

Route::get('/resultados/{year?}', [ResultadosController::class, 'index'])->name('resultados');

// Rutas sin restricción de acceso
Route::get('/', [PaginaController::class, 'landing'])->name('landing');

Route::post('/login', [AuthController::class, 'login'])->name('login'); // Procesar inicio de sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Cerrar sesión

Route::get('/registro', [PaginaController::class, 'registro'])->name('registro');
Route::post('/registro', [RegistroController::class, 'register'])->name('registro2');
Route::get('/registro', [RegistroController::class, 'showRegisterForm'])->name('registro2.form');

Route::get('/provincias', [CandidatoController::class, 'mostrarProvincias'])->name('provincias');
Route::get('/provincias/{provincia}/candidatos', [CandidatoController::class, 'candidatosPorProvincia'])->name('candidatos.porProvincia');


Route::get('/calendario', [EleccionController::class, 'mostrarCalendario']);
Route::resource('elecciones', EleccionController::class);
Route::get('/api/elecciones', [EleccionController::class, 'getEleccionesForDropdown'])->name('api.elecciones');
Route::get('/api/elecciones/{eleccion}/fechas', [EleccionController::class, 'getFechasEleccion'])->name('api.elecciones.fechas');

Route::get('/login', [PaginaController::class, 'inicio'])->name('login.form');
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        $dbName = DB::connection()->getDatabaseName();
        return "✅ Conectado a la base de datos: $dbName";
    } catch (\Exception $e) {
        return "❌ Error de conexión: " . $e->getMessage();
    }
});

Route::get('/inicio', [PaginaController::class, 'inicio'])->/*middleware('RedirectIfAuthenticatedCustom')->*/name('inicio');
Route::get('/predicciones', [PaginaController::class, 'predicciones'])->name('predicciones');

Route::middleware([\App\Http\Middleware\IsUser::class])->group(function () {
    Route::get('/voto', [CandidaturaController::class, 'votar'])->name('voto');
    Route::post('/guardar-voto', [CandidaturaController::class, 'guardarVoto'])->name('guardar.voto');
});

Route::get('/usuario', [PaginaController::class, 'usuario'])
    ->middleware(\App\Http\Middleware\IsAuthenticated::class)
    ->name('usuario');


Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
    Route::get('/administracion', [PaginaController::class, 'administracion'])->name('administracion');

    // Candidaturas
    Route::get('/administracion/candidatura/editar/{id}', [CandidaturaController::class, 'editar'])->name('candidatura.editar');
    Route::post('/administracion/candidatura/editar/{id}', [CandidaturaController::class, 'actualizar'])->name('candidatura.actualizar');
    Route::get('/administracion/candidatura/crear', [CandidaturaController::class, 'crear'])->name('candidatura.crear');
    Route::post('/administracion/candidatura/crear', [CandidaturaController::class, 'guardar'])->name('candidatura.guardar');
    Route::delete('administracion/candidatura/borrar/{id}', [CandidaturaController::class, 'eliminar'])->name('candidatura.eliminar');

    // Candidatos
    Route::get('/administracion/candidato/editar/{id}', [CandidatoController::class, 'editar'])->name('candidato.editar');
    Route::post('/administracion/candidato/actualizar/{id}', [CandidatoController::class, 'actualizar'])->name('candidato.actualizar');
    Route::get('/administracion/candidato/crear', [CandidatoController::class, 'crear'])->name('candidato.crear');
    Route::post('/administracion/candidato/guardar', [CandidatoController::class, 'guardar'])->name('candidato.guardar');
    Route::delete('/administracion/candidato/borrar/{id}', [CandidatoController::class, 'borrar'])->name('candidato.borrar');
});
