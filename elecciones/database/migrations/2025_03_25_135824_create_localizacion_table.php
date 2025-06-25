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
        Schema::create('localizacion', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('nomProvincia'); // Nombre de la provincia (usado en los controladores)
            $table->string('ciudad');      // Ciudad
            $table->string('provincia');   // Nombre corto o identificador de provincia
            $table->string('codpos');      // Código postal (string para admitir ceros a la izquierda)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localizacion');
    }
};