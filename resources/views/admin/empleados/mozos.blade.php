@extends('template')

@section('title', 'Listado de Mozos')

@section('content')
    <div class="card mt-4 my-4">
        <div class="card-header">
            <div class="card-body text-center">
                <h1 class="text-black text-center">Listado de los mozos disponibles...</h1>
             </div>
        </div>
        <div class="card-body">
            <div class="card mt-4 md-4 sm-4 bg-light text-white">
                <div class="row">
                    @forelse ($mozos as $mozo)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white text-center">
                                    <h5>{{ $mozo->nombre }}</h5>
                                </div>
                                <div class="card-body bg-info">
                                    <p><strong>DNI:</strong> {{ $mozo->dni }}</p>
                                    <p><strong>Teléfono:</strong> {{ $mozo->telefono }}</p>
                                    <p><strong>Correo:</strong> {{ $mozo->correo ?? 'No registrado' }}</p>
                                    <p><strong>Dirección:</strong> {{ $mozo->direccion }}</p>   
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                No hay mozos disponibles en este momento.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
