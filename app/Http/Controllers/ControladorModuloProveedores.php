<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proveedore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Use Exception;

class ControladorModuloProveedores extends Controller
{
    ////
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function mostrarProveedores(){

        try{

            $proveedores = proveedore::all();
            return view('proveedores', [ 'pro' => $proveedores ]);

        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Proveedores');
            return view('ErrorCatch');  
        }
        
    }

    public function mostrarProveedoresEditar($id){

        try{
            $proveedor = proveedore::findOrFail($id);
            return view('proveedor-editar', [ 'proveedor' => $proveedor ]);

        }catch (Exception $e) { 
            Session::flash('catch_error','Mostrar Editar Proveedor');
            return view('ErrorCatch');  
        }
    }

    public function AgregarProveedor(Request $request){
        //|email
        try{

            $validator = Validator::make($request->all(), [
                'nombre_proveedor' => 'required|max:255',
                'direccion_oficina' => 'max:255',
                'nit_proveedor' => 'max:255',
                'telefono_proveedor' => 'max:255',
                'correo_proveedor' => 'max:255',
                'nombre_banco' => 'max:255',
                'forma_pago' => 'max:255'
            ]);
        
            if ($validator->fails()) {
                return redirect('/proveedores')
                    ->withInput()
                    ->withErrors($validator);
            }
        
            $proveedo= new proveedore;
            $proveedo->nombre_proveedor = $request->nombre_proveedor;
            $proveedo->direccion_oficina = $request->direccion_oficina;
            $proveedo->nit_proveedor = $request->nit_proveedor;
            $proveedo->telefono_proveedor = $request->telefono_proveedor;
            $proveedo->correo_proveedor = $request->correo_proveedor;
            $proveedo->nombre_banco = $request->nombre_banco;
            $proveedo->forma_pago = $request->forma_pago;
            $proveedo->save();
        
            return redirect('/proveedores');

        }catch (Exception $e) { 
            Session::flash('catch_error','Agregar Proveedor');
            return view('ErrorCatch');  
        }
    
    }

    public function EliminarProveedor($id){

        try{ 

            proveedore::findOrFail($id)->delete();

            return redirect('/proveedores');

        }catch (Exception $e) { 
            Session::flash('catch_error','Eliminar Proveedor');
            return view('ErrorCatch');  
        }
    }

    public function ModificarProveedor(Request $request, $id){

        try{

            $validator = Validator::make($request->all(), [
                'nombre_proveedor' => 'required|max:255',
                'direccion_oficina' => 'max:255',
                'nit_proveedor' => 'max:255',
                'telefono_proveedor' => 'max:255',
                'correo_proveedor' => 'max:255',
                'nombre_banco' => 'max:255',
                'forma_pago' => 'max:255'
        
            ]);
        
            if ($validator->fails()) {
                return redirect('/proveedores')
                    ->withInput()
                    ->withErrors($validator);
            }
        
            $proveedo = proveedore::findOrFail($id);
            $proveedo->nombre_proveedor = $request->nombre_proveedor;
            $proveedo->direccion_oficina = $request->direccion_oficina;
            $proveedo->nit_proveedor = $request->nit_proveedor;
            $proveedo->telefono_proveedor = $request->telefono_proveedor;
            $proveedo->correo_proveedor = $request->correo_proveedor;
            $proveedo->nombre_banco = $request->nombre_banco;
            $proveedo->forma_pago = $request->forma_pago;
            $proveedo->save();
            return redirect('/proveedores');

        }catch (Exception $e) { 
            Session::flash('catch_error','Modificar Proveedor');
            return view('ErrorCatch');  
        }

    }
}
