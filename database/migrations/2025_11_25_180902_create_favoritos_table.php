<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('recipe_id');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('calories')->nullable();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
        
            $table->timestamps();

            $table->unique(['usuario_id','recipe_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
