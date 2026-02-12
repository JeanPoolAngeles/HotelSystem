<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ServicioSeeder::class);
        $this->call(HabitacionSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(CompaniaSeeder::class);
        $this->call(FormaSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
