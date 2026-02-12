@extends('template')

@section('title', 'EDITAR-GASTOS')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE LOS GASTOS</h1>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <div class="card-header">
                <h2>Estas editando el gasto: {{ $gasto->descripcion }}</h2>
            </div>
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
                        <span class="card-title">{{ __('Update') }} Gasto</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.gastos.update', $gasto->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('admin.gastos.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
