<!-- ENCABEZADO -->
@extends(
    Auth::user()->rol == 'colaborador' ? 'layouts.appColaborador' :
        ( Auth::user()->rol == 'manager' ? 'layouts.appManager' : 
            (Auth::user()->rol == 'director' ? 'layouts.appDirector' : 
                (Auth::user()->rol == 'compras' ? 'layouts.appCompras' :
                    (Auth::user()->rol == 'recepcion' ? 'layouts.appRecepcion' : 
                        (Auth::user()->rol == 'contabilidad' ? 'layouts.appContabilidad' : 'layouts.appAdmin')))))
    )
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



        <div class="form-group">
            <a href="#">
                <button name="btn_Orden" id="btn_Orden"  type="submit" class="btn btn-success" onclick="location.href='/homes'">HOME</button> 
                <button type="submit" class="btn btn-danger" onclick="location.href='/AceptarSolicitudRechazada/{{Session::get('pdf_idOrden')}}'">
                    <i class="fa fa-btn fa-pencil" ></i> Eliminar de Notificaciones
                </button>    
            </a>
        </div>


    </center>
@endsection