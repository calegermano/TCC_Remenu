<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public function toArray($request)
    {
        // Aqui assumi alguns nomes de colunas, altere conforme seu banco de dados
        return [
            'id' => $this->id,
            'titulo' => $this->titulo ?? $this->nome, // Ajuste para o nome real da coluna
            'descricao' => $this->descricao,
            'tempo_preparo' => $this->tempo_preparo, // Ex: "30 min"
            
            // TRUQUE IMPORTANTE: Converter caminho relativo para URL completa
            // Se sua imagem for salva como "receitas/bolo.jpg", isso vira "http://localhost:8000/storage/receitas/bolo.jpg"
            'imagem_url' => $this->imagem ? asset('storage/' . $this->imagem) : null,
            
            // Se você tiver relacionamento com usuário
            'autor' => $this->usuario ? $this->usuario->nome : 'Desconhecido',
            
            // Data formatada para o App
            'data_criacao' => $this->created_at->format('d/m/Y'),
        ];
    }
}