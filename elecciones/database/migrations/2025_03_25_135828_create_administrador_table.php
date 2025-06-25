<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administrador', function (Blueprint $table) {
            $table->string('NIF')->primary();
            $table->string('NOMBREUSUARIO')->unique();
            $table->string('CONTRASENYA');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('administrador');
    }
}; 