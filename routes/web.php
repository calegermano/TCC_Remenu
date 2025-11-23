<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (acessíveis sem login) - SEM MIDDLEWARE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home', function () {
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
| Rotas de Interação - COM MIDDLEWARE DE REDIRECIONAMENTO
|--------------------------------------------------------------------------
*/
Route::middleware(['redirect.unauthenticated'])->group(function () {
    // Ações de favoritos
    Route::post('/receitas/{id}/favoritar', [RecipeController::class, 'favoritar'])->name('recipes.favorite');
    Route::delete('/receitas/{id}/desfavoritar', [RecipeController::class, 'desfavoritar'])->name('recipes.unfavorite');
    
    // Ações de avaliação
    Route::post('/receitas/{id}/avaliar', [RecipeController::class, 'avaliar'])->name('recipes.rate');
    Route::post('/receitas/{id}/comentar', [RecipeController::class, 'comentar'])->name('recipes.comment');
    
    // Salvar receitas pessoais
    Route::post('/minhas-receitas', [RecipeController::class, 'salvarReceita'])->name('recipes.save');
    Route::delete('/minhas-receitas/{id}', [RecipeController::class, 'excluirReceita'])->name('recipes.delete');
    
    // Planejamento de refeições
    Route::post('/receitas/{id}/planejar', [RecipeController::class, 'adicionarPlanejamento'])->name('recipes.plan');
    Route::delete('/planejamento/{id}', [RecipeController::class, 'removerPlanejamento'])->name('planning.remove');
    
    // Adicionar à geladeira/lista de compras
    Route::post('/receitas/{id}/adicionar-ingredientes', [RecipeController::class, 'adicionarIngredientes'])->name('recipes.add_ingredients');
    
    // Buscas e filtros (POST) - se você tiver versões POST dessas funcionalidades
    Route::post('/receitas/buscar', [RecipeController::class, 'buscarAvancado'])->name('recipes.search.advanced');
    Route::post('/receitas/filtrar', [RecipeController::class, 'filtrarAvancado'])->name('recipes.filter.advanced');
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas - Apenas usuários autenticados
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Páginas que requerem autenticação
    Route::get('/geladeira', function () {
        return view('geladeira');
    })->name('geladeira');
    
    Route::get('/favoritos', function () {
        return view('favoritos');
    })->name('favoritos');
    
    Route::get('/planejamento', function () {
        return view('planejamento');
    })->name('planejamento');
    
    Route::get('/minhas-receitas', function () {
        return view('minhas-receitas');
    })->name('my.recipes');
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