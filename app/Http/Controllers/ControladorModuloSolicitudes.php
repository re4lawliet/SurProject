<?php

namespace SUR\Http\Controllers;

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
        $insertarOrden = DB::select(DB::raw("INSERT INTO orden (id_proveedor,tipo_pago,id_solicitud,total,id_proyecto,correos)
                                    VALUES($val_id_proveedor,$val_tipo_pago,$val_id_solicitud,'$val_total',$val_id_proyecto,'$val_correos');"));
        
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
