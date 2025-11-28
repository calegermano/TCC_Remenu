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
        $params = [
            'method' => 'recipes.search.v3',
            'format' => 'json',
            'max_results' => 48,
            'page_number' => $page,
            'must_have_images' => true,
            'sort_by' => 'relevance',
        ];

        // 1. TRADUÇÃO DA BUSCA (PT -> EN)
        // Isso permite pesquisar "Frango" e achar resultados de "Chicken"
        if (!empty($search) && $search !== 'a') {
            try {
                // Traduz para inglês rapidinho antes de buscar
                $tr = new GoogleTranslate('en'); 
                $searchEn = $tr->translate($search);
                $params['search_expression'] = $searchEn;
                
                $palavrasDeBebida = [
                    'juice', 'suco', 
                    'smoothie', 'vitamina', 
                    'shake', 'milkshake', 
                    'tea', 'chá', 
                    'coffee', 'café', 
                    'drink', 'bebida', 
                    'cocktail', 'coquetel',
                    'lemonade', 'limonada'
                ];

                // Verifica se a busca (em PT ou EN) contém alguma dessas palavras
                foreach ($palavrasDeBebida as $palavra) {
                    // stripos busca sem diferenciar maiúscula/minúscula
                    if (stripos($search, $palavra) !== false || stripos($searchEn, $palavra) !== false) {
                        // Se encontrou, FORÇA o tipo ser Bebida (se o usuário não marcou outro filtro)
                        if (empty($filters['recipe_types'])) {
                            $params['recipe_types'] = 'Beverage';
                        }
                        break; // Para de procurar
                    }
                }
                // ---------------------------------------------------

            } catch (\Exception $e) {
                $params['search_expression'] = $search;
            }
        }

        // Filtros (Mantidos iguais)
        if (!empty($filters['calories_from'])) $params['calories.from'] = (int)$filters['calories_from'];
        if (!empty($filters['calories_to'])) $params['calories.to'] = (int)$filters['calories_to'];
        if (!empty($filters['prep_time_from'])) $params['prep_time.from'] = (int)$filters['prep_time_from'];
        if (!empty($filters['prep_time_to'])) $params['prep_time.to'] = (int)$filters['prep_time_to'];

        if (!empty($filters['recipe_types']) && is_array($filters['recipe_types'])) {
            $types = $filters['recipe_types'];
            // Lógica de Smoothie e Salada mantida...
            if (count($types) === 1 && in_array('Smoothie', $types)) {
                $params['search_expression'] = "smoothie OR juice OR tea OR coffee";
            }
            if (count($types) === 1 && in_array('Salad', $types)) {
                $params['search_expression'] = "salad";
            }
            $params['recipe_types'] = implode(',', $types);
        }

        // 2. CHAMADA API
        $response = $this->callApi($params);
        $recipesData = $response['recipes'] ?? ['recipe' => [], 'total_results' => 0];

        // Se não tem receitas, retorna vazio agora
        if (empty($recipesData['recipe'])) {
            return $recipesData;
        }

        // 3. NORMALIZAÇÃO (Array ou Objeto)
        $recipesList = isset($recipesData['recipe']['recipe_id']) 
                       ? [$recipesData['recipe']] 
                       : $recipesData['recipe'];

        // 4. TRADUÇÃO EM LOTE DOS TÍTULOS (EN -> PT)
        
        // Extrai apenas os nomes
        $titlesEn = array_column($recipesList, 'recipe_name');
        
        // Cacheia a tradução dos títulos baseada na busca
        $cacheKey = 'titles_' . md5(json_encode($titlesEn));
        
        $titlesPt = Cache::remember($cacheKey, 3600, function() use ($titlesEn) {
            return $this->translateBatchWithGemini($titlesEn);
        });

        // Substitui os nomes originais pelos traduzidos
        foreach ($recipesList as $index => &$recipe) {
            if (isset($titlesPt[$index])) {
                $recipe['recipe_name'] = $titlesPt[$index];
            }
        }

        // Atualiza a lista e retorna
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