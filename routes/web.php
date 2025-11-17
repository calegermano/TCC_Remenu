<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RecipeController;

Route::get('/receitas', [RecipeController::class, 'index'])->name('recipes.index');

Route::get('/receitas/{id}', [RecipeController::class, 'show']);


Route::get('/', function () {
    return view('home');
});

Route::get('/footer', function () {
    return view('footer');
});

Route::get('/header', function () {
    return view('header');
});

Route::get('/home2', function () {
    return view('home2');
});

Route::get('/conta', function () {
    return view('cconta');
});

Route::get('/senha', function () {
    return view('senha');
});

Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware('auth');


// Rota /dashboard protegida com 'auth' e 'isAdmin'
Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware('auth', 'isAdmin');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

// Grupo de rotas /admin/dashboard também protegido
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [DashBoardController::class, 'index']);
});
