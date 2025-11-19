<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipo_usuarios';

    const ADMIN = 1;
    const COMUM = 2;

    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'tipo_id');
    }
}