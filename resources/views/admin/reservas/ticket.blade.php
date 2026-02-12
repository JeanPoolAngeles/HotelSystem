<!DOCTYPE html>
<html>

<head>
    <title>Reporte Ticket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .ticket {
            width: 181px;
            padding: 2px;
            border: 1px solid #000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .business-info {
            text-align: center;
            font-size: 10px;
        }

        .ticket-details {
            margin-top: 10px;
            padding-top: 10px;
        }

        .ticket-details p {
            font-size: 10px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        th,
        td {
            padding: 2px;
            border-bottom: 1px solid #000;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .footer-info {
            text-align: center;
            font-size: 10px;
            margin-top: 10px;
        }

        .footer-info p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="business-info">
            <h3>{{ $company->nombre }}</h3>
            <p>COMPROBANTE DE PAGO</p>
        </div>
        <div class="ticket-details">
            @if ($tipo_venta === 'para_mesa') <!-- Mostrar solo para ventas en mesa -->
                <hr>
                <p>Numero de Mesa: {{ $nr_mesa }}</p>
                <p># Sala: {{ $id_sala }}</p>
                <p># Empleado: {{ $id_empleado }}</p>
                <hr>
            @endif
            <p>Tipo de Venta: {{ $tipo_venta }}</p>
            <p>Fecha: {{ $fecha . ' ' . $hora }}</p>
            <p>Cliente: {{ $venta->cliente->nombre }}</p>
            @if ($tipo_venta != 'para_mesa' || $tipo_venta == '' )
                <p>Teléfono: {{ $venta->cliente->telefono ?? '-' }}</p>
                <p>Dirección: {{ $venta->cliente->direccion ?? '-' }}</p>
            @endif
            <hr>
        </div>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th>Cant</th>
                        <th>Producto</th>
                        <th class="text-right">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->cantidad }}</td>
                            <td>
                                @if ($producto->tipo == 'producto')
                                    {{ $producto->nombre }} <!-- Para productos -->
                                @else
                                    {{ $producto->nombre }} <!-- Para platos -->
                                @endif
                            </td>
                            <td class="text-right">{{ $producto->precio }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Método</td>
                        <td class="text-right">{{ $venta->metodo }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Forma Pago</td>
                        <td class="text-right">{{ $venta->formapago->nombre }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Pago con</td>
                        <td class="text-right">{{ $venta->pago_con }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Cambio</td>
                        <td class="text-right">{{ number_format($venta->pago_con - $venta->total, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total</td>
                        <td class="text-right">{{ number_format($venta->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="footer-info">
            <p>**Gracias por su compra**</p>
            <p>Teléfono: {{ $company->telefono }}</p>
            <p>Email: {{ $company->correo }}</p>
            <p>Ubicación: {{ $company->direccion }}</p>
            <p>****Ticket válido para reclamos****</p>
            <p>**TICKET NO VALIDO PARA SUNAT**</p>
        </div>
    </div>
</body>

</html>
@php
    header('Content-type: application/pdf');
@endphp
