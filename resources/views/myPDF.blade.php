
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Orden de Compra</title>
    <style>
        
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
  
        a {
            color: #5D6975;
            text-decoration: underline;
        }
  
        body {
            /*background: #ddd;*/
            position: relative;
            width: 15cm;  
            height: 29.7cm; 
            margin: 0 auto; 
            color: #001028;
            background: #FFFF;
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            font-family: Arial;
        }
  
        header {
            width: 100%;
            margin-bottom: 30px;
        }
  
        #logo {
            text-align: right;
            margin-bottom: 10px;
        }
  
        #logo img {
            width: 3cm;
        }
  
        h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }
  
        #project {
            width: 50%;
            float: left;
            text-align: left;
        }
  
        #project span {
            color: #5D6975;
            text-align: left;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }
  
        #company {
            width:50%;
            float: right;
            text-align: right;
        }
  
        #project div,
        #company div {
            white-space: nowrap;        
        }
  
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }
        
        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }
        
        table th,
        table td {
            text-align: center;
        }
        
        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;        
            font-weight: normal;
        }
        
        table .service,
        table .desc {
            text-align: left;
        }
        
        table td {
            padding: 20px;
            text-align: right;
        }
        
        table td.service,
        table td.desc {
            vertical-align: top;
        }
        
        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }
        
        table td.grand {
            border-top: 1px solid #5D6975;;
        }
        
        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }
        
        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }

        #wrapper {
            width: 15cm; 
            /*background: orange;*/
            clear:both;
        }


        #first {
            /*background-color:red;*/
            width: 5cm;
            float:left;
        }
        #first_cont{
            /*background-color:red;*/
            width: 4cm;
            float:left;
        }


        #second {
            /*background-color:blue;*/
            width: 5cm;
            float: left;
            text-align: center;
        }
        
        #third {
            /*background-color:#bada55;*/
            width: 5cm;
            float:left;
            text-align: right;
        }
        #third_cont{
            width: 2cm;
            float:left;
        }

    </style>
  </head>
  <body>
    <header class="clearfix">
      <br>
      <br>
      <br>
      <h1>Orden de compra</h1>
      <div id="company" class="clearfix">
        <div id="logo">
            <img src="{{ $proyecto->logo_proyecto }}">
        </div>
        <div>{{ $proyecto->nombre_proyecto }}</div>
        <div>{{ $proyecto->factura_a }}</div>
      </div>
      <div id="project"><!-- IZQUIERDO -->
        <div><span style="text-align: left;">DATOS DE FACTURACION</span> </div>
        <div><span style="text-align: left;">{{ $proyecto->factura_a }}</span> </div>
        <div><span style="text-align: left;">{{ $proyecto->factura_numero }}</span> </div>
        <div><span style="text-align: left;">Diagonal 6 19-30 Zona 10</span> </div>
      </div>
    </header>
    <br>
    <main>
    <div id="wrapper">
        <div id="first">
            <div><span style="font-weight:bold">PROVEEDOR</span><br>
                <div id="first_cont">{{ $proveedor->nombre_empresa }}</div>
            </div>
            
        </div>

        <div id="second">
            <div><span style="font-weight:bold">ENVIAR MATERIAL A:</span></div>
            <div id="second_cont">{{ $enviar_a }}</div>
        </div>

        <div id="third">
            <div><span style="font-weight:bold">OC No. </span>{{ $proyecto->correlativo }}</div>
            <div><span style="font-weight:bold">FECHA </span>{{ $fecha }}</div>
        </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <hr>
    <br>
    
    <div id="wrapper" >
        <div id="first">
            <div><span style="font-weight:bold">METODO DE PAGO:</span><br>
                <div id="first_cont">{{ $tipo_pago }}</div>
            </div>
            
        </div>

        <div id="second">
            <div><span style="font-weight:bold">No. CUENTA</span></div>
            <div id="second_cont">{{ $proveedor->no_cuenta }}</div>
        </div>

        <div id="third">
            
        </div>
    </div>       
    <br>
    <br>
    <br>
    <br>
    <br>
    <hr>
    <br>

        <table >
            <thead>
            <tr>
                <th class="service">UNIDAD</th>
                <th class="desc">DESCRIPCION</th>
                <th>PRECIO</th>
                <th>CANTIDAD</th>
                <th>SUBTOTAL</th>
            </tr>
            </thead>
            <tbody>
            
            @foreach($detalle as $prod)
                <tr>
                    <td class="service">{{ $prod->unidad }}</td>
                    <td class="desc">{{ $prod->descripcion }}</td>
                    @if($proveedor->divisa=='USD')
                        <td class="unit">$ {{ $prod->precio_unitario }}</td>
                    @else if($proveedor->divisa=='GTQ')
                        <td class="unit">Q {{ $prod->precio_unitario }}</td>
                    @endif
                    <td class="qty">{{ $prod->cantidad }}</td>
                    @if($proveedor->divisa=='USD')
                        <td class="total">$ {{ $prod->subtotal }}</td>
                    @else if($proveedor->divisa=='GTQ')
                        <td class="total">Q {{ $prod->subtotal }}</td>
                    @endif
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="total">Ajuste</td>
                @if($proveedor->divisa=='USD')
                    <td class="total">$ {{ $ajuste }}</td>
                @else if($proveedor->divisa=='GTQ')
                    <td class="total">Q {{ $ajuste }}</td>
                @endif
                
            </tr>
            <tr>
                <td colspan="4" class="grand total">TOTAL</td>
                @if($proveedor->divisa=='USD')
                    <td class="grand total">$ {{ $total }}</td>
                @else if($proveedor->divisa=='GTQ')
                    <td class="grand total">Q {{ $total }}</td>
                @endif
                
            </tr>
            </tbody>
        </table>
        <br>
        <br>
        <div id="wrapper" >
        <div id="first">
        </div>

        <div id="second">
            <div><span style="font-weight:bold">Detalle de Pagos</span></div>
        </div>

        <div id="third">
        </div>
    </div> 
    <br>
        <br>
        @if(count($orden_abierta)>0)
            <table>
                <thead>
                <tr>
                    <th>FECHA</th>
                    <th>DETALLE</th>
                    <th>DEBE</th>
                    <th>HABER</th>
                    <th>SALDO</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($orden_abierta as $orden)
                        <tr>
                            <td>{{ $orden->fecha }}</td>
                            <td>Abono No. {{ $orden->abono }}</td>
                            @if($proveedor->divisa=='USD')
                                @if($orden->debe=='-')
                                    <td></td>
                                @else
                                    <td>$ {{ $orden->debe }}</td>
                                @endif
                                @if($orden->haber=='-')
                                    <td></td>
                                @else
                                <td>$ {{ $orden->haber }}</td>
                                @endif
                                <td>$ {{ $orden->saldo }}</td>
                            @else if($proveedor->divisa=='GTQ')
                                @if($orden->debe=='-')
                                    <td></td>
                                @else
                                    <td>Q {{ $orden->debe }}</td>
                                @endif
                                @if($orden->haber=='-')
                                    <td></td>
                                @else
                                <td>Q {{ $orden->haber }}</td>
                                @endif
                                <td>Q {{ $orden->saldo }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
      <!--div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div-->
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>

