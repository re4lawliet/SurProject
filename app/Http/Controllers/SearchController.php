<?php

namespace SUR\Http\Controllers;

use Illuminate\Http\Request;
use SUR\Http\Controllers\Controller;
use SUR\empresa;

class SearchController extends Controller
{
    function index()
    {
     return view('search');
    }

    function fetch(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = DB::table('empresas')
        ->where('nombre_empresa', 'LIKE', "%{$query}%")
        ->get();

        //$data = DB::select(DB::raw("SELECT id, nombre_empresa FROM empresas WHERE nombre_empresa LIKE %{$query}%"))
        //->get();


      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
       $output .= '
       <li><a href="#">'.$row->nombre_empresa.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
    }
    //
    /*public function index(){
        return view('search');
    }

    public function autocomplete(Request $request){
        $data = empresa::select("nombre_empresa")
                        ->where("nombre_empresa","LIKE","%{$request->input('name')}%")
                        ->get();
        return response()->json($data);
    }*/
}
