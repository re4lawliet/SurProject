@extends('layouts.appAdmin') <!--LLAMAR ENCABEZADO (pagina aparte) -->


@section('content')

    <!-- Inicio del Contenido de Pagina -->
    <center>
    <div class="panel-title">
        <h1><center>Administrador de Usuarios</center></h1>
    </div>

    <!-- Formulario de Registro de Proyecto -->    
  
    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
                <h3><center>Registrar Usuarioo:</center></h3>
        </div>
    <div class="panel-body">


        <!--route (Route::post('/proyecto', 'ControladorModuloProyectos@AgregarProyecto');) -->
        <form action="{{ url('registrousuario') }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="nombre_usuario" class="control-label">Nombre</label>
                <input type="text" name="nombre_usuario" class="form-control">
            </div>  

            <div class="form-group">
                <label for="apellido_usuario" class="control-label">Apellido Usuario</label>
                <input type="text" name="zona_proyecto" class="form-control">
            </div>

            <!-- ROLL -->

            <div class="form-group">
                <label for="email_usuario" class="control-label">E-Mail Address</label>
                <input type="text" name="email_usuario" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="contrasena_usuario" class="control-label">Contraseña</label>
                <input type="password" name="email_usuario" class="form-control">
            </div>

            <div class="form-group">
                <label for="confirmar_contrasena_usuario" class="control-label">Confirmar Contraseña</label>
                <input type="password" name="confiarmar_contrasena_usuario" class="form-control">
            </div>

            <div class="form-group row">
                <label for="estado_proyecto" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>

                <div class="col-md-6">
                    <select id="estado_proyecto" type="text" class="form-control{{ $errors->has('estado_proyecto') ? ' is-invalid' : '' }}" name="estado_proyecto" >
                        <option value="Manager" >Manager</option>
                        <option value="Colaborador" >Colaborador</option>
                        <option value="Director" >Director</option>
                        <option value="Admin" >admin</option>
                    </select>
                </div>
            </div>


            <div class="form-group">
                
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus"></i> Registrar Proyecto  
                </button>    
                
            </div> 

            
        </form>   
        
    </div>
</div>

<br><br><br> 

</center>

@endsection