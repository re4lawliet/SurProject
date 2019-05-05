<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;
Use Exception;
use Illuminate\Support\Facades\DB;

class ControladorAdmin extends Controller
{
    //
/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexAdmin(Request $request)
    {
        try{
            
            $name = $request->get('name');
            $proyectos = proyecto::orderBy('id', 'DESC')
            ->name($name)
            ->paginate(10);
            
            return view('homeAdmin', compact('proyectos'));
      
        } catch (Exception $e) { 
            Session::flash('catch_error','Carga Home de Admin');
            return view('ErrorCatch');  
        }
    }

    public function register2(Request $request)
    {
        return view('auth.register2');
    }


    public function asignacion(){
        $asignaciones = DB::select("SELECT u.id AS id_u, u.name, u.apellido, p.id AS id_p, p.nombre_proyecto
                                    FROM users as u, proyectos as p, usuario_proyecto as up
                                    WHERE u.id = up.id_usuario
                                    AND p.id = up.id_proyecto
                                    ORDER BY nombre_proyecto DESC;");

        $usuarios = DB::select("SELECT *
                                FROM users
                                ORDER BY name;");

        $proyectos = DB::select("SELECT *
                                FROM proyectos
                                ORDER BY nombre_proyecto;");

        return view('asignaciones')->with('asignaciones',$asignaciones)
                                    ->with('usuarios',$usuarios)
                                    ->with('proyectos',$proyectos);

    }


    public function asignar(Request $request){
        $id_usuario = $request->empleados;
        $id_proyecto = $request->proyectos;
        $asignaciones = DB::select("SELECT *
                                    FROM usuario_proyecto;");


        if($id_usuario != "-1" && $id_proyecto!="-1"){

            $asignar = 1;
            foreach($asignaciones as $a){
                if($a->id_usuario == $id_usuario && $a->id_proyecto == $id_proyecto){
                    $asignar=0;
                }
            }
            if($asignar==1){
                $agregar = DB::insert("INSERT INTO usuario_proyecto (id_usuario, id_proyecto)
                                    VALUES($id_usuario, $id_proyecto);");
            }else{
                echo('ya existe asignacion');
            }
            
        }else{
            echo('no selecciono nada');
        }


        $asignaciones = DB::select("SELECT u.id AS id_u, u.name, u.apellido, p.id AS id_p, p.nombre_proyecto
                                    FROM users as u, proyectos as p, usuario_proyecto as up
                                    WHERE u.id = up.id_usuario
                                    AND p.id = up.id_proyecto
                                    ORDER BY nombre_proyecto DESC;");

        $usuarios = DB::select("SELECT *
                                FROM users
                                ORDER BY name;");

        $proyectos = DB::select("SELECT *
                                FROM proyectos
                                ORDER BY nombre_proyecto;");

        return view('asignaciones')->with('asignaciones',$asignaciones)
                                    ->with('usuarios',$usuarios)
                                    ->with('proyectos',$proyectos);

    }

    public function desasignar($idu, $idp){

        $quitar = DB::delete("DELETE 
                                FROM usuario_proyecto
                                WHERE id_usuario = $idu
                                AND id_proyecto = $idp;");

        $asignaciones = DB::select("SELECT u.id AS id_u, u.name, u.apellido, p.id AS id_p, p.nombre_proyecto
                                    FROM users as u, proyectos as p, usuario_proyecto as up
                                    WHERE u.id = up.id_usuario
                                    AND p.id = up.id_proyecto
                                    ORDER BY nombre_proyecto DESC;");

        $usuarios = DB::select("SELECT *
                                FROM users
                                ORDER BY name;");

        $proyectos = DB::select("SELECT *
                                    FROM proyectos
                                    ORDER BY nombre_proyecto;");

        return view('asignaciones')->with('asignaciones',$asignaciones)
                                    ->with('usuarios',$usuarios)
                                    ->with('proyectos',$proyectos);
    }
    

}
