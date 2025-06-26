<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'usuario';  // Asegúrate de que el nombre de la tabla es correcto

    // Definir qué campo se utiliza para la autenticación
    public $primaryKey = 'NIF'; // Usamos NIF como la clave primaria

    protected $fillable = [
        'NIF', 'CONTRASENYA',
    ];

    protected $hidden = [
        'CONTRASENYA', // Ocultar la contraseña en la respuesta JSON
    ];

    // Definir cómo se autentica por NIF en lugar de email
    public function getAuthIdentifierName()
    {
        return 'NIF';
    }

    public function getAuthPassword()
    {
        return $this->CONTRASENYA;
    }
}

