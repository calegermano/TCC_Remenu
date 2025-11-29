<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

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

            \Log::info('LOGIN - Usuário: ' . $user->email . ', Tipo ID: ' . $user->tipo_id);

            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/home2');
            }
        }

        return back()->withErrors(['email' => 'Email ou senha inválidos']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => [
            'required',
            'confirmed',
            'min:8',             // Mínimo de 8 caracteres
            'regex:/[a-z]/',     // Pelo menos uma letra minúscula
            'regex:/[A-Z]/',     // Pelo menos uma letra maiúscula
            'regex:/[0-9]/',     // Pelo menos um número
        ],
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Por favor, digite um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado em nosso sistema.',
            'senha.required' => 'A senha é obrigatória.',
            'senha.confirmed' => 'A confirmação de senha não confere.',
            'senha.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'senha.regex' => 'A senha deve conter letras maiúsculas, minúsculas e números.',
            ]);

        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'tipo_id' => 2,
        ]);

        Auth::login($usuario);

        $usuario->sendEmailVerificationNotification();

        return redirect()->route('register.form') 
           ->with('verify_email', true)
           ->with('email_registered', $usuario->email);
    }
}