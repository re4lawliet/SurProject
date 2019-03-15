@extends('layouts.encabezado')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">PRODUCTO SELECCIONADO</div>

                <div class="card-body">
          

                    <h3><center>Detalles del producto:</center></h3>
                    <br>
                    <br>

            <div class="panel panel-default">
                @foreach($producto as $prod)
                    <div class="panel-heading">
                            <div class="title m-b-md">
                                <center><img src="{{ $prod->imagen }}" width="400" height="300"></center>  
                            </div>
                            <br>
                            <br>
                            <h2>Tipo: {{ $prod->nombre }}</h2>
                            <h4>Marca: {{ $prod->marca }}</h4>
                            <h4>Modelo: {{ $prod->modelo }}</h4>
                            <h4>Peso: {{ $prod->peso }}</h4>
                            <h4>Dimensiones: {{ $prod->dimensiones }}</h4>
                            <h4>Color: {{ $prod->color }}</h4>
                            <h4>Caracteristicas: {{ $prod->arquitectura }}</h4>
                            <h4>Precio: Q {{ $prod->precio }}</h4>
                    </div>
                @endforeach
                <br>
                    @if(Session::get('usuario')  == "noUser")
                        <button type="submit" class="btn btn-success" onclick="noAgregaraCarrito()">
                            <i class="fa fa-btn fa-pencil"></i>Agregar al Carrito
                        </button>
                    @else
                        <button type="submit" class="btn btn-success" onclick="agregaraCarrito()">
                            <i class="fa fa-btn fa-pencil"></i>Agregar al Carrito
                        </button>
                    @endif
                    
 
            </div>
        </div>

        


        

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    function agregaraCarrito(){
        alert('Agregado a Carrito');
    }

    function noAgregaraCarrito(){
        alert('No se puede agregar al carrito por que no ha logeado como un usuario');
    }
</script>