<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\solicitude;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

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
        
        return view('ModuloProyecto.SolicitudProyecto');
    }

    public function AgregarPedido(Request $request){
        $validator = Validator::make($request->all(), [
            'proveedor' => 'required|max:255',
            'listado' => 'max:2000',
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
        $solicitud->proveedor = $request->proveedor;
        $solicitud->listado = $request->listado;
        $solicitud->partida = $request->partida;
        $solicitud->rol = $logiado;
        $solicitud->respondido_director='0';
        $solicitud->respondido_manager='0';
        $solicitud->aprobado_director ='0';
        $solicitud->aprobado_manager='0';
        $solicitud->id_proyecto=$idproyecto;
        $solicitud->save();
        Session::flash('message','Agregado correctamente');
        return redirect('solicitud');
    }

}