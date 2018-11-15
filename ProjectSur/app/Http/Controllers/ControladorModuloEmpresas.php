<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\empresa;

class ControladorModuloEmpresas extends Controller
{
    //
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function mostrarEmpresas(Request $request){

        $name = $request->get('name');
        
        $empresas = empresa::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('empresas', compact('empresas'));
        
    }

    public function mostrarEmpresasEditar($id){

        $empresa = empresa::findOrFail($id);
        return view('empresa-editar', [ 'empresa' => $empresa ]);
    }

    public function AgregarEmpresa(Request $request){
        //|email
        $validator = Validator::make($request->all(), [
            'nombre_empresa' => 'required|max:255',
            'nit_empresa' => 'max:255',
            'direccion_empresa' => 'max:255',
            'telefono_oficina' => 'max:255',
            'telefono_empresa' => 'max:255',
            'correo_empresa' => 'max:255',
            'telefono_encargado' => 'max:255',
            'correo_encargado' => 'max:255',
            'nombre_encargado' => 'max:255',
            'puesto_encargado' => 'max:255',
            'nombre_banco' => 'max:255',
            'forma_pago' => 'max:255'
        ]);
    
        if ($validator->fails()) {
            return redirect('/empresas')
                ->withInput()
                ->withErrors($validator);
        }
    
        $empres= new empresa;
        $empres->nombre_empresa = $request->nombre_empresa;
        $empres->nit_empresa = $request->nit_empresa;
        $empres->direccion_empresa = $request->direccion_empresa;
        $empres->telefono_oficina = $request->telefono_oficina;
        $empres->telefono_empresa = $request->telefono_empresa;
        $empres->correo_empresa = $request->correo_empresa;
        $empres->telefono_encargado = $request->telefono_encargado;
        $empres->correo_encargado = $request->correo_encargado;
        $empres->nombre_encargado = $request->nombre_encargado;
        $empres->puesto_encargado = $request->puesto_encargado;
        $empres->nombre_banco = $request->nombre_banco;
        $empres->forma_pago = $request->forma_pago;
        $empres->save();
    
        return redirect('/empresas');
    
    }

    public function EliminarEmpresa($id){
        empresa::findOrFail($id)->delete();

        return redirect('/empresas');
    }

    public function ModificarEmpresa(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nombre_empresa' => 'required|max:255',
            'nit_empresa' => 'max:255',
            'direccion_empresa' => 'max:255',
            'telefono_oficina' => 'max:255',
            'telefono_empresa' => 'max:255',
            'correo_empresa' => 'max:255',
            'telefono_encargado' => 'max:255',
            'correo_encargado' => 'max:255',
            'nombre_encargado' => 'max:255',
            'puesto_encargado' => 'max:255',
            'nombre_banco' => 'max:255',
            'forma_pago' => 'max:255'
    
        ]);
    
        if ($validator->fails()) {
            return redirect('/empresas')
                ->withInput()
                ->withErrors($validator);
        }
    
        $empres = empresa::findOrFail($id);
        $empres->nombre_empresa = $request->nombre_empresa;
        $empres->nit_empresa = $request->nit_empresa;
        $empres->direccion_empresa = $request->direccion_empresa;
        $empres->telefono_oficina = $request->telefono_oficina;
        $empres->telefono_empresa = $request->telefono_empresa;
        $empres->correo_empresa = $request->correo_empresa;
        $empres->telefono_encargado = $request->telefono_encargado;
        $empres->correo_encargado = $request->correo_encargado;
        $empres->nombre_encargado = $request->nombre_encargado;
        $empres->puesto_encargado = $request->puesto_encargado;
        $empres->nombre_banco = $request->nombre_banco;
        $empres->forma_pago = $request->forma_pago;
        $empres->save();
        return redirect('/empresas');

    }
}
