<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Use Exception;

class ControladorModuloProyectos extends Controller
{

    public function __construct(){

        $this->middleware('auth');//validacion de que este logeado
        $this->middleware('admin');//validacion de rol sea admin

    }

    public function mostrarUsuarios(Request $request){
        try{
            $name = $request->get('name');
            
            $proyectos = proyecto::orderBy('id', 'DESC')
            ->name($name)
            ->paginate(10);
            
            return view('proyectos', compact('proyectos'));
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Usuarios Register Admin');
            return view('ErrorCatch');  
        }
        
    }

    public function mostrarProyectosEditar($id){
        try{
            $proyecto = proyecto::findOrFail($id);
            return view('proyecto-editar', [ 'proyecto' => $proyecto ]);
        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Proyectos Editar Register Admin');
            return view('ErrorCatch');  
        }
    }

    public function AgregarUsuario(Request $request){
        //|email
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

        $proyect= new proyecto;
        $proyect->nombre_proyecto = $request->nombre_proyecto;
        $proyect->zona_proyecto = $request->zona_proyecto;
        $proyect->logo_proyecto = $ruta;
        $proyect->estado_proyecto = $request->estado_proyecto;
        $proyect->factura_a = $request->factura_a;
        $proyect->factura_numero = $request->factura_numero;
        $proyect->save();
    
        return redirect('/proyectos');
        }catch (Exception $e) { 
            Session::flash('catch_error','Agregar Usuario Register Admin');
            return view('ErrorCatch');  
        }
    }

    public function EliminarProyecto($id){
        try{
        proyecto::findOrFail($id)->delete();

        return redirect('/proyectos');
        }catch (Exception $e) { 
            Session::flash('catch_error','Eliminar Proyecto Register Admin');
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
            Session::flash('catch_error','Modificar Proyecto Register Admin');
            return view('ErrorCatch');  
        }
    }
}