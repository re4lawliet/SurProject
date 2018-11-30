@extends('layouts.appProyecto')

@section('content')
<!-- Inicio del Contenido de Pagina -->
<center>
    <div class="panel-title">
        <h1><center>Solicitud de Proyecto</center></h1>
    </div>

<div class="col-sm-offset-3 col-sm-6">
    <div class="panel-title">
            <h3><center>Registrar Solicitud:</center></h3>
    </div>
    <div class="panel-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="card-body">
            @if(Session::has('message'))
                <div class="alert alert-success">
                <h7><B>{{Session::get('message')}}</B></h7>
                </div>
            @endif
        </div>
        <form action="{{ url('solicitudes') }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="proveedor" class="control-label">Proveedor</label>
                <input type="text" name="proveedor" class="form-control">
            </div>  

            <div class="form-group">
                <label for="listado" class="control-label">Listado</label>
                <input type="text" name="listado" class="form-control">
            </div>
















            <div class="form-group">
                <label for="partida" class="control-label">Partida</label>
                <input type="text" name="partida" class="form-control">
            </div>
            
            <div class="form-group row">
                <label for="estado_proyecto" class="col-md-4 col-form-label text-md-right">{{ __('Solicitante') }}</label>
                <div class="col-md-6">
                    <select id="estado_proyecto" type="text" class="form-control{{ $errors->has('estado_proyecto') ? ' is-invalid' : '' }}" name="estado_proyecto" >
                        <?php
                        Session::put('rolActual', Auth::user()->rol );
                        
                        ?>
                        <option value=<?php Session::get('rolActual');?> >{{ Auth::user()->name }} {{ Auth::user()->apellido }}</option>
                    </select>
                    
                </div>
            </div>



            <div class="form-group">
                
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus"></i> Hacer Solicitud  
                </button>   

                <!-- 
                <div class = "modal" id="msgmodal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Solicitud Creada Correctamente</h4>
                                </div>
                            </div>
                        </div>
                </div>

                @if(Session::has('welcome_msg'))
                <script>
                $(function() {
                $('#msgmodal').modal('show');
                });
                </script>
                    <h7><B>{{Session::get('message')}}</B></h7>
                    
                @endif
                -->


            </div> 

            
        </form>   
        
    </div>
</div>








@endsection
