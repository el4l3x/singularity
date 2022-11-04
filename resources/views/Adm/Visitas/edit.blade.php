@extends('adminlte::page')

@section('title', 'Visitas')

@section('content_header')
    <h1>Editar Visita {{ $visita->slug }} a {{ $visita->visitable->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("visitas.update", $visita) }}" method="post">
                        @method('PUT')
                        @csrf

                        <div class="row">

                            @php
                                $config = ['format' => 'HH:mm'];
                            @endphp
                            <x-adminlte-input-date name="entrada" :config="$config" enable-old-support label="Hora de Entrada" fgroup-class="col-lg-6 col-md-6 col-sm-12" value="{{ $visita->entrada }}">
                                <x-slot name="bottomSlot">
                                    @error('entrada')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>

                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                            
                            @php
                                $config = ['format' => 'HH:mm'];
                            @endphp
                            <x-adminlte-input-date name="salida" :config="$config" enable-old-support label="Hora de Salida" fgroup-class="col-lg-6 col-md-6 col-sm-12" value="{{ $visita->salida }}">
                                <x-slot name="bottomSlot">
                                    @error('salida')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>

                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>

                        </div>

                        <div class="row">
                            @php
                            $configu = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona los productos...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="productos" name="productos[]" label="Productos" label-class="text-white" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12" multiple>
                                @if ($visita->productos->count() < 1)
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                    @endforeach
                                @else
                                    @foreach ($productos as $producto)
                                        @php
                                            $breed = false;
                                        @endphp
                                        @foreach ($visita->productos as $visitap)
                                            @if ($visitap->pivot->visitable_id == $producto->id)
                                                <option value="{{ $producto->id }}" selected>{{ $producto->nombre }}</option>
                                                @php
                                                    $breed = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (!$breed)
                                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>                                            
                                        @endif
                                    @endforeach
                                @endif

                            </x-adminlte-select2>
                            
                            @php
                            $configu = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona los servicios...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="servicios" name="servicios[]" label="Servicios" label-class="text-white" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12" multiple>                                

                                @if ($visita->servicios->count() < 1)
                                    @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                    @endforeach
                                @else
                                    @foreach ($servicios as $servicio)
                                        @php
                                            $breed = false;
                                        @endphp
                                        @foreach ($visita->servicios as $visitas)
                                            @if ($visitas->pivot->visitable_id == $servicio->id)
                                                <option value="{{ $servicio->id }}" selected>{{ $servicio->nombre }}</option>
                                                @php
                                                    $breed = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (!$breed)
                                            <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>                                            
                                        @endif
                                    @endforeach
                                @endif

                            </x-adminlte-select2>

                        </div>

                        <div class="row">
                            <x-adminlte-textarea name="descripcion" label="Observaciones" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                <x-slot name="bottomSlot">
                                    @error('descripcion')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-textarea>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("franquicias.visitas.index", $visita->franquicia) }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)

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