<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
Use Exception;

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
        try{
            $solicitudes = DB::table('orden')
                                ->where('respuesta_conta','1')
                                ->count();
            Session::put('countSolicitudesConta',$solicitudes);

            $solicitudesFinalizadas = DB::table('orden')
                                ->where('respuesta_conta','2')
                                ->count();
            Session::put('countSolicitudesContaFinalizadas',$solicitudesFinalizadas);

            $name = $request->get('name');
            
            $proyectos = proyecto::orderBy('id', 'DESC')
            ->name($name)
            ->paginate(10);
            
            return view('homeContabilidad', compact('proyectos'));

        } catch (Exception $e) { 
            Session::flash('catch_error','Carga Home Contabilidad');
            return view('ErrorCatch');  
        }
    }
}
