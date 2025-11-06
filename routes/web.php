<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FatSecretController;

Route::get('/recipes', fn() => view('recipes'));
Route::get('/api/recipes/search', [FatSecretController::class, 'search']);

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

Route::get('/receitas', function () {
    return view('receitas');
});
Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware('auth', 'isAdmin');

Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [DashBoardController::class, 'index']);
});