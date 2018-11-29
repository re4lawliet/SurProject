<?php
/*****************************************************************************************************/

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


use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\cliente;
use App\Client;

//Route::get('/', function () {
  //  return view('welcome');
//});

Route::get('/', function () {
    if( Auth::user() ) //se valida si esta logueado
        if( Auth::user()->rol =='admin' ) //se valida el tipo de usuario
        return view('welcomeAdmin');
        else
            return view('welcome');
    else
        return view('welcome');
});

/*********************************/
/*    Forma de Controladores     */
/*********************************/

//------------------ Mostrar Clientes
Route::get('/clientes', 'ControladorClientes@mostrarClientes');

//------------------ Mostrar Edicion Clientes
Route::get('/clientes/{id}', 'ControladorClientes@mostrarClientesEditar');

//------------------ Agregar Clientes
Route::post('/cliente', 'ControladorClientes@AgregarCliente');

//------------------ Eliminar Clientes
Route::delete('/cliente/{id}', 'ControladorClientes@EliminarCliente');

//------------------ Modificar Clientes
Route::put('/cliente/{id}', 'ControladorClientes@ModificarCliente');

//------------------ Loguin

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/homeAdmin', 'HomeController@indexAdmin')->name('homeAdmin');
