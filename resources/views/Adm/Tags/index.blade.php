@extends('adminlte::page')

@section('title', 'Etiquetas')

@section('content_header')
    @can('tags.create')
        <a class="btn btn-gray btn-sm float-right" type="button" href="{{ route('etiquetas.create') }}">Nueva Etiqueta</a>
    @endcan
    <h3>Etiquetas para Productos y Servicios</h3>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row justify-content-end mb-3">
                <div class="col-md-12 col-lg-12 col-sm-12" id="buttons-exp">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <table id="empresas-table" class="table table-dark table-hover responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->nombre }}</td>
                                    <td>
                                        @can('tags.edit')
                                            <a href="{{ route('etiquetas.edit', $tag) }}" title="Editar" class="btn btn-xs btn-dark gray-text mx-1 shadow">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>                                            
                                        @endcan

                                        @can('tags.destroy')
                                            <button title="Eliminar" class="btn btn-xs btn-dark gray-text mx-1 shadow" onclick="event.preventDefault();
                                            document.getElementById({{$tag->id}}).submit();">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>

                                            <form action="{{ route('etiquetas.destroy', $tag) }}" method="post" id="{{$tag->id}}" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="/src/datatables.min.css"/>

    <style>
        .btn-gray {
            background: #6c757d;
            color: white;
        }
        .gray-text {
            color: #6c757d !important;
            text-decoration: none !important;
        }
        .dt-button.dropdown-item {
            color: white !important;
        }
        .dt-button-collection {
            background: gray !important;
        }
        .dt-button.active {
            background: #6c757d !important;
        }
        div.dt-button-info {
           background: #6c757d;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="/src/datatables.min.js"></script>
    
    <script>        
        $(function () {

            var tablita = $("#empresas-table").DataTable({
                "language": {
                    "search": "Buscar:",
                    "emptyTable": "No hay registros",
                    "info":           "Viendo del _START_ al _END_. En total _TOTAL_ registros",
                    "infoEmpty":      "",
                    "infoFiltered":   "(filtrado de _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      ".",
                    "lengthMenu":     "Ver _MENU_ filas",
                    "loadingRecords": "Cargando...",
                    "processing":     "",
                    "zeroRecords":    "No se consiguieron coincidencias",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": ordenar de manera ascendente",
                        "sortDescending": ": ordenar de manera descendente"
                    },
                    "buttons": {
                        copy: 'Copy',
                        copySuccess: {
                            1: "Copiado al portapapeles",
                            _: "Copiado al portapapeles"
                        },
                        copyTitle: '',
                        copyKeys: 'Press <i>ctrl</i> or <i>\u2318</i> + <i>C</i> to copy the table data<br>to your system clipboard.<br><br>To cancel, click this message or press escape.'
                    }
                },
                /* scrollX: true, */
                "responsive": true, 
                "autoWidth": false,
                "buttons": [                    
                    {
                        extend: 'copyHtml5',
                        text: 'Copiar',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                        /* action: function ( e, dt, node, config ) {
                            toastr.options.progressBar = true;
                            toastr.info('Tabla copiada al portapapeles.');

                            $.fn.dataTable.ext.buttons.copyHtml5.action.call(this, e, dt, node, config);
                        }, */
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                    },
                    {
                        extend: 'colvis',
                        text: 'Ocultar Columnas',
                        className: ''
                    },
                ]
            }).buttons().container().appendTo('#buttons-exp');
          
        });
    </script>
@stop