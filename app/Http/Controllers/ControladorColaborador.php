<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Use Exception;

class ControladorColaborador extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('colaborador');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexColaborador(Request $request)
    {
        try{

            $solicitudes = solicitude::where('mostrar','1')
                                        ->where('email',Auth::user()->email)
                                        ->count();
            Session::put('countSolicitudesColaborador',$solicitudes);

            $name = $request->get('name');

            //-------------Restringe Colaboradores::::::::::::::::::::::
            
            if(Auth::user()->email=="g.macario@sur.gt" || Auth::user()->email=="p.gutierrez@sur.gt" ){//granat
                $proyectos = proyecto::where('nombre_proyecto','GRANAT, Cantón Exposición')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
                
            }else if(Auth::user()->email=="a.velasquez@sur.gt" || Auth::user()->email=="j.hernandez@sur.gt" ){//Narama
                $proyectos = proyecto::where('nombre_proyecto','NARAMA')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
                
            }else if(Auth::user()->email=="h.barillas@sur.gt"|| Auth::user()->email=="g.debroy@sur.gt"){//Roque
                $proyectos = proyecto::where('nombre_proyecto','ROQUE, Ciudad Nueva')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);

            }else if(Auth::user()->email=="s.garcia@sur.gt"){//Sur Properties
                $proyectos = proyecto::where('nombre_proyecto','SUR PROPERTIES, S.A.')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }else{
                $proyectos = proyecto::orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }
            //-------------Restringe Colaboradores::::::::::::::::::::::
            
            return view('homeColaborador', compact('proyectos'));

        } catch (Exception $e) { 
            Session::flash('catch_error','Carga Home Colaborador');
            return view('ErrorCatch');  
        }
    }
}
