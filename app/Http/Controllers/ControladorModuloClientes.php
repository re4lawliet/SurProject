<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\cliente;
use SUR\Client;

class ControladorModuloClientes extends Controller
{
    //Aqui van las Acciones desde las routes solo se llaman 
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function mostrarClientes(){

        $clientes = cliente::all();
        return view('clientes', [ 'cli' => $clientes ]);
        
    }

    public function mostrarClientesEditar($id){

        $cliente = cliente::findOrFail($id);
        return view('cliente-editar', [ 'cliente' => $cliente ]);
    }

    public function AgregarCliente(Request $request){
        //
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'max:255',
            'nit' => 'max:255',
            'telefono' => 'max:8'
    
        ]);
    
        if ($validator->fails()) {
            return redirect('/clientes')
                ->withInput()
                ->withErrors($validator);
        }
    
        $client= new cliente;
        $client->nombre = $request->nombre;
        $client->apellido = $request->apellido;
        $client->direccion = $request->direccion;
        $client->nit = $request->nit;
        $client->telefono = $request->telefono;
        $client->save();
    
        return redirect('/clientes');
    
    }

    public function EliminarCliente($id){
        cliente::findOrFail($id)->delete();

        return redirect('/clientes');
    }

    public function ModificarCliente(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'max:255',
            'nit' => 'max:255',
            'telefono' => 'max:8'
    
        ]);
    
        if ($validator->fails()) {
            return redirect('/clientes')
                ->withInput()
                ->withErrors($validator);
        }
    
        $client = cliente::findOrFail($id);
        $client->nombre = $request->nombre;
        $client->apellido = $request->apellido;
        $client->direccion = $request->direccion;
        $client->nit = $request->nit;
        $client->telefono = $request->telefono;
        $client->save();
        return redirect('/clientes');

    }
}
