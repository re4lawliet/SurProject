<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SUR\solicitude;
use SUR\proyecto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControladorVistaPedidos extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('colaborador');
    }

    public function Vista()
    {
        Session::put('rollogueado', Auth::user()->rol);
        return view('VistaPedidosAdmin');
    }


    public function mostrarSolicitudes(){
        $solicitudes = solicitude::where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudes',$solicitudes);

        $solicitudes = DB::select(DB::raw("SELECT s.id, s.proveedor,s.listado, s.partida, s.rol, p.nombre_proyecto 
                                            FROM solicitudes AS s, proyectos AS p 
                                            WHERE s.respondido_director = '0' AND s.id_proyecto = p.id;"));
        
        
        //$solicitudes = solicitude::all();
        /*$solicitudes = solicitude::where('respondido_director','0')
                                    //->orderBy('name','desc')
                                    //->take(10) //obtener solo 10 registros
                                    ->get();*/
        return view('VistaPedidosAdmin', [ 'querySolicitudes' => $solicitudes ]);
    }

    public function aceptarSolicitud($id){
        $solicitudes = solicitude::where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudes',$solicitudes);

        $solicitud = solicitude::findOrFail($id);
        $solicitud->respondido_director='1';
        $solicitud->aprobado_director='1';
        $solicitud->save();
        return redirect('/MostrarSolicitudes');
    }

    public function rechazarSolicitud($id){
        $solicitudes = solicitude::where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudes',$solicitudes);

        $solicitud = solicitude::findOrFail($id);
        $solicitud->respondido_director='1';
        $solicitud->aprobado_director='0';
        $solicitud->save();
        return redirect('/MostrarSolicitudes');
    }

    

}

?>