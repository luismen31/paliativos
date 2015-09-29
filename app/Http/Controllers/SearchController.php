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
                $modelo = '\App\DatoProfesionalSalud';
            }else{
                $modelo = '\App\DatoPaciente';
            }

            $datospersona = $modelo::where(\DB::raw('CONCAT(NO_CEDULA," ",PRIMER_NOMBRE," ",APELLIDO_PATERNO)'), 'LIKE', '%'.$search.'%')
                ->select(\DB::raw('CONCAT(PRIMER_NOMBRE," ",APELLIDO_PATERNO) AS nombre'), 'NO_CEDULA AS cedula')
                ->orderBy('cedula', 'DESC')
                ->take(10)
                ->get();
            
            return utf8_encode($datospersona);            
        }else{
            abort(403);
        }    

    }

    public function getDistrito(Request $request){
        $distrito = \App\Distrito::where('id_provincia',$request->input('provincia'));
        return ($distrito->get(['id_distrito','distrito']));
    }
    public function getCorregimiento(Request $request){
        $corregimiento = \App\Corregimiento::where('id_distrito',$request->input('distrito'));
        return ($corregimiento->get(['id_corregimiento','corregimiento']));
    }
}


