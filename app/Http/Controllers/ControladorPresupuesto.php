<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SUR\presupuesto;

class ControladorPresupuesto extends Controller
{
    public function mostrarPresupuesto($idProyecto){
        $partidas = DB::select(DB::raw("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida, pr.presupuesto, pr.orden_sumada, pr.saldo
                                            FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o, presupuesto as pr
                                            WHERE p.id = $idProyecto
                                            AND o.id_proyecto = $idProyecto
                                            AND o.enviado = '1'
                                            AND s.id = o.id_solicitud
                                            AND pa.id = s.id_partida
                                            AND e.id = o.id_proveedor
                                            AND pr.id_proyecto = p.id
                                            AND pr.id_partida = pa.id
                                            AND pr.divisa = e.divisa
                                            GROUP BY pa.id, e.divisa ;"));

        $partidas_nuevas = DB::select(DB::raw("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida
                                                FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
                                                WHERE p.id = $idProyecto
                                                AND o.id_proyecto = $idProyecto
                                                AND o.enviado = '1'
                                                AND s.id = o.id_solicitud
                                                AND pa.id = s.id_partida
                                                AND e.id = o.id_proveedor
                                                AND NOT EXISTS (
                                                    SELECT * FROM presupuesto AS pr
                                                    WHERE pr.id_proyecto = p.id
                                                    AND pr.id_partida = pa.id
                                                    AND pr.divisa = e.divisa
                                                )
                                                GROUP BY pa.id, e.divisa;"));

        $proyecto = DB::select(DB::raw("SELECT id, nombre_proyecto
                                        FROM proyectos
                                        WHERE id = $idProyecto ;"));

        return view('crearPresupuesto')->with('partidas',$partidas)
                                        ->with('proyectos',$proyecto)
                                        ->with('nuevas',$partidas_nuevas);
    }



    public function guardarPresupuesto(Request $request){
        $val_id_proyecto = $request->txt_id_proyecto;
        $val_ids = $request->txt_ids;
        $val_divisas = $request->txt_divisas;
        $val_presupuestos = $request->txt_presupuestos;
        $val_orden_sumada = $request->txt_orden_sumada;
        $val_saldos = $request->txt_saldos;

        $arr_ids = explode(",",$val_ids);
        $arr_divisas = explode(",",$val_divisas);
        $arr_presupuestos = explode(",",$val_presupuestos);
        $arr_orden_sumada = explode(",",$val_orden_sumada);
        $arr_saldos = explode(",",$val_saldos);

        //ELIMINAMOS LOS VIEJOS DATOS 
        $insertarPresupuestos = DB::select(DB::raw("DELETE FROM presupuesto WHERE id_proyecto=30;
                                                    "));
        
        
        //insertar en tabla Presupuesto
        for($i =0; $i<sizeof($arr_ids);$i++){
            $insertarPresupuestos = DB::select(DB::raw("INSERT IGNORE INTO presupuesto
                                                        (id_proyecto, id_partida, divisa, presupuesto, orden_sumada, saldo)
                                                        VALUES ($val_id_proyecto, $arr_ids[$i], '$arr_divisas[$i]', '$arr_presupuestos[$i]', '$arr_orden_sumada[$i]', '$arr_saldos[$i]');"));
        }

        echo($val_id_proyecto.'<br>');
        echo($val_ids.'<br>');
        echo($val_divisas.'<br>');
        echo($val_presupuestos.'<br>');
        echo($val_orden_sumada.'<br>');
        echo($val_saldos.'<br>');
    }
}


/*
SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida, pr.presupuesto, pr.orden_sumada, pr.saldo
                                            FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o, presupuesto as pr
                                            WHERE p.id = 30
                                            AND o.id_proyecto = 30
                                            AND o.enviado = '1'
                                            AND s.id = o.id_solicitud
                                            AND pa.id = s.id_partida
                                            AND e.id = o.id_proveedor
                                            AND pr.id_proyecto = p.id
                                            AND pr.id_partida = pa.id
                                            AND pr.divisa = e.divisa
                                            GROUP BY pa.id, e.divisa




                                            SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida
                                            FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
                                            WHERE p.id = 30
                                            AND o.id_proyecto = 30
                                            AND o.enviado = '1'
                                            AND s.id = o.id_solicitud
                                            AND pa.id = s.id_partida
                                            AND e.id = o.id_proveedor
                                            GROUP BY pa.id, e.divisa


                                            */