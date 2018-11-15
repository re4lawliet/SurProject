<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;

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

    public function indexColaborador()
    {
        return view('homeColaborador');
    }
}
