<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Hotel System - reportes" />
    <meta name="author" content="Jean Pool" />
    <title>Hotel System - @yield('title')</title>

    <!-- Bootstrap CSS -->
     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle (Popper.js incluido) -->

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet" />

    <!-- jQuery UI CSS (opcional, si lo necesitas) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
    @livewireStyles
    @yield('css')
</head>

<body class="sb-nav-fixed">

    <x-navigation-header />
    <div id="layoutSidenav">
        <x-navigation-menu />

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <x-navigation-menu />
            <x-navigation-footer />
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- jQuery UI (si lo necesitas) -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Otros scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js')
    @livewireScripts
</body>

</html>
