<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // Nome da receita
            $table->text('descricao')->nullable(); // Descrição
            $table->text('ingredientes'); // Ingredientes
            $table->text('modo_preparo'); // Modo de preparo
            $table->integer('tempo_preparo')->default(0); // Tempo em minutos
            $table->integer('porcoes')->default(1); // Porções
            $table->integer('calorias')->default(0); // Calorias
            $table->string('imagem')->nullable(); // Imagem da receita
            $table->string('dificuldade')->default('Fácil'); // Fácil, Médio, Difícil
            $table->foreignId('usuario_id')->constrained('usuarios'); // Criador
            $table->boolean('publica')->default(false); // Pública ou privada
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};