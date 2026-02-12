<?php

namespace App\Http\Controllers;

use App\Models\Reservas;
use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Forma;
use App\Models\Habitacion;
use App\Models\Historialestadias;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservasController extends Controller
{
    /**
     * Muestra la vista principal de reservas con los datos necesarios
     */
    public function index()
    {
        $formapagos = Forma::all(); // Obtener todas las formas de pago
        $clientes = Cliente::all(); // Obtener todos los clientes
        $habitaciones = Habitacion::where('estado', 1)->get(); // Habitaciones disponibles (estado 1 = libre)
        $servicios = Servicio::whereNull('id_habitacion')->get(); // Servicios sin asignar habitación

        return view('admin.reservas.index', compact('formapagos', 'clientes', 'habitaciones', 'servicios'));
    }
    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            DB::beginTransaction(); // Inicia la transacción

            // Verificar si hay una caja abierta
            $cajaAbierta = Caja::where('estado', 1)->first();
            if (!$cajaAbierta) {
                return response()->json([
                    'title' => 'LA CAJA ESTÁ CERRADA',
                    'icon' => 'warning'
                ]);
            }

            $userId = Auth::id();
            $id_caja = $cajaAbierta->id;
            $datosReserva = $request->all();

            // Datos recibidos
            $id_cliente = $datosReserva['id_cliente'];
            $id_servicio = $datosReserva['id_servicio'];
            $id_habitacion = $datosReserva['id_habitacion'];
            $forma = $datosReserva['forma'];
            $pago_con = $datosReserva['pago_con'] ?? 0;
            $total = $datosReserva['total'];
            $descripcion = $datosReserva['descripcion'];
            $fecha_inicio = $datosReserva['fecha_inicio'];
            $fecha_fin = $datosReserva['fecha_fin'];

            // Verificar si la habitación está disponible
            $habitacion = Habitacion::where('id', $id_habitacion)->where('estado', 1)->first();
            if (!$habitacion) {
                return response()->json([
                    'title' => 'LA HABITACIÓN SELECCIONADA NO ESTÁ DISPONIBLE',
                    'icon' => 'warning'
                ]);
            }

            // Crear la reserva
            $reserva = Reservas::create([
                'codigo' => strtoupper(uniqid('RSV-')), // Código único para la reserva
                'monto' => $pago_con,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'descripcion' => $descripcion,
                'estado' => 1, // 1 = Activa
                'id_servicio' => $id_servicio,
                'id_cliente' => $id_cliente,
                'id_forma' => $forma,
                'id_usuario' => $userId,
            ]);

            // Crear la venta relacionada con la reserva
            $venta = Venta::create([
                'total' => $total,
                'pago_con' => $pago_con,
                'id_caja' => $id_caja,
                'id_reserva' => $reserva->id,
            ]);

            // Asignar la habitación al servicio y actualizar su estado
            $servicio = Servicio::find($id_servicio);
            $servicio->id_habitacion = $id_habitacion;
            $servicio->save();

            $habitacion->estado = 2; // 2 = Ocupada // 0 mantenimiento
            $habitacion->save();

            // Registrar en el historial de estadías
            Historialestadias::create([
                'id_cliente' => $id_cliente,
                'id_reserva' => $reserva->id,
            ]);

            DB::commit(); // Confirmar la transacción

            return response()->json([
                'title' => 'RESERVA GENERADA CON ÉXITO',
                'icon' => 'success',
                'ticket' => $venta->id
            ]);
        } catch (\Exception $e) {
            DB::rollback(); // Revertir cambios en caso de error
            return response()->json([
                'title' => 'ERROR AL CREAR LA RESERVA',
                'icon' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function anular($reservaId)
    {
        $cajaAbierta = Caja::where('estado', 1)->first();
        if (!$cajaAbierta) {
            return redirect()->route('admin.venta.show')
                ->with('error', 'LA CAJA ESTÁ CERRADA');
        }

        try {
            DB::beginTransaction(); // Iniciar transacción

            // Obtener la reserva con la venta relacionada
            $reserva = Reservas::with('venta')->findOrFail($reservaId);

            // Liberar la habitación asociada al servicio
            $servicio = Servicio::find($reserva->id_servicio);
            if ($servicio) {
                $habitacion = Habitacion::find($servicio->id_habitacion);
                if ($habitacion) {
                    $habitacion->estado = 1; // 1 = Disponible
                    $habitacion->save();
                }
                $servicio->id_habitacion = null;
                $servicio->save();
            }

            // Eliminar historial de estadías
            Historialestadias::where('id_reserva', $reservaId)->delete();

            // Eliminar la venta relacionada
            Venta::where('id_reserva', $reservaId)->delete();

            // Eliminar la reserva
            $reserva->delete();

            DB::commit(); // Confirmar la transacción

            return redirect()->route('admin.reservas.index')
                ->with('success', 'RESERVA ANULADA CORRECTAMENTE');
        } catch (\Exception $e) {
            DB::rollback(); // Revertir cambios en caso de error
            return redirect()->route('admin.reservas.index')
                ->with('error', 'ERROR AL ANULAR LA RESERVA');
        }
    }
}
