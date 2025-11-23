<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoUsuario;

class TiposUsuarioSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            [
                'id' => 1,
                'nome' => 'admin'
            ],
            [
                'id' => 2,
                'nome' => 'comum'
            ]
        ];

        foreach ($tipos as $tipo) {
            TipoUsuario::updateOrCreate(
                ['id' => $tipo['id']],
                $tipo
            );
        }
    }
}