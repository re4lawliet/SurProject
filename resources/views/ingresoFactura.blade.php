@extends('layouts.appRecepcion')


@section('content')

@if(count($queryOrden)>0)
    @foreach($queryOrden as $orden)
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{$orden->titulo_solicitud}}</center></h1>
            <input id="id_orden"name="id_orden" type="hidden" form="agregar" value="{{ $orden->id }}">
            <input id="id_proveedor"name="id_proveedor" type="hidden" form="agregar" value="{{ $orden->id_proveedor }}">
        </div>
        <center>
        <div>
            <h5>No. Orden: {{ $orden->no_orden }}</h5>
            <h5>Proveedor: {{$orden->nombre_empresa}}</h5>
            <h5>Proyecto: {{$orden->nombre_proyecto}}</h5>
        </div>
        </center>
    @endforeach
@endif
<br><br>
<center>
<div class="container">

            @foreach ($queryOrden as $orden)
                    @if($orden->pdf!=NULL)
                        <div  class="col-sm-7">
                            <button id="btn_pr" type="submit" form="no-form" class="btn btn-info" onclick="myFunction()">
                            Ver Orden</button>
                        </div>
                        <br>
                        <div class="col-sm-11" id="myDIV" style="display:none">
                            <div class="container">
                                
                                    <embed src="/{{ $orden->pdf }}" type="application/pdf" width="100%" height="600px">
                                
                            </div>
                        </div>
                    @else
                    <label style="background: #ddd;"> No hay Propuesta de Presupuesto</label>
                    @endif
            @endforeach

</div>
</center>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">FACTURAS</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session()->has('facturaAgregada'))
                    <center>
                        <div class="alert alert-success">
                            <h7><B>{{Session::get('facturaAgregada')}}</B></h7>
                            <br>
                            <button class="btn btn-success" onclick="location.href='/ingresoFacturaOrdenes'">
                                <i class="fa fa-btn fa-pencil"></i>OK
                            </button>
                        </div>
                    </center>
                    @endif
                    <form id="agregar" action="{{ url('AgregarFactura') }}" method="post">
                        {{ csrf_field() }}
                        <div>
                            <label for="orden" class="control-label">Serie</label>
                            <input id="serie"name="serie" type="text" class="form-control">
                        </div>
                        <div>
                            <label for="orden" class="control-label">No. Factura</label>
                            <input id="n_fact"name="n_fact" type="text" class="form-control">
                        </div>
                        <div>
                            <label for="orden" class="control-label">Fecha</label>
                            <input id="fecha"name="fecha" type="text" class="form-control">
                        </div>
                        <div>
                            <label for="orden" class="control-label">Monto</label>
                            <input id="monto"name="monto" type="text" class="form-control">
                        </div>
                        <div>
                            <label for="orden" class="control-label">Descrpcion</label>
                            <input id="descripcion"name="descripcion" type="text" class="form-control">
                        </div>
                        <br>
                        <div>
                            <button id="agregar" form="agregarr" onclick="validacion()" class="btn btn-success">Agregar Factura</button>
                        </div>

                        <br>
                        <DIV>
                            <center><h3>Historial Facturas</h3></center>
                            <center>
                                <br>
                                <table class="table table-striped task-table" >
                                    <thead>
                                        <th >Serie</th>
                                        <th >No. Factura</th>
                                        <th >Fecha</th>
                                        <th >Monto</th>
                                        <th >Descripcion</th>
                                    </thead>
                                    <tbody>
                                        @if(count($queryFacturas)>0)
                                            @foreach($queryFacturas as $fact)
                                                <tr>
                                                    <td >{{ $fact->serie }}</td>
                                                    <td >{{ $fact->no_factura }}</td>
                                                    <td >{{ $fact->fecha }}</td>
                                                    <td >{{ $fact->monto }}</td>
                                                    <td >{{ $fact->descripcion }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </center>
                        </DIV>
                        <br><br><br>
                    </form>







                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    function validacion(){
        var ide = document.getElementById("monto");
        var nfa = document.getElementById("n_fact");
        if(ide.value!==""){
            if(nfa.value!==""){
                document.forms["agregar"].submit();
            }else{
                alert('No ingreso numero de factura');
            }
        }else{
            alert('No ingreso monto');
        }
        
    }
</script>
<script>
    function myFunction() {
        var y = document.getElementById("btn_pr");
        var x = document.getElementById("myDIV");
        if (x.style.display === "none") {
            y.className = "btn btn-danger";
            y.innerHTML = "Esconder Cotizacion";
            x.style.display = "block";
        } else {
            x.style.display = "none";
            y.className = "btn btn-info"
            y.innerHTML = "Ver Cotizacion";
        }
    }
</script>