@extends('layouts.encabezado')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">PRODUCTOS</div>

               

<br>
                   
            <div class="panel panel-default">
               
               <?php
                    $contador = 0;
                ?>
                <div class="panel-body">
                    <table class="table table-striped task-table" cellspacing="10">
                        <tr>
                        @foreach($productos as $producto)
                            <?php
                                if($contador<3){
                            ?>
                                    <td class="table-text">
                                        <a href='/producto/{{$producto->id}}'>
                                            <img src="{{ $producto->imagen }}" width="200" height="200">
                                            <div>
                                                Tipo: {{ $producto->nombre }}
                                                <br>
                                                Marca: {{ $producto->marca }}
                                                <br>
                                                Modelo: {{ $producto->modelo }}
                                                <br>
                                                Precio: {{ $producto->precio }}
                                            </div>
                                            </a>
                                    </td>
                            <?php
                                    $contador = $contador + 1;
                                }else{  
                            ?>
                                    </tr>
                                    <tr>
                                    <td class="table-text">
                                        <a href='/producto/{{$producto->id}}'>
                                            <img src="{{ $producto->imagen }}" width="200" height="200">
                                            <div>
                                                Tipo: {{ $producto->nombre }}
                                                <br>
                                                Marca: {{ $producto->marca }}
                                                <br>
                                                Modelo: {{ $producto->modelo }}
                                                <br>
                                                Precio: {{ $producto->precio }}
                                            </div>
                                        </a>
                                    </td> 
                            <?php
                                    $contador = 1;
                                }
                            ?>
                        @endforeach
                        </tr>
                    </table>
        
                </div>
            </div>
        </div>



        

                </div>
            </div>
        </div>
    </div>
</div>
@endsection