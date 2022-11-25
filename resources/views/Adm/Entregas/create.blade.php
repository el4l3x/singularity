@extends('adminlte::page')

@section('title', 'Notas de Entrega')

@section('content_header')
    <h1>Nueva Nota de Entrega para {{ $franquicia->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("franquicias.entregas.store", $franquicia) }}" method="post">
                        @csrf
                        
                        @livewire('adm.create-entrega', [
                            'personas' => $personas,
                            'empresas' => $empresas,
                            'productos' => $productos,
                            'servicios' => $servicios,
                        ])
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("franquicias.entregas.index", $franquicia) }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('css')
    <style>
        .btn-gray {
            background: #6c757d;
            color: white;
        }
        .gray-text {
            color: #6c757d !important;
            text-decoration: none !important;
        }
        .dt-button.dropdown-item {
            color: white !important;
        }
        .dt-button-collection {
            background: gray !important;
        }
        .dt-button.active {
            background: #6c757d !important;
        }
        div.dt-button-info {
           background: #6c757d;
        }
    </style>
@stop

@section('js')    
    <script>        

    </script>
@stop