<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planejamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('recipe_id');
            $table->date('date');
            $table->string('meal_type');

            $table->string('recipe_name');
            $table->string('recipe_image')->nullable();
            $table->integer('calories')->default(0);
            $table->float('protein')->default(0);
            $table->float('carbs')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planejamentos');
    }
};
