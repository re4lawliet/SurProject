@extends('layouts.encabezado')


@section('content')

    <!-- Inicio del Contenido de Pagina -->
    <center>
    <div class="panel-title">
        <h1><center>Datos de Facturacion</center></h1>
    </div>


            <div class="col-md-7">
                <label for="nombre_proyecto" class="control-label">Nombre</label>
                <input type="text" name="nombre_proyecto" class="form-control">
            </div>  

            <div class="col-md-7">
                <label for="zona_proyecto" class="control-label">Apellidos</label>
                <input type="text" name="zona_proyecto" class="form-control">
            </div>

            <div class="col-md-7">
                <label for="logo_proyecto" class="control-label">Direccion</label>
                <input type="text" name="zona_proyecto" class="form-control">
                <!--input type="file" name="logo_proyecto" class="form-control"-->
            </div>
            
            

             <div class="col-md-7">
                <label for="factura_a" class="control-label">NIT</label>
                <input type="text" name="factura_a" class="form-control">
            </div>

             <div class="col-md-7">
                <label for="factura_numero" class="control-label">Numero de Tarjeta</label>
                <input type="text" name="factura_numero" class="form-control">
            </div>
            <div class="col-md-7">
                <label for="factura_numero" class="control-label">FORMA DE PAGO:</label>
                <select class="form-control" name="" id="">
                    <option value="0">Tarjeta de Credito VISA</option>
                    <option value="1">Tarjeta de Credito MASTER CARD</option>
                    <option value="2">Deposito</option>
                </select>
            </div>
            <br>

            <div class="col-md-7">
                <label for="factura_numero" class="control-label">TOTAL: Q XXX.XX</label>
            </div>

            <div class="col-md-7">
                
                <button type="submit" class="btn btn-primary btn-lg" onclick="confirmarCompra();">Confirmar Compra</button>    
                
            </div> 

            

        
    </div>
</div>

<br><br><br> 


<br>

    
    
    
</center>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    function confirmarCompra(){
        alert('Compra realizada exitosamente');
        location.href="{{url('productoss')}}";
    }
</script>