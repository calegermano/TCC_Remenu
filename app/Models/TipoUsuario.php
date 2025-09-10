<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipo_usuario';

    protected $filaable =[
        'nome',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'tipo_id');
    }
}
