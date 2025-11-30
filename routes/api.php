<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\PlanejamentoController;
use App\Http\Controllers\GeladeiraController;

/*
|--------------------------------------------------------------------------
| API Routes - Mobile
|--------------------------------------------------------------------------
*/

// Rotas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Receitas - Flexíveis (local ou fatsecret)
    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/{id}', [RecipeController::class, 'show']);
    Route::get('/recipes/search/{query}', [RecipeController::class, 'search']);
    Route::get('/recipes/local', [RecipeController::class, 'localRecipes']);
    Route::get('/recipes/fatsecret', [RecipeController::class, 'fatsecretRecipes']);

    // Favoritos
    Route::get('/favorites', [FavoritoController::class, 'index']);
    Route::post('/favorites/toggle', [FavoritoController::class, 'toggle']);
    
    // Planejamento
    Route::get('/meal-plans', [PlanejamentoController::class, 'index']);
    Route::post('/meal-plans', [PlanejamentoController::class, 'store']);
    Route::delete('/meal-plans/{id}', [PlanejamentoController::class, 'destroy']);

    // Geladeira
    Route::get('/pantry', [GeladeiraController::class, 'index']);
    Route::post('/pantry', [GeladeiraController::class, 'store']);
    Route::put('/pantry/{id}', [GeladeiraController::class, 'update']);
    Route::delete('/pantry/{id}', [GeladeiraController::class, 'destroy']);
    Route::get('/pantry/search', [GeladeiraController::class, 'search']);
});