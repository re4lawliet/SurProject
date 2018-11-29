<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;

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

        $solicitudes = solicitude::where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudes',$solicitudes);

        $name = $request->get('name');
        $proyectos = proyecto::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('homeAdmin', compact('proyectos'));
    }

    public function register2(Request $request)
    {
        return view('auth.register2');
    }
    

}
