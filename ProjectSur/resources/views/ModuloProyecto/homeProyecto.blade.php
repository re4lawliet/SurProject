@extends('layouts.appProyecto')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{Session::get('proyectoGnombre', 'Seleccione Proyecto')}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3><center>Menu de Proyecto:</center></h3>
                    <br>
                    <br>

            <div class="panel panel-default">
                
                <div class="panel-heading">
                        <div class="title m-b-md">
                    
                            <center><img src="{{Session::get('proyectoGlogo_proyecto', 'Seleccione Proyecto')}}" width="400" height="300"></center>
                                
                        </div>
                        <br>
                        <br>
                        <h2>Proyecto: "{{Session::get('proyectoGnombre', 'Seleccione Proyecto')}}"</h2>
                        <h4>Zona: "{{Session::get('proyectoGzona_proyecto', 'Seleccione Proyecto')}}"</h4>
                        <h4>Estado: "{{Session::get('proyectoGestado_proyecto', 'Seleccione Proyecto')}}"</h4>
                        <h4>Factura a: "{{Session::get('proyectoGfactura_a', 'Seleccione Proyecto')}}"</h4>
                        <h4>Nit: "{{Session::get('proyectoGfactura_numero', 'Seleccione Proyecto')}}"</h4>
                </div>

                <br>
                <button type="submit" class="btn btn-primary" onclick="location.href=''">
                    <i class="fa fa-btn fa-pencil"></i>Presupuesto          
                </button>

                <button type="submit" class="btn btn-secondary" onclick="location.href=''">
                    <i class="fa fa-btn fa-pencil"></i>Orden de Compra
                </button>
                
                <button type="submit" class="btn btn-success" onclick="location.href=''">
                    <i class="fa fa-btn fa-pencil"></i>Solicitud de Materiales
                </button>

            </div>
        </div>



        Mi Proyecto: {{Session::get('proyectoG', 'Seleccione Proyecto')}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection