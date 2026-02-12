<?php

namespace App\Exports;

use App\Models\Gasto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GastosExport implements FromView
{
    public function view(): View
    {
        $userId = Auth::id();
        return view('admin.gastos.reporte', [
            //'company' => Compania::first(),
            'gastos' => Gasto::get()
        ]);
    }
}
