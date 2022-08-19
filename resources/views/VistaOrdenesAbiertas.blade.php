<!-- ENCABEZADO -->
@extends('layouts.appCompras')

@section('title','Menu de Compras SUR')

@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>VISTA DE ORDENES ABIERTAS</center></h1>
        </div>


        <!-- Tabla  -->
        <div class="col-sm-10">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($ordenes) > 0)
                <div class="panel panel-default">
                    <h2>Listado De Ordenes </h2>
                </div>
                <br>
                <div class="panel-body">
                    <table id="tabla_pedidos" class="table table-striped task-table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>Fecha de Creacion</th>
                            <th>No. Orden</th>
                            <th>No. Parida</th>
                            <th>Partida</th>
                            <th>Titulo de Solicitud</th>
                            <th>Proveedor</th>
                            <th>Proyecto</th>
                            <th>Total Orden</th>
                            <th>Pagado</th>
                            <th>Hacer Abono</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($ordenes as $orden)
                            <tr>
                                <td class="table-text">{{ $orden->fecha_creacion }}</td>
                                <td class="table-text">{{ $orden->no_orden }}</td>
                                <td class="table-text">{{ $orden->idpar }}</td>
                                <td class="table-text">{{ $orden->nombrepar }}</td>
                                <td class="table-text">{{ $orden->titulo_solicitud }}</td>
                                <td class="table-text">{{ $orden->nombre_empresa }}</td>
                                <td class="table-text">{{ $orden->nombre_proyecto }}</td>
                                @if($orden->divisa=='USD')
                                    <td class="table-text">$ {{ $orden->total }}</td>
                                    <td class="table-text">$ {{ $orden->pagado }}</td>
                                @else
                                    <td class="table-text">Q {{ $orden->total }}</td>
                                    <td class="table-text">Q {{ $orden->pagado }}</td>
                                @endif
                                <!-- Boton VER -->
                                <td>
                                <!-- // <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_proveedor">Crear Orden</button> -->
                                @if($orden->respuesta_conta<=1 || $orden->respuesta_conta==3)
                                    <button type="submit" class="btn btn-danger" onclick="denegar()">
                                                <i class="fa fa-btn fa-pencil"></i>Hacer Abono
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary" onclick="location.href='/OrdeneAbierta/{{ $orden->id_orden }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Hacer Abono
                                    </button>
                                @endif
                                
                                    
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
            $('#tabla_pedidos').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false
            });
        } );
    </script>
    <script>
        function denegar(){
            alert('No se pueden hacer abonos, la Orden de Compra no ha sido aprobada por Contabilidad');
        }
    </script>
@endsection
