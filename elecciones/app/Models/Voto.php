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
    protected $fillable = ['candidato_id', 'provincia_id'];

    // Relación con Candidatura
    public function candidatura()
    {
        return $this->belongsTo(Candidatura::class, 'candidato_id');
    }

    // Relación con Provincia
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }
}
