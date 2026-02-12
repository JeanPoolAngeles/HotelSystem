@extends('template')

@section('title', 'ADMIN-RESERVAS')

@section('content')
    <div class="card">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE NUEVAS RESERVAS</h1>
        </div>
    </div>

    @if (session('success'))
        <script>
            let message = "{{ session('success') }}"
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: message,
                showConfirmButton: false,
                timer: 1200
            });
        </script>
    @endif

    <div class="card mt-1">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    @can('admin.cajas.index')
                        <div class="mb-1">
                            <a href="{{ route('admin.cajas.index') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-funnel-dollar"></i> {{ __('Caja') }}
                            </a>
                            <a href="{{ route('admin.reservas.show') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-list"></i> {{ __('Listar reservas') }}
                            </a>
                        </div>
                    @endcan
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="card">
                                        <div class="container">
                                            <div class="card-body">
                                                <!-- Livewire muestra habitaciones disponibles@livewire('habitaciones-disponibles') -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end gap-2">
                            <button class="btn btn-primary fixed-button mt-4" id="btnReservar" type="button">
                                Generar Reserva
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para reservas -->
            <div class="modal fade" tabindex="-1" role="dialog" id="modalreservas">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Total: <span id="total_pagar">0.00</span></h3>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label>Reserva Rápida* <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="id_cliente">Cliente <span class="text-danger">*</span></label>
                                    <select id="id_cliente" name="id_cliente" class="form-control" required>
                                        <option value="">Seleccione un Cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="id_forma">Forma de Pago <span class="text-danger">*</span></label>
                                    <select id="id_forma" name="id_forma" class="form-control" required>
                                        @foreach ($formapagos as $formapago)
                                            <option value="{{ $formapago->id }}">{{ $formapago->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="id_habitacion">Habitación <span class="text-danger">*</span></label>
                                    <select id="id_habitacion" class="form-control">
                                        <option value="">Seleccione una Habitación</option>
                                        @foreach ($habitaciones as $habitacion)
                                            <option value="{{ $habitacion->id }}">Habitación #{{ $habitacion->numero }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="id_servicio">Servicio <span class="text-danger">*</span></label>
                                    <select id="id_servicio" class="form-control">
                                        <option value="">Seleccione un Servicio</option>
                                        @foreach ($servicios as $servicio)
                                            <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="fecha_inicio">Fecha de Inicio <span class="text-danger">*</span></label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_fin">Fecha de Fin <span class="text-danger">*</span></label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="pago_con">Pago con</label>
                                    <input type="number" id="pago_con" name="pago_con" class="form-control" step="0.01"
                                        min="0.01" placeholder="0.00" oninput="calcularCambio()" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="total">Total a Pagar</label>
                                    <input type="text" id="total" name="total" class="form-control"
                                        placeholder="0.00" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="cambio">Cambio</label>
                                    <input type="text" id="cambio" name="cambio" class="form-control"
                                        placeholder="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-primary" id="btnProcesar" type="button">Confirmar Reserva</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <script>
        var reservaUrl = "{{ route('admin.reservas.index') }}";
        var ticketUrl = "{{ route('admin.reservas.ticket', ['id' => ':reserva']) }}";

        document.addEventListener('DOMContentLoaded', function() {
            const btnReservar = document.querySelector('#btnReservar');
            const btnProcesar = document.querySelector('#btnProcesar');
            const total_pagar = document.querySelector('#total_pagar');
            const pago_con = document.querySelector('#pago_con');
            const total = document.getElementById('total');
            const idHabitacion = document.getElementById('id_habitacion');
            const modalReservas = new bootstrap.Modal(document.getElementById('modalreservas'));

            // Abrir modal de reservas
            if (btnReservar) {
                btnReservar.addEventListener('click', function() {
                    let total = document.getElementById('total');
                    total_pagar.textContent = total ? total.value : '0.00';
                    modalReservas.show(); // Aquí ya funcionará correctamente
                });
            }
            if (btnProcesar) {
                btnProcesar.addEventListener('click', function() {
                    // Validación inicial de campos requeridos
                    if (!id_cliente.value || !forma.value) {
                        mostrarAlerta('TODOS LOS CAMPOS CON * SON REQUERIDOS', 'warning');
                        return;
                    }

                    const montoPago = parseFloat(pago_con.value.replace(',', '')) || 0;
                    const totalPagar = parseFloat(total_pagar.textContent.replace(',', '')) || 0;

                    Swal.fire({
                        title: "Mensaje",
                        text: "¿Está seguro de procesar la reserva?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, procesar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Realizar la petición POST al backend
                            fetch(reservaUrl, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id_cliente: id_cliente.value,
                                        forma: forma.value,
                                        pago_con: montoPago,
                                        tipo_reserva: tipo_reserva.value,
                                        id_sala: id_sala.value,
                                        id_empleado: id_empleado.value,
                                        numero_mesa: numero_mesa.value
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    mostrarAlerta(data.title, data.icon);

                                    if (data.icon === 'success') {
                                        const ticketUrlFinal = ticketUrl.replace(':reserva',
                                            data.ticket);
                                        window.open(ticketUrlFinal,
                                            '_blank'); // Abrir ticket
                                        window.location.reload(); // Recargar página
                                    }
                                })
                                .catch(error => {
                                    console.error('Error al procesar la reserva: ', error);
                                    mostrarAlerta(
                                        'Ocurrió un error al procesar la reserva. Intente nuevamente.',
                                        'error');
                                });
                        }
                    });
                });
            }
        });

        function calcularCambio() {
            const pagoCon = parseFloat(document.getElementById('pago_con').value) || 0;
            const totalReservas = parseFloat(document.getElementById('total').value) || 0;
            document.getElementById('cambio').value = (pagoCon - totalReservas).toFixed(2);
        }

        function mostrarAlerta(texto, icono) {
            Swal.fire({
                showConfirmButton: false,
                title: "Respuesta",
                text: texto,
                icon: icono,
                toast: true,
                timer: 1500,
                position: "top-end",
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('habitacionSeleccionada', id => {
                document.getElementById('id_habitacion').value = id;
                console.log("Habitación seleccionada: " + id);
            });
        });
    </script>
@stop
