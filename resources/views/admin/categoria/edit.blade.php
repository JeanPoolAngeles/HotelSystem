@extends('template')

@section('title', 'EDITAR-CATEGORIAS')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE LAS CATEGORIAS</h1>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h2>Estas editando la categoria llamada: {{ $categoria->nombre }}</h2>
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
                        <form method="POST" action="{{ route('admin.categorias.update', $categoria->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('admin.categoria.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
