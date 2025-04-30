<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotoTable extends Migration
{
    public function up()
    {
        // Verificar si la tabla ya existe antes de crearla
        if (!Schema::hasTable('voto')) {
            Schema::create('voto', function (Blueprint $table) {
                $table->id();  // Clave primaria autoincremental
                $table->string('voto', 45);  // Nombre del candidato
                $table->unsignedBigInteger('localizacion_id')->nullable();  // Relación con la tabla 'localizacion'
                $table->timestamps();

                // Clave foránea para 'localizacion_id'
                $table->foreign('localizacion_id')->references('id')->on('localizacion')
                    ->onDelete('set null');  // Esto asegura que, si la localización se elimina, el campo 'localizacion_id' se pone a NULL
            });
        }
    }

    public function down()
    {
        // Eliminar la tabla en caso de que sea necesario revertir la migración
        Schema::dropIfExists('voto');
    }
}
