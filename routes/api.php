<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// routes/api.php
use App\Http\Controllers\FatSecretController;

Route::get('/receitas', fn() => view('receitas'));
Route::get('/api/receitas/search', [FatSecretController::class, 'search']);