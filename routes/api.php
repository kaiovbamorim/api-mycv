<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\CurriculoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Autencicação
Route::prefix('/autenticacao')->group(function () {

    // POST'S
    Route::post('/login', [AutenticacaoController::class, 'Login']);
    Route::post('/registrar-usuario', [AutenticacaoController::class, 'RegistrarUsuario']);
});

// Curriculo
Route::prefix('/curriculo')->group(function () {

    // POST'S

    Route::post('/info-pessoais', [CurriculoController::class, 'CadastraInfoPessoais']);
    Route::post('/obj-profissional', [CurriculoController::class, 'CadastraObjetivoResumo']);
    Route::post('/habilidades', [CurriculoController::class, 'CadastraHabilidades']);
});
