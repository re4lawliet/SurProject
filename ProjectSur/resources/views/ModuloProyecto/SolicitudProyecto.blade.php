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




<div class="row">
    <div class="col-sm-12">
    <h2>Lista de Productos</h2>
        <table class="table table-hover table-condensed table-bordered">
        <caption>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo">
                Agregar nuevo 
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </caption>
            <tr>
                <td>Descripcion</td>
                <td>Unidad</td>
                <td>Cantidad</td>
                <td>Editar</td>
                <td>Eliminar</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modalEdicion">
                        Editar
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger glyphicon glyphicon-remove">Eliminar</button>
                </td>
            </tr>
        </table>
    </div>
</div>


<!-- Modal para registros nuevos -->


<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title" id="myModalLabel">Agrega nuevo Producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
              <label>Descripcion</label>
              <input type="text" name="" id="nombre" class="form-control input-sm">
              <label>Unidad</label>
              <input type="text" name="" id="apellido" class="form-control input-sm">
              <label>Cantidad</label>
              <input type="text" name="" id="email" class="form-control input-sm">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
          Agregar
          </button>
         
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal para edicion de datos -->
  
  <div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
                <input type="text" hidden="" id="idpersona" name="">
              <label>Descripcion</label>
              <input type="text" name="" id="nombreu" class="form-control input-sm">
              <label>Unidad</label>
              <input type="text" name="" id="apellidou" class="form-control input-sm">
              <label>Cantidad</label>
              <input type="text" name="" id="emailu" class="form-control input-sm">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" id="actualizadatos" data-dismiss="modal">Actualizar</button>
          
        </div>
      </div>
    </div>
  </div>




@endsection
