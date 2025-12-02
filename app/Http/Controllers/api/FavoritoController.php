<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorito;
use App\Services\FatSecretService;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    public function index(FatSecretService $fatSecret)
    {
        // Usa o relacionamento 'favoritos' do usuário logado via Token
        $favoritos = Auth::user()->favoritos()->orderBy('created_at', 'desc')->get();

        // Tradução automática (igual fizemos na Web)
        if ($favoritos->isNotEmpty()) {
            $nomes = $favoritos->pluck('name')->toArray();
            $nomesTraduzidos = $fatSecret->translateBatchWithGemini($nomes);

            foreach ($favoritos as $index => $fav) {
                if (isset($nomesTraduzidos[$index]) && $nomesTraduzidos[$index] !== $fav->name) {
                    $fav->name = $nomesTraduzidos[$index];
                    $fav->save();
                }
            }
        }

        return response()->json(['success' => true, 'data' => $favoritos]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required',
            'name' => 'nullable|string',
            'image' => 'nullable|string',
            'calories' => 'nullable',
        ]);

        $user = Auth::user();
        
        // Verifica se já existe (usando usuario_id conforme seu banco)
        $favorito = Favorito::where('usuario_id', $user->id)
                            ->where('recipe_id', $request->recipe_id)
                            ->first();

        if ($favorito) {
            $favorito->delete();
            return response()->json(['success' => true, 'status' => 'removed']);
        } else {
            Favorito::create([
                'usuario_id' => $user->id,
                'recipe_id' => $request->recipe_id,
                'name' => $request->name,
                'image' => $request->image,
                'calories' => (string)$request->calories,
            ]);
            return response()->json(['success' => true, 'status' => 'added']);
        }
    }
}