<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->increments('IDDIRECCION'); // Clave primaria autoincremental
            $table->string('PROVINCIA');
            $table->string('CIUDAD');
            $table->string('CPOSTAL');
            $table->string('NOMVIA');
            $table->string('NUMERO');
            $table->string('BIS')->nullable();
            $table->string('PISO')->nullable();
            $table->string('BLOQUE')->nullable();
            $table->string('PUERTA')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
}; 