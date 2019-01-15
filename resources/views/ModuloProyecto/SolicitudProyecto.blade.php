@extends(
    Auth::user()->rol == 'colaborador' ? 'layouts.appColaborador' :
        ( Auth::user()->rol == 'manager' ? 'layouts.appManager' : 
            (Auth::user()->rol == 'director' ? 'layouts.appDirector' : 
                (Auth::user()->rol == 'compras' ? 'layout.appCompras' : 'layout.appAdmin')))
    )

@section('content')
<!-- Inicio del Contenido de Pagina -->
<center>
    <div class="panel-title">
        <h1><center>Solicitud de Proyecto</center></h1>
    </div>

<div class="col-sm-offset-3 col-sm-6">
    <div class="panel-title">
            <h3><center>Registrar Solicitud:</center></h3>
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
        
        <div class="card-body">
            @if(Session::has('message'))
                <div class="alert alert-success">
                <h7><B>{{Session::get('message')}}</B></h7>
                <br>
                <button type="submit" class="btn btn-success" onclick="location.href='homeProyecto'">
                    <i class="fa fa-btn fa-pencil"></i>OK
                </button>
                </div>
            @endif
        </div>

        <form action="{{ url('solicitudes') }}" method="POST">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="titulo_solicitud" class="control-label">Titulo de Solicitud</label>
                <input type="text" name="titulo_solicitud" class="form-control">
            </div>  

            <div class="form-group">
                <label for="proveedor" class="control-label">Proveedor (Sugerencia)</label>
                <input type="text" name="proveedor" class="form-control">
            </div>  
            


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
                                </thead>
                                <tbody>
                                    @foreach ($temporal_productos as $clis)
                                        <tr>
                                            <td class="table-text"><div>{{ $clis->descripcion }}</div></td>
                                            <td class="table-text"><div>{{ $clis->unidad }}</div></td>
                                            <td class="table-text"><div>{{ $clis->cantidad }}</div></td>
            
                                            <!-- Task Delete Button -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>


            <div class="form-group row">
                <label for="Partida" class="col-md-4 col-form-label text-md-right">{{ __('Partida') }}</label>
                    <div class="col-md-6">
                        <select name="id_partida" id="id_partida"  class="form-control" >
                            @foreach($partidas as $partida)
                            <option value="{{ $partida['id'] }}" >{{ $partida['id'] }} {{ $partida['nombre'] }} </option>
                            @endforeach
                        </select>
                    </div>
            </div>
            
            <div class="form-group row">
                <label for="estado_proyecto" class="col-md-4 col-form-label text-md-right">{{ __('Solicitante') }}</label>
                <div class="col-md-6">
                    <select id="estado_proyecto" type="text" class="form-control{{ $errors->has('estado_proyecto') ? ' is-invalid' : '' }}" name="estado_proyecto" >
                        <?php
                        Session::put('rolActual', Auth::user()->rol );
                        
                        ?>
                        <option value=<?php Session::get('rolActual');?> >{{ Auth::user()->name }} {{ Auth::user()->apellido }}</option>
                    </select>
                    
                </div>
            </div>



            <div class="form-group">
                
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus"></i> Hacer Solicitud  
                </button>   

                <!-- 
                <div class = "modal" id="msgmodal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Solicitud Creada Correctamente</h4>
                                </div>
                            </div>
                        </div>
                </div>

                @if(Session::has('welcome_msg'))
                <script>
                $(function() {
                $('#msgmodal').modal('show');
                });
                </script>
                    <h7><B>{{Session::get('message')}}</B></h7>
                    
                @endif
                -->


            </div> 

            
        </form>   
        
    </div>
</div>








@endsection
