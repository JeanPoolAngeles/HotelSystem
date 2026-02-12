<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.productos.index')->only('index');
        $this->middleware('can:admin.productos.create')->only('create', 'store');
        $this->middleware('can:admin.productos.edit')->only('edit', 'update');
        $this->middleware('can:admin.productos.delete')->only('toggleStatus');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.producto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();
        $categorias = Categoria::pluck('nombre', 'id');
        return view('admin.producto.create', compact('producto', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Producto::rules()); // Pass the ID for unique rule in updates

        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('productos', 'public');
        } else {
            $imagePath = null;
        }

        Producto::create([
            'codigo' => $request->codigo,
            'producto' => $request->producto,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'stock' => $request->stock,
            'foto' => $imagePath,
            'id_categoria' => $request->id_categoria,
        ]);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        $categorias = Categoria::pluck('nombre', 'id');
        return view('admin.producto.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $rules = Producto::rules($producto->id);

        // Si el campo 'stock' no está presente, elimina la regla de validación para 'stock'
        if (!$request->has('stock')) {
            unset($rules['stock']);
        }

        $request->validate($rules);

        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('productos', 'public');
            // Eliminar la imagen anterior si existe
            if ($producto->foto) {
                Storage::disk('public')->delete($producto->foto);
            }
        } else {
            $imagePath = $producto->foto;
        }

        $producto->update([
            'codigo' => $request->codigo,
            'producto' => $request->producto,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'stock' => $request->has('stock') ? $request->stock : $request->stock_hidden,
            'foto' => $imagePath,
            'id_categoria' => $request->id_categoria,
        ]);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado');
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function toggleStatus($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = $producto->estado == 1 ? 0 : 1;
        $producto->save();

        return redirect()->route('admin.productos.index')->with('success', 'El estado del producto se ha actualizado correctamente.');
    }


    public function updated(Producto $producto)
    {
        // Verificar si se actualizó el stock del POLLO ENTERO
        if ($producto->producto === 'POLLO ENTERO' && $producto->isDirty('stock')) {

            // Calcular cantidad de cuartos disponibles
            $cuartosDisponibles = $producto->stock * 4; // 1 pollo = 4 cuartos

            // Obtener platos de categorías 1 y 2
            $platos = Plato::whereIn('id_categoria', [1, 2])->get();

            foreach ($platos as $plato) {
                // Asignar stock de 1/4 a cada plato hasta agotar cuartos
                $stockRepartido = min($cuartosDisponibles, 4); // Máximo 4 cuartos por vez

                if ($stockRepartido > 0) {
                    // Guardar en inventario
                    Inventario::updateOrCreate(
                        ['producto_id' => $producto->id, 'plato_id' => $plato->id],
                        [
                            'stock_anterior' => $plato->stock ?? 0,
                            'stock_entra' => $stockRepartido,
                            'stock_queda' => $plato->stock + $stockRepartido,
                        ]
                    );

                    // Actualizar stock del plato
                    $plato->increment('stock', $stockRepartido);

                    // Restar cuartos disponibles
                    $cuartosDisponibles -= $stockRepartido;
                }
            }

            // Actualizar el stock restante del producto POLLO ENTERO
            $producto->stock = floor($cuartosDisponibles / 4); // Cuartos restantes convertidos a pollos enteros
            $producto->saveQuietly(); // Guardar sin disparar de nuevo el Observer
        }
    }
}
