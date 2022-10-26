@extends('adminlte::page')

@section('title', 'Personas')

@section('content_header')
    <h1>Nuevo Cliente Personal</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("personas.store") }}" method="post">
                        @csrf
                        @livewire('adm.create-persona')

                        <div class="form-group">
                            @php
                            $configu = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona el estado...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="estado" name="estado" label="Estado" label-class="text-white" :config="$configu" enable-old-support>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>

                        <div class="form-group">
                            <x-adminlte-input name="ciudad" label="Ciudad" list="datalistCiudad" enable-old-support/>
                            <x-slot name="bottomSlot">
                                @error('ciudad')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </x-slot>
                            <datalist id="datalistCiudad">
                                @foreach ($ciudades as $ciudad)
                                    <option value="{{ $ciudad->nombre }}">
                                @endforeach
                            </datalist>
                        </div>
                    
                        <div class="form-group">
                            <x-adminlte-input name="sector" label="Sector" list="datalistSector" enable-old-support/>
                            <x-slot name="bottomSlot">
                                @error('sector')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </x-slot>
                            <datalist id="datalistSector">
                                @foreach ($sectores as $sector)
                                    <option value="{{ $sector->nombre }}">
                                @endforeach
                            </datalist>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("personas.index") }}">Volver</a>
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