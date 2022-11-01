@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Editar Producto {{ $producto->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("productos.update", $producto) }}" method="post">
                        @method('PUT')
                        @csrf

                        <div class="row">

                            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12" value="{{ $producto->nombre }}">
                                <x-slot name="bottomSlot">
                                    @error('nombre')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                            
                            <x-adminlte-input name="precio" label="Precio" placeholder="" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12" value="{{ $producto->precio }}">
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
                            <x-adminlte-select2 id="etiquetas" name="etiquetas[]" label="Estado" label-class="text-white" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12" multiple>
                                @if ($producto->tags->count() < 1)
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->nombre }}</option>
                                    @endforeach
                                @else
                                    @foreach ($tags as $tag)
                                        @php
                                            $breed = false;
                                        @endphp
                                        @foreach ($producto->tags as $productot)
                                            @if ($productot->pivot->tag_id == $tag->id)
                                                <option value="{{ $tag->id }}" selected>{{ $tag->nombre }}</option>
                                                @php
                                                    $breed = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (!$breed)
                                            <option value="{{ $tag->id }}">{{ $tag->nombre }}</option>                                            
                                        @endif
                                    @endforeach
                                @endif
                            </x-adminlte-select2>

                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("productos.index") }}">Volver</a>
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