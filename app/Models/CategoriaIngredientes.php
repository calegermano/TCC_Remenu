<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaIngredientes extends Model
{
    use HasFactory;

    protected $table = 'categorias_ingredientes';

    protected $fillable = [
        'nome',
    ];

    public function ingredientes()
    {
        return $this->hasMany(Ingredientes::class, 'categoria_id');
    }
}
