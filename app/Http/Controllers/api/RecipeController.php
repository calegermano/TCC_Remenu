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
            
            // FUNÇÃO DE LIMPEZA:
            // Transforma "20" em 20, e "" em null.
            $clean = function($val) {
                return ($val === '' || $val === null) ? null : $val;
            };

            // AQUI ESTÁ A CORREÇÃO DO FILTRO:
            // Mapeamos o que vem do celular (min_time) para o que o Service entende (prep_time_from)
            $filters = [
                'recipe_types'   => $request->get('types'),
                
                // Calorias
                'calories_from'  => $clean($request->get('min_cal')),
                'calories_to'    => $clean($request->get('max_cal')),
                
                // Tempo (Onde estava o erro provável)
                'prep_time_from' => $clean($request->get('min_time')), // Mobile manda 'min_time'
                'prep_time_to'   => $clean($request->get('max_time')), // Mobile manda 'max_time'
            ];

            // Chama o serviço
            $result = $this->fatSecretService->getRecipes($search, $filters, $page);
            
            $recipes = $result['recipe'] ?? [];
            
            // Normaliza se vier apenas 1 item
            if (isset($recipes['recipe_id'])) {
                $recipes = [$recipes];
            }

            return response()->json([
                'success' => true,
                'data' => $recipes,
                'total_results' => $result['total_results'] ?? 0,
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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