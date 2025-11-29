<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- IMPORTANTE: Note que agora estamos chamando a pasta "Api" ---
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;

// Se você ainda NÃO criou esses controllers na pasta API, mantenha eles comentados 
// ou o Laravel vai dar erro ao tentar rodar.
// use App\Http\Controllers\Api\FavoritoController; 
// use App\Http\Controllers\Api\GeladeiraController;
// use App\Http\Controllers\Api\PlanejamentoController;


/*
|--------------------------------------------------------------------------
| Rotas Públicas (Não precisa de Token)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']); // Fazer depois

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Precisa estar logado no App)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Retorna dados do usuário logado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- RECEITAS (Usando o novo Controller da API) ---
    Route::get('/receitas', [RecipeController::class, 'index']);
    Route::get('/receitas/{id}', [RecipeController::class, 'show']);

    // --- OUTROS (Descomente conforme você for criando os Controllers na pasta Api) ---
    
    // Route::get('/favoritos', [FavoritoController::class, 'index']);
    // Route::post('/favoritos/toggle', [FavoritoController::class, 'toggle']);

    // Route::apiResource('geladeira', GeladeiraController::class);
    
    // Route::get('/planejamento', [PlanejamentoController::class, 'getPlans']); 
});