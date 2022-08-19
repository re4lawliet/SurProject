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
Use Exception;

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
        try{

            $solicitudes = solicitude::where('aprobado_manager','1')
                                        ->where('aprobado_director','1')
                                        ->where('orden_creada','0')
                                        ->count();

            Session::put('countSolicitudesCompras',$solicitudes);

            $orden = DB::table('orden')->where('respuesta_conta', '3')->count();

            Session::put('countOrdenesRechazadas',$orden); 

            $orden = DB::table('orden')->where('respuesta_conta', '2')->count();

            Session::put('countOrdenesFinalizadas',$orden); 

            $ordenesA = DB::select(DB::raw("SELECT o.id as id_orden, s.titulo_solicitud, pa.nombre as partida, pr.nombre_proyecto, e.nombre_empresa, o.total, o.pagado, e.divisa, o.respuesta_conta
                                            FROM orden as o, solicitudes as s, partidas as pa, proyectos as pr, empresas as e 
                                            WHERE o.abierta = '1'
                                            AND o.total!=o.pagado
                                            AND s.id = o.id_solicitud
                                            AND pa.id = s.id_partida
                                            AND pr.id = o.id_proyecto
                                            AND e.id = o.id_proveedor;")); 

            Session::put('countOrdenesAbiertas',count($ordenesA)); 

            

            $name = $request->get('name');
            
            $proyectos = proyecto::orderBy('id', 'DESC')
            ->name($name)
            ->paginate(10);
            
            return view('homeCompras', compact('proyectos'));

        } catch (Exception $e) { 
            Session::flash('catch_error','Carga Home Compras');
            return view('ErrorCatch');  
        }
    }

}
