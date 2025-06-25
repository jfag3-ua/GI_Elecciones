<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatura', function (Blueprint $table) {
            $table->increments('idCandidatura'); // Clave primaria autoincremental
            $table->string('nombre');
            $table->string('color');
            $table->integer('idCircunscripcion'); // Relación con circunscripcion
            $table->integer('escanyosElegidos')->default(0);
            // Clave foránea
            $table->foreign('idCircunscripcion')->references('idCircunscripcion')->on('circunscripcion')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('candidatura');
    }
}; 