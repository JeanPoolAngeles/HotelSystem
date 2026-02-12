<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $table = 'incidencias';
    protected $fillable = ['descripcion', 'hora', 'estado', 'id_cliente', 'id_habitacion'];
}
