@extends('layouts.appCompras')

@section('title','Menu de Compras SUR')

@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

<center>
<div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                    
                    
                        @foreach($compras as $c)
                            @if ($loop->first)
                                <h6>Proyecto: {{ $c->nombre_proyecto }}</h6>
                                <h6>Partida: {{ $c->nombre_partida }}</h6>
                            @endif
                        @endforeach
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-10">
                            <br>
                            @if(count($compras)>0)
                            <div class="panel-body">
                                    <table id="myTable" class="table table-striped task-table">
                                        <!-- Encabezado de Tabla -->
                                        <thead>
                                            <th style='text-align:center' width="30%">Fecha</th>
                                            <th style='text-align:center' width="30%">No. Orden</th>
                                            <th style='text-align:center' width="30%">Nombre Proveedor</th>
                                            <th style='text-align:center' width="18%">Titulo de Solicitud</th>
                                            <th style='text-align:center' width="30%">Saldo Total</th>
                                            <th style='text-align:center' width="18%">Saldo Pagado</th>
                                            <th style='text-align:center' width="30%">Saldo Pendiente</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($compras as $part)
                                                <tr>
                                                    <td style='text-align:center' class="table-text">{{ $part->fecha_creacion }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->no_orden }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->nombre_empresa }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->titulo_solicitud }}</td>
                                                    <td style='text-align:center' class="table-text">Q {{ $part->total }}</td>
                                                    <td style='text-align:center' class="table-text">Q {{ $part->pagado }}</td>
                                                    <td style='text-align:center' class="table-text">Q {{ $part->pendiente }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <br>
                            <!-- Fin del Contenido -->
                        </div> 
                        <br>
                        <div>
                        <button class="btn btn-primary" onclick="location.href='{{ URL::previous() }}'">Regresar</button>
                        </div>
                        
                    </div>
                </div>
        </div>
        </center>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

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
                $('#myTable').DataTable({
                    "language": idioma_espanol,
                    "paging": false,
                    "info": false,
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'pdfHtml5'
                    ]
                });
            } );
        </script>
@endsection