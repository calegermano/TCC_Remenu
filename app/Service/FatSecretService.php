<?php

namespace App\Service;
use Illuminate\Support\Facades\Http;

class FatSecretService
{
    protected $key;
    protected $secret;

    public function __construct()
    {
    $this->key = config('services.fatsecret.client_id');
    $this->secret = config('services.fatsecret.client_secret');
    }

    // Obtém o access token
    public function getAccessToken()
    {
        $response = Http::asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . base64_encode($this->key . ':' . $this->secret),
            ])
            ->post('https://oauth.fatsecret.com/connect/token', [
                'grant_type' => 'client_credentials',
                'scope' => 'basic',
            ]);

        dd($response->json());

        return $response->json()['access_token'] ?? null;
    }

    // Busca receitas da API
    public function getRecipes($query = 'frango')
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return [];
        }

        $response = Http::withToken($token)->get('https://platform.fatsecret.com/rest/server.api', [
            'method' => 'recipes.search.v2',
            'search_expression' => $query,
            'format' => 'json',
        ]);

        $data = $response->json();

        dd($data);

        return $data['recipes']['recipe'] ?? [];
    }
}
