<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    //Listar Favoritos
    public function index()
    {
        $favoritos = Auth::user()->favoritos()->orderBy('created_at','desc')->get();
        return view('favoritos.index', compact('favoritos'));
    }

    //Adicionar ou Remover
    public function toggle(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required',
            'name' => 'nullable|string',
            'image' => 'nullable|string',
            'calories' => 'nullable|string',
        ]);

        $user = Auth::user();
        $recipeId = $request->recipe_id;

        //Verifica se ja existe

        $favorito = Favorito::where('usuario_id', $usuario->id)
                            ->where('recipe_id', $recipeId)
                            ->first();

        if ($favorito) {
            //Se ja for favorito, desfavorita
            $favorito->delete();
            return response()->json([
                'status' => 'removed'
            ]);
        } else {
            //Se nao for, favorita
            Favorito::create([
                'usuario_id' => $usuario->id,
                'recipe_id' => $recipeId,
                'name' => $request-> name,
                'image' => $request-> image,
                'calories' => $request-> calories,
            ]);
            return response()->json([
                'status' => 'added'
            ]);
        }
    }
}
