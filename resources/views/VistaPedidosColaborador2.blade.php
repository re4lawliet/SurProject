<!-- ENCABEZADO -->
@extends(    
Auth::user()->rol == 'colaborador' ? 'layouts.appColaborador' :
    ( Auth::user()->rol == 'manager' ? 'layouts.appManager' : 
        (Auth::user()->rol == 'director' ? 'layouts.appDirector' : 
            (Auth::user()->rol == 'compras' ? 'layouts.appCompras' :
                (Auth::user()->rol == 'recepcion' ? 'layouts.appRecepcion' : 'layouts.appAdmin'))))
)
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
                        <td><div class="alert alert-warning">
                        <h7><B>Solicitud en Orden de Compra</B></h7>
                        </div></td>
                    </tr>
                    </table>
                </div>


        <!-- Tabla  -->
        <div class="col-md-12">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($querySolicitudes) > 0)
            <center>
                <div class="panel panel-default">
                    <h2>Listado De Solicitudes</h2>
                </div>
                </center>
                <div class="panel-body">
                    <table id="tabla_solicitudes" class="table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>Fecha</th>
                            <th>Titulo</th>
                            <th>No. Partida</th>
                            <th>Nombre Partida</th>
                            <th>Proyecto</th>
                            <th>Proveedor sugerido</th>
                            <th>Estado Transaccion</th>
                            <th>Dejar de Seguir</th>
                            <th>Modificar Cotizacion</th>
                            <th>Ver Solicitud</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($querySolicitudes as $solicitud)
                            @if($solicitud->respondido_manager == 0)
                                <!-- ni el manager la ha visto PENDIENTE-->
                                <tr class="alert alert-dark">
                                    <td class="table-text"><div>{{ $solicitud->fecha_solicitud }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                    <td class="table-text"><div>Falta Aprobacion Manager</div></td>
                                    <!-- Boton DEJAR -->
                                    <td>
                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                        </button>
                                    </td>
                                    <!-- Boton MODIFICAR -->
                                    <td>
                                        <button type="submit" class="btn btn-primary" onclick="location.href='ModificarSolicitud/{{ $solicitud->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Cambiar Cotizacion
                                        </button>
                                    </td>
                                    <!-- Boton Ver -->
                                    <td>
                                        <button type="submit" class="btn btn-primary" onclick="location.href='VerSolicitud/{{ $solicitud->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Ver Solicitud
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
                                            <td class="table-text"><div>{{ $solicitud->fecha_solicitud }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                            <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                            <td class="table-text"><div>Aceptada Por Manager, Falta Aprobacion Director</div></td>
                                            <!-- Boton DEJAR -->
                                            <td>
                                                <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                    <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                </button>
                                            </td>
                                            <!-- Boton MODIFICAR -->
                                            <td>
                                                <button type="submit" class="btn btn-danger" onclick="location.href=''">
                                                    <i class="fa fa-btn fa-pencil"></i>Cambiar Cotizacion
                                                </button>
                                            </td>
                                            <!-- Boton Ver -->
                                            <td>
                                                <button type="submit" class="btn btn-primary" onclick="location.href='VerSolicitud/{{ $solicitud->id }}'">
                                                    <i class="fa fa-btn fa-pencil"></i>Ver Solicitud
                                                </button>
                                            </td>
                                        </tr>
                                    @elseif($solicitud->respondido_director == 1)
                                        <!-- el director ya la vio -->
                                        @if($solicitud->aprobado_director == 1)
                                            <!-- el director ya la acepto-->
                                            <!-- si se creo la orden en 1 gris-->
                                            @if($solicitud->orden_creada == 1)
                                                <tr class="alert alert-warning">
                                                    <td class="table-text"><div>{{ $solicitud->fecha_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                    <td class="table-text"><div>Aceptada Por Manager, Aceptada Director, Orden Creada en Compras(Falta Envio De Director y Aprobacion de Contabilidad)</div></td>
                                                    <!-- Boton DEJAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                        </button>
                                                    </td>
                                                    <!-- Boton MODIFICAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-danger" onclick="location.href=''">
                                                            <i class="fa fa-btn fa-pencil"></i>Cambiar Cotizacion
                                                        </button>
                                                    </td>
                                                    <!-- Boton Ver -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='VerSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Ver Solicitud
                                                        </button>
                                                    </td>
                                                </tr>
                                            <!-- si se creo la orden en 0 gris-->
                                            @elseif($solicitud->orden_creada == 0)
                                                <tr class="alert alert-dark">
                                                    <td class="table-text"><div>{{ $solicitud->fecha_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                    <td class="table-text"><div>Aceptada Por Manager,Aceptada Director, Orden Enviada a Compras</div></td>
                                                    <!-- Boton DEJAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                        </button>
                                                    </td>
                                                    <!-- Boton MODIFICAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-danger" onclick="location.href=''">
                                                            <i class="fa fa-btn fa-pencil"></i>Cambiar Cotizacion
                                                        </button>
                                                    </td>
                                                    <!-- Boton Ver -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='VerSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Ver Solicitud
                                                        </button>
                                                    </td>
                                                </tr>
                                            <!-- si se creo la orden en 2 rechazada por conta-->
                                            @elseif($solicitud->orden_creada == 2)
                                                <tr class="alert alert-danger">
                                                    <td class="table-text"><div>{{ $solicitud->fecha_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                    <td class="table-text"><div>Aceptada Por Manager,Aceptada Director, Orden Creada en Compras, Rechazada por Conta</div></td>
                                                    <!-- Boton DEJAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                        </button>
                                                    </td>
                                                    <!-- Boton MODIFICAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-danger" onclick="location.href=''">
                                                            <i class="fa fa-btn fa-pencil"></i>Cambiar Cotizacion
                                                        </button>
                                                    </td>
                                                    <!-- Boton Ver -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='VerSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Ver Solicitud
                                                        </button>
                                                    </td>
                                                </tr>
                                            <!-- si se creo la orden en 3 aprobada enviada-->
                                            @elseif($solicitud->orden_creada == 3)
                                                <tr class="alert alert-success">
                                                    <td class="table-text"><div>{{ $solicitud->fecha_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                    <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                    <td class="table-text"><div>Aceptada Por Manager,Aceptada Director, Orden Creada en Compras, Aprobada y Enviada</div></td>
                                                    <!-- Boton DEJAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                        </button>
                                                    </td>
                                                    <!-- Boton MODIFICAR -->
                                                    <td>
                                                        <button type="submit" class="btn btn-danger" onclick="location.href=''">
                                                            <i class="fa fa-btn fa-pencil"></i>Cambiar Cotizacion
                                                        </button>
                                                    </td>
                                                    <!-- Boton Ver -->
                                                    <td>
                                                        <button type="submit" class="btn btn-primary" onclick="location.href='VerSolicitud/{{ $solicitud->id }}'">
                                                            <i class="fa fa-btn fa-pencil"></i>Ver Solicitud
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif

                                        @elseif($solicitud->aprobado_director == 0)
                                            <!-- el director ya la rechazo ROJO -->
                                            <tr class="alert alert-danger">
                                                <td class="table-text"><div>{{ $solicitud->fecha_solicitud }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                                <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                                <td class="table-text"><div>Aceptada Por Manager,Rechazada por Director o Compras</div></td>
                                                <!-- Boton DEJAR -->
                                                <td>
                                                    <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                        <i class="fa fa-btn fa-pencil"></i>Eliminar
                                                    </button>
                                                </td>
                                                <!-- Boton MODIFICAR -->
                                                <td>
                                                    <button type="submit" class="btn btn-danger" onclick="location.href=''">
                                                        <i class="fa fa-btn fa-pencil"></i>Cambiar Cotizacion
                                                    </button>
                                                </td>
                                                <!-- Boton Ver -->
                                                <td>
                                                    <button type="submit" class="btn btn-primary" onclick="location.href='VerSolicitud/{{ $solicitud->id }}'">
                                                        <i class="fa fa-btn fa-pencil"></i>Ver Solicitud
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @elseif($solicitud->aprobado_manager == 0)
                                    <!-- el manager la rechazo ROJO-->
                                    <tr class="alert alert-danger">
                                        <td class="table-text"><div>{{ $solicitud->fecha_solicitud }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->titulo_solicitud }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->id_partida }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->nombre }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->nombre_proyecto }}</div></td>
                                        <td class="table-text"><div>{{ $solicitud->proveedor }}</div></td>
                                        <td class="table-text"><div>Rechazada por Director</div></td>
                                        <!-- Boton DEJAR -->
                                        <td>
                                            <button type="submit" class="btn btn-primary" onclick="location.href='DejarSolicitud/{{ $solicitud->id }}'">
                                                <i class="fa fa-btn fa-pencil"></i>Eliminar
                                            </button>
                                        </td>
                                        <!-- Boton MODIFICAR -->
                                        <td>
                                            <button type="submit" class="btn btn-danger" onclick="location.href=''">
                                                <i class="fa fa-btn fa-pencil"></i>Cambiar Cotizacion
                                            </button>
                                        </td>
                                        <!-- Boton Ver -->
                                        <td>
                                            <button type="submit" class="btn btn-primary" onclick="location.href='VerSolicitud/{{ $solicitud->id }}'">
                                                <i class="fa fa-btn fa-pencil"></i>Ver Solicitud
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
            $('#tabla_solicitudes').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false
            });
        } );
    </script>

@endsection


