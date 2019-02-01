<!-- ENCABEZADO -->
@extends('layouts.appDirector')


@section('content')
    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>VISTA DE ORDENES ABIERTAS POR ENVIAR</center></h1>
        </div>


        <!-- Tabla  -->
        <div class="col-md-11">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($ordenes) > 0)
                <div class="panel panel-default">
                    <h2>Listado De Ordenes Abiertas</h2>
                </div>
                <br>
                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>Fecha de Creacion Orden Abierta</th>
                            <th>Fecha de Creacion Abono</th>
                            <th>Monto A Abonar</th>
                            <th>Titulo de Solicitud</th>
                            <th>Proveedor</th>
                            <th>Proyecto</th>
                            <th>Ver Orden</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                        @foreach ($ordenes as $orden)
                            <tr>
                                <td class="table-text"><div>{{ $orden->fecha_creacion }}</div></td>
                                <td class="table-text"><div>{{ $orden->fecha}}</div></td>
                                <td class="table-text"><div>{{ $orden->haber}}</div></td>
                                <td class="table-text"><div>{{ $orden->titulo_solicitud }}</div></td>
                                <td class="table-text"><div>{{ $orden->nombre_empresa }}</div></td>
                                <td class="table-text"><div>{{ $orden->nombre_proyecto }}</div></td>
                                <!-- Boton VER -->
                                <td>
                                <!-- // <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_proveedor">Crear Orden</button> -->
                                <button type="submit" class="btn btn-primary" onclick="location.href='verOrdenAbiertaDirector/{{ $orden->id }}/{{ $orden->abono }}'">
                                        <i class="fa fa-btn fa-pencil"></i>Ver Orden
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
