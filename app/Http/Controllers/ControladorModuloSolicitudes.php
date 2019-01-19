<?php

namespace SUR\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use SUR\solicitude;
use SUR\listado;
use SUR\proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;

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

        $listad = DB::select(DB::raw("SELECT *
                                            FROM listados
                                            WHERE id_solicitud = $id;"));

        $solicitud = DB::select(DB::raw("SELECT *
                                            FROM solicitudes
                                            WHERE id = $id;"));
        return view('homeSolicitudDirector')
                                            ->with('queryListado', $listad)
                                            ->with('querySolicitud',$solicitud);
    }

    public function verPresupuesto(Request $request){
        $pdf = $request->txt_pdf;
        return view('/presupuestoDirector')->with('pdf',$pdf);
    }

    public function verPresupuesto2($pdf){
        return view('/presupuestoDirector')->with('pdf',$pdf);
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
    }


    public function crearOrden(Request $request){
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
            
        ]);
    
        if ($validator->fails()) {
            return redirect('/MostrarSolicitudesCompras')
                ->withInput()
                ->withErrors($validator);
        }

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

        $val_enviar_a = $request->txt_enviara;
        $val_id_proyecto = $request->id_proyecto;
        $val_correos = $request->correos;
        


        //Insertar en Orden
        $insertarOrden = DB::select(DB::raw("INSERT INTO orden (id_proveedor,tipo_pago,id_solicitud,total,id_proyecto,correos,enviado,respuesta_conta,comentario_conta)
                                    VALUES($val_id_proveedor,$val_tipo_pago,$val_id_solicitud,'$val_total',$val_id_proyecto,'$val_correos','0','0','');"));
        
        //Insertar precios
        $arr_ids=explode(",",$val_ids);
        $arr_precios=explode(",",$val_precios_unitarios);
        $arr_subtotales = explode(",",$val_subtotales);
        for($i =0; $i<sizeof($arr_ids);$i++){
            $insertarPrecios = DB::select(DB::raw("UPDATE listados
                                                    SET precio_unitario = $arr_precios[$i], subtotal = $arr_subtotales[$i]
                                                    WHERE id = $arr_ids[$i];"));
        }
        //actualizar Solicitud
        $insertarSolicitud = DB::select(DB::raw("UPDATE solicitudes
                                                    SET orden_creada = '1'
                                                    WHERE id = $val_id_solicitud;"));
        if ($_FILES['presupuesto']['name'] != null) {
            $nombrep = 'pres'.$val_id_solicitud;
            $nombreimg =$_FILES['presupuesto']['name'];//nombre relativo
            $archivo =$_FILES['presupuesto']['tmp_name'];//archivo binario
            $ruta="PDF/".$nombrep.$nombreimg;
            if(strpos($ruta, '.pdf')){
                move_uploaded_file($archivo,$ruta);
            }else{
                $ruta="";
            }
            $insertarSolicitud2 = DB::select(DB::raw("UPDATE solicitudes
                                                    SET presupuesto = '$ruta'
                                                    WHERE id = $val_id_solicitud;"));
        }

        //Datos proveedor
        $data_proveedor = DB::table('empresas')->where('id', $val_id_proveedor)->first();
        //Datos de Solicitud 
        $data_solicitud = DB::table('solicitudes')->where('id', $val_id_solicitud)->first();
        //Detalle de Factura
        $data_factura = DB::table('listados')->where('id_solicitud', $val_id_solicitud)->get();
        //Datos Proyecto
        $data_proyecto = DB::table('proyectos')->where('id', $val_id_proyecto)->first();
       

        date_default_timezone_set('America/Guatemala');
        $fecha = date('d/m/y');

        $data = ['proveedor' => $data_proveedor,
                'tipo_pago' => $str_tipo_pago,
                'fecha' => $fecha,
                'solicitud' => $data_solicitud,
                'detalle' => $data_factura,
                'proyecto' => $data_proyecto,
                'enviar_a' => $val_enviar_a,
                'total' => $val_total];
                
        //direccion del correo
        $maxid = DB::table('orden')->find(DB::table('orden')->max('id'));
        $name = 'orderfile'.$maxid->id.'.pdf';
        $path = 'PDF/orderfile'.$maxid->id.'.pdf';
        //update ORDEN
        $insertarPDF = DB::select(DB::raw("UPDATE orden
                                                    SET pdf ='$path'
                                                    WHERE id = $maxid->id;"));

        // return view('myPDF')->with('proveedor' , $data_proveedor)
        //                     ->with('tipo_pago' , $str_tipo_pago)
        //                     ->with('fecha' , $fecha)
        //                     ->with('solicitud' , $data_solicitud)
        //                     ->with('detalle' , $data_factura)
        //                     ->with('proyecto',$data_proyecto)
        //                     ->with('enviar_a',$val_enviar_a)
        //                     ->with('total',$val_total);

        
        $pdf = PDF::loadView('myPDF', $data);
        file_put_contents($path, $pdf->output()); 
        return view('guardarPDF')->with('path',$path);
        //return $pdf->stream($name);
        
    }










    

}
