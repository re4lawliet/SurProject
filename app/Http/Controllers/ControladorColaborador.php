<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;
use Illuminate\Support\Facades\Auth;

class ControladorColaborador extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('colaborador');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexColaborador(Request $request)
    {
        $name = $request->get('name');
        
        $proyectos = proyecto::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('homeColaborador', compact('proyectos'));
    }
}
