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
        <br><br>
        <!-- enctype de este tipo para enviar datos del formulario que despues seran variables -->
        <form id="crear_presupuesto_frm" action="{{ url('Presupuesto') }}" method="POST" >
            {{ csrf_field() }}
            @foreach($proyectos as $proyecto)
                <input name="txt_id_proyecto" type="hidden" value="{{ $proyecto->id }}">
            @endforeach
            <!-- Detalle de Pedido -->
            <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                        @foreach($proyectos as $proyecto)
                            <h6>{{ $proyecto->nombre_proyecto }}</h6>
                            <input name="txt_id_proyecto" type="hidden" value="{{ $proyecto->id }}">
                        @endforeach
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-12">
                            <br>
                            @if(count($partidas)>0)
                                <div class="panel-body">
                                    <table id="tabla_de_detalle" name='tabla_de_detalle' class="table table-striped task-table">
                                        <!-- Encabezado de Tabla -->
                                        <thead>
                                            <th style='text-align:center; display:none;' width="10%">ID Partida</td>
                                            <th style='text-align:center' width="30%">Nombre Partida</th>
                                            <th style='text-align:center' width="18%">Presupuesto</th>
                                            <th style='text-align:center' width="18%">Total</th>
                                            <th style='text-align:center' width="18%">Saldo</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($partidas as $part)
                                                <tr>
                                                    <td style='text-align:center; display:none;' class="table-text">{{ $part->id_partida }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->nombre }}</td>
                                                    <td style='text-align:center' class="table-text">Q {{ $part->presupuesto }}</td>    
                                                    @if($part->orden_sumada>0)
                                                        <td style='text-align:center' class="table-text"><a href="/desglose/{{$part->id_proyecto}}/{{$part->id_partida}}" data-toggle="tooltip" title="Desglosar Gastos">Q {{ $part->orden_sumada }}</a></td>
                                                    @else
                                                        <td style='text-align:center' class="table-text"  >Q {{ $part->orden_sumada }}</td>  
                                                    @endif                                                                                                    
                                                    <td style='text-align:center' class="table-text"  >Q {{ $part->saldo }}</td>
                                                </tr>
                                            @endforeach
                                            @foreach($sumas as $sum)
                                                <tr>
                                                    <td style='text-align:center; display:none;' class="table-text">TOTAL</td>
                                                    <td style='text-align:center' class="table-text">TOTAL</td>
                                                    <td style='text-align:center' class="table-text">Q {{ $sum->Sp }}</td>
                                                    <td style='text-align:center' class="table-text">Q {{ $sum->So }}</td>
                                                    <td style='text-align:center' class="table-text">Q {{ $sum->Ss }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <br>
                            
                            <!-- Fin del Contenido -->
                        </div> 
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <button id="btn_subtotal" type="submit" form="no_frm" class="btn btn-primary" onclick="location.href='{{ url('/homeCompras') }}'">Salir</button><br><br>
            </div>
        </form>
        
        
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

