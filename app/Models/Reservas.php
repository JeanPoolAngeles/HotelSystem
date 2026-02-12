<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $fillable = [
        'codigo',
        'monto',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estado',
        'id_servicio',
        'id_cliente',
        'id_forma',
        'id_usuario'
    ];

    // Relación con cliente (una reserva pertenece a un cliente)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con usuario (quién creó la reserva)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con servicio (una reserva tiene un servicio asociado)
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    // Relación con forma de pago
    public function formaPago()
    {
        return $this->belongsTo(Forma::class, 'id_forma');
    }

    // Una reserva puede estar en el historial de estadías
    public function historialEstadias()
    {
        return $this->hasMany(Historialestadias::class, 'id_reserva');
    }
}
