<div class="row">
    <x-adminlte-input name="descripcion" label="Observaciones" placeholder="" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
        <x-slot name="bottomSlot">
            @error('descripcion')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </x-slot>
    </x-adminlte-input>

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
            <select name="tipo" class="form-control" wire:model="tipo" wire:change="buscar">
                <option value="p">Persona</option>
                <option value="e">Empresa</option>
            </select>
        </x-slot>

        @foreach ($datas as $data)
            <option value="{{ $data->id }}">{{ $data->nombre }}</option>
        @endforeach

    </x-adminlte-select2>
</div>