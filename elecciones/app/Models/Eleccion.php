<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Eleccion extends Model
{
    use HasFactory;

    protected $table = 'elecciones';
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'fecha_campana_inicio',
        'fecha_campana_fin',
        'fecha_elecciones',
        'activa',
        'votos_nulos',
        'abstenciones',
    ];
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'fecha_campana_inicio' => 'datetime',
        'fecha_campana_fin' => 'datetime',
        'fecha_elecciones' => 'datetime',
        'activa' => 'boolean',
    ];

    public function candidatos(): HasMany
    {
        return $this->HasMany(Candidato::class, 'eleccion_candidato');
    }

    public function candidaturas(): HasMany
    {
        return $this->HasMany(Candidatura::class, 'eleccion_candidatura');
    }

    public function votos(): HasMany
    {
        return $this->hasMany(Voto::class); // Asumiendo que la tabla 'voto' tiene una 'eleccion_id'
    }
}
