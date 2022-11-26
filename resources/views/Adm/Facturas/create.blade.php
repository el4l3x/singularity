@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
    <h1>Nueva Factura para {{ $franquicia->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("franquicias.facturas.store", $franquicia) }}" method="post">
                        @csrf
                        
                        @livewire('exp.select-cliente')

                        @livewire('exp.cart-venta')
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("franquicias.facturas.index", $franquicia) }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('plugins.Select2', true)
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