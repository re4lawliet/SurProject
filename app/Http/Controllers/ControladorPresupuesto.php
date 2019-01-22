<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SUR\presupuesto;

class ControladorPresupuesto extends Controller
{
    public function mostrarPresupuesto($idProyecto){

        $presupuesto = DB::select(DB::raw("SELECT * FROM presupuesto WHERE id_proyecto = $idProyecto;"));

        if($presupuesto==NULL){
            $partidas = DB::select(DB::raw("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida
                                            FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
                                            WHERE p.id = $idProyecto
                                            AND o.id_proyecto = $idProyecto
                                            AND o.enviado = '1'
                                            AND s.id = o.id_solicitud
                                            AND pa.id = s.id_partida
                                            AND e.id = o.id_proveedor
                                            GROUP BY pa.id, e.divisa ;"));
        
        
            $proyecto = DB::select(DB::raw("SELECT nombre_proyecto
                                        FROM proyectos
                                        WHERE id = $idProyecto ;"));

        return view('crearPresupuesto')->with('partidas',$partidas)
                                        ->with('proyectos',$proyecto)
                                        ->with('presupuesto',$presupuesto);
        }else{

            $partidas = DB::select(DB::raw("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida
                                            FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
                                            WHERE p.id = $idProyecto
                                            AND o.id_proyecto = $idProyecto
                                            AND o.enviado = '1'
                                            AND s.id = o.id_solicitud
                                            AND pa.id = s.id_partida
                                            AND e.id = o.id_proveedor
                                            GROUP BY pa.id, e.divisa ;"));
        
        
            $proyecto = DB::select(DB::raw("SELECT nombre_proyecto
                                        FROM proyectos
                                        WHERE id = $idProyecto ;"));

            return view('crearPresupuesto')->with('partidas',$partidas)
                                        ->with('proyectos',$proyecto)
                                        ->with('presupuesto',$presupuesto);
        }

        
    }
}
