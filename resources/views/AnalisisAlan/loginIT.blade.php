@extends('layouts.encabezado')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Inicio de Sesion') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('productos') }}">
                        @csrf
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span id="span_PrimerPago" class="input-group-text">Correo</span>
                            </div>
                            <input name="correo" type="text" class="form-control" value="">
                        </div>
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span id="span_PrimerPago" class="input-group-text">Contrasena</span>
                            </div>
                            <input name="contrasena" type="password" class="form-control" value="">
                        </div>
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Iniciar Sesion') }}
                                </button>

                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


                    