@extends(
    Auth::user()->rol == 'colaborador' ? 'layouts.appColaborador' :
        ( Auth::user()->rol == 'manager' ? 'layouts.appManager' : 
            (Auth::user()->rol == 'director' ? 'layouts.appDirector' : 
                (Auth::user()->rol == 'compras' ? 'layouts.appCompras' :
                    (Auth::user()->rol == 'recepcion' ? 'layouts.appRecepcion' : 
                        (Auth::user()->rol == 'contabilidad' ? 'layouts.appContabilidad' : 'layouts.appAdmin')))))
    )

@section('content')

    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel-title">
            <h1>Modificar MI USUARIO</h1>
        </div>
    
        <div class="panel-body">

                <div class="card-body">
                        @if (session('message2'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message2') }}
                            </div>
                        @endif
                        @if (session('message3'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('message3') }}
                            </div>
                        @endif
                </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('user') }}/{{ Auth::user()->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <label for="nombre_nombre" class="control-label">Nombre:</label>
                    <input type="text" name="nombre_nombre" class="form-control" value="{{ Auth::user()->name }}">
                </div>  

                <div class="form-group">
                    <label for="nombre_apellido" class="control-label">Apellido:</label>
                    <input type="text" name="nombre_apellido" class="form-control" value="{{ Auth::user()->apellido }}">
                </div>  

                <div class="form-group">
                    <label for="contra_antigua" class="control-label">Contraseña Antigua:</label>
                    <input type="password" name="contra_antigua" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="contra_nueva" class="control-label">Contraseña Nueva:</label>
                    <input type="password" name="contra_nueva" class="form-control" value="">
                </div>

                <div class="form-group">
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Modificar Usuario
                    </button>     
                </div> 
            </form>   
            
        </div>
    </div>
    


@endsection