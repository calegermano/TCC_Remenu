<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

class FatSecretService
{
    protected $clientId;
    protected $clientSecret;
    protected $geminiKey;

    public function __construct()
    {
        $this->clientId = config('services.fatsecret.client_id');
        $this->clientSecret = config('services.fatsecret.client_secret');
        $this->geminiKey = env('GEMINI_API_KEY');
    }

    protected function callApi(array $params)
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->get('https://platform.fatsecret.com/rest/server.api', $params);

        if ($response->failed()) {
            return ['error' => $response->json()];
        }

        return $response->json();
    }

    protected function getAccessToken()
    {
        return Cache::remember('fatsecret_token', 3600, function () {
            $response = Http::asForm()->post('https://oauth.fatsecret.com/connect/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => 'basic',
            ]);

            return $response->json()['access_token'] ?? null;
        });
    }

    // --- BUSCA E LISTAGEM (CORRIGIDO) ---
    public function getRecipes($search = '', $filters = [], $page = 0)
    {
        // 1. CONFIGURAÇÃO INICIAL (Baseado no CÓDIGO 1 para manter a tela inicial igual)
        $params = [
            'method' => 'recipes.search.v3',
            'format' => 'json',
            'max_results' => 48,
            'page_number' => $page,
            'must_have_images' => true, // Mantido true para não quebrar o layout inicial
            'sort_by' => 'relevance',
        ];

        // 2. TRADUÇÃO DA BUSCA (PT -> EN) - Mantida a lógica do CÓDIGO 1
        if (!empty($search) && $search !== 'a') {
            try {
                $tr = new GoogleTranslate('en'); 
                $searchEn = $tr->translate($search);
                $params['search_expression'] = $searchEn;
                
                $palavrasDeBebida = [
                    'juice', 'suco', 'smoothie', 'vitamina', 'shake', 'milkshake', 
                    'tea', 'chá', 'coffee', 'café', 'drink', 'bebida', 
                    'cocktail', 'coquetel', 'lemonade', 'limonada'
                ];

                foreach ($palavrasDeBebida as $palavra) {
                    if (stripos($search, $palavra) !== false || stripos($searchEn, $palavra) !== false) {
                        if (empty($filters['recipe_types'])) {
                            $params['recipe_types'] = 'Beverage';
                        }
                        break;
                    }
                }
            } catch (\Exception $e) {
                $params['search_expression'] = $search;
            }
        }

        // 3. FILTROS NUMÉRICOS
        if (!empty($filters['calories_from'])) $params['calories.from'] = (int)$filters['calories_from'];
        if (!empty($filters['calories_to'])) $params['calories.to'] = (int)$filters['calories_to'];
        if (!empty($filters['prep_time_from'])) $params['prep_time.from'] = (int)$filters['prep_time_from'];
        if (!empty($filters['prep_time_to'])) $params['prep_time.to'] = (int)$filters['prep_time_to'];

        // 4. LÓGICA DE TIPOS (AQUI ESTÁ A CORREÇÃO HÍBRIDA)
        if (!empty($filters['recipe_types']) && is_array($filters['recipe_types'])) {
            $types = $filters['recipe_types'];
            
            // Verifica se "Salad" foi selecionado
            if (in_array('Salad', $types)) {
                // Pega o termo que já está sendo buscado (ex: "Chicken")
                $currentSearch = $params['search_expression'] ?? '';
                
                // Lógica do CÓDIGO 2: Adiciona "salad" na busca textual
                if (empty($currentSearch)) {
                    $params['search_expression'] = "salad";
                } else {
                    $params['search_expression'] = trim($currentSearch . " salad");
                }
                
                // IMPORTANTE: Removemos o filtro 'recipe_types' rígido para saladas
                // Isso força a API a procurar pela palavra-chave, que funciona melhor
                unset($params['recipe_types']); 
            } 
            elseif (in_array('Soup', $types)) {
                // Aplicando a mesma lógica para Sopas (opcional, mas recomendado)
                $currentSearch = $params['search_expression'] ?? '';
                if (empty($currentSearch)) {
                    $params['search_expression'] = "soup";
                } else {
                    $params['search_expression'] = trim($currentSearch . " soup");
                }
                unset($params['recipe_types']);
            }
            else {
                // Para outros tipos (como Smoothie padrão), mantém comportamento normal
                if (count($types) === 1 && in_array('Smoothie', $types)) {
                    $params['search_expression'] = "smoothie OR juice OR tea OR coffee";
                }
                $params['recipe_types'] = implode(',', $types);
            }
        }

        // 5. CHAMADA API
        $response = $this->callApi($params);
        $recipesData = $response['recipes'] ?? ['recipe' => [], 'total_results' => 0];

        if (empty($recipesData['recipe'])) {
            return $recipesData;
        }

        // 6. NORMALIZAÇÃO
        $recipesList = isset($recipesData['recipe']['recipe_id']) 
                    ? [$recipesData['recipe']] 
                    : $recipesData['recipe'];

        // 7. TRADUÇÃO DOS TÍTULOS (CÓDIGO 1 - Lógica Batch)
        $titlesEn = array_column($recipesList, 'recipe_name');
        
        // Cache key baseado nos títulos
        $cacheKey = 'titles_' . md5(json_encode($titlesEn));
        
        $titlesPt = Cache::remember($cacheKey, 3600, function() use ($titlesEn) {
            return $this->translateBatchWithGemini($titlesEn);
        });

        foreach ($recipesList as $index => &$recipe) {
            if (isset($titlesPt[$index])) {
                $recipe['recipe_name'] = $titlesPt[$index];
            }
        }

        $recipesData['recipe'] = $recipesList;
        return $recipesData;
    }

    // --- DETALHES DA RECEITA (COM TRADUÇÃO COMPLETA) ---
    public function getRecipeDetails($id)
    {
        $cacheKey = "recipe_translated_{$id}_v3"; // Mudei versão para v3 para limpar erros antigos

        return Cache::remember($cacheKey, 2592000, function () use ($id) {
            
            $params = [
                'method' => 'recipe.get',
                'format' => 'json',
                'recipe_id' => $id,
            ];

            $response = $this->callApi($params);

            if (isset($response['error']) || empty($response['recipe'])) {
                return null;
            }

            $recipe = $response['recipe'];

            return $this->translateWithGemini($recipe);
        });
    }

    // --- TRADUÇÃO COM GEMINI (DETALHES) ---
    protected function translateWithGemini($recipeData)
    {
        if (empty($this->geminiKey)) {
            return $this->translateWithFallback($recipeData);
        }

        $dataToTranslate = $recipeData;
        unset($dataToTranslate['recipe_url']);
        unset($dataToTranslate['recipe_images']); 
        
        $prompt = "
            Atue como um tradutor culinário para Português do Brasil.
            Traduza os valores deste JSON. 
            REGRAS:
            1. Mantenha a estrutura JSON idêntica.
            2. Converta unidades para o padrão brasileiro (xícara, colher de sopa, etc).
            3. Retorne APENAS o JSON válido.
            JSON: " . json_encode($dataToTranslate);

        try {
            // Tentei usar o modelo mais padrão para garantir compatibilidade
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$this->geminiKey}", [
                    'contents' => [['parts' => [['text' => $prompt]]]],
                    'generationConfig' => ['responseMimeType' => 'application/json']
                ]);

            if ($response->successful()) {
                $jsonResponse = $response->json();
                $translatedText = $jsonResponse['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if ($translatedText) {
                    $translatedData = json_decode($translatedText, true);
                    if ($translatedData) {
                        return array_merge($recipeData, $translatedData);
                    }
                }
            }
            // Se falhar o Gemini, tenta o Google Translate
            return $this->translateWithFallback($recipeData);

        } catch (\Exception $e) {
            Log::error('Gemini falhou: ' . $e->getMessage());
            return $this->translateWithFallback($recipeData);
        }
    }

    // --- TRADUÇÃO EM LOTE (LISTAGEM) ---
    protected function translateBatchWithGemini(array $titles)
    {
        if (empty($this->geminiKey) || empty($titles)) {
            return $titles; 
        }

        $prompt = "
            Traduza a lista de títulos de receitas abaixo para o Português do Brasil.
            Mantenha a ordem EXATA.
            Retorne APENAS um Array JSON de strings.
            Lista: " . json_encode($titles);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$this->geminiKey}", [
                    'contents' => [['parts' => [['text' => $prompt]]]],
                    'generationConfig' => ['responseMimeType' => 'application/json']
                ]);

            if ($response->successful()) {
                $text = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) {
                    $translatedArray = json_decode($text, true);
                    if (is_array($translatedArray) && count($translatedArray) == count($titles)) {
                        return $translatedArray;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Erro Lote: ' . $e->getMessage());
        }

        return $titles;
    }

    // --- PLANO B: GOOGLE TRANSLATE (SEM IA) ---
    protected function translateWithFallback($recipe)
    {
        try {
            $tr = new GoogleTranslate('pt-br'); 

            if (isset($recipe['recipe_name'])) $recipe['recipe_name'] = $tr->translate($recipe['recipe_name']);
            if (isset($recipe['recipe_description'])) $recipe['recipe_description'] = $tr->translate($recipe['recipe_description']);

            // Ingredientes
            $ingredients = $recipe['ingredients']['ingredient'] ?? [];
            $isSingle = isset($ingredients['ingredient_description']);
            if ($isSingle) $ingredients = [$ingredients];

            foreach ($ingredients as &$ing) {
                if (isset($ing['ingredient_description'])) $ing['ingredient_description'] = $tr->translate($ing['ingredient_description']);
            }
            
            if ($isSingle) $recipe['ingredients']['ingredient'] = $ingredients[0];
            else $recipe['ingredients']['ingredient'] = $ingredients;

            // Preparo
            $directions = $recipe['directions']['direction'] ?? [];
            $isSingleDir = isset($directions['direction_description']);
            if ($isSingleDir) $directions = [$directions];

            foreach ($directions as &$dir) {
                if (isset($dir['direction_description'])) $dir['direction_description'] = $tr->translate($dir['direction_description']);
            }

            if ($isSingleDir) $recipe['directions']['direction'] = $directions[0];
            else $recipe['directions']['direction'] = $directions;

            return $recipe;

        } catch (\Exception $e) {
            return $recipe; // Se tudo falhar, retorna em inglês
        }
    }
}