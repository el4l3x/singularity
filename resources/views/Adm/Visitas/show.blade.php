@extends('adminlte::page')

@section('title', 'Visitas')

@section('content_header')
    <h1>Hoja de Visita {{ $visita->slug }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-8 col-sm-12">

                        Cliente: {{ $visita->visitable->nombre }}

                </div>
                
                <div class="col-md-2 col-sm-6">

                        H. Entrada: {{ $visita->entrada }}

                </div>
                
                <div class="col-md-2 col-sm-6">

                        H. Salida: {{ $visita->salida }}

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                    Productos Instalados:
                    @foreach ($visita->productos as $producto)
                        @if ($loop->last)
                            {{ $producto->nombre }}.
                        @else
                            {{ $producto->nombre }} -
                        @endif
                    @endforeach
                </div>
                
                <div class="col-md-6 col-sm-12">
                    Servicios Aplicados:
                    @foreach ($visita->servicios as $servicios)
                        @if ($loop->last)
                            {{ $servicios->nombre }}.
                        @else
                            {{ $servicios->nombre }} -
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    Observaciones:
                    <br>
                    <p>
                        {{ $visita->descripcion }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('franquicias.visitas.index', $visita->franquicia) }}" class="btn btn-gray">Volver</a>
                </div>
            </div>

        </div>
    </div>

@stop

@section('css')
    <style>
        .btn-gray {
            background: #6c757d;
            color: white;
        }
    </style>
@stop

@section('js')    
    <script>        

    </script>
@stop