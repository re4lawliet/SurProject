@extends('layouts.app')

@section('content')

    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
            <h1>Modificar Proyecto</h1>
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

            <form action="{{ url('proyecto') }}/{{ $proyecto->id }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <label for="nombre_proyecto" class="control-label">Nombre del Proyecto</label>
                    <input type="text" name="nombre_proyecto" class="form-control" value="{{ $proyecto->nombre_proyecto }}">
                </div>  

                <div class="form-group">
                    <label for="zona_proyecto" class="control-label">Zona del Proyecto</label>
                    <input type="text" name="zona_proyecto" class="form-control" value="{{ $proyecto->zona_proyecto }}">
                </div>
                
                <div class="form-group">
                    <label for="logo_proyecto" class="control-label">Logo del Proyecto</label>
                    <input type="file" name="logo_proyecto" class="form-control">
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
                    <input type="text" name="factura_a" class="form-control" value="{{ $proyecto->factura_a }}">
                </div>

                 <div class="form-group">
                    <label for="factura_numero" class="control-label">Numero de Factura:</label>
                    <input type="text" name="factura_numero" class="form-control" value="{{ $proyecto->factura_numero }}">
                </div>


                <div class="form-group">
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Modificar Proyecto
                    </button>    
                    
                </div> 
            </form>   
            
        </div>
    </div>
    


@endsection