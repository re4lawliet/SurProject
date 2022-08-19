<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SUR\solicitude;
use SUR\proyecto;
use SUR\orden;
use SUR\empresa;
use SUR\orden_abierta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use PDF;
Use Exception;

class ControladorVistaPedidos extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('colaborador');
    }

    public function mostrarSolicitudesManager(){
        try{
            $nsolicitudes = solicitude::where('respondido_manager','0')
                                        ->count();
            Session::put('countSolicitudesManager',$nsolicitudes);

            $solicitudes = DB::select(DB::raw("SELECT s.fecha_solicitud, s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                                WHERE s.respondido_manager = '0' AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
        
            return view('VistaPedidosManager', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes Manager');
            return view('ErrorCatch');  
        }
    }

    public function responderSolicitudManager(){
        try{
            $id = Session::get('s_id');
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            //----PDF
            $nombrep = 'pres'.$id;
            $nombreimg =$_FILES['presupuesto']['name'];//nombre relativo
            $archivo =$_FILES['presupuesto']['tmp_name'];//archivo binario
            $ruta="PDF/".$nombrep.$nombreimg;
            if(strpos($ruta, '.pdf')){
                move_uploaded_file($archivo,$ruta);
            }else{
                $ruta="";
            }
            $solicitud = solicitude::findOrFail($id);
            $solicitud->respondido_manager='1';
            if(isset($_POST['aceptar'])){
                $solicitud->aprobado_manager='1';
            }else if(isset($_POST['rechazar'])){
                $solicitud->aprobado_manager='0';
            }
            if ($_FILES['presupuesto']['name'] != null) {
                $solicitud->presupuesto=$ruta;
            }
            $solicitud->fecha_manager = $fecha;
            $solicitud->save();
            $solicitudes = solicitude::where('respondido_manager','0')
                                        ->count();
            Session::put('countSolicitudesManager',$solicitudes);
            return redirect('MostrarSolicitudesManager');

        }catch (Exception $e) { 
            Session::flash('catch_error','Responder Solicitud Manager');
            return view('ErrorCatch');  
        }
    }

    





    public function mostrarSolicitudesDirector(){
        try{
            $iduser = Auth::user()->id;
            $solicitudes = DB::select(DB::raw("SELECT s.fecha_solicitud, s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, usuario_proyecto as up
                                WHERE s.respondido_manager = '1' 
                                AND s.aprobado_manager = '1'

                                AND up.id_usuario = $iduser
                                AND p.id = up.id_proyecto

                                AND s.respondido_director = '0'
                                AND s.id_proyecto = p.id AND s.id_partida = pa.id;")); 


            return view('VistaPedidosDirector', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes Director');
            return view('ErrorCatch');  
        }
    }

    public function mostrarSolicitudesAprobadasDirector(){
        try{

            $iduser = Auth::user()->id;
            $solicitudes = DB::select(DB::raw("SELECT s.fecha_solicitud, s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, usuario_proyecto as up
                                WHERE s.respondido_manager = '1' 
                                AND s.aprobado_manager = '1'
                                AND s.respondido_director = '1'
                                AND s.aprobado_director = '1'

                                AND up.id_usuario = $iduser
                                AND p.id = up.id_proyecto

                                AND s.id_proyecto = p.id AND s.id_partida = pa.id;")); 


            return view('VistaPedidosAprobadosDirector', [ 'querySolicitudes' => $solicitudes ]);

        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes Director');
            return view('ErrorCatch');  
        }

    }


    public function mostrarSolicitudesRechazadasDirector(){
        try{

            $iduser = Auth::user()->id;
            $solicitudes = DB::select(DB::raw("SELECT s.fecha_solicitud, s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, usuario_proyecto as up
                                WHERE s.respondido_manager = '1' 
                                AND s.aprobado_manager = '1'
                                AND s.respondido_director = '1'
                                AND s.aprobado_director = '0'

                                AND up.id_usuario = $iduser
                                AND p.id = up.id_proyecto

                                AND s.id_proyecto = p.id AND s.id_partida = pa.id;")); 


            return view('VistaPedidosRechazadosDirector', [ 'querySolicitudes' => $solicitudes ]);

        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes Director');
            return view('ErrorCatch');  
        }

    }



    public function aceptarSolicitudDirector($id){
        try{
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            $solicitud = solicitude::findOrFail($id);
            $solicitud->respondido_director='1';
            $solicitud->aprobado_director='1';
            $solicitud->fecha_director = $fecha;
            $solicitud->save();
            /*
            $nsolicitudes = solicitude::where('respondido_manager','1')
                                        ->where('aprobado_manager','1')
                                        ->where('respondido_director','0')
                                        ->count();
            Session::put('countSolicitudesDirector',$nsolicitudes);*/

            return redirect('MostrarSolicitudesDirector');
        }catch (Exception $e) { 
            Session::flash('catch_error','Aceptar Solicitud Director');
            return view('ErrorCatch');  
        }
    }

    public function rechazarSolicitudDirector($id){
        try{
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            $solicitud = solicitude::findOrFail($id);
            $solicitud->respondido_director='1';
            $solicitud->aprobado_director='0';
            $solicitud->fecha_director = $fecha;
            $solicitud->save();

            $nsolicitudes = solicitude::where('respondido_manager','1')
                                        ->where('aprobado_manager','1')
                                        ->where('respondido_director','0')
                                        ->count();
            Session::put('countSolicitudesDirector',$nsolicitudes);

            return redirect('MostrarSolicitudesDirector');
        }catch (Exception $e) { 
            Session::flash('catch_error','Rechazar Solicitud Director');
            return view('ErrorCatch');  
        }
    }





    public function mostrarSolicitudesColaborador(){
        try{
            $solicitudes = solicitude::where('mostrar','1')
                                        ->where('email',Auth::user()->email)
                                        ->count();
            Session::put('countSolicitudesColaborador',$solicitudes);

            $email = Auth::user()->email;

            $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, p.nombre_proyecto, s.proveedor, s.respondido_manager, s.aprobado_manager, s.respondido_director, s.aprobado_director, s.orden_creada
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                                WHERE s.mostrar = '1' 
                                                AND s.email = '$email'
                                                AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
        
            return view('VistaPedidosColaborador', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes al Colaborador');
            return view('ErrorCatch');  
        }
    }

    public function mostrarSolicitudesColaborador2(){

            $solicitudes = solicitude::where('mostrar','1')
                                        ->where('email',Auth::user()->email)
                                        ->count();
            Session::put('countSolicitudesColaborador2',$solicitudes);

            $iduser = Auth::user()->id;

            $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, s.fecha_solicitud, pa.nombre, p.nombre_proyecto, s.proveedor, s.respondido_manager, s.aprobado_manager, s.respondido_director, s.aprobado_director, s.orden_creada
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, usuario_proyecto AS up
                                                WHERE s.mostrar = '1' 
                                                AND s.id_proyecto=up.id_proyecto
                                                AND up.id_usuario=$iduser
                                                AND s.id_proyecto = p.id AND s.id_partida = pa.id
                                                ORDER BY s.fecha_solicitud DESC;"));                             
        
            return view('VistaPedidosColaborador2', [ 'querySolicitudes' => $solicitudes ]);

    }

    public function dejarSolicitud($id){
        try{
            $solicitudes = solicitude::where('mostrar','1')
                                        ->where('email',Auth::user()->email)
                                        ->count();
            Session::put('countSolicitudesColaborador',$solicitudes);

            $solicitud = solicitude::findOrFail($id);
            $solicitud->mostrar='0';
            $solicitud->save();
            return redirect('MostrarSolicitudesColaborador');
        }catch (Exception $e) { 
            Session::flash('catch_error','Dejar Solicitud');
            return view('ErrorCatch');  
        }
    }




    public function modificarSolicitud($id){
        try{
            $solicitudes = solicitude::where('mostrar','1')
                                        ->where('email',Auth::user()->email)
                                        ->count();
            Session::put('countSolicitudesColaborador',$solicitudes);

            $solicitud = DB::select("SELECT s.id, s.titulo_solicitud, s.id_partida, s.id_proyecto, s.proveedor, s.presupuesto, p.nombre, pr.nombre_proyecto
                                        FROM solicitudes as s, partidas as p, proyectos as pr
                                        WHERE s.id = $id
                                        AND p.id = s.id_partida
                                        AND pr.id = s.id_proyecto;");

            $listado = DB::select("SELECT cantidad, unidad, descripcion
                                    FROM listados
                                    WHERE id_solicitud = $id");

            return view('ModificarSolicitud')->with('querySolicitud',$solicitud)
                                                ->with('queryListado',$listado);
        }catch (Exception $e) { 
            Session::flash('catch_error','Dejar Solicitud');
            return view('ErrorCatch');  
        }
    }





    public function modificarCotizacion(){
        $id = $_POST['id_solicitud'];
        $ruta_vieja = $_POST['pdf_viejo'];
        //----PDF
        $nombrep = 'pres'.$id;
        $nombreimg =$_FILES['presupuesto']['name'];//nombre relativo
        $archivo =$_FILES['presupuesto']['tmp_name'];//archivo binario
        if($nombreimg==""){
            $ruta = $ruta_vieja;
        }else{
            $ruta="PDF/".$nombrep.$nombreimg;
            move_uploaded_file($archivo,$ruta);
        }
        $solicitud = solicitude::findOrFail($id);
        if ($_FILES['presupuesto']['name'] != null) {
            $solicitud->presupuesto=$ruta;
        }
        $solicitud->save();

        $solicitudes = solicitude::where('mostrar','1')
                                        ->where('email',Auth::user()->email)
                                        ->count();
            Session::put('countSolicitudesColaborador2',$solicitudes);

            $iduser = Auth::user()->id;

            $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, p.nombre_proyecto, s.proveedor, s.respondido_manager, s.aprobado_manager, s.respondido_director, s.aprobado_director, s.orden_creada
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, usuario_proyecto AS up
                                                WHERE s.mostrar = '1' 
                                                AND s.id_proyecto=up.id_proyecto
                                                AND up.id_usuario=$iduser
                                                AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
        
            return view('VistaPedidosColaborador2', [ 'querySolicitudes' => $solicitudes ]);
    }






    public function mostrarSolicitudesCompras(){
        try{
            $solicitudes = solicitude::where('aprobado_manager','1')
                                        ->where('aprobado_director','1')
                                        ->where('orden_creada','0')
                                        ->count();
            Session::put('countSolicitudesCompras',$solicitudes);

            $email = Auth::user()->email;

            $solicitudes = DB::select(DB::raw("SELECT s.fecha_solicitud, s.id as id, s.titulo_solicitud, s.id_partida, s.rol, pa.nombre, p.nombre_proyecto, s.proveedor, p.id as id_proyecto, pa.id as id_partida
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                                WHERE aprobado_manager = '1' 
                                                AND aprobado_director = '1'
                                                AND s.orden_creada = '0'
                                                AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
        
            return view('VistaPedidosCompras', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes Compras');
            return view('ErrorCatch');  
        }
    }


    public function mostrarSolicitudesContador(){
        try{
            $solicitudes2 = DB::table('orden')
                                ->where('respuesta_conta','1')
                                ->count();
            Session::put('countSolicitudesConta',$solicitudes2);

            $solicitudes = DB::select(DB::raw("SELECT DISTINCT ord.id, ord.fecha_creacion, s.titulo_solicitud, pro.nombre_empresa, p.nombre_proyecto, ord.id_solicitud, ord.id_proveedor,ord.id_proyecto, ord.no_orden, pa.nombre, s.id_partida   
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, orden AS ord, empresas AS pro 
                                                WHERE ord.id_solicitud = s.id 
                                                AND ord.id_proveedor = pro.id 
                                                AND ord.id_proyecto = p.id 
                                                AND ord.respuesta_conta = '1'
                                                AND pa.id=s.id_partida
                                                ;
                                                "));                             
        
            return view('VistaPedidosContador', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes al Contador');
            return view('ErrorCatch');  
        }
    }

    
    public function aceptarSolicitudContador(Request $request,$id){
        // try{
        // $validator = Validator::make($request->all(), [
        //     'comentario' => 'required|max:2000',   
        // ]);
    
        // if ($validator->fails()) {
        //     return redirect('MostrarSolicitudesContador')
        //         ->withInput()
        //         ->withErrors($validator);
        // }
       /*
        $comentarioAceptada="[Aceptada] ".$request->comentario;

        date_default_timezone_set('America/Guatemala');
        $fecha = date('d/m/y');
        $solicitud = orden::findOrFail($id);
        //$solicitud->respuesta_conta='2';
        $solicitud->comentario_conta=$comentarioAceptada;
        $solicitud->fecha_contador = $fecha;
        $solicitud->save();

        //ACTUALIZAR PRESUPUESTO
        $presupuestoViejo = DB::select(DB::raw("SELECT p.id_proyecto, p.id_partida, p.presupuesto, p.orden_sumada, p.saldo
                                                    FROM presupuesto as p, orden as o, solicitudes as s 
                                                    WHERE o.id = $id
                                                    AND p.id_proyecto = o.id_proyecto
                                                    AND s.id = o.id_solicitud
                                                    AND s.id_partida = p.id_partida;"));
                                            
        foreach($presupuestoViejo as $p){
            $nuevoTotal = floatval($p->orden_sumada) + floatval($solicitud->total) * floatval($solicitud->tasa_cambio);
            echo($p->orden_sumada.'<br>');
            echo($solicitud->total.'<br>');
            echo($solicitud->tasa_cambio.'<br>');
            

            $presupuestoNuevo = DB::select(DB::raw("UPDATE presupuesto
                                                    SET orden_sumada = $nuevoTotal
                                                    WHERE id_proyecto = $p->id_proyecto
                                                    AND id_partida = $p->id_partida;"));

            $presupuestoNuevo = DB::select(DB::raw("UPDATE presupuesto
                                                    SET saldo = presupuesto - orden_sumada
                                                    WHERE id_proyecto = $p->id_proyecto
                                                    AND id_partida = $p->id_partida;"));
        }*/

        //jalo la solicitud y le pondre 3 que es aceptada final
        // $solicitud3 = solicitude::findOrFail($solicitud->id_solicitud);
        // $solicitud3->orden_creada='3';
        // $solicitud3->save();

        // $solicitudes2 = DB::table('orden')
        //                     ->where('respuesta_conta','1')
        //                     ->count();
        // Session::put('countSolicitudesConta',$solicitudes2);

        // return redirect('MostrarSolicitudesContador');
        // }catch (Exception $e) { 
        //     Session::flash('catch_error','Aceptar Solicitud por Contador');
        //     return view('ErrorCatch');  
        // }
    }

    public function rechazarSolicitudContador(Request $request,$id){

        try{
        if(isset($_POST['aceptar_orden'])){

            $validator = Validator::make($request->all(), [
                'comentario' => 'required|max:2000',   
            ]);
        
            if ($validator->fails()) {
                return redirect('MostrarSolicitudesContador')
                    ->withInput()
                    ->withErrors($validator);
            }
           
            $comentarioAceptada="[Aceptada] ".$request->comentario;
    
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            $solicitud = orden::findOrFail($id);
            $solicitud->respuesta_conta='2';
            $solicitud->comentario_conta=$comentarioAceptada;
            $solicitud->fecha_contador = $fecha;
            $solicitud->save();

            //si el abono != 0 es por que se esta abonando 
            if($solicitud->abono == '0'){
                //ACTUALIZAR PRESUPUESTO
                $presupuestoViejo = DB::select(DB::raw("SELECT p.id_proyecto, p.id_partida, p.presupuesto, p.orden_sumada, p.saldo
                                    FROM presupuesto as p, orden as o, solicitudes as s 
                                    WHERE o.id = $id
                                    AND p.id_proyecto = o.id_proyecto
                                    AND s.id = o.id_solicitud
                                    AND s.id_partida = p.id_partida;"));

                foreach($presupuestoViejo as $p){
                $nuevoTotal = floatval($p->orden_sumada) + floatval($solicitud->total) * floatval($solicitud->tasa_cambio);

                $presupuestoNuevo = DB::update("UPDATE presupuesto
                SET orden_sumada = $nuevoTotal
                WHERE id_proyecto = $p->id_proyecto
                AND id_partida = $p->id_partida;");

                $presupuestoNuevo = DB::update("UPDATE presupuesto
                SET saldo = presupuesto - orden_sumada
                WHERE id_proyecto = $p->id_proyecto
                AND id_partida = $p->id_partida;");
                }

            }else if($solicitud->abono == '1'){
                //ACTUALIZAR PRESUPUESTO
                $presupuestoViejo = DB::select(DB::raw("SELECT p.id_proyecto, p.id_partida, p.presupuesto, p.orden_sumada, p.saldo
                                    FROM presupuesto as p, orden as o, solicitudes as s 
                                    WHERE o.id = $id
                                    AND p.id_proyecto = o.id_proyecto
                                    AND s.id = o.id_solicitud
                                    AND s.id_partida = p.id_partida;"));

                foreach($presupuestoViejo as $p){
                $nuevoTotal = floatval($p->orden_sumada) + floatval($solicitud->total) * floatval($solicitud->tasa_cambio);

                $presupuestoNuevo = DB::update("UPDATE presupuesto
                SET orden_sumada = $nuevoTotal
                WHERE id_proyecto = $p->id_proyecto
                AND id_partida = $p->id_partida;");

                $presupuestoNuevo = DB::update("UPDATE presupuesto
                SET saldo = presupuesto - orden_sumada
                WHERE id_proyecto = $p->id_proyecto
                AND id_partida = $p->id_partida;");
                }

            }else{//si el abono es == 0 Actualizamos Presupuesto

            }
            
            //jalo la solicitud y le pondre 3 que es aceptada final
            $solicitud3 = solicitude::findOrFail($solicitud->id_solicitud);
            $solicitud3->orden_creada='3';
            $solicitud3->save();

            $solicitudes2 = DB::table('orden')
                                ->where('respuesta_conta','1')
                                ->count();
            Session::put('countSolicitudesConta',$solicitudes2);

        }else if(isset($_POST['rechazar_orden'])){

            $validator = Validator::make($request->all(), [
                'comentario' => 'required|max:2000',   
            ]);
        
            if ($validator->fails()) {
                return redirect('MostrarSolicitudesContador')
                    ->withInput()
                    ->withErrors($validator);
            }
            
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            $solicitud = orden::findOrFail($id);
            $solicitud->respuesta_conta='3';
            $solicitud->comentario_conta=$request->comentario;
            $solicitud->fecha_contador = $fecha;
            $solicitud->save();
    
            //jalo la solicitud y le pondre 3 que es rechazada por conta
            $solicitud3 = solicitude::findOrFail($solicitud->id_solicitud);
            $solicitud3->orden_creada='2';
            $solicitud3->save();
    
            $solicitudes2 = DB::table('orden')
                                ->where('respuesta_conta','1')
                                ->count();
            Session::put('countSolicitudesConta',$solicitudes2);
    
        }

        return redirect('MostrarSolicitudesContador');
        }catch (Exception $e) { 
            Session::flash('catch_error','Rechazar Solicitud Contador');
            return view('ErrorCatch');  
        }
    }

    public function mostrarSolicitudesRechazadas(){
        try{
            $solicitudes2 = DB::table('orden')
                                ->where('respuesta_conta','3')
                                ->count();
            Session::put('countOrdenesRechazadas',$solicitudes2);

            $solicitudes = DB::select(DB::raw("SELECT DISTINCT ord.id, ord.fecha_creacion, s.titulo_solicitud, pro.nombre_empresa, p.nombre_proyecto, ord.id_solicitud, ord.id_proveedor,ord.id_proyecto, ord.comentario_conta, ord.fecha_contador, ord.no_orden, pa.id as idpar, pa.nombre as nombrepar
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, orden AS ord, empresas AS pro 
                                                WHERE ord.id_solicitud = s.id 
                                                AND ord.id_proveedor = pro.id 
                                                AND ord.id_proyecto = p.id 
                                                AND s.id_partida = pa.id
                                                AND ord.respuesta_conta = '3';
                                                "));                             
        
            return view('VistaPedidosOrdenesRechazadas', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes Rechazadas');
            return view('ErrorCatch');  
        }
    }


    public function aceptarSolicitudRechazada($id){
        try{
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            $solicitud = orden::findOrFail($id);
            $solicitud->respuesta_conta='4';
            $solicitud->save();

            $solicitudes2 = DB::table('orden')
                                ->where('respuesta_conta','3')
                                ->count();
            Session::put('countOrdenesRechazadas',$solicitudes2);

            return redirect('/homes');
        }catch (Exception $e) { 
            Session::flash('catch_error','Aceptar Solicitud Rechazada');
            return view('ErrorCatch');  
        }
    }


    public function mostrarSolicitudes(){
        $solicitudes = solicitude::where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudes',$solicitudes);
        $solicitudes = DB::select(DB::raw("SELECT s.id, s.proveedor,s.listado, s.partida, s.rol, p.nombre_proyecto 
                                            FROM solicitudes AS s, proyectos AS p 
                                            WHERE s.respondido_director = '0' AND s.id_proyecto = p.id;"));
        $solicitudes = solicitude::all();
        $solicitudes = solicitude::where('respondido_director','0')
                                    //->orderBy('name','desc')
                                    //->take(10) //obtener solo 10 registros
                                    ->get();
        return view('VistaPedidosAdmin', [ 'querySolicitudes' => $solicitudes ]);
    }


    public function mostrarOrdenesDirector(){
        try{
            
            //RESTRINGIR TAMBIEN LAS SOLICITUDES POR SU PROYECTO
            $iduser = Auth::user()->id;
            $ordenes = DB::select("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, o.no_orden, pa.id as idpar, pa.nombre as nombrepar
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p, usuario_proyecto as up, partidas as pa
                        WHERE respuesta_conta = '0'

                        AND up.id_usuario = $iduser
                        AND p.id = up.id_proyecto
                        AND s.id_partida = pa.id
                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"); 




        
            return view('VistaOrdenesDirector')->with('ordenes',$ordenes);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Ordenes Director');
            return view('ErrorCatch');  
        }
    }
    

    public function mostrarPDFDirector($idOrden){
        //try{
        $orden = DB::select(DB::raw("SELECT *
                                    FROM orden
                                    WHERE id = '$idOrden';"));
        Session::put('pdf_idOrden',$idOrden);
        foreach ($orden as $or) {
            Session::put('pdf_enviar',$or->pdf);
            Session::put('pdf_correos',$or->correos);
            
            //$file = $request->file('file');
            //$extension = $file->getClientOriginalExtension();
            //$nombre=$file->getClientOriginalName();
            Storage::disk('local')->put('OrdenCompra.pdf', \File::get($or->pdf));

            $solicitud = DB::select(DB::raw("SELECT *
                                    FROM solicitudes
                                    WHERE id = '$or->id_solicitud';"));
            foreach ($solicitud as $sol) {
                if($sol->presupuesto!=NULL){
                    Session::put('pdf_presupuesto',$sol->presupuesto);
                    Storage::disk('local')->put('Presupuesto.pdf', \File::get($sol->presupuesto));
                }else{
                    Session::put('pdf_presupuesto','PDF/orderfile1.pdf');
                    Storage::disk('local')->put('Presupuesto.pdf', \File::get("PDF/orderfile1.pdf"));
                }          
            }


            $proyecto = DB::select(DB::raw("SELECT *
                                    FROM proyectos
                                    WHERE id = '$or->id_proyecto';"));
            foreach ($proyecto as $proy) {
                Session::put('pdf_proyecto',$proy->nombre_proyecto);        
            }

            $provedor = DB::select(DB::raw("SELECT *
                                    FROM empresas
                                    WHERE id = '$or->id_proveedor';"));
            foreach ($provedor as $prov) {
                Session::put('pdf_provedor',$prov->nombre_encargado);        
            }

        }
        
        //seteamos en el local el archivo de presupuesto

        
        
                                    
        return view('verPDFDirector')->with('orden',$orden);
        //}catch (Exception $e) { 
          //  Session::flash('catch_error','Mostrar PDF Director');
            //return view('ErrorCatch');  
        //}
    }

    public function enviar()
    {
        try{
            $destinos=Session::get('pdf_correos');
            $idOrden=Session::get('pdf_idOrden');
            $proyectoNombre=Session::get('pdf_proyecto');
            $provedorNombre=Session::get('pdf_provedor');
            
            $valoresR1=str_replace(' ', '', $destinos);
            $valoresR2=str_replace('\n', '', $valoresR1);
            $valoresR3=str_replace('\r', '', $valoresR2);
    
            $valores = $valoresR3; 
            $valor = explode(',',$valores); 

        foreach($valor as $llave => $valorsito) 
        {
            //PDF/pres27OrdenDePagooopooo.pdf
            $nombre="OrdenCompra.pdf";
            $pathToFile= storage_path('app') ."/". $nombre;
            $nombre2="Presupuesto.pdf";
            $pathToFile2= storage_path('app') ."/". $nombre2;
            $containfile=true;
            $destinatario2="re4lawliet@gmail.com";
            $asunto="Orden de Compra De: ".$proyectoNombre;
            $contenido="Orden de Compra De: ".$proyectoNombre;

    
            $data = array('contenido' => $contenido, 'nombre' => $provedorNombre);
            $r= Mail::send('correo.plantilla_correo', $data, function ($message) use ($asunto,$valorsito,  $containfile,$pathToFile,$pathToFile2, $proyectoNombre) {
                $titulo="Sur Desarrollos: Orden de Compra: ".$proyectoNombre;
                $message->from('_mainaccount@sistema.sursur.net', $titulo);
                $message->to($valorsito)->subject($asunto);
                if($containfile){
                $message->attach($pathToFile);
                $message->attach($pathToFile2);
                }

            });      
        }
        //2 rechazada por conta
        //ahora tengo que colocar 3 por que fue enviada
        $solicitud = orden::findOrFail($idOrden);
        $solicitud->respuesta_conta='1';
        $solicitud->enviado='1';
        $solicitud->save();

        //Actualizando orden abierta si existe
        $orden_abierta = DB::update("UPDATE orden_abierta
                                                SET respuesta_conta = '1', enviado='1'
                                                WHERE id_orden = $idOrden
                                                AND abono = '1';");

        Session::flash('messageOrden','Orden de Compra Aprobada Se Enviaron Los Correos a Proveedor y a Contabilidad');


        return redirect('/homeDirector');
        }catch (Exception $e) { 
            Session::flash('catch_error','Envio de Orden De Compra Error En correos o Datos envioNormal:' . $e);
            return view('ErrorCatch');  
        }
    }


    public function mostrarOrdenesFinalizadas(){
        try{
            
            $countorden = DB::table('orden')->where('respuesta_conta', '2')->count();
            Session::put('countOrdenesFinalizadas',$countorden); 

            //RESTRINGIR TAMBIEN LAS SOLICITUDES POR SU PROYECTO
            $iduser = Auth::user()->id;
            $ordenes = DB::select(DB::raw("SELECT DISTINCT o.id, o.fecha_creacion, o.fecha_contador, o.no_orden, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, pa.id as idpar, pa.nombre as nombrepar
                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p, usuario_proyecto as up, partidas as pa
                        WHERE respuesta_conta = '2'

                        AND up.id_usuario = $iduser
                        AND p.id = up.id_proyecto

                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto
                        
                        AND s.id_partida = pa.id;"));

            
                                        
        
            return view('VistaOrdenesFinalizadas')->with('ordenes',$ordenes);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Ordenes Finalizadas');
            return view('ErrorCatch');  
        }
    }

    public function mostrarPDFFinalizada($idOrden){
        try{
        $orden = DB::select(DB::raw("SELECT *
                                    FROM orden
                                    WHERE id = '$idOrden';"));
        Session::put('pdf_idOrden',$idOrden);
        foreach ($orden as $or) {
            Session::put('pdf_enviar',$or->pdf);
            Session::put('pdf_correos',$or->correos);
            
            //$file = $request->file('file');
            //$extension = $file->getClientOriginalExtension();
            //$nombre=$file->getClientOriginalName();
            Storage::disk('local')->put('OrdenCompra.pdf', \File::get($or->pdf));

            $solicitud = DB::select(DB::raw("SELECT *
                                    FROM solicitudes
                                    WHERE id = '$or->id_solicitud';"));
            foreach ($solicitud as $sol) {
                if($sol->presupuesto!=NULL){
                    Session::put('pdf_presupuesto',$sol->presupuesto);
                    Storage::disk('local')->put('Presupuesto.pdf', \File::get($sol->presupuesto));
                }else{
                    Session::put('pdf_presupuesto','PDF/orderfile1.pdf');
                    Storage::disk('local')->put('Presupuesto.pdf', \File::get("PDF/orderfile1.pdf"));
                }          
            }


            $proyecto = DB::select(DB::raw("SELECT *
                                    FROM proyectos
                                    WHERE id = '$or->id_proyecto';"));
            foreach ($proyecto as $proy) {
                Session::put('pdf_proyecto',$proy->nombre_proyecto);        
            }

            $provedor = DB::select(DB::raw("SELECT *
                                    FROM empresas
                                    WHERE id = '$or->id_proveedor';"));
            foreach ($provedor as $prov) {
                Session::put('pdf_provedor',$prov->nombre_encargado);        
            }

        }
        
        //seteamos en el local el archivo de presupuesto

        
        
                                    
        return view('verPDFFinalizada')->with('orden',$orden);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Pdf de Orden Finalizada');
            return view('ErrorCatch');  
        }
    }


    public function mostrarOrdenesAbiertas(){
        try{
            //$orden_abierta = DB::table('orden')->where('abierta','1')->count();

            //Session::put('countOrdenesAbiertas',$orden_abierta); 


            $ordenesA = DB::select(DB::raw("SELECT o.id as id_orden, s.titulo_solicitud, pa.nombre as partida, pr.nombre_proyecto, e.nombre_empresa, o.total, o.pagado, e.divisa, o.respuesta_conta, o.no_orden, o.fecha_creacion, pa.id as idpar, pa.nombre as nombrepar
                                            FROM orden as o, solicitudes as s, partidas as pa, proyectos as pr, empresas as e 
                                            WHERE o.abierta = '1'
                                            AND o.total!=o.pagado
                                            AND s.id = o.id_solicitud
                                            AND pa.id = s.id_partida
                                            AND pr.id = o.id_proyecto
                                            AND e.id = o.id_proveedor;")); 

            Session::put('countOrdenesAbiertas',count($ordenesA));   

        
            return view('VistaOrdenesAbiertas')->with('ordenes',$ordenesA);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Ordenes Abiertas Todas');
            return view('ErrorCatch');  
        }
    }

    public function mostrarOrdenAbierta($id_Orden){
        try{
        //obteniendo datos de solicitud para titulo
        $data_solicitud = DB::select(DB::raw("SELECT s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.id as id_proyecto, p.nombre_proyecto
                                                FROM solicitudes as s, orden as o, proyectos as p, partidas as pa
                                                WHERE o.id = $id_Orden
                                                AND s.id = o.id_solicitud
                                                AND p.id = o.id_proyecto
                                                AND pa.id = s.id_partida;"));

        //data de Proveedor
        $data_proveedor = DB::select(DB::raw("SELECT e.id as id_proveedor , e.nombre_empresa, e.nit_empresa, e.direccion_empresa, e.nombre_banco, e.tipo_cuenta,e.no_cuenta, e.divisa
                                                FROM orden as o, empresas as e
                                                WHERE o.id = $id_Orden
                                                AND e.id = o.id_proveedor;"));

        //data detalle
        $data_detalle = DB::select(DB::raw("SELECT l.id, l.descripcion, l.unidad, l.cantidad, l.precio_unitario, l.subtotal, l.id_solicitud
                                                FROM orden as o, solicitudes as s, listados as l
                                                WHERE o.id = $id_Orden
                                                AND s.id = o.id_solicitud
                                                AND l.id_solicitud = s.id"));

        //data orden
        $data_orden = DB::select(DB::raw("SELECT *
                                            FROM orden 
                                            WHERE id = $id_Orden;"));

        //data abonos
        $data_abonos = DB::select(DB::raw("SELECT *
                                            FROM orden_abierta
                                            WHERE id_orden = $id_Orden;"));

        //data proyecto
        $data_proyecto = DB::select(DB::raw("SELECT p.id, p.nombre_proyecto, p.zona_proyecto, p.logo_proyecto, p.estado_proyecto, p.factura_a, p.factura_numero
                                                FROM proyectos as p, orden as o
                                                WHERE p.id = o.id_proyecto
                                                AND o.id = $id_Orden;"));

        $data_abonoMaximo = DB::select(DB::raw("SELECT o.id_orden, o.no_orden, o.fecha, o.abono, o.debe, o.haber, o.saldo
                                                    FROM orden_abierta as o
                                                    WHERE o.id_orden = $id_Orden
                                                    AND abono = (SELECT MAX(abono) as abono
                                                                FROM orden_abierta 
                                                                WHERE id_orden = $id_Orden);"));

        return view('homeOrdenAbierta')->with('encabezado',$data_solicitud)
                                        ->with('proveedor',$data_proveedor)
                                        ->with('detalle',$data_detalle)
                                        ->with('orden',$data_orden)
                                        ->with('abonos',$data_abonos)
                                        ->with('queryProyecto',$data_proyecto)
                                        ->with('abonoMaximo',$data_abonoMaximo);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Orden Abierta Especifica');
            return view('ErrorCatch');  
        }
    }

    public function hacerAbono(Request $request){
        try{
        //OBTENCION DE DATOS
        $val_id_proveedor = $request->id_emp;
        $val_tipo_pago = $request->tipo_pago;
        $str_tipo_pago="NaN";
        if($val_tipo_pago == 1){
            $str_tipo_pago = "Transferencia";
        }else if($val_tipo_pago == 2){
            $str_tipo_pago = "Cheque";
        }
        $val_id_solicitud = $request->txt_id_solicitud;
        $val_id_orden = $request->txt_id_orden;
        //$val_ids = $request->txt_ids;
        //$val_precios_unitarios = $request->txt_precios_unitarios;
        //$val_subtotales = $request->txt_subtotales;
        $val_total = $request->txt_total_show;
        $val_Abono = $request->txt_abono;
        $val_enviar_a = $request->txt_enviara;
        $val_id_proyecto = $request->id_proyecto;
        $val_correos = $request->correos;
        $val_tasa = $request->txt_tasa;
        date_default_timezone_set('America/Guatemala');
        $fecha = date('d/m/y');

        
        
        
        

        $orden = orden::findOrFail($val_id_orden);
        $proveedor = empresa::findOrFail($val_id_proveedor);
        $solicitud = solicitude::findOrFail($val_id_solicitud);
        $proyecto = proyecto::findOrFail($val_id_proyecto);

        //Agregar ABONO
        $abono_Maximo = DB::select(DB::raw("SELECT o.id_orden, o.no_orden, o.fecha, o.abono, o.debe, o.haber, o.saldo
                                                FROM orden_abierta as o
                                                WHERE o.id_orden = $orden->id
                                                AND o.no_orden = $orden->no_orden
                                                AND abono = (SELECT MAX(abono) as abono
                                                                FROM orden_abierta 
                                                                WHERE id_orden = $orden->id);"));
        //direccion del PDF
        $name = '.pdf';
        $path = '.pdf';
        $data_Orden_Abierta = "";
        $no_orden = "";
        foreach($abono_Maximo as $a){
            $no_orden = $a->no_orden;
            $nuevoAbono = $a->abono + 1;
            $nuevoSaldo = $a->saldo - $val_Abono;
            $name = 'orderfile'.$a->id_orden.'Abono'.$nuevoAbono.'.pdf';
            $path = 'PDF/'.$name;
            $Insertar_Abono = DB::insert("INSERT INTO orden_abierta (id_orden,no_orden,fecha,abono,debe,haber,saldo,pdf,enviado,respuesta_conta)
                                                    VALUES ($a->id_orden,'$a->no_orden', '$fecha',$nuevoAbono,'-','$val_Abono','$nuevoSaldo','$path','0','0')");

            //data Orden Abierta
            $data_Orden_Abierta = DB::table('orden_abierta')->where('id_orden', $a->id_orden)
                                                            ->where('no_orden',$a->no_orden)
                                                            ->get();
        }

        //Datos proveedor
        $data_proveedor = DB::table('empresas')->where('id', $val_id_proveedor)->first();
        //Detalle de Factura
        $data_factura = DB::table('listados')->where('id_solicitud', $val_id_solicitud)->get();
        //Datos Proyecto
        $data_proyecto = DB::table('proyectos')->where('id', $val_id_proyecto)->first();
               
        $data = ['proveedor' => $data_proveedor,
                'tipo_pago' => $str_tipo_pago,
                'fecha' => $fecha,
                'detalle' => $data_factura,
                'proyecto' => $data_proyecto,
                'enviar_a' => $val_enviar_a,
                'total' => $val_total,
                'orden_abierta' => $data_Orden_Abierta,
                'no_orden'=>$no_orden];

        $pdf = PDF::loadView('myPDFabierta', $data);
        file_put_contents($path, $pdf->output()); 
        // aumentar lo que va pagado de la orden
        $pagado = floatval($orden->pagado) + floatval($val_Abono);
        $abonito = floatval($orden->abono) + 1;
        $orden->pagado = $pagado;
        $orden->abono = $abonito;
        $orden->respuesta_conta = '-1';
        $orden->pdf = $path;
        $orden->save();

        //DEBO BLOQUEAR BOTON DE HACER ABONOS
        

        $salida = '1';
        return view('guardarPDF')->with('path',$path)
                                    ->with('salida',$salida);
         }catch (Exception $e) { 
             Session::flash('catch_error','Hacer Abono');
             return view('ErrorCatch');  
         }

    }

    public function reenviarSolicitudRechazada($id){
        try{
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            $solicitud = orden::findOrFail($id);
            $solicitud->respuesta_conta='1';
            $solicitud->save();

            $solicitudes2 = DB::table('orden')
                                ->where('respuesta_conta','3')
                                ->count();
            Session::put('countOrdenesRechazadas',$solicitudes2);
            Session::flash('messageOrdenReenviada','Orden Reenviada A Contabilidad Sin Cambios');

            return redirect('/homeCompras');
        }catch (Exception $e) { 
            Session::flash('catch_error','Aceptar Solicitud Rechazada');
            return view('ErrorCatch');  
        }
    }



    public function mostrarOrdenesAbiertasDirector(){
        try{
            

            //RESTRINGIR TAMBIEN LAS SOLICITUDES POR SU PROYECTO
            $iduser = Auth::user()->id;
            $ordenes = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto, oa.fecha, oa.haber, oa.id_orden, oa.abono, pa.id as idpar, pa.nombre as nombrepar, o.no_orden
                        FROM orden_abierta as oa, orden as o, solicitudes as s, empresas as e, proyectos as p, usuario_proyecto as up, partidas as pa

                        WHERE oa.respuesta_conta = '0'
                        AND oa.abono != '1'

                        AND up.id_usuario = $iduser
                        AND p.id = up.id_proyecto
                        AND s.id_partida = pa.id
                        AND o.id = oa.id_orden
                        AND s.id = o.id_solicitud
                        AND e.id = o.id_proveedor
                        AND p.id = o.id_proyecto;"));



            
        
            return view('VistaOrdenesAbiertasDirector')->with('ordenes',$ordenes);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Ordenes Director');
            return view('ErrorCatch');  
        }
    }

    public function mostrarPDFAbiertaDirector($idOrden, $abono){
        try{
        $orden = DB::select(DB::raw("SELECT *
                                    FROM orden
                                    WHERE id = '$idOrden';"));

        $ordenA = DB::select(DB::raw("SELECT *
                                    FROM orden_abierta
                                    WHERE id_orden = '$idOrden'
                                    AND abono = '$abono';"));

        Session::put('pdf_idOrden',$idOrden);

        foreach ($orden as $or) {

            foreach ($ordenA as $orA) {
                Session::put('pdf_enviar',$orA->pdf);
                Session::put('abono',$orA->abono);
                Storage::disk('local')->put('OrdenCompra.pdf', \File::get($orA->pdf));
            }
            
            Session::put('pdf_correos',$or->correos);

            $solicitud = DB::select(DB::raw("SELECT *
                                    FROM solicitudes
                                    WHERE id = '$or->id_solicitud';"));
            foreach ($solicitud as $sol) {
                if($sol->presupuesto!=NULL){
                    Session::put('pdf_presupuesto',$sol->presupuesto);
                    Storage::disk('local')->put('Presupuesto.pdf', \File::get($sol->presupuesto));
                }else{
                    Session::put('pdf_presupuesto','PDF/orderfile1.pdf');
                    Storage::disk('local')->put('Presupuesto.pdf', \File::get("PDF/orderfile1.pdf"));
                }          
            }


            $proyecto = DB::select(DB::raw("SELECT *
                                    FROM proyectos
                                    WHERE id = '$or->id_proyecto';"));
            foreach ($proyecto as $proy) {
                Session::put('pdf_proyecto',$proy->nombre_proyecto);        
            }

            $provedor = DB::select(DB::raw("SELECT *
                                    FROM empresas
                                    WHERE id = '$or->id_proveedor';"));
            foreach ($provedor as $prov) {
                Session::put('pdf_provedor',$prov->nombre_encargado);        
            }

        }
        
        //seteamos en el local el archivo de presupuesto

        
        
                                    
        return view('verPDFAbiertaDirector')->with('orden',$ordenA);


        }catch (Exception $ex) { 
            Session::flash('catch_error','Mostrar PDF Director');
            return view('ErrorCatch')->with('exception',$ex->getMessage());  
        }
    }

    public function enviarAbierta()
    {
        try{
            $destinos=Session::get('pdf_correos');
            $idOrden=Session::get('pdf_idOrden');
            $abono=Session::get('abono');
            $proyectoNombre=Session::get('pdf_proyecto');
            $provedorNombre=Session::get('pdf_provedor');
    
            $valoresR1=str_replace(' ', '', $destinos);
            $valoresR2=str_replace('\n', '', $valoresR1);
            $valoresR3=str_replace('\r', '', $valoresR2);
    
            $valores = $valoresR3; 
            $valor = explode(',',$valores);

        foreach($valor as $llave => $valorsito) 
        {
            //PDF/pres27OrdenDePagooopooo.pdf
            $nombre="OrdenCompra.pdf";
            $pathToFile= storage_path('app') ."/". $nombre;
            $nombre2="Presupuesto.pdf";
            $pathToFile2= storage_path('app') ."/". $nombre2;
            $containfile=true;
            $destinatario2="re4lawliet@gmail.com";
            $asunto="Orden de Compra De: ".$proyectoNombre;
            $contenido="Orden de Compra De: ".$proyectoNombre;

    
            $data = array('contenido' => $contenido, 'nombre' => $provedorNombre);
            $r= Mail::send('correo.plantilla_correo', $data, function ($message) use ($asunto,$valorsito,  $containfile,$pathToFile,$pathToFile2, $proyectoNombre) {
                $titulo="Sur Desarrollos: Orden de Compra: ".$proyectoNombre;
                $message->from('_mainaccount@sistema.sursur.net', $titulo);
                $message->to($valorsito)->subject($asunto);
                if($containfile){
                $message->attach($pathToFile);
                $message->attach($pathToFile2);
                }

            });      
        }
        //2 rechazada por conta
        //ahora tengo que colocar 3 por que fue enviada

        //update ORDEN Abierta
        $insertarPDF = DB::update("UPDATE orden_abierta
                                                    SET respuesta_conta ='1'
                                                    WHERE id_orden = $idOrden
                                                    AND abono = $abono;");

         //Luego de Agregar Abono Actualizamos el PDF de la orden y cambiamos a respuesta conta 1
        $insertarPDF2 = DB::update("UPDATE orden
        SET respuesta_conta ='1'
        WHERE id = $idOrden;");

        $ord = DB::select(DB::raw("SELECT pdf FROM orden_abierta WHERE id_orden = $idOrden AND abono = $abono;"));   

        foreach ($ord as $or) {
            $insertarPDF3 = DB::update("UPDATE orden
            SET pdf = '$or->pdf'
            WHERE id = $idOrden;");
        }

        Session::flash('messageOrden','Abono de Orden de Compra Aprobada Se Enviaron Los Correos a Proveedor y a Contabilidad');


        return redirect('/homeDirector');
        }catch (Exception $e) { 
            Session::flash('catch_error','Envio de Orden De Compra Error En correos o Datos' . $e);
            return view('ErrorCatch');  
        }
    }

    public function mostrarSolicitudesManagerAprobadas(){
        try{
            $nsolicitudes = solicitude::where('aprobado_manager','1')
                                        ->count();
            Session::put('countSolicitudesManagerAprobadas',$nsolicitudes);

            $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor, s.fecha_solicitud
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                                WHERE s.respondido_manager = '1' AND s.id_proyecto = p.id AND s.id_partida = pa.id
                                                AND s.aprobado_manager = '1';"));                             
        
            return view('VistaPedidosManagerAprobadas', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes Manager');
            return view('ErrorCatch');  
        }
    }

    public function mostrarSolicitudesManagerRechazadas(){
        try{
            $nsolicitudes = solicitude::where('aprobado_manager','0')
                                        ->count();
            Session::put('countSolicitudesManagerRechazadas',$nsolicitudes);

            $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor, s.fecha_solicitud
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                                WHERE s.respondido_manager = '1' AND s.id_proyecto = p.id AND s.id_partida = pa.id
                                                AND s.aprobado_manager = '0';"));                             
        
            return view('VistaPedidosManagerRechazadas', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes Manager');
            return view('ErrorCatch');  
        }
    }


    public function mostrarSolicitudesContadorFinalizadas(){
        try{
            $solicitudes2 = DB::table('orden')
                                ->where('respuesta_conta','2')
                                ->count();
            Session::put('countSolicitudesContaFinalizadas',$solicitudes2);

            $solicitudes = DB::select(DB::raw("SELECT DISTINCT ord.id, ord.fecha_creacion, s.titulo_solicitud, pro.nombre_empresa, p.nombre_proyecto, ord.id_solicitud, ord.id_proveedor,ord.id_proyecto, ord.no_orden, s.id_partida, pa.nombre 
                                                FROM solicitudes AS s, proyectos AS p, partidas AS pa, orden AS ord, empresas AS pro 
                                                WHERE ord.id_solicitud = s.id 
                                                AND ord.id_proveedor = pro.id 
                                                AND ord.id_proyecto = p.id 
                                                AND ord.respuesta_conta = '2'
                                                AND pa.id=s.id_partida
                                                ;
                                                "));                             
        
            return view('VistaPedidosContadorFinalizadas', [ 'querySolicitudes' => $solicitudes ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Solicitudes al Contador Finalizadas');
            return view('ErrorCatch');  
        }
    }



    public function ingresoFacturaOrdenes(){

        //mostrar todos los proveedores
        $ordenes = DB::select("SELECT o.id, o.id_proveedor, o.id_proyecto, o.no_orden, o.pdf, e.nombre_empresa, o.fecha_creacion, s.titulo_solicitud, p.nombre_proyecto
                                FROM orden o, empresas e, solicitudes s, proyectos p
                                WHERE e.id = o.id_proveedor
                                AND o.id_solicitud = s.id
                                AND o.id_proyecto = p.id;");

        return view('ingresoFacturaOrden')->with('querySolicitudes' , $ordenes);
    
    }





    public function ingresoFactura($ido){
        $ordenes = DB::select("SELECT o.id, o.id_proveedor, o.id_proyecto, o.no_orden, o.pdf, e.nombre_empresa, o.fecha_creacion, s.titulo_solicitud, p.nombre_proyecto
                                FROM orden o, empresas e, solicitudes s, proyectos p
                                WHERE o.id = $ido
                                AND e.id = o.id_proveedor
                                AND o.id_solicitud = s.id
                                AND o.id_proyecto = p.id;");
        //mostrar todos los proveedores

        //historial facturas
        $facturas = DB::select("SELECT *
                                FROM log_factura
                                WHERE orden = $ido;");

        return view('ingresoFactura')->with('queryOrden', $ordenes)
                                        ->with('queryFacturas',$facturas);
    
    }


    public function AgregarFactura(Request $request){
        $serie = $request->serie;
        $n_fact = $request->n_fact;
        $fecha = $request->fecha;
        $monto = $request->monto;
        $descripcion = $request->descripcion;
        $id_orden = $request->id_orden;
        $id_proveedor = $request->id_proveedor;


        $busqueda = DB::select("SELECT *
                                FROM log_factura
                                WHERE orden = $id_orden
                                AND no_factura = $n_fact;");

        $existe = false;
        foreach($busqueda as $encontrada){
            if($encontrada->orden = $id_orden && $encontrada->no_factura = $n_fact){
                $existe=true;
            }
        }

        if($existe == false){
            DB::insert("INSERT INTO log_factura(id_proveedor,orden,serie,no_factura,fecha,monto,descripcion) 
                        VALUES($id_proveedor,$id_orden,'$serie','$n_fact','$fecha','$monto','$descripcion')");
            Session::flash('facturaAgregada','La factura ha sido agregada al sistema');
            return redirect('ingresoFactura/'.$id_orden);
        }else{
            Session::flash('catch_error','Esta factura ya ha sido ingresada');
            return view('ErrorCatch');  
        }
        
    }



    public function rechazarSolicitudCompras($id){
        try{
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            $solicitud = solicitude::findOrFail($id);
            $solicitud->respondido_director='1';
            $solicitud->aprobado_director='0';
            $solicitud->fecha_director = $fecha;
            $solicitud->save();

            //$nsolicitudes = solicitude::where('respondido_manager','1')
            //                            ->where('aprobado_manager','1')
            //                            ->where('respondido_director','0')
            //                            ->count();
            //Session::put('countSolicitudesDirector',$nsolicitudes);

            return redirect('MostrarSolicitudesCompras');
        }catch (Exception $e) { 
            Session::flash('catch_error','Rechazar Solicitud Compras');
            return view('ErrorCatch');  
        }
    }

    
    public function rechazarOrdenDirector(Request $request,$id){

        
        

            $validator = Validator::make($request->all(), [
                'comentario' => 'required|max:2000',   
            ]);
        
            if ($validator->fails()) {
                return redirect('MostrarOrdenesDirector')
                    ->withInput()
                    ->withErrors($validator);
            }
            
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');
            $solicitud = orden::findOrFail($id);
            $solicitud->respuesta_conta='3';
            $solicitud->comentario_conta=$request->comentario;
            $solicitud->fecha_contador = $fecha;
            $solicitud->save();
    
            //jalo la solicitud y le pondre 3 que es rechazada por conta
            $solicitud3 = solicitude::findOrFail($solicitud->id_solicitud);
            $solicitud3->orden_creada='2';
            $solicitud3->save();
    
            //$solicitudes2 = DB::table('orden')
            //                    ->where('respuesta_conta','1')
            //                    ->count();
            //Session::put('countSolicitudesConta',$solicitudes2);
    
        

        return redirect('MostrarOrdenesDirector');
        
    }

    public function mostrarOrdenAbiertaRehacer($id_Orden){
        try{

        $idOrden=Session::get('r_id');
        $sol = orden::findOrFail($idOrden);
        
        //restar el ultimo Abono Realizado en Orden Normal
        $numeroAbonos=(int)$sol->abono;
        $numeroAbonosRestantes=$numeroAbonos - 1;

        //Obteniendo Penultimo Abono
        $data_PenultimoAbono = DB::select(DB::raw("SELECT *
                                                FROM orden_abierta
                                                WHERE id_orden=$idOrden AND abono=$numeroAbonosRestantes;"));
        //Obteniendo Ultimo Abono
        $data_UltimoAbono = DB::select(DB::raw("SELECT *
                                                FROM orden_abierta
                                                WHERE id_orden=$idOrden AND abono=$numeroAbonos;"));
        

        //Restarle a lo Pagado de Orden Normal lo del Ultimo Abono
        $pagadoAnterior=(float)$sol->pagado;
        $restaAPagado=0;
        foreach ($data_UltimoAbono as $dultimo) {
            $restaAPagado=(float)$dultimo->haber;
        }
        //se resta lo pagado total - el ultimo abono
        $pagadoNuevo=$pagadoAnterior - $restaAPagado;

        //ahora Jalamos el PDF del Penultimo Abono
        $pdfPenultimoAbono="pdfPenultimo";
        foreach ($data_UltimoAbono as $dultimo) {
            $pdfPenultimoAbono=$dultimo->pdf;
        }

        //Actualizamos los datos de la Tabla de Orden Normal
        // campos: pagado,pdf,abono eliminando el ultimo Abono

        $ActualizandoPagado = DB::update("UPDATE orden
                                                    SET pagado = '$pagadoNuevo',
                                                    pdf = '$pdfPenultimoAbono',
                                                    abono = '$numeroAbonosRestantes'
                                                    WHERE id = $idOrden;");

        //eliminar el Ultimo Abono
        $deleteUltimoAbono = DB::delete("DELETE FROM orden_abierta WHERE id_orden=$idOrden AND abono=$numeroAbonos;");

        //obteniendo datos de solicitud para titulo
        $data_solicitud = DB::select(DB::raw("SELECT s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.id as id_proyecto, p.nombre_proyecto
                                                FROM solicitudes as s, orden as o, proyectos as p, partidas as pa
                                                WHERE o.id = $id_Orden
                                                AND s.id = o.id_solicitud
                                                AND p.id = o.id_proyecto
                                                AND pa.id = s.id_partida;"));

        //data de Proveedor
        $data_proveedor = DB::select(DB::raw("SELECT e.id as id_proveedor , e.nombre_empresa, e.nit_empresa, e.direccion_empresa, e.nombre_banco, e.tipo_cuenta,e.no_cuenta, e.divisa
                                                FROM orden as o, empresas as e
                                                WHERE o.id = $id_Orden
                                                AND e.id = o.id_proveedor;"));

        //data detalle
        $data_detalle = DB::select(DB::raw("SELECT l.id, l.descripcion, l.unidad, l.cantidad, l.precio_unitario, l.subtotal, l.id_solicitud
                                                FROM orden as o, solicitudes as s, listados as l
                                                WHERE o.id = $id_Orden
                                                AND s.id = o.id_solicitud
                                                AND l.id_solicitud = s.id"));

        //data orden
        $data_orden = DB::select(DB::raw("SELECT *
                                            FROM orden 
                                            WHERE id = $id_Orden;"));

        //data abonos
        $data_abonos = DB::select(DB::raw("SELECT *
                                            FROM orden_abierta
                                            WHERE id_orden = $id_Orden;"));

        //data proyecto
        $data_proyecto = DB::select(DB::raw("SELECT p.id, p.nombre_proyecto, p.zona_proyecto, p.logo_proyecto, p.estado_proyecto, p.factura_a, p.factura_numero
                                                FROM proyectos as p, orden as o
                                                WHERE p.id = o.id_proyecto
                                                AND o.id = $id_Orden;"));

        $data_abonoMaximo = DB::select(DB::raw("SELECT o.id_orden, o.no_orden, o.fecha, o.abono, o.debe, o.haber, o.saldo
                                                    FROM orden_abierta as o
                                                    WHERE o.id_orden = $id_Orden
                                                    AND abono = (SELECT MAX(abono) as abono
                                                                FROM orden_abierta 
                                                                WHERE id_orden = $id_Orden);"));

        return view('homeOrdenAbiertaRehacer')->with('encabezado',$data_solicitud)
                                        ->with('proveedor',$data_proveedor)
                                        ->with('detalle',$data_detalle)
                                        ->with('orden',$data_orden)
                                        ->with('abonos',$data_abonos)
                                        ->with('queryProyecto',$data_proyecto)
                                        ->with('abonoMaximo',$data_abonoMaximo);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Orden Abierta Especifica Rehacer ultimo');
            return view('ErrorCatch');  
        }
    }



    public function verSolicitud($id_Solicitud){
        try{
            $solicitudes = solicitude::where('mostrar','1')
                                        ->where('email',Auth::user()->email)
                                        ->count();
            Session::put('countSolicitudesColaborador',$solicitudes);

            $solicitud = DB::select("SELECT s.id, s.titulo_solicitud, s.id_partida, s.id_proyecto, s.proveedor, s.presupuesto, p.nombre, pr.nombre_proyecto
                                        FROM solicitudes as s, partidas as p, proyectos as pr
                                        WHERE s.id = $id_Solicitud
                                        AND p.id = s.id_partida
                                        AND pr.id = s.id_proyecto;");

            $listado = DB::select("SELECT cantidad, unidad, descripcion
                                    FROM listados
                                    WHERE id_solicitud = $id_Solicitud");

            $orden = DB::select("SELECT *
                                        FROM orden
                                        WHERE id_solicitud = $id_Solicitud");

            return view('VerSolicitud')->with('querySolicitud',$solicitud)
                                                ->with('queryListado',$listado)
                                                ->with('queryOrden',$orden);
        }catch (Exception $e) { 
            Session::flash('catch_error','Dejar Solicitud');
            return view('ErrorCatch');  
        }
    }



}






?>