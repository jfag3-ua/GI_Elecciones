<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidatura', function (Blueprint $table) {
            $table->unsignedBigInteger('eleccion_id')->nullable()->after('escanyosElegidos');
            $table->foreign('eleccion_id')->references('id')->on('elecciones')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('candidatura', function (Blueprint $table) {
            $table->dropForeign(['eleccion_id']);
            $table->dropColumn('eleccion_id');
        });
    }
}; 