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

    public function mostrarSolicitudesManager(){
        $nsolicitudes = solicitude::where('respondido_manager','0')
                                    ->count();
        Session::put('countSolicitudesManager',$nsolicitudes);

        $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                            WHERE s.respondido_manager = '0' AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
    
        return view('VistaPedidosManager', [ 'querySolicitudes' => $solicitudes ]);
    }

    public function aceptarSolicitudManager($id){
        $solicitudes = solicitude::where('respondido_manager','0')
                                    ->count();
        Session::put('countSolicitudesManager',$solicitudes);

        $solicitud = solicitude::findOrFail($id);
        $solicitud->respondido_manager='1';
        $solicitud->aprobado_manager='1';
        $solicitud->save();
        return redirect('MostrarSolicitudesManager');
    }

    public function rechazarSolicitudManager($id){
        $solicitudes = solicitude::where('respondido_manager','0')
                                    ->count();
        Session::put('countSolicitudesManager',$solicitudes);

        $solicitud = solicitude::findOrFail($id);
        $solicitud->respondido_manager='1';
        $solicitud->aprobado_manager='0';
        $solicitud->save();
        return redirect('MostrarSolicitudesManager');
    }





    public function mostrarSolicitudesDirector(){
        $nsolicitudes = solicitude::where('respondido_manager','1')
                                    ->where('aprobado_manager','1')
                                    ->where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudesDirector',$nsolicitudes);

        $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                            WHERE s.respondido_manager = '1' 
                                            AND s.aprobado_manager = '1'
                                            AND s.respondido_director = '0'
                                            AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
    
        return view('VistaPedidosDirector', [ 'querySolicitudes' => $solicitudes ]);
    }

    public function aceptarSolicitudDirector($id){
        $nsolicitudes = solicitude::where('respondido_manager','1')
                                    ->where('aprobado_manager','1')
                                    ->where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudesDirector',$nsolicitudes);

        $solicitud = solicitude::findOrFail($id);
        $solicitud->respondido_director='1';
        $solicitud->aprobado_director='1';
        $solicitud->save();
        return redirect('MostrarSolicitudesDirector');
    }

    public function rechazarSolicitudDirector($id){
        $nsolicitudes = solicitude::where('respondido_manager','1')
                                    ->where('aprobado_manager','1')
                                    ->where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudesDirector',$nsolicitudes);

        $solicitud = solicitude::findOrFail($id);
        $solicitud->respondido_director='1';
        $solicitud->aprobado_director='0';
        $solicitud->save();
        return redirect('MostrarSolicitudesDirector');
    }





    public function mostrarSolicitudesColaborador(){
        $solicitudes = solicitude::where('mostrar','1')
                                    ->where('email',Auth::user()->email)
                                    ->count();
        Session::put('countSolicitudesColaborador',$solicitudes);

        $email = Auth::user()->email;

        $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, p.nombre_proyecto, s.proveedor, s.respondido_manager, s.aprobado_manager, s.respondido_director, s.aprobado_director
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                            WHERE s.mostrar = '1' 
                                            AND s.email = '$email'
                                            AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
    
        return view('VistaPedidosColaborador', [ 'querySolicitudes' => $solicitudes ]);
    }

    public function dejarSolicitud($id){
        $solicitudes = solicitude::where('mostrar','1')
                                    ->where('email',Auth::user()->email)
                                    ->count();
        Session::put('countSolicitudesColaborador',$solicitudes);

        $solicitud = solicitude::findOrFail($id);
        $solicitud->mostrar='0';
        $solicitud->save();
        return redirect('MostrarSolicitudesColaborador');
    }






    public function mostrarSolicitudesCompras(){
        $solicitudes = solicitude::where('aprobado_manager','1')
                                    ->where('aprobado_director','1')
                                    ->where('orden_creada','0')
                                    ->count();
        Session::put('countSolicitudesCompras',$solicitudes);

        $email = Auth::user()->email;

        $solicitudes = DB::select(DB::raw("SELECT s.id as id, s.titulo_solicitud, s.id_partida, s.rol, pa.nombre, p.nombre_proyecto, s.proveedor, p.id as id_proyecto, pa.id as id_partida
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                            WHERE aprobado_manager = '1' 
                                            AND aprobado_director = '1'
                                            AND s.orden_creada = '0'
                                            AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
    
        return view('VistaPedidosCompras', [ 'querySolicitudes' => $solicitudes ]);
    }
















    /*public function mostrarSolicitudes(){
        $solicitudes = solicitude::where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudes',$solicitudes);
        $solicitudes = DB::select(DB::raw("SELECT s.id, s.proveedor,s.listado, s.partida, s.rol, p.nombre_proyecto 
                                            FROM solicitudes AS s, proyectos AS p 
                                            WHERE s.respondido_director = '0' AND s.id_proyecto = p.id;"));
        $solicitudes = solicitude::all();
        $solicitudes = solicitude::where('respondido_director','0')
                                    //->orderBy('name','desc')
                                    //->take(10) //obtener solo 10 registros
                                    ->get();
        return view('VistaPedidosAdmin', [ 'querySolicitudes' => $solicitudes ]);
    }*/


    

}

?>