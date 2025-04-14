<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    use HasFactory;

    // Si la tabla se llama 'candidatura' (singular), puedes especificarlo si no sigue la convención.
    protected $table = 'candidatura'; // No es necesario si la tabla sigue la convención

    // Definir los campos que son asignables masivamente
    protected $fillable = [
        'nombre', // Nombre del candidato o partido
    ];

    // Si deseas agregar algún método relacionado o alguna relación, puedes hacerlo aquí
}
