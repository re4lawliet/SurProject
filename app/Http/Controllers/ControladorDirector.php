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

class ControladorDirector extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('director');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexDirector(Request $request)
    {
        //try{
     
            

            $name = $request->get('name');
            
                //..............MANAGERS 
                $iduser = Auth::user()->id;

                //--------------SOLICITUDES
                //-solicitudes pendientes
                $solicitudsPendientes = DB::select("SELECT COUNT(*) as numero
                                                        FROM solicitudes as s, usuario_proyecto as up
                                                        WHERE s.id_proyecto = up.id_proyecto
                                                        AND up.id_usuario = $iduser
                                                        AND s.respondido_manager = '1'
                                                        AND s.aprobado_manager = '1'
                                                        AND s.respondido_director = '0';");

                foreach($solicitudsPendientes as $sp){
                        Session::put('countSolicitudesMiasDirector',$sp->numero);
                }
                //-solicitudes aprobadas
                $solicitudsAprobadas = DB::select("SELECT COUNT(*) as numero
                                                        FROM solicitudes as s, usuario_proyecto as up
                                                        WHERE s.id_proyecto = up.id_proyecto
                                                        AND up.id_usuario = $iduser
                                                        AND s.respondido_manager = '1'
                                                        AND s.aprobado_manager = '1'
                                                        AND s.respondido_director = '1'
                                                        AND s.aprobado_director = '1';");

                foreach($solicitudsAprobadas as $sa){
                        Session::put('countSolicitudesDirectorAprobadas',$sa->numero);
                }
                //-solicitudes rechazadas
                $solicitudsRechazadas = DB::select("SELECT COUNT(*) as numero
                                                        FROM solicitudes as s, usuario_proyecto as up
                                                        WHERE s.id_proyecto = up.id_proyecto
                                                        AND up.id_usuario = $iduser
                                                        AND s.respondido_manager = '1'
                                                        AND s.aprobado_manager = '1'
                                                        AND s.respondido_director = '1'
                                                        AND s.aprobado_director = '0';");

                foreach($solicitudsRechazadas as $sr){
                        Session::put('countSolicitudesDirectorRechazadas',$sr->numero);
                }



                
                //---------ORDENES
                $orden = DB::select("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p, usuario_proyecto as up
                        WHERE respuesta_conta = '0'

                        AND up.id_usuario = $iduser
                        AND p.id = up.id_proyecto

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;");    
                Session::put('countOrdenesAprobadas',count($orden)); 

                $orden2 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p, usuario_proyecto as up
                        WHERE respuesta_conta = '2'

                        AND up.id_usuario = $iduser
                        AND p.id = up.id_proyecto

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));
                Session::put('countOrdenesFinalizadas',count($orden2));


                $orden3 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, oa.fecha, oa.haber, oa.id_orden, oa.abono
                        FROM orden_abierta as oa, orden as o, solicitudes as s, empresas as e, proyectos as p, usuario_proyecto as up
                        WHERE oa.respuesta_conta = '0'
                        AND oa.abono != '1'

                        AND up.id_usuario = $iduser
                        AND p.id = up.id_proyecto

                        AND o.id = oa.id_orden
                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));

                Session::put('countOrdenesAbiertas',count($orden3)); 

                $nsolicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, usuario_proyecto as up
                                WHERE s.respondido_manager = '1' 
                                AND s.aprobado_manager = '1'

                                AND up.id_usuario = $iduser
                                AND p.id = up.id_proyecto

                                AND s.respondido_director = '0'
                                AND s.id_proyecto = p.id AND s.id_partida = pa.id;")); 
                                
                Session::put('countSolicitudesDirector',count($nsolicitudes));

                //----------PROYECTOS----------//
                $proyectos = DB::select("SELECT *
                                        FROM proyectos as p, usuario_proyecto as up 
                                        WHERE up.id_usuario = $iduser
                                        AND p.id = up.id_proyecto;");





            
            /*if(Auth::user()->email=="r.diaz@sur.gt"){//granat narama

                $orden = DB::select("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE respuesta_conta = '0'

                        AND (p.nombre_proyecto = 'GRANAT, Cantón Exposición'
                        OR p.nombre_proyecto = 'NARAMA')

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;");    
                Session::put('countOrdenesAprobadas',count($orden)); 

                $orden2 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE respuesta_conta = '2'

                        AND (p.nombre_proyecto = 'GRANAT, Cantón Exposición'
                        OR p.nombre_proyecto = 'NARAMA')

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));
                Session::put('countOrdenesFinalizadas',count($orden2)); 

                $orden3 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, oa.fecha, oa.haber, oa.id_orden, oa.abono
                        FROM orden_abierta as oa, orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE oa.respuesta_conta = '0'
                        AND oa.abono != '1'

                        AND (p.nombre_proyecto = 'GRANAT, Cantón Exposición'
                        OR p.nombre_proyecto = 'NARAMA')

                        AND o.id = oa.id_orden
                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));

                Session::put('countOrdenesAbiertas',count($orden3)); 

                $nsolicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                WHERE s.respondido_manager = '1' 
                                AND s.aprobado_manager = '1'

                                AND (p.nombre_proyecto = 'GRANAT, Cantón Exposición'
                                OR p.nombre_proyecto = 'NARAMA')

                                AND s.respondido_director = '0'
                                AND s.id_proyecto = p.id AND s.id_partida = pa.id;")); 

                Session::put('countSolicitudesDirector',count($nsolicitudes));


            }else if(Auth::user()->email=="j.gonzalez@sur.gt"){//Baldone, Airali

                $orden = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE respuesta_conta = '0'

                        AND (p.nombre_proyecto = 'BALDONE'
                        OR p.nombre_proyecto = 'AIRALI')

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));    
                Session::put('countOrdenesAprobadas',count($orden)); 

                $orden2 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE respuesta_conta = '2'

                        AND (p.nombre_proyecto = 'BALDONE'
                        OR p.nombre_proyecto = 'AIRALI')

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));
                Session::put('countOrdenesFinalizadas',count($orden2)); 

                $orden3 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, oa.fecha, oa.haber, oa.id_orden, oa.abono
                        FROM orden_abierta as oa, orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE oa.respuesta_conta = '0'
                        AND oa.abono != '1'

                        AND (p.nombre_proyecto = 'BALDONE'
                        OR p.nombre_proyecto = 'AIRALI')

                        AND o.id = oa.id_orden
                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));

                Session::put('countOrdenesAbiertas',count($orden3)); 

                $nsolicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                        FROM solicitudes AS s, proyectos AS p, partidas AS pa
                        WHERE s.respondido_manager = '1' 
                        AND s.aprobado_manager = '1'

                        AND (p.nombre_proyecto = 'BALDONE'
                        OR p.nombre_proyecto = 'AIRALI')

                        AND s.respondido_director = '0'
                        AND s.id_proyecto = p.id AND s.id_partida = pa.id;")); 

                Session::put('countSolicitudesDirector',count($nsolicitudes));


                $proyectos = proyecto::where('nombre_proyecto','BALDONE')
                ->orwhere('nombre_proyecto','AIRALI')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);



            }else if(Auth::user()->email=="mj.morales@sur.gt"){//Sur Properties

                $orden = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE respuesta_conta = '0'

                        AND p.nombre_proyecto = 'SUR PROPERTIES, S.A.'

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));    
                Session::put('countOrdenesAprobadas',count($orden)); 

                $orden2 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE respuesta_conta = '2'

                        AND p.nombre_proyecto = 'SUR PROPERTIES, S.A.'

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));
                Session::put('countOrdenesFinalizadas',count($orden2));
                
                $orden3 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, oa.fecha, oa.haber, oa.id_orden, oa.abono
                        FROM orden_abierta as oa, orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE oa.respuesta_conta = '0'
                        AND oa.abono != '1'

                        AND p.nombre_proyecto = 'SUR PROPERTIES, S.A.'

                        AND o.id = oa.id_orden
                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));

                Session::put('countOrdenesAbiertas',count($orden3)); 
                

                $nsolicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                        FROM solicitudes AS s, proyectos AS p, partidas AS pa
                        WHERE s.respondido_manager = '1' 
                        AND s.aprobado_manager = '1'

                        AND p.nombre_proyecto = 'SUR PROPERTIES, S.A.'

                        AND s.respondido_director = '0'
                        AND s.id_proyecto = p.id AND s.id_partida = pa.id;")); 

                Session::put('countSolicitudesDirector',count($nsolicitudes));

                $proyectos = proyecto::where('nombre_proyecto','SUR PROPERTIES, S.A.')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);


            }else if(Auth::user()->email=="d.perez@sur.gt"){//Roque

                $orden = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE respuesta_conta = '0'

                        AND p.nombre_proyecto = 'ROQUE, Ciudad Nueva'

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));    
                Session::put('countOrdenesAprobadas',count($orden)); 

                $orden2 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE respuesta_conta = '2'

                        AND p.nombre_proyecto = 'ROQUE, Ciudad Nueva'

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));
                Session::put('countOrdenesFinalizadas',count($orden2)); 

                $orden3 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, oa.fecha, oa.haber, oa.id_orden, oa.abono
                        FROM orden_abierta as oa, orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE oa.respuesta_conta = '0'
                        AND oa.abono != '1'

                        AND p.nombre_proyecto = 'ROQUE, Ciudad Nueva'

                        AND o.id = oa.id_orden
                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));

                Session::put('countOrdenesAbiertas',count($orden3)); 

                $nsolicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                        FROM solicitudes AS s, proyectos AS p, partidas AS pa
                        WHERE s.respondido_manager = '1' 
                        AND s.aprobado_manager = '1'

                        AND p.nombre_proyecto = 'ROQUE, Ciudad Nueva'

                        AND s.respondido_director = '0'
                        AND s.id_proyecto = p.id AND s.id_partida = pa.id;")); 

                Session::put('countSolicitudesDirector',count($nsolicitudes));

                $proyectos = proyecto::where('nombre_proyecto','ROQUE, Ciudad Nueva')
                ->orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }else{

                $orden = DB::table('orden')
                ->where('respuesta_conta', '0')
                ->count();
                Session::put('countOrdenesAprobadas',$orden); 

                $orden2 = DB::table('orden')
                ->where('respuesta_conta', '2')
                ->count();
                Session::put('countOrdenesFinalizadas',$orden2); 

                $orden3 = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, oa.fecha, oa.haber, oa.id_orden, oa.abono
                        FROM orden_abierta as oa, orden as o, solicitudes as s, empresas as e, proyectos as p
                        WHERE oa.respuesta_conta = '0'
                        AND oa.abono != '1'
                        AND o.id = oa.id_orden
                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));

                Session::put('countOrdenesAbiertas',count($orden3)); 

                $nsolicitudes = solicitude::where('respondido_manager','1')
                                        ->where('aprobado_manager','1')
                                        ->where('respondido_director','0')
                                        ->count();
                Session::put('countSolicitudesDirector',$nsolicitudes);

                $proyectos = proyecto::orderBy('id', 'DESC')
                ->name($name)
                ->paginate(10);
            }*/
            
            //..............MANAGERS
            
            return view('homeDirector', compact('proyectos'));

        /*} catch (Exception $e) { 
            Session::flash('catch_error','Carga Home Director');
            return view('ErrorCatch');  
        }*/
    }
}
