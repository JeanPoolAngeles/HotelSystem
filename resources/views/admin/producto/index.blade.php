@extends('template')

@section('title', 'VISTA-PRODUCTOS')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE LOS PRODUCTOS</h1>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-header">
                        <div class="mb-2 btn-group" role="group" aria-label="Button group">
                            @can('admin.productos.create')
                                <a href="{{ route('admin.productos.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"> NUEVO PRODUCTO</i>
                                </a>
                            @endcan
                            @can('admin.productos.reportes')
                                <a href="{{ route('admin.productos.pdf') }}" target="_blank" class="btn btn-danger btn-sm">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('admin.productos.excel') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel"></i>
                                </a>
                                <a href="{{ route('admin.productos.barcode') }}" target="_blank"
                                    class="btn btn-secondary btn-sm">
                                    <i class="fas fa-barcode"></i>
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ $message }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped table-hover display responsive nowrap" width="100%"
                                    id="tblProducts">
                                    <thead class="thead">
                                        <tr>
                                            <th></th>
                                            <th>Codigo</th>
                                            <th>Producto</th>
                                            <th>P. compra</th>
                                            <th>P. venta</th>
                                            <th>Stock</th>
                                            <th>Categoria</th>
                                            <th>Foto</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
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
    <form id="toggleStatusForm" action="#" method="post">
        @csrf
        @method('PUT') <!-- valor por defecto -->
    </form>
@endsection

@section('css')
    <link href="DataTables/datatables.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="DataTables/datatables.min.js"></script>
    <script>
        var editUrl = "{{ route('admin.productos.edit', ['producto' => ':producto']) }}";
        var toggleStatusUrl = "{{ route('admin.productos.toggleStatus', ['producto' => ':producto']) }}";
        var imageUrl = "{{ asset('storage/') }}";
        document.addEventListener("DOMContentLoaded", function() {
            new DataTable('#tblProducts', {
                responsive: true,
                fixedHeader: true,
                dom: 'Pfrtip',
                searchPanes: {
                    columns: [6]
                },
                ajax: {
                    url: '{{ route('admin.products.list') }}',
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'codigo'
                    },
                    {
                        data: 'producto'
                    },
                    {
                        data: 'precio_compra'
                    },
                    {
                        data: 'precio_venta'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'categoria'
                    },
                    {
                        data: 'foto',
                        render: function(data, type, row) {
                            return data ? '<img src="' + imageUrl + '/' + data +
                                '" alt="Imagen del Producto" style="max-width: 100px; max-height: 100px;">' :
                                'Sin imagen';
                        }
                    },
                    {
                        data: 'estado',
                        render: function(data, type, row) {
                            var estados = {
                                1: {
                                    label: 'Activo',
                                    class: 'btn-success'
                                },
                                0: {
                                    label: 'Eliminado',
                                    class: 'btn-warning'
                                }
                            };
                            var estadoInfo = estados[data] || {
                                label: 'Desconocido',
                                class: ''
                            };
                            return '<span class="btn ' + estadoInfo.class + '">' + estadoInfo
                                .label + '</span>';
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var toggleButton = row.estado == 1 ?
                                `<button class="btn btn-sm btn-danger" onclick="toggleProductStatus(${row.id}, 1)"><i class="fas fa-trash"></i></button>` :
                                `<button class="btn btn-sm btn-success" onclick="toggleProductStatus(${row.id}, 0)"><i class="fas fa-undo"></i></button>`;

                            return `<a class="btn btn-sm btn-primary" href="${editUrl.replace(':producto', row.id)}"><i class="fas fa-edit"></i></a>` +
                                toggleButton;
                        }
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
                },
                order: [
                    [0, 'asc']
                ]
            });
        });

        function toggleProductStatus(productId, estadoActual) {
            var mensaje = estadoActual == 1 ? '¿Estás seguro de que quieres eliminar este producto?' :
                '¿Estás seguro de que quieres restaurar este producto?';
            var confirmButtonText = estadoActual == 1 ? 'Sí, Eliminar' : 'Sí, Restaurar';

            Swal.fire({
                title: 'Confirmación',
                text: mensaje,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.querySelector('#toggleStatusForm');
                    form.action = toggleStatusUrl.replace(':producto', productId);
                    form.submit();
                }
            });
        }
    </script>
@stop
