<!-- ENCABEZADO -->
@extends('layouts.appCompras')


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
                            <th>Crear Orden</th>
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
                                <!-- // <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_proveedor">Crear Orden</button> -->
                                <button type="submit" class="btn btn-primary" onclick="location.href='OrdenSolicitud/{{ $solicitud->id }}/{{ $solicitud->nombre }}/{{ $solicitud->nombre_proyecto }}'">
                                        <i class="fa fa-btn fa-pencil"></i>Crear Orden
                                    </button>
                                    
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>



    <!-- MODAL -->
    <div class="modal fade" id="modal_proveedor" role="dialog" >
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- Modal Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Escoger Proveedor</h4>
                </div>
                <!-- Modal Body-->
                <div class="modal-body">
                    <p>Some text in the modal proveedor</p>
                </div>
                <!-- Modal Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <input type="text" class="form-control" id="selected" list="browsers" name="browser">
    <datalist id="browsers">
        <option data-value="InternetExplorer" value="1"></option>
        <option data-value="Firefox" value="2"></option>
        <option data-value="Chrome" value="3"></option>
        <option data-value="Opera" value="4"></option>
        <option data-value="Safari" value="5"></option>
    </datalist>
    <input id="submit" type="submit">

    <script>
        $(document).ready(function() {

        var data = {}; 
        $("#browsers option").each(function(i,el) {  
        data[$(el).data("value")] = $(el).val();
        });
        // `data` : object of `data-value` : `value`
        console.log(data, $("#browsers option").val());


            $('#submit').click(function()
            {
                var value = $('#selected').val();
                alert($('#browsers [value="' + value + '"]').data('value'));
            });
        });
    </script>



    </center>

@endsection
