<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Husped extends Model
{
    use HasFactory;

    protected $table = 'huspeds';
    protected $fillable = ['id_cliente', 'id_habitacion'];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con habitación
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'id_habitacion');
    }
}
