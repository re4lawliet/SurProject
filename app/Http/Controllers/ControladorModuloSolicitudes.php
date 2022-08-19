<?php

namespace SUR\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use SUR\solicitude;
use SUR\listado;
use SUR\proyecto;
use SUR\empresa;
use SUR\orden;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Session;
Use Exception;

class ControladorModuloSolicitudes extends Controller
{
    public function verSolicitud($id, $npa, $npr){
        try{
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

            $solicitudes = DB::select(DB::raw("SELECT *
                                                FROM listados
                                                WHERE id_solicitud = $id;"));

            $sol = DB::select("SELECT * 
                                FROM solicitudes
                                WHERE id = $id");
            return view('homeSolicitudManager')->with('queryListado', $solicitudes)
                                                ->with('solicitudes', $sol);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud');
            return view('ErrorCatch');  
        }
    }

    

    public function verSolicitudDirector($id, $npa, $npr){
        try{
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

            $listad = DB::select(DB::raw("SELECT *
                                                FROM listados
                                                WHERE id_solicitud = $id;"));

            $solicitud = DB::select(DB::raw("SELECT *
                                                FROM solicitudes
                                                WHERE id = $id;"));
            return view('homeSolicitudDirector')
                                                ->with('queryListado', $listad)
                                                ->with('querySolicitud',$solicitud);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Director');
            return view('ErrorCatch');  
        }
    }

    public function verSolicitudDirectorSB($id, $npa, $npr){
        try{
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

            $listad = DB::select(DB::raw("SELECT *
                                                FROM listados
                                                WHERE id_solicitud = $id;"));

            $solicitud = DB::select(DB::raw("SELECT *
                                                FROM solicitudes
                                                WHERE id = $id;"));
            return view('homeSolicitudDirectorSinBoton')
                                                ->with('queryListado', $listad)
                                                ->with('querySolicitud',$solicitud);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Director');
            return view('ErrorCatch');  
        }
    }

    public function verPresupuesto(Request $request){
        $pdf = $request->txt_pdf;
        return view('/presupuestoDirector')->with('pdf',$pdf);
    }

    public function verPresupuesto2($pdf){
        return view('/presupuestoDirector')->with('pdf',$pdf);
    }


    public function verSolicitudCompras($id_solicitud, $id_partida, $id_proyecto){
        try{
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
            
            //lista de productos solicitados
            $lista_Solicitud = DB::select(DB::raw("SELECT *
                                                FROM listados
                                                WHERE id_solicitud = $id_solicitud;"));

            //solicitud
            $solicitud = DB::select(DB::raw("SELECT *
                                                FROM solicitudes
                                                WHERE id = $id_solicitud;"));
            
            $emp = DB::select(DB::raw("SELECT * FROM empresas;"));

            $prove = DB::select(DB::raw("SELECT * 
                                            FROM empresas
                                            WHERE id = 'inexistente';"));

            return view('homeOrdenSolicitud')
                                                ->with('queryListado',$lista_Solicitud)
                                                ->with('partidas',$partida)
                                                ->with('queryEmpresas' , $emp)
                                                ->with('queryProveedores',$prove)
                                                ->with('queryProyecto',$proyecto)
                                                ->with('querySolicitud',$solicitud);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Compras');
            return view('ErrorCatch');  
        }
    }

    
    public function verSolicitudComprasProv($id_solicitud, $id_partida, $id_proyecto, $id_proveedor){
        try{
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
            //lista de productos solicitados
            $lista_Solicitud = DB::select(DB::raw("SELECT *
                                                FROM listados
                                                WHERE id_solicitud = $id_solicitud;"));

            //solicitud
            $solicitud = DB::select(DB::raw("SELECT *
                                                FROM solicitudes
                                                WHERE id = $id_solicitud;"));
            
            $emp = DB::select(DB::raw("SELECT * FROM empresas;"));

            $prove = DB::select(DB::raw("SELECT * 
                                            FROM empresas 
                                            WHERE id = $id_proveedor;"));

            return view('homeOrdenSolicitud')
                                            ->with('queryListado',$lista_Solicitud)
                                            ->with('partidas',$partida)
                                            ->with('queryEmpresas' , $emp)
                                            ->with('queryProveedores',$prove)
                                            ->with('queryProyecto',$proyecto)
                                            ->with('querySolicitud',$solicitud);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Compras Carga de Proveedor');
            return view('ErrorCatch');  
        }
    }

    

    public function crearOrden(Request $request){
        try{
        $validator = Validator::make($request->all(), [
            'id_emp' => 'required',
            'tipo_pago' => 'required',
            'txt_id_solicitud' => 'required',
            'txt_precios_unitarios' => 'required',
            'txt_subtotales' => 'required',
            'txt_subtotales' => 'required',
            'txt_total' => 'required',
            'txt_enviara' => 'required',
            'id_proyecto' => 'required',
            'txt_tasa' => 'required'
        ]);
    
        if ($validator->fails()) {
            return redirect('/MostrarSolicitudesCompras')
                ->withInput()
                ->withErrors($validator);
        }
        $val_ajuste = $request->txt_ajuste;
        $val_id_proveedor = $request->id_emp;
        $val_tipo_pago = $request->tipo_pago;
        $str_tipo_pago="NaN";
        if($val_tipo_pago == 1){
            $str_tipo_pago = "Transferencia";
        }else if($val_tipo_pago == 2){
            $str_tipo_pago = "Cheque";
        }

        $val_id_solicitud = $request->txt_id_solicitud;

        $val_ids = $request->txt_ids;
        $val_precios_unitarios = $request->txt_precios_unitarios;
        $val_subtotales = $request->txt_subtotales;

        $val_total = $request->txt_total;
        $val_ordenAbierta = $request->txt_primerpago;
        $val_enviar_a = $request->txt_enviara;
        $val_id_proyecto = $request->id_proyecto;
        $val_correos = $request->correos;

        $val_tasa = $request->txt_tasa;
        
        date_default_timezone_set('America/Guatemala');
        $fecha = date('d/m/y');


        //Insertar en Orden
        if($val_ordenAbierta==""){
            $insertarOrden = DB::insert("INSERT INTO orden (id_proveedor,tipo_pago,id_solicitud,tasa_cambio,total,ajuste,pagado,abierta,id_proyecto,correos,enviado,respuesta_conta,comentario_conta,fecha_creacion, abono)
                                                VALUES($val_id_proveedor,$val_tipo_pago,$val_id_solicitud,'$val_tasa','$val_total','$val_ajuste','$val_total','0',$val_id_proyecto,'$val_correos','0','0','','$fecha','0');");
        }else{
            $insertarOrden = DB::insert("INSERT INTO orden (id_proveedor,tipo_pago,id_solicitud,tasa_cambio,total,ajuste,pagado,abierta,id_proyecto,correos,enviado,respuesta_conta,comentario_conta,fecha_creacion, abono)
                                                VALUES($val_id_proveedor,$val_tipo_pago,$val_id_solicitud,'$val_tasa','$val_total','$val_ajuste','$val_ordenAbierta','1',$val_id_proyecto,'$val_correos','0','0','','$fecha','1');");
        }
        
        
        

        //Insertar precios
        $arr_ids=explode(",",$val_ids);
        $arr_precios=explode(",",$val_precios_unitarios);
        $arr_subtotales = explode(",",$val_subtotales);
        for($i =0; $i<sizeof($arr_ids);$i++){
            $insertarPrecios = DB::update("UPDATE listados
                                                    SET precio_unitario = $arr_precios[$i], subtotal = $arr_subtotales[$i]
                                                    WHERE id = $arr_ids[$i];");
        }
        //actualizar Solicitud
        $insertarSolicitud = DB::update("UPDATE solicitudes
                                                    SET orden_creada = '1'
                                                    WHERE id = $val_id_solicitud;");

        if ($_FILES['presupuesto']['name'] != null) {
            $nombrep = 'pres'.$val_id_solicitud;
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
            $insertarSolicitud2 = DB::update("UPDATE solicitudes
                                                    SET presupuesto = '$ruta'
                                                    WHERE id = $val_id_solicitud;");
        }

        //Datos proveedor
        $data_proveedor = DB::table('empresas')->where('id', $val_id_proveedor)->first();
        //Datos de Solicitud 
        $data_solicitud = DB::table('solicitudes')->where('id', $val_id_solicitud)->first();
        //Detalle de Factura
        $data_factura = DB::table('listados')->where('id_solicitud', $val_id_solicitud)->get();
        //Datos Proyecto
        $data_proyecto = DB::table('proyectos')->where('id', $val_id_proyecto)->first();
       
        //direccion del correo
        $maxid = DB::table('orden')->find(DB::table('orden')->max('id'));
        $name = 'orderfile'.$maxid->id.'.pdf';
        $path = 'PDF/orderfile'.$maxid->id.'.pdf';
        
        //update ORDEN
        $insertarPDF = DB::update("UPDATE orden
                                                    SET pdf ='$path'
                                                    WHERE id = $maxid->id;");

        //insertar Orden_abierta si es Abierta
        if($val_ordenAbierta!=""){
            $insertarOrden_Abierta = DB::insert("INSERT INTO orden_abierta (id_orden,fecha,abono,debe,haber,saldo,enviado,respuesta_conta)
                                                VALUES($maxid->id,'$fecha',0,'$val_total','-','$val_total','1','1');");
        }
        //insertar primer Pago si es Abierta
        if($val_ordenAbierta!=""){
            $val_saldo = floatval($val_total) - floatval($val_ordenAbierta);
            $insertarOrden_Abierta_pago = DB::insert("INSERT INTO orden_abierta (id_orden,fecha,abono,debe,haber,saldo,enviado,pdf,respuesta_conta)
                                                VALUES($maxid->id,'$fecha',1,'-','$val_ordenAbierta','$val_saldo','0','$path','0');");
        }

        //data Orden Abierta
        $data_Orden_Abierta = DB::table('orden_abierta')->where('id_orden', $maxid->id)->get();
        

        $data = ['proveedor' => $data_proveedor,
                'tipo_pago' => $str_tipo_pago,
                'fecha' => $fecha,
                'solicitud' => $data_solicitud,
                'detalle' => $data_factura,
                'proyecto' => $data_proyecto,
                'enviar_a' => $val_enviar_a,
                'total' => $val_total,
                'orden_abierta' => $data_Orden_Abierta,
                'ajuste' => $val_ajuste];
                
       
        $pdf = PDF::loadView('myPDF', $data);
        file_put_contents($path, $pdf->output()); 

        //GUARDAR CORRELATIVO DE LA ORDEN
        $proy = DB::table('proyectos')->where('id', $val_id_proyecto)->first();
        $correlativo = $proy->correlativo;
        $actualizar = DB::update("UPDATE orden
                                             SET no_orden = '$correlativo'
                                             WHERE id = $maxid->id;");
        
        //guardar no_orden en orden_abierta
        if($val_ordenAbierta!=""){
            $updateOrdenAbierta = DB::update("UPDATE orden_abierta
                                                        SET no_orden = '$correlativo'
                                                        WHERE id_orden = $maxid->id;");
        }
        //incrementar correlativo del proyecto
        
        $corr = $proy->correlativo + 1;
        $updateProyecto = DB::update("UPDATE proyectos
                                                    SET correlativo ='$corr'
                                                    WHERE id = $val_id_proyecto ;");
        $salida = '0';
        return view('guardarPDF')->with('path',$path)
                                ->with('salida',$salida);
        return $pdf->stream($name);
        }catch (Exception $e) { 
            Session::flash('catch_error','Crear Orden De Compra ' . $e);
            return view('ErrorCatch');  
        }
    }




    public function verSolicitudContador($id){
        try{
        $sol = orden::findOrFail($id);

        Session::put('c_id', $id);
        Session::put('c_idpro', $sol->id_proveedor);
        Session::put('c_idsol', $sol->id_solicitud);
        Session::put('c_idproy', $sol->id_proyecto);

        $solicitud = solicitude::findOrFail($sol->id_solicitud);
        $prove = empresa::findOrFail($sol->id_proveedor);
        $proyecto = proyecto::findOrFail($sol->id_proyecto);

        //nombre provedor
        Session::put('c_nproveedor', $prove->nombre_empresa);
        //solicitud
        Session::put('c_nsolicitud', $solicitud->titulo_solicitud);
        //proyecto
        Session::put('c_nproyecto', $proyecto->nombre_proyecto);
        //pdf orden
        Session::put('c_npdf', $sol->pdf);
        //pdf presupuesto
        $solicitudd = DB::select(DB::raw("SELECT *
                                    FROM solicitudes
                                    WHERE id = '$sol->id_solicitud';"));
        foreach ($solicitudd as $soli) {
            if($soli->presupuesto!=NULL){
                Session::put('c_npdfpresupuesto',$soli->presupuesto);
            }else{
                Session::put('c_npdfpresupuesto','PDF/orderfile1.pdf');
            }          
        }
        $provee = DB::select("SELECT * FROM empresas WHERE id = $sol->id_proveedor");
        return view('/homeSolicitudContador')->with('proveedores',$provee);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Contador');
            return view('ErrorCatch');  
        }
    }




    public function verSolicitudRechazada($id){

        try{
        $sol = orden::findOrFail($id);

        Session::put('r_id', $id);
        Session::put('r_idpro', $sol->id_proveedor);
        Session::put('r_idsol', $sol->id_solicitud);
        Session::put('r_idproy', $sol->id_proyecto);
        

        $solicitud = solicitude::findOrFail($sol->id_solicitud);
        $prove = empresa::findOrFail($sol->id_proveedor);
        $proyecto = proyecto::findOrFail($sol->id_proyecto);

        //nombre provedor
        Session::put('r_nproveedor', $prove->nombre_empresa);
        //solicitud
        Session::put('r_nsolicitud', $solicitud->titulo_solicitud);
        Session::put('r_idpart', $solicitud->id_partida);
        //proyecto
        Session::put('r_nproyecto', $proyecto->nombre_proyecto);
        //pdf
        Session::put('r_npdf', $sol->pdf);

        //fechas
        Session::put('r_fechacreacion', $sol->fecha_creacion);
        Session::put('r_fecharechazo', $sol->fecha_contador);
        //comentario
        Session::put('r_comentario', $sol->comentario_conta);
        
        //Si es ORden Abierta O No
        Session::put('r_abierta', $sol->abierta);
        $solic = DB::select(DB::raw("SELECT * 
                                        FROM orden
                                        WHERE id = $id;"));

        return view('/homeSolicitudRechazada')
                ->with('querySolicitud',$solic);

        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Rechazada');
            return view('ErrorCatch');  
        }
    }

    public function verSolicitudComprasRechazada($id_solicitud, $id_partida, $id_proyecto){
        try{
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
        
        //lista de productos solicitados
        $lista_Solicitud = DB::select(DB::raw("SELECT *
                                            FROM listados
                                            WHERE id_solicitud = $id_solicitud;"));

        //solicitud
        $solicitud = DB::select(DB::raw("SELECT *
                                            FROM solicitudes
                                            WHERE id = $id_solicitud;"));
        
        $emp = DB::select(DB::raw("SELECT * FROM empresas;"));

        $prove = DB::select(DB::raw("SELECT * 
                                        FROM empresas
                                        WHERE id = 'inexistente';"));

        return view('homeOrdenSolicitudRechazada')
                                            ->with('queryListado',$lista_Solicitud)
                                            ->with('partidas',$partida)
                                            ->with('queryEmpresas' , $emp)
                                            ->with('queryProveedores',$prove)
                                            ->with('queryProyecto',$proyecto)
                                            ->with('querySolicitud',$solicitud);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Compras Rechazada');
            return view('ErrorCatch');  
        }
    }

    
    public function verSolicitudComprasProvRechazada($id_solicitud, $id_partida, $id_proyecto, $id_proveedor){
        try{
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
        //lista de productos solicitados
        $lista_Solicitud = DB::select(DB::raw("SELECT *
                                            FROM listados
                                            WHERE id_solicitud = $id_solicitud;"));

        //solicitud
        $solicitud = DB::select(DB::raw("SELECT *
                                            FROM solicitudes
                                            WHERE id = $id_solicitud;"));
        
        $emp = DB::select(DB::raw("SELECT * FROM empresas;"));

        $prove = DB::select(DB::raw("SELECT * 
                                        FROM empresas 
                                        WHERE id = $id_proveedor;"));

        return view('homeOrdenSolicitudRechazada')
                                        ->with('queryListado',$lista_Solicitud)
                                        ->with('partidas',$partida)
                                        ->with('queryEmpresas' , $emp)
                                        ->with('queryProveedores',$prove)
                                        ->with('queryProyecto',$proyecto)
                                        ->with('querySolicitud',$solicitud);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Compras Rechazada Carga Proveedor');
            return view('ErrorCatch');  
        }
    }


    public function verSolicitudSinBoton($id, $npa, $npr){
        try{
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

            $solicitudes = DB::select(DB::raw("SELECT *
                                                FROM listados
                                                WHERE id_solicitud = $id;"));
            return view('homeSolicitudManagerSinBoton', ['queryListado' => $solicitudes]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud');
            return view('ErrorCatch');  
        }
    }


    public function crearOrdenRechazada(Request $request){

        $idOrden=Session::get('r_id');
        $sol = orden::findOrFail($idOrden);

        if($sol->abierta=='1'){
            $numeroAbonos=(int)$sol->abono;
            for($i =0; $i<=$numeroAbonos;$i++){
                $insertarOrden2 = DB::delete("DELETE FROM orden_abierta WHERE id_orden=$idOrden AND abono=$i;");
            }
        }

        orden::findOrFail($idOrden)->delete();


        try{
            $validator = Validator::make($request->all(), [
                'id_emp' => 'required',
                'tipo_pago' => 'required',
                'txt_id_solicitud' => 'required',
                'txt_precios_unitarios' => 'required',
                'txt_subtotales' => 'required',
                'txt_subtotales' => 'required',
                'txt_total' => 'required',
                'txt_enviara' => 'required',
                'id_proyecto' => 'required',
                'txt_tasa' => 'required'
            ]);
            
            if ($validator->fails()) {
                return redirect('/MostrarSolicitudesCompras')
                    ->withInput()
                    ->withErrors($validator);
            }
            $val_ajuste = $request->txt_ajuste;
            $val_id_proveedor = $request->id_emp;
            $val_tipo_pago = $request->tipo_pago;
            $str_tipo_pago="NaN";
            if($val_tipo_pago == 1){
                $str_tipo_pago = "Transferencia";
            }else if($val_tipo_pago == 2){
                $str_tipo_pago = "Cheque";
            }

            $val_id_solicitud = $request->txt_id_solicitud;
            $val_ids = $request->txt_ids;
            $val_precios_unitarios = $request->txt_precios_unitarios;
            $val_subtotales = $request->txt_subtotales;
            $val_total = $request->txt_total;
            $val_ordenAbierta = $request->txt_primerpago;
            $val_enviar_a = $request->txt_enviara;
            $val_id_proyecto = $request->id_proyecto;
            $val_correos = $request->correos;
            $val_tasa = $request->txt_tasa;
            date_default_timezone_set('America/Guatemala');
            $fecha = date('d/m/y');

            //Insertar en Orden
            if($val_ordenAbierta==""){
                $insertarOrden = DB::insert("INSERT INTO orden (id_proveedor,tipo_pago,id_solicitud,tasa_cambio,total,ajuste,pagado,abierta,id_proyecto,correos,enviado,respuesta_conta,comentario_conta,fecha_creacion, abono)
                                                    VALUES($val_id_proveedor,$val_tipo_pago,$val_id_solicitud,'$val_tasa','$val_total','$val_ajuste','$val_total','0',$val_id_proyecto,'$val_correos','0','0','','$fecha','0');");
            }else{
                $insertarOrden = DB::insert("INSERT INTO orden (id_proveedor,tipo_pago,id_solicitud,tasa_cambio,total,ajuste,pagado,abierta,id_proyecto,correos,enviado,respuesta_conta,comentario_conta,fecha_creacion, abono)
                                                    VALUES($val_id_proveedor,$val_tipo_pago,$val_id_solicitud,'$val_tasa','$val_total','$val_ajuste','$val_ordenAbierta','1',$val_id_proyecto,'$val_correos','0','0','','$fecha','1');");
            }


            //Insertar precios
            $arr_ids=explode(",",$val_ids);
            $arr_precios=explode(",",$val_precios_unitarios);
            $arr_subtotales = explode(",",$val_subtotales);
            for($i =0; $i<sizeof($arr_ids);$i++){
                $insertarPrecios = DB::update("UPDATE listados
                                                        SET precio_unitario = $arr_precios[$i], subtotal = $arr_subtotales[$i]
                                                        WHERE id = $arr_ids[$i];");
            }

            //actualizar Solicitud
            $insertarSolicitud = DB::update("UPDATE solicitudes
                                                        SET orden_creada = '1'
                                                        WHERE id = $val_id_solicitud;");


            if ($_FILES['presupuesto']['name'] != null) {
                $nombrep = 'pres'.$val_id_solicitud;
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
                // $ruta="PDF/".$nombrep.$nombreimg;
                if(strpos($ruta, '.pdf')){
                    move_uploaded_file($archivo,$ruta);
                }else{
                    $ruta="";
                }
                $insertarSolicitud2 = DB::update("UPDATE solicitudes
                                                        SET presupuesto = '$ruta'
                                                        WHERE id = $val_id_solicitud;");
            }


            //Datos proveedor
            $data_proveedor = DB::table('empresas')->where('id', $val_id_proveedor)->first();
            //Datos de Solicitud 
            $data_solicitud = DB::table('solicitudes')->where('id', $val_id_solicitud)->first();
            //Detalle de Factura
            $data_factura = DB::table('listados')->where('id_solicitud', $val_id_solicitud)->get();
            //Datos Proyecto
            $data_proyecto = DB::table('proyectos')->where('id', $val_id_proyecto)->first();
            //direccion del correo
            $maxid = DB::table('orden')->find(DB::table('orden')->max('id'));
            $name = 'orderfile'.$maxid->id.'.pdf';
            $path = 'PDF/orderfile'.$maxid->id.'.pdf';

            //update ORDEN
            $insertarPDF = DB::update("UPDATE orden
                                                        SET pdf ='$path'
                                                        WHERE id = $maxid->id;");
            //insertar Orden_abierta si es Abierta
            if($val_ordenAbierta!=""){
                $insertarOrden_Abierta = DB::insert("INSERT INTO orden_abierta (id_orden,fecha,abono,debe,haber,saldo,enviado,respuesta_conta)
                                                    VALUES($maxid->id,'$fecha',0,'$val_total','-','$val_total','1','1');");
            }
            //insertar primer Pago si es Abierta
            if($val_ordenAbierta!=""){
                $val_saldo = floatval($val_total) - floatval($val_ordenAbierta);
                $insertarOrden_Abierta_pago = DB::insert("INSERT INTO orden_abierta (id_orden,fecha,abono,debe,haber,saldo,enviado,pdf,respuesta_conta)
                                                    VALUES($maxid->id,'$fecha',1,'-','$val_ordenAbierta','$val_saldo','0','$path','0');");
            }

            //data Orden Abierta
            $data_Orden_Abierta = DB::table('orden_abierta')->where('id_orden', $maxid->id)->get();

            $data = ['proveedor' => $data_proveedor,
                    'tipo_pago' => $str_tipo_pago,
                    'fecha' => $fecha,
                    'solicitud' => $data_solicitud,
                    'detalle' => $data_factura,
                    'proyecto' => $data_proyecto,
                    'enviar_a' => $val_enviar_a,
                    'total' => $val_total,
                    'orden_abierta' => $data_Orden_Abierta,
                    'ajuste' => $val_ajuste];

            $pdf = PDF::loadView('myPDF', $data);
            file_put_contents($path, $pdf->output()); 
    

            //GUARDAR CORRELATIVO DE LA ORDEN
            $proy = DB::table('proyectos')->where('id', $val_id_proyecto)->first();
            $correlativo = $proy->correlativo;
            $actualizar = DB::update("UPDATE orden
                                                SET no_orden = '$correlativo'
                                                WHERE id = $maxid->id;");
            
            //guardar no_orden en orden_abierta
            if($val_ordenAbierta!=""){
                $updateOrdenAbierta = DB::update("UPDATE orden_abierta
                                                            SET no_orden = '$correlativo'
                                                            WHERE id_orden = $maxid->id;");
            }
            //incrementar correlativo del proyecto
            
            $corr = $proy->correlativo + 1;
            $updateProyecto = DB::update("UPDATE proyectos
                                                        SET correlativo ='$corr'
                                                        WHERE id = $val_id_proyecto ;");
            $salida = '0';
            /*
            //GUARDAR CORRELATIVO DE LA ORDEN
            $provv = DB::table('proyecto')->where('id', $val_id_proveedor)->first();
            $corr1 = $provv->correlativo;
            $actualizar = DB::update("UPDATE orden
                                                SET no_orden = '$corr1'
                                                WHERE id = $maxid->id;");

            //guardar no_orden en orden_abierta
            if($val_ordenAbierta!=""){
                $updateOrdenAbierta = DB::update("UPDATE orden_abierta
                                                            SET no_orden = '$corr1'
                                                            WHERE id_orden = $maxid->id;");
            }

            //incrementar correlativo de empresa
            $corr = $provv->correlativo + 1;
            $updateProveedor = DB::update("UPDATE proyecto
                                                        SET correlativo ='$corr'
                                                        WHERE id = $val_id_proveedor;");

            $salida = '0';

            */



            return view('guardarPDF')->with('path',$path)
                                    ->with('salida',$salida);
            return $pdf->stream($name);


        }catch (Exception $e) { 
            Session::flash('catch_error','Crear Orden De Compra ');
            return view('ErrorCatch');  
        }

    }


    public function verSolicitudContadorFinalizada($id){
        try{
        $sol = orden::findOrFail($id);

        Session::put('c_id', $id);
        Session::put('c_idpro', $sol->id_proveedor);
        Session::put('c_idsol', $sol->id_solicitud);
        Session::put('c_idproy', $sol->id_proyecto);

        $solicitud = solicitude::findOrFail($sol->id_solicitud);
        $prove = empresa::findOrFail($sol->id_proveedor);
        $proyecto = proyecto::findOrFail($sol->id_proyecto);

        //nombre provedor
        Session::put('c_nproveedor', $prove->nombre_empresa);
        //solicitud
        Session::put('c_nsolicitud', $solicitud->titulo_solicitud);
        //proyecto
        Session::put('c_nproyecto', $proyecto->nombre_proyecto);
        //pdf orden
        $pdfOrden = DB::select("SELECT pdf 
                                FROM orden_abierta
                                WHERE id_orden = $id
                                AND abono = (SELECT max(abono)
                                            FROM orden_abierta
                                            WHERE id_orden = $id
                                            )");
        foreach($pdfOrden as $pdf){
            Session::put('c_npdf', $pdf->pdf);
        }
        
        //pdf presupuesto
        $solicitudd = DB::select(DB::raw("SELECT *
                                    FROM solicitudes
                                    WHERE id = '$sol->id_solicitud';"));
        foreach ($solicitudd as $soli) {
            if($soli->presupuesto!=NULL){
                Session::put('c_npdfpresupuesto',$soli->presupuesto);
            }else{
                Session::put('c_npdfpresupuesto','PDF/orderfile1.pdf');
            }          
        }
        $provee = DB::select("SELECT * FROM empresas WHERE id = $sol->id_proveedor");
        return view('/homeSolicitudContadorFinalizada')->with('proveedores',$provee);
        }catch (Exception $e) { 
            Session::flash('catch_error','Ver Solicitud Contador Finalizada');
            return view('ErrorCatch');  
        }
    }

    
}
