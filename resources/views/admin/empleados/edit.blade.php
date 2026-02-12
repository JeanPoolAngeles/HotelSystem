@extends('template')

@section('title', 'EDITAR-EMPLEADO')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE LOS EMPLEADOS</h1>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header text-center">
            <h2>Estas editando al empleado: {{ $empleados->nombre }}</h2>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @if ($errors->any())
                    @foreach ($errors->all() as $item)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $item }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Empleado</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.empleados.update', $empleados->id) }}" role="form"
                            autocomplete="off">
                            {{ method_field('PATCH') }}
                            @csrf
                            @include('admin.empleados.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
