@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Editar Usuario {{ $user->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("usuarios.update", $user) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support value="{{ $user->name }}">
                                <x-slot name="bottomSlot">
                                    @error('nombre')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        
                        <div class="form-group">
                            <x-adminlte-input name="usuario" label="Usuario" placeholder="" enable-old-support value="{{ $user->username }}">
                                <x-slot name="bottomSlot">
                                    @error('usuario')
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

                                @if ($user->franquicias->count() < 1)
                                    @foreach ($franquicias as $franquicia)
                                        <option value="{{ $franquicia->id }}">{{ $franquicia->nombre }}</option>
                                    @endforeach
                                @else
                                    @foreach ($franquicias as $franquicia)
                                        @foreach ($user->franquicias as $userf)
                                            @if ($userf->pivot->franquicia_id == $franquicia->id)
                                                <option value="{{ $franquicia->id }}" selected>{{ $franquicia->nombre }}</option>                                            
                                            @else
                                                <option value="{{ $franquicia->id }}">{{ $franquicia->nombre }}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif

                            </x-adminlte-select2>
                        </div>

                        <div class="form-group">
                            <x-adminlte-select name="rol" label="Rol de Usuario" enable-old-support>
                                @foreach ($roles as $rol)
                                    @foreach ($user->roles as $userr)
                                        @if ($userr->pivot->role_id == $rol->id)
                                            <option selected value="{{ $rol->id }}">{{ $rol->name }}</option>
                                        @else
                                            <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                        @endif
                                    @endforeach
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