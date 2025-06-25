<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('censo', function (Blueprint $table) {
            $table->string('NIF')->primary(); // Clave primaria, relacionado con usuario
            $table->unsignedInteger('IDDIRECCION'); // Relación con direcciones
            $table->string('CLAVE'); // Para registro/validación
            $table->string('NOMBRE'); // Nombre
            $table->string('APELLIDOS'); // Apellidos
            $table->date('FECHANAC'); // Fecha de nacimiento
            $table->string('SEXO'); // Sexo
            $table->timestamps();
            // Clave foránea
            $table->foreign('IDDIRECCION')->references('IDDIRECCION')->on('direcciones')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('censo');
    }
}; 