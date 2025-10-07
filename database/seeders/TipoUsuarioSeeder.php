<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoUsuarioSeeder extends Seeder
{
    //php artisan db:seed --class=TipoUsuarioSeeder//
    public function run(): void
    {
        DB::table('tipos_usuario')->insert([
            ['nome' => 'admin'],
            ['nome' => 'comum'],
        ]);
    }
}
