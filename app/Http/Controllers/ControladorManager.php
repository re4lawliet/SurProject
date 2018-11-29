<?php

namespace SUR\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SUR\proyecto;
use Illuminate\Support\Facades\Auth;

class ControladorManager extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('manager');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexManager(Request $request)
    {
        $name = $request->get('name');
        
        $proyectos = proyecto::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(10);
        
        return view('homeManager', compact('proyectos'));
    }
}
