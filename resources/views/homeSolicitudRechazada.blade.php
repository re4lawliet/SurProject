<!-- ENCABEZADO -->
@extends('layouts.appCompras')

@section('content')

    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('r_nsolicitud')}}</center></h1>
        </div>

        <div>
            <h5>Nombre Proveedor: "{{Session::get('r_nproveedor', 'Seleccione Solicitud')}}"</h5>
            <h5>Nombre Proyecto: "{{Session::get('r_nproyecto', 'Seleccione Solicitud')}}"</h5>
            <br>
            <h5>Fecha de Creacion de Orden: "{{Session::get('r_fechacreacion', 'Seleccione Solicitud')}}"</h5>
            <h5>Fecha de Rechazo de Orden (Contabilidad): "{{Session::get('r_fecharechazo', 'Seleccione Solicitud')}}"</h5>
            <br>
            <br>
            <h4>Comentario (Contabilidad): "{{Session::get('r_comentario', 'Seleccione Solicitud')}}"</h4>

        </div>
        <br><br>
        
        <div class="col-sm-7">
            <button id="btn_pr" form="noForm" type="submit" class="btn btn-info" onclick="mostrarPresupuesto()">Ver Orden de Compra</button>
        </div>
        <br>
        <div class="col-sm-7" id="divPresupuesto" style="display:none">
            <embed src="/{{ Session::get('r_npdf', 'pdf invalido') }}" type="application/pdf" width="100%" height="600px">
            <br><br>
            
        </div>

        

        <br>
        <br>
        <div>
            <button type="submit" class="btn btn-success" onclick="location.href='/homeCompras'">
                <i class="fa fa-btn fa-pencil"></i>Home
            </button>
            
            <button type="submit" class="btn btn-danger" onclick="location.href='/AceptarSolicitudRechazada/{{Session::get('r_id')}}'">
                    <i class="fa fa-btn fa-pencil" ></i> Eliminar de Notificaciones
            </button>             
            
            <button type="submit" class="btn btn-primary" onclick="location.href='/OrdenSolicitudRechazada/{{Session::get('r_idsol')}}/{{Session::get('r_idpart')}}/{{Session::get('r_idproy')}}'">
                <i class="fa fa-btn fa-pencil" ></i> Rehacer Toda la Orden de Compra
            </button>
            
            <button type="submit" class="btn btn-dark" onclick="location.href='/ReenviarSolicitudRechazada/{{Session::get('r_id')}}'">
                <i class="fa fa-btn fa-pencil" ></i> Reenviar Solicitud Sin Cambios
            </button>   

            @foreach ($querySolicitud as $soli)
                @if($soli->abierta==1 && $soli->abono>1)
                <button type="submit" class="btn btn-warning" onclick="location.href='/OrdeneAbiertaRehacer/{{ Session::get('r_id') }}'">
                    <i class="fa fa-btn fa-pencil" ></i> Rehacer Ultimo Abono
                </button>
                @endif
            @endforeach

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