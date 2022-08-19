<!-- ENCABEZADO -->
@extends('layouts.appCompras')


@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>VISTA DE ORDENES RECHAZADAS POR CONTABILIDAD</center></h1>
        </div>

        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        <!-- Tabla  -->
        <div class="col-md-12">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($querySolicitudes) > 0)
                <div class="panel panel-default">
                    <h2>Listado De ORDENES Rechazadas por Contabilidad</h2>
                </div>

                <div class="panel-body">
                    <table id="tabla_ordenes" class="table table-striped task-table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>Fecha de Creacion</th>
                            <th>No. Orden</th>
                            <th>No. Parida</th>
                            <th>Partida</th>
                            <th>Titulo de Solicitud</th>
                            <th>Proveedor</th>
                            <th>Proyecto</th>
                            <th>Comentario</th>
                            <th>Ver Orden</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($querySolicitudes as $solicitud)
                            <tr>
                                <td class="table-text"><div>{{ $solicitud->fecha_creacion }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->no_orden }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->idpar }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->nombrepar }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->nombre_empresa }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->comentario_conta }}</div></td>
                                
                                <!-- Boton VER -->
                                <td>
                                    <button type="submit" class="btn btn-primary" onclick="location.href='/SolicitudRechazada/{{$solicitud->id}}'">
                                        <i class="fa fa-btn fa-pencil"></i>Seleccionar
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
            $('#tabla_ordenes').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false
            });
        } );
    </script>

@endsection