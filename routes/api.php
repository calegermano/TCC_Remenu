<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GeladeiraController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');


use App\Http\Controllers\FatSecretController;

Route::get('/receitas', fn() => view('receitas'));
Route::get('/api/receitas/search', [FatSecretController::class, 'search']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ingredientes/search', [IngredienteController::class, 'search']);
    Route::get('/geladeira', [GeladeiraController::class, 'index']);
    Route::post('/geladeira', [GeladeiraController::class, 'store']);
    Route::put('/geladeira/{id}', [GeladeiraController::class, 'update']);
    Route::delete('/geladeira/{id}', [GeladeiraController::class, 'destroy']);
});