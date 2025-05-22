<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidatura extends Model
{
    protected $table = 'candidatura';
    protected $primaryKey = 'idCandidatura'; // Columna que es clave primaria
    protected $fillable = ['nombre', 'color', 'idCircunscripcion', 'escanyosElegidos'];
    public $timestamps = false; // <--- Esto evita que Laravel intente guardar created_at y updated_at
    public function elecciones(): BelongsTo
    {
        return $this->BelongsTo(Eleccion::class);
    }
}
