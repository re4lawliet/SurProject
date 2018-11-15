<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proveedore;

class ControladorModuloProveedores extends Controller
{
    ////
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function mostrarProveedores(){

        $proveedores = proveedore::all();
        return view('proveedores', [ 'pro' => $proveedores ]);
        
    }

    public function mostrarProveedoresEditar($id){

        $proveedor = proveedore::findOrFail($id);
        return view('proveedor-editar', [ 'proveedor' => $proveedor ]);
    }

    public function AgregarProveedor(Request $request){
        //|email
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
    
    }

    public function EliminarProveedor($id){
        proveedore::findOrFail($id)->delete();

        return redirect('/proveedores');
    }

    public function ModificarProveedor(Request $request, $id){

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

    }
}
