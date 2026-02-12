<?php

namespace App\Http\Controllers;

use App\Models\Abonoventa;
use App\Models\Caja;
use App\Models\Compra;
use Illuminate\Http\Request;
use App\Models\Gasto;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class GastoController extends Controller
{
    public function __construct() {
        $this->middleware('can:admin.gastos.index')->only('index');
        $this->middleware('can:admin.gastos.create')->only('create', 'store');
        $this->middleware('can:admin.gastos.edit')->only('edit', 'update');
        $this->middleware('can:admin.gastos.delete')->only('destroy');
    }

    public function index()
    {

        return view('admin.gastos.index');
    }

    public function create()
    {
        return view('admin.gastos.create');
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $existe = Caja::where('estado', 1)->first();
        if ($existe) {
            // Valida los campos del formulario
            $request->validate([
                'monto' => 'required|numeric|min:0.01',
                'descripcion' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta según tus necesidades
            ]);

            $id_caja = $existe->id;
            $montoInicial = $existe->monto_inicial;
            $compras = Compra::where('id_caja', $id_caja)->where('estado', 1)->sum('total');
            $gastos = Gasto::where('id_caja', $id_caja)->sum('monto');
            $ventas = Venta::where('id_caja', $id_caja)->where('estado', 1)->sum('total');
            $saldo = ($montoInicial + $ventas) - ($compras + $gastos);

            if ($saldo < $request->monto) {
                return redirect()->route('admin.gastos.create')->with('error', 'SALDO DISPONIBLE. ' . $saldo);
            }

            // Lógica para manejar la foto si se adjunta
            if ($request->hasFile('foto')) {
                // Aquí debes almacenar y manejar la foto, por ejemplo:
                $fotoPath = $request->file('foto')->store('gastos', 'public');
            } else {
                $fotoPath = null;
            }
            // Crea el gasto en la base de datos
            Gasto::create([
                'monto' => $request->monto,
                'descripcion' => $request->descripcion,
                'foto' => $fotoPath,
                'id_caja' => $id_caja,
                'id_usuario' => $userId,
            ]);

            // Redirige a la vista de lista de gastos con un mensaje
            return redirect()->route('admin.gastos.index')->with('success', 'Gasto creado correctamente.');
        } else {
            return redirect()->route('admin.gastos.create')->with('error', 'La caja esta cerrada.');
        }
    }

    public function edit($id)
    {
        $gasto = Gasto::find($id);
        return view('admin.gastos.edit', compact('gasto'));
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $existe = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();
        if ($existe) {
            // Valida los campos del formulario
            $request->validate([
                'monto' => 'required|numeric|min:0.01',
                'descripcion' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta según tus necesidades
            ]);

            $id_caja = $existe->id;
            $montoInicial = $existe->monto_inicial;
            //GASTO ACTUAL
            $gastoActual = Gasto::find($id);
            $compras = Compra::where('id_usuario', $userId)->where('id_caja', $id_caja)->where('estado', 1)->sum('total');
            $gastos = Gasto::where('id_usuario', $userId)->where('id_caja', $id_caja)->sum('monto');
            $ventas = Venta::where('id_usuario', $userId)->where('id_caja', $id_caja)->where('estado', 1)->where('metodo', 'Contado')->sum('total');
            $abonoventa = Abonoventa::where('id_usuario', $userId)->where('id_caja', $id_caja)->sum('monto');
            $saldo = ($montoInicial + $ventas + $abonoventa) - ($compras + $gastos + $gastoActual->monto);

            if ($saldo < $request->monto) {
                return redirect()->route('admin.gastos.create')->with('error', 'SALDO DISPONIBLE. ' . $saldo);
            }

            // Lógica para manejar la foto si se adjunta
            if ($request->hasFile('foto')) {
                // Aquí debes almacenar y manejar la foto, por ejemplo:
                $fotoPath = $request->file('foto')->store('gastos', 'public');
            } else {
                $fotoPath = null;
            }
            
            // Actualiza el gasto en la base de datos
            Gasto::find($id)->update([
                'monto' => $request->monto,
                'descripcion' => $request->descripcion,
                'foto' => $fotoPath,
                'id_caja' => $id_caja,
                'id_usuario' => $userId,
            ]);

            // Redirige a la vista de lista de gastos con un mensaje
            return redirect()->route('admin.gastos.index')->with('success', 'Gasto actualizado correctamente.');
        } else {
            return redirect()->route('admin.gastos.create')->with('error', 'La caja esta cerrada.');
        }
    }

    public function destroy($id)
    {
        // Elimina el gasto con el ID proporcionado
        Gasto::destroy($id);
        return redirect()->route('admin.gastos.index')
        ->with('success', 'Gasto eliminado correctamente.');
    }
}
