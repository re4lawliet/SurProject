@extends('layouts.appContabilidad')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Menu de Contabilidad</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3><center>Ordenes Pendientes: {{Session::get('countSolicitudesConta')}}</center></h3>
                    <br>
                    <br>
                    <center>
                    <button type="submit" class="btn btn-primary" onclick="location.href='/MostrarSolicitudesContador'">
                        <i class="fa fa-btn fa-pencil"></i>Ir a Revision de Ordenes de Compra
                    </button>
                    </center>
                        

                    <br><br><br>

                    <h3><center>Ordenes Aprobadas: {{Session::get('countSolicitudesContaFinalizadas')}}</center></h3>
                    <br>
                    <br>
                    <center>
                    <button type="submit" class="btn btn-primary" onclick="location.href='/MostrarSolicitudesContadorFinalizadas'">
                        <i class="fa fa-btn fa-pencil"></i>Ir a Revision de Ordenes de Compra Finalizadas
                    </button>
                    </center>
                        

                    <br><br><br>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection