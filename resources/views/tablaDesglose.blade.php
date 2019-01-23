<!-- ENCABEZADO -->
@extends('layouts.appCompras')

@section('content')
        <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>
            <h6>DESGLOSE DE LA PARTIDA</h6>
        </div>

        <!-- Detalle de Pedido -->
        <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                        Partidas del Proyecto
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
                                            <th style='text-align:center' width="10%">ID Proyecto</td>
                                            <th style='text-align:center' width="30%">Nombre Proyecto</th>
                                            <th style='text-align:center' width="15%">ID Partida</th>
                                            <th style='text-align:center' width="18%">Nombre Partida</th>
                                            <th style='text-align:center' width="18%">Divisa</th>
                                            <th style='text-align:center' width="18%">Total</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($compras as $part)
                                                <tr>

                                                    <td style='text-align:center' class="table-text">{{ $part->id_proyecto }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->nombre_proyecto }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->id_partida }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->nombre_partida }}</td>
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

                                
                            