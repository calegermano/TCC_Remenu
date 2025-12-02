<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // 1. Enviar link/token por email
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);

        if ($validator->fails()) {
            return response()->json(['message' => 'E-mail inválido'], 422);
        }

        // Envia o e-mail padrão do Laravel
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Link de redefinição enviado para o e-mail!']);
        }

        return response()->json(['message' => 'Não foi possível enviar o e-mail.'], 500);
    }

    // 2. Redefinir a senha (O App envia Email + Token + Nova Senha)
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'senha' => \Illuminate\Support\Facades\Hash::make($password) // Atenção se sua coluna é 'senha' ou 'password'
                ])->save();
                
                // Opcional: $user->setRememberToken(Str::random(60));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Senha redefinida com sucesso!']);
        }

        return response()->json(['message' => 'Token inválido ou expirado.'], 400);
    }
}