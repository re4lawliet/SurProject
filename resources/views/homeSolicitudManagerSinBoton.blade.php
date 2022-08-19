<!-- ENCABEZADO -->
@extends('layouts.appManager')

@section('content')

    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>
            <h5>No. Partida: "{{Session::get('s_id_partida', 'Seleccione Solicitud')}}"</h5>
            <h5>Nombre Partida: "{{Session::get('s_npartida', 'Seleccione Solicitud')}}"</h5>
            <h5>Solicitante: "{{Session::get('s_solicitante', 'Seleccione Solicitud')}}"</h5>
            <h5>Proyecto: "{{Session::get('s_nproyecto', 'Seleccione Solicitud')}}"</h5>
            <h5>Proveedor sugerido: "{{Session::get('s_proveedor', 'Seleccione Solicitud')}}"</h5>
        </div>
        <br><br>
        <form action="{{ url('/ResponderSolicitudManager') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div>
                <h4>Materiales Solicitados</h4>
                @if(count($queryListado)>0)
                    <div class="col-sm-7">
                        <table class="table table-striped task-table">
                            <!-- Encabezado de Tabla -->
                            <thead>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Descripcion</th>
                            </thead>
                            <!-- Cuerpo de Tabla -->
                            <tbody>
                                @foreach ($queryListado as $material)
                                    <tr>
                                        <td class="table-text"><div>{{ $material->cantidad }}</div></td>
                                        <td class="table-text"><div>{{ $material->unidad }}</div></td>
                                        <td class="table-text"><div>{{ $material->descripcion }}</div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <br><br>
        </form>
        
        
    </center>

@endsection