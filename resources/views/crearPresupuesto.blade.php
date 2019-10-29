<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('content')
        <center>
        <!--TITULO -->
        <div>

            <h1>CREACION DE PRESUPUESTO</h1>
            
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
                            <h6>Proyecto: {{ $proyecto->nombre_proyecto }}</h6>
                            <input id="id_txt_id_proyecto" name="txt_id_proyecto" type="hidden" value="{{ $proyecto->id }}">
                        @endforeach
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-12">
                            <br>
                            @if(count($nuevas)>0)
                                <div class="panel-body">
                                    <table id="tabla_de_detalle" name="tabla_de_detalle" class="table table-striped task-table">
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
                                            @foreach ($nuevas as $nueva)
                                                <tr>
                                                    <td style='text-align:center; display:none;' class="table-text">{{ $nueva->id_partida }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $nueva->nombre }}</td>
                                                    <td style='text-align:center' class="editable" contenteditable="true" onclick="document.execCommand('selectAll',false,null)" >Q {{ $nueva->presupuesto }}</td>                                                    
                                                    <td style='text-align:center' class="table-text"  >Q {{ $nueva->orden_sumada }}</td>                                                    
                                                    <td style='text-align:center' class="table-text"  >Q {{ $nueva->saldo }}</td>                                                    
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td id="td_Totales" style='text-align:center; display:none;' class="table-text"> TOTALES </td>
                                                <td id="td_Totales" style='text-align:center' class="table-text"> TOTALES </td>
                                                <td id="td_Presupuesto" style='text-align:center' class="table-text"> 0 </td>
                                                <td id="td_Ordenes" style='text-align:center' class="table-text"> 0 </td>
                                                <td id="td_Saldo" style='text-align:center' class="table-text"> 0 </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input id ="id_txt_ids" name="txt_ids" type="hidden" value="">
                                    <input id ="id_txt_presupuestos" name="txt_presupuestos" type="hidden" value="">
                                    <input id ="id_txt_orden_sumada" name="txt_orden_sumada" type="hidden" value="">
                                    <input id ="id_txt_saldos" name="txt_saldos" type="hidden" value="">
                                </div>
                            @endif

                            <br>
                            <div class="form-group">
                                <button id="btn_subtotal" type="submit" form="No_Es_Parte_Del_Form" class="btn btn-primary" onclick="calcularSaldos()">Calcular Saldos y Totales</button><br><br>

                                </div>
                            </div>
                            <!-- Fin del Contenido -->
                        </div> 
                    </div>
                </div>
                <br>
                <div class="">
                    <button id="btn_subtotal" type="submit" form="crear_presupuesto_frm" class="btn btn-success">Guardar Presupuesto</button>
                    &nbsp;&nbsp;&nbsp;
                    <button id="btn_subtotal" type="submit" form="no_form" class="btn btn-primary"  onclick="irVista()">Ver Detalle Presupuesto</button>
                </div>
            </div>
            
        </form>
        
        
    </center>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    function calcularSaldos(){
        var table = document.getElementById("tabla_de_detalle");
        //limpiar divisas
        for( var i = 1; i < table.rows.length; i++){
            var divisa = "Q";
            if(table.rows[i].cells[3].innerHTML.indexOf(divisa)!== -1){
                table.rows[i].cells[3].innerHTML = table.rows[i].cells[3].innerHTML.replace(divisa,'');
            }
            if(table.rows[i].cells[4].innerHTML.indexOf(divisa)!== -1){
                table.rows[i].cells[4].innerHTML = table.rows[i].cells[4].innerHTML.replace(divisa,'');
            } 
            if(table.rows[i].cells[2].innerHTML.indexOf(divisa)!== -1){
                table.rows[i].cells[2].innerHTML = table.rows[i].cells[2].innerHTML.replace(divisa,'');
            }       
        }

        var ids="";
        var presupuestos="";
        var ordenes_sumadas="";
        var saldos="";
        var sumpresu=0;
        var sumorden=0;
        var sumsaldos=0;
        for( var i = 1; i < table.rows.length-1; i++){
            //calculos
            table.rows[i].cells[4].innerHTML = parseFloat(table.rows[i].cells[2].innerHTML) - parseFloat(table.rows[i].cells[3].innerHTML);    
            //concatenaciones
            ids = ids + table.rows[i].cells[0].innerHTML + ',';
            presupuestos = presupuestos + parseFloat(table.rows[i].cells[2].innerHTML).toFixed(2) + ',';
            ordenes_sumadas = ordenes_sumadas + parseFloat(table.rows[i].cells[3].innerHTML).toFixed(2) + ',';
            saldos = saldos + parseFloat(table.rows[i].cells[4].innerHTML).toFixed(2) + ',';
            //suma totales
            sumpresu = sumpresu + parseFloat(table.rows[i].cells[2].innerHTML);
            sumorden = sumorden + parseFloat(table.rows[i].cells[3].innerHTML);
            sumsaldos = sumsaldos + parseFloat(table.rows[i].cells[4].innerHTML);
            //formato
            var x = parseFloat(table.rows[i].cells[2].innerHTML);
            var y = parseFloat(table.rows[i].cells[3].innerHTML);
            var z = parseFloat(table.rows[i].cells[4].innerHTML);
            table.rows[i].cells[2].innerHTML = "Q " + x.toFixed(2);   
            table.rows[i].cells[3].innerHTML = "Q " + y.toFixed(2);   
            table.rows[i].cells[4].innerHTML = "Q " + z.toFixed(2);   
        }
        
        document.getElementById("td_Presupuesto").innerHTML ="Q " + sumpresu.toFixed(2);
        document.getElementById("td_Ordenes").innerHTML ="Q " + sumorden.toFixed(2);
        document.getElementById("td_Saldo").innerHTML ="Q " + sumsaldos.toFixed(2);

        //limpiando ultima coma
        ids = ids.slice(0,-1);
        presupuestos = presupuestos.slice(0,-1);
        ordenes_sumadas = ordenes_sumadas.slice(0,-1);
        saldos = saldos.slice(0,-1);
        //colocar concatenaciones en textbos hidden
        document.getElementById("id_txt_ids").value = ids;
        document.getElementById("id_txt_presupuestos").value = presupuestos;
        document.getElementById("id_txt_orden_sumada").value = ordenes_sumadas;
        document.getElementById("id_txt_saldos").value = saldos;
        
        
    }
    
</script>
<script>
function irVista(){
        var idp = document.getElementById("id_txt_id_proyecto").value;
        location.href="/vistaPresupuesto/"+idp;
    }
</script>