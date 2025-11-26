<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\GeladeiraController; // <--- IMPORTANTE: Adicionado aqui
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (acessíveis sem login) - SEM MIDDLEWARE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home2', function () {
    return view('home2');
})->name('home2');

Route::get('/senha', function () {
    return view('senha');
})->name('senha');

// Rotas de receitas (públicas - apenas visualização)
Route::get('/receitas', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/receitas/{id}', [RecipeController::class, 'show'])->name('recipes.show');

// Rotas de componentes estáticos
Route::get('/footer', function () {
    return view('footer');
});

Route::get('/header', function () {
    return view('header');
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação
|--------------------------------------------------------------------------
*/
// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Registro
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas - Apenas usuários autenticados
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // --- PÁGINA DA GELADEIRA (View) ---
    Route::get('/geladeira', function () {
        return view('geladeira');
    })->name('geladeira');

    // --- API DA GELADEIRA (JSON para o JavaScript) ---
    // Estas rotas respondem às chamadas fetch('/api/...') do seu script
    Route::prefix('api')->group(function () {
        Route::get('/ingredientes/search', [GeladeiraController::class, 'search']); // Autocomplete
        Route::get('/geladeira', [GeladeiraController::class, 'index']);           // Listar itens
        Route::post('/geladeira', [GeladeiraController::class, 'store']);          // Adicionar
        Route::put('/geladeira/{id}', [GeladeiraController::class, 'update']);     // Editar
        Route::delete('/geladeira/{id}', [GeladeiraController::class, 'destroy']); // Excluir
    });
    
    // --- OUTRAS ROTAS PROTEGIDAS ---
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favorites.index');
    Route::post('/favoritos/toggle', [FavoritoController::class, 'toggle'])->name('favorites.toggle');
    
    Route::get('/planejamento', function () {
        return view('planejamento');
    })->name('planejamento');
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas - Apenas ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashBoardController::class, 'index'])->name('admin.dashboard');
});