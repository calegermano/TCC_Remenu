<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\FavoritoController;
use App\Http\Controllers\Api\PlanejamentoController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\GeladeiraApiController;

// --- ROTAS PÚBLICAS ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

// A busca de ingredientes é pública (autocomplete)
// Note que usamos GeladeiraApiController
Route::get('/app/ingredientes/search', [GeladeiraApiController::class, 'search']);

// --- ROTAS PROTEGIDAS (Requer Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Receitas
    Route::get('/receitas', [RecipeController::class, 'index']); 
    Route::get('/receitas/destaques', [RecipeController::class, 'featured']);
    Route::get('/receitas/{id}', [RecipeController::class, 'show']);

    // Favoritos
    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos/toggle', [FavoritoController::class, 'toggle']);

    // Planejamento
    Route::get('/planejamento', [PlanejamentoController::class, 'index']);
    Route::post('/planejamento', [PlanejamentoController::class, 'store']);
    Route::delete('/planejamento/{id}', [PlanejamentoController::class, 'destroy']);

    // Geladeira
    Route::get('/teste-token', function (Illuminate\Http\Request $request) {
    return response()->json([
        'status' => 'sucesso', 
        'usuario' => $request->user()->id,
        'mensagem' => 'O token está funcionando!'
        ]);
    });
    Route::get('/app/geladeira', [GeladeiraApiController::class, 'index']);
    Route::post('/app/geladeira', [GeladeiraApiController::class, 'store']);
    Route::put('/app/geladeira/{id}', [GeladeiraApiController::class, 'update']);
    Route::delete('/app/geladeira/{id}', [GeladeiraApiController::class, 'destroy']);
});