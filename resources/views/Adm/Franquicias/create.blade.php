@extends('adminlte::page')

@section('title', 'Franquicias')

@section('content_header')
    <h1>Nueva Franquicia</h1>
@stop

@section('content')
    {{-- @livewire('security.logs-index') --}}
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("franquicias.store") }}" method="post">
                        @csrf
                        <div class="form-group">
                            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support>
                                <x-slot name="bottomSlot">
                                    @error('nombre')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        
                        <div class="form-group">
                            <x-adminlte-input name="actividad" label="Actividad Economica" placeholder="" enable-old-support>
                                <x-slot name="bottomSlot">
                                    @error('actividad')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        
                        <div class="form-group">
                            <x-adminlte-input name="rif" label="RIF" placeholder="" enable-old-support maxlength="9">
                                <x-slot name="bottomSlot">
                                    @error('rif')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <div class="form-group">
                            @php
                            $configu = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona los usuarios...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="usuarios" name="usuarios[]" label="Usuarios a cargo" label-class="text-white" :config="$configu" multiple enable-old-support>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                </x-slot>

                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach

                            </x-adminlte-select2>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("franquicias.index") }}">Volver</a>
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