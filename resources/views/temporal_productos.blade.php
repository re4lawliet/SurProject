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
        <h1><center>Solicitud de Materiales</center></h1>
    </div>
    
    <!-- Formulario de Registro de Materiales -->    
  
    <div class="col-sm-offset-3 col-sm-6">
            <div class="panel-title">
                    <h3><center>Agregue Los Materiales al Carrito:</center></h3>
            </div>
        <br><br>
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
                @if(Session::has('message2'))
                    <div class="alert alert-success">
                    <h7><B>{{Session::get('message2')}}</B></h7>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-danger" onclick="location.href='limpiar_temporal'">
                <i class="fa fa-btn fa-pencil"></i>Limpiar Productos
            </button>
            <br><br>
            <form action="{{ url('temporal_producto') }}" method="POST">

                {{ csrf_field() }}

                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                            <th>  
                                <div class="form-group">
                                <label for="descripcion" class="control-label">Descripcion</label>
                                <input type="text" name="descripcion" class="form-control">
                                </div> 
                            </th>
                            <th>   
                                <div class="form-group">
                                <label for="unidad" class="control-label">Unidad</label>
                                <input type="text" name="unidad" class="form-control">
                                </div>
                            </th>
                            <th>   
                                <div class="form-group">
                                <label for="cantidad" class="control-label">Cantidad</label>
                                <input type="text" name="cantidad" class="form-control">
                                </div>
                            </th>
                            <th> 
                                <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Agregar Producto  
                                </button>  
                                </div> 
                            </th>
                            <th>&nbsp;</th>
                        </thead>
                    </table>
                </div>

            </form>   
            
        </div>

    <br><br>
    
    <!-- Tabla de Administrador -->

    <div class="col-md-12">
        @if (count($temporal_productos) > 0)
        <div class="panel panel-default">
            
            <div class="panel-heading">
                    Listado De Materiales Agregados
            </div>
            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                        <th>Descripcion</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Modificar</th>
                        <th>Borrar</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($temporal_productos as $clis)
                            <tr>
                                <td class="table-text"><div>{{ $clis->descripcion }}</div></td>
                                <td class="table-text"><div>{{ $clis->unidad }}</div></td>
                                <td class="table-text"><div>{{ $clis->cantidad }}</div></td>

                                <!-- Task Delete Button -->
                                <td>
                                    <button type="submit" class="btn btn-success" onclick="location.href='temporal_productos/{{ $clis->id }}'">
                                        <i class="fa fa-btn fa-pencil"></i>Modificar
                                    </button>
                                </td>
                                <td>
                                    <form action="{{ url('temporal_producto') }}/{{ $clis->id }}" method="POST">
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
    </div>

    <br><br>

    <button type="submit" class="btn btn btn-info" onclick="location.href='solicitud'">
        <i class="fa fa-btn fa-pencil"></i>VALIDAR PEDIDO DE MATERIALES
    </button>

  

</center>

@endsection