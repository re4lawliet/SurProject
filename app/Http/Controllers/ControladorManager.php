<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
Use Exception;

class ControladorManager extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('manager');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexManager(Request $request)
    {
        try{
            $nsolicitudes = solicitude::where('respondido_manager','0')
                                        ->count();
            Session::put('countSolicitudesManager',$nsolicitudes);

            $solicitudes2 = solicitude::where('mostrar','1')
                                        ->where('email',Auth::user()->email)
                                        ->count();
            Session::put('countSolicitudesMiasManager',$solicitudes2);
            
            $nsolicitudes3 = solicitude::where('aprobado_manager','1')
                                        ->where('respondido_manager','1')
                                        ->count();
            Session::put('countSolicitudesManagerAprobadas',$nsolicitudes3);

            $nsolicitudes4 = solicitude::where('aprobado_manager','0')
                                        ->where('respondido_manager','1')
                                        ->count();
            Session::put('countSolicitudesManagerRechazadas',$nsolicitudes4);

            $name = $request->get('name');

            //..............MANAGERS
            /*
            if(Auth::user()->email=="r.diaz@sur.gt"){//granat narama
                $proyectos = proyecto::where('nombre_proyecto','GRANAT, Cantón Exposición')
                ->orwhere('nombre_proyecto','NARAMA')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }else if(Auth::user()->email=="j.gonzalez@sur.gt"){//Baldone, Airali
                $proyectos = proyecto::where('nombre_proyecto','BALDONE')
                ->orwhere('nombre_proyecto','AIRALI')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }else if(Auth::user()->email=="mj.morales@sur.gt"){//Sur Properties
                $proyectos = proyecto::where('nombre_proyecto','SUR PROPERTIES, S.A.')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }else if(Auth::user()->email=="d.perez@sur.gt"){//Roque
                $proyectos = proyecto::where('nombre_proyecto','ROQUE, Ciudad Nueva')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }else{
                $proyectos = proyecto::orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }
            */
            //..............MANAGERS
            $proyectos = proyecto::orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);


            return view('homeManager', compact('proyectos'));

        } catch (Exception $e) { 
            Session::flash('catch_error','Carga Home Manager');
            return view('ErrorCatch');  
        }
    }
}
