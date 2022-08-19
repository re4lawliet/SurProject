<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use Exception;

class ControladorRecepcion extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('recepcion');
    }

    public function indexRecepcion(Request $request)
    {
        try{
            $solicitudes = DB::table('orden')
                                ->where('respuesta_conta','2')
                                ->count();
            Session::put('countSolicitudesConta',$solicitudes);

            $name = $request->get('name');
            
            $proyectos = proyecto::orderBy('id', 'DESC')
            ->name($name)
            ->paginate(10);
            
            return view('homeRecepcion', compact('proyectos'));
        }catch (Exception $e) { 
            Session::flash('catch_error','Home de Recepcion');
            return view('ErrorCatch');  
        }
    }
}
