<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.empleados.index')->only('index');
        $this->middleware('can:admin.empleados.create')->only('create', 'store');
        $this->middleware('can:admin.empleados.edit')->only('edit', 'update');
        $this->middleware('can:admin.empleados.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.empleados.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = new Empleado();
        return view('admin.empleados.create', compact('empleados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //dd($request->all());

        request()->validate(Empleado::rules());

        $empleado = Empleado::create([
            'nombre' => $request->nombre,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'tipo' => $request->tipo,
            'correo' => $request->correo,
            'sueldo' => $request->sueldo,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('admin.empleados.index')
            ->with('success', 'Empleado creado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleados = Empleado::find($id);

        if (!$empleados) {
            return redirect()->route('admin.empleados.index')
                ->with('error', 'Empleado no encontrado.');
        }

        return view('admin.empleados.edit', compact('empleados'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        // Obtener las reglas de validación
        $rules = Empleado::rules($empleado->id);

        // Validar los datos de la solicitud
        $request->validate($rules);

        // Actualizar el cliente
        $empleado->update([
            'nombre' => $request->nombre,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'tipo' => $request->tipo,
            'correo' => $request->correo,
            'sueldo' => $request->sueldo,
            'direccion' => $request->direccion,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.empleados.index')
            ->with('success', 'Empleado actualizado');
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Empleado::find($id)->delete();
        return redirect()->route('admin.empleados.index')
            ->with('success', 'Empleado eliminado.');
    }

    public function list()
    {
        $mozos = Empleado::where('tipo', 'mozo')->orderBy('id', 'asc')->get(); // Selecciona solo los mozos
        return response()->json($mozos);
    }
}
