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

    /**
     * Listar receitas da FatSecret
     */
    public function index(Request $request)
    {
        try {
            $page = $request->get('page', 0);
            $search = $request->get('search', '');
            
            $recipes = $this->fatSecretService->getRecipes($search, [], $page);
            
            return response()->json([
                'success' => true,
                'data' => $recipes['recipes'] ?? [],
                'total_results' => $recipes['total_results'] ?? 0,
                'page_number' => $recipes['page_number'] ?? 0,
                'has_more' => isset($recipes['page_number']) && $recipes['page_number'] < ceil($recipes['total_results'] / 50)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar receitas'
            ], 500);
        }
    }

    /**
     * Detalhes de uma receita específica
     */
    public function show($id)
    {
        try {
            $recipe = $this->fatSecretService->getRecipe($id);
            
            return response()->json([
                'success' => true,
                'data' => $recipe
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Receita não encontrada'
            ], 404);
        }
    }

    /**
     * Pesquisar receitas
     */
    public function search(Request $request, $query)
    {
        try {
            $page = $request->get('page', 0);
            
            $recipes = $this->fatSecretService->searchRecipes($query, $page);
            
            return response()->json([
                'success' => true,
                'data' => $recipes['recipes'] ?? [],
                'total_results' => $recipes['total_results'] ?? 0,
                'page_number' => $recipes['page_number'] ?? 0,
                'search_query' => $query,
                'has_more' => isset($recipes['page_number']) && $recipes['page_number'] < ceil($recipes['total_results'] / 50)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na pesquisa'
            ], 500);
        }
    }

    /**
     * Receitas em destaque (mais populares)
     */
    public function featured(Request $request)
    {
        try {
            $page = $request->get('page', 0);
            
            // Busca receitas populares
            $recipes = $this->fatSecretService->getRecipes('', ['sort_by' => 'rating'], $page);
            
            return response()->json([
                'success' => true,
                'data' => $recipes['recipes'] ?? [],
                'total_results' => $recipes['total_results'] ?? 0,
                'page_number' => $recipes['page_number'] ?? 0
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar receitas em destaque'
            ], 500);
        }
    }
}