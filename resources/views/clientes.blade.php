@extends('layouts.appAdmin')


@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <!-- Inicio del Contenido de Pagina -->
    <center>
    <div class="panel-title">
        <h1><center>Administrador de Clientes</center></h1>
    </div>

    <!-- Tabla de Administrador -->

    <div class="col-md-12">
            @if (count($cli) > 0)
            <div class="panel panel-default">
                
                <div class="panel-heading">
                        Listado De Clientes
                </div>
                <div class="panel-body">
                    <table id="clientes"  class="table table-striped task-table">
                        <thead>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Direccion</th>
                            <th>NIT</th>
                            <th>Telefono</th>
                            <th>Modificar</th>
                            <th>Borrar</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($cli as $clis)
                                <tr>
                                    <td class="table-text"><div>{{ $clis->nombre }}</div></td>
                                    <td class="table-text"><div>{{ $clis->apellido }}</div></td>
                                    <td class="table-text"><div>{{ $clis->direccion }}</div></td>
                                    <td class="table-text"><div>{{ $clis->nit }}</div></td>
                                    <td class="table-text"><div>{{ $clis->telefono }}</div></td>
    
                                    <!-- Task Delete Button -->
                                    <td>
                                        <button type="submit" class="btn btn-success" onclick="location.href='clientes/{{ $clis->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Modificar
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ url('cliente') }}/{{ $clis->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
    
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Borrar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Formulario de Registro de Cliente -->    
  
    <div class="col-sm-offset-3 col-sm-6">
            <div class="panel-title">
                    <h3><center>Registrar Cliente:</center></h3>
            </div>
        <div class="panel-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('cliente') }}" method="POST">

                {{ csrf_field() }}

                <div class="form-group">
                    <label for="nombre" class="control-label">Nombres</label>
                    <input type="text" name="nombre" class="form-control">
                </div>  

                <div class="form-group">
                    <label for="apellido" class="control-label">Apellidos</label>
                    <input type="text" name="apellido" class="form-control">
                </div>
                
                 <div class="form-group">
                    <label for="direccion" class="control-label">Direccion</label>
                    <input type="text" name="direccion" class="form-control">
                </div>

                 <div class="form-group">
                    <label for="nit" class="control-label">NIT</label>
                    <input type="text" name="nit" class="form-control">
                </div>

                 <div class="form-group">
                    <label for="telefono" class="control-label">Telefono</label>
                    <input type="text" name="telefono" class="form-control">
                </div>


                <div class="form-group">
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Registrar Cliente  
                    </button>    
                    
                </div> 
            </form>   
            
        </div>
    </div>
</center>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script>
        var idioma_espanol = {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
        }
        
        $(document).ready( function () {
            $('#clientes').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false
            });
        } );
    </script>
@endsection