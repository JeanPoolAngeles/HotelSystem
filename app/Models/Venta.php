<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['total', 'pago_con', 'id_caja', 'id_reserva'];

    // Relación con caja
    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    // Relación con reservas
    public function reserva()
    {
        return $this->belongsTo(Reservas::class, 'id_reserva');
    }

    // Relación con detalles de venta
    public function detalleVenta()
    {
        return $this->hasMany(Detalleventa::class, 'id_venta');
    }
}
