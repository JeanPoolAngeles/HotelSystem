@extends('template')

@section('title', 'EDITAR-PRODUCTOS')

@section('content_header')
    <div class="card">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE LOS PRODUCTOS</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h2>Estas editando el producto: {{ $producto->producto }}</h2>
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
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.productos.update', $producto->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            @csrf

                            @include('admin.producto.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
