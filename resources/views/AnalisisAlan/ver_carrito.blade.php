<!-- ENCABEZADO -->
@extends('layouts.encabezado')
@section('content')
        <center>
        <!--TITULO -->
        <div>

            <h1>CARRITO DE COMPRAS</h1>
            
        </div>
        <br><br>
        <!-- enctype de este tipo para enviar datos del formulario que despues seran variables -->

            <!-- Detalle de Pedido -->
            <div class="container">
                <div class="card">
                    <div class="card-header"><!-- Encabezado -->
                            <h6>Carrito pendiente de Aprobar</h6>
                    </div>

                    <div class="card-body">
                        <!-- Inicio Contenido -->
                        <div class="col-sm-12">
                            <br>
                                <div class="panel-body">
                                    <table id="tabla_de_detalle" name="tabla_de_detalle" class="table table-striped task-table">
                                        <!-- Encabezado de Tabla -->
                                        <thead>
                                            <th style='text-align:center' width="10%">Producto</td>
                                            <th style='text-align:center' width="30%">Cantidad</th>
                                            <th style='text-align:center' width="18%">Precio Unitario</th>
                                            <th style='text-align:center' width="18%">Sub-Total</th>
                                        </thead>
                                        <!-- Cuerpo de Tabla -->
                                        <tbody>
                                            <tr>
                                                <td style='text-align:center' class="table-text">Computadora 1</td>
                                                <td style='text-align:center' class="table-text"><input type="number"></td>
                                                <td style='text-align:center' class="table-text">Q XXX.XX</td>                                                    
                                                <td style='text-align:center' class="table-text"  >Q XXX.XX</td>                                                                 
                                            </tr>
                                            <tr>
                                                <td style='text-align:center' class="table-text">Celular #2</td>
                                                <td style='text-align:center' class="table-text"><input type="number"></td>
                                                <td style='text-align:center' class="table-text">Q XXX.XX</td>                                                    
                                                <td style='text-align:center' class="table-text"  >Q XXX.XX</td>                                                                 
                                            </tr>
                                            <tr>
                                                <td style='text-align:center' class="table-text">Computadora 6</td>
                                                <td style='text-align:center' class="table-text"><input type="number"></td>
                                                <td style='text-align:center' class="table-text">Q XXX.XX</td>                                                    
                                                <td style='text-align:center' class="table-text"  >Q XXX.XX</td>                                                                 
                                            </tr>
                                            <tr>
                                                <td id="td_Totales" style='text-align:center' class="table-text"> TOTAL </td>
                                                <td id="td_Totales" style='text-align:center' class="table-text">  </td>
                                                <td id="td_Presupuesto" style='text-align:center' class="table-text">  </td>
                                                <td id="td_Ordenes" style='text-align:center' class="table-text"> 0 </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                           
                            <br>
                            <div class="form-group">
                                <button id="btn_subtotal" type="submit" form="No_Es_Parte_Del_Form" class="btn btn-success" onclick="validarCarrito()">Validar Carrito de Compra</button><br><br>
                                </div>
                            </div>
                            <!-- Fin del Contenido -->
                        </div> 
                    </div>
                </div>
                <br>
               
            </div>
            
        
        
        
    </center>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    function validarCarrito(){
        if(confirm('Esta seguro de validar el carrito de compra?')){
            location.href="{{url('informac_factura')}}";
            //document.forms["hacer_abono_frm"].submit();
        }
    }
</script>
