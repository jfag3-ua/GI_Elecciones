<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circunscripcion extends Model
{
    use HasFactory;

    protected $table = 'circunscripcion';
    protected $primaryKey = 'idCircunscripcion';
    public $timestamps = false;
    protected $fillable = ['NOMBRE', 'numEscanyos'];
} 