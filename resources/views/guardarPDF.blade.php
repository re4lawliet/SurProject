<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('content')
    <center>
        <h1> Vista Previa</h1>
        <div class="container">
            <embed src="{{ $path }}" type="application/pdf" width="100%" height="1150px">
        </div>
        <div class="form-group">
            <a href="{{ url('/MostrarSolicitudesCompras') }}">
                <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" >OK</button> 
            </a>
        </div>
    </center>
@endsection