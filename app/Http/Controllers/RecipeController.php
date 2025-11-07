<?php

namespace App\Http\Controllers;

use App\Services\FatSecretService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    protected $fatSecret;

    public function __construct(FatSecretService $fatSecret)
    {
        $this->fatSecret = $fatSecret;
    }

    public function index(Request $request)
    {
        $search = $request->get('search', '');

        // Aqui garantimos que os nomes batem com os do form
        $filters = [
            'calories_from' => $request->get('calories_from'),
            'calories_to' => $request->get('calories_to'),
            'prep_time_from' => $request->get('prep_time_from'),
            'prep_time_to' => $request->get('prep_time_to'),
            'recipe_types' => $request->get('recipe_types', []),
        ];

        $page = (int) $request->get('page', 0);

        $recipesData = $this->fatSecret->getRecipes($search, $filters, $page);
        $recipes = $recipesData['recipe'] ?? [];
        $totalResults = (int) ($recipesData['total_results'] ?? 0);
        $maxResults = 50;
        $totalPages = ceil($totalResults / $maxResults);

        return view('recipes.index', compact('recipes', 'search', 'filters', 'page', 'totalPages'));
    }
}
