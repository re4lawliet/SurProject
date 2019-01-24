<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SUR\solicitude;
use SUR\proyecto;
use SUR\orden;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class ControladorVistaPedidos extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('colaborador');
    }

    public function mostrarSolicitudesManager(){
        $nsolicitudes = solicitude::where('respondido_manager','0')
                                    ->count();
        Session::put('countSolicitudesManager',$nsolicitudes);

        $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                            WHERE s.respondido_manager = '0' AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
    
        return view('VistaPedidosManager', [ 'querySolicitudes' => $solicitudes ]);
    }

    public function responderSolicitudManager(){
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
    }

    





    public function mostrarSolicitudesDirector(){
        $nsolicitudes = solicitude::where('respondido_manager','1')
                                    ->where('aprobado_manager','1')
                                    ->where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudesDirector',$nsolicitudes);

        $solicitudes = DB::select(DB::raw("SELECT s.id, s.titulo_solicitud, s.id_partida, pa.nombre, s.rol, p.nombre_proyecto, s.proveedor
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                            WHERE s.respondido_manager = '1' 
                                            AND s.aprobado_manager = '1'
                                            AND s.respondido_director = '0'
                                            AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
    
        return view('VistaPedidosDirector', [ 'querySolicitudes' => $solicitudes ]);
    }

    public function aceptarSolicitudDirector($id){
        
        date_default_timezone_set('America/Guatemala');
        $fecha = date('d/m/y');
        $solicitud = solicitude::findOrFail($id);
        $solicitud->respondido_director='1';
        $solicitud->aprobado_director='1';
        $solicitud->fecha_director = $fecha;
        $solicitud->save();

        $nsolicitudes = solicitude::where('respondido_manager','1')
                                    ->where('aprobado_manager','1')
                                    ->where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudesDirector',$nsolicitudes);
        return redirect('MostrarSolicitudesDirector');
    }

    public function rechazarSolicitudDirector($id){
        
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
    }





    public function mostrarSolicitudesColaborador(){
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
    }

    public function dejarSolicitud($id){
        $solicitudes = solicitude::where('mostrar','1')
                                    ->where('email',Auth::user()->email)
                                    ->count();
        Session::put('countSolicitudesColaborador',$solicitudes);

        $solicitud = solicitude::findOrFail($id);
        $solicitud->mostrar='0';
        $solicitud->save();
        return redirect('MostrarSolicitudesColaborador');
    }






    public function mostrarSolicitudesCompras(){
        $solicitudes = solicitude::where('aprobado_manager','1')
                                    ->where('aprobado_director','1')
                                    ->where('orden_creada','0')
                                    ->count();
        Session::put('countSolicitudesCompras',$solicitudes);

        $email = Auth::user()->email;

        $solicitudes = DB::select(DB::raw("SELECT s.id as id, s.titulo_solicitud, s.id_partida, s.rol, pa.nombre, p.nombre_proyecto, s.proveedor, p.id as id_proyecto, pa.id as id_partida
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa
                                            WHERE aprobado_manager = '1' 
                                            AND aprobado_director = '1'
                                            AND s.orden_creada = '0'
                                            AND s.id_proyecto = p.id AND s.id_partida = pa.id;"));                             
    
        return view('VistaPedidosCompras', [ 'querySolicitudes' => $solicitudes ]);
    }


    public function mostrarSolicitudesContador(){
        $solicitudes2 = DB::table('orden')
                            ->where('respuesta_conta','1')
                            ->count();
        Session::put('countSolicitudesConta',$solicitudes2);

        $solicitudes = DB::select(DB::raw("SELECT DISTINCT ord.id, ord.fecha_creacion, s.titulo_solicitud, pro.nombre_empresa, p.nombre_proyecto, ord.id_solicitud, ord.id_proveedor,ord.id_proyecto 
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa, orden AS ord, empresas AS pro 
                                            WHERE ord.id_solicitud = s.id 
                                            AND ord.id_proveedor = pro.id 
                                            AND ord.id_proyecto = p.id 
                                            AND ord.respuesta_conta = '1';
                                            "));                             
    
        return view('VistaPedidosContador', [ 'querySolicitudes' => $solicitudes ]);
    }

    
    public function aceptarSolicitudContador(Request $request,$id){

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

        //jalo la solicitud y le pondre 3 que es aceptada final
        $solicitud3 = solicitude::findOrFail($solicitud->id_solicitud);
        $solicitud3->orden_creada='3';
        $solicitud3->save();

        $solicitudes2 = DB::table('orden')
                            ->where('respuesta_conta','1')
                            ->count();
        Session::put('countSolicitudesConta',$solicitudes2);

        return redirect('MostrarSolicitudesContador');
    }

    public function rechazarSolicitudContador(Request $request,$id){


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
    
            //jalo la solicitud y le pondre 2 que es rechazada por conta
            $solicitud3 = solicitude::findOrFail($solicitud->id_solicitud);
            $solicitud3->orden_creada='2';
            $solicitud3->save();
    
            $solicitudes2 = DB::table('orden')
                                ->where('respuesta_conta','1')
                                ->count();
            Session::put('countSolicitudesConta',$solicitudes2);
    
        }

        return redirect('MostrarSolicitudesContador');
    }

    public function mostrarSolicitudesRechazadas(){
        $solicitudes2 = DB::table('orden')
                            ->where('respuesta_conta','3')
                            ->count();
        Session::put('countOrdenesRechazadas',$solicitudes2);

        $solicitudes = DB::select(DB::raw("SELECT DISTINCT ord.id, ord.fecha_creacion, s.titulo_solicitud, pro.nombre_empresa, p.nombre_proyecto, ord.id_solicitud, ord.id_proveedor,ord.id_proyecto, ord.comentario_conta, ord.fecha_contador
                                            FROM solicitudes AS s, proyectos AS p, partidas AS pa, orden AS ord, empresas AS pro 
                                            WHERE ord.id_solicitud = s.id 
                                            AND ord.id_proveedor = pro.id 
                                            AND ord.id_proyecto = p.id 
                                            AND ord.respuesta_conta = '3';
                                            "));                             
    
        return view('VistaPedidosOrdenesRechazadas', [ 'querySolicitudes' => $solicitudes ]);
    }


    public function aceptarSolicitudRechazada($id){
        
        date_default_timezone_set('America/Guatemala');
        $fecha = date('d/m/y');
        $solicitud = orden::findOrFail($id);
        $solicitud->respuesta_conta='4';
        $solicitud->save();

        $solicitudes2 = DB::table('orden')
                            ->where('respuesta_conta','3')
                            ->count();
        Session::put('countOrdenesRechazadas',$solicitudes2);

        return redirect('MostrarSolicitudesRechazadas');
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
    $countorden = DB::table('orden')->where('respuesta_conta', '0')->count();
    Session::put('countOrdenesAprobadas',$countorden); 
        $ordenes = DB::select(DB::raw("SELECT o.id, o.fecha_creacion, o.fecha_contador, s.titulo_solicitud, e.nombre_empresa, p.nombre_proyecto
                                        FROM orden as o, solicitudes as s, empresas as e, proyectos as p
                                        WHERE respuesta_conta = '0'
                                        AND s.id = o.id_solicitud
                                        AND e.id = o.id_proveedor
                                        AND p.id = o.id_proyecto;"));                             
    
        return view('VistaOrdenesDirector')->with('ordenes',$ordenes);
    }

    public function mostrarPDFDirector($idOrden){
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
    }

    public function enviar()
    {
        $destinos=Session::get('pdf_correos');
        $idOrden=Session::get('pdf_idOrden');
        $proyectoNombre=Session::get('pdf_proyecto');
        $provedorNombre=Session::get('pdf_provedor');

        $valores = $destinos; 
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
                $message->from('sur.app.correos@gmail.com', $titulo);
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

        Session::flash('messageOrden','Orden de Compra Aprobada Se Enviaron Los Correos a Proveedor y a Contabilidad');


        return redirect('/homeDirector');
    }









    

}

?>