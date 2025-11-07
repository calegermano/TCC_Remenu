<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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
            'max_results' => 50,
            'page_number' => $page,
            'must_have_images' => true,
            'sort_by' => 'relevance',
        ];

        // 🔹 Filtros de calorias e tempo
        if (!empty($filters['calories_from'])) $params['calories.from'] = (int) $filters['calories_from'];
        if (!empty($filters['calories_to'])) $params['calories.to'] = (int) $filters['calories_to'];
        if (!empty($filters['prep_time_from'])) $params['prep_time.from'] = (int) $filters['prep_time_from'];
        if (!empty($filters['prep_time_to'])) $params['prep_time.to'] = (int) $filters['prep_time_to'];

        // 🔹 Se o usuário digitou algo na busca, isso tem prioridade
        if (!empty($search)) {
            $params['search_expression'] = $search;
            return $this->callApi($params)['recipes'] ?? ['recipe' => [], 'total_results' => 0];
        }

        if (!empty($filters['recipe_types']) && is_array($filters['recipe_types'])) {
            $types = $filters['recipe_types'];

            // Caso especial: BEBIDAS
            if (count($types) === 1 && in_array('Beverage', $types)) {
                $searchTerms = [
                    'drink', 'juice', 'smoothie', 'vitamina', 'café', 'coffee',
                    'milkshake', 'chá', 'tea', 'refresco', 'suco', 'bebida', 'shake'
                ];

                $params['search_expression'] = implode(' OR ', $searchTerms);
                $response = $this->callApi($params);

                // 🔁 Se vier vazio, tenta busca em português apenas
                if (empty($response['recipes']['recipe'])) {
                    $params['search_expression'] = 'suco OR café OR vitamina OR bebida OR milkshake OR chá';
                    $response = $this->callApi($params);
                }

                return $response['recipes'] ?? ['recipe' => [], 'total_results' => 0];
            }

            // Caso especial: LANCHES
            if (count($types) === 1 && in_array('Snack', $types)) {
                $searchTerms = [
                    'snack', 'lanche', 'sanduíche', 'wrap', 'burger',
                    'pizza', 'tapioca', 'tostex', 'empada', 'coxinha', 'pastel'
                ];

                $params['search_expression'] = implode(' OR ', $searchTerms);
                $response = $this->callApi($params);

                // 🔁 Se vier com poucos resultados, busca alternativa
                if (empty($response['recipes']['recipe']) || count($response['recipes']['recipe']) < 5) {
                    $params['search_expression'] = 'lanche rápido OR sanduíche OR pão OR pizza OR salgadinho';
                    $response = $this->callApi($params);
                }

                return $response['recipes'] ?? ['recipe' => [], 'total_results' => 0];
            }


            // 🔹 Demais tipos (mantém o comportamento anterior)
            $params['recipe_types'] = implode(',', $types);
            $response = $this->callApi($params);

            if (empty($response['recipes']['recipe']) || count($response['recipes']['recipe']) < 5) {
                $keywords = [
                    'Salad' => 'salad vegetable lettuce tomato green',
                    'Main Dish' => 'main dish dinner pasta rice chicken beef lasagna',
                    'Dessert' => 'dessert cake pudding pie cookie brownie sweet',
                    'Side Dish' => 'side dish accompaniment mashed fries rice sauce garnish',
                    'Appetizer' => 'appetizer starter finger food bruschetta dip canapé',
                    'Breakfast' => 'breakfast eggs cereal pancake toast bread',
                    'Soup' => 'soup broth stew creamy bisque',
                ];

                $searchWords = [];
                foreach ($types as $type) {
                    if (isset($keywords[$type])) {
                        $searchWords[] = $keywords[$type];
                    }
                }

                if (!empty($searchWords)) {
                    unset($params['recipe_types']);
                    $params['search_expression'] = implode(' ', $searchWords);
                    $response = $this->callApi($params);
                }
            }

            return $response['recipes'] ?? ['recipe' => [], 'total_results' => 0];
        }
    }
}
