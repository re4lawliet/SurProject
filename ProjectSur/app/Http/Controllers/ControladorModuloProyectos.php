<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;

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
            'estado_proyecto' => 'max:255',
            'factura_a' => 'max:255',
            'factura_numero' => 'max:255'
        ]);
    
        if ($validator->fails()) {
            return redirect('/proyectos')
                ->withInput()
                ->withErrors($validator);
        }
    
        $proyect= new proyecto;
        $proyect->nombre_proyecto = $request->nombre_proyecto;
        $proyect->zona_proyecto = $request->zona_proyecto;
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
            'estado_proyecto' => 'max:255',
            'factura_a' => 'max:255',
            'factura_numero' => 'max:255'
    
        ]);
    
        if ($validator->fails()) {
            return redirect('/proyectos')
            ->withInput()
            ->withErrors($validator);
        }
    
        $proyect = proyecto::findOrFail($id);
        $proyect->nombre_proyecto = $request->nombre_proyecto;
        $proyect->zona_proyecto = $request->zona_proyecto;
        $proyect->estado_proyecto = $request->estado_proyecto;
        $proyect->factura_a = $request->factura_a;
        $proyect->factura_numero = $request->factura_numero;
        $proyect->save();
        return redirect('/proyectos');

    }
}
