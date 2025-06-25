<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidato', function (Blueprint $table) {
            $table->increments('idCandidato'); // Clave primaria autoincremental
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('nif')->unique();
            $table->integer('orden');
            $table->unsignedInteger('idCandidatura'); // Relación con candidatura (unsigned)
            $table->boolean('elegido')->default(0); // Nuevo campo para saber si el candidato ha sido elegido
            // Clave foránea
            $table->foreign('idCandidatura')->references('idCandidatura')->on('candidatura')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('candidato');
    }
}; 