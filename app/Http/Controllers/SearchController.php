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

    public function getObtenerrvd(Request $request){
        if(!$request->ajax()) abort(403);

        $fecha_inicio =  $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        
        $comilla = "'";
        $data = array();
               
        foreach(\App\RegistroVisitaDomiciliaria::whereBetween('FECHA', array($fecha_inicio, $fecha_fin))->orderBy('FECHA')->get() as $rvd) {
                    
            $data[] = array(
                'fecha' => $rvd->FECHA,
                'denominacion' => \App\Institucion::where('ID_INSTITUCION', $rvd->ID_INSTITUCION)->first()->DENOMINACION,
                'equipo' => \App\DetalleEquipoMedico::where('ID_EQUIPO_MEDICO', $rvd->ID_EQUIPO_MEDICO)->count(),
                'pacientes' => \App\DetalleRegistroVisitaDomiciliaria::where('ID_RVD', $rvd->ID_RVD)->count(),
                'horas' => $rvd->HORAS_DE_ATENCION,
                'url' => '<a href='.$comilla.route('rvd.show', $rvd->ID_RVD).$comilla.' class='.$comilla.'btn btn-info btn-sm'.$comilla.'><i class='.$comilla.'glyphicon glyphicon-search'.$comilla.'></i> Buscar </a>',  
            );
        }
        
        return \Response::json($data);
    }

    //Filtro para las agenda de citas medicas
    public function postCitamedica(Request $request){
        
        $fecha = $request->input('FECHA');
        $equipo = $request->input('ID_EQUIPO_MEDICO');

        return view('agenda.veragenda')->with('fechaFilter', $fecha)->with('equipoFilter', $equipo);
    }
}


