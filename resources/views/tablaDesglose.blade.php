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
                                            <th style='text-align:center' width="30%">Nombre Proveedor</th>
                                            <th style='text-align:center' width="18%">Titulo de Solicitud</th>
                                            <th style='text-align:center' width="18%">Total</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($compras as $part)
                                                <tr>
                                                    <td style='text-align:center' class="table-text">{{ $part->nombre_empresa }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->titulo_solicitud }}</td>
                                                    <td style='text-align:center' class="table-text" >Q {{ $part->total }}</td>

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
                    "info": false
                });
            } );
        </script>
@endsection