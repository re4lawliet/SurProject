<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;
use SUR\solicitude;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ControladorDirector extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('director');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexDirector(Request $request)
    {
        $nsolicitudes = solicitude::where('respondido_manager','1')
                                    ->where('aprobado_manager','1')
                                    ->where('respondido_director','0')
                                    ->count();
        Session::put('countSolicitudesDirector',$nsolicitudes);

        $name = $request->get('name');
        
        $proyectos = proyecto::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('homeDirector', compact('proyectos'));
    }
}
