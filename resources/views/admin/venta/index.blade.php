@extends('template')

@section('title', 'ADMIN-VENTA')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE NUEVAS VENTAS</h1>
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
    <div class="card mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    @can('admin.cajas.index')
                        <div class="mb-1">
                            <a href="{{ route('admin.cajas.index') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-funnel-dollar"></i> {{ __('Caja') }}
                            </a>
                            <a href="{{ route('admin.venta.show') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-list"></i> {{ __('Listar ventas') }}
                            </a>
                        </div>
                    @endcan
                    <div class="card">
                        <div class="card-body">
                            @livewire('product-list')
                        </div>
                        <div class="card-footer d-flex justify-content-end gap-2">
                            <button class="btn btn-primary fixed-button mt-4" id="btnVenta" type="button">Generar
                                Venta</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalVenta">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title">
                                <h3>Total: <span id="total_pagar">0.00</span></h3>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label>Venta Rapida*<span class="text-danger">*</span></label>
                            <div class="row">

                                <div class="col-md-8 mb-2">
                                    <label for="id_cliente">Clientes <span class="text-danger">*</span></label>
                                    <select id="id_cliente" class="form-control">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <span id="errorBusqueda" class="text-danger"></span>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <div class="input-group">
                                        <label for="forma">Habitaciones <span class="text-danger">*</span></label>
                                        <select id="forma" class="form-control">
                                            @foreach ($habitaciones as $habitacion)
                                                <option value="{{ $habitacion->id }}">{{ $habitacion->slug }} |
                                                    {{ $habitacion->numero }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span id="errorBusqueda" class="text-danger"></span>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="forma">Forma Pago <span class="text-danger">*</span></label>
                                    <select id="forma" class="form-control">
                                        @foreach ($formapagos as $formapago)
                                            <option value="{{ $formapago->id }}">{{ $formapago->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="tipo_venta">Tipo de Venta <span class="text-danger">*</span></label>
                                    <select id="tipo_venta" class="form-control">
                                        @can('admin.venta.final.caja')
                                            <option value="para_llevar">Para Llevar</option>
                                        @endcan
                                        @can('admin.venta.edit.mozo')
                                            <option value="">Seleccione una opción</option>
                                            <option value="para_mesa">Para Mesa</option>
                                        @endcan
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="pago_con">Pago con</label>
                                    <input id="pago_con" class="form-control" type="number" step="0.01" min="0.01"
                                        placeholder="0.00" oninput="calcularCambio()">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="cambio">Cambio</label>
                                    <input id="cambio" class="form-control" type="text" placeholder="0.00" disabled>
                                </div>
                            </div>
                            <!-- Modal de selección de sala -->
                            <div id="panelSalas" class="modal fade" tabindex="-2" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Selecciona una Sala</h3>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido para seleccionar sala -->
                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de selección de empleado -->
                            <div id="panelEmpleados" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Selecciona un Empleado</h3>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido para seleccionar empleado -->
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de selección de mesa -->
                            <div id="panelMesas" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Selecciona una Mesa</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido para seleccionar mesa -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Campos ocultos para datos de la mesa -->
                            <input id="id_sala" type="hidden" name="id_sala" value="">
                            <input id="id_empleado" type="hidden" name="id_empleado" value="">
                            <input id="numero_mesa" type="hidden" name="numero_mesa" value="">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                            <button class="btn btn-primary" id="btnProcesar" type="button">Completar</button>
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

    <style>
        /* Ajustes para botones y tarjetas */
        @media (max-width: 768px) {
            .fixed-button {
                width: 100%;
            }

            .btn {
                font-size: 0.9rem;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <script>
        var ventaUrl = "{{ route('admin.venta.index') }}";
        var ticketUrl = "{{ route('admin.venta.ticket', ['id' => ':venta']) }}";
        var cocinaUrl = "{{ route('admin.venta.cocina', ['id' => ':venta']) }}";
        const btnVenta = document.querySelector('#btnVenta');
        const btnProcesar = document.querySelector('#btnProcesar');
        const total_pagar = document.querySelector('#total_pagar');
        const pago_con = document.querySelector('#pago_con');
        const total = document.querySelector('#total');
        const tipoVenta = document.querySelector('#tipo_venta');
        const modalSala = document.querySelector('#panelSalas');
        const modalEmpleado = document.querySelector('#panelEmpleados');
        const modalMesa = document.querySelector('#panelMesas');
        const pagoCon = document.querySelector('#pago_con'); // El campo Pago con

        document.addEventListener('DOMContentLoaded', function() {

            // Verifica que los elementos existen antes de usar Bootstrap.Modal
            if (tipoVenta && modalSala && modalEmpleado && modalMesa) {
                const modalSalaInstance = new bootstrap.Modal(modalSala);
                const modalEmpleadoInstance = new bootstrap.Modal(modalEmpleado);
                const modalMesaInstance = new bootstrap.Modal(modalMesa);


                tipoVenta.addEventListener('change', function() {
                    if (this.value === 'para_mesa') {
                        modalSalaInstance.show();
                        pagoCon.disabled = true; // Deshabilita el campo
                    } else {
                        if (this.value === 'para_llevar') {
                            pagoCon.disabled = false; // Habilita el campo si no es para_mesa
                        }
                    }
                });

                function cargarSalas() {
                    fetch("{{ route('admin.salas.list') }}")
                        .then(response => response.json())
                        .then(data => {
                            const panelSalas = document.querySelector('#panelSalas .modal-body');
                            panelSalas.innerHTML = ''; // Limpiar contenido previo

                            if (data.length === 0) {
                                panelSalas.textContent = 'No hay salas disponibles';
                                return;
                            }

                            data.forEach(sala => {
                                const boton = document.createElement('button');
                                boton.className = 'btn btn-primary m-2';
                                const img = document.createElement('img');
                                img.src =
                                    "{{ asset('img/salas.png') }}"; // Ruta a la imagen de la mesa
                                img.alt = 'salas';
                                img.className = 'me-2'; // Margen derecho a la imagen
                                img.style.width =
                                    '80px'; // Ajusta el tamaño de la imagen según sea necesario

                                const spanText = document.createElement('span');
                                spanText.textContent = `${sala.nombre}`;

                                boton.appendChild(img);
                                boton.appendChild(spanText);

                                boton.addEventListener('click', function() {
                                    cargarEmpleados(sala.id);
                                    modalSalaInstance.hide();
                                    modalEmpleadoInstance.show();
                                });
                                panelSalas.appendChild(boton);
                            });
                        })
                        .catch(error => console.error('Error al cargar salas:', error));
                }

                function cargarEmpleados(idSala) {
                    fetch("{{ route('admin.empleados.list') }}")
                        .then(response => response.json())
                        .then(data => {
                            const panelEmpleados = document.querySelector('#panelEmpleados .modal-body');
                            panelEmpleados.innerHTML = ''; // Limpiar contenido previo

                            if (data.length === 0) {
                                panelEmpleados.textContent = 'No hay empleados disponibles';
                                return;
                            }

                            data.forEach(empleado => {
                                const boton = document.createElement('button');
                                boton.className = 'btn btn-success m-2';
                                // Crear elementos de imagen y texto
                                const img = document.createElement('img');
                                img.src = "{{ asset('img/users.png') }}";
                                img.alt = 'Mesa';
                                img.className = 'me-2';
                                img.style.width = '150px';

                                const spanText = document.createElement('span');
                                spanText.textContent = `Nombre: ° ${empleado.nombre}`;

                                boton.appendChild(img);
                                boton.appendChild(spanText);

                                boton.addEventListener('click', function() {
                                    cargarMesas(idSala, empleado.id);
                                    modalEmpleadoInstance.hide();
                                    modalMesaInstance.show();
                                });
                                panelEmpleados.appendChild(boton);
                            });
                        })
                        .catch(error => console.error('Error al cargar empleados:', error));
                }

                function cargarMesas(idSala, idEmpleado) {
                    fetch(`/mesas/${idSala}`)
                        .then(response => response.json())
                        .then(data => {
                            const panelMesas = document.querySelector('#panelMesas .modal-body');
                            panelMesas.innerHTML = ''; // Limpiar contenido previo

                            data.forEach(mesa => {
                                const boton = document.createElement('button');
                                boton.className = 'btn m-2';

                                // Establecer la clase según el estado de la mesa
                                if (mesa.estado === 'OCUPADO') {
                                    boton.className += ' btn-danger';
                                    boton.disabled = true; // Desactivar botón si la mesa está ocupada
                                } else {
                                    boton.className += ' btn-success';
                                }

                                // Crear elementos de imagen y texto
                                const img = document.createElement('img');
                                img.src = "{{ asset('img/mesa.png') }}";
                                img.alt = 'Mesa';
                                img.className = 'me-2';
                                img.style.width = '50px';

                                const spanText = document.createElement('span');
                                spanText.textContent = `Mesa N° ${mesa.numero_mesa}`;

                                boton.appendChild(img);
                                boton.appendChild(spanText);

                                // Event listener para seleccionar mesa
                                boton.addEventListener('click', function() {
                                    if (mesa.estado !== 'OCUPADO') {
                                        seleccionarMesa(idSala, idEmpleado, mesa.numero_mesa);
                                        modalMesaInstance.hide();
                                        Swal.fire({
                                            title: 'Mesa Disponible',
                                            text: 'Esta mesa está disponible para uso.',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });

                                panelMesas.appendChild(boton);
                            });
                        })
                        .catch(error => console.error('Error al cargar mesas:', error));
                }

                function seleccionarMesa(idSala, idEmpleado, numeroMesa) {
                    idSalaSeleccionada = idSala;
                    idEmpleadoSeleccionado = idEmpleado;
                    numeroMesaSeleccionada = numeroMesa;

                    // Actualiza los campos ocultos
                    document.querySelector('#id_sala').value = idSalaSeleccionada;
                    document.querySelector('#id_empleado').value = idEmpleadoSeleccionado;
                    document.querySelector('#numero_mesa').value = numeroMesaSeleccionada;

                    console.log(id_sala, id_empleado, numero_mesa);
                }

                // Inicializar la carga de salas
                cargarSalas();

            } else {
                console.error('Uno o más elementos no están presentes en el DOM.');
            }

            btnVenta.addEventListener('click', function() {
                total_pagar.textContent = total.value;
                $('#modalVenta').modal('show');
            });

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
                    text: "¿Está seguro de procesar la venta?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, procesar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Realizar la petición POST al backend
                        fetch(ventaUrl, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    id_cliente: id_cliente.value,
                                    forma: forma.value,
                                    pago_con: montoPago,
                                    tipo_venta: tipo_venta.value,
                                    id_sala: id_sala.value,
                                    id_empleado: id_empleado.value,
                                    numero_mesa: numero_mesa.value
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                mostrarAlerta(data.title, data.icon);

                                if (data.icon === 'success') {
                                    // Manejar la lógica según el tipo de venta
                                    switch (tipo_venta.value) {
                                        case 'para_llevar':
                                            if (!pago_con.value) {
                                                mostrarAlerta('EL MONTO DE PAGO ES REQUERIDO',
                                                    'warning');
                                                return;
                                            }
                                            const ticketUrlFinal = ticketUrl.replace(':venta',
                                                data.ticket);
                                            window.open(ticketUrlFinal,
                                                '_blank'); // Abrir ticket
                                            window.location.reload(); // Recargar página
                                            break;

                                        case 'para_mesa':
                                            window.location.href =
                                                "{{ route('admin.salas.index') }}";
                                            break;

                                        default:
                                            console.warn('Tipo de venta no manejado:',
                                                tipo_venta.value);
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('Error al procesar la venta: ', error);
                                mostrarAlerta(
                                    'Ocurrió un error al procesar la venta. Intente nuevamente.',
                                    'error');
                            });
                    }
                });
            });
        });

        function calcularCambio() {
            var pagoCon = parseFloat(pago_con.value.replace(',', '')) || 0; // Reemplaza comas por puntos
            var totalVenta = parseFloat(total.value.replace(',', '')) || 0;

            if (!isNaN(pagoCon) && !isNaN(totalVenta)) {
                var cambio = pagoCon - totalVenta;
                document.getElementById('cambio').value = cambio.toFixed(2);
            } else {
                document.getElementById('cambio').value = '0.00';
            }
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
@stop
