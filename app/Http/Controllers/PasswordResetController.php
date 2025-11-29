<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    // 1. Enviar o link por e-mail
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Envia o link usando as configurações do auth.php
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => 'Link de redefinição enviado para o seu e-mail!']);
        }

        return back()->withErrors(['email' => 'Não conseguimos encontrar um usuário com esse endereço de e-mail.']);
    }

    // 2. Mostrar o formulário de reset (ao clicar no email)
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // 3. Processar a troca de senha
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
            'required',
            'confirmed',
            'min:8',             // Mínimo de 8 caracteres
            'regex:/[a-z]/',     // Pelo menos uma letra minúscula
            'regex:/[A-Z]/',     // Pelo menos uma letra maiúscula
            'regex:/[0-9]/',     // Pelo menos um número
        ],
        ], [
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não conferem.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.regex' => 'A senha deve conter letras maiúsculas, minúsculas e números.',

        ]);


        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Força a atualização da coluna 'senha'
                $user->forceFill([
                    'senha' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login.form')->with('status', 'Sua senha foi redefinida com sucesso!');
        }

        return back()->withErrors(['email' => 'O token é inválido ou expirou.']);
    }
}