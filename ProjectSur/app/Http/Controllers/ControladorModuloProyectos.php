<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;
use Illuminate\Support\Facades\Session;

class ControladorModuloProyectos extends Controller
{
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function mostrarProyectos(Request $request){

        $name = $request->get('name');
        
        $proyectos = proyecto::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('proyectos', compact('proyectos'));
        
        
    }

    public function mostrarProyectosEditar($id){

        $proyecto = proyecto::findOrFail($id);
        return view('proyecto-editar', [ 'proyecto' => $proyecto ]);
    }

    public function AgregarProyecto(Request $request){
        //|email
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
        $proyect->save();
    
        return redirect('/proyectos');
    
    }

    public function EliminarProyecto($id){
        proyecto::findOrFail($id)->delete();

        return redirect('/proyectos');
    }

    public function ModificarProyecto(Request $request, $id){

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

    }

    

    public function GuardarProyecto($id, $nombre_proyecto){

        Session::put('proyectoG', $id);
        Session::put('proyectoGnombre', $nombre_proyecto);

        $proyect = proyecto::findOrFail($id);

        Session::put('proyectoGzona_proyecto', $proyect->zona_proyecto);
        Session::put('proyectoGlogo_proyecto', $proyect->logo_proyecto);
        Session::put('proyectoGestado_proyecto', $proyect->estado_proyecto);
        Session::put('proyectoGfactura_a', $proyect->factura_a);
        Session::put('proyectoGfactura_numero', $proyect->factura_numero);
        

        return redirect('/homeProyecto');
    }

    public function HomeProyecto()
    {
        return view('ModuloProyecto.homeProyecto');
    }
}
