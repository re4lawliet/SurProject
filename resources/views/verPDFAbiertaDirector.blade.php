<!-- ENCABEZADO -->
@extends('layouts.appDirector')
@section('content')
    <center>
        <h1> Vista Previa Abono A Orden Abierta y Cotizacion</h1>
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



        <div class="form-group">
            <a href="#">
                <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" onclick="validacion()">APROBADO Y ENVIADO</button> 
            </a>
        </div>

    </center>
@endsection

<script>
        function validacion(){
            var btnEnv=document.getElementById("btn_Orden");
            btnEnv.disabled=true;
            location.href='/enviar_correoA';
        }
    
    </script>