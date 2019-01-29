<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;
Use Exception;

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
    

}
