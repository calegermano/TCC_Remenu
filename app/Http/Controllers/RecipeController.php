<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FatSecretService;
use Illuminate\Support\Facades\Auth;

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

    // ========== MÉTODOS PROTEGIDOS PELO MIDDLEWARE ==========

    /**
     * Adicionar receita aos favoritos
     */
    public function favoritar(Request $request, $id)
    {
        $user = Auth::user();
        
        // Lógica para favoritar a receita
        // Exemplo: $user->favoritos()->attach($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Receita adicionada aos favoritos!'
        ]);
    }

    /**
     * Remover receita dos favoritos
     */
    public function desfavoritar(Request $request, $id)
    {
        $user = Auth::user();
        
        // Lógica para remover dos favoritos
        // Exemplo: $user->favoritos()->detach($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Receita removida dos favoritos!'
        ]);
    }

    /**
     * Avaliar uma receita
     */
    public function avaliar(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5'
        ]);

        $user = Auth::user();
        
        // Lógica para salvar avaliação
        // Exemplo: Rating::updateOrCreate(...);
        
        return response()->json([
            'success' => true,
            'message' => 'Avaliação salva com sucesso!'
        ]);
    }

    /**
     * Comentar em uma receita
     */
    public function comentar(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500'
        ]);

        $user = Auth::user();
        
        // Lógica para salvar comentário
        // Exemplo: Comment::create(...);
        
        return response()->json([
            'success' => true,
            'message' => 'Comentário adicionado com sucesso!'
        ]);
    }

    /**
     * Adicionar receita ao planejamento
     */
    public function adicionarPlanejamento(Request $request, $id)
    {
        $request->validate([
            'data' => 'required|date',
            'refeicao' => 'required|in:cafe,almoco,jantar,lanche'
        ]);

        $user = Auth::user();
        
        // Lógica para adicionar ao planejamento
        // Exemplo: MealPlan::create(...);
        
        return response()->json([
            'success' => true,
            'message' => 'Receita adicionada ao planejamento!'
        ]);
    }

    /**
     * Adicionar ingredientes à lista de compras
     */
    public function adicionarIngredientes(Request $request, $id)
    {
        $recipe = $this->fatSecret->getRecipeDetails($id);
        
        if (!$recipe) {
            return response()->json([
                'error' => true,
                'message' => 'Receita não encontrada'
            ], 404);
        }

        $user = Auth::user();
        
        // Lógica para adicionar ingredientes à lista de compras
        // Exemplo: ShoppingList::addIngredients(...);
        
        return response()->json([
            'success' => true,
            'message' => 'Ingredientes adicionados à lista de compras!'
        ]);
    }

    /**
     * Busca avançada (POST)
     */
    public function buscarAvancado(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:100'
        ]);

        // Redireciona para a rota GET com os parâmetros
        return redirect()->route('recipes.index', $request->only('search'));
    }

    /**
     * Filtro avançado (POST)
     */
    public function filtrarAvancado(Request $request)
    {
        // Redireciona para a rota GET com os filtros
        return redirect()->route('recipes.index', $request->all());
    }
}