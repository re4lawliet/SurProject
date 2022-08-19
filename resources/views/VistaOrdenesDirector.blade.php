<!-- ENCABEZADO -->
@extends('layouts.appDirector')


@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>VISTA DE ORDENES POR ENVIAR</center></h1>
        </div>


        <!-- Tabla  -->
        <div class="col-md-11">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($ordenes) > 0)
                <div class="panel panel-default">
                    <h2>Listado De Ordenes</h2>
                </div>
                <br>
                <div class="panel-body">
                    <table id="ordenes_director" class="table table-striped task-table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>Fecha de Creacion</th>
                            <th>No. Orden</th>
                            <th>No. Parida</th>
                            <th>Partida</th>
                            <th>Titulo de Solicitud</th>
                            <th>Proveedor</th>
                            <th>Proyecto</th>
                            <th>Ver Orden</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($ordenes as $orden)
                            <tr>
                                <td class="table-text"><div>{{ $orden->fecha_creacion }}</div></td>
                                <td class="table-text"><div>{{ $orden->no_orden }}</div></td>
                                <td class="table-text"><div>{{ $orden->idpar }}</div></td>
                                <td class="table-text"><div>{{ $orden->nombrepar }}</div></td>
                                <td class="table-text"><div>{{ $orden->titulo_solicitud }}</div></td>
                                <td class="table-text"><div>{{ $orden->nombre_empresa }}</div></td>
                                <td class="table-text"><div>{{ $orden->nombre_proyecto }}</div></td>
                                <!-- Boton VER -->
                                <td>
                                <!-- // <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_proveedor">Crear Orden</button> -->
                                <button type="submit" class="btn btn-primary" onclick="location.href='verOrdenDirector/{{ $orden->id }}'">
                                        <i class="fa fa-btn fa-pencil"></i>Ver Orden
                                    </button>
                                    
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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
            $('#ordenes_director').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false
            });
        } );
    </script>
@endsection
