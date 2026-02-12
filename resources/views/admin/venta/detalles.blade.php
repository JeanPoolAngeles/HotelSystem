@extends('template')

@section('title', 'Detalles de la Venta.')

@section('content')
    <div class="container mt-4">
        @if ($venta)
            <h5>Detalles de la Venta</h5>
            <p><strong>Mesa:</strong> {{ $venta->mesa->numero_mesa }}</p>
            <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }}</p>
            <p><strong>Total:</strong> {{ $venta->total }} {{ $venta->moneda }}</p>
            <!-- Otros detalles que quieras mostrar -->
        @else
            <p>No hay una venta activa para esta mesa.</p>
        @endif
    </div>
@endsection
