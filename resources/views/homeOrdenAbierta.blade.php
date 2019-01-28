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
                    <input id="id_proyecto" name="id_proyecto" type="hidden" value="{{ $e->id_proyecto }}">
                @endforeach
            @endif
        </div>
        
        <br><br>

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
                                    <div class="form-group">
                                        @if($p->divisa=='USD')
                                            <label for="tasa" class="control-label">Tasa de Cambio</label><br>
                                            <input id="id_txt_tasa" type="text" name="txt_tasa" class="form-control">
                                        @else
                                            <input id="id_txt_tasa" type="hidden" name="txt_tasa" class="form-control" value="1">
                                        @endif
                                    </div>
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
                                                <?php
                                                    }else{
                                                ?>
                                                    <input id="txtTotal_show" type="text" name="txt_total_show" class="form-control" readonly="readonly" value="Q {{ $o->total }}">
                                                <?php
                                                    }
                                                ?>
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
                                            <input id="id_txt_abono" name="txt_abono" type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- Fin del Contenido -->
                    </div> 
                </div>
            </div>
            <br>
        </form>
        
        
    </center>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
