<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\temporal_producto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class ControladorModuloProductos_Temporal extends Controller
{
    //Aqui van las Acciones desde las routes solo se llaman 
    public function __construct(){

        $this->middleware('auth');

    }

    public function mostrarTemporal_Productos(){

        $temporal_productos = temporal_producto::all();
        return view('temporal_productos', [ 'temporal_productos' => $temporal_productos ]);
        
    }

    public function mostrarTemporal_ProductosEditar($id){

        $temporal_producto = temporal_producto::findOrFail($id);
        return view('temporal_producto-editar', [ 'temporal_producto' => $temporal_producto ]);
    }

    public function AgregarTemporal_Producto(Request $request){
        //
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
        $temporal_product->save();
    
        return redirect('/temporal_productos');
    
    }

    public function EliminarTemporal_Producto($id){
        temporal_producto::findOrFail($id)->delete();

        return redirect('/temporal_productos');
    }

    public function ModificarTemporal_Producto(Request $request, $id){

        //
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

    }
}
