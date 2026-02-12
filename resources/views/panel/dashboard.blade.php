@extends('template')

@section('title', 'Dashboard')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    @if (session('success'))
        <script>
            let message = "{{ session('success') }}";
            Swal.fire(message);
        </script>
    @endif
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">PANEL DE VISTA</h1>
        <div class="row mt-4">
            <div class="col-xl-3 col-md-12">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fas fa-store"></i><span>NUEVA VENTA</span>
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('admin.venta.index') }}"></a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @can('admin.clientes.index')
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-people-group"></i><span>Clientes</span>
                            </div>
                            <div class="col-4">
                                {{ $totales['clients'] }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('admin.clientes.index') }}">Ver Más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endcan
            @can('admin.productos.index')
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fas fa-fw fa-box"></i><span>Productos</span>
                            </div>
                            <div class="col-4">
                                {{ $totales['products'] }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('admin.productos.index') }}">Ver Más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endcan
            @can('admin.categorias.index')
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fa-solid fa-tag"></i><span>Categorias</span>
                            </div>
                            <div class="col-4">
                                {{ $totales['categorias'] }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('admin.categorias.index') }}">Ver Más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endcan
            @can('admin.gastos.index')
            <div class="col-xl-3 col-md-6">
                <div class="card bg-dark text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fas fa-dollar-sign"></i><span>Gastos</span>
                            </div>
                            <div class="col-4">
                                {{ $totales['gastos'] }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('admin.gastos.index') }}">Ver Más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endcan
            @can('admin.compra.show')
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fas fa-store"></i><span>Compras</span>
                            </div>
                            <div class="col-4">
                                {{ number_format($montosTotal['compras'], 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('admin.compra.show') }}">Ver Más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endcan
            @can('admin.venta.show')
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <i class="fas fa-shopping-cart"></i><span>Ventas</span>
                            </div>
                            <div class="col-4">
                                {{ number_format($montosTotal['ventas'], 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('admin.venta.show') }}">Ver Más</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endcan
        </div>
        @can('admin.cajas.index')
        <div class="row">
            @if ($ventasPorSemana || $comprasPorSemana)
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Compras y Ventas por Semana</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="ventasPorSemana" width="804" height="375"
                                class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            @endif

            @if ($ventas || $compras)
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Compras y Ventas por Mes</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="ventasPorMes" width="804" height="375" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <br>
                <br>
                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
        @endcan
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Productos con Stock Bajo'
                },
                xAxis: {
                    categories: {!! json_encode($productos->pluck('producto')) !!}
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Stock'
                    }
                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                        stacking: 'normal'
                    }
                },
                series: [{
                    name: 'Stock',
                    data: {!! json_encode($productos->pluck('stock')) !!}
                }]
            });

            if (document.getElementById('ventasPorSemana')) {
                ventasSemana()
            }

            //ventas
            var dataVenta = @json($ventas);
            var dataCompra = @json($compras);

            // Verifica si hay datos de ventas o compras
            var hayDatosVenta = dataVenta && Object.keys(dataVenta).length > 0;
            var hayDatosCompra = dataCompra && Object.keys(dataCompra).length > 0;

            if (hayDatosVenta || hayDatosCompra) {
                var ctx = document.getElementById('ventasPorMes').getContext('2d');
                var datasets = [];

                // Sales data
                if (hayDatosVenta) {
                    Object.keys(dataVenta).forEach(function(year, index) {
                        datasets.push({
                            label: 'Ventas ' + year,
                            data: Object.values(dataVenta[year]),
                            backgroundColor: 'rgb(99, 237, 122)',
                            borderWidth: 1
                        });
                    });
                }

                // Purchases data
                if (hayDatosCompra) {
                    Object.keys(dataCompra).forEach(function(year, index) {
                        datasets.push({
                            label: 'Compras ' + year,
                            data: Object.values(dataCompra[year]),
                            backgroundColor: 'rgb(103, 119, 239)',
                            borderWidth: 1
                        });
                    });
                }

                var labels = hayDatosVenta ? Object.keys(dataVenta[Object.keys(dataVenta)[0]]) : (hayDatosCompra ?
                    Object.keys(
                        dataCompra[Object.keys(dataCompra)[0]]) : []);

                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                // Si no hay datos, puedes realizar alguna acción de manejo de error o simplemente mostrar un mensaje
                console.log('No hay datos disponibles para mostrar el gráfico.');
            }
        });

        function ventasSemana() {
            var ctx = document.getElementById('ventasPorSemana').getContext('2d');

            var ventasData = {!! json_encode($ventasPorSemana) !!};
            var comprasData = {!! json_encode($comprasPorSemana) !!};

            var labels = ventasData.map(function(item) {
                return item.diaEnEspanol;
            });

            var ventasValores = ventasData.map(function(item) {
                return item.total;
            });

            var comprasValores = comprasData.map(function(item) {
                return item.total;
            });

            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Ventas por semana',
                            data: ventasValores,
                            backgroundColor: 'rgb(99, 237, 122)',
                            borderColor: 'rgb(99, 237, 122)',
                            borderWidth: 1
                        },
                        {
                            label: 'Compras por semana',
                            data: comprasValores,
                            backgroundColor: 'rgb(103, 119, 239)',
                            borderColor: 'rgb(103, 119, 239)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endsection
