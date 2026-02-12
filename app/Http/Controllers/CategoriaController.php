<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

/**
 * Class CategoriaController
 * @package App\Http\Controllers
 */
class CategoriaController extends Controller
{
    public function __construct() {
        $this->middleware('can:admin.categorias.index')->only('index');
        $this->middleware('can:admin.categorias.create')->only('create', 'store');
        $this->middleware('can:admin.categorias.edit')->only('edit', 'update');
        $this->middleware('can:admin.categorias.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categoria.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria = new Categoria();
        return view('admin.categoria.create', compact('categoria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Categoria::rules());

        $categoria = Categoria::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria creado.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::find($id);

        return view('admin.categoria.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        request()->validate(Categoria::rules($categoria->id));

        $categoria->update(
            [
                'nombre' => $request->nombre
            ]
        );

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria actualizado');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Categoria::find($id)->delete();
        return redirect()->route('admin.categorias.index')
        ->with('success', 'Categoria eliminado.');
    }
}
