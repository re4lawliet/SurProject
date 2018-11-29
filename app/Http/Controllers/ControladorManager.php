<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;

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

    public function indexManager()
    {
        return view('homeManager');
    }
}
