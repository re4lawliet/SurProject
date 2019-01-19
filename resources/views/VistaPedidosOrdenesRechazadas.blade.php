<!-- ENCABEZADO -->
@extends('layouts.appCompras')


@section('content')
    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>VISTA DE ORDENES RECHAZADAS POR CONTABILIDAD</center></h1>
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

        <!-- Tabla  -->
        <div class="col-md-12">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($querySolicitudes) > 0)
                <div class="panel panel-default">
                    <h2>Listado De ORDENES Rechazadas por Contabilidad</h2>
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>Fecha de Creacion</th>
                            <th>Fecha de Rechazo</th>
                            
                            <th>Titulo Solicitud</th>
                            <th>Proveedor</th>
                            <th>Proyecto</th>
                            <th>Ver Solicitud</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($querySolicitudes as $solicitud)
                            <tr>
                                <td class="table-text"><div>{{ $solicitud->fecha_creacion }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->fecha_contador }}</div></td>
                                
                                <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->nombre_empresa }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                <!-- Boton VER -->
                                <td>
                                    <button type="submit" class="btn btn-primary" onclick="location.href='/SolicitudRechazada/{{$solicitud->id}}'">
                                        <i class="fa fa-btn fa-pencil"></i>Seleccionar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>


        



    </center>

@endsection