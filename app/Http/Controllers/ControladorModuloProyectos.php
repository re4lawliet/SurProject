<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Use Exception;

class ControladorModuloProyectos extends Controller
{
    public function __construct(){

        $this->middleware('auth');
        //$this->middleware('admin', ['only' => ['mostrarProyectos','mostrarProyectosEditar', 'AgregarProyecto', 'EliminarProyecto','ModificarProyecto'] ]);
        $this->middleware('proyecto', ['only' => ['mostrarProyectos','mostrarProyectosEditar', 'AgregarProyecto', 'EliminarProyecto','ModificarProyecto'] ]);        

    }

    public function mostrarProyectos(Request $request){
        try{
            $name = $request->get('name');
            $proyectos = proyecto::orderBy('id', 'DESC')
            ->name($name)
            ->paginate(10);
            return view('proyectos', compact('proyectos'));
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Proyectos');
            return view('ErrorCatch');  
        }
    }

    public function mostrarProyectosEditar($id){
        try{
            $proyecto = proyecto::findOrFail($id);
            return view('proyecto-editar', [ 'proyecto' => $proyecto ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Editar Proyecto');
            return view('ErrorCatch');  
        }
    }

    public function AgregarProyecto(Request $request){
        //|email
        //try{
            $validator = Validator::make($request->all(), [
                'nombre_proyecto' => 'required|max:255',
                'zona_proyecto' => 'max:255',
                'logo_proyecto' => 'max:248',
                'estado_proyecto' => 'max:255',
                'factura_a' => 'max:255',
                'factura_numero' => 'max:255'
                
            ]);
        
            if ($validator->fails()) {
                return redirect('/proyectos')
                    ->withInput()
                    ->withErrors($validator);
            }
            
            //----Creando imagen
            $nombrep = $request->nombre_proyecto;
            $zonap = $request->zona_proyecto;
            $nombreimg =$_FILES['logo_proyecto']['name'];//nombre relativo
            $archivo =$_FILES['logo_proyecto']['tmp_name'];//archivo binario
            $ruta="images/".$nombrep.$zonap.$nombreimg;
            
            if(strpos($ruta, '.png') OR strpos($ruta, '.jpg')){
                move_uploaded_file($archivo,$ruta);
            }else{
                $ruta="images/NoImageFound.png";
            }
            //------------------

            $proyect= new proyecto;
            $proyect->nombre_proyecto = $request->nombre_proyecto;
            $proyect->zona_proyecto = $request->zona_proyecto;
            $proyect->logo_proyecto = $ruta;
            $proyect->estado_proyecto = $request->estado_proyecto;
            $proyect->factura_a = $request->factura_a;
            $proyect->factura_numero = $request->factura_numero;
            $proyect->correlativo = "1000";
            $proyect->save();

            $I1 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15000', '0','0','0')");
            $I2 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15010', '0','0','0')");
            $I3 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15020', '0','0','0')");
            $I4 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15030', '0','0','0')");
            $I5 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15040', '0','0','0')");
            $I6 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15050', '0','0','0')");
            $I7 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15060', '0','0','0')");
            $I8 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15070', '0','0','0')");
            $I9 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15080', '0','0','0')");
            $I10 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15090', '0','0','0')");
            $I11 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15100', '0','0','0')");
            $I12 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15110', '0','0','0')");
            $I13 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15120', '0','0','0')");
            $I14 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15130', '0','0','0')");
            $I15 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15140', '0','0','0')");
            $I16 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15150', '0','0','0')");
            $I17 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15160', '0','0','0')");
            $I18 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15170', '0','0','0')");
            $I19 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15180', '0','0','0')");
            $I20 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15190', '0','0','0')");
            $I21 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15200', '0','0','0')");
            $I22 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15210', '0','0','0')");
            $I23 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15220', '0','0','0')");
            $I24 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15230', '0','0','0')");
            $I25 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15240', '0','0','0')");
            $I26 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15250', '0','0','0')");
            $I27 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15260', '0','0','0')");
            $I28 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15270', '0','0','0')");
            $I29 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15280', '0','0','0')");
            $I30 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15290', '0','0','0')");
            $I31 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15300', '0','0','0')");
            $I32 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15310', '0','0','0')");
            $I33 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15320', '0','0','0')");
            $I34 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15330', '0','0','0')");
            $I35 = DB::insert("INSERT INTO presupuesto (id_proyecto, id_partida,presupuesto,orden_sumada,saldo)
            VALUES ((SELECT MAX(id) FROM proyectos),'15340', '0','0','0')");
        
            return redirect('/proyectos');
        // }catch (Exception $e) { 
        //     Session::flash('catch_error','Agregar Proyecto');
        //     return view('ErrorCatch');  
        // }
    
    }

    public function EliminarProyecto($id){
        try{
        proyecto::findOrFail($id)->delete();

        return redirect('/proyectos');
        }catch (Exception $e) { 
            Session::flash('catch_error','Eliminar Proyecto');
            return view('ErrorCatch');  
        }
    }

    public function ModificarProyecto(Request $request, $id){
        try{
            $validator = Validator::make($request->all(), [
                'nombre_proyecto' => 'required|max:255',
                'zona_proyecto' => 'max:255',
                'logo_proyecto' => 'max:248',
                'estado_proyecto' => 'max:255',
                'factura_a' => 'max:255',
                'factura_numero' => 'max:255'
        
            ]);
        
            if ($validator->fails()) {
                return redirect('/proyectos')
                ->withInput()
                ->withErrors($validator);
            }

            //----Creando imagen
            $nombrep = $request->nombre_proyecto;
            $zonap = $request->zona_proyecto;
            $nombreimg =$_FILES['logo_proyecto']['name'];//nombre relativo
            $archivo =$_FILES['logo_proyecto']['tmp_name'];//archivo binario
            $ruta="images/".$nombrep.$zonap.$nombreimg;
            
            if(strpos($ruta, '.png') OR strpos($ruta, '.jpg')){
                move_uploaded_file($archivo,$ruta);
            }else{
                $ruta="images/NoImageFound.png";
            }
            //------------------
        
            $proyect = proyecto::findOrFail($id);
            $proyect->nombre_proyecto = $request->nombre_proyecto;
            $proyect->zona_proyecto = $request->zona_proyecto;
            $proyect->logo_proyecto = $ruta;
            $proyect->estado_proyecto = $request->estado_proyecto;
            $proyect->factura_a = $request->factura_a;
            $proyect->factura_numero = $request->factura_numero;
            $proyect->save();
            return redirect('/proyectos');
        }catch (Exception $e) { 
            Session::flash('catch_error','Modificar Proyecto');
            return view('ErrorCatch');  
        }
    }

    

    public function GuardarProyecto($id, $nombre_proyecto){
        try{
            Session::put('proyectoG', $id);
            Session::put('proyectoGnombre', $nombre_proyecto);

            $proyect = proyecto::findOrFail($id);

            Session::put('proyectoGzona_proyecto', $proyect->zona_proyecto);
            Session::put('proyectoGlogo_proyecto', $proyect->logo_proyecto);
            Session::put('proyectoGestado_proyecto', $proyect->estado_proyecto);
            Session::put('proyectoGfactura_a', $proyect->factura_a);
            Session::put('proyectoGfactura_numero', $proyect->factura_numero);
            

            return redirect('/homeProyecto');
        }catch (Exception $e) { 
            Session::flash('catch_error','Guardar Proyecto');
            return view('ErrorCatch');  
        }
    }

    public function HomeProyecto()
    {
        return view('ModuloProyecto.homeProyecto');
    }
}
