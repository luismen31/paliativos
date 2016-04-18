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

    public function getBuscarMedicamentos(Request $request){
        if(!$request->ajax()) abort(403);
        
        $search = $request->input('search');
        if(trim($search)){
            $medicamentos = \App\Medicamento::where('DESCRIPCION', 'LIKE', '%'.$search.'%')
                ->select('DESCRIPCION', 'ID_MEDICAMENTO')
                ->orderBy('DESCRIPCION', 'DESC')
                ->take(10)
                ->get();
            
            return utf8_encode($medicamentos);
        }
    }

    //FUNCION PARA OBTENER LOS DATOS DEL PACIENTE SOAP
    public function pacienteSoap(Request $request){

        $this->validate($request, ['search_paciente' => 'required']);
        // dd($request->get('search_paciente'));
        $paciente = \App\DatoPaciente::where('NO_CEDULA', $request->get('search_paciente'))->first();
        
        if($paciente == null){
            \Session::flash('msj_error', 'Solo se puede enviar la cédula del paciente');
            return redirect()->back();
        }

        return redirect()->route('categorias', [$paciente->ID_PACIENTE]);
    }

    public function getObtenerTratamiento(Request $request){
        if(!$request->ajax()) abort(403);

        $id_detalle_receta = $request->input('det_receta_id');

        $detalle_receta = \App\DetalleReceta::where('ID_DETALLE_RECETA', $id_detalle_receta)->first();
        $medicamento = \App\Medicamento::where('ID_MEDICAMENTO', $detalle_receta->ID_MEDICAMENTO)->first();

        $indicaciones = (!empty($detalle_receta->OTRAS_INDICACIONES)) ? $detalle_receta->OTRAS_INDICACIONES : '';

        $data = array(
            'det_receta' => $id_detalle_receta,
            'descripcion_medicamento' => $medicamento->DESCRIPCION,
            'medicamento_id' => $medicamento->ID_MEDICAMENTO,
            'cant_dosis' => $detalle_receta->DOSIS,
            'frecuencia_trat' => $detalle_receta->ID_FRECUENCIA_TRATAMIENTO,
            'tratamiento' => $detalle_receta->TRATAMIENTO,
            'via' => $detalle_receta->ID_VIA,
            'periodo' => $detalle_receta->ID_PERIODO_TRATAMIENTO,
            'indicaciones' => utf8_encode($indicaciones)
        );

        return \Response::json($data);
    }

    //Obtiene todos los usuarios de la Base de Datos
    public function getUsers(){
        if(!request()->ajax()) abort(403);

        $datos = array();
        $inputs = request()->all();        

        if(empty($inputs['search'])){
            $usuarios = \App\User::where('ID_USUARIO', '>', 0)
            ->select(\DB::raw('SQL_CALC_FOUND_ROWS *'), 'NO_IDENTIFICACION', 'ID_USUARIO', 'ID_GRUPO_USUARIO')
            ->take($inputs['limit'])->skip($inputs['offset'])->get();
        }else{
            $usuarios = \App\User::where('ID_USUARIO', '>', 0)
            ->where('NO_IDENTIFICACION', 'LIKE', '%'.$inputs['search'].'%')
            ->select(\DB::raw('SQL_CALC_FOUND_ROWS *'), 'NO_IDENTIFICACION', 'ID_USUARIO', 'ID_GRUPO_USUARIO')
            ->take($inputs['limit'])->skip($inputs['offset'])->get();
        }

        $cantidad = \DB::select(\DB::raw("SELECT FOUND_ROWS() AS total;"));
        $cantidad = $cantidad[0]->total;
        $n = 1;

        foreach ($usuarios as $usuario) {
            $paciente = \App\Paciente::where('ID_USUARIO', $usuario->ID_USUARIO)->first();
            $profesional = \App\ProfesionalSalud::where('ID_USUARIO', $usuario->ID_USUARIO)->first();

            if($paciente != null){
                $datos_paciente = \App\DatoPaciente::findOrFail($paciente->ID_PACIENTE);
                $usuario->fullName = $datos_paciente->full_name;
                $usuario->cedula = $datos_paciente->NO_CEDULA;
            }

            if ($profesional != null) {
                $datos_prof = \App\DatoProfesionalSalud::findOrFail($profesional->ID_PROFESIONAL);
                $usuario->fullName = $datos_prof->full_name;
                $usuario->cedula = $datos_prof->NO_CEDULA;   
            }

            if ($paciente == null and $profesional == null) {
                $usuario->fullName = 'Administrador';
                $usuario->cedula = 'Administrador';
            }

            $usuario->grupo = \App\GrupoUsuario::findOrFail($usuario->ID_GRUPO_USUARIO)->DESCRIPCION;

            $url = '<button class="btn btn-sm btn-success btn-edit-user" data-id="'.$usuario->ID_USUARIO.'" title="Editar"><i class="fa fa-edit"></i><span class="sr-only">Editar</span></button>';

            $datos[] = [
                'num' => $n++ + $inputs['offset'],
                'identificacion' => $usuario->NO_IDENTIFICACION,
                'cedula' => $usuario->cedula,
                'patient_or_prof' => $usuario->fullName,
                'group' => $usuario->grupo,
                'act' => $url
                
            ];
        }

        return \Response::json(['total' => $cantidad, 'rows' => $datos]);
    }

    public function getUsuario(Request $request){
       
        if(!$request->ajax()) abort(403);

        $id = $request->input('user_id');

        //DECLARACIONES
        $select = 0;
        $pregunta = 1;
        $respuesta = $email = $tel = '';

        $user = \App\User::where('ID_USUARIO', $id)->first();
        $preferencias = \App\PreferenciaRecuperacionAcceso::where('ID_USUARIO', $id)->first();
        $autenticacion = \App\DatoAutenticacionUsuario::where('ID_USUARIO', $id)->first();
        
        $identificacion = $user->NO_IDENTIFICACION;

        if($preferencias != null){

            if($preferencias->USAR_PREGUNTA_SEGURIDAD == 1){
                $select = '1';
                $pregunta = $autenticacion->ID_PREGUNTA;
                $respuesta = $autenticacion->RESPUESTA;
            }
            if($preferencias->USAR_EMAIL_PREFERENCIAL == 1){
                $select = '2';
                $email = $autenticacion->E_MAIL_PREFERENCIAL;
            }  
            if($preferencias->USAR_TELEFONO_PREFERENCIAL == 1){
                $select = '3';
                $tel = $autenticacion->TELEFONO_PREFERENCIAL;
            }

        }

        $datos = array(
            'identificacion' => $identificacion,
            'recuperar' => $select,
            'preg_recuperacion' => $pregunta,
            'respuesta' => $respuesta,
            'correo' => $email,
            'telefono' => $tel

        );

        return \Response::json($datos);
    }

}



