@extends('layouts.app')

@section('content')

    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
            <h1>Modificar Proveedor</h1>
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

            <form action="{{ url('proveedor') }}/{{ $proveedor->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <label for="nombre_proveedor" class="control-label">Nombre del Proveedor</label>
                    <input type="text" name="nombre_proveedor" class="form-control" value="{{ $proveedor->nombre_proveedor }}">
                </div>  

                <div class="form-group">
                    <label for="direccion_oficina" class="control-label">Direccion del Proveedor</label>
                    <input type="text" name="direccion_oficina" class="form-control" value="{{ $proveedor->direccion_oficina }}">
                </div>
                
                 <div class="form-group">
                    <label for="nit_proveedor" class="control-label">Nit del Proveedor</label>
                    <input type="text" name="nit_proveedor" class="form-control" value="{{ $proveedor->nit_proveedor }}">
                </div>

                 <div class="form-group">
                    <label for="telefono_proveedor" class="control-label">Telefono del Proveedor</label>
                    <input type="text" name="telefono_proveedor" class="form-control" value="{{ $proveedor->telefono_proveedor }}">
                </div>

                 <div class="form-group">
                    <label for="correo_proveedor" class="control-label">Correo del Proveedor</label>
                    <input type="text" name="correo_proveedor" class="form-control" value="{{ $proveedor->correo_proveedor }}">
                </div>

                <div class="form-group">
                    <label for="nombre_banco" class="control-label">Nombre del Banco</label>
                    <input type="text" name="nombre_banco" class="form-control" value="{{ $proveedor->nombre_banco }}">
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
                        <i class="fa fa-plus"></i> Modificar Proveedor
                    </button>    
                    
                </div> 
            </form>   
            
        </div>
    </div>
    


@endsection