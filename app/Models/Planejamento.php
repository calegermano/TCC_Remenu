<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planejamento extends Model
{
    use HasFactory;

    protected $table = 'planejamentos';

    protected $fillable = [
        'usuario_id',
        'recipe_id',
        'date',
        'meal_type',
        'recipe_name',
        'recipe_image',
        'calories',
        'protein',
        'carbs'
    ];
}
