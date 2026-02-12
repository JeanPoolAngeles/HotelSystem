<?php

namespace App\Http\Controllers;

use App\Exports\VentaExport;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Compania;
use App\Models\Detalleventa;
use App\Models\Forma;
use App\Models\Producto;
use App\Models\Venta;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class VentaController
 * @package App\Http\Controllers
 */
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formapagos = Forma::all();
        $cliente = Cliente::first();
        return view('admin.venta.index', compact('formapagos', 'cliente'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $existe = Caja::where('estado', 1)->first(); // Verificar si hay una caja abierta
        if ($existe) {
            $id_caja = $existe->id;
            $datosVenta = $request->all();
            $id_cliente = $datosVenta['id_cliente'];
            $forma = $datosVenta['forma'];
            $pago_con = $datosVenta['pago_con'];
            $totalDecimal = Cart::instance('ventas')->subtotal();
            $total = str_replace(',', '', $totalDecimal);

            if ($total > 0) {
                $pago_con = (empty($pago_con)) ? 0 : $pago_con;
                $sale = Venta::create([
                    'total' => $total,
                    'pago_con' => $pago_con,
                    'id_empleado' => $datosVenta['id_empleado'] ?? null,
                    'id_cliente' => $id_cliente,
                    'id_caja' => $id_caja,
                    'id_forma' => $forma,
                    'id_usuario' => $userId,
                ]);

                if ($sale) {

                    $polloEntero = Producto::where('producto', 'POLLO ENTERO')->first();

                    // Actualizar el estado de la mesa
                    foreach (Cart::instance('ventas')->content() as $item) {
                        $productoId = null;

                        Detalleventa::create([
                            'precio' => $item->price,
                            'cantidad' => $item->qty,
                            'id_producto' => $productoId, // Esto será null si es un plato
                            'id_venta' => $sale->id
                        ]);

                        if ($item->options->type == 'producto') {
                            $producto = Producto::find($productoId);
                            if ($producto && $producto->stock >= $item->qty) {
                                $producto->decrement('stock', $item->qty);
                            } elseif ($producto) {
                                $producto->update(['stock' => 0]);
                            }
                        }
                    }
                    Cart::instance('ventas')->destroy();
                    return response()->json([
                        'title' => 'VENTA GENERADA',
                        'icon' => 'success',
                        'ticket' => $sale->id
                    ]);
                }
            } else {
                return response()->json([
                    'title' => 'CARRITO VACIO',
                    'icon' => 'warning'
                ]);
            }
        } else {
            return response()->json([
                'title' => 'LA CAJA ESTA CERRADA',
                'icon' => 'warning'
            ]);
        }
    }

    public function ticket($id)
    {
        // Obtener la compañía
        $data['company'] = Compania::first();

        // Obtener la venta
        $data['venta'] = Venta::with(['cliente', 'formapago'])
            ->where('id', $id)
            ->first();

        // Verificar si la venta existe
        if (!$data['venta']) {
            return response()->json([
                'success' => false,
                'message' => 'Venta no encontrada. Verifique el ID proporcionado.'
            ], 404);
        }

        // Obtener los detalles de los productos
        $productos = Detalleventa::join('productos', 'detalleventa.id_producto', '=', 'productos.id')
            ->select('detalleventa.*', 'productos.producto AS nombre', DB::raw('"producto" AS tipo'))
            ->where('detalleventa.id_venta', $id)
            ->get();

        // Combinar ambos resultados
        $data['productos'] = $productos;

        // Acceder a la fecha solo si existe la venta
        $fecha_venta = $data['venta']->created_at;

        // Asignar detalles adicionales
        $data['fecha'] = date('d/m/Y', strtotime($fecha_venta));
        $data['hora'] = date('h:i A', strtotime($fecha_venta));
        $data['id_empleado'] = $data['venta']->id_empleado;

        // Generar el contenido del ticket en HTML
        $html = View::make('admin.venta.ticket', $data)->render();
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 140, 500], 'portrait')->setWarnings(false);

        return $pdf->stream('ticket.pdf');
    }

    public function show()
    {
        return view('admin.venta.show');
    }

    public function cliente(Request $request)
    {
        $term = $request->get('term');
        $clients = Cliente::where('nombre', 'LIKE', '%' . $term . '%')
            ->select('id', 'nombre AS label', 'telefono', 'direccion')
            ->limit(10)
            ->get();
        return response()->json($clients);
    }

    public function anular($ventaId)
    {
        $existe = Caja::where('estado', 1)->first();
        if ($existe) {
            try {
                // Iniciar una transacción
                DB::beginTransaction();

                // Buscar la venta por ID con sus detalles
                $venta = Venta::with('detalleventa')->findOrFail($ventaId);

                // Iterar sobre los detalles y deshacer la cantidad en la tabla de productos
                foreach ($venta->detalleventa as $detalle) {
                    if ($detalle->id_producto) {
                        $producto = Producto::find($detalle->id_producto);
                        if ($producto) {
                            $producto->increment('stock', $detalle->cantidad);
                        }
                    }
                }
                
                // Actualizar el estado de la venta a 0
                $venta->update(['estado' => 0]);

                // Confirmar la transacción
                DB::commit();

                return redirect()->route('admin.venta.show')
                    ->with('success', 'VENTA ANULADA');
            } catch (\Exception $e) {
                // Deshacer la transacción en caso de error
                DB::rollback();

                return redirect()->route('admin.venta.show')
                    ->with('error', 'ERROR AL ANULAR');
            }
        } else {
            return redirect()->route('admin.venta.show')
                ->with('error', 'LA CAJA ESTA CERRADO');
        }
    }

    public function generateExcelReport()
    {
        return Excel::download(new VentaExport, 'venta.xlsx');
    }

    public function generatePdfReport()
    {
        $userId = Auth::id();

        $data['ventas'] = Venta::with(
            [
                'cliente',
                'formapago'
            ]
        )->where('id_usuario', $userId)->get();

        $html = View::make('admin.venta.reporte', $data)
            ->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape')
            ->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }
}