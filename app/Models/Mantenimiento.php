<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimientos';
    protected $fillable = ['tipo', 'descripcion', 'estado', 'fecha_inicio', 'fecha_fin', 'id_empleado', 'id_habitacion'];

    // Relación con habitación
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'id_habitacion');
    }

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
}
