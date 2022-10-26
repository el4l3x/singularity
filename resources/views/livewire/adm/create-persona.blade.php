<div>
    <div class="form-group">
        <x-adminlte-input name="cedula" label="C.I" placeholder="" enable-old-support wire:model="cedula" maxlength="8">
            <x-slot name="appendSlot">
                <x-adminlte-button wire:click="buscarci" label="Buscar"/>
            </x-slot>
            <x-slot name="prependSlot">
                <div class="input-group-text text-dark" wire:click="buscarci">
                    <i class="fas fa-search"></i>
                </div>
            </x-slot>
            <x-slot name="bottomSlot">
                <span class="text-danger">{{ $errorci }}</span>
                @error('cedula')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </x-slot>
        </x-adminlte-input>
    </div>

    <div class="form-group">
        @if ($readonly)
            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support wire:model="nombre" readonly>
                <x-slot name="bottomSlot">
                    @error('nombre')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </x-slot>
            </x-adminlte-input>
        @else
            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support wire:model="nombre">
                <x-slot name="bottomSlot">
                    @error('nombre')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </x-slot>
            </x-adminlte-input>
        @endif        
    </div>

    <div class="form-group">
        @if ($readonly)
            <x-adminlte-input name="apellido" label="Apellido" placeholder="" enable-old-support wire:model="apellido" readonly>
                <x-slot name="bottomSlot">
                    @error('apellido')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </x-slot>
            </x-adminlte-input>
        @else
            <x-adminlte-input name="apellido" label="Apellido" placeholder="" enable-old-support wire:model="apellido">
                <x-slot name="bottomSlot">
                    @error('apellido')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </x-slot>
            </x-adminlte-input>
        @endif        
    </div>

    <div class="form-group">
        <x-adminlte-input name="telefono" label="Telefono" placeholder="" enable-old-support maxlength="7">
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

</div>