<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('content')
        <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>

            <h6>CREACION DE PRESUPUESTO</h6>
            <h6>DEL PROYECTO</h6>
            @foreach($proyectos as $proyecto)
                <h6>{{ $proyecto->nombre_proyecto }}</h6>
                <input name="txt_id_proyecto" type="hidden" value="{{ $proyecto->id }}">
            @endforeach
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
                        Partidas del Proyecto
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-10">
                            <br>
                            @if(count($partidas)>0)
                                <div class="panel-body">
                                    <table id="tabla_de_detalle" name='tabla_de_detalle' class="table table-striped task-table">
                                        <!-- Encabezado de Tabla -->
                                        <thead>
                                            <th style='text-align:center' width="10%">ID Partida</td>
                                            <th style='text-align:center' width="30%">Nombre Partida</th>
                                            <th style='text-align:center' width="15%">Divisa de Partida</th>
                                            <th style='text-align:center' width="18%">Presupuesto</th>
                                            <th style='text-align:center' width="18%">Orden Sumada</th>
                                            <th style='text-align:center' width="18%">Saldo</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($partidas as $part)
                                                <tr>

                                                    <td style='text-align:center' class="table-text">{{ $part->id_partida }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->nombre_partida }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $part->divisa }}</td>

                                                    @if($part->divisa=='USD')
                                                    <td style='text-align:center' class="table-text">$ {{ $part->presupuesto }}</td>
                                                    @elseif($part->divisa=='QGT')
                                                    <td style='text-align:center' class="table-text" >Q {{ $part->presupuesto }}</td>
                                                    @endif
                                                    
                                                    
                                                    @if($part->divisa=='USD')
                                                        <td style='text-align:center' class="table-text"><a href="/desglose/{{$part->id_proyecto}}/{{$part->id_partida}}/{{$part->divisa}}" data-toggle="tooltip" title="Desglosar Gastos">$ {{ $part->total_partida }}</a></td>
                                                    @elseif($part->divisa=='QGT')
                                                    <td style='text-align:center' class="table-text"><a href="/desglose/{{$part->id_proyecto}}/{{$part->id_partida}}/{{$part->divisa}}" data-toggle="tooltip" title="Desglosar Gastos">Q {{ $part->total_partida }}</a></td>
                                                    @endif

                                                    @if($part->divisa=='USD')
                                                    <td style='text-align:center' class="table-text">$ {{ $part->saldo }} </td>
                                                    @elseif($part->divisa=='QGT')
                                                    <td style='text-align:center' class="table-text">Q {{ $part->saldo }} </td>
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
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <button id="btn_subtotal" type="submit" form="no_frm" class="btn btn-primary" onclick="location.href='{{ url('/homeCompras') }}'">Salir</button><br><br>
            </div>
        </form>
        
        
    </center>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>