<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elecciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_campana_inicio')->nullable();
            $table->date('fecha_campana_fin')->nullable();
            $table->date('fecha_elecciones')->nullable();
            $table->boolean('activa')->default(false);
            $table->integer('votos_nulos')->default(0);
            $table->integer('abstenciones')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elecciones');
    }
}; 