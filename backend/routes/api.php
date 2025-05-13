<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\eventos\EventosController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('events', [EventosController::class, 'index']);
Route::middleware('auth:api')->post('events', [EventosController::class, 'store']);

Route::get('/test', function () {
    return response()->json(['message' => 'API Laravel funcionando!']);
});