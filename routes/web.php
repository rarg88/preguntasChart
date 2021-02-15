<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\RespuestasController;
use App\Http\Controllers\SedesController;
use App\Models\Pregunta;
use App\Models\Sede;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $preguntas = Pregunta::all();
    $sedes = Sede::all();
    return view('welcome', compact('preguntas','sedes'));
})->name('home');

//Preguntas
Route::get('preguntas/create', [PreguntasController::class, 'create'])->name('createPregunta');
Route::post('preguntas/store', [PreguntasController::class, 'store']);
Route::get('/preguntas/{id}', [PreguntasController::class, 'show'])->name('showPregunta');
Route::put('/preguntas/{id}', [PreguntasController::class, 'update']);
Route::delete('/preguntas/{id}', [PreguntasController::class, 'destroy']);
//Respuestas
Route::put('/respuestas', [RespuestasController::class, 'update']);
//Sedes
Route::get('/sedes', [SedesController::class, 'index'])->name('indexSedes');
Route::get('sedes/create', [SedesController::class, 'create'])->name('createSede');
Route::post('sedes/store', [SedesController::class, 'store']);
Route::put('/sedes/{id}', [SedesController::class, 'update']);
Route::delete('/sedes/{id}', [SedesController::class, 'destroy']);
