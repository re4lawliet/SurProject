<!-- ENCABEZADO -->
@extends('layouts.appDirector')

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

        @foreach ($querySolicitud as $sol)
            @if($sol->presupuesto!=NULL)
                <div  class="col-sm-7">
                    <button id="btn_pr" type="submit" class="btn btn-info" onclick="myFunction()">
                    Ver Propuesta de Presupuesto</button>
                </div>
                <br>
                <div class="col-sm-7" id="myDIV" style="display:none">
                    <div class="container">
                        
                            <embed src="/{{ $sol->presupuesto }}" type="application/pdf" width="100%" height="600px">
                        
                    </div>
                </div>
            @else
               <label style="background: #ddd;"> No hay Propuesta de Presupuesto</label>
            @endif
        @endforeach
        <br>
        <br>
        <div>
           
        </div>
        
    </center>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function myFunction() {
    var y = document.getElementById("btn_pr");
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
        y.className = "btn btn-danger";
        y.innerHTML = "Esconder Propuesta de Presupuesto";
        x.style.display = "block";
    } else {
        x.style.display = "none";
        y.className = "btn btn-info"
        y.innerHTML = "Ver Propuesta de Presupuesto";
    }
}
</script>