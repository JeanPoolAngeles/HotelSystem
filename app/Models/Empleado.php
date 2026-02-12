<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    public static function rules($id = null)
    {
      return [
        'nombre' => 'required',
        'dni' => 'required|unique:empleados,dni,' . $id,
        'telefono' => 'required',
        'correo' => 'nullable|email',
        'tipo' => 'required',
        'sueldo' => 'required',
        'direccion' => 'required'
      ];
    }
  
    protected $table = 'empleados';
  
    protected $fillable = ['nombre', 'dni', 'telefono', 'tipo', 'correo', 'sueldo', 'direccion'];
  
}
