<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Analisis extends Controller
{
    


    public function login(){
        Session::put('usuario','noUser');
        return view('/AnalisisAlan/loginIT');
    }

    public function logear(Request $request){
        $correo = $request->correo;
        $pass = $request->contrasena;

        $usuarios = DB::select("SELECT *
                            FROM tba_users
                            WHERE correo = '$correo'
                            AND contrasena = '$pass';");

        $productos = DB::select("SELECT *
                                FROM tba_producto;");

        foreach($usuarios as $usuario){
            if($usuario->correo == $correo){
                Session::put('usuario',$usuario->nombre);
                Session::put('rol',$usuario->rol);
                return view('/AnalisisAlan/productos')->with('productos',$productos);
            }
        }
        return view('/AnalisisAlan/loginIT');
    }


    public function producto($id){
        $producto = DB::select("SELECT *
                                FROM tba_producto
                                WHERE id = $id");
        return view('analisisAlan/producto')->with('producto',$producto);
    }

    public function ver_carrito(){
        return view('AnalisisAlan/ver_carrito');
    }

    public function comprado(){
        
        $productos = DB::select("SELECT *
                                FROM tba_producto;");

        return view('/AnalisisAlan/productos')->with('productos',$productos);
    }





    public function informac_factura(){
        return view('/AnalisisAlan/informac_factura');
    }

    

    

    public function administrador(){
        return view('analisisAlan/administrador');
    }


}
