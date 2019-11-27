<!-- ENCABEZADO -->
@extends('layouts.appColaborador')

@section('content')

    <center>
        <!--TITULO -->
        @foreach($querySolicitud as $sol)
            <div class="panel-title">
                <h1><center>{{ $sol->titulo_solicitud }}</center></h1>
            </div>

            <div>
                
                <h5>No. Partida: "{{ $sol->id_partida }}"</h5>
                <h5>Nombre Partida: "{{ $sol->nombre }}"</h5>
                <h5>Proyecto: "{{ $sol->nombre_proyecto }}"</h5>
                <h5>Proveedor sugerido: "{{ $sol->proveedor }}"</h5>
            </div>
        @endforeach
        
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
                    <button id="btn_pr" type="submit" form="no-form" class="btn btn-info" onclick="myFunction()">
                    Ver Cotizacion</button>
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
        <br><br>
        @if(count($queryOrden)>0)
            @foreach ($queryOrden as $ord)
                @if($ord->pdf!=NULL)
                    <div  class="col-sm-7">
                        <button id="btn_ord" type="submit" form="no-form" class="btn btn-info" onclick="myFunction2()">
                        Ver Orden</button>
                    </div>
                    <br>
                    <div class="col-sm-7" id="myDIV2" style="display:none">
                        <div class="container">
                            
                                <embed src="/{{ $ord->pdf }}" type="application/pdf" width="100%" height="600px">
                            
                        </div>
                    </div>
                @else
                <label style="background: #ddd;"> No hay PDF de la orden </label>
                @endif
            @endforeach
        @else
            <label style="background: #ddd;"> No se ha creado una Orden </label>
        @endif
        
        
        
        
    </center>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
function myFunction() {
    var y = document.getElementById("btn_pr");
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
        y.className = "btn btn-danger";
        y.innerHTML = "Esconder Cotizacion";
        x.style.display = "block";
    } else {
        x.style.display = "none";
        y.className = "btn btn-info"
        y.innerHTML = "Ver Cotizacion";
    }
}
function myFunction2() {
    var y = document.getElementById("btn_ord");
    var x = document.getElementById("myDIV2");
    if (x.style.display === "none") {
        y.className = "btn btn-danger";
        y.innerHTML = "Esconder Orden";
        x.style.display = "block";
    } else {
        x.style.display = "none";
        y.className = "btn btn-info"
        y.innerHTML = "Ver Orden";
    }
}
</script>
@endsection