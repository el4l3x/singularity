@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    @can('users.create')
        <a class="btn btn-gray btn-sm float-right" type="button" href="{{ route('roles.create') }}">Nuevo Rol</a>
    @endcan
    <h3>Roles de Usuario</h3>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row justify-content-end mb-3">
                <div class="col-md-12 col-sm-12" id="buttons-exp">
                </div>    
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <table id="roles-table" class="table table-dark table-hover responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @can('roles.edit')
                                            <a href="{{ route('roles.edit', $role) }}" title="Editar" class="btn btn-xs btn-dark gray-text mx-1 shadow">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('roles.destroy')
                                            <button title="Eliminar" class="btn btn-xs btn-dark gray-text mx-1 shadow" onclick="event.preventDefault();
                                            document.getElementById({{$role->id}}).submit();">
                                                <i class="fa fw fa-trash"></i>
                                            </button>

                                            <form action="{{ route('usuarios.destroy', $role) }}" method="POST" id="{{$role->id}}" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach --}}
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
        .dt-button.active {
            background: #6c757d !important;
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
        .gray-text {
            color: #6c757d !important;
            text-decoration: none !important;
        }
        .btn-gray {
            background: #6c757d;
            color: white;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="/src/datatables.min.js"></script>
    
    <script>        
        $(function () {

            var table = $("#roles-table").DataTable({
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
                    },
                },
                /* scrollX: true, */
                "responsive": true, 
                "autoWidth": false,
                "buttons": [
                    {
                        extend: 'copy',
                        text: 'Copiar',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
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