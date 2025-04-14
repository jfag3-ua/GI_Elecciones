<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacion extends Model
{
    use HasFactory;

    // Define el nombre de la tabla si no es el pluralizado por defecto
    protected $table = 'localizacion';

    // Definir los campos que son asignables de forma masiva (puedes añadir más campos según sea necesario)
    protected $fillable = [
        'nomProvincia',
        'ciudad',
        'provincia',
        'codpos',
    ];

    // Si tu tabla tiene una clave primaria diferente a 'id', define eso también
    // protected $primaryKey = 'id'; // No es necesario si la clave primaria es 'id'

    // Si no deseas usar el timestamp de Laravel
    // public $timestamps = false;
}
