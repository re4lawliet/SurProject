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
        <form id="crear_orden_frm" action="{{ url('OrdenCreada') }}" method="POST" >
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
                                        <input type="text" class="form-control" id="selected" list="browsers" name="browser" value="{{ $prov->nombre_empresa }}">
                                        <input  name="id_emp" type="hidden" value="{{ $prov->id }}">
                                        @endforeach
                                    @else
                                        <input type="text" class="form-control" id="selected" list="browsers" name="browser" >
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
                                                    <td style='text-align:center' class="editable" contenteditable="true">0</td>
                                                    <td style='text-align:center' class="table-text"><div></div></td>
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
                                <button id="btn_subtotal" type="submit" form="No_Es_Parte_Del_Form" class="btn btn-primary" onclick="calcularSubtotal()">Calcular Subtotales</button> 
                            </div>
                            

                            <div class="form-group">
                                <label for="total" class="control-label">Total</label><br>
                                <button id="btn_subtotal" type="submit" form="No_Es_Parte_Del_Form" class="btn btn-primary" onclick="calcularTotal()">Calcular Total</button>
                                <input id="txtTotal" type="text" name="txt_total" class="form-control" readonly="readonly">
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
                            <input  type="text" name="txt_enviara" class="form-control">
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

            <div class="form-group">
                <button name="btn_Orden" id="btn_Orden" form="crear_orden_frm" type="submit" class="btn btn-primary">Crear Orden</button> 
            </div>
        </form>
        
        
    </center>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btn_Orden').click(function(){
            var value = $('#selected').val();
            var val_id_proveedor = $('#browsers [value="' + value + '"]').data('value');
            var val_id_proyecto = $('#id_proyecto').val();
            var val_id_partida = $('#id_partida').val();
            var val_table = document.getElementById("tabla_de_detalle");

            location.href='/OrdenSolicitud/{{Session::get('s_id')}}/'+val_id_partida+'/'+val_id_proyecto+'/'+val_id_proveedor+'/'+val_table;
        });
    });
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
        //alert(iden);
        var val_id_proyecto = $('#id_proyecto').val();
        var val_id_partida = $('#id_partida').val();

        location.href='/OrdenSolicitud/{{Session::get('s_id')}}/'+val_id_partida+'/'+val_id_proyecto+'/'+val_id_proveedor;
        });
    });
</script>
<script>
    function calcularSubtotal() {
        var table = document.getElementById("tabla_de_detalle");
        var str_precios_unitarios="";
        var str_subtotales="";
        var str_ids="";
        for( var i = 1; i < table.rows.length; i++){
            table.rows[i].cells[5].innerHTML = parseFloat(table.rows[i].cells[1].innerHTML) * parseFloat(table.rows[i].cells[4].innerHTML);
            str_ids = str_ids + table.rows[i].cells[0].innerHTML + ',';
            str_precios_unitarios = str_precios_unitarios + table.rows[i].cells[4].innerHTML + ',';
            str_subtotales = str_subtotales + table.rows[i].cells[5].innerHTML + ',';
        }
        str_ids = str_ids.slice(0,-1);
        str_precios_unitarios = str_precios_unitarios.slice(0,-1);
        str_subtotales = str_subtotales.slice(0,-1);
        document.getElementById("id_txt_ids").value = str_ids;
        document.getElementById("id_txt_precios_unitarios").value = str_precios_unitarios;
        document.getElementById("id_txt_subtotales").value = str_subtotales;
    }

    function calcularTotal(){
        var table = document.getElementById("tabla_de_detalle");
        var total =0;
        for( var i = 1; i < table.rows.length; i++){
          total = total + parseFloat(table.rows[i].cells[5].innerHTML);
        }
        document.getElementById("txtTotal").value = total;
    }
</script>