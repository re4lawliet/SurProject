<!-- ENCABEZADO -->
@extends('layouts.appCompras')

@section('content')

    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>
            <h6>No. Partida: "{{Session::get('s_id_partida', 'Seleccione Solicitud')}}"</h6>
            <h6>Nombre Partida: "{{Session::get('s_npartida', 'Seleccione Solicitud')}}"</h6>
            <h6>Solicitante: "{{Session::get('s_solicitante', 'Seleccione Solicitud')}}"</h6>
            <h6>Proyecto: "{{Session::get('s_nproyecto', 'Seleccione Solicitud')}}"</h6>
            <h6>Proveedor sugerido: "{{Session::get('s_proveedor', 'Seleccione Solicitud')}}"</h6>
        </div>
        <br><br>
        <div>
            <h4>Materiales Solicitados</h4>
            @if(count($queryListado)>0)
                <div class="panel-body">
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
        <table class="table table-striped task-table">
            <thead>
                <th>&nbsp;</th>
                <th>  
                    <div class="form-group">
                      <label for="Proveedor" class="control-label">Proveedor</label>
                      <input type="text" class="form-control" id="selected" list="browsers" name="browser" >
                      <datalist id="browsers">
                        @foreach($queryEmpresas as $empresa)
                          <option data-value="{{ $empresa->id }}" value="{{ $empresa->nombre_empresa }}"></option>
                        @endforeach
                      </datalist>
                    </div> 
                </th>
                <th>   

                    <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>
                    @if(count($queryProveedores)>0)
                      @foreach($queryProveedores as $prov)
                        <input type="text" name="nombre" class="form-control" placeholder="{{ $prov->nombre_empresa }}">
                      @endforeach
                    @endif
                    </div>
                </th>
                <th>   
                    <div class="form-group">
                    <label for="cantidad" class="control-label">Cantidad</label>
                    <input type="text" name="cantidad" class="form-control">
                    </div>
                </th>
                <th> 
                    <div class="form-group">
                    <button id="botoncito" type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Agregar Producto  
                    </button>  
                    </div> 
                </th>
                <th>&nbsp;</th>
            </thead>
        </table>


       
        
       
          


        <div>
            <button type="submit" class="btn btn-success" onclick="location.href='/AceptarSolicitudDirector/{{Session::get('s_id')}}'">
                <i class="fa fa-btn fa-pencil"></i>Aceptar Solicitud
            </button>
            <!-- Boton Rechazar -->
            <button type="submit" class="btn btn-danger" onclick="location.href='/RechazarSolicitudDirector/{{Session::get('s_id')}}'">
                <i class="fa fa-btn fa-pencil"></i>Rechazar Solicitud
            </button>
        </div>
        
    </center>

 

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
  $(document).ready(function() {
    var data = {}; 
    $("#browsers option").each(function(i,el) {  
      data[$(el).data("value")] = $(el).val();
    });

    // `data` : object of `data-value` : `value`
    console.log(data, $("#browsers option").val());

    $('#botoncito').click(function(){
      var value = $('#selected').val();
      var iden = $('#browsers [value="' + value + '"]').data('value');
      alert(iden);
      location.href='/OrdenSolicitud/{{Session::get('s_id')}}/{{Session::get('s_npartida')}}/{{Session::get('s_nproyecto')}}/'+iden;
    });
  });
</script>