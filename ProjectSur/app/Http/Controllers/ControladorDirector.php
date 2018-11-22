<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;

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
        $name = $request->get('name');
        
        $proyectos = proyecto::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('homeDirector', compact('proyectos'));
    }
}
