@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <h1>Nuevo Cliente Empresarial</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("empresas.store") }}" method="post">
                        @csrf

                        <h5>Datos de la Empresa</h5>
                        <hr>

                        <div class="row">
                            <x-adminlte-input name="rif" label="RIF" placeholder="" enable-old-support maxlength="9" fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                <x-slot name="prependSlot">
                                    <select name="tipo" class="form-control">
                                        <option value="j">J</option>
                                        <option value="g">G</option>
                                    </select>
                                </x-slot>
                                <x-slot name="bottomSlot">
                                    @error('cedula')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        {{-- </div>
                    
                        <div class="form-group"> --}}
                            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                <x-slot name="bottomSlot">
                                    @error('nombre')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                    
                        <div class="row">
                    
                            <x-adminlte-input name="telefono" label="Telefono" placeholder="" enable-old-support maxlength="7" fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                <x-slot name="prependSlot">
                                    <x-adminlte-select name="codigo">
                                        <option value="0414">0414</option>
                                        <option value="0424">0424</option>
                                        <option value="0412">0412</option>
                                        <option value="0416">0416</option>
                                        <option value="0426">0426</option>
                                    </x-adminlte-select>
                                </x-slot>
                                <x-slot name="bottomSlot">
                                    @error('telefono')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                    
                        </div>

                        <h5>Direccion</h5>
                        <hr>

                        <div class="row">
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
                            <x-adminlte-select2 id="estado" name="estado" label="Estado" label-class="text-white" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </x-adminlte-select2>
                        {{-- </div>

                        <div class="form-group"> --}}
                            <x-adminlte-input name="ciudad" label="Ciudad" list="datalistCiudad" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12"/>
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