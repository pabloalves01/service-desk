<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->get('products', [ProductController::class, 'index']);

Route::middleware('auth:api')->post('product/save', [ProductController::class, 'store']);

Route::middleware('auth:api')->get('product/{id}', [ProductController::class, 'getProduto']);

Route::middleware('auth:api')->put('product/{id}', [ProductController::class, 'update']);
Route::middleware('auth:api')->delete('product/{id}', [ProductController::class, 'destroy']);

Route::get('/test', function () {
    return response()->json(['message' => 'API Laravel funcionando!']);
});