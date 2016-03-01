<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function getBuscarpersona(Request $request, $type, $search){
        if(!$request->ajax()) abort(403);

        if($type == 'profesional'){
            $modelo = '\App\DatoProfesionalSalud';
        }else{
            $modelo = '\App\DatoPaciente';
        }

        $datospersona = $modelo::where(\DB::raw('CONCAT(NO_CEDULA," ",PRIMER_NOMBRE," ",APELLIDO_PATERNO)'), 'LIKE', '%'.$search.'%')
            ->select(\DB::raw('CONCAT(PRIMER_NOMBRE," ",APELLIDO_PATERNO) AS nombre'), 'NO_CEDULA AS cedula')
            ->orderBy('nombre', 'ASC')
            ->take(10)
            ->get();
        
        return utf8_encode($datospersona);            

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

    public function getBuscarcie10(Request $request, $search){
        if(!$request->ajax()) abort(403);
         $cie10 = \App\Cie10::where(\DB::raw('CONCAT(ID_CIE10," ", DESCRIPCION)'), 'LIKE', '%'.$search.'%')
            ->select(\DB::raw('CONCAT(DESCRIPCION) AS CIE10'), 'ID_CIE10')
            ->orderBy('DESCRIPCION', 'DESC')
            ->take(10)
            ->get();
        
        return utf8_encode($cie10);
    }

    public function getRda(Request $request){
        //aborta la ejecucion si no es AJAX.
        if(!$request->ajax()) abort(403);

        $id_rda = $request->get('id'); //Recibe el id        
        $det_rda = \App\DetalleRda::where('ID_RDA', $id_rda)->first(); //busca todos los datos de ese RDA        
        $det_diag = \App\DetalleDiagnostico::where('ID_DIAGNOSTICO', $det_rda->ID_DIAGNOSTICO)->first(); //Busca todo los datos de la tabla detalle_diagnostico        
        $id_cie10 = $det_diag->ID_CIE10;
        $id_diag_prof = $det_diag->ID_PROFESIONAL;
        $act_prof = \App\Actividad::where('ID_ACTIVIDAD', $det_rda->ID_ACTIVIDAD)->first()->ID_PROFESIONAL; //Busca el id_prof del que realizo la actividad al paciente        
        if($det_rda->REFERIDO_PACIENTE == 0){
            $referido = 'No Referido';
        }else{
            $referido = 'Dentro de la Inst.';
        }

        $data = array(
            'Zona' => \App\Zona::where('ID_ZONA', $det_rda->ID_ZONA)->first()->ZONA,
            'Paciente' => \App\DatoPaciente::where('ID_PACIENTE', $det_rda->ID_PACIENTE)->first()->PRIMER_NOMBRE.' '.\App\DatoPaciente::where('ID_PACIENTE', $det_rda->ID_PACIENTE)->first()->APELLIDO_PATERNO,
            'Frecuencia' => \App\Frecuencia::where('ID_FRECUENCIA', $det_rda->ID_FRECUENCIA)->first()->FRECUENCIA,
            'Tipo De Atencion' => \App\TipoAtencion::where('ID_TIPO_ATENCION', $det_rda->ID_TIPO_ATENCION)->first()->TIPO_ATENCION,
            'CIE10' => \App\Cie10::where('ID_CIE10', $id_cie10)->first()->DESCRIPCION,
            'Diag./Prof.' => \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $id_diag_prof)->first()->PRIMER_NOMBRE.' '.\App\DatoProfesionalSalud::where('ID_PROFESIONAL', $id_diag_prof)->first()->APELLIDO_PATERNO,
            'Actividad' => \App\Actividad::where('ID_ACTIVIDAD', $det_rda->ID_ACTIVIDAD)->first()->ACTIVIDAD,
            'Act./Prof.' => \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $act_prof)->first()->PRIMER_NOMBRE.' '.\App\DatoProfesionalSalud::where('ID_PROFESIONAL', $act_prof)->first()->APELLIDO_PATERNO,
            'Estado' => \App\EstadoPaciente::where('ID_ESTADO_PACIENTE', $det_rda->ID_ESTADO_PACIENTE)->first()->LETRA_ESTADO,
            'Referido' => $referido,
            'Observacion' => $det_diag->OBSERVACION,
        );
        
        //Retorna la data al script.js en formato json.
        return \Response::json($data);
    }

    public function getFiltrarrda(Request $request){
        
        if(!$request->ajax()) abort(403);

        $fecha_inicio =  $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $tipoRDA = $request->input('tipo_rda');

        $data = array();

        foreach (\App\RegistroDiarioActividad::where('TIPO_ATENCION', $tipoRDA)->whereBetween('FECHA', [$fecha_inicio, $fecha_fin])->orderBy('FECHA')->get() as $rda) {
            $url = '<a href="'.route('rda.edit', $rda->ID_RDA).'" class="btn btn-info btn-xs"><i class="fa fa-search"></i> Buscar</a>';

            $data[] = [
                'fecha' => $rda->FECHA,
                'institucion' => \App\Institucion::where('ID_INSTITUCION', $rda->ID_INSTITUCION)->first()->DENOMINACION,
                'prof' => \App\DetalleEquipoMedico::where('ID_EQUIPO_MEDICO', $rda->ID_EQUIPO_MEDICO)->count(),
                'pacientes' => \App\DetalleRda::where('ID_RDA', $rda->ID_RDA)->count(),
                'horas' => ($rda->HORAS_DE_ATENCION == NULL) ? 0 : $rda->HORAS_DE_ATENCION,
                'url' => $url
            ];
        }

        return \Response::json($data);
    }

    public function getActividad(Request $request){
        if(!$request->ajax()) abort(403);

        $actividad = \App\Actividad::where('ID_ACTIVIDAD', $request->input('id_activity'))->first();
        $profesional = \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $actividad->ID_PROFESIONAL)->first();

        $datos = [
            'actividad' => $actividad->ACTIVIDAD,
            'profesional' => $profesional->PRIMER_NOMBRE.' '.$profesional->APELLIDO_PATERNO
        ];
        
        return response()->json($datos); 

    }
}



