<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('geladeiras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('ingrediente_id');
            $table->integer('quantidade')->nullable();
            $table->date('validade')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geladeiras');
    }
};
