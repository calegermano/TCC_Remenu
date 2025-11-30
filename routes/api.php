<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;

/*
|--------------------------------------------------------------------------
| API Routes - Mobile
|--------------------------------------------------------------------------
*/

// ROTAS PÚBLICAS
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// RECEITAS FATSECRET (Públicas - não precisam de autenticação)
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/featured', [RecipeController::class, 'featured']);
Route::get('/recipes/search/{query}', [RecipeController::class, 'search']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);

// ROTAS PROTEGIDAS (apenas para ações do usuário)
Route::middleware(['auth:sanctum'])->group(function () {
    
    // AUTENTICAÇÃO
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // FAVORITOS (próxima implementação)
    // Route::get('/favorites', [FavoritoController::class, 'index']);
    // Route::post('/favorites/{recipeId}', [FavoritoController::class, 'toggle']);
    
    // PLANEJAMENTO (próxima implementação)
    // Route::get('/meal-plans', [PlanejamentoController::class, 'index']);
    // Route::post('/meal-plans', [PlanejamentoController::class, 'store']);
    // Route::delete('/meal-plans/{id}', [PlanejamentoController::class, 'destroy']);
});