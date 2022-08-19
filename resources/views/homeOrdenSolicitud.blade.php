<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('content')
        


        <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>

            <h6>No. Partida: "{{Session::get('s_id_partida', 'Seleccione Solicitud')}}"</h6>

            @if(count($partidas)>0)
                @foreach($partidas as $partida)
                <h6>Nombre Partida: "{{ $partida->nombre }}"</h6>
                <input id="id_partida" name="id_partida" type="hidden" value="{{ $partida->id }}">
                @endforeach
            @endif

            <h6>Solicitante: "{{Session::get('s_solicitante', 'Seleccione Solicitud')}}"</h6>
            @if(count($queryProyecto)>0)
                @foreach($queryProyecto as $proyecto)
                <h6>Proyecto: "{{ $proyecto->nombre_proyecto }}"</h6>
                <input id="id_proyecto" name="id_proyecto" type="hidden" value="{{ $proyecto->id }}">
                @endforeach
            @endif

            <h6>Proveedor sugerido: "{{Session::get('s_proveedor', 'Seleccione Solicitud')}}"</h6>
        </div>
        <br><br>
        <!-- enctype de este tipo para enviar datos del formulario que despues seran variables -->
        <form id="crear_orden_frm" action="{{ url('OrdenCreada') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
            
            <!-- Datos de Proveedor -->
            <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                        Datos de Proveedor
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="Proveedor" class="control-label">Proveedor</label>
                                <input type="hidden" class="form-control" name="input_prueba" value="asdf">
                                <div class="input-group">
                                    @if(count($queryProveedores)>0)
                                        @foreach($queryProveedores as $prov)
                                        <input type="text" class="form-control" id="selected" list="browsers" name="browser" value="{{ $prov->nombre_empresa }}" onclick="document.execCommand('selectAll',false,null)">
                                        <input  name="id_emp" type="hidden" value="{{ $prov->id }}">
                                        <input type="hidden" id="txt_divisa" value="{{ $prov->divisa }}">
                                        @endforeach
                                    @else
                                        <input type="text" class="form-control" id="selected" list="browsers" name="browser" onclick="document.execCommand('selectAll',false,null)" >
                                    @endif
                                    
                                    <datalist id="browsers">
                                        @foreach($queryEmpresas as $empresa)
                                        <option data-value="{{ $empresa->id }}" value="{{ $empresa->nombre_empresa }}"></option>
                                        @endforeach
                                    </datalist>
                                
                            <div class="input-group-append">
                                <button id="botoncito" form="No_Es_Parte_Del_Form" class="btn btn-primary">Seleccionar</button> 
                            </div>
                        </div>


                            </div> 
                            <div class="form-group">
                                <label for="nombre_banco" class="control-label">Nombre del Banco</label>
                                @if(count($queryProveedores)>0)
                                    @foreach($queryProveedores as $prov)
                                    <input type="text" name="nombre_proyecto" class="form-control" value="{{ $prov->nombre_banco }}" readonly="readonly">
                                    @endforeach
                                @else
                                    <input type="text" name="nombre_proyecto" class="form-control">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="tipo_cuenta" class="control-label">Tipo de la Cuenta</label>
                                @if(count($queryProveedores)>0)
                                    @foreach($queryProveedores as $prov)
                                    <input type="text" name="tipo_cuenta" class="form-control"   value="{{ $prov->tipo_cuenta }}" readonly="readonly">
                                    @endforeach
                                @else
                                    <input type="text" name="tipo_cuenta" class="form-control">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="no_cuenta" class="control-label">No. de la Cuenta</label>
                                @if(count($queryProveedores)>0)
                                    @foreach($queryProveedores as $prov)
                                    <input type="text" name="no_cuenta" class="form-control"   value="{{ $prov->no_cuenta }}" readonly="readonly">
                                    @endforeach
                                @else
                                    <input type="text" name="no_cuenta" class="form-control">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="tipo_pago" class="control-label">Tipo de Pago</label>
                                <select name="tipo_pago" type="text" class="form-control">
                                    <option value="1">Transferencia</option>
                                    <option value="2">Cheque</option>
                                </select>
                            </div>
                            
                            @if(count($queryProveedores)>0)
                                @foreach($queryProveedores as $prov)
                                    @if($prov->divisa=='USD')
                                    <label for="tasa" class="control-label">Tasa de Cambio</label><br>
                                    <input id="id_txt_tasa" type="text" name="txt_tasa" class="form-control">
                                    @else
                                    <input id="id_txt_tasa" type="hidden" name="txt_tasa" class="form-control" value="1">
                                    @endif
                                @endforeach
                            @endif
                            
                                
                        </div>
                        <!-- Fin del Contenido -->
                    </div> 
                </div>
            </div>
            <br>


            <!-- Detalle de Pedido -->
            <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                        Detalle de Facturacion
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-7">
                            <label for="detalle" class="control-label">Materiales Solicitados</label>
                            @if(count($queryListado)>0)
                                <div class="panel-body">
                                    <table id="tabla_de_detalle" name='tabla_de_detalle' class="table table-striped task-table">
                                        <!-- Encabezado de Tabla -->
                                        <thead>
                                            <th style='display:none' class="table-text">id</td>
                                            <th style='text-align:center' width="10%">Cantidad</th>
                                            <th style='text-align:center' width="10%">Unidad</th>
                                            <th style='text-align:center' width="50%">Descripcion</th>
                                            <th style='text-align:center' width="10%">Precio Unitario</th>
                                            <th style='text-align:center' width="20%">Subtotal</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($queryListado as $material)
                                                <input name="txt_id_solicitud" type="hidden" value="{{ $material->id_solicitud }}">
                                                <tr>
                                                    <td style='display:none' class="table-text">{{ $material->id }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $material->cantidad }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $material->unidad }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $material->descripcion }}</td>
                                                    <td style='text-align:center' class="editable" contenteditable="true" onclick="document.execCommand('selectAll',false,null)">0</td>
                                                    <td style='text-align:center' class="table-text"><div></div></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span id="span_ajuste" class="input-group-text">Ajuste</span>
                                        </div>
                                        <input id="id_txt_ajuste" name="txt_ajuste" type="text" class="form-control" value="0.0">
                                    </div>
                                    <br>
                                    <input id ="id_txt_ids" name="txt_ids" type="hidden" value="">
                                    <input id ="id_txt_precios_unitarios" name="txt_precios_unitarios" type="hidden" value="">
                                    <input id="id_txt_subtotales" name="txt_subtotales" type="hidden" value="">
                                </div>
                            @endif


                            <div class="form-group">
                                <button id="btn_subtotal" type="submit" form="No_Es_Parte_Del_Form" class="btn btn-primary" onclick="calcularTotales()">Calcular Totales</button><br><br>
                                <label for="total" class="control-label">Total</label><br>
                                <input id="txtTotal" type="hidden" name="txt_total" class="form-control" readonly="readonly">
                                <input type="hidden" id="mul">
                                <input id="txtTotal_show" type="text" name="txt_total_show" class="form-control" readonly="readonly">
                            </div>
                            <div>
                                <button form="No_Es_Parte_Del_Form" class="btn btn-primary" onclick="mostrarDivOrdenAbierta()">Orden Abierta</button>
                                <br>
                                <br>
                                <div id="div_Orden_Abierta" style="display:none;">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span id="span_PrimerPago" class="input-group-text">Primer Pago</span>
                                        </div>
                                        <input id="id_txt_primerpago" name="txt_primerpago" type="text" class="form-control" value="">
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Fin del Contenido -->
                    </div> 
                </div>
            </div>
            <br>
            <!-- Datos de Facturacion -->
            <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                        Datos de Facturacion
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-7">
                        <div class="form-group">
                            <label for="enviara" class="control-label">Enviar a:</label><br>
                            <input  id="id_txt_enviara" type="text" name="txt_enviara" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="total" class="control-label">Factura a:</label><br>
                            @if(count($queryProyecto)>0)
                                @foreach($queryProyecto as $proyecto)
                                <input id="facturaa" type="text" name="facturaa" class="form-control" readonly="readonly" value="{{ $proyecto->nombre_proyecto }}">
                                <input type="hidden" name="id_proyecto" value="{{ $proyecto->id }}">
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="nit" class="control-label">NIT:</label><br>
                            @if(count($queryProyecto)>0)
                                @foreach($queryProyecto as $proyecto)
                                <input id="nit" type="text" name="nit" class="form-control" readonly="readonly" value="{{ $proyecto->factura_numero }}">
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="dir_fiscal" class="control-label">Direccion Fiscal:</label><br>
                            <input id="nit" type="text" name="nit" class="form-control" readonly="readonly" value="Diagonal 6 19-30 Zona 10">
                        </div>
                        <div class="form-group">
                            <label for="total" class="control-label">Correos: (Separar por comas ',')</label><br>
                            <div class="tags-input" data-name="tags-input"></div>
                        </div>
                        </div>
                        <!-- Fin del Contenido -->
                    </div> 
                </div>
            </div>
            <br>
            <!-- Datos de Cotizacion -->
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        Propuesta de Cotizacion
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        @foreach ($querySolicitud as $sol)
                            @if($sol->presupuesto!=NULL)
                                <div class="col-sm-7">
                                    <button id="btn_pr" form="noForm" type="submit" class="btn btn-info" onclick="mostrarPresupuesto()">Ver Propuesta de Presupuesto</button>
                                </div>
                                <br>
                                <div class="col-sm-7" id="divPresupuesto" style="display:none">
                                    <embed src="/{{ $sol->presupuesto }}" type="application/pdf" width="100%" height="600px">
                                    <br><br>
                                    <label class="control-label">Cambiar Cotizacion</label>
                                    <input type="file" name="presupuesto" class="form-control" accept=".pdf">
                                </div>
                            @else
                                <label style="background: #ddd;"> No hay Propuesta de Cotizacion</label><br>
                                <label class="control-label">Agregar Presupuesto</label>
                                <input type="file" name="presupuesto" class="form-control" accept=".pdf">
                            @endif
                        @endforeach
                        
                        <!-- Fin del Contenido -->
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <button name="btn_Orden" id="btn_Orden" form="crear_orden_frmmmm" type="submit" class="btn btn-primary" onclick="validacion()">Crear Orden</button> 
            </div>
        </form>
        
        
    </center>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    function mostrarDivOrdenAbierta(){
        var div = document.getElementById("div_Orden_Abierta");
        divisa="";
        if(div.style.display === "none"){
            var textdiv = document.getElementById("txt_divisa");
            if(textdiv!==null){
                if(textdiv.value=="USD"){
                    divisa=" $ ";
                }else if(textdiv.value=="GTQ"){
                    divisa=" Q ";
                }
                var primerPago = document.getElementById("span_PrimerPago");
                primerPago.innerHTML = "Primer Pago "+divisa;
                div.style.display = "block";
            }else{
                alert('No ha seleccionado ningun proveedor y no existe divisa.');
            }
        }else{
            div.style.display = "none";
        }
        
    }
</script>
<script>
    function mostrarPresupuesto() {
        var y = document.getElementById("btn_pr");
        var x = document.getElementById("divPresupuesto");
        if (x.style.display === "none") {
            y.className = "btn btn-danger";
            y.innerHTML = "Esconder Propuesta de Presupuesto";
            x.style.display = "block";
        } else {
            x.style.display = "none";
            y.className = "btn btn-info"
            y.innerHTML = "Ver Propuesta de Presupuesto";
        }
    }
</script>

<script>
    $(document).ready(function() {
            var data = {}; 
            $("#browsers option").each(function(i,el) {  
            data[$(el).data("value")] = $(el).val();
        });

        // `data` : object of `data-value` : `value`
        console.log(data, $("#browsers option").val());

        $('#botoncito').click(function(){
            var value = $('#selected').val();
            var val_id_proveedor = $('#browsers [value="' + value + '"]').data('value');
            var val_id_proyecto = $('#id_proyecto').val();
            var val_id_partida = $('#id_partida').val();

            if(typeof val_id_proveedor === 'undefined'){
                alert('No ha seleccionado ningun Proveedor');
            }else{
                location.href='/OrdenSolicitud/{{Session::get('s_id')}}/'+val_id_partida+'/'+val_id_proyecto+'/'+val_id_proveedor;
            }
        });
    });
