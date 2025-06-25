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
        Schema::create('circunscripcion', function (Blueprint $table) {
            $table->integer('idCircunscripcion')->primary(); // Clave primaria
            $table->string('NOMBRE'); // Nombre de la provincia/circunscripción en mayúsculas
            $table->integer('numEscanyos'); // Número de escaños
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circunscripcion');
    }
}; 