<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            [
                'codigo' => 'GI001',
                'producto' => 'INCA KOLA 1L',
                'precio_compra' => 4.50,
                'precio_venta' => 7,
                'estado' => 1,
                'stock' => 10,
                'foto' => 'productos/sd2hHfwBh4JbDRuvteKsHHPOnzPXk9IqgCDjHY9E.jpg',
                'id_categoria' => 1,
            ],
            [
                'codigo' => 'GC001',
                'producto' => 'COCA KOLA 1L',
                'precio_compra' => 4.50,
                'precio_venta' => 7,
                'estado' => 1,
                'stock' => 10,
                'foto' => 'productos/rfYRv4qC2XBPFJR4nS21NHHDMpFiDmQIHOKnehsl.webp',
                'id_categoria' => 1,
            ],
            [
                'codigo' => 'GIP01',
                'producto' => 'INCA KOLA PERSONAL',
                'precio_compra' => 1.50,
                'precio_venta' => 2,
                'estado' => 1,
                'stock' => 10,
                'foto' => 'productos/AgLkahEkJGWHK5igBiUcOesWGLgAXlxSZmZU0YeW.jpg',
                'id_categoria' => 1,
            ],
            [
                'codigo' => 'GCP01',
                'producto' => 'COCA KOLA PERSONAL',
                'precio_compra' => 1.50,
                'precio_venta' => 2,
                'estado' => 1,
                'stock' => 10,
                'foto' => 'productos/rfYRv4qC2XBPFJR4nS21NHHDMpFiDmQIHOKnehsl.webp',
                'id_categoria' => 1,
            ],
            [
                'codigo' => 'ED005',
                'producto' => 'INCA KOLA GORDITA',
                'precio_compra' => 2,
                'precio_venta' => 4,
                'estado' => 1,
                'stock' => 10,
                'foto' => 'productos/VnLZLI7CplXuorvRiCoFSwGv9nNo1vjNTMepCJKg.png',
                'id_categoria' => 1,
            ],
        ];
        DB::table('productos')->insert($productos);
    }
}
