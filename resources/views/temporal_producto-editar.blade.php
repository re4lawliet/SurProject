@extends(
    Auth::user()->rol == 'colaborador' ? 'layouts.appColaborador' :
        ( Auth::user()->rol == 'manager' ? 'layouts.appManager' : 
            (Auth::user()->rol == 'director' ? 'layouts.appDirector' : 
                (Auth::user()->rol == 'compras' ? 'layouts.appCompras' : 'layouts.appAdmin')))
    )

@section('content')

    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
            <h1>Modificar Producto</h1>
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

            <form action="{{ url('temporal_producto') }}/{{ $temporal_producto->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripcion</label>
                    <input type="text" name="descripcion" class="form-control" value="{{ $temporal_producto->descripcion }}">
                </div>  

                <div class="form-group">
                    <label for="unidad" class="control-label">Unidad</label>
                    <input type="text" name="unidad" class="form-control" value="{{ $temporal_producto->unidad }}">
                </div>
                
                 <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="text" name="cantidad" class="form-control" value="{{ $temporal_producto->cantidad }}">
                </div>      


                <div class="form-group">
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Modificar Producto
                    </button>    
                    
                </div> 
            </form>   
            
        </div>
    </div>
    


@endsection