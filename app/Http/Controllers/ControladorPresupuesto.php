<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SUR\presupuesto;
use Illuminate\Support\Facades\Session;
Use Exception;


class ControladorPresupuesto extends Controller
{
    public function mostrarPresupuesto($idProyecto){

        try{

        /*CONSULTA DE PARTIDAS CON SUS SUMAS
            SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, SUM(o.total) as total_partida
                                                    FROM proyectos as p, partidas as pa, solicitudes as s, orden as o
                                                    WHERE p.id = $idProyecto
                                                    AND o.id_proyecto = $idProyecto
                                                    AND o.enviado = '1'
                                                    AND s.id = o.id_solicitud
                                                    AND pa.id = s.id_partida
                                                    GROUP BY pa.id;
        */
        /*$partidas = DB::select(DB::raw("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida, pr.presupuesto, pr.orden_sumada, pr.saldo
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
                                            GROUP BY pa.id, e.divisa ;"));*/

        /*$partidas_nuevas = DB::select(DB::raw("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida
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
                                                GROUP BY pa.id, e.divisa;"));*/

        $partidas_nuevas =  DB::select(DB::raw("SELECT p.id_partida, p.presupuesto, p.orden_sumada, p.saldo, pa.nombre 
                                                FROM presupuesto as p, partidas as pa
                                                WHERE p.id_proyecto = $idProyecto
                                                AND p.id_partida = pa.id; "));

        $proyecto = DB::select(DB::raw("SELECT id, nombre_proyecto
                                        FROM proyectos
                                        WHERE id = $idProyecto ;"));

        return view('crearPresupuesto')->with('proyectos',$proyecto)
                                        ->with('nuevas',$partidas_nuevas);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Presupuesto');
            return view('ErrorCatch');  
        }
    }

//

    public function guardarPresupuesto(Request $request){
        try{

            $val_id_proyecto = $request->txt_id_proyecto;
            $val_ids = $request->txt_ids;
            $val_presupuestos = $request->txt_presupuestos;
            $val_orden_sumada = $request->txt_orden_sumada;
            $val_saldos = $request->txt_saldos;
            //replace<br> que no se donde lo agrega
            $val_presupuestos = str_ireplace("<br>","",$val_presupuestos);

            $arr_ids = explode(",",$val_ids);
            $arr_presupuestos = explode(",",$val_presupuestos);
            $arr_orden_sumada = explode(",",$val_orden_sumada);
            $arr_saldos = explode(",",$val_saldos);

                
            //insertar en tabla Presupuesto
            for($i =0; $i<sizeof($arr_ids);$i++){
                $insertarPresupuestos = DB::update("UPDATE presupuesto
                                                            SET presupuesto = '$arr_presupuestos[$i]', orden_sumada = '$arr_orden_sumada[$i]', saldo = '$arr_saldos[$i]'
                                                            WHERE id_proyecto = $val_id_proyecto
                                                            AND id_partida = $arr_ids[$i];");
            }

            return redirect('vistaPresupuesto/'.$val_id_proyecto);

        }catch (Exception $e) { 
            Session::flash('catch_error','Guardar Presupuesto: Primero Debe Calcular Saldos Antes de Guardar');
            return view('ErrorCatch');  
        }
    }


    public function consultaPresupuesto($idProyecto){

        try{        
        /*$partidas = DB::select(DB::raw("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, e.divisa, SUM(o.total) as total_partida, pr.presupuesto, pr.orden_sumada, pr.saldo
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
                                            GROUP BY pa.id, e.divisa ;"));*/
    
        $partidas =  DB::select(DB::raw("SELECT p.id_proyecto, p.id_partida, p.presupuesto, p.orden_sumada, p.saldo, pa.nombre 
                                                FROM presupuesto as p, partidas as pa
                                                WHERE p.id_proyecto = $idProyecto
                                                AND p.id_partida = pa.id; "));
    
        $proyecto = DB::select(DB::raw("SELECT id, nombre_proyecto
                                        FROM proyectos
                                        WHERE id = $idProyecto ;"));

        $sumas = DB::select(DB::raw("SELECT SUM(p.presupuesto) as Sp, SUM(p.orden_sumada) as So, SUM(p.saldo) as Ss
                                        FROM presupuesto as p, partidas as pa
                                        WHERE p.id_proyecto = $idProyecto
                                        AND p.id_partida = pa.id;"));
    
        return view('consultarPresupuesto')->with('partidas',$partidas)
                                        ->with('proyectos',$proyecto)
                                        ->with('sumas',$sumas);
        }catch (Exception $e) { 
            Session::flash('catch_error','Consultar Presupuesto');
            return view('ErrorCatch');  
        }
    }

    
    public function desglose($idProyecto,$idPartida){

        try{
        $compras = DB::select(DB::raw("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, (o.total * o.tasa_cambio) as total, e.nombre_empresa, s.titulo_solicitud, o.no_orden, o.fecha_creacion, o.pagado, ((o.total * o.tasa_cambio) - o.pagado) as pendiente
                                            FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
                                            WHERE p.id = $idProyecto
                                            AND o.id_proyecto = $idProyecto
                                            AND o.enviado = '1'
                                            AND o.respuesta_conta = '2'
                                            AND s.id = o.id_solicitud
                                            AND pa.id = s.id_partida
                                            AND pa.id = $idPartida
                                            AND e.id = o.id_proveedor;"));

            $proyecto = DB::select(DB::raw("SELECT id, nombre_proyecto
                                            FROM proyectos
                                            WHERE id = $idProyecto ;"));


            return view('tablaDesglose')->with('compras', $compras)
                                                ->with('proyecto',$proyecto);
        }catch (Exception $e) { 
            Session::flash('catch_error','Desglose De Presupuesto');
            return view('ErrorCatch');  
        }
    }

    public function PresupuestoCompleto($idProyecto){
        try {
            Session::put('id_proyecto_completo',$idProyecto);
            //Informacion basica del Proyecto
            $proyecto = DB::select("SELECT id, nombre_proyecto
                                        FROM proyectos
                                        WHERE id = $idProyecto ;");

            //Todas las partidas
            $partidas =  DB::select("SELECT id as id_partida, nombre 
                                    FROM partidas; ");

            //Todas las compras del proyecto
            //$compras = DB::select("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, (o.total * o.tasa_cambio) as total, e.nombre_empresa, s.titulo_solicitud
            $compras = DB::select("SELECT o.fecha_creacion, o.no_orden, e.nombre_empresa, s.titulo_solicitud, ROUND((o.total * o.tasa_cambio),2) as total, ROUND((o.pagado * o.tasa_cambio),2) as pagado, ROUND(((o.total * o.tasa_cambio) - (o.pagado * o.tasa_cambio)),2) as saldo, p.id as id_proyecto, pa.id as id_partida
                                    FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
                                    WHERE p.id = $idProyecto
                                    AND o.id_proyecto = $idProyecto
                                    AND o.enviado = '1'
                                    AND o.respuesta_conta = '2'
                                    AND s.id = o.id_solicitud
                                    AND pa.id = s.id_partida
                                    AND e.id = o.id_proveedor
                                    order by id_partida;");
            
            $sumas = DB::select(DB::raw("SELECT ROUND(SUM((o.total * o.tasa_cambio)),2) as Sp, ROUND(SUM((o.pagado * o.tasa_cambio)),2) as So, ROUND(SUM(((o.total * o.tasa_cambio) - (o.pagado * o.tasa_cambio))),2) as Ss
            FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
            WHERE p.id = $idProyecto
            AND o.id_proyecto = $idProyecto
            AND o.enviado = '1'
            AND o.respuesta_conta = '2'
            AND s.id = o.id_solicitud
            AND pa.id = s.id_partida
            AND e.id = o.id_proveedor
            order by id_partida;"));

            $array = array();

            foreach($partidas as $partida){

                $fila = array($partida->id_partida, $partida->nombre, "","","","","","","");
                array_push($array, $fila);

                foreach($compras as $compra){
                    
                    if($compra->id_partida === $partida->id_partida){
                        $fila2 = array("", "", $compra->fecha_creacion,$compra->no_orden,$compra->nombre_empresa,$compra->titulo_solicitud,$compra->total,$compra->pagado,$compra->saldo);
                        array_push($array,$fila2);
                    }

                }

            }

            return view('presupuestoCompleto')->with('proyectos',$proyecto)
                                                ->with('compras', $compras)
                                                ->with('partidas',$partidas)
                                                ->with('matriz', $array)
                                                ->with('sumas', $sumas);

            

        } catch (Exception $e) {
            Session::flash('catch_error','Presupuesto Completo '+$e->msgfmt_get_error_message);
            return view('ErrorCatch');  
        }
    }

    public function PresupuestoCompleto2($fi, $ff){
        try {
            $idProyecto=Session::get('id_proyecto_completo');

            $replaced1 = str_replace('-', '/', $fi);
            $replaced2 = str_replace('-', '/', $ff);

            //Informacion basica del Proyecto
            $proyecto = DB::select("SELECT id, nombre_proyecto
                                        FROM proyectos
                                        WHERE id = $idProyecto ;");

            //Todas las partidas
            $partidas =  DB::select("SELECT id as id_partida, nombre 
                                    FROM partidas; ");

            //Todas las compras del proyecto
            //$compras = DB::select("SELECT p.id as id_proyecto, p.nombre_proyecto, pa.id as id_partida, pa.nombre as nombre_partida, (o.total * o.tasa_cambio) as total, e.nombre_empresa, s.titulo_solicitud
            $compras = DB::select("SELECT o.fecha_creacion, o.no_orden, e.nombre_empresa, s.titulo_solicitud, ROUND((o.total * o.tasa_cambio),2) as total, ROUND((o.pagado * o.tasa_cambio),2) as pagado, ROUND(((o.total * o.tasa_cambio) - (o.pagado * o.tasa_cambio)),2) as saldo, p.id as id_proyecto, pa.id as id_partida
                                    FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
                                    WHERE p.id = $idProyecto
                                    AND o.id_proyecto = $idProyecto
                                    AND o.enviado = '1'
                                    AND o.respuesta_conta = '2'
                                    AND s.id = o.id_solicitud
                                    AND pa.id = s.id_partida
                                    AND e.id = o.id_proveedor
                                    AND DATE_FORMAT(o.fecha_creacion, '%d/%m/%y') BETWEEN DATE_FORMAT('$replaced1', '%d/%m/%y') AND DATE_FORMAT('$replaced2', '%d/%m/%y')
                                    order by id_partida;");

            $sumas = DB::select(DB::raw("SELECT ROUND(SUM((o.total * o.tasa_cambio)),2) as Sp, ROUND(SUM((o.pagado * o.tasa_cambio)),2) as So, ROUND(SUM(((o.total * o.tasa_cambio) - (o.pagado * o.tasa_cambio))),2) as Ss
            FROM proyectos as p, partidas as pa, solicitudes as s, empresas as e, orden as o
                                    WHERE p.id = $idProyecto
                                    AND o.id_proyecto = $idProyecto
                                    AND o.enviado = '1'
                                    AND o.respuesta_conta = '2'
                                    AND s.id = o.id_solicitud
                                    AND pa.id = s.id_partida
                                    AND e.id = o.id_proveedor
                                    AND DATE_FORMAT(o.fecha_creacion, '%d/%m/%y') BETWEEN DATE_FORMAT('$replaced1', '%d/%m/%y') AND DATE_FORMAT('$replaced2', '%d/%m/%y')
                                    order by id_partida;"));

            $array = array();

            foreach($partidas as $partida){

                $fila = array($partida->id_partida, $partida->nombre, "","","","","","","");
                array_push($array, $fila);

                foreach($compras as $compra){
                    
                    if($compra->id_partida === $partida->id_partida){
                        $fila2 = array("", "", $compra->fecha_creacion,$compra->no_orden,$compra->nombre_empresa,$compra->titulo_solicitud,$compra->total,$compra->pagado,$compra->saldo);
                        array_push($array,$fila2);
                    }

                }

            }

            return view('presupuestoCompleto2')->with('proyectos',$proyecto)
                                                ->with('compras', $compras)
                                                ->with('partidas',$partidas)
                                                ->with('matriz', $array)
                                                ->with('sumas', $sumas);


            

        } catch (Exception $e) {
            Session::flash('catch_error','Presupuesto Completo '+$e->msgfmt_get_error_message);
            return view('ErrorCatch');  
        }
    }
}

