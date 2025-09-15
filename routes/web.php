<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return "Página do usuário comum";
    });
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return "Página do administrador";
    });
});