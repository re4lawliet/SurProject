<?php
/*****************************************************************************************************/

//Route::get('/', function () {
  //  return view('welcome');
//});

/*********************************/
/*    Forma Sin Controladores    */
/*********************************/

/***************************************************/ 
/********        Mostrar Clientes     *************/ 
/***************************************************/ 

/*
Route::get('/clientes', function () {
    $clientes = cliente::all();
    return view('clientes', [ 'cli' => $clientes ]);
});
*/



/***************************************************/ 
/********        Mostrar Edicion Clientes      *****/ 
/***************************************************/ 

/*
Route::get('/clientes/{id}', function ($id) {
    $cliente = cliente::findOrFail($id);
    return view('cliente-editar', [ 'cliente' => $cliente ]);
});
*/



/***************************************************/ 
/********        Agregar Cliente       *************/ 
/***************************************************/ 

/*
Route::post('/cliente', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'nombre' => 'required|max:255',
        'apellido' => 'required|max:255',
        'nit' => 'max:255',
        'telefono' => 'min:8|max:8'

    ]);

    if ($validator->fails()) {
        return redirect('/clientes')
            ->withInput()
            ->withErrors($validator);
    }

    $client= new cliente;
    $client->nombre = $request->nombre;
    $client->apellido = $request->apellido;
    $client->direccion = $request->direccion;
    $client->nit = $request->nit;
    $client->telefono = $request->telefono;
    $client->save();

    return redirect('/clientes');
});
*/



/***************************************************/ 
/********        Eliminar Cliente       ************/ 
/***************************************************/ 

/*
Route::delete('/cliente/{id}', function ($id) {
    cliente::findOrFail($id)->delete();

    return redirect('/clientes');
});
*/


/***************************************************/ 
/********        Modificar Cliente      ************/ 
/***************************************************/ 

/*
Route::put('/cliente/{id}', function (Request $request, $id) {

    $validator = Validator::make($request->all(), [
        'nombre' => 'required|max:255',
        'apellido' => 'required|max:255',
        'nit' => 'max:255',
        'telefono' => 'min:8|max:8'

    ]);

    if ($validator->fails()) {
        return redirect('/clientes')
            ->withInput()
            ->withErrors($validator);
    }

    $client = cliente::findOrFail($id);
    $client->nombre = $request->nombre;
    $client->apellido = $request->apellido;
    $client->direccion = $request->direccion;
    $client->nit = $request->nit;
    $client->telefono = $request->telefono;
    $client->save();
    return redirect('/clientes');
});
*/


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*****************************************************************************************************/

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\cliente;
use App\Client;

/*********************************/
/*    RAIZ                       */
/*********************************/

Route::get('/', function () {
    if( Auth::user() ){//se valida si esta logueado
        if( Auth::user()->rol =='admin' ){//se valida el tipo de usuario
            return view('welcomeAdmin');
        }elseif (Auth::user()->rol =='colaborador'){
            return view('welcomeColaborador');
        }elseif (Auth::user()->rol =='manager'){
            return view('welcomeManager');
        }elseif (Auth::user()->rol =='director'){
            return view('welcomeDirector');
        }elseif (Auth::user()->rol =='compras'){
            return view('welcomeCompras');
        }elseif (Auth::user()->rol =='contabilidad'){
            return view('welcomeContabilidad');
        }elseif (Auth::user()->rol =='recepcion'){
            return view('welcomeRecepcion');
        }

    }else{
        return view('welcome');
    }
        
        
});

Route::get('/homes', function () {
    if( Auth::user() ){//se valida si esta logueado
        if( Auth::user()->rol =='admin' ){//se valida el tipo de usuario
            return redirect('/homeAdmin');
        }elseif (Auth::user()->rol =='colaborador'){
            return redirect('/homeColabrador');
        }elseif (Auth::user()->rol =='manager'){
            return redirect('/homeManager');
        }elseif (Auth::user()->rol =='director'){
            return redirect('/homeDirector');
        }elseif (Auth::user()->rol =='compras'){
            return redirect('/homeCompras');
        }elseif (Auth::user()->rol =='contabilidad'){
            return redirect('/homeContabilidad');
        }elseif (Auth::user()->rol =='recepcion'){
            return redirect('/homeRecepcion');
        }

    }else{
        return view('welcome');
    }
        
        
});



/*********************************/
/*    Forma de Controladores     */
/*********************************/

//------------------ Mostrar Clientes
Route::get('/clientes', 'ControladorModuloClientes@mostrarClientes');

//------------------ Mostrar Edicion Clientes
Route::get('/clientes/{id}', 'ControladorModuloClientes@mostrarClientesEditar');

//------------------ Agregar Clientes
Route::post('/cliente', 'ControladorModuloClientes@AgregarCliente');

//------------------ Eliminar Clientes
Route::delete('/cliente/{id}', 'ControladorModuloClientes@EliminarCliente');

//------------------ Modificar Clientes
Route::put('/cliente/{id}', 'ControladorModuloClientes@ModificarCliente');


/************************************************************************************************* */

//------------------ Mostrar Empresas
Route::get('/empresas', 'ControladorModuloEmpresas@mostrarEmpresas')->name('empresas');

//------------------ Mostrar Edicion Empresas
Route::get('/empresas/{id}', 'ControladorModuloEmpresas@mostrarEmpresasEditar');

//------------------ Agregar Empresas
Route::post('/empresa', 'ControladorModuloEmpresas@AgregarEmpresa');

//------------------ Eliminar Empresas
Route::delete('/empresa/{id}', 'ControladorModuloEmpresas@EliminarEmpresa');

//------------------ Modificar Empresas
Route::put('/empresa/{id}', 'ControladorModuloEmpresas@ModificarEmpresa');



/************************************************************************************************* */

//------------------ Mostrar Proyectos
Route::get('/proyectos', 'ControladorModuloProyectos@mostrarProyectos')->name('proyectos');

//------------------ Mostrar Edicion Proyectos
Route::get('/proyectos/{id}', 'ControladorModuloProyectos@mostrarProyectosEditar');

//------------------ Agregar Proyectos
Route::post('/proyecto', 'ControladorModuloProyectos@AgregarProyecto');

//------------------ Eliminar Proyectos
Route::delete('/proyecto/{id}', 'ControladorModuloProyectos@EliminarProyecto');

//------------------ Modificar Proyectos
Route::put('/proyecto/{id}', 'ControladorModuloProyectos@ModificarProyecto');


//------------------ Guardar Proyecto en Variable de Session
Route::get('/proyectoG/{id}/{nombre_proyecto}', 'ControladorModuloProyectos@GuardarProyecto');

//------------------ Home del Proyecto
Route::get('/homeProyecto', 'ControladorModuloProyectos@HomeProyecto')->name('homeProyecto');


/*******************************************SOLICITUDES********************************************* */
//------------------ Pedido del Proyecto
Route::post('/solicitudes', 'ControladorPedidoProyecto@AgregarPedido');
//------------------ redireccion LINK
Route::get('/solicitud', 'ControladorPedidoProyecto@solicitud')->name('solicitud');

//------------------redireccion LINK vista pedidos
Route::get('/dirVistaPedidos', 'ControladorVistaPedidos@Vista')->name('dirVistaPedidos');



//------------------Mostrar solicitudes a Manager
Route::get('/MostrarSolicitudesManager','ControladorVistaPedidos@mostrarSolicitudesManager')->name('MostrarSolicitudesManager');
//------------------Mostrar solicitudes a Manager Aprobadas
Route::get('/MostrarSolicitudesManagerAprobadas','ControladorVistaPedidos@mostrarSolicitudesManagerAprobadas')->name('MostrarSolicitudesManagerAprobadas');
//------------------Mostrar solicitudes a Manager Aprobadas
Route::get('/MostrarSolicitudesManagerRechazadas','ControladorVistaPedidos@mostrarSolicitudesManagerRechazadas')->name('MostrarSolicitudesManagerRechazadas');
//------------------Mostrar solicitud especifica sin Aprobar o Rechazar
Route::get('/SolicitudSinBoton/{id}/{npa}/{npr}', 'ControladorModuloSolicitudes@verSolicitudSinBoton');


//------------------Mostrar solicitud especifica a Manager
Route::get('/Solicitud/{id}/{npa}/{npr}', 'ControladorModuloSolicitudes@verSolicitud');
//------------------Responder solicitud por Manager
Route::post('/ResponderSolicitudManager', 'ControladorVistaPedidos@responderSolicitudManager');


//------------------Mostrar solicitudes a Director
Route::get('/MostrarSolicitudesDirector','ControladorVistaPedidos@mostrarSolicitudesDirector')->name('MostrarSolicitudesDirector');
//------------------Mostrar solicitudes APROBADAS a Director
Route::get('/MostrarSolicitudesAprobadasDirector','ControladorVistaPedidos@mostrarSolicitudesAprobadasDirector');
//------------------Mostrar solicitudes RECHAZADAS a Director
Route::get('/MostrarSolicitudesRechazadasDirector','ControladorVistaPedidos@mostrarSolicitudesRechazadasDirector');
//------------------Mostrar solicitud especifica a Director
Route::get('/SolicitudDirector/{id}/{npa}/{npr}', 'ControladorModuloSolicitudes@verSolicitudDirector');
//------------------Mostrar solicitud especifica a Director
Route::get('/RespuestaSolicitudDirector/{id}/{npa}/{npr}', 'ControladorModuloSolicitudes@verSolicitudDirectorSB');

Route::post('/presFile', 'ControladorModuloSolicitudes@verPresupuesto');
//------------------Aceptar solicitud por Director
Route::get('/AceptarSolicitudDirector/{id}', 'ControladorVistaPedidos@aceptarSolicitudDirector');
//------------------Rechazar solicitud por Director
Route::get('/RechazarSolicitudDirector/{id}', 'ControladorVistaPedidos@rechazarSolicitudDirector');


//------------------Ver detalle de solicitud por colaborador
Route::get('/VerSolicitud/{id}', 'ControladorVistaPedidos@verSolicitud');
//------------------Mostrar solicitudes a Colaborador
Route::get('/MostrarSolicitudesColaborador','ControladorVistaPedidos@mostrarSolicitudesColaborador')->name('MostrarSolicitudesColaborador');
Route::get('/MostrarSolicitudesColaborador2','ControladorVistaPedidos@mostrarSolicitudesColaborador2')->name('MostrarSolicitudesColaborador2');
//------------------Eliminar solicitud por Colaborador
Route::get('/DejarSolicitud/{id}', 'ControladorVistaPedidos@dejarSolicitud');
//------------------Modificar solicitud por Colaborador
Route::get('/ModificarSolicitud/{id}', 'ControladorVistaPedidos@modificarSolicitud');
Route::post('/ModificarCotizacion', 'ControladorVistaPedidos@modificarCotizacion');



//------------------Mostrar solicitudes a Compras
Route::get('/MostrarSolicitudesCompras','ControladorVistaPedidos@mostrarSolicitudesCompras')->name('MostrarSolicitudesCompras');
//------------------Mostrar solicitud especifica a Director
Route::get('/OrdenSolicitud/{id_solicitud}/{id_partida}/{id_proyecto}', 'ControladorModuloSolicitudes@verSolicitudCompras');

Route::get('/OrdenSolicitud/{id_solicitud}/{id_partida}/{id_proyecto}/{id_proveedor}', 'ControladorModuloSolicitudes@verSolicitudComprasProv');

Route::post('/OrdenCreada', 'ControladorModuloSolicitudes@crearOrden');

Route::get('/MostrarOrdenesAbiertas','ControladorVistaPedidos@mostrarOrdenesAbiertas');
Route::get('/OrdeneAbierta/{id_Orden}','ControladorVistaPedidos@mostrarOrdenAbierta');
Route::get('/OrdeneAbiertaRehacer/{id_Orden}','ControladorVistaPedidos@mostrarOrdenAbiertaRehacer');
Route::post('/CrearAbono','ControladorVistaPedidos@hacerAbono');

Route::get('/OrdenSolicitudRechazada/{id_solicitud}/{id_partida}/{id_proyecto}', 'ControladorModuloSolicitudes@verSolicitudComprasRechazada');

Route::get('/OrdenSolicitudRechazada/{id_solicitud}/{id_partida}/{id_proyecto}/{id_proveedor}', 'ControladorModuloSolicitudes@verSolicitudComprasProvRechazada');

Route::post('/OrdenCreadaRechazada', 'ControladorModuloSolicitudes@crearOrdenRechazada');

Route::get('/RechazarSolicitudCompras/{id}', 'ControladorVistaPedidos@rechazarSolicitudCompras');






//------------------Mostrar solicitudes a Contador
Route::get('/MostrarSolicitudesContador','ControladorVistaPedidos@mostrarSolicitudesContador')->name('MostrarSolicitudesContador');
//------------------Mostrar solicitud especifica a Contador
Route::get('/SolicitudContador/{id}', 'ControladorModuloSolicitudes@verSolicitudContador');
//------------------Aceptar solicitud por Contador
Route::put('/AceptarSolicitudContador/{id}', 'ControladorVistaPedidos@aceptarSolicitudContador');
//------------------Rechazar solicitud por Contador
Route::put('/RechazarSolicitudContador/{id}', 'ControladorVistaPedidos@rechazarSolicitudContador');
//------------------Mostrar solicitudes a Contador
Route::get('/MostrarSolicitudesContadorFinalizadas','ControladorVistaPedidos@mostrarSolicitudesContadorFinalizadas')->name('MostrarSolicitudesContadorFinalizadas');
//------------------Mostrar solicitud especifica a Contador Finalizada
Route::get('/SolicitudContadorFinalizada/{id}', 'ControladorModuloSolicitudes@verSolicitudContadorFinalizada');




//------------------Mostrar solicitudes a Compras Rechazadas
Route::get('/MostrarSolicitudesRechazadas','ControladorVistaPedidos@mostrarSolicitudesRechazadas')->name('MostrarSolicitudesRechazadas');
//------------------Mostrar solicitud especifica a REchazada
Route::get('/SolicitudRechazada/{id}', 'ControladorModuloSolicitudes@verSolicitudRechazada');
//------------------Aceptar solicitud por Rechazada
Route::get('/AceptarSolicitudRechazada/{id}', 'ControladorVistaPedidos@aceptarSolicitudRechazada');
//------------------Reenviar solicitud por Rechazada
Route::get('/ReenviarSolicitudRechazada/{id}', 'ControladorVistaPedidos@reenviarSolicitudRechazada');


/*************************************************************************************************/


//------------------ Mostrar Temporal_Productos
Route::get('/temporal_productos', 'ControladorModuloProductos_Temporal@mostrarTemporal_Productos');

//------------------ Mostrar Edicion Temporal_Productos
Route::get('/temporal_productos/{id}', 'ControladorModuloProductos_Temporal@mostrarTemporal_ProductosEditar');

//------------------ Agregar Temporal_Productos
Route::post('/temporal_producto', 'ControladorModuloProductos_Temporal@AgregarTemporal_Producto');

//------------------ Eliminar Temporal_Productos
Route::delete('/temporal_producto/{id}', 'ControladorModuloProductos_Temporal@EliminarTemporal_Producto');

//------------------ Modificar Temporal_Productos
Route::put('/temporal_producto/{id}', 'ControladorModuloProductos_Temporal@ModificarTemporal_Producto');

Route::get('/limpiar_temporal', 'ControladorModuloProductos_Temporal@LimpiarTemporal_Producto');

/*************************************************************************************************/





//------------------Mostrar Ordenes a Director
Route::get('/MostrarOrdenesDirector','ControladorVistaPedidos@mostrarOrdenesDirector');
//------------------Mostrar Ordenes Abiertas a Director
Route::get('/MostrarOrdenesAbiertasDirector','ControladorVistaPedidos@mostrarOrdenesAbiertasDirector');
//------------------Mostrar PDF a Director
Route::get('/verOrdenDirector/{idOrden}','ControladorVistaPedidos@mostrarPDFDirector');

//------------------Mostrar PDF a Director
Route::get('/verOrdenAbiertaDirector/{idOrden}/{abono}','ControladorVistaPedidos@mostrarPDFAbiertaDirector');
Route::put('/RechazarOrdenDirector/{id}', 'ControladorVistaPedidos@rechazarOrdenDirector');


//------------------PRESUPUESTO
Route::get('/crearPresupuesto/{idProyecto}','ControladorPresupuesto@mostrarPresupuesto');
Route::post('/Presupuesto','ControladorPresupuesto@guardarPresupuesto');
Route::get('/vistaPresupuesto/{idProyecto}','ControladorPresupuesto@consultaPresupuesto');
Route::get('/desglose/{idProyecto}/{idPartida}','ControladorPresupuesto@desglose');
Route::get('/PrespuestoCompleto/{idProyecto}','ControladorPresupuesto@PresupuestoCompleto');
Route::get('/PrespuestoCompleto2/{fi}/{ff}','ControladorPresupuesto@PresupuestoCompleto2');



//------------------ Loguin
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/homeAdmin', 'ControladorAdmin@indexAdmin')->name('homeAdmin');
Route::get('/homeManager', 'ControladorManager@indexManager')->name('homeManager');
Route::get('/homeDirector', 'ControladorDirector@indexDirector')->name('homeDirector');
Route::get('/homeColaborador', 'ControladorColaborador@indexColaborador')->name('homeColaborador');
Route::get('/homeCompras', 'ControladorCompras@indexCompras')->name('homeCompras');
Route::get('/homeContabilidad', 'ControladorContabilidad@indexContabilidad')->name('homeContabilidad');
Route::get('/homeRecepcion', 'ControladorRecepcion@indexRecepcion')->name('homeRecepcion');

//----------------- Registro Administrador
Route::get('/register2', 'ControladorAdmin@register2')->name('register2');
//VISTA DE USUARIO-PROYECTO
Route::get('/asignacion', 'ControladorAdmin@asignacion');
//HACER ASIGNACION
Route::post('/asignar', 'ControladorAdmin@asignar');
//QUITAR ASIGNACION
Route::get('/desasignar/{idu}/{idp}', 'ControladorAdmin@desasignar');


//comentario alan
//otro comentario

//Enviar Mails
Route::get('/enviar_correo', 'ControladorVistaPedidos@enviar');
//Enviar Mails
Route::get('/enviar_correoA', 'ControladorVistaPedidos@enviarAbierta');

//------------------Mostrar Ordenes Finalizadas
Route::get('/MostrarOrdenesFinalizadas','ControladorVistaPedidos@mostrarOrdenesFinalizadas');
//------------------Mostrar PDF a Director
Route::get('/verOrdenFinalizada/{idOrden}','ControladorVistaPedidos@mostrarPDFFinalizada');

//------------------ Modificar User
Route::put('/user/{id}', 'HomeController@ModificarUser');
//------------------ Mostrar Edicion User
Route::get('/users/{id}', 'HomeController@mostrarUsersEditar');






//-----------------------------------IR A INGRESO DE FACTURAS
Route::get('/ingresoFacturaOrdenes', 'ControladorVistaPedidos@ingresoFacturaOrdenes');
Route::get('/ingresoFactura/{ido}', 'ControladorVistaPedidos@ingresoFactura');
Route::post('/AgregarFactura', 'ControladorVistaPedidos@agregarFactura');