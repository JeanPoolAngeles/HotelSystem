<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Servicio;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            ['codigo' => 'SRV001', 'nombre' => 'Wi-Fi Premium', 'descripcion' => 'Conexión a internet de alta velocidad en toda la habitación.', 'precio' => 10.99],
            ['codigo' => 'SRV002', 'nombre' => 'Desayuno Buffet', 'descripcion' => 'Desayuno buffet con opciones internacionales.', 'precio' => 15.50],
            ['codigo' => 'SRV003', 'nombre' => 'Lavandería', 'descripcion' => 'Servicio de lavado y planchado de ropa.', 'precio' => 25.00],
            ['codigo' => 'SRV004', 'nombre' => 'Servicio a la Habitación', 'descripcion' => 'Atención en la habitación las 24 horas.', 'precio' => 5.00],
            ['codigo' => 'SRV005', 'nombre' => 'Gimnasio', 'descripcion' => 'Acceso libre al gimnasio del hotel.', 'precio' => 8.00],
            ['codigo' => 'SRV006', 'nombre' => 'Spa y Masajes', 'descripcion' => 'Sesión de spa con masajes relajantes.', 'precio' => 40.00],
            ['codigo' => 'SRV007', 'nombre' => 'Transporte al Aeropuerto', 'descripcion' => 'Transporte privado hacia el aeropuerto.', 'precio' => 20.00],
            ['codigo' => 'SRV008', 'nombre' => 'Cena Romántica', 'descripcion' => 'Cena especial con velas y vino.', 'precio' => 50.00],
            ['codigo' => 'SRV009', 'nombre' => 'Excursión Turística', 'descripcion' => 'Tour por los principales atractivos de la ciudad.', 'precio' => 30.00],
            ['codigo' => 'SRV010', 'nombre' => 'Alquiler de Bicicletas', 'descripcion' => 'Alquiler de bicicletas para recorrer la ciudad.', 'precio' => 12.00],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create([
                'codigo' => $servicio['codigo'],
                'nombre' => $servicio['nombre'],
                'descripcion' => $servicio['descripcion'],
                'precio' => $servicio['precio'],
            ]);
        }
    }
}
