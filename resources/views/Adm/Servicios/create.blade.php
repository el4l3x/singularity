@extends('adminlte::page')

@section('title', 'Servicios')

@section('content_header')
    <h1>Nuevo Servicio</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("servicios.store") }}" method="post">
                        @csrf

                        <div class="row">
                            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                <x-slot name="bottomSlot">
                                    @error('nombre')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        
                            <x-adminlte-input name="precio" label="Precio" placeholder="" enable-old-support maxlength="9" fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                <x-slot name="bottomSlot">
                                    @error('precio')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                    
                        <div class="row">
                    
                            @php
                            $configu = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona las etiquetas...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="etiquetas" name="etiquetas[]" label="Etiquetas" label-class="text-white" :config="$configu" multiple enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text" title="Nueva Etiqueta" role="button">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </x-slot>

                                <x-slot name="bottomSlot">
                                    @error('etiquetas')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>

                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->nombre }}</option>
                                @endforeach

                            </x-adminlte-select2>
                    
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("servicios.index") }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('plugins.Select2', true)

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