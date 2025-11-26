<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class FatSecretService
{
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->clientId = config('services.fatsecret.client_id');
        $this->clientSecret = config('services.fatsecret.client_secret');
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
        $response = Http::asForm()->post('https://oauth.fatsecret.com/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scope' => 'basic',
        ]);

        return $response->json()['access_token'] ?? null;
    }

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

        // 🔹 filtros básicos
        if (!empty($filters['calories_from'])) $params['calories.from'] = (int)$filters['calories_from'];
        if (!empty($filters['calories_to'])) $params['calories.to'] = (int)$filters['calories_to'];
        if (!empty($filters['prep_time_from'])) $params['prep_time.from'] = (int)$filters['prep_time_from'];
        if (!empty($filters['prep_time_to'])) $params['prep_time.to'] = (int)$filters['prep_time_to'];

        if (!empty($filters['recipe_types']) && is_array($filters['recipe_types'])) {

            $types = $filters['recipe_types'];

            // 🟦 Smoothie / Bebidas especiais
            if (count($types) === 1 && in_array('Smoothie', $types)) {

                $params['search_expression'] = "smoothie OR juice OR tea OR coffee";
                $response = $this->callApi($params);

                return $response['recipes'] ?? ['recipe' => [], 'total_results' => 0];
            }

            // 🟩 Saladas
            if (count($types) === 1 && in_array('Salad', $types)) {

                $params['search_expression'] = "salad";
                $response = $this->callApi($params);

                if (empty($response['recipes']['recipe']) || count($response['recipes']['recipe']) < 10) {
                    $params['search_expression'] = "salad OR vegetable OR greens OR lettuce OR tomato OR fruit salad";
                    $response = $this->callApi($params);
                }

                return $response['recipes'] ?? ['recipe' => [], 'total_results' => 0];
            }

            
            $params['recipe_types'] = implode(',', $types);
        }

        if (!empty($search) && $search !== 'a') {
            $params['search_expression'] = $search;
        }
        $response = $this->callApi($params);

        return $response['recipes'] ?? ['recipe' => [], 'total_results' => 0];
    }

    public function getRecipeDetails($id)
    {
        // 2. ALTERE ESTE MÉTODO INTEIRO
        $params = [
            'method' => 'recipe.get', // <--- MUDOU DE 'recipe.get.v3' PARA 'recipe.get'
            'format' => 'json',
            'recipe_id' => $id,
        ];

        $response = $this->callApi($params);

        // LOG PARA DEPURAR: Isso vai salvar a resposta real da FatSecret no arquivo storage/logs/laravel.log
        Log::info('FatSecret Detalhes:', ['id' => $id, 'response' => $response]);

        if (isset($response['error'])) {
            return null;
        }

        return $response['recipe'] ?? null;
    }

}
