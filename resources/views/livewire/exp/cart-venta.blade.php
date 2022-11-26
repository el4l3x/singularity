<div>
    <div class="row" wire:ignore>

        @php
        $configu = [
            "placeholder" => "",
            "allowClear" => false,
            "liveSearch" => true,
            "liveSearchPlaceholder" => "Buscar...",
            "title" => "Selecciona al producto...",
            "showTick" => false,
            "actionsBox" => false,
        ];
        @endphp
        <x-adminlte-select2 id="selectProducto" name="selectProducto" label="Producto" label-class="text-white" :config="$configu" fgroup-class="col-lg-6 col-md-6 col-sm-12">
            <x-slot name="appendSlot">
                <div class="input-group-text" wire:loading wire:target="addProducto">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <x-adminlte-button label="Agregar" wire:click="addProducto" wire:loading.remove.target="addProducto" />
            </x-slot>
            
            <option disabled selected>Selecciona un producto</option>
            @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
            @endforeach
    
        </x-adminlte-select2>
        
        @php
        $configu = [
            "placeholder" => "",
            "allowClear" => false,
            "liveSearch" => true,
            "liveSearchPlaceholder" => "Buscar...",
            "title" => "Selecciona al servivicio...",
            "showTick" => false,
            "actionsBox" => false,
        ];
        @endphp
        <x-adminlte-select2 id="selectServicio" name="selectServicio" label="Servicio" label-class="text-white" :config="$configu" fgroup-class="col-lg-6 col-md-6 col-sm-12">
            <x-slot name="appendSlot">
                <div class="input-group-text" wire:loading wire:target="addServicio">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <x-adminlte-button label="Agregar" wire:click="addServicio" wire:loading.remove.target="addServicio" />
            </x-slot>
            
            <option disabled selected>Selecciona un servicio</option>
            @foreach ($servicios as $servicio)
                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
            @endforeach
    
        </x-adminlte-select2>

    </div>

    {{-- Add plugin initialization and configuration code --}}

    @push('js')
    <script>

        $(() => {

            $('#selectProducto').on('change', function (e) {
                var productoId = $('#selectProducto').select2("val")
                @this.set('productoId', productoId)
            });
            
            $('#selectServicio').on('change', function (e) {
                var servicioId = $('#selectServicio').select2("val")
                @this.set('servicioId', servicioId)
            });

        });

    </script>
    @endpush

    <div class="row table-responsive">
        
        <table class="table table-dark table-hover table-sm">
            <thead>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Sub Total</th>
                <th>Descripcion</th>
                <th>Acciones</th>
            </thead>

            @if ($carritoP->count() > 0 || $carritoS->count() > 0)
                <tbody>
                    @foreach ($carritoP as $itemP)
                        <tr>
                            <td>
                                {{ $itemP->name }}
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ number_format($itemP->price, 2, ".", ",") }}" wire:change="updatePriceP({{$itemP->id}}, $('#p'+{{$itemP->id}}).val())" id="p{{$itemP->id}}">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ $itemP->quantity }}" wire:change="updateCantidadP({{$itemP->id}}, $('#pc'+{{$itemP->id}}).val())" id="pc{{$itemP->id}}">
                            </td>
                            <td>
                                {{ $itemP->getPriceSum() }}
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ $itemP->attributes->descripcion }}" wire:change="updateDescripcionP({{$itemP->id}}, $('#pd'+{{$itemP->id}}).val())" id="pd{{$itemP->id}}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs btn-default mx-1 shadow" title="Sumar" wire:click="plusP({{$itemP->id}})">
                                    <i class="fa fa-lg fa-fw fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-default mx-1 shadow" title="Restar" wire:click="minusP({{$itemP->id}})">
                                    <i class="fa fa-lg fa-fw fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-default mx-1 shadow" title="Quitar" wire:click="removeP({{$itemP->id}})">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    
                    @foreach ($carritoS as $itemS)
                        <tr>
                            <td>
                                {{ $itemS->name }}
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ number_format($itemS->price, 2, ".", ",") }}" wire:change="updatePriceS({{$itemS->id}}, $('#s'+{{$itemS->id}}).val())" id="s{{$itemS->id}}">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ $itemS->quantity }}" wire:change="updateCantidadS({{$itemS->id}}, $('#sc'+{{$itemS->id}}).val())" id="sc{{$itemS->id}}">    
                            </td>
                            <td>
                                {{ $itemS->getPriceSum() }}
                            </td>
                            <td>
                                <input type="text" class="form-control" value="{{ $itemS->attributes->descripcion }}" wire:change="updateDescripcionS({{$itemS->id}}, $('#sd'+{{$itemS->id}}).val())" id="sd{{$itemS->id}}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs btn-default mx-1 shadow" title="Sumar" wire:click="plusS({{$itemS->id}})">
                                    <i class="fa fa-lg fa-fw fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-default mx-1 shadow" title="Restar" wire:click="minusS({{$itemS->id}})">
                                    <i class="fa fa-lg fa-fw fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-default mx-1 shadow" title="Quitar" wire:click="removeS({{$itemS->id}})">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center">
                            Agrega el primer producto o servicio al presupuesto
                        </td>
                    </tr>
                </tbody>
            @endif
        </table>

    </div>

    <div class="row">
        <div class="col-md-8">

        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    Total
                </div>

                <div class="col-md-6">
                    {{ $total }}
                </div>
            </div>
        </div>
    </div>
</div>