</script>
<script>
    function calcularTotales(){
        var textdiv = document.getElementById("txt_divisa");
        var table = document.getElementById("tabla_de_detalle");
        var str_precios_unitarios="";
        var str_subtotales="";
        var str_ids="";
        var divisa="";
        var total =0;
        if(textdiv!==null){
            if(textdiv.value=="USD"){
                divisa="$ ";
            }else if(textdiv.value=="GTQ"){
                divisa="Q ";
            }
        }else{
            alert('No ha seleccionado ningun proveedor y no existe divisa.');
        }
        //limpiando divisas
        for( var i = 1; i < table.rows.length; i++){
            if(table.rows[i].cells[5].innerHTML.indexOf(divisa)!== -1){
                table.rows[i].cells[5].innerHTML = table.rows[i].cells[5].innerHTML.replace(divisa,'');
            }
            if(table.rows[i].cells[4].innerHTML.indexOf(divisa)!== -1){
                table.rows[i].cells[4].innerHTML = table.rows[i].cells[4].innerHTML.replace(divisa,'');
            }
        }
        //calculando subtotales
        for( var i = 1; i < table.rows.length; i++){
            var resultado = parseFloat(table.rows[i].cells[1].innerHTML) * parseFloat(table.rows[i].cells[4].innerHTML);
            table.rows[i].cells[5].innerHTML = parseFloat(resultado).toFixed(2);
            str_ids = str_ids + table.rows[i].cells[0].innerHTML + ',';
            str_precios_unitarios = str_precios_unitarios + table.rows[i].cells[4].innerHTML + ',';
            str_subtotales = str_subtotales + table.rows[i].cells[5].innerHTML + ',';
            total = total + parseFloat(table.rows[i].cells[5].innerHTML);
            table.rows[i].cells[5].innerHTML = divisa + table.rows[i].cells[5].innerHTML;  
            table.rows[i].cells[4].innerHTML = divisa + table.rows[i].cells[4].innerHTML;         
        }
        total = total + parseFloat(document.getElementById("id_txt_ajuste").value);
        str_ids = str_ids.slice(0,-1);
        str_precios_unitarios = str_precios_unitarios.slice(0,-1);
        str_subtotales = str_subtotales.slice(0,-1);
        document.getElementById("id_txt_ids").value = str_ids;
        document.getElementById("id_txt_precios_unitarios").value = str_precios_unitarios;
        document.getElementById("id_txt_subtotales").value = str_subtotales;
        document.getElementById("txtTotal").value = total.toFixed(2);
        document.getElementById("txtTotal_show").value = divisa + total.toFixed(2);
        var mult = parseFloat(document.getElementById("txtTotal").value) * parseFloat(document.getElementById("id_txt_tasa").value);
        document.getElementById("mul").value = mult.toFixed(2);
    }

    function validacion(){
        var btnEnv=document.getElementById("btn_Orden");
        btnEnv.disabled=true;

        var textdiv = document.getElementById("txt_divisa");
        var texttasa = document.getElementById("id_txt_tasa");
        var textboxTotal = document.getElementById("id_txt_ids");
        var textboxEnviara = document.getElementById("id_txt_enviara");
        var txtOrdenAbierta = document.getElementById("id_txt_primerpago");
        if(textdiv!==null){//validando que haya seleccionado Proveedor
            if(texttasa.value!==""){//validando que seleccionara Tasa de Cambio
                if(textboxTotal.value!==""){//validando que haya calculado TOTALES Y SUBTOTALES
                    if(textboxEnviara.value!==""){//validando que haya seleccionado ENVIAR A
                        if(txtOrdenAbierta.value!==""){
                            if(confirm('Crear Orden de Pago Abierta?')){
                                document.forms["crear_orden_frm"].submit();
                            }else{
                                btnEnv.disabled=false;
                            }
                        }else{
                            if(confirm('Crear Orden de Pago?')){
                                document.forms["crear_orden_frm"].submit();
                            }else{
                                btnEnv.disabled=false;
                            }
                        }
                    }else{
                        alert('No se ha designado direccion de envio');
                        btnEnv.disabled=false;
                    }
                }else{
                    alert('No se han calculado los detalles de subtotales y totales.');
                    btnEnv.disabled=false;
                }
            }else{
                alert('El proveedor es una cuenta en dolares y no ha designado la Tasa de Cambio.');
                btnEnv.disabled=false;
            }
        }else{
            alert('No ha seleccionado ningun proveedor.');
            btnEnv.disabled=false;
        }
        
        
        
    }

</script>
