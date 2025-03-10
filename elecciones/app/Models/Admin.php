<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'administrador';  // Asigna la tabla correcta
    public $primaryKey = 'NIF'; // Clave primaria

    protected $fillable = [
        'NIF', 'CONTRASENYA',
    ];

    protected $hidden = [
        'CONTRASENYA', // Ocultar la contraseña en la respuesta JSON
    ];

    public function getAuthIdentifierName()
    {
        return 'NIF';
    }

    public function getAuthPassword()
    {
        return $this->CONTRASENYA;
    }
}
