@extends('layouts.app')


@section('content')

    <!-- Inicio del Contenido de Pagina -->
    <center>
    <div class="panel-title">
        <h1><center>Administrador de Proyectos</center></h1>
    </div>

    <!-- Formulario de Registro de Proyecto -->    
  
    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
                <h3><center>Registrar Proyecto:</center></h3>
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

        <form action="{{ url('proyecto') }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="nombre_proyecto" class="control-label">Nombre de la Proyecto</label>
                <input type="text" name="nombre_proyecto" class="form-control">
            </div>  

            <div class="form-group">
                <label for="zona_proyecto" class="control-label">Zona del Proyecto (numero)</label>
                <input type="text" name="zona_proyecto" class="form-control">
            </div>
            
            <div class="form-group row">
                <label for="estado_proyecto" class="col-md-4 col-form-label text-md-right">{{ __('Estado del Proyecto') }}</label>

                <div class="col-md-6">
                    <select id="estado_proyecto" type="text" class="form-control{{ $errors->has('estado_proyecto') ? ' is-invalid' : '' }}" name="estado_proyecto" >
                        <option value="Proyecto Terminado" >Proyecto Terminado</option>
                        <option value="Proyecto en Construccion" >Proyecto en Construccion</option>
                        <option value="Proyecto en Planificacion" >Proyecto en Planificacion</option>
                        <option value="Oficina" >Oficina</option>
                    </select>
                    @if ($errors->has('estado_proyecto'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('estado_proyecto') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

             <div class="form-group">
                <label for="factura_a" class="control-label">Factura a:</label>
                <input type="text" name="factura_a" class="form-control">
            </div>

             <div class="form-group">
                <label for="factura_numero" class="control-label">Numero de Factura:</label>
                <input type="text" name="factura_numero" class="form-control">
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

<div class="container">

        <div class="col-12"><h2>Buscar Proyecto
            
                {{ Form::open(['route' => 'proyectos', 'method' => 'GET', 'class' => 'navbar-form navbar-left']) }}
                <div class="form-group">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de Proyecto']) }}
                </div>
                <div class="form-group">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                {{ Form::close() }}
        
        
        
        </h2></div>
</div>

<br>

    <!-- Tabla de Administrador -->


    <div class="col-md-12">
            @if (count($proyectos) > 0)
            <div class="panel panel-default">
                
                <div class="panel-heading">
                        <h2>Listado De Proyectos</h2>
                </div>
                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                            <th>Nombre Proyecto</th>
                            <th>Zona Proyecto</th>
                            <th>Estado Proyecto</th>
                            <th>Factura a</th>
                            <th>Numero de Factura</th>
                            <th>Modificar</th>
                            <th>Borrar</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($proyectos as $emps)
                                <tr>
                                    <td class="table-text"><div>{{ $emps->nombre_proyecto }}</div></td>
                                    <td class="table-text"><div>{{ $emps->zona_proyecto }}</div></td>
                                    <td class="table-text"><div>{{ $emps->estado_proyecto }}</div></td>
                                    <td class="table-text"><div>{{ $emps->factura_a }}</div></td>
                                    <td class="table-text"><div>{{ $emps->factura_numero }}</div></td>
                                    

                                    <!-- Task Delete Button -->
                                    <td>
                                        <button type="submit" class="btn btn-success" onclick="location.href='proyectos/{{ $emps->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Modificar
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ url('proyecto') }}/{{ $emps->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
    
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Borrar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $proyectos->render() }}
                </div>
            </div>
        </div>
    @endif
    
    
</center>

@endsection