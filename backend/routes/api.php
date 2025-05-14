<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\eventos\EventosController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

// Eventos
Route::middleware('auth:api')->get('events', [EventosController::class, 'index']);
Route::middleware('auth:api')->post('events', [EventosController::class, 'store']);
Route::middleware('auth:api')->get('event/{id}', [EventosController::class, 'show']);

Route::post('/upload', [EventosController::class, 'uploadImage']);
Route::put('/imagens/aprovar/{id}', [EventosController::class, 'aprovar']);
Route::put('/imagens/rejeitar/{id}', [EventosController::class, 'rejeitar']);
Route::delete('/imagens/excluir/{id}', [EventosController::class, 'excluir']);

Route::get('/test', function () {
    return response()->json(['message' => 'API Laravel funcionando!']);
});
