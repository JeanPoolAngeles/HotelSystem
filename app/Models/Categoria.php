<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

  public static function rules($id = null)
  {
    return [
      'nombre' => 'required|unique:categoria,nombre,' . $id
    ];
  }

  protected $table = 'categoria';

  protected $fillable = ['nombre'];

  public function productos()
  {
    return $this->hasMany(Producto::class);
  }
}
