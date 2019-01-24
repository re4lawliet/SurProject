<!-- EL CODIGO QUE SI JALA -->
<head>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>
            <h1>DESGLOSE</h1>
        </div>

        <!-- Detalle de Pedido -->
        <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                    <center>
                    @foreach($compras as $c)
                            @if ($loop->first)
                                <h6>Proyecto: {{ $c->nombre_proyecto }}</h6>
                                <h6>Partida: {{ $c->nombre_partida }}</h6>
                            @endif
                        @endforeach
                    </center>
                        
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-10">
                            <br>
                            @if(count($compras)>0)
                            <div class="panel-body">
                                    <table id="myTable" class="table table-bordered">
                                        <!-- Encabezado de Tabla -->
                                        <thead>
                                            <th style='text-align:center' width="30%">Nombre Proveedor</th>
                                            <th style='text-align:center' width="18%">Titulo de Solicitud</th>
                                            <th style='text-align:center' width="18%">Divisa</th>
                                            <th style='text-align:center' width="18%">Total</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($compras as $part)
                                                <tr>
                                                    <td style='text-align:center' class="table-text">{{ $part->nombre_empresa }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->titulo_solicitud }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->divisa }}</td>

                                                    @if($part->divisa=='USD')
                                                    <td style='text-align:center' class="table-text" >$ {{ $part->total }}</td>
                                                    @elseif($part->divisa=='QGT')
                                                    <td style='text-align:center' class="table-text" >Q {{ $part->total }}</td>
                                                    @endif
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
                        <div class="content">
                            <button class="btn btn-primary" onclick="location.href='{{ URL::previous() }}'">Regresar</button>
                        </div>
                        
                    </div>
                </div>
        </div>







        </center>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
            } );
        </script>


































































<!-- EL CODIGO ORIGIANL -->         
<!-- ENCABEZADO -->
@extends('layouts.appCompras')

@section('content')
        <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>
            <h1>DESGLOSE</h1>
        </div>

        <!-- Detalle de Pedido -->
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
                                    <table id="tabla_de_detalle" name='tabla_de_detalle' class="table table-striped task-table">
                                        <!-- Encabezado de Tabla -->
                                        <thead>
                                            <th style='text-align:center' width="30%">Nombre Proveedor</th>
                                            <th style='text-align:center' width="18%">Titulo de Solicitud</th>
                                            <th style='text-align:center' width="18%">Divisa</th>
                                            <th style='text-align:center' width="18%">Total</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($compras as $part)
                                                <tr>
                                                    <td style='text-align:center' class="table-text">{{ $part->nombre_empresa }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->titulo_solicitud }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->divisa }}</td>

                                                    @if($part->divisa=='USD')
                                                    <td style='text-align:center' class="table-text" >$ {{ $part->total }}</td>
                                                    @elseif($part->divisa=='QGT')
                                                    <td style='text-align:center' class="table-text" >Q {{ $part->total }}</td>
                                                    @endif
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
                        <button class="btn btn-primary" onclick="location.href='{{ URL::previous() }}'">Regresar</button>
                    </div>
                </div>
            </div>







        </center>
@endsection

                                
                             
                            