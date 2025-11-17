<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use App\Models\TipoUsuario;

class AuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('login');
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

            if ($user->tipo->nome === 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/home');
            }
        }

        return back()->withErrors(['email' => 'Email ou senha inválidos']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome' =>  'required',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|confirmed',
        ]);

        // Definindo o tipo de usuário como COMUM por padrão
        $tipoUsuario = $request->input('tipo_id', TipoUsuario::COMUM);
        $tipoId = ($tipoUsuario === 'admin') ? TipoUsuario::ADMIN : TipoUsuaario::COMUM;

        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => bcrypt($request->senha),
            'tipo_id' => TipoUsuario::COMUM,
        ]);

        Auth::login($usuario);

        if ($tipoId === TipoUsuario::ADMIN) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/home');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
