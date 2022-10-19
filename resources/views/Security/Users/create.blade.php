@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Nuevo Usuario</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("usuarios.store") }}" method="post">
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
                            <x-adminlte-input name="usuario" label="Usuario" placeholder="" enable-old-support>
                                <x-slot name="bottomSlot">
                                    @error('usuario')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        
                        <div class="form-group">
                            <x-adminlte-input name="clave" type="password" label="Clave" placeholder="" enable-old-support>
                                <x-slot name="bottomSlot">
                                    @error('clave')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        
                        <div class="form-group">
                            <x-adminlte-input name="clave_confirmation" type="password" label="Confirmar Clave" placeholder="" enable-old-support>
                                <x-slot name="bottomSlot">
                                    @error('clave_confirmation')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <div class="form-group">
                            @php
                            $config = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona las franquicias...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="franquicias" name="franquicias[]" label="Franquicias a cargo" label-class="text-white" igroup-size="md" :config="$config" multiple enable-old-support>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                </x-slot>

                                {{-- <x-slot name="appendSlot">
                                    <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger"/>
                                </x-slot> --}}

                                @foreach ($franquicias as $franquicia)
                                    <option value="{{ $franquicia->id }}">{{ $franquicia->nombre }}</option>
                                @endforeach

                            </x-adminlte-select2>
                        </div>

                        <div class="form-group">
                            <x-adminlte-select name="rol" label="Rol de Usuario" enable-old-support>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("usuarios.index") }}">Volver</a>
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