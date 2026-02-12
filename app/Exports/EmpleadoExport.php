<?php

namespace App\Exports;

use App\Models\Empleado;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmpleadoExport implements FromView
{
    public function view(): View
    {
        return view('admin.empleados.reporte', [
            //'company' => Compania::first(),
            'empleados' => Empleado::get()
        ]);
    }
}
