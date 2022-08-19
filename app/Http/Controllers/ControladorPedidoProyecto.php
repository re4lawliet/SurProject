<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\solicitude;
use SUR\temporal_producto;
use SUR\partida;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use Exception;

class ControladorPedidoProyecto extends Controller{

    public function __construct(){

        $this->middleware('auth');
       // $this->middleware();        
    }

    public function solicitud()
    {
        try{
            //Session::put('rollogueado', Auth::user()->name);
            //Session::put('rollogueado2', Auth::user()->apellido);

            $oldlat = Auth::user()->name;
            $oldlong = Auth::user()->apellido;
            $oldMarker = $oldlat . ' ' . $oldlong;

            Session::put('rollogueado', $oldMarker);

            $email = Auth::user()->email;
            $temporal_productos = DB::select("SELECT *
                                                FROM temporal_productos
                                                WHERE usuario = '$email'");
            
            $partidas = partida::all();

            return view('ModuloProyecto.SolicitudProyecto', [ 'temporal_productos' => $temporal_productos ],[ 'partidas' => $partidas ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Solicitud Pedido de Proyecto');
            return view('ErrorCatch');  
        }
    }

    public function AgregarPedido(Request $request){
        //try{
        date_default_timezone_set('America/Guatemala');
        $fecha = date('d/m/y');
        $validator = Validator::make($request->all(), [
            'titulo_solicitud' => 'required|max:255',
            'proveedor' => 'max:255',
            'partida' => 'max:248',            
        ]);

        // if ($validator->fails()) {
        //     return redirect('/solicitud')
        //         ->withInput()
        //         ->withErrors($validator);
        // }
        $logiado = Session::get('rollogueado');
        $idproyecto = Session::get('proyectoG');
        

        $solicitud = new Solicitude;
        $solicitud->titulo_solicitud = $request->titulo_solicitud;
        $solicitud->proveedor = $request->proveedor;
        $solicitud->id_partida = $request->id_partida;
        $solicitud->email = Auth::user()->email;
        $solicitud->rol = $logiado;
        
        $solicitud->mostrar = '1';
        if(Auth::user()->rol == 'colaborador'){
            $solicitud->respondido_manager='0';
            $solicitud->aprobado_manager='0';
            $solicitud->respondido_director='0';
            $solicitud->aprobado_director ='0';
        }else if(Auth::user()->rol == 'manager'){
            $solicitud->respondido_manager='1';
            $solicitud->aprobado_manager='1';
            $solicitud->fecha_manager = $fecha;
            $solicitud->respondido_director='0';
            $solicitud->aprobado_director ='0';
        }else if(Auth::user()->rol == 'director'){
            $solicitud->respondido_manager='1';
            $solicitud->aprobado_manager='1';
            $solicitud->fecha_manager = $fecha;
            $solicitud->respondido_director='1';
            $solicitud->aprobado_director ='1';
            $solicitud->fecha_director = $fecha;
        }else if(Auth::user()->rol == 'compras'){
            $solicitud->respondido_manager='1';
            $solicitud->aprobado_manager='1';
            $solicitud->fecha_manager = $fecha;
            $solicitud->respondido_director='1';
            $solicitud->aprobado_director ='1';
            $solicitud->fecha_director = $fecha;
        }
        
        $solicitud->orden_creada = '0';
        $solicitud->id_proyecto=$idproyecto;
        $solicitud->fecha_solicitud = $fecha;
        $solicitud->save();

        $id_solicitud = DB::select("SELECT MAX(id) as id FROM solicitudes");

        //PDF
        foreach($id_solicitud as $ids){
            $nombrep = 'pres'.$ids->id;
            $nombreimg =$_FILES['presupuesto']['name'];//nombre relativo
            $archivo =$_FILES['presupuesto']['tmp_name'];//archivo binario
            /**SUSTITUCIONES
             * Se sustituyen caracteres no deseados en el nombre
             */
            $incorrectos = array(".", " ", "á","Á","é","É","í","Í","ó","Ó","ú","Ú");
            $correctos = array("", "_", "a","A","e","E","i","I","o","O","u","U");
            $ruta0 = $nombrep.$nombreimg;
            $ruta1 = str_replace($incorrectos, $correctos, $ruta0);
            $ruta="PDF/".$ruta1.".pdf";

            if(strpos($ruta, '.pdf')){
                move_uploaded_file($archivo,$ruta);
            }else{
                $ruta="";
            }
            if ($_FILES['presupuesto']['name'] != null) {
                $sol = DB::update("UPDATE solicitudes
                                    SET presupuesto = '$ruta'
                                    WHERE id = $ids->id");
            }
        }
        
        
        $email = Auth::user()->email;
        $cargaSolicitud = DB::insert("INSERT INTO listados (descripcion,unidad,cantidad, id_solicitud)
                                              (SELECT t.descripcion, t.unidad, t.cantidad, s.id 
                                                FROM temporal_productos as t, solicitudes s
                                                WHERE t.usuario = '$email'
                                                AND s.id=(SELECT max(id) FROM solicitudes))");

        $solicitudes = DB::delete("DELETE FROM temporal_productos
                                    WHERE usuario = '$email';");
        
        
        Session::flash('message','Solicitud Agregada correctamente');
        $solicitudes = solicitude::where('mostrar','1')
                                    ->where('email',Auth::user()->email)
                                    ->count();
        Session::put('countSolicitudesColaborador',$solicitudes);
        return redirect('solicitud');
        // }catch (Exception $e) { 
        //     Session::flash('catch_error','Agregar Pedido');
        //     return view('ErrorCatch');  
        // }
    }

}