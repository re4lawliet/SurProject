<!-- ENCABEZADO -->
@extends('layouts.appDirector')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@section('content')
    <center>
        <h1> Vista Previa Orden y Cotizacion</h1>
        <br>
        <h3> Orden de Compra</h3>
        @foreach($orden as $o)
        <div class="container">
            <embed src="/{{ $o->pdf }}" type="application/pdf" width="100%" height="1150px">
        </div>
        @endforeach
        <br>
        <br>
        <h3> Cotizacion</h3>
        <div class="container">
            <embed src="/{{ Session::get('pdf_presupuesto') }}" type="application/pdf" width="100%" height="1150px">
        </div>


<br>a
        <div class="form-group">
            <a href="#">
                <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" onclick="validacion()">APROBADO Y ENVIADO</button> 
            </a>

            @foreach($orden as $o)
            <form action="{{ url('RechazarOrdenDirector') }}/{{ $o->id }}" method="POST">
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
            </form> 
            @endforeach
            
        </div>

    </center>
@endsection

<script>
    function validacion(){
        var btnEnv=document.getElementById("btn_Orden");
        btnEnv.disabled=true;
        location.href='/enviar_correo';
    }

</script>