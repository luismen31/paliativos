<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function getBuscarpersona(Request $request, $type, $search){
        if($request->ajax()){
            if($type == 'profesional'){
                $datospersona = \App\DatoProfesionalSalud::where(\DB::raw('CONCAT(NO_CEDULA," ",PRIMER_NOMBRE," ",APELLIDO_PATERNO)'), 'LIKE', '%'.$search.'%')
                ->select(\DB::raw('CONCAT(PRIMER_NOMBRE," ",APELLIDO_PATERNO) AS nombre'), 'NO_CEDULA AS cedula')
                ->orderBy('cedula', 'desc')
                ->take(10)
                ->get();
            }
            
            return utf8_encode($datospersona);
            
        }    

        abort(403);



    }
}
