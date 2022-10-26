@extends('adminlte::page')

@section('title', 'Personas')

@section('content_header')
    <h1>Editar Persona {{ $persona->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("personas.update", $persona) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <x-adminlte-input name="nombre" label="Nombre" placeholder="" value="{{ $persona->nombre }}" enable-old-support>
                                <x-slot name="bottomSlot">
                                    @error('nombre')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                    
                        <div class="form-group">
                            <x-adminlte-input name="apellido" label="Apellido" placeholder="" value="{{ $persona->apellido }}" enable-old-support>
                                <x-slot name="bottomSlot">
                                    @error('apellido')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                    
                        <div class="form-group">
                            <x-adminlte-input name="telefono" label="Telefono" placeholder="" enable-old-support maxlength="7" value="{{ $numero }}">
                                <x-slot name="prependSlot">
                                    <x-adminlte-select name="codigo">
                                        @switch($code)
                                            @case("0412")
                                                <option value="0414">0414</option>
                                                <option value="0424">0424</option>
                                                <option value="0412" selected>0412</option>
                                                <option value="0416">0416</option>
                                                <option value="0426">0426</option>
                                                @break
                                            @case("0414")
                                                <option value="0414" selected>0414</option>
                                                <option value="0424">0424</option>
                                                <option value="0412">0412</option>
                                                <option value="0416">0416</option>
                                                <option value="0426">0426</option>
                                                @break
                                                @case("0424")
                                                <option value="0414">0414</option>
                                                <option value="0424" selected>0424</option>
                                                <option value="0412">0412</option>
                                                <option value="0416">0416</option>
                                                <option value="0426">0426</option>
                                                @break
                                                @case("0416")
                                                <option value="0414">0414</option>
                                                <option value="0424">0424</option>
                                                <option value="0412">0412</option>
                                                <option value="0416" selected>0416</option>
                                                <option value="0426">0426</option>
                                                @break
                                                @case("0426")
                                                <option value="0414">0414</option>
                                                <option value="0424">0424</option>
                                                <option value="0412">0412</option>
                                                <option value="0416">0416</option>
                                                <option value="0426" selected>0426</option>
                                                @break
                                                
                                        @endswitch                                        
                                    </x-adminlte-select>
                                </x-slot>
                                <x-slot name="bottomSlot">
                                    @error('telefono')
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
                                "title" => "Selecciona el estado...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="estado" name="estado" label="Estado" label-class="text-white" :config="$configu" enable-old-support value="{{ $persona->direccion->ciudade->estado->id }}">
                                @foreach ($estados as $estado)
                                    @if ($estado->id == $persona->direccion->ciudade->estado->id)
                                        <option value="{{ $estado->id }}" selected>{{ $estado->nombre }}</option>
                                    @else
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endif
                                @endforeach

                            </x-adminlte-select2>
                        </div>

                        <div class="form-group">
                            <x-adminlte-input name="ciudad" label="Ciudad" list="datalistCiudad" value="{{ $persona->direccion->ciudade->nombre }}" enable-old-support/>
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
                            <x-adminlte-input name="sector" label="Sector" list="datalistSector" value="{{ $persona->direccion->sector }}" enable-old-support/>
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