@extends('layouts.app')

@section('content')

    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
            <h1>Modificar Cliente</h1>
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

            <form action="{{ url('cliente') }}/{{ $cliente->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <label for="nombre" class="control-label">Nombres</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $cliente->nombre }}">
                </div>  

                <div class="form-group">
                    <label for="apellido" class="control-label">Apellidos</label>
                    <input type="text" name="apellido" class="form-control" value="{{ $cliente->apellido }}">
                </div>
                
                 <div class="form-group">
                    <label for="direccion" class="control-label">Direccion</label>
                    <input type="text" name="direccion" class="form-control" value="{{ $cliente->direccion }}">
                </div>

                 <div class="form-group">
                    <label for="nit" class="control-label">NIT</label>
                    <input type="text" name="nit" class="form-control" value="{{ $cliente->nit }}">
                </div>

                 <div class="form-group">
                    <label for="telefono" class="control-label">Telefono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ $cliente->telefono }}">
                </div>


                <div class="form-group">
                    
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Modificar Cliente  
                    </button>    
                    
                </div> 
            </form>   
            
        </div>
    </div>
    


@endsection