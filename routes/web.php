<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (acessíveis sem login)
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

// Rotas de receitas (públicas)
Route::get('/receitas', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/receitas/{id}', [RecipeController::class, 'show'])->name('recipes.show');

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
    // Rotas para usuários COMUNS
    Route::get('/geladeira', function () {
        return view('geladeira');
    })->name('geladeira');
    
    Route::get('/favoritos', function () {
        return view('favoritos');
    })->name('favoritos');
    
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

/*
|--------------------------------------------------------------------------
| Rotas de Componentes (se necessário para desenvolvimento)
|--------------------------------------------------------------------------
*/
Route::get('/footer', function () {
    return view('footer');
});

Route::get('/header', function () {
    return view('header');
});