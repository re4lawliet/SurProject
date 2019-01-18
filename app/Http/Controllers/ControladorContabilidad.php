<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;

class ControladorContabilidad extends Controller
{
    //
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('contabilidad');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexContabilidad(Request $request)
    {
        $solicitudes = solicitude::where('aprobado_manager','1')
                                    ->where('aprobado_director','1')
                                    ->where('orden_creada','0')
                                    ->count();
        Session::put('countSolicitudesCompras',$solicitudes);

        $name = $request->get('name');
        
        $proyectos = proyecto::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('homeContabilidad', compact('proyectos'));
    }
}
