@extends(
    Auth::user()->rol == 'colaborador' ? 'layouts.appColaborador' :
        ( Auth::user()->rol == 'manager' ? 'layouts.appManager' : 
            (Auth::user()->rol == 'director' ? 'layouts.appDirector' : 
                (Auth::user()->rol == 'compras' ? 'layouts.appCompras' : 'layouts.appAdmin')))
    )

@section('content')

    <!-- Inicio del Contenido de Pagina -->
    <center>
    <div class="panel-title">
        <h1><center>Administrador de Empresas</center></h1>
    </div>

    <!-- Formulario de Registro de Empresa -->    
  
    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
                <h3><center>Registrar Empresa:</center></h3>
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

        <form action="{{ url('empresa') }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="nombre_empresa" class="control-label">Nombre de la Empresa</label>
                <input type="text" name="nombre_empresa" class="form-control">
            </div>  

            <div class="form-group row">
                <label for="Partida" class="col-md-4 col-form-label text-md-right">{{ __('Divisa') }}</label>
                    <div class="col-md-6">
                        <select name="divisa_empresa" id="divisa_empresa"  class="form-control" >
                            <option value="GTQ" >Quetzales GTQ</option>
                            <option value="USD" >Dolares USD</option>
                        </select>
                    </div>
            </div>

            <div class="form-group">
                <label for="nit_empresa" class="control-label">NIT de la Empresa</label>
                <input type="text" name="nit_empresa" class="form-control">
            </div>
            
             <div class="form-group">
                <label for="direccion_empresa" class="control-label">Direccion de la Empresa</label>
                <input type="text" name="direccion_empresa" class="form-control">
            </div>

             <div class="form-group">
                <label for="telefono_oficina" class="control-label">Telefono de la Oficina</label>
                <input type="text" name="telefono_oficina" class="form-control">
            </div>

             <div class="form-group">
                <label for="telefono_empresa" class="control-label">Telefono de la Empresa</label>
                <input type="text" name="telefono_empresa" class="form-control">
            </div>

            <div class="form-group">
                <label for="correo_empresa" class="control-label">Correo de la Empresa</label>
                <input type="text" name="correo_empresa" class="form-control">
            </div>

            <div class="form-group">
                <label for="telefono_encargado" class="control-label">Telefono del Encargado</label>
                <input type="text" name="telefono_encargado" class="form-control">
            </div>

            <div class="form-group">
                <label for="correo_encargado" class="control-label">Correo del Encargado</label>
                <input type="text" name="correo_encargado" class="form-control">
            </div>

            <div class="form-group">
                <label for="nombre_encargado" class="control-label">Nombre del Encargado</label>
                <input type="text" name="nombre_encargado" class="form-control">
            </div>

            <div class="form-group">
                <label for="puesto_encargado" class="control-label">Puesto del Encargado</label>
                <input type="text" name="puesto_encargado" class="form-control">
            </div>

            <div class="form-group">
                <label for="nombre_banco" class="control-label">Nombre del Banco</label>
                <input type="text" name="nombre_banco" class="form-control">
            </div>

            <div class="form-group">
                <label for="no_cuenta" class="control-label">No. Cuenta</label>
                <input type="text" name="no_cuenta" class="form-control">
            </div>

            <div class="form-group">
                <label for="tipo_cuenta" class="control-label">Tipo de Cuenta</label>
                <input type="text" name="tipo_cuenta" class="form-control">
            </div>

            <div class="form-group">
                
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus"></i> Registrar Empresa  
                </button>    
                
            </div> 

            
        </form>   
        
    </div>
</div>

<br><br><br> 

<div class="container">

        <div class="col-12"><h2>Buscar Empresa
            
                {{ Form::open(['route' => 'empresas', 'method' => 'GET', 'class' => 'navbar-form navbar-left']) }}
                <div class="form-group">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de Empresa']) }}
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
            @if (count($empresas) > 0)
            <div class="panel panel-default">
                
                <div class="panel-heading">
                        <h2>Listado De Empresas</h2>
                </div>
                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                            <th>Nombre Empresa</th>
                            <th>Nit Empresa</th>
                            <th>Direccion Empresa</th>
                            <th>Telefono Oficina</th>
                            <th>Telefono Empresa</th>
                            <th>Correo Empresa</th>
                            <th>Telefono Encargado</th>
                            <th>Correo Encargado</th>
                            <th>Nombre Encargado</th>
                            <th>Puesto Encargado</th>
                            <th>Nombre Banco</th>
                            <th>No. Cuenta</th>
                            <th>Tipo de Cuetna</th>
                            <th>Modificar</th>
                            <th>Borrar</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($empresas as $emps)
                                <tr>
                                    <td class="table-text"><div>{{ $emps->nombre_empresa }}</div></td>
                                    <td class="table-text"><div>{{ $emps->nit_empresa }}</div></td>
                                    <td class="table-text"><div>{{ $emps->direccion_empresa }}</div></td>
                                    <td class="table-text"><div>{{ $emps->telefono_oficina }}</div></td>
                                    <td class="table-text"><div>{{ $emps->telefono_empresa }}</div></td>
                                    <td class="table-text"><div>{{ $emps->correo_empresa }}</div></td>
                                    <td class="table-text"><div>{{ $emps->telefono_encargado }}</div></td>
                                    <td class="table-text"><div>{{ $emps->correo_encargado }}</div></td>
                                    <td class="table-text"><div>{{ $emps->nombre_encargado }}</div></td>
                                    <td class="table-text"><div>{{ $emps->puesto_encargado }}</div></td>
                                    <td class="table-text"><div>{{ $emps->nombre_banco }}</div></td>
                                    <td class="table-text"><div>{{ $emps->no_cuenta }}</div></td>
                                    <td class="table-text"><div>{{ $emps->tipo_cuenta }}</div></td>
                                    <!-- Task Delete Button -->
                                    <td>
                                        <button type="submit" class="btn btn-success" onclick="location.href='empresas/{{ $emps->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Modificar
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ url('empresa') }}/{{ $emps->id }}" method="POST">
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
                    {{ $empresas->render() }}
                </div>
            </div>
        </div>
    @endif
    
    
</center>

@endsection