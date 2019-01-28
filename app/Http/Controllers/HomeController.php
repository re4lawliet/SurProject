<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;
use SUR\empresa;
use SUR\uss;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function ModificarUser(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nombre_nombre' => 'required|max:255',
            'nombre_apellido' => 'required|max:255',
            'contra_antigua' => 'required|max:255',
            'contra_nueva' => 'required|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect('/users'."/$id")
                ->withInput()
                ->withErrors($validator);
        }
        $empres = uss::findOrFail($id);

        if (Hash::check($request->contra_antigua, Auth::user()->password)){

            $empres->name = $request->nombre_nombre;
            $empres->apellido = $request->nombre_apellido;
            $empres->password = Hash::make($request->contra_nueva);

            $empres->save();
            Session::flash('message2','Cambio Contraseña Correcto');

            return redirect('/users'."/$id");

        }else{
            Session::flash('message3','Cambio Contraseña Incorrecto');

            return redirect('/users'."/$id");
        }

    }

    public function mostrarUsersEditar($id){

        $empresa = uss::findOrFail($id);
        return view('user-editar', [ 'empresa' => $empresa ]);
    }

}
