@extends('layouts.appColaborador')


@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Menu de Colaborador</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3><center>Menu de Proyectos:</center></h3>
                    <br>
                    <br>
                    <br><br><br> 

                    <div class="container">
                    
                            <div class="col-12"><h2>Buscar Proyecto
                                
                                    {{ Form::open(['route' => 'homeColaborador', 'method' => 'GET', 'class' => 'navbar-form navbar-left']) }}
                                    <div class="form-group">
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de Proyecto']) }}
                                    </div>
                                    <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Buscar</button>
                                    </div>
                                    {{ Form::close() }}
                            
                            
                            
                            </h2></div>
                    </div>
                    
                    <br>

                    @if (count($proyectos) > 0)
            <div class="panel panel-default">
                
                <div class="panel-heading">
                        <!--h2>Proyecto Seleccionado: "{{Session::get('proyectoGnombre', 'Seleccione Proyecto')}}"</h2-->
                </div>
                <div class="panel-body">
                    <table id="tabla_proyectos" name="tabla_proyectos" class="table table-striped task-table">
                        <thead>
                            <th>Nombre Proyecto</th>
                            <th>Estado Proyecto</th>
                            <th>Seleccionar</th>
                            
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($proyectos as $emps)
                                <tr>
                                    <td class="table-text"><div>{{ $emps->nombre_proyecto }}</div></td>
                                    <td class="table-text"><div>{{ $emps->estado_proyecto }}</div></td>
                                    
                                    

                                    <!-- Task Delete Button -->
                                    <td>
                                        <button type="submit" class="btn btn-primary" onclick="location.href='proyectoG/{{ $emps->id }}/{{ $emps->nombre_proyecto }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Seleccionar
                                        </button>

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
            </div>
        </div>
    </div>
</div>
@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script>
        var idioma_espanol = {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
        }
        
        $(document).ready( function () {
            $('#lllltabla_proyectos').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false
            });
        } );
    </script>