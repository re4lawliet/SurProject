<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('content')
    <center>
        <h1> Vista Previa</h1>
        <div class="container">
            <embed src="{{ $path }}" type="application/pdf" width="100%" height="1150px">
        </div>
        <div class="form-group">
            @if($salida=='0')
                <a href="{{ url('/MostrarSolicitudesCompras') }}">
                    <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" >OK</button> 
                </a>
            @elseif($salida=='1')
                <a href="{{ url('/MostrarOrdenesAbiertas') }}">
                    <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" >OK</button> 
                </a>
            @endif
        </div>
    </center>
@endsection