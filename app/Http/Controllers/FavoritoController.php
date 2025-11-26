<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    // Listar Favoritos
    public function index()
    {
        // Aqui chamamos a função 'favoritos()' que vamos criar no Model Usuario
        $favoritos = Auth::user()->favoritos()->orderBy('created_at','desc')->get();
        return view('favorites.index', compact('favoritos'));
    }

    // Adicionar ou Remover
    public function toggle(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required',
            'name' => 'nullable|string',
            'image' => 'nullable|string',
            'calories' => 'nullable|string',
        ]);

        // 1. Pegamos o usuário logado
        $user = Auth::user(); 
        $recipeId = $request->recipe_id;

        // 2. CORREÇÃO: Usamos '$user->id' (a variável que definimos acima)
        // E assumindo que no banco a coluna se chama 'usuario_id'
        $favorito = Favorito::where('usuario_id', $user->id)
                            ->where('recipe_id', $recipeId)
                            ->first();

        if ($favorito) {
            $favorito->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favorito::create([
                'usuario_id' => $user->id, // CORREÇÃO: $user->id
                'recipe_id' => $recipeId,
                'name' => $request->name,
                'image' => $request->image,
                'calories' => $request->calories,
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}