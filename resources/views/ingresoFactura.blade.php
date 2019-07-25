@extends('layouts.appRecepcion')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Menu de Recepcion</div>

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
                            <button type="submit" class="btn btn-success" onclick="location.href='homeRecepcion'">
                                <i class="fa fa-btn fa-pencil"></i>OK
                            </button>
                        </div>
                    </center>
                    @endif
                    <form id="agregar" action="{{ url('AgregarFactura') }}" method="post">
                        {{ csrf_field() }}
                    <label for="Proveedor" class="control-label">Proveedor</label>
                    <div class="input-group">
                        @if(count($queryProveedores)>0)
                            @foreach($queryProveedores as $prov)
                            <input type="text" class="form-control" id="selected" list="browsers" name="browser" value="{{ $prov->nombre_empresa }}" onclick="document.execCommand('selectAll',false,null)">
                            <input  name="id_emp" id="id_emp" type="hidden" value="{{ $prov->id }}">
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
                    <br>
                    <div>
                        <label for="orden" class="control-label">No. Factura</label>
                        <input id="n_fact"name="n_fact" type="text" class="form-control">
                    </div>
                    <br>
                    <div>
                        <button id="agregar" form="agregarr" onclick="validacion()" class="btn btn-success">Agregar Factura</button>
                    </div>


                    
                    </form>







                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

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
                location.href='/ingresoFactura/'+val_id_proveedor;
            }
        });
    });

    function validacion(){
        var ide = document.getElementById("id_emp");
        var nfa = document.getElementById("n_fact");
        if(ide!==null){
            if(nfa.value!==""){
                document.forms["agregar"].submit();
            }else{
                alert('No ingreso numero de factura');
            }
        }else{
            alert('No selecciono proveedor');
        }
        
    }
</script>