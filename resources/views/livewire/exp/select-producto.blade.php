<div class="form-group col-lg-6 col-md-6 col-sm-12">

    <label for="selectProducto">
        Productos - {{ $productoId }}
    </label>

    <div class="input-group" wire:ignore>
        {{-- Select --}}
        <select id="selectProducto" name="selectProducto" class="form-control">
            @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
            @endforeach
        </select>

        <div class="input-group-append">
            <x-adminlte-button wire:click="addProducto" label="Agregar"/>   
        </div>

    </div>

    @if($isInvalid)
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $errorP }}</strong>
        </span>
    @endif

    {{-- Add plugin initialization and configuration code --}}

    @push('js')
    <script>

        $(() => {
            $('#selectProducto').select2( {
                "placeholder": "",
                "allowClear": false,
                "liveSearch": true,
                "liveSearchPlaceholder": "Buscar...",
                "title": "Selecciona los productos...",
                "showTick": false,
                "actionsBox": false,
            } );

            $('#selectProducto').on('change', function (e) {
                var productoId = $('#selectProducto').select2("val")
                var productoName = $('#selectProducto option:selected').text()
                @this.set('productoId', productoId)
                @this.set('productoName', productoName)
            });

            // Add support to auto select old submitted values in case of
            // validation errors.

            @if($errors->any() && $enableOldSupport)

                let oldOptions = @json(collect($getOldValue($errorKey)));

                $('#selectProducto option').each(function()
                {
                    let value = $(this).val() || $(this).text();
                    $(this).prop('selected', oldOptions.includes(value));
                });

                $('#selectProducto').trigger('change');

            @endif
        });

    </script>
    @endpush

    {{-- CSS workarounds for the Select2 plugin --}}
    {{-- NOTE: this may change with newer plugin versions --}}

    @once
    @push('css')
    <style type="text/css">

        {{-- SM size setup --}}
        .input-group-sm .select2-selection--single {
            height: calc(1.8125rem + 2px) !important
        }
        .input-group-sm .select2-selection--single .select2-selection__rendered,
        .input-group-sm .select2-selection--single .select2-selection__placeholder {
            font-size: .875rem !important;
            line-height: 2.125;
        }
        .input-group-sm .select2-selection--multiple {
            min-height: calc(1.8125rem + 2px) !important
        }
        .input-group-sm .select2-selection--multiple .select2-selection__rendered {
            font-size: .875rem !important;
            line-height: normal;
        }

        {{-- LG size setup --}}
        .input-group-lg .select2-selection--single {
            height: calc(2.875rem + 2px) !important;
        }
        .input-group-lg .select2-selection--single .select2-selection__rendered,
        .input-group-lg .select2-selection--single .select2-selection__placeholder {
            font-size: 1.25rem !important;
            line-height: 2.25;
        }
        .input-group-lg .select2-selection--multiple {
            min-height: calc(2.875rem + 2px) !important
        }
        .input-group-lg .select2-selection--multiple .select2-selection__rendered {
            font-size: 1.25rem !important;
            line-height: 1.7;
        }

        {{-- Enhance the plugin to support readonly attribute --}}
        select[readonly].select2-hidden-accessible + .select2-container {
            pointer-events: none;
            touch-action: none;
        }

        select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
            background: #e9ecef;
            box-shadow: none;
        }

        select[readonly].select2-hidden-accessible + .select2-container .select2-search__field {
            display: none;
        }

    </style>
    @endpush
    @endonce

</div>
