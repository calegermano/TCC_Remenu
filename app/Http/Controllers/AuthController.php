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

    public function login(Request $request)
    {
        $request->validade([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Usuario::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->senha)) {
            Auth::login($user);

            if ($user->tipo->nome === 'admin') {
                return redirect('/admin/dashbord');
            } else {
                return redirect('/home');
            }
        }

        return back()->withErrors(['email' => 'Email ou senha inválidos']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
