<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Importe o Model correto (Recipe ou Receita?)
use App\Models\Recipe; 
use App\Http\Resources\RecipeResource;

class RecipeController extends Controller
{
    // Listar todas
    public function index()
    {
        // Pega todas as receitas (pode usar paginação se tiver muitas: Recipe::paginate(10))
        $receitas = Recipe::all();
        
        // Retorna formatado
        return RecipeResource::collection($receitas);
    }

    // Mostrar uma específica
    public function show($id)
    {
        $receita = Recipe::find($id);

        if (!$receita) {
            return response()->json(['message' => 'Receita não encontrada'], 404);
        }

        return new RecipeResource($receita);
    }
}