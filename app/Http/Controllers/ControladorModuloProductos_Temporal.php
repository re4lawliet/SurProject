<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\temporal_producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
Use Exception;


class ControladorModuloProductos_Temporal extends Controller
{
    //Aqui van las Acciones desde las routes solo se llaman 
    public function __construct(){

        $this->middleware('auth');

    }

    public function mostrarTemporal_Productos(){
        try{
            $email = Auth::user()->email;
            $temporal_productos = DB::select("SELECT *
                                                FROM temporal_productos
                                                WHERE usuario = '$email'");
            return view('temporal_productos', [ 'temporal_productos' => $temporal_productos ]);

        }catch (Exception $e) { 
            Session::flash('catch_error','Temporal de Productos Para Solicitud');
            return view('ErrorCatch');  
        }
        
    }

    public function mostrarTemporal_ProductosEditar($id){
        try{

            $temporal_producto = temporal_producto::findOrFail($id);
            return view('temporal_producto-editar', [ 'temporal_producto' => $temporal_producto ]);

        }catch (Exception $e) { 
            Session::flash('catch_error','Temporal de Productos Para Solicitud Editar');
            return view('ErrorCatch');  
        }
    }

    public function AgregarTemporal_Producto(Request $request){
        //
        try{
            $validator = Validator::make($request->all(), [
                'descripcion' => 'required|max:255',
                'unidad' => 'required|max:255',
                'cantidad' => 'numeric'
        
            ]);
        
            if ($validator->fails()) {
                return redirect('/temporal_productos')
                    ->withInput()
                    ->withErrors($validator);
            }
        
            $temporal_product= new temporal_producto;
            $temporal_product->descripcion = $request->descripcion;
            $temporal_product->unidad = $request->unidad;
            $temporal_product->cantidad = $request->cantidad;
            $temporal_product->usuario = Auth::user()->email;
            $temporal_product->save();
        
            return redirect('/temporal_productos');

        }catch (Exception $e) { 
            Session::flash('catch_error','Agregar Producto Para Solicitud');
            return view('ErrorCatch');  
        }
    }

    public function EliminarTemporal_Producto($id){
        try{

            temporal_producto::findOrFail($id)->delete();

            return redirect('/temporal_productos');

        }catch (Exception $e) { 
            Session::flash('catch_error','Eliminar Producto Para Solicitud');
            return view('ErrorCatch');  
        }
    }

    public function ModificarTemporal_Producto(Request $request, $id){

        //
        try{

            $validator = Validator::make($request->all(), [
                'descripcion' => 'required|max:255',
                'unidad' => 'required|max:255',
                'cantidad' => 'numeric'
        
            ]);
        
            if ($validator->fails()) {
                return redirect('/temporal_productos')
                    ->withInput()
                    ->withErrors($validator);
            }
            
            $temporal_product = temporal_producto::findOrFail($id);
            $temporal_product->descripcion = $request->descripcion;
            $temporal_product->unidad = $request->unidad;
            $temporal_product->cantidad = $request->cantidad;
            $temporal_product->save();
            return redirect('/temporal_productos');

        }catch (Exception $e) { 
            Session::flash('catch_error','Modificar Productos Para Solicitud');
            return view('ErrorCatch');  
        }

    }


    public function LimpiarTemporal_Producto(){

        try{
            $email = Auth::user()->email;
            $solicitudes = DB::delete("DELETE FROM temporal_productos
                                        WHERE usuario = '$email';");
            
            return redirect('/temporal_productos');

        }catch (Exception $e) { 
            Session::flash('catch_error','Limpiar Temporal de Productos Para Solicitud');
            return view('ErrorCatch');  
        }
    }
}
