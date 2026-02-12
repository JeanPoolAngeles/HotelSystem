@extends('template')

@section('title', 'ADMIN-BACKUP')

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <h1 class="text-center">Copia de seguridad y restauración</h1>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <!-- Aquí puedes agregar tus enlaces y formularios para realizar la copia de seguridad y restauración -->

            <a href="{{ url('/backup') }}" id="copia_id" class="btn btn-primary">Realizar copia de seguridad</a>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('/restore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Selecciona tu base de datos, para restaurar la base de datos</label><br>
                <input type="file" name="sqlFile">
                <button id="subir_id" type="submit" class="btn btn-primary">Restaurar</button>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.getElementById('copia_id').addEventListener('click', function(event) {
            event.preventDefault(); // Evita que el enlace ejecute su acción predeterminada

            // Llama a SweetAlert para mostrar el mensaje de alerta
            Swal.fire({
                showConfirmButton: false,
                title: "BACKUP",
                text: "La copia de seguridad se ha realizado con éxito.",
                icon: "success",
                toast: true,
                timer: 1500,
                position: "top-end",
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('subir_id').addEventListener('click', function(event) {
                var inputFile = document.querySelector('input[name="sqlFile"]');
                if (inputFile.files.length === 0 || !inputFile.files[0].name.endsWith('.sql')) {
                    event.preventDefault(); // Evita que el formulario se envíe
                    Swal.fire({
                        showConfirmButton: false,
                        title: "INFORMACIÓN",
                        text: "Selecciona un archivo .sql para restaurar la base de datos",
                        icon: "warning",
                        toast: true,
                        timer: 2500,
                        position: "top-end",
                    });
                } else {
                    Swal.fire({
                        showConfirmButton: false,
                        title: "INFORMACIÓN",
                        text: "La base de datos se a restaurado!.",
                        icon: "success",
                        toast: true,
                        timer: 2500,
                        position: "top-end",
                    });
                }
            });
        });
    </script>
@stop
