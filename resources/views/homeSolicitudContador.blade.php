<!-- ENCABEZADO -->
@extends('layouts.appContabilidad')

@section('content')

    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('c_nsolicitud')}}</center></h1>
        </div>

        <div>
            <h5>Nombre Proyecto: "{{Session::get('c_nproyecto', 'Seleccione Solicitud')}}"</h5>
           
        </div>
        <br><br>
        
        <h3>Mostrar ORDEN:</h3>
        <div class="col-sm-7">
            <button id="btn_pr" form="noForm" type="submit" class="btn btn-info" onclick="mostrarPresupuesto()">Ver Orden de Compra</button>
        </div>
        <br>
        <div class="col-sm-7" id="divPresupuesto" style="display:none">
            <embed src="/{{ Session::get('c_npdf', 'pdf invalido') }}" type="application/pdf" width="100%" height="600px">
            <br><br>
            
        </div>

        <br><br>
        <h3>Mostrar Presupuesto:</h3>
        <div class="col-sm-7">
            <button id="btn_pr2" form="noForm" type="submit" class="btn btn-info" onclick="mostrarPresupuesto2()">Ver Propuesta de Cotizacion</button>
        </div>
        <br>
        <div class="col-sm-7" id="divPresupuesto2" style="display:none">
            <embed src="/{{ Session::get('c_npdfpresupuesto', 'pdf invalido') }}" type="application/pdf" width="100%" height="600px">
            <br><br>
            
        </div>

        <br>
        <br>
        <div class="col-sm-7">
            <h3>Informacion del Proveedor</h3>
            @foreach($proveedores as $p)
                <label>Nombre de Proveedor: {{ $p->nombre_empresa }}</label><br>
                <label>NIT de Proveedor: {{ $p->nit_empresa }}</label><br>
                <label>Nombre del Banco: {{ $p->nombre_banco }}</label><br>
                <label>No. de Cuenta: {{ $p->no_cuenta }}</label><br>
                <label>Tipo de Cuenta: {{ $p->tipo_cuenta }}</label><br>
            @endforeach
        </div>
        <br>
        <br>
        <div>
            <form action="{{ url('RechazarSolicitudContador') }}/{{ Session::get('c_id', '0') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                <div class="col-sm-7">
                <label for="comentario" class="control-label">Agregue Comentario si Rechaza la Solicitud</label>
                <input type="text" name="comentario" class="form-control" value="">
                </div>  
                <br>
                <!-- Boton Rechazar -->
                <button type="submit" class="btn btn-danger" name="rechazar_orden">
                    <i class="fa fa-btn fa-pencil"></i> Rechazar Orden de Compra
                </button>    
                <button type="submit" class="btn btn-success" name="aceptar_orden">
                    <i class="fa fa-btn fa-pencil"></i>Aceptar Orden de Compra
                </button>     
            </form>  

            

        </div>
        
    </center>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
        function mostrarPresupuesto() {
            var y = document.getElementById("btn_pr");
            var x = document.getElementById("divPresupuesto");
            if (x.style.display === "none") {
                y.className = "btn btn-danger";
                y.innerHTML = "Esconder Orden de Compra";
                x.style.display = "block";
            } else {
                x.style.display = "none";
                y.className = "btn btn-info"
                y.innerHTML = "Ver Orden de Compra";
            }
        }

        function mostrarPresupuesto2() {
            var y = document.getElementById("btn_pr2");
            var x = document.getElementById("divPresupuesto2");
            if (x.style.display === "none") {
                y.className = "btn btn-danger";
                y.innerHTML = "Esconder Propuesta de Cotizacion";
                x.style.display = "block";
            } else {
                x.style.display = "none";
                y.className = "btn btn-info"
                y.innerHTML = "Ver Propuesta de Cotizacion";
            }
        }
</script>