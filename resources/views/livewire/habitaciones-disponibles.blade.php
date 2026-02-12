<div>
    <div class="card">
        <div class="row">
            @foreach ($habitaciones as $habitacion)
                @php
                    $bgColor =
                        $habitacion->estado == 1
                            ? 'bg-success text-white'
                            : ($habitacion->estado == 2
                                ? 'bg-danger text-white'
                                : 'bg-info text-white');
                    $estadoTexto =
                        $habitacion->estado == 1
                            ? 'Disponible'
                            : ($habitacion->estado == 2
                                ? 'Ocupado'
                                : 'En Mantenimiento');
                @endphp
                <div class="col-md-2 mb-3"> <!-- Distribuye las tarjetas en columnas -->
                    <div class="card shadow {{ $bgColor }}">
                        <div class="card-body">
                            <h5 class="card-title">Habitación #{{ $habitacion->numero }}</h5>
                            <p><strong>Categoría:</strong> {{ $habitacion->categoria }}</p>
                            <p><strong>Capacidad:</strong> {{ $habitacion->capacidad }} personas</p>
                            <p><strong>Precio:</strong> ${{ number_format($habitacion->precio, 2) }}</p>
                            <p><strong>Estado:</strong>
                                <span class="badge bg-dark">{{ $estadoTexto }}</span>
                            </p>
                            @if ($habitacion->servicios->isEmpty())
                                <small>Sin servicio asignado</small>
                            @else
                                <strong>Servicios:</strong>
                                <ul>
                                    @foreach ($habitacion->servicios as $servicio)
                                        <li>{{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
