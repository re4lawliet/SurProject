<!-- ENCABEZADO -->
@extends('layouts.appDirector')
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
<<<<<<< HEAD

        
        
=======
        <br>
        <br>
        <h3> Cotizacion</h3>
        <div class="container">
            <embed src="/{{ Session::get('pdf_presupuesto') }}" type="application/pdf" width="100%" height="1150px">
        </div>
>>>>>>> 8be43520202d74a384d4d15e0392f35ceadbe5bd



        <div class="form-group">
            <a href="#">
                <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" onclick="location.href='/enviar_correo'">ENVIAR</button> 
            </a>
        </div>

    </center>
@endsection