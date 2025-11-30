<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao', 
        'ingredientes',
        'modo_preparo',
        'tempo_preparo',
        'porcoes',
        'calorias',
        'imagem',
        'dificuldade',
        'usuario_id',
        'publica'
    ];

    // Relação com o usuário criador
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relação com favoritos
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'recipe_id');
    }

    // Escopo para receitas públicas
    public function scopePublicas($query)
    {
        return $query->where('publica', true);
    }

    // Escopo para receitas do usuário
    public function scopeDoUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    // Acessor para tempo de preparo formatado
    public function getTempoPreparoFormatadoAttribute()
    {
        return $this->tempo_preparo . ' min';
    }
}