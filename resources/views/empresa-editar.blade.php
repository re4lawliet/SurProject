@extends('layouts.app')

@section('content')

    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
            <h1>Modificar Empresa</h1>
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

            <form action="{{ url('empresa') }}/{{ $empresa->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <label for="nombre_empresa" class="control-label">Nombre de la Empresa</label>
                    <input type="text" name="nombre_empresa" class="form-control" value="{{ $empresa->nombre_empresa }}">
                </div>  

                <div class="form-group">
                    <label for="nit_empresa" class="control-label">Nit de la Empresa</label>
                    <input type="text" name="nit_empresa" class="form-control" value="{{ $empresa->nit_empresa }}">
                </div>
                
                 <div class="form-group">
                    <label for="direccion_empresa" class="control-label">Direccion de la Empresa</label>
                    <input type="text" name="direccion_empresa" class="form-control" value="{{ $empresa->direccion_empresa }}">
                </div>

                 <div class="form-group">
                    <label for="telefono_oficina" class="control-label">Telefono de la Oficina</label>
                    <input type="text" name="telefono_oficina" class="form-control" value="{{ $empresa->telefono_oficina }}">
                </div>

                 <div class="form-group">
                    <label for="telefono_empresa" class="control-label">Telefono de la Empresa</label>
                    <input type="text" name="telefono_empresa" class="form-control" value="{{ $empresa->telefono_empresa }}">
                </div>

                <div class="form-group">
                    <label for="correo_empresa" class="control-label">Correo de la Empresa</label>
                    <input type="text" name="correo_empresa" class="form-control" value="{{ $empresa->correo_empresa }}">
                </div>

                <div class="form-group">
                    <label for="telefono_encargado" class="control-label">Telefono del Encargado</label>
                    <input type="text" name="telefono_encargado" class="form-control" value="{{ $empresa->telefono_encargado }}">
                </div>

                <div class="form-group">
                    <label for="correo_encargado" class="control-label">Correo del Encargado</label>
                    <input type="text" name="correo_encargado" class="form-control" value="{{ $empresa->correo_encargado }}">
                </div>

                <div class="form-group">
                    <label for="nombre_encargado" class="control-label">Nombre del Encargado</label>
                    <input type="text" name="nombre_encargado" class="form-control" value="{{ $empresa->nombre_encargado }}">
                </div>

                <div class="form-group">
                    <label for="puesto_encargado" class="control-label">Puesto del Encargado</label>
                    <input type="text" name="puesto_encargado" class="form-control" value="{{ $empresa->puesto_encargado }}">
                </div>

                <div class="form-group">
                    <label for="nombre_banco" class="control-label">Nombre del Banco</label>
                    <input type="text" name="nombre_banco" class="form-control" value="{{ $empresa->nombre_banco }}">
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
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Modificar Empresa
                    </button>    
                    
                </div> 
            </form>   
            
        </div>
    </div>
    


@endsection