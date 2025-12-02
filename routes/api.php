<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\FavoritoController;
use App\Http\Controllers\Api\PlanejamentoController; 
use App\Http\Controllers\GeladeiraController;
use App\Http\Controllers\Api\PasswordResetController;

// --- ROTAS PÚBLICAS ---
Route::post('/register', [AuthController::class, 'register']); // Adicionei registro
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

// --- ROTAS PROTEGIDAS (Requer Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']); // Para pegar dados do usuário logado
    
    // Receitas
    Route::get('/receitas', [RecipeController::class, 'index']); 
    Route::get('/receitas/destaques', [RecipeController::class, 'featured']); // Nova rota de destaques
    Route::get('/receitas/{id}', [RecipeController::class, 'show']);

    // Favoritos (API)
    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos/toggle', [FavoritoController::class, 'toggle']);

    // Planejamento (API)
    Route::get('/planejamento', [PlanejamentoController::class, 'index']);
    Route::post('/planejamento', [PlanejamentoController::class, 'store']);
    Route::delete('/planejamento/{id}', [PlanejamentoController::class, 'destroy']);

    // Geladeira (Reaproveitando o controller existente que já retorna JSON)
    Route::get('/geladeira', [GeladeiraController::class, 'index']);
    Route::post('/geladeira', [GeladeiraController::class, 'store']);
    Route::put('/geladeira/{id}', [GeladeiraController::class, 'update']);
    Route::delete('/geladeira/{id}', [GeladeiraController::class, 'destroy']);
    // Autocomplete da geladeira
    Route::get('/ingredientes/search', [GeladeiraController::class, 'search']);
});