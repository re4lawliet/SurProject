<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('title','Menu de Compras SUR')
@section('content')
        


        <center>
        <!--TITULO -->
        <div>
            @if(count($encabezado)>0)
                @foreach($encabezado as $e)
                    <h1>{{ $e->titulo_solicitud }}</h1>
                    <h6>No. Partida: {{ $e->id_partida }}</h6>
                    <h6>Nombre Partida: {{ $e->nombre }}</h6>
                    <h6>Solicitante: {{ $e->rol }}</h6>
                    <h6>Proyecto: "{{ $e->nombre_proyecto }}"</h6>
                    <input id="id_partida" name="id_partida" type="hidden" value="{{ $e->id_partida }}">
                    
                @endforeach
            @endif
        </div>
        
        <br><br>

        <form id="hacer_abono_frm" action="{{ url('CrearAbono') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <!-- Datos de Proveedor -->
            <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                        Datos de Proveedor
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        @if(count($proveedor)>0)
                            @foreach($proveedor as $p)
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <label for="Proveedor" class="control-label">Proveedor</label>
                                        <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor" value="{{ $p->nombre_empresa }}" readonly="readonly">
                                        <input  name="id_emp" name="id_emp" type="hidden" value="{{ $p->id_proveedor }}">
                                        <input type="hidden" id="txt_divisa" value="{{ $p->divisa }}">
                                        <?php
                                            $divisa = $p->divisa;
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre_banco" class="control-label">Nombre del Banco</label>
                                        <input type="text" name="nombre_proyecto" class="form-control" value="{{ $p->nombre_banco }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_cuenta" class="control-label">Tipo de la Cuenta</label>
                                        <input type="text" name="tipo_cuenta" class="form-control"   value="{{ $p->tipo_cuenta }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_cuenta" class="control-label">No. de la Cuenta</label>
                                        <input type="text" name="no_cuenta" class="form-control"   value="{{ $p->no_cuenta }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_pago" class="control-label">Tipo de Pago</label>
                                        <select name="tipo_pago" type="text" class="form-control">
                                            <option value="1">Transferencia</option>
                                            <option value="2">Cheque</option>
                                        </select>
                                    </div>
                                    <!--div class="form-group">
                                        @if($p->divisa=='USD')
                                            <label for="tasa" class="control-label">Tasa de Cambio</label><br>
                                            <input id="id_txt_tasa" type="text" name="txt_tasa" class="form-control">
                                        @else
                                            <input id="id_txt_tasa" type="hidden" name="txt_tasa" class="form-control" value="1">
                                        @endif
                                    </div-->
                                </div>  
                            @endforeach
                        @endif  
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
                        @if(count($detalle)>0)
                            <div class="col-sm-7">
                                <label for="detalle" class="control-label">Materiales Solicitados</label>
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
                                            @foreach ($detalle as $d)
                                                <tr>
                                                    <td style='display:none' class="table-text">{{ $d->id }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $d->cantidad }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $d->unidad }}</td>
                                                    <td style='text-align:center' class="table-text">{{ $d->descripcion }}</td>
                                                    <?php
                                                        if($divisa == 'USD'){
                                                    ?>
                                                        <td style='text-align:center' class="table-text" >$ {{ $d->precio_unitario }}</td>
                                                        <td style='text-align:center' class="table-text">$ {{ $d->subtotal }}</td>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <td style='text-align:center' class="table-text" >Q {{ $d->precio_unitario }}</td>
                                                        <td style='text-align:center' class="table-text">Q {{ $d->subtotal }}</td>
                                                    <?php
                                                        }
                                                    ?>
                                                </tr>
                                            @endforeach
                                            @if(count($orden)>0)
                                                @foreach($orden as $o)
                                                        @if($o->ajuste > 0)
                                                        <td style='display:none' class="table-text"></td>
                                                        <td style='text-align:center' class="table-text"></td>
                                                        <td style='text-align:center' class="table-text"></td>
                                                        <td style='text-align:center' class="table-text">Ajuste</td>
                                                        <?php
                                                            if($divisa == 'USD'){
                                                        ?>
                                                            <td style='text-align:center' class="table-text" ></td>
                                                            <td style='text-align:center' class="table-text">$ {{ $o->ajuste }}</td>
                                                        <?php
                                                            }else{
                                                        ?>
                                                            <td style='text-align:center' class="table-text" ></td>
                                                            <td style='text-align:center' class="table-text">Q {{ $o->ajuste }}</td>
                                                        <?php
                                                            }
                                                        ?>
                                                        @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <br>
                                    @if(count($orden)>0)
                                        @foreach($orden as $o)
                                            <div class="form-group">
                                                <label for="total" class="control-label">Total</label><br>
                                                <?php
                                                    if($divisa == 'USD'){
                                                ?>
                                                    <input id="txtTotal_show" type="text" name="txt_total_show" class="form-control" readonly="readonly" value="$ {{ $o->total }}">
                                                    <input type="hidden" name="txt_id_solicitud" value="{{ $o->id_solicitud }}">
                                                    <input type="hidden" name="txt_id_orden" value="{{ $o->id }}">
                                                <?php
                                                    }else{
                                                ?>
                                                    <input id="txtTotal_show" type="text" name="txt_total_show" class="form-control" readonly="readonly" value="Q {{ $o->total }}">
                                                    <input type="hidden" name="txt_id_solicitud" value="{{ $o->id_solicitud }}">
                                                    <input type="hidden" name="txt_id_orden" value="{{ $o->id }}">
                                                <?php
                                                    }
                                                ?>
                                                <input id="id_txt_tasa" type="hidden" name="txt_tasa" class="form-control" value="{{ $o->tasa_cambio }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                        <!-- Fin del Contenido -->
                    </div> 
                </div>
            </div>
            <br>
            <!-- Datos de Abonos -->
            <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                        Abonos
                    </div>
                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        @if(count($abonos)>0)
                            <div class="col-sm-7">
                                <label for="detalle" class="control-label">Historial de Abonos</label>
                                <div class="panel-body">
                                    <table id="tabla_de_abonos" name='tabla_de_abonos' class="table table-striped task-table">
                                        <!-- Encabezado de Tabla -->
                                        <thead>
                                            <th style='text-align:center' >Fecha</th>
                                            <th style='text-align:center' >Detalle</th>
                                            <th style='text-align:center' >Debe</th>
                                            <th style='text-align:center' >Haber</th>
                                            <th style='text-align:center' >Saldo</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            @foreach ($abonos as $a)
                                                <tr>
                                                    <td style='text-align:center' class="table-text">{{ $a->fecha }}</td>
                                                    <td style='text-align:center' class="table-text">Abono No. {{ $a->abono }}</td>
                                                    <?php
                                                        if($divisa == 'USD'){
                                                    ?>
                                                        @if($a->debe=='-')
                                                            <td style='text-align:center' class="table-text" ></td>
                                                        @else
                                                            <td style='text-align:center' class="table-text" >$ {{ $a->debe }}</td>
                                                        @endif
                                                        @if($a->haber=='-')
                                                            <td style='text-align:center' class="table-text" ></td>
                                                        @else
                                                            <td style='text-align:center' class="table-text" >$ {{ $a->haber }}</td>
                                                        @endif
                                                        @if($a->saldo=='-')
                                                            <td style='text-align:center' class="table-text" ></td>
                                                        @else
                                                            <td style='text-align:center' class="table-text" >$ {{ $a->saldo }}</td>
                                                        @endif
                                                    <?php
                                                        }else{
                                                    ?>
                                                        @if($a->debe=='-')
                                                            <td style='text-align:center' class="table-text" ></td>
                                                        @else
                                                            <td style='text-align:center' class="table-text" >Q {{ $a->debe }}</td>
                                                        @endif
                                                        @if($a->haber=='-')
                                                            <td style='text-align:center' class="table-text" ></td>
                                                        @else
                                                            <td style='text-align:center' class="table-text" >Q {{ $a->haber }}</td>
                                                        @endif
                                                        @if($a->saldo=='-')
                                                            <td style='text-align:center' class="table-text" ></td>
                                                        @else
                                                            <td style='text-align:center' class="table-text" >Q {{ $a->saldo }}</td>
                                                        @endif
                                                    <?php
                                                        }
                                                    ?>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <div class="form-group">
                                        @foreach($abonoMaximo as $max)
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <?php
                                                        if($divisa == 'USD'){
                                                    ?>
                                                        <span id="span_PrimerPago" class="input-group-text">Hacer Abono de: $</span>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <span id="span_PrimerPago" class="input-group-text">Hacer Abono de: Q</span>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <input type="hidden" id="inputmax" value ="{{ $max->saldo }}" >
                                                <input id="id_txt_abono" name="txt_abono" type="number" min="0" max="{{ $max->saldo }}" class="form-control" value="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                <input id="id_proyecto" name="id_proyecto" type="hidden" value="{{ $proyecto->id }}">
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
            <div class="form-group">
                <button name="btn_Orden" id="btn_Orden" form="crear_orden_frmmmm" type="submit" class="btn btn-primary" onclick="validacion()">Crear Orden</button> 
            </div>
        </form>
        
        
    </center>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    function validacion(){
        var btnEnv=document.getElementById("btn_Orden");
        btnEnv.disabled=true;

        var textdiv = document.getElementById("txt_divisa");
        var texttasa = document.getElementById("id_txt_tasa");
        var textboxTotal = document.getElementById("txtTotal_show");
        var txtAbono = document.getElementById("id_txt_abono");
        var textboxEnviara = document.getElementById("id_txt_enviara");
        var divisa="";
        var txtmax = document.getElementById("inputmax");
        
        if(textdiv.value!==""){//validando que haya seleccionado Proveedor
            if(textdiv.value=="USD"){
                divisa="$ ";
            }else if(textdiv.value=="GTQ"){
                divisa="Q ";
            }
            if(texttasa.value!==""){//validando que seleccionara Tasa de Cambio
                if(textboxTotal.value!==""){//validando que haya calculado TOTALES Y SUBTOTALES
                    document.getElementById("txtTotal_show").value = document.getElementById("txtTotal_show").value.replace(divisa,'');
                    if(textboxEnviara.value!==""){//validando que haya seleccionado ENVIAR A
                        if(txtAbono.value!==""){
                            var valAbono = parseFloat(txtAbono.value);
                            var valMax = parseFloat(txtmax.value);
                            if(valAbono<valMax){
                                if(confirm('Crear Abono?')){
                                    document.forms["hacer_abono_frm"].submit();
                                }else{
                                    btnEnv.disabled=false;
                                }
                            }else  if(valAbono==valMax){
                                if(confirm('Crear Abono?')){
                                    document.forms["hacer_abono_frm"].submit();
                                }else{
                                    btnEnv.disabled=false;
                                }
                            }else{
                                alert('No se puede realizar un abono mayor al saldo');
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