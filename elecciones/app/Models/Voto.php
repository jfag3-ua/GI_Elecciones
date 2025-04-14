<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'voto';

    // Campos asignables
    protected $fillable = ['voto', 'localizacion_id'];  // Usamos 'voto' en lugar de 'candidato_id' y 'localizacion_id' en lugar de 'provincia_id'
    
    public $timestamps = false;
    // Relación con Candidatura
    public function candidatura()
    {
        return $this->belongsTo(Candidatura::class, 'voto');  // Relacionamos el nombre del candidato
    }

    // Relación con Localizacion (no Provincia)
    public function localizacion()
    {
        return $this->belongsTo(Localizacion::class, 'localizacion_id');  // Cambiamos 'provincia_id' por 'localizacion_id'
    }
}
