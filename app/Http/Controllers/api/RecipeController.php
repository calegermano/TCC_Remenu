<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Services\FatSecretService;
use App\Http\Resources\RecipeResource;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    protected $fatSecretService;

    public function __construct(FatSecretService $fatSecretService)
    {
        $this->fatSecretService = $fatSecretService;
    }

    // Listar receitas (LOCAIS + FATSECRET)
    public function index(Request $request)
    {
        $source = $request->get('source', 'local');
        
        if ($source === 'fatsecret') {
            // Buscar da API FatSecret
            try {
                $page = $request->get('page', 0);
                $search = $request->get('search', '');
                
                $recipes = $this->fatSecretService->getRecipes($search, [], $page);
                
                return response()->json([
                    'success' => true,
                    'source' => 'fatsecret',
                    'data' => $recipes['recipes'] ?? [],
                    'total_results' => $recipes['total_results'] ?? 0,
                    'page_number' => $recipes['page_number'] ?? 0
                ]);
                
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao buscar receitas da API'
                ], 500);
            }
        } else {
            // Buscar receitas locais (apenas públicas)
            $recipes = Recipe::publicas()->get();
            return response()->json([
                'success' => true,
                'source' => 'local',
                'data' => RecipeResource::collection($recipes)
            ]);
        }
    }

    // Mostrar uma específica
    public function show($id, Request $request)
    {
        $source = $request->get('source', 'local');
        
        if ($source === 'fatsecret') {
            // Buscar da API FatSecret
            try {
                $recipe = $this->fatSecretService->getRecipe($id);
                
                return response()->json([
                    'success' => true,
                    'source' => 'fatsecret',
                    'data' => $recipe
                ]);
                
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Receita não encontrada na API'
                ], 404);
            }
        } else {
            // Buscar receita local (pode ser privada se for do usuário)
            $recipe = Recipe::find($id);

            if (!$recipe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Receita não encontrada'
                ], 404);
            }

            // Verificar se é pública ou do usuário
            if (!$recipe->publica && $recipe->usuario_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acesso não autorizado'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'source' => 'local',
                'data' => new RecipeResource($recipe)
            ]);
        }
    }

    // Criar receita local
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ingredientes' => 'required|string',
            'modo_preparo' => 'required|string',
            'tempo_preparo' => 'required|integer|min:1',
            'porcoes' => 'required|integer|min:1',
            'calorias' => 'nullable|integer',
            'dificuldade' => 'required|in:Fácil,Médio,Difícil',
            'publica' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $recipe = Recipe::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'ingredientes' => $request->ingredientes,
            'modo_preparo' => $request->modo_preparo,
            'tempo_preparo' => $request->tempo_preparo,
            'porcoes' => $request->porcoes,
            'calorias' => $request->calorias ?? 0,
            'dificuldade' => $request->dificuldade,
            'usuario_id' => $request->user()->id,
            'publica' => $request->publica ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Receita criada com sucesso',
            'data' => new RecipeResource($recipe)
        ], 201);
    }

    // Atualizar receita local
    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('usuario_id', $request->user()->id)->find($id);

        if (!$recipe) {
            return response()->json([
                'success' => false,
                'message' => 'Receita não encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|string|max:255',
            'descricao' => 'nullable|string',
            'ingredientes' => 'sometimes|string',
            'modo_preparo' => 'sometimes|string',
            'tempo_preparo' => 'sometimes|integer|min:1',
            'porcoes' => 'sometimes|integer|min:1',
            'calorias' => 'nullable|integer',
            'dificuldade' => 'sometimes|in:Fácil,Médio,Difícil',
            'publica' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $recipe->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Receita atualizada com sucesso',
            'data' => new RecipeResource($recipe)
        ]);
    }

    // Deletar receita local
    public function destroy(Request $request, $id)
    {
        $recipe = Recipe::where('usuario_id', $request->user()->id)->find($id);

        if (!$recipe) {
            return response()->json([
                'success' => false,
                'message' => 'Receita não encontrada'
            ], 404);
        }

        $recipe->delete();

        return response()->json([
            'success' => true,
            'message' => 'Receita deletada com sucesso'
        ]);
    }

    // Minhas receitas
    public function minhasReceitas(Request $request)
    {
        $recipes = Recipe::where('usuario_id', $request->user()->id)->get();
        
        return response()->json([
            'success' => true,
            'data' => RecipeResource::collection($recipes)
        ]);
    }

    // Pesquisar receitas da FatSecret
    public function search($query)
    {
        try {
            $recipes = $this->fatSecretService->searchRecipes($query);
            
            return response()->json([
                'success' => true,
                'source' => 'fatsecret',
                'data' => $recipes['recipes'] ?? [],
                'total_results' => $recipes['total_results'] ?? 0
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro na pesquisa'
            ], 500);
        }
    }

    // Listar apenas receitas da FatSecret
    public function fatsecretRecipes(Request $request)
    {
        try {
            $page = $request->get('page', 0);
            $search = $request->get('search', '');
            
            $recipes = $this->fatSecretService->getRecipes($search, [], $page);
            
            return response()->json([
                'success' => true,
                'source' => 'fatsecret',
                'data' => $recipes['recipes'] ?? [],
                'total_results' => $recipes['total_results'] ?? 0,
                'page_number' => $recipes['page_number'] ?? 0
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar receitas da API'
            ], 500);
        }
    }
}