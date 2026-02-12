<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
  use HasFactory;

  protected $fillable = [
    'monto_inicial',
    'fecha_apertura',
    'fecha_cierre',
    'compras',
    'gastos',
    'ventas',
    'estado',
    'id_usuario'
  ];

  // Un usuario abre una caja
  public function usuario()
  {
    return $this->belongsTo(User::class, 'id_usuario');
  }

  // Una caja puede tener muchos gastos
  public function gastos()
  {
    return $this->hasMany(Gasto::class, 'id_caja');
  }

  // Una caja puede tener muchas ventas
  public function ventas()
  {
    return $this->hasMany(Venta::class, 'id_caja');
  }
}
