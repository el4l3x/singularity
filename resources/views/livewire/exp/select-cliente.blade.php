<div class="row">

    @php
    $configu = [
        "placeholder" => "",
        "allowClear" => false,
        "liveSearch" => true,
        "liveSearchPlaceholder" => "Buscar...",
        "title" => "Selecciona al cliente...",
        "showTick" => false,
        "actionsBox" => false,
    ];
    @endphp
    <x-adminlte-select2 id="cliente" name="cliente" label="Cliente" label-class="text-white" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
        <x-slot name="prependSlot">
            <select name="tipo" class="form-control" wire:model="tipo" wire:change="buscar" name="tipo">
                @if ($selectC == 'p')
                    <option value="p" selected>Persona</option>                    
                    <option value="e">Empresa</option>
                @else                
                    <option value="p">Persona</option>                    
                    <option value="e" selected>Empresa</option>
                @endif
            </select>
        </x-slot>

        @foreach ($datas as $data)
            @if (isset($cliente->id) && $cliente->id == $data->id)
                <option value="{{ $data->id }}" selected>{{ $data->nombre }}</option>
            @else
                <option value="{{ $data->id }}">{{ $data->nombre }}</option>
            @endif
        @endforeach

    </x-adminlte-select2>

    <x-adminlte-textarea name="observaciones" label="Observaciones" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
        {{ $observaciones }}
        <x-slot name="bottomSlot">
            @error('observaciones')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </x-slot>
    </x-adminlte-textarea>
</div>

@push('js')
    <script>
        window.addEventListener('contentChanged', event => {
            $('#cliente').select2('destroy');
            $('#cliente').select2();
        });
    </script>
@endpush