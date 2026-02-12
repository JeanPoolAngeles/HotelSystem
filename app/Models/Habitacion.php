<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $table = 'habitacions'; // Confirma que en la BD está bien escrita
    protected $fillable = [
        'categoria',
        'numero',
        'capacidad',
        'slug',
        'foto',
        'video',
        'descripcion',
        'precio',
        'estado'
    ];

    // Una habitación puede tener muchos servicios
    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_habitacion');
    }

    // Una habitación puede tener huéspedes
    public function huspedes()
    {
        return $this->hasMany(Husped::class, 'id_habitacion');
    }

    // Una habitación puede tener mantenimientos
    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'id_habitacion');
    }

    // Relación con reservas a través de servicios
    public function reservas()
    {
        return $this->hasManyThrough(
            Reservas::class,     // Modelo final
            Servicio::class,     // Modelo intermedio
            'id_habitacion',     // Clave foránea en `servicios` que referencia `habitacions`
            'id_servicio',       // Clave foránea en `reservas` que referencia `servicios`
            'id',                // Clave primaria en `habitacions`
            'id'                 // Clave primaria en `servicios`
        );
    }
}
