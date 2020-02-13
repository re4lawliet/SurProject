<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
        <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>

            <h1>PRESUPUESTO</h1>
            
        </div>
        <div>
            @foreach($proyectos as $proyecto)
                <h4>{{ $proyecto->nombre_proyecto }}</h4>
            @endforeach
        </div>
        <br><br>
           
        <!-- Tabla  -->
        <div class="col-md-12">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($matriz) > 0)
            <center>
                
                </center>
                <div class="panel-body">
                    <table id="tabla_de_detalle" name='tabla_de_detalle' class="table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th style='text-align:center'>Partida</td>
                            <th style='text-align:center'>Nombre Partida</th>
                            <th style='text-align:center'>Fecha</td>
                            <th style='text-align:center'>No. Orden</th>
                            <th style='text-align:center'>Proveedor</th>
                            <th style='text-align:center'>Titulo</th>
                            <th style='text-align:center'>Total</th>
                            <th style='text-align:center'>Pagado</th>
                            <th style='text-align:center'>Saldo</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                            @foreach ($matriz as $row)
                                <tr>
                                    <td style='text-align:center;font-weight:bold;'>{{ $row[0] }}</td>
                                    <td style='text-align:center;font-weight:bold;'>{{ $row[1] }}</td>
                                    <td> {{ $row[2] }} </td>
                                    <td> {{ $row[3] }} </td>
                                    <td> {{ $row[4] }} </td>
                                    <td> {{ $row[5] }} </td>
                                    <td> {{ $row[6] }} </td>
                                    <td> {{ $row[7] }} </td>
                                    <td> {{ $row[8] }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>


        <br>

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
            $('#tabla_de_detalle').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false,
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'pdfHtml5'
                ]
            });
        } );
    </script>

    <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
    
    
@endsection


