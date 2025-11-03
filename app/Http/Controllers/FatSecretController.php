<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FatSecretController extends Controller
{
      public function search(Request $request)
    {
        $query = trim($request->input('q', 'chicken'));
        $key = env('FATSECRET_CONSUMER_KEY');
        $secret = env('FATSECRET_CONSUMER_SECRET');

        if (!$key || !$secret) {
            return response()->json(['error' => 'Credenciais ausentes']);
        }

        $params = [
            'method' => 'recipes.search',
            'search_expression' => $query,
            'format' => 'json',
            'max_results' => '12',
        ];

        // Gera OAuth 1.0a corretamente
        $oauth = [
            'oauth_consumer_key' => $key,
            'oauth_nonce' => md5(uniqid()),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0',
        ];

        // Parâmetros assinados = oauth + query
        $base_params = array_merge($oauth, $params);
        ksort($base_params);
        $base_string = 'GET&' . rawurlencode('https://platform.fatsecret.com/rest/server.api') . '&' . rawurlencode(http_build_query($base_params, '', '&', PHP_QUERY_RFC3986));
        $oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $base_string, $secret . '&', true));

        // Cabeçalho Authorization
        $auth_header = 'OAuth ' . implode(', ', array_map(
            fn($k, $v) => $k . '="' . rawurlencode($v) . '"',
            array_keys($oauth),
            $oauth
        ));

        // Chamada
        $response = Http::withHeader('Authorization', $auth_header)
                      ->get('https://platform.fatsecret.com/rest/server.api', $params);

        $data = $response->json();

        // Extrai receitas
        $recipes = $data['recipes']['recipe'] ?? [];
        if (!is_array($recipes)) $recipes = [$recipes];

        return response()->json([
            'recipes' => array_map(fn($r) => [
                'name' => $r['recipe_name'] ?? 'No name',
                'description' => $r['recipe_description'] ?? '',
                'image' => $r['recipe_images']['recipe_image'][0]['image_url'] ?? null,
                'url' => $r['recipe_url'] ?? '#',
            ], $recipes)
        ]);
    }
}