<!-- ENCABEZADO -->
@extends(
    Auth::user()->rol == 'colaborador' ? 'layouts.appColaborador' :
        ( Auth::user()->rol == 'manager' ? 'layouts.appManager' : 
            (Auth::user()->rol == 'director' ? 'layouts.appDirector' : 
                (Auth::user()->rol == 'compras' ? 'layouts.appCompras' :
                    (Auth::user()->rol == 'recepcion' ? 'layouts.appRecepcion' : 'layouts.appAdmin'))))
    )
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ERROR</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3><center>Error en Operacion:</center></h3>
                    <br>
                    <br>
                    @if (session('catch_error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('catch_error') }}
                        </div>
                    @endif
                    <br><br><br> 

<div class="container">
    <h4><center><B><font color="red">Existio un Error en la Operacion Realizada Intente Realizarla De nuevo </font></center></h4>
    <br>
    <center>
    <button type="submit" class="btn btn-success" onclick="location.href='/homes'">
        <i class="fa fa-btn fa-pencil"></i>Regresar A Home
    </button>
    </center>
    
</div>
@endsection