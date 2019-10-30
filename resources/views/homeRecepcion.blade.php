<!-- ENCABEZADO -->
@extends('layouts.appRecepcion')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Menu de Recepcion</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3><center>Ordenes Finalizadas: {{Session::get('countSolicitudesConta')}}</center></h3>
                    <br>
                    <center>
                    <button type="submit" class="btn btn-primary" onclick="location.href='/MostrarOrdenesFinalizadas'">
                        <i class="fa fa-btn fa-pencil"></i>Ir a Revision de Ordenes de Compra
                    </button>
                    </center>

                    <br><br><br>

                    <h3><center>Ingreso de Facturas</center></h3>
                    <br>
                    <center>
                    <button type="submit" class="btn btn-primary" onclick="location.href='/ingresoFacturaOrdenes'">
                        <i class="fa fa-btn fa-pencil"></i>Ir a Ingreso de Facturas
                    </button>
                    </center>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection