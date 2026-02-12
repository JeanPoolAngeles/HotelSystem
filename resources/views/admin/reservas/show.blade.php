@extends('template')

@section('title', 'LISTAR-VENTAS')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE HISTORIAL DE VENTAS</h1>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    @can('admin.venta.reportes')
                        <div class="mb-2">
                            <a href="{{ route('admin.venta.reportPdf') }}" class="btn btn-danger btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                            <a href="{{ route('admin.venta.reportExcel') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Excel
                            </a>
                        </div>
                    @endcan
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover display responsive nowrap" width="100%"
                                    id="tblVentas">
                                    <thead class="thead">
                                        <tr>
                                            <th>Id</th>
                                            <th>Monto</th>
                                            <th>Cliente</th>
                                            <th>Tipo de Venta</th>
                                            <th>Forma Pago</th>
                                            <th>Fecha/Hora</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <form id="deleteForm" action="#" method="post">
        @csrf
        @method('PUT')
    </form>
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
    <style>
        .dt-buttons button {
            background: lightgray;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        var ticketUrl = "{{ route('admin.venta.ticket', ['id' => ':venta']) }}";
        var anularUrl = "{{ route('admin.venta.anular', ['id' => ':venta']) }}";
        var cocinaUrl = "{{ route('admin.venta.cocina', ['id' => ':venta']) }}";
        document.addEventListener("DOMContentLoaded", function() {
            new DataTable('#tblVentas', {
                responsive: true,
                ajax: {
                    url: '{{ route('admin.sales.list') }}',
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'cliente'
                    },
                    {
                        data: 'tipo_venta'
                    },
                    {
                        data: 'formapago'
                    },
                    {
                        // Agregar columna para acciones
                        data: 'created_at',
                        render: function(data, type, row, meta) {
                            if (type === 'display') {
                                // Formatear la fecha en el formato deseado
                                return new Date(data).toLocaleString();
                            }
                            return data;
                        }
                    },
                    {
                        // Agregar columna para acciones
                        data: null,
                        render: function(data, type, row) {
                            // Agregar botones de editar y eliminar
                            return `<a class="btn btn-sm btn-danger" target="_blank" href="${ticketUrl.replace(':venta', row.id)}"><i class="fas fa-print"></i></a>` +
                                `<a class="btn btn-sm btn-warning" onclick="anularVenta(${row.id})" href="#"><i class="fas fa-trash"></i></a>` +
                                `<a class="btn btn-sm btn-success" target="_blank" href="${cocinaUrl.replace(':venta', row.id)}"><i class="fas fa-print"></i></a>`;
                        }

                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
                },
                dom: "<'row'<'col-sm-12 text-center'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'>,'PQlfrtip' ",
                buttons: [{
                        //Botón para Excel
                        extend: 'excelHtml5',
                        footer: true,
                        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
                    },
                    //Botón para PDF
                    {
                        extend: 'pdfHtml5',
                        download: 'open',
                        footer: true,
                        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    //Botón para print
                    {
                        extend: 'print',
                        footer: true,
                        text: '<span class="badge bg-purple"><i class="fas fa-print"></i></span>'
                    },
                    //Botón para cvs
                    {
                        extend: 'csvHtml5',
                        footer: true,
                        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
                    },
                    {
                        extend: 'colvis',
                        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
                        postfixButtons: ['colvisRestore']
                    },
                ],
                searchPanes: {
                    columns: [3, 4]
                },
                order: [
                    [0, 'desc']
                ]
            });
        });

        function anularVenta(ventaId) {
            Swal.fire({
                title: "Anular",
                text: "¿Estás seguro de anular la venta?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, anular!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.querySelector('#deleteForm');
                    form.action = anularUrl.replace(':venta', ventaId);
                    // Enviar el formulario
                    form.submit();
                }
            });
        }
    </script>
@endsection
