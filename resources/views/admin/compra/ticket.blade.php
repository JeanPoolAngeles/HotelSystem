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
            width: 165px;
            padding: 10px;
            border: 1px solid #000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .business-info {
            text-align: center;
            font-size: 12px;
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

        th, td {
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
            <h3>{{$company->nombre}}</h3>
            <p>{{$company->direccion}}</p>
            <p>{{$company->telefono}}</p>
            <p>{{$company->correo}}</p>
        </div>
        <hr>
        <div class="ticket-details">
            <p>Fecha: {{ $fecha . ' ' . $hora }}</p>
            <p>Folio: {{ $compra->id }}</p>
            <hr>
            <p>Proveedor: {{ $compra->nombre }}</p>
            <p>Teléfono: {{ $compra->telefono }}</p>
            <p>Dirección: {{ $compra->direccion }}</p>
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
                            <td>{{ $producto->producto }}</td>
                            <td class="text-right">{{ $producto->precio }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><hr></td>
                    </tr>
                    <tr>
                        <td colspan="2">Total</td>
                        <td class="text-right"><h4>{{ number_format($compra->total, 2) }}</h4></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
@php
    header("Content-type: application/pdf");
@endphp
