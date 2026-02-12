<?php

namespace App\Livewire;

use App\Models\Habitacion;
use Livewire\Component;

class HabitacionesDisponibles extends Component
{
    public function render()

    {

        // Obtener todas las habitaciones con sus servicios
        $habitaciones = Habitacion::with('servicios')->get();
        return view('livewire.habitaciones-disponibles', compact('habitaciones'));
    }
}
