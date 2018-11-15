<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;

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

    public function indexAdmin()
    {
        return view('homeAdmin');
    }

}
