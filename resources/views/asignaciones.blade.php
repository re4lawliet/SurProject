@extends('layouts.appAdmin')


@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <!-- Inicio del Contenido de Pagina -->
    <center>
    <div class="panel-title">
        <h1><center>Administrador de Asignaciones</center></h1>
    </div>



<!-- Formulario de Registro de Cliente -->    
  
<div class="col-md-10">
            <div class="panel-title">
                    <h3><center>Asignar Proyecto a Empleado</center></h3>
            </div>
        

            <form action="{{ url('asignar') }}" method="POST">

                {{ csrf_field() }}

                <div class="form-group">
                    <div class="row">
                        <div class="col-xl-6">
                            <label for="apellido" class="control-label">Empleados</label>
                            <select id="empleados" class="form-control" name="empleados">
                                <option value="-1"></option>
                                @if (count($usuarios) > 0)
                                    @foreach($usuarios as $usr)
                                        <option value="{{ $usr->id }}">{{ $usr->name}} {{ $usr->apellido }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-xl-6">
                            <label for="apellido" class="control-label">Proyectos</label>
                            <select id="proyectos" class="form-control" name="proyectos">
                                <option value="-1"></option>
                                @if (count($proyectos) > 0)
                                    @foreach($proyectos as $pr)
                                        <option value="{{ $pr->id }}">{{ $pr->nombre_proyecto}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group">
                    
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> ASIGNAR >>
                    </button>    
                    
                </div> 
            </form>   
            
       
</div>



    <br><br><br>
    <!-- Tabla de Administrador -->

    <div class="col-md-10">
            @if (count($asignaciones) > 0)
            <div class="panel panel-default">
                
                <div class="panel-heading">
                        Listado De Asignaciones
                </div>
                <div class="panel-body">
                    <table id="clientes"  class="table table-striped task-table">
                        <thead>
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>PROYECTO</th>
                            <th>QUITAR</th>
                            <th style='text-align:center; display:none;'>ID_USUARIO</th>
                            <th style='text-align:center; display:none;'>ID_PROYECTO</th>
                        </thead>
                        <tbody>
                            @foreach ($asignaciones as $as)
                                <tr>
                                    <td class="table-text">{{ $as->name }}</td>
                                    <td class="table-text">{{ $as->apellido }}</td>
                                    <td class="table-text">{{ $as->nombre_proyecto }}</td>

                                    <!-- Task Delete Button -->
                                    <td>
                                        <form action="{{ url('desasignar') }}/{{ $as->id_u }}/{{ $as->id_p }}" method="get">
                                            {{ csrf_field() }}
    
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Quitar
                                            </button>
                                        </form>
                                    </td>


                                    <td class="table-text" style='text-align:center; display:none;'>{{ $as->id_u }}</td>
                                    <td class="table-text" style='text-align:center; display:none;'>{{ $as->id_p }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    
    
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