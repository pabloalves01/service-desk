<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ClienteController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->post('cliente', [ClienteController::class, 'store']);
Route::middleware('auth:api')->get('cliente', [ClienteController::class, 'show']);
Route::middleware('auth:api')->delete('cliente/{id}', [ClienteController::class, 'destroy']);
Route::middleware('auth:api')->get('cliente/{id}', [ClienteController::class, 'getClient']);
Route::middleware('auth:api')->put('cliente/{id}', [ClienteController::class, 'update']);

Route::get('/test', function () {
    return response()->json(['message' => 'API Laravel funcionando!']);
});