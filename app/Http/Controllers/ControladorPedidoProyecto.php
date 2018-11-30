<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\solicitude;
use SUR\temporal_producto;
use SUR\partida;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControladorPedidoProyecto extends Controller{

    public function __construct(){

        $this->middleware('auth');
       // $this->middleware();        
    }

    public function solicitud()
    {
        //Session::put('rollogueado', Auth::user()->name);
        //Session::put('rollogueado2', Auth::user()->apellido);

        $oldlat = Auth::user()->name;
        $oldlong = Auth::user()->apellido;
        $oldMarker = $oldlat . ' ' . $oldlong;

        Session::put('rollogueado', $oldMarker);

        $temporal_productos = temporal_producto::all();
        
        $partidas = partida::all();

        return view('ModuloProyecto.SolicitudProyecto', [ 'temporal_productos' => $temporal_productos ],[ 'partidas' => $partidas ]);
    }

    public function AgregarPedido(Request $request){
        $validator = Validator::make($request->all(), [
            'titulo_solicitud' => 'required|max:255',
            'proveedor' => 'max:255',
            'partida' => 'max:248',            
        ]);

        if ($validator->fails()) {
            return redirect('/solicitud')
                ->withInput()
                ->withErrors($validator);
        }
        $logiado = Session::get('rollogueado');
        $idproyecto = Session::get('proyectoG');
        $solicitud = new Solicitude;
        $solicitud->titulo_solicitud = $request->titulo_solicitud;
        $solicitud->proveedor = $request->proveedor;
        $solicitud->id_partida = $request->id_partida;
        $solicitud->rol = $logiado;
        $solicitud->respondido_manager='0';
        $solicitud->aprobado_manager='0';
        $solicitud->respondido_director='0';
        $solicitud->aprobado_director ='0';
        $solicitud->id_proyecto=$idproyecto;
        $solicitud->save();

        $id_solicitud = DB::select(DB::raw("SELECT MAX(id) FROM solicitudes"));

        $cargaSolicitud = DB::select(DB::raw("INSERT INTO listados (descripcion,unidad,cantidad, id_solicitud)
                                              (SELECT t.descripcion, t.unidad, t.cantidad, s.id 
                                                FROM temporal_productos as t, solicitudes s
                                                WHERE s.id=(SELECT max(id) FROM solicitudes))"));

        $solicitudes = DB::select(DB::raw("DELETE FROM temporal_productos;"));
        Session::flash('message','Solicitud Agregada correctamente');
        return redirect('solicitud');
    }

}