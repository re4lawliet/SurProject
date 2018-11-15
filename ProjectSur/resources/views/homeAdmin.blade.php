@extends('layouts.appAdmin')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Menu de Administrador</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3><center>Menu de Proyectos:</center></h3>

                    @if (count($proyectos) > 0)
            <div class="panel panel-default">
                
                <div class="panel-heading">
                        <h2>Proyectos Activos:</h2>
                </div>
                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                            <th>Nombre Proyecto</th>
                            <th>Estado Proyecto</th>
                            <th>Seleccionar</th>
                            
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($proyectos as $emps)
                                <tr>
                                    <td class="table-text"><div>{{ $emps->nombre_proyecto }}</div></td>
                                    <td class="table-text"><div>{{ $emps->estado_proyecto }}</div></td>
                                    
                                    

                                    <!-- Task Delete Button -->
                                    <td>
                                        <button type="submit" class="btn btn-primary" onclick="location.href='proyectos/{{ $emps->id }}'">
                                            <i class="fa fa-btn fa-pencil"></i>Seleccionar
                                        </button>
                                    </td>
                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $proyectos->render() }}
                </div>
            </div>
        </div>
    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection