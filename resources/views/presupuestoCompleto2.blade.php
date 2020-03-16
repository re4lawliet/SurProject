<!-- ENCABEZADO -->
@extends('layouts.appCompras')
@section('content')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
        <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>{{Session::get('s_titulo')}}</center></h1>
        </div>

        <div>

            <h1>PRESUPUESTO</h1>
            
        </div>
        <div>
            @foreach($proyectos as $proyecto)
                <h4>{{ $proyecto->nombre_proyecto }}</h4>
            @endforeach
        </div>
        <br><br>
        Fecha Inicio: 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Fecha Final:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Dia:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Mes:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Año:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
        Dia:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Mes:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Año:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="col-md-6">
            <select id="fi1" type="text" class="" name="rol" >
                <option value="01" >1</option>
                <option value="02" >2</option>
                <option value="03" >3</option>
                <option value="04" >4</option>
                <option value="05" >5</option>
                <option value="06" >6</option>
                <option value="07" >7</option>
                <option value="08" >8</option>
                <option value="09" >9</option>
                <option value="10" >10</option>
                <option value="11" >11</option>
                <option value="12" >12</option>
                <option value="13" >13</option>
                <option value="14" >14</option>
                <option value="15" >15</option>
                <option value="16" >16</option>
                <option value="17" >17</option>
                <option value="18" >18</option>
                <option value="19" >19</option>
                <option value="20" >20</option>
                <option value="21" >21</option>
                <option value="22" >22</option>
                <option value="23" >23</option>
                <option value="24" >24</option>
                <option value="25" >25</option>
                <option value="26" >26</option>
                <option value="27" >27</option>
                <option value="28" >28</option>
                <option value="29" >29</option>
                <option value="30" >30</option>
                <option value="31" >31</option>

            </select>
            <select id="fi2" type="text" class="" name="rol" >
                <option value="01" >Enero</option>
                <option value="02" >Febrero</option>
                <option value="03" >Marzo</option>
                <option value="04" >Abril</option>
                <option value="05" >Mayo</option>
                <option value="06" >Junio</option>
                <option value="07" >Julio</option>
                <option value="08" >Agosto</option>
                <option value="09" >Septiembre</option>
                <option value="10" >Octubre</option>
                <option value="11" >Noviembre</option>
                <option value="12" >Diciembre</option>
            </select>
            <select id="fi3" type="text" class="" name="rol" >
                <option value="19" >2019</option>
                <option value="20" >2020</option>
                <option value="21" >2021</option>
                <option value="22" >2022</option>
                <option value="23" >2023</option>
                <option value="24" >2024</option>
                <option value="25" >2025</option>
                <option value="26" >2026</option>
                <option value="27" >2027</option>
                <option value="28" >2028</option>
                <option value="29" >2029</option>
                <option value="30" >2030</option>
            </select>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;

            <select id="ff1" type="text" class="" name="rol" >
                <option value="01" >1</option>
                <option value="02" >2</option>
                <option value="03" >3</option>
                <option value="04" >4</option>
                <option value="05" >5</option>
                <option value="06" >6</option>
                <option value="07" >7</option>
                <option value="08" >8</option>
                <option value="09" >9</option>
                <option value="10" >10</option>
                <option value="11" >11</option>
                <option value="12" >12</option>
                <option value="13" >13</option>
                <option value="14" >14</option>
                <option value="15" >15</option>
                <option value="16" >16</option>
                <option value="17" >17</option>
                <option value="18" >18</option>
                <option value="19" >19</option>
                <option value="20" >20</option>
                <option value="21" >21</option>
                <option value="22" >22</option>
                <option value="23" >23</option>
                <option value="24" >24</option>
                <option value="25" >25</option>
                <option value="26" >26</option>
                <option value="27" >27</option>
                <option value="28" >28</option>
                <option value="29" >29</option>
                <option value="30" >30</option>
                <option value="31" >31</option>

            </select>
            <select id="ff2" type="text" class="" name="rol" >
                <option value="01" >Enero</option>
                <option value="02" >Febrero</option>
                <option value="03" >Marzo</option>
                <option value="04" >Abril</option>
                <option value="05" >Mayo</option>
                <option value="06" >Junio</option>
                <option value="07" >Julio</option>
                <option value="08" >Agosto</option>
                <option value="09" >Septiembre</option>
                <option value="10" >Octubre</option>
                <option value="11" >Noviembre</option>
                <option value="12" >Diciembre</option>
            </select>
            <select id="ff3" type="text" class="" name="rol" >
                <option value="19" >2019</option>
                <option value="20" >2020</option>
                <option value="21" >2021</option>
                <option value="22" >2022</option>
                <option value="23" >2023</option>
                <option value="24" >2024</option>
                <option value="25" >2025</option>
                <option value="26" >2026</option>
                <option value="27" >2027</option>
                <option value="28" >2028</option>
                <option value="29" >2029</option>
                <option value="30" >2030</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" id="btn_Orden" onclick="validacion()">
            <i class="fa fa-btn fa-pencil"></i>Filtrar por fechas
        </button>
        <br><br>
        <!-- Tabla  -->
        <div class="col-md-12">
            <!-- si el resultado de la consulta es mayor a 0-->
            @if (count($matriz) > 0)
            <center>
                
                </center>
                <div class="panel-body">
                    <table id="tabla_de_detalle" name='tabla_de_detalle' class="table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th style='text-align:center'>Partida</td>
                            <th style='text-align:center'>Nombre Partida</th>
                            <th style='text-align:center'>Fecha</td>
                            <th style='text-align:center'>No. Orden</th>
                            <th style='text-align:center'>Proveedor</th>
                            <th style='text-align:center'>Titulo</th>
                            <th style='text-align:center'>Total</th>
                            <th style='text-align:center'>Pagado</th>
                            <th style='text-align:center'>Saldo</th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                            @foreach ($matriz as $row)
                                <tr>
                                    <td style='text-align:center;font-weight:bold;'>{{ $row[0] }}</td>
                                    <td style='text-align:center;font-weight:bold;'>{{ $row[1] }}</td>
                                    <td> {{ $row[2] }} </td>
                                    <td> {{ $row[3] }} </td>
                                    <td> {{ $row[4] }} </td>
                                    <td> {{ $row[5] }} </td>
                                    <td> {{ $row[6] }} </td>
                                    <td> {{ $row[7] }} </td>
                                    <td> {{ $row[8] }} </td>
                                </tr>
                            @endforeach

                            @foreach ($sumas as $row2)
                                <tr>
                                    <td style='text-align:center;font-weight:bold;'></td>
                                    <td style='text-align:center;font-weight:bold;'>TOTALES</td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> {{ $row2->Sp }} </td>
                                    <td> {{ $row2->So }} </td>
                                    <td> {{ $row2->Ss }} </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @endif
        </div>


        <br>

    </center>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

   

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
            $('#tabla_de_detalle').DataTable({
                "language": idioma_espanol,
                "paging": false,
                "info": false,
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5', 
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }
                ]
            });
        } );
    </script>

    <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>

    <script>
        function validacion(){
            var btnEnv=document.getElementById("btn_Orden");
            btnEnv.disabled=true;


            var fi1 = document.getElementById("fi1").value;
            var fi2 = document.getElementById("fi2").value;
            var fi3 = document.getElementById("fi3").value;

            var ff1 = document.getElementById("ff1").value;
            var ff2 = document.getElementById("ff2").value;
            var ff3 = document.getElementById("ff3").value;

            var finicial = fi1+"-"+fi2+"-"+fi3;
            var ffinal = ff1+"-"+ff2+"-"+ff3;
            
            
            location.href="/PrespuestoCompleto2/" + finicial + "/" + ffinal;

        }
    </script>
    
    
@endsection


