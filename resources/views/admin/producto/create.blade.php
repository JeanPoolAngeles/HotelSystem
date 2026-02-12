@extends('template')

@section('title', 'CREAR-PRODUCTO')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE LOS PRODUCTOS</h1>
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
                            <form method="POST" action="{{ route('admin.productos.store') }}" role="form"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                @include('admin.producto.form')

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
