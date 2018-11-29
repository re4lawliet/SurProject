<!-- ENCABEZADO -->
@extends('layouts.appAdmin')


@section('content')
    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>VISTA DE SOLICITUDES</center></h1>
        </div>


        <!-- Tabla  -->
        <div class="col-md-12">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($querySolicitudes) > 0)
                <div class="panel panel-default">
                    <h2>Listado De Solicitudes</h2>
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>Proveedor</th>
                            <th>Listado</th>
                            <th>Partida</th>
                            <th>Rol</th>
                            <th>Proyecto</th>
                            <th>Aceptar</th>
                            <th>Rechazar</th>
                            <th>&nbsp;</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($querySolicitudes as $solicitud)
                            <tr>
                                <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->listado }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->partida }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->rol }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                <!-- Boton Aceptar -->
                                <td>
                                    <button type="submit" class="btn btn-success" onclick="location.href='AceptarSolicitud/{{ $solicitud->id }}'">
                                        <i class="fa fa-btn fa-pencil"></i>Aceptar Solicitud
                                    </button>
                                </td>
                                <!-- Boton Rechazar -->
                                <td>
                                    <button type="submit" class="btn btn-danger" onclick="location.href='RechazarSolicitud/{{ $solicitud->id }}'">
                                        <i class="fa fa-btn fa-pencil"></i>Rechazar Solicitud
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