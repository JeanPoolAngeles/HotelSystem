<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';
    protected $fillable = ['codigo', 'nombre', 'descripcion', 'precio', 'estado', 'id_habitacion'];

    // Relación con habitación (evita errores si no hay relación)
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'id_habitacion')->withDefault([
            'categoria' => 'clasico',
            'numero' => 'N/A',
            'capacidad' => 2,
            'descripcion' => 'cuarto de 1 cama, 1 baño, 1 tele, 1 mueble, 1 control, 1 tolla, 1 javon, 1 papel de baño.'
        ]);
    }

    // Relación con reservas
    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'id_servicio');
    }
}
