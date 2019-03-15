<!-- ENCABEZADO -->
@extends('layouts.encabezado')
@section('content')

    <center>
        <!--TITULO -->
        <div class="panel-title">
            <h1><center>ADMINISTRADOR</center></h1>
        </div>
        <br><br>
        


        <!-- Tabla  -->
        <div class="col-md-12">
            <!-- si el resultado de la consulta es mayor a 0-->
            <center>
                <div class="panel panel-default">
                    <h2>Listado De Productos</h2>
                </div>
                </center>
                <div class="panel-body">
                    <table id="tabla_solicitudes" class="table">
                        <!-- Encabezado de Tabla -->
                        <thead>
                            <th>ID</th>
                            <th>PRODUCTO</th>
                            <th>VENDIDOS</th>
                            <th>STOCK</th>
                            <th> </th>
                        </thead>
                        <!-- Cuerpo de Tabla -->
                        <tbody>
                            <tr class="alert alert-danger">
                                <td class="table-text"><div>11235</div></td>
                                <td class="table-text"><div>Computadora 1</div></td>
                                <td class="table-text"><div>22</div></td>
                                <td class="table-text"><div>3</div></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-pencil"></i>IGNORAR
                                    </button>
                                </td>
                            </tr>
                            <tr class="alert alert-danger">
                                <td class="table-text"><div>13548</div></td>
                                <td class="table-text"><div>Celular 2</div></td>
                                <td class="table-text"><div>10</div></td>
                                <td class="table-text"><div>1</div></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-pencil"></i>IGNORAR
                                    </button>
                                </td>
                            </tr>
                            <tr class="alert alert-success">
                                <td class="table-text"><div>11598</div></td>
                                <td class="table-text"><div>Celular 1</div></td>
                                <td class="table-text"><div>31</div></td>
                                <td class="table-text"><div>15</div></td>
                                <td class="table-text"><div></div></td>
                            </tr>
                            <tr class="alert alert-success">
                                <td class="table-text"><div>19875</div></td>
                                <td class="table-text"><div>Celular 3</div></td>
                                <td class="table-text"><div>4</div></td>
                                <td class="table-text"><div>20</div></td>
                                <td class="table-text"><div></div></td>
                            </tr>
                            <tr class="alert alert-success">
                                <td class="table-text"><div>26589</div></td>
                                <td class="table-text"><div>Computadora 2</div></td>
                                <td class="table-text"><div>0</div></td>
                                <td class="table-text"><div>20</div></td>
                                <td class="table-text"><div></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>






    </center>


@endsection

