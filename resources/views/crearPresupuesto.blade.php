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
            @endforeach
        </div>
        <br><br>
        
        @if(count($presupuesto)==NULL)
            <!-- enctype de este tipo para enviar datos del formulario que despues seran variables -->
            <form id="crear_orden_frm" action="{{ url('#') }}" method="POST" >
                {{ csrf_field() }}

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
                                                <th style='text-align:center' width="15%">ID Partida</td>
                                                <th style='text-align:center' width="35%">Nombre Partida</th>
                                                <th style='text-align:center' width="20%">Divisa de Partida</th>
                                                <th style='text-align:center' width="15%">Presupuesto</th>
                                                <th style='text-align:center' width="15%">Orden Sumada</th>
                                                <th style='text-align:center' width="15%">Saldo</th>
                                            </thead>
                                            <!-- Cuerpo de Tabla -->
                                            <tbody>
                                                @foreach ($partidas as $part)
                                                    <tr>
                                                        <td style='text-align:center' class="table-text">{{ $part->id_partida }}</td>
                                                        <td style='text-align:center' class="table-text">{{ $part->nombre_partida }}</td>
                                                        <td style='text-align:center' class="table-text">{{ $part->divisa }}</td>
                                                        <td style='text-align:center' class="editable" contenteditable="true">0</td>
                                                        @if($part->divisa=='USD')
                                                            <td style='text-align:center' class="table-text">$ {{ $part->total_partida }}</td>
                                                        @elseif($part->divisa=='QGT')
                                                        <td style='text-align:center' class="table-text">Q {{ $part->total_partida }}</td>
                                                        @endif
                                                        <td style='text-align:center' class="table-text"> </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <input id ="id_txt_ids" name="txt_ids" type="hidden" value="">
                                        <input id ="id_txt_precios_unitarios" name="txt_precios_unitarios" type="hidden" value="">
                                        <input id="id_txt_subtotales" name="txt_subtotales" type="hidden" value="">
                                    </div>
                                @endif


                                <div class="form-group">
                                    <button id="btn_subtotal" type="submit" form="No_Es_Parte_Del_Form" class="btn btn-primary" onclick="calcularSaldos()">Calcular Saldos</button><br><br>

                                </div>
                            </div>
                            <!-- Fin del Contenido -->
                        </div> 
                    </div>
                </div>
                <br>
            </form>
        @else

        @endif


        
        
        
    </center>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    function calcularSaldos(){
        var table = document.getElementById("tabla_de_detalle");
        //limpiar divisas
        for( var i = 1; i < table.rows.length; i++){
            var divisa = "";
            if(table.rows[i].cells[2].innerHTML == 'USD'){
                divisa="$";
            }else if(table.rows[i].cells[2].innerHTML == 'QGT'){
                divisa="Q";
            }
            if(table.rows[i].cells[3].innerHTML.indexOf(divisa)!== -1){
                table.rows[i].cells[3].innerHTML = table.rows[i].cells[3].innerHTML.replace(divisa,'');
            }
            if(table.rows[i].cells[4].innerHTML.indexOf(divisa)!== -1){
                table.rows[i].cells[4].innerHTML = table.rows[i].cells[4].innerHTML.replace(divisa,'');
            } 
            if(table.rows[i].cells[5].innerHTML.indexOf(divisa)!== -1){
                table.rows[i].cells[5].innerHTML = table.rows[i].cells[5].innerHTML.replace(divisa,'');
            }       
        }
        //calcular saldos
        for( var i = 1; i < table.rows.length; i++){
            table.rows[i].cells[5].innerHTML = parseFloat(table.rows[i].cells[3].innerHTML) - parseFloat(table.rows[i].cells[4].innerHTML);    

            
            //agregar divisas
            var divisa = "";
            if(table.rows[i].cells[2].innerHTML == 'USD'){
                divisa="$";
            }else if(table.rows[i].cells[2].innerHTML == 'QGT'){
                divisa="Q";
            }
            table.rows[i].cells[5].innerHTML = divisa + table.rows[i].cells[5].innerHTML;   
            table.rows[i].cells[4].innerHTML = divisa + table.rows[i].cells[4].innerHTML;   
            table.rows[i].cells[3].innerHTML = divisa + table.rows[i].cells[3].innerHTML;   
        }
    }
</script>