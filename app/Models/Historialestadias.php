<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historialestadias extends Model
{
    use HasFactory;

    protected $table = 'historialestadias';
    protected $fillable = ['id_cliente', 'id_reserva'];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con reserva
    public function reserva()
    {
        return $this->belongsTo(Reservas::class, 'id_reserva');
    }
}
