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


<br>
        <div class="form-group">
            <a href="#">
                <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" onclick="location.href='/enviar_correo'">APROBADO Y ENVIADO</button> 
            </a>
        </div>

    </center>
@endsection