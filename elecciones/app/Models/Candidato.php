<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Candidato extends Model
{
    use HasFactory;

    protected $table = 'candidato'; // Especifica el nombre de la tabla

    protected $primaryKey = 'idCandidato'; // Especifica la clave primaria

    public $timestamps = false; // Indica que la tabla no tiene campos 'created_at' y 'updated_at'

    protected $fillable = [
        'nombre',
        'apellidos',
        'elegido',
        'idCandidatura',
        'nif',
        'orden',
        'eleccion_id',
    ];

    protected $casts = [
        'idCandidato' => 'integer',
        'elegido' => 'boolean',
        'idCandidatura' => 'integer',
        'orden' => 'integer',
    ];

    /**
     * Define la relación con la Candidatura a la que pertenece el candidato.
     */
    public function candidatura(): BelongsTo
    {
        return $this->belongsTo(Candidatura::class, 'idCandidatura', 'idCandidatura');
    }

    /**
     * Define la relación muchos a muchos con las Elecciones en las que participa el candidato.
     */
    public function elecciones(): BelongsTo
    {
        return $this->BelongsTo(Eleccion::class);
    }
}
