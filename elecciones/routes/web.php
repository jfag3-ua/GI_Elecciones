<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\CandidaturaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\ResultadosController;

Route::get('/resultados/{year?}', [ResultadosController::class, 'index'])->name('resultados');

// Rutas sin restricción de acceso
Route::get('/', [PaginaController::class, 'landing'])->name('landing');
Route::get('/inicio', [PaginaController::class, 'inicio'])->name('inicio');
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Procesar inicio de sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Cerrar sesión

Route::get('/registro', [PaginaController::class, 'registro'])->name('registro');
Route::post('/registro', [RegistroController::class, 'register'])->name('registro2');
Route::get('/registro', [RegistroController::class, 'showRegisterForm'])->name('registro2.form');

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
// Rutas protegidas
Route::get('/voto', [CandidaturaController::class, 'votar'])->name('voto');
Route::post('/guardar-voto', [CandidaturaController::class, 'guardarVoto'])->name('guardar.voto');
Route::get('/predicciones', [PaginaController::class, 'predicciones'])->name('predicciones');
Route::get('/administracion', [PaginaController::class, 'administracion'])->name('administracion');
//Route::get('/administracion', [PaginaController::class, 'administracion'])->name('administracion');
Route::get('/usuario', [PaginaController::class, 'usuario'])->middleware(\App\Http\Middleware\AuthenticatedUser::class)->name('usuario');


// Formulario de edición de candidatura
Route::get('/administracion/candidatura/editar/{id}', [CandidaturaController::class, 'editar'])->name('candidatura.editar');
// Actualizar candidatura
Route::post('/administracion/candidatura/editar/{id}', [CandidaturaController::class, 'actualizar'])->name('candidatura.actualizar');

// Mostrar formulario para añadir candidatura
Route::get('/administracion/candidatura/crear', [CandidaturaController::class, 'crear'])->name('candidatura.crear');
// Guardar candidatura
Route::post('/administracion/candidatura/crear', [CandidaturaController::class, 'guardar'])->name('candidatura.guardar');

// Borrar candidatura
Route::delete('administracion/candidatura/borrar/{id}', [CandidaturaController::class, 'eliminar'])->name('candidatura.eliminar');

// Rutas de candidato
Route::get('/administracion/candidato/editar/{id}', [CandidatoController::class, 'editar'])->name('candidato.editar');
Route::post('/administracion/candidato/actualizar/{id}', [CandidatoController::class, 'actualizar'])->name('candidato.actualizar');

// Mostrar formulario
Route::get('/administracion/candidato/crear', [CandidatoController::class, 'crear'])->name('candidato.crear');
// Guardar candidato
Route::post('/administracion/candidato/guardar', [CandidatoController::class, 'guardar'])->name('candidato.guardar');
Route::delete('/administracion/candidato/borrar/{id}', [CandidatoController::class, 'borrar'])->name('candidato.borrar');
