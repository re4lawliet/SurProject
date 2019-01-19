<!-- ENCABEZADO -->
@extends('layouts.appContabilidad')

@section('content')

    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('c_nsolicitud')}}</center></h1>
        </div>

        <div>
            <h5>Nombre Proveedor: "{{Session::get('c_nproveedor', 'Seleccione Solicitud')}}"</h5>
            <h5>Nombre Proyecto: "{{Session::get('c_nproyecto', 'Seleccione Solicitud')}}"</h5>
           
        </div>
        <br><br>
        
        <div class="col-sm-7">
            <button id="btn_pr" form="noForm" type="submit" class="btn btn-info" onclick="mostrarPresupuesto()">Ver Propuesta de Presupuesto</button>
        </div>
        <br>
        <div class="col-sm-7" id="divPresupuesto" style="display:none">
            <embed src="/{{ Session::get('c_npdf', 'pdf invalido') }}" type="application/pdf" width="100%" height="600px">
            <br><br>
            
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
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-pencil"></i> Rechazar Orden de Compra
                </button>    
            </form>  
            <button type="submit" class="btn btn-success" onclick="location.href='/AceptarSolicitudContador/{{Session::get('c_id')}}'">
                <i class="fa fa-btn fa-pencil"></i>Aceptar Orden de Compra
            </button>     

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
                y.innerHTML = "Esconder Propuesta de Presupuesto";
                x.style.display = "block";
            } else {
                x.style.display = "none";
                y.className = "btn btn-info"
                y.innerHTML = "Ver Propuesta de Presupuesto";
            }
        }
</script>