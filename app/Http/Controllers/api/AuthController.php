<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        // Busca o usuário pelo email
        $user = Usuario::where('email', $request->email)->first();

        // Verifica se o usuário existe e se a senha bate
        if (!$user || !Hash::check($request->senha, $user->senha)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        // Cria o Token (Isso é o que o App vai guardar na memória)
        $token = $user->createToken('mobile_app')->plainTextToken;

        return response()->json([
            'message' => 'Login realizado com sucesso',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
                'isAdmin' => $user->isAdmin(), // Se você tiver esse método no model
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // Apaga o token que estava sendo usado (desloga o app)
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}