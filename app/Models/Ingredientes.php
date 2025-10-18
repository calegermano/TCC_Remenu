<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Ingredientes extends Model
{
    use HasFactory;

    protected $table = 'ingredientes';

    protected $fillable = [
        'nome',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaIngrediente::class, 'categoria_id');
    }
}
