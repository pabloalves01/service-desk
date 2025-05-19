<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\corporacao\AniversariantesController;
use App\Http\Controllers\corporacao\SlideshowController;
use App\Http\Controllers\eventos\EventosController;
use App\Http\Controllers\WeatherController;

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
Route::get('/imagens/evento/{id}', [EventosController::class, 'imagensEvento']);

Route::get('/aniversariantes', [SlideshowController::class, 'getAniversariantes']);
Route::post('/aniversariante', [AniversariantesController::class, 'store']);
Route::get('/aniversariante', [AniversariantesController::class, 'index']);
Route::delete('/aniversariante/{id}', [AniversariantesController::class, 'destroy']);

Route::get('/weather/imbituba', [WeatherController::class, 'Imbituba']);
Route::get('/weather/rio-claro', [WeatherController::class, 'RioClaro']);
Route::get('/weather/guaira', [WeatherController::class, 'Guaira']);
Route::get('/weather/pien', [WeatherController::class, 'Pien']);

Route::get('/test', function () {
    return response()->json(['message' => 'API Laravel funcionando!']);
});
