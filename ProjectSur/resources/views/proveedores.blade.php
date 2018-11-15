@extends('layouts.app')


@section('content')

    <!-- Inicio del Contenido de Pagina -->
    <center>
    <div class="panel-title">
        <h1><center>Administrador de Proveedores</center></h1>
    </div>

    <!-- Tabla de Administrador -->

    <div class="col-md-12">
            @if (count($pro) > 0)
            <div class="panel panel-default">
                
                <div class="panel-heading">
                        Listado De Proveedores
                </div>
                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                            <th>Nombre Proovedor</th>
                            <th>Direccion Oficina</th>
                            <th>Nit Proveedor</th>
                            <th>Telefono Proveedor</th>
                            <th>Correo Proveedor</th>
                            <th>Nombre Banco</th>
                            <th>Forma Pago</th>
                            <th>Modificar</th>
                            <th>Borrar</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($pro as $pros)
                                <tr>
                                    <td class="table-text"><div>{{ $pros->nombre_proveedor }}</div></td>
                                    <td class="table-text"><div>{{ $pros->direccion_oficina }}</div></td>
                                    <td class="table-text"><div>{{ $pros->nit_proveedor }}</div></td>
                                    <td class="table-text"><div>{{ $pros->telefono_proveedor }}</div></td>
                                    <td class="table-text"><div>{{ $pros->correo_proveedor }}</div></td>
                                    <td class="table-text"><div>{{ $pros->nombre_banco }}</div></td>
                                    <td class="table-text"><div>{{ $pros->forma_pago }}</div></td>
    
                                    <!-- Task Delete Button -->
                                    <td>
                                        <button type="submit" class="btn btn-success" onclick="location.href='proveedores/{{ $pros->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Modificar
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ url('proveedor') }}/{{ $pros->id }}" method="POST">
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
                </div>
            </div>
        </div>
    @endif
    
    <!-- Formulario de Registro de Cliente -->    
  
    <div class="col-sm-offset-3 col-sm-6">
            <div class="panel-title">
                    <h3><center>Registrar Proveedor:</center></h3>
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

            <form action="{{ url('proveedor') }}" method="POST">

                {{ csrf_field() }}

                <div class="form-group">
                    <label for="nombre_proveedor" class="control-label">Nombre del Proveedor</label>
                    <input type="text" name="nombre_proveedor" class="form-control">
                </div>  

                <div class="form-group">
                    <label for="direccion_oficina" class="control-label">Direccion de la Oficina</label>
                    <input type="text" name="direccion_oficina" class="form-control">
                </div>
                
                 <div class="form-group">
                    <label for="nit_proveedor" class="control-label">Nit del Proveedor</label>
                    <input type="text" name="nit_proveedor" class="form-control">
                </div>

                 <div class="form-group">
                    <label for="telefono_proveedor" class="control-label">Telefono del Proveedor</label>
                    <input type="text" name="telefono_proveedor" class="form-control">
                </div>

                 <div class="form-group">
                    <label for="correo_proveedor" class="control-label">Correo del Proveedor</label>
                    <input type="text" name="correo_proveedor" class="form-control">
                </div>

                <div class="form-group">
                    <label for="nombre_banco" class="control-label">Nombre del Banco</label>
                    <input type="text" name="nombre_banco" class="form-control">
                </div>

                <div class="form-group row">
                    <label for="forma_pago" class="col-md-4 col-form-label text-md-right">{{ __('Forma de Pago') }}</label>

                    <div class="col-md-6">
                        <select id="forma_pago" type="text" class="form-control{{ $errors->has('forma_pago') ? ' is-invalid' : '' }}" name="forma_pago" >
                            <option value="cheque" >Cheque</option>
                            <option value="deposito" >Deposito</option>
                            <option value="transferencia" >Transferencia</option>
                            <option value="otra" >Otra</option>
                        </select>
                        @if ($errors->has('forma_pago'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('forma_pago') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Registrar Proveedor 
                    </button>    
                    
                </div> 
            </form>   
            
        </div>
    </div>
</center>

@endsection