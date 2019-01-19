<!-- ENCABEZADO -->
@extends('layouts.appDirector')
@section('content')
    <center>
        <h1> Vista Previa</h1>
        @foreach($orden as $o)
        <div class="container">
            <embed src="/{{ $o->pdf }}" type="application/pdf" width="100%" height="1150px">
        </div>
        @endforeach
        <div class="form-group">
            <a href="#">
                <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" >ENVIAR</button> 
            </a>
        </div>
    </center>
@endsection