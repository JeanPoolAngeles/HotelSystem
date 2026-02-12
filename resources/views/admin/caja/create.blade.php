@extends('template')

@section('title', 'Abrir caja')

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <h1 class="text-center">ADMINISTRACIÓN DE APERTURA DE CAJA</h1>
        </div>
    </div>
    <div class="row mt-4">
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
                    <form method="POST" action="{{ route('admin.cajas.store') }}" role="form" autocomplete="off">
                        @csrf

                        <div class="box box-info padding-1">
                            <div class="box-body row">
                                <div class="form-group col-md-12">
                                    {{ Form::label('Monto Inicial') }}
                                    {{ Form::number('monto_inicial', $caja->monto_inicial, ['class' => 'form-control' . ($errors->has('monto_inicial') ? ' is-invalid' : ''), 'placeholder' => '0.00']) }}
                                    {!! $errors->first('monto_inicial', '<div class="invalid-feedback">:message</div>') !!}
                                </div>

                            </div>
                            <div class="box-footer mt20 text-right">
                                <a href="{{ route('admin.cajas.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
