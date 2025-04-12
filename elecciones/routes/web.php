<?php

use Illuminate\Support\Facades\Route; # Addition
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\CandidaturaController;

use App\Http\Controllers\ResultadosController;

Route::get('/resultados/{year?}', [ResultadosController::class, 'index'])->name('resultados');


// Rutas sin restricción de acceso
Route::get('/', [PaginaController::class, 'landing'])->name('landing');
Route::get('/inicio', [PaginaController::class, 'inicio'])->name('inicio'); // Mostrar formulario de login
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Procesar inicio de sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Cerrar sesión

Route::get('/registro', [PaginaController::class, 'registro'])->name('registro');
Route::post('/registro', [RegistroController::class, 'register'])->name('registro2');
Route::get('/registro', [RegistroController::class, 'showRegisterForm'])->name('registro2.form');



// Rutas protegidas con middleware 'auth' (NO FUNCIONA, HAY QUE REVISAR EL INICIO DE SESIÓN)
Route::get('/voto', [PaginaController::class, 'voto'])->name('voto');
Route::get('/predicciones', [PaginaController::class, 'predicciones'])->name('predicciones');
/*Route::get('/resultados', [PaginaController::class, 'resultados'])->name('resultados');*/
Route::get('/administracion', [PaginaController::class, 'administracion'])->name('administracion');
Route::get('/usuario', [PaginaController::class, 'usuario'])->name('usuario');

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



