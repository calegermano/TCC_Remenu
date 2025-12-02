<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FatSecretService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    protected $fatSecretService;

    public function __construct(FatSecretService $fatSecretService)
    {
        $this->fatSecretService = $fatSecretService;
    }

    public function index(Request $request)
    {
        try {
            $page = $request->get('page', 0);
            $search = $request->get('search', '');

            // Captura filtros vindos do React Native
            $filters = [
                'calories_from' => $request->get('calories_from'),
                'calories_to'   => $request->get('calories_to'),
                'prep_time_from'=> $request->get('prep_time_from'),
                'prep_time_to'  => $request->get('prep_time_to'),
                'recipe_types'  => $request->get('recipe_types', []), // Array de tipos
            ];
            
            // Chama o serviço (que já tem a tradução embutida)
            $recipesData = $this->fatSecretService->getRecipes($search, $filters, $page);
            
            // Normaliza a resposta para garantir que 'recipe' seja sempre array
            $recipesList = $recipesData['recipe'] ?? [];
            if (isset($recipesList['recipe_id'])) {
                $recipesList = [$recipesList];
            }

            return response()->json([
                'success' => true,
                'data' => $recipesList,
                'total_results' => $recipesData['total_results'] ?? 0,
                'page_number' => $recipesData['page_number'] ?? 0,
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao buscar receitas: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            // CORREÇÃO: O nome do método no Service é getRecipeDetails
            $recipe = $this->fatSecretService->getRecipeDetails($id);
            
            if (!$recipe) {
                return response()->json(['success' => false, 'message' => 'Receita não encontrada'], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $recipe
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro interno'], 500);
        }
    }

    public function featured()
    {
        // Busca receitas genéricas para a Home do App
        $termos = ['chicken', 'salad', 'pasta', 'healthy'];
        $termo = $termos[array_rand($termos)];
        
        $recipesData = $this->fatSecretService->getRecipes($termo, [], 0);
        $recipesList = $recipesData['recipe'] ?? [];

        if (isset($recipesList['recipe_id'])) $recipesList = [$recipesList];

        // Pega 5 aleatórias
        $destaques = collect($recipesList)->shuffle()->take(5)->values();

        return response()->json([
            'success' => true,
            'data' => $destaques
        ]);
    }
}