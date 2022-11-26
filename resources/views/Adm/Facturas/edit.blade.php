@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
    <h1>Editar Factura {{ $factura->slug }} a {{ $factura->facturable->nombre }}</h1>
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

                    <form action="{{ route("facturas.update", $factura) }}" method="post">
                        @method('PUT')
                        @csrf

                        <div class="row">

                            @php
                                $config = [
                                    "title" => "Selecciona la franquicia",
                                    "liveSearch" => true,
                                    "liveSearchPlaceholder" => "Buscar...",
                                    "showTick" => true,
                                    "actionsBox" => true,
                                ];
                            @endphp
                            <x-adminlte-select-bs name="franquicia" id="franquicia" :config="$config" label="Franquicia" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12" data-style="btn-dark">
                                @foreach ($franquicias as $franquicia)
                                    @if ($factura->franquicia_id == $franquicia->id)
                                        <option value="{{ $franquicia->id }}" selected>{{ $franquicia->nombre }}</option>
                                    @else
                                    <option value="{{ $franquicia->id }}">{{ $franquicia->nombre }}</option>
                                    @endif
                                @endforeach
                            </x-adminlte-select-bs>

                            @php
                                $config = ['format' => 'DD-MM-YYYY'];
                            @endphp
                            <x-adminlte-input-date name="fecha" :config="$config" enable-old-support label="Fecha" fgroup-class="col-lg-6 col-md-6 col-sm-12" value="{{ $factura->updated_at }}">
                                <x-slot name="bottomSlot">
                                    @error('fecha')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>

                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>

                        </div>

                        @livewire('exp.select-cliente', [
                            'observaciones' => $factura->observaciones,
                            'cliente' => $factura->facturable,
                            'clienteT' => $factura->facturable_type,
                        ])

                        @livewire('exp.cart-venta', [
                            'data' => $factura,
                        ])
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("franquicias.facturas.index", $factura->franquicia) }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.BootstrapSelect', true)

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