<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\GeladeiraController;
use App\Http\Controllers\PlanejamentoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (acessíveis sem login) - SEM MIDDLEWARE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/senha', function () {
    return view('senha');
})->name('senha');

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
    // --- PÁGINAS PROTEGIDAS ---
    Route::get('/geladeira', function () {
        return view('geladeira');
    })->name('geladeira');
    
    Route::get('/home2', [RecipeController::class, 'home'])->name('home2');

    // Rotas de receitas
    Route::get('/receitas', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/receitas/{id}', [RecipeController::class, 'show'])->name('recipes.show');


    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos');

    Route::get('/planejamento', [PlanejamentoController::class, 'index'])->name('planejamento');
    Route::get('/planejamento/fetch', [PlanejamentoController::class, 'getPlans']);
    Route::post('/planejamento/store', [PlanejamentoController::class, 'store']);
    Route::delete('/planejamento/{id}', [PlanejamentoController::class, 'destroy']);

    // --- API DA GELADEIRA ---
    Route::prefix('api')->group(function () {
        Route::get('/ingredientes/search', [GeladeiraController::class, 'search']);
        Route::get('/geladeira', [GeladeiraController::class, 'index']);
        Route::post('/geladeira', [GeladeiraController::class, 'store']);
        Route::put('/geladeira/{id}', [GeladeiraController::class, 'update']);
        Route::delete('/geladeira/{id}', [GeladeiraController::class, 'destroy']);
    });
    
    // --- AÇÕES DE FAVORITOS ---
    Route::post('/favoritos/toggle', [FavoritoController::class, 'toggle'])->name('favorites.toggle');
    

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


Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    Auth::loginUsingId($request->user()->id);

    return redirect()->route('home2');
})->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {

    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Link reenviado!');
    
})->middleware('auth')->name('verification.send');

