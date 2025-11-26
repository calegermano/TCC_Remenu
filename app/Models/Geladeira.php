<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Geladeira extends Model
{
    protected $table = 'geladeiras';

    protected $fillable = [
        'usuario_id',
        'ingrediente_id',
        'quantidade',
        'validade',
    ];
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingredientes::class);
    }
}
