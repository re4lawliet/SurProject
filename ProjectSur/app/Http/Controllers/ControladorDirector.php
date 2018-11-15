<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;

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

    public function indexDirector()
    {
        return view('homeDirector');
    }
}
