<?php

namespace App\Exports;

use App\Models\Caja;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class CajasExport implements FromView
{
    public function view(): View
    {
        return view('admin.caja.reporte', [
            'cajas' => Caja::all() // Obtener todas las cajas sin filtro por usuario
        ]);
        /*
        $userId = Auth::id();
        return view('admin.caja.reporte', [
            //'company' => Compania::first(),
            'cajas' => Caja::where('id_usuario', $userId)->get()
        ]);*/
    }
}
