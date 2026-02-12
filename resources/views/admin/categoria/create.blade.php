@extends('template')

@section('title', 'CREAR-CATEGORIA')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE LAS NUEVAS CATEGORIAS</h1>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <div class="row">
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
                            <form method="POST" action="{{ route('admin.categorias.store') }}" role="form"
                                autocomplete="off">
                                @csrf

                                @include('admin.categoria.form')

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
