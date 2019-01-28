<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SUR\proyecto;
use SUR\solicitude;
use SUR\orden_abierta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControladorCompras extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('compras');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexCompras(Request $request)
    {
        $solicitudes = solicitude::where('aprobado_manager','1')
                                    ->where('aprobado_director','1')
                                    ->where('orden_creada','0')
                                    ->count();

        Session::put('countSolicitudesCompras',$solicitudes);

        $orden = DB::table('orden')->where('respuesta_conta', '3')->count();

        Session::put('countOrdenesRechazadas',$orden); 

        $orden = DB::table('orden')->where('respuesta_conta', '2')->count();

        Session::put('countOrdenesFinalizadas',$orden); 

        $orden_abierta = DB::table('orden')->where('abierta','1')->count();

        Session::put('countOrdenesAbiertas',$orden_abierta); 

        

        $name = $request->get('name');
        
        $proyectos = proyecto::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('homeCompras', compact('proyectos'));
    }

}
