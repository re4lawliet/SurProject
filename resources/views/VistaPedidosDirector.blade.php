<!-- ENCABEZADO -->
@extends('layouts.appDirector')


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
                            <th>Titulo</th>
                            <th>No. Partida</th>
                            <th>Nombre Partida</th>
                            <th>Solicitante</th>
                            <th>Proyecto</th>
                            <th>Proveedor sugerido</th>
                            <th>Ver Solicitud</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($querySolicitudes as $solicitud)
                            <tr>
                                <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->rol }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                <!-- Boton VER -->
                                <td>
                                    <button type="submit" class="btn btn-primary" onclick="location.href='SolicitudDirector/{{ $solicitud->id }}/{{ $solicitud->nombre }}/{{ $solicitud->nombre_proyecto }}'">
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