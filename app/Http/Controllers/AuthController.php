<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('cconta');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $user = Usuario::where('email', $request->email)->first();

        if ($user && Hash::check($request->senha, $user->senha)) {
            Auth::login($user);

            // DEBUG
            \Log::info('LOGIN - Usuário: ' . $user->email . ', Tipo ID: ' . $user->tipo_id . ', isAdmin: ' . ($user->isAdmin() ? 'SIM' : 'NÃO'));

            // Redirecionamento baseado no tipo de usuário
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/home2');
            }
        }

        return back()->withErrors(['email' => 'Email ou senha inválidos']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|confirmed',
        ]);

        // SEMPRE definir como usuário COMUM (tipo_id = 2)
        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'tipo_id' => 2, // SEMPRE COMUM
        ]);

        Auth::login($usuario);

        // DEBUG
        \Log::info('REGISTRO - Novo usuário: ' . $usuario->email . ', Tipo ID: ' . $usuario->tipo_id . ', isAdmin: ' . ($usuario->isAdmin() ? 'SIM' : 'NÃO'));

        // Redirecionamento após o registro
        if ($usuario->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        } else {
            return redirect()->intended('/home2');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}