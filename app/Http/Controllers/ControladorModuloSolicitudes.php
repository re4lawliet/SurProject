<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use SUR\solicitude;
use SUR\listado;
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


    public function verSolicitudCompras($id, $npa, $npr){
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
        
        $emp = DB::select(DB::raw("SELECT * FROM empresas;"));

        return view('homeOrdenSolicitud', ['queryListado' => $solicitudes], ['queryEmpresas' => $emp]);
    }
}
