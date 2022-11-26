@extends('adminlte::page')

@section('title', 'Presupuestos')

@section('content_header')
    <h1>Presupuesto {{ $presupuesto->slug }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-6 col-sm-12">

                        Cliente: {{ $presupuesto->presupuestoable->nombre }}

                </div>
                
                <div class="col-md-3 col-sm-6">

                        Fecha: {{ $presupuesto->updated_at }}

                </div>
                
                <div class="col-md-3 col-sm-6">

                        Total: {{ $presupuesto->total }}

                </div>
        
            </div>

            <div class="row mb-3 table-responsive">

                <table class="table table-dark table-hover table-sm">
                    <thead>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Sub Total</th>
                    </thead>
        
                    <tbody>
                        @foreach ($presupuesto->productos as $itemP)
                            <tr>
                                <td>
                                    {{ $itemP->nombre }}
                                </td>
                                <td>
                                    {{ $itemP->pivot->descripcion }}
                                </td>
                                <td>
                                    {{ number_format($itemP->pivot->precio, 2, ",", ".") }}
                                </td>
                                <td>
                                    {{ $itemP->pivot->cantidad }}
                                </td>
                                <td>
                                    {{ $itemP->pivot->precio*$itemP->pivot->cantidad }}
                                </td>
                            </tr>
                        @endforeach
                        
                        @foreach ($presupuesto->servicios as $itemS)
                            <tr>
                                <td>
                                    {{ $itemS->nombre }}
                                </td>
                                <td>
                                    {{ $itemS->pivot->descripcion }}
                                </td>
                                <td>
                                    {{ number_format($itemS->pivot->precio, 2, ",", ".") }}
                                </td>
                                <td>
                                    {{ $itemS->pivot->cantidad }}
                                </td>
                                <td>
                                    {{ $itemS->pivot->precio*$itemS->pivot->cantidad }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    Observaciones:
                    <br>
                    <p>
                        {{ $presupuesto->observaciones }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('franquicias.presupuestos.index', $presupuesto->franquicia) }}" class="btn btn-gray">Volver</a>
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