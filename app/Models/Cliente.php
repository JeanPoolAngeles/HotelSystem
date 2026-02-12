<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

  public static function rules($id = null)
  {
    return [
      'nombre' => 'required',
      'dni' => 'required|unique:cliente,dni,' . $id,
      'telefono' => 'required',
      'correo' => 'nullable|email',
      'direccion' => 'required',
      'tipo' => 'nullable',
    ];
  }

  protected $table = 'clientes';

  protected $fillable = ['nombre', 'dni', 'telefono', 'correo', 'direccion', 'tipo'];

  public function reservas()
  {
    return $this->hasMany(Reservas::class, 'id_cliente');
  }

  // Un cliente puede tener historial de estadías
  public function historialEstadias()
  {
    return $this->hasMany(Historialestadias::class, 'id_cliente');
  }
}
