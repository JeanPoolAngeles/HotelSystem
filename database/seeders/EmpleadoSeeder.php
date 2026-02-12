<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    
    public function run(): void
    {
        Empleado::create([
            'nombre' => 'jean pool angeles lara',
            'dni' => 77665544,
            'telefono' => '964686884',
            'tipo' => 'mozo',
            'correo' => 'jean@gmail.com',
            'sueldo' => 1300,
            'direccion' => 'Av San Carlos 1119, Huancayo - Peru.',
        ]);
        Empleado::create([
            'nombre' => 'frank perez cardenas',
            'dni' => 77665543,
            'telefono' => '954789765',
            'correo' => 'frank@gmail.com',
            'tipo' => 'mozo',
            'sueldo' => 1300,
            'direccion' => 'Av San Carlos 1119, Huancayo - Peru.',
        ]);
        Empleado::create([
            'nombre' => 'jose luis puertas',
            'dni' => 77665542,
            'telefono' => '954678432',
            'tipo' => 'cocinero',
            'correo' => 'jose@gmail.com',
            'sueldo' => 1300,
            'direccion' => 'Av San Carlos 1119, Huancayo - Peru.',
        ]);
        Empleado::create([
            'nombre' => 'ana maria torres ',
            'dni' => 77665542,
            'telefono' => '999345123',
            'tipo' => 'cajero',
            'correo' => 'ana@gmail.com',
            'sueldo' => 1300,
            'direccion' => 'Av San Carlos 1119, Huancayo - Peru.',
        ]);
    }
}
