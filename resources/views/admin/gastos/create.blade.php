@extends('template')

@section('title', 'CREAR-GASTO')

@section('content')
    <div class="card mt-4">
        <div class="card-body text-center">
            <h1>ADMINISTRACIÓN DE LOS GASTOS</h1>
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
                            @if ($message = Session::get('error'))
                                <div class="alert fade_error .fade">
                                    <button aria-hidden="true" data-dismiss="alert" class="close"
                                        type="button">&times;</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('admin.gastos.store') }}" role="form"
                                autocomplete="off" enctype="multipart/form-data">
                                @csrf

                                @include('admin.gastos.form')

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
