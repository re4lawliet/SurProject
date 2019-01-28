<!-- ENCABEZADO -->
@extends('layouts.master')

@section('title','Menu de Compras')

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
                            <th>Titulo</th>
                            <th>Nombre Partida</th>
                            <th>Proyecto</th>
                            <th>Proveedor</th>
                            <th>Total Orden</th>
                            <th>Pagado</th>
                            <th>Hacer Abono</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($ordenes as $orden)
                            <tr>
                                <td class="table-text">{{ $orden->titulo_solicitud }}</td>
                                <td class="table-text">{{ $orden->partida }}</td>
                                <td class="table-text">{{ $orden->nombre_proyecto }}</td>
                                <td class="table-text">{{ $orden->nombre_empresa }}</td>
                                <td class="table-text">{{ $orden->total }}</td>
                                <td class="table-text">{{ $orden->pagado }}</td>
                                <!-- Boton VER -->
                                <td>
                                <!-- // <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_proveedor">Crear Orden</button> -->
                                <button type="submit" class="btn btn-primary" onclick="location.href='/OrdeneAbierta/{{ $orden->id_orden }}'">
                                        <i class="fa fa-btn fa-pencil"></i>Hacer Abono
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
            $('#tabla_pedidos').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false
            });
        } );
    </script>
@endsection
