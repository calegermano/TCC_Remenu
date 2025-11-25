<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FatSecretService;


class RecipeController extends Controller
{
    protected $fatSecret;

    public function __construct(FatSecretService $fatSecret)
    {
        $this->fatSecret = $fatSecret;
    }

    public function index(Request $request)
    {
        $rawSearch = $request->input('search');



        $filters = [
            'recipe_types' => $request->input('recipe_types', []),
            'calories_from' => $request->input('calories_from'),
            'calories_to' => $request->input('calories_to'),
            'prep_time_from' => $request->input('prep_time_from'),
            'prep_time_to' => $request->input('prep_time_to'),
        ];

        $hasFilters =
            !empty($filters['recipe_types']) ||
            !empty($filters['calories_from']) ||
            !empty($filters['calories_to']) ||
            !empty($filters['prep_time_from']) ||
            !empty($filters['prep_time_to']);

        if (($rawSearch === null || trim($rawSearch) === '') && !$hasFilters) {
            $search = 'a';   // usado apenas internamente
        } else {
            $search = $rawSearch; // usa o que o usuário digitou
        }

        $page = $request->input('page', 0);

        $recipesData = $this->fatSecret->getRecipes($search, $filters, $page);
        $recipes = $recipesData['recipe'] ?? [];
        $totalResults = $recipesData['total_results'] ?? 0;

        $availableFilters = [
            'Main Dish' => 'Prato Principal',
            'Breakfast' => 'Café da Manhã',
            'Salad' => 'Salada',
            'Soup' => 'Sopa',
            'Dessert' => 'Sobremesa',
            'Beverage' => 'Bebidas',
        ];

        if ($request->ajax()) {
            return view('partials.recipe_cards', compact('recipes'))->render();
        }

        return view('recipes.index', [
            'recipes' => $recipes,
            'totalResults' => $totalResults,
            'search' => $rawSearch,
            'filters' => $filters,
            'availableFilters' => $availableFilters,
        ]);
    }
    
    public function show($id)
    {
        $recipe = $this->fatSecret->getRecipeDetails($id);

        if (!$recipe) {
            return response()->json([
                'error' => true,
                'message' => 'Receita não encontrada ou erro na API'
            ], 404);
        }

        return response()->json(['recipe' => $recipe]);

    }

}