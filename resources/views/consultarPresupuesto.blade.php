<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('content')
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