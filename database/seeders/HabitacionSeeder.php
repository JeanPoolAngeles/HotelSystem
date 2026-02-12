<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Habitacion;

class HabitacionSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 10; $i <= 30; $i++) {
            Habitacion::create([
                'categoria' => 'Habitacion ' . ($i <= 15 ? 'Estandar' : 'Premium'),
                'numero' => $i,
                'capacidad' => rand(1, 4),
                'slug' => Str::slug('Habitacion-'),
                'foto' => 'habitacion_' . $i . '.jpg',
                'video' => null,
                'descripcion' => 'Habitación número ' . $i . ' con todas las comodidades.',
                'precio' => rand(50, 160),
                'estado' => 1, // 1 = Disponible por defecto
            ]);
        }
    }
}
