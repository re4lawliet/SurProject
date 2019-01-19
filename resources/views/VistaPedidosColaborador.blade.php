<!-- ENCABEZADO -->
@extends('layouts.appColaborador')


@section('content')
    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>VISTA DE SOLICITUDES</center></h1>
        </div>
        <br><br>
        <div class="panel-title">
            <h4><center>Metricas</center></h4>
        </div>

                <table>
                    <tr>
                        <td><div class="alert alert-dark">
                <h7><B>Solicitud en Proceso</B></h7>
                </div></td>
                        <td><div class="alert alert-success">
                <h7><B>Solicitud Aceptada</B></h7>
                </div></td>
                        <td><div class="alert alert-danger">
                <h7><B>Solicitud Rechazada</B></h7>
                </div></td>
                        <td><div class="alert alert-primary">
                        <h7><B>Solicitud en Orden de Compra</B></h7>
                        </div></td>
                    </tr>
                    </table>
                </div>


        <!-- Tabla  -->
        <div class="col-md-12">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($querySolicitudes) > 0)
                <div class="panel panel-default">
                    <h2>Listado De Solicitudes</h2>
                </div>

                <div class="panel-body">
                    <table class="table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>Titulo</th>
                            <th>No. Partida</th>
                            <th>Nombre Partida</th>
                            <th>Proyecto</th>
                            <th>Proveedor sugerido</th>
                            <th>Dejar de Seguir</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($querySolicitudes as $solicitud)
                            @if($solicitud->respondido_manager == 0)
                                <!-- ni el manager la ha visto PENDIENTE-->
                                <tr class="alert alert-dark">
                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                    <!-- Boton DEJAR -->
                                    <td>
                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @elseif($solicitud->respondido_manager == 1)
                                <!-- el manager ya la vio -->
                                @if($solicitud->aprobado_manager == 1)
                                    <!-- el manager la acepto -->
                                    @if($solicitud->respondido_director == 0)
                                        <!-- pero el director no la ha visto AZUL-->
                                        <tr class="alert alert-dark">
                                            <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                            <!-- Boton DEJAR -->
                                            <td>
                                                <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                    <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    @elseif($solicitud->respondido_director == 1)
                                        <!-- el director ya la vio -->
                                        @if($solicitud->aprobado_director == 1)
                                            <!-- el director ya la acepto-->
                                            <!-- si se creo la orden en 1 gris-->
                                            @if($solicitud->orden_creada == 1)
                                                <tr class="alert alert-primary">
                                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                    <!-- Boton DEJAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                        </button>
                                                    </td>
                                                </tr>
                                            <!-- si se creo la orden en 0 gris-->
                                            @elseif($solicitud->orden_creada == 0)
                                                <tr class="alert alert-dark">
                                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                    <!-- Boton DEJAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                        </button>
                                                    </td>
                                                </tr>
                                            <!-- si se creo la orden en 2 rechazada por conta-->
                                            @elseif($solicitud->orden_creada == 2)
                                                <tr class="alert alert-danger">
                                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                    <!-- Boton DEJAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                        </button>
                                                    </td>
                                                </tr>
                                            <!-- si se creo la orden en 3 aprobada enviada-->
                                            @elseif($solicitud->orden_creada == 3)
                                                <tr class="alert alert-success">
                                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                    <!-- Boton DEJAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif

                                        @elseif($solicitud->aprobado_director == 0)
                                            <!-- el director ya la rechazo ROJO -->
                                            <tr class="alert alert-danger">
                                                <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                <!-- Boton DEJAR -->
                                                <td>
                                                    <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                        <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @elseif($solicitud->aprobado_manager == 0)
                                    <!-- el manager la rechazo ROJO-->
                                    <tr class="alert alert-danger">
                                        <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                        <!-- Boton DEJAR -->
                                        <td>
                                            <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                <i class="fa fa-btn fa-pencil"></i>Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>






    </center>

@endsection