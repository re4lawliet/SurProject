<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use SUR\solicitude;
use SUR\listado;
use SUR\proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ControladorModuloSolicitudes extends Controller
{
    public function verSolicitud($id, $npa, $npr){
        $sol = solicitude::findOrFail($id);
        Session::put('s_id', $id);
        Session::put('s_titulo', $sol->titulo_solicitud);
        Session::put('s_id_partida', $sol->id_partida);
        Session::put('s_solicitante', $sol->rol);
        Session::put('s_proveedor', $sol->proveedor);
        //nombre partida
        Session::put('s_npartida', $npa);
        //proyecto
        Session::put('s_nproyecto', $npr);
        $list = listado::where('id_solicitud',$id)->get();
        $solicitudes = DB::select(DB::raw("SELECT *
                                            FROM listados
                                            WHERE id_solicitud = $id;"));
        return view('homeSolicitudManager', ['queryListado' => $solicitudes]);
    }

    public function verSolicitudDirector($id, $npa, $npr){
        $sol = solicitude::findOrFail($id);
        Session::put('s_id', $id);
        Session::put('s_titulo', $sol->titulo_solicitud);
        Session::put('s_id_partida', $sol->id_partida);
        Session::put('s_solicitante', $sol->rol);
        Session::put('s_proveedor', $sol->proveedor);
        //nombre partida
        Session::put('s_npartida', $npa);
        //proyecto
        Session::put('s_nproyecto', $npr);
        $list = listado::where('id_solicitud',$id)->get();
        $solicitudes = DB::select(DB::raw("SELECT *
                                            FROM listados
                                            WHERE id_solicitud = $id;"));
        return view('homeSolicitudDirector', ['queryListado' => $solicitudes]);
    }


    public function verSolicitudCompras($id_solicitud, $id_partida, $id_proyecto){
        $sol = solicitude::findOrFail($id_solicitud);
        Session::put('s_id', $id_solicitud);
        Session::put('s_titulo', $sol->titulo_solicitud);
        Session::put('s_id_partida', $sol->id_partida);
        Session::put('s_solicitante', $sol->rol);
        Session::put('s_proveedor', $sol->proveedor);
        //nombre partida
        $partida = DB::select(DB::raw("SELECT *
                                        FROM partidas
                                        WHERE id = $id_partida;"));
        //proyecto
        $proyecto = DB::select(DB::raw("SELECT *
                                        FROM proyectos
                                        WHERE id = $id_proyecto;"));
        
        //solicitudes
        $solicitudes = DB::select(DB::raw("SELECT *
                                            FROM listados
                                            WHERE id_solicitud = $id_solicitud;"));
        
        $emp = DB::select(DB::raw("SELECT * FROM empresas;"));

        $prove = DB::select(DB::raw("SELECT * 
                                        FROM empresas
                                        WHERE id = 'inexistente';"));

        return view('homeOrdenSolicitud')
                                            ->with('queryListado',$solicitudes)
                                            ->with('partidas',$partida)
                                            ->with('queryEmpresas' , $emp)
                                            ->with('queryProveedores',$prove)
                                            ->with('queryProyecto',$proyecto);
    }

    
    public function verSolicitudComprasProv($id_solicitud, $id_partida, $id_proyecto, $id_proveedor){
        $sol = solicitude::findOrFail($id_solicitud);
        Session::put('s_id', $id_solicitud);
        Session::put('s_titulo', $sol->titulo_solicitud);
        Session::put('s_id_partida', $sol->id_partida);
        Session::put('s_solicitante', $sol->rol);
        Session::put('s_proveedor', $sol->proveedor);
        //nombre partida
        $partida = DB::select(DB::raw("SELECT *
                                        FROM partidas
                                        WHERE id = $id_partida;"));
        //proyecto
        $proyecto = DB::select(DB::raw("SELECT *
                                        FROM proyectos
                                        WHERE id = $id_proyecto;"));
        //solicitudes
        $solicitudes = DB::select(DB::raw("SELECT *
                                            FROM listados
                                            WHERE id_solicitud = $id_solicitud;"));
        
        $emp = DB::select(DB::raw("SELECT * FROM empresas;"));

        $prove = DB::select(DB::raw("SELECT * 
                                        FROM empresas 
                                        WHERE id = $id_proveedor;"));

        return view('homeOrdenSolicitud')
                                        ->with('queryListado',$solicitudes)
                                        ->with('partidas',$partida)
                                        ->with('queryEmpresas' , $emp)
                                        ->with('queryProveedores',$prove)
                                        ->with('queryProyecto',$proyecto);
    }


    public function crearOrden(Request $request){
        $val_id_proveedor = $request->id_emp;
        $val_tipo_pago = $request->tipo_pago;
        $val_precios_unitarios = $request->txt_precios_unitarios;
        $val_subtotales = $request->txt_subtotales;
        $val_total = $request->txt_total;
        $val_id_proyecto = $request->id_proyecto;
        $val_correos = $request->correos;
        echo('id_proveedor '.$val_id_proveedor);
        echo('<br>tipo_pago'.$val_tipo_pago);
        echo('<br>precios_unitarios'.$val_precios_unitarios);
        echo('<br>subtotales'.$val_subtotales);
        echo('<br>total'.$val_total);
        echo('<br>id_proyecto'.$val_id_proyecto);
        echo('<br>correos'.$val_correos);
    }










    

}
