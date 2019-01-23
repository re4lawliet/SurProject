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
        <div class="btn btn-default btn-file">
            <i class="fa fa-paperclip"></i> Adjuntar Archivo {{Session::get('pdf_enviar')}}
            <input type="file"  id="file" name="file" class="email_archivo" >
        </div>
        <p class="help-block"  >Max. 20MB</p>
        <div id="texto_notificacion">
        
        </div>
        </div>

        <div class="form-group">
            <a href="#">
                <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" onclick="location.href='/enviar_correo'">ENVIAR</button> 
            </a>
        </div>

    </center>
@endsection