<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//Entidades utilizadas
use App\DatoPaciente;
use App\ResponsablePaciente;
use App\Trazabilidad;
use App\DatoProfesionalSalud;
use App\Cama;
use App\DiagnosticoAdmision;
use App\DetalleDiagnosticoAdmision;
use App\DiagnosticoEgreso;
use App\DetalleDiagnosticoEgreso;
use App\RegistroAdmisionEgreso;
use App\Cie10;

class EvolucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('evolucion.index');
    }

    public function buscarPaciente(Request $request){
       
        $v = \Validator::make($request->all(), ['search_paciente' => 'required']);
        $id_paciente = $request->input('paciente');
        $responsable = $request->input('responsable');
        if($v->fails()){
            //llamado a la funcion de redireccionamiento            
            return $this->redirectRoute($v, $id_paciente, $responsable);
        }

        $datos = DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
        if ($datos == null) {
            $request->session()->flash('msj_error', 'Solo puede ingresar una cédula del paciente o no existe el mismo');
            return redirect()->route('evolucion.index');
        }
        
        $responsable = ResponsablePaciente::where('ID_PACIENTE', $datos->ID_PACIENTE)->first();        
        if($responsable == null){
            $request->session()->flash('msj_info', $datos->PRIMER_NOMBRE.' '.$datos->APELLIDO_PATERNO.' no tiene un responsable registrado en el sistema');
            return view('evolucion.responsable')->with('id_paciente', $datos->ID_PACIENTE);
        }else{
            //Carga vista para registrar el registro de admision-egreso
            $rae = RegistroAdmisionEgreso::where('ID_PACIENTE', $datos->ID_PACIENTE)->first();
            if($rae != null){
                //Obtenemos los datos de RAE de la funcion getRAE
                $rae = $this->getRAE($rae);
                
                return view('evolucion.update', compact(['datos', 'responsable', 'rae']));
            }

            return view('evolucion.create', compact(['datos', 'responsable']));
        }
    }

    //Permite registrar los datos del responsable del paciente
    public function registrarResponsable(Request $request, $id_paciente){

        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'parentesco' => 'required',
            'telefono' => 'required',
        ];

        $v = \Validator::make($request->all(), $rules);
        if($v->fails()){            
            return $this->redirectRoute($v, $id_paciente);
        }

        $responsable = new ResponsablePaciente;
        $responsable->ID_PACIENTE = $id_paciente;
        $responsable->NOMBRE_CONTACTO = $request->input('nombre');
        $responsable->APELLIDO_CONTACTO = $request->input('apellido');
        $responsable->PARENTESCO_CONTACTO = $request->input('parentesco');
        $responsable->DIRECCION_CONTACTO = $request->input('direccion');
        $responsable->TELEFONO_CONTACTO = $request->input('telefono');
        $responsable->save();

        $paciente = DatoPaciente::where('ID_PACIENTE', $id_paciente)->first();
        $request->session()->flash('msj_success', 'Se ha registrado correctamente el responsable del paciente '.$paciente->PRIMER_NOMBRE.' '.$paciente->APELLIDO_PATERNO);
        return redirect()->route('evolucion.index');
    }

    //Redirige a la vista o ruta que tenga la validacion
    public function redirectRoute($v, $id_paciente = null, $responsable = null){
        //si no esta vacio el $id_paciente redirige a la vista del responsable o la vista de registro del RAE con los errores
        // sino redirige a la vista anterior procesada a la solicitud            
        if($id_paciente != null){
            if($responsable != null){
                $datos = DatoPaciente::where('ID_PACIENTE', $id_paciente)->first();
                $responsable = ResponsablePaciente::where('ID_PACIENTE', $id_paciente)->first();    
                //Carga vista para registrar el registro de admision-egreso
                $rae = RegistroAdmisionEgreso::where('ID_PACIENTE', $datos->ID_PACIENTE)->first();
                if($rae != null){
                    
                    $rae = $this->getRAE($rae);

                    return view('evolucion.update', compact(['datos', 'responsable', 'rae']))->withErrors($v);
                }
                //Carga vista para registrar el registro de admision-egreso con errores de validacion            
                return view('evolucion.create', compact(['datos', 'responsable']))->withErrors($v);
            }

            return view('evolucion.responsable', compact('id_paciente'))->withErrors($v);

        }else{
            return redirect()->back()->withErrors($v);
        }
    }

    public function getRAE($rae){
        // Detalle de la Admisión
        $admision = DetalleDiagnosticoAdmision::where('ID_DIAGNOSTICO_ADMISION', $rae->ID_DIAGNOSTICO_ADMISION)->first();
        $Cie10 = Cie10::where('ID_CIE10', $admision->ID_CIE10)->first();

        $rae->diagnosticoCie10Ad = $Cie10->DESCRIPCION;
        $rae->search_cie10_admision = $admision->ID_CIE10;

        $profAd = DatoProfesionalSalud::where('ID_PROFESIONAL', $admision->ID_PROFESIONAL)->first();

        $rae->search_profesional_1 = $profAd->NO_CEDULA;
        $rae->nombre_profesional_1 = $profAd->PRIMER_NOMBRE.' '.$profAd->APELLIDO_PATERNO;
        $rae->OBSERVACION_ADMISION = $admision->OBSERVACION;                
        
        //Detalle del Egreso (Solo cargara los campos que esten llenos en el sistema)
        $egreso = DetalleDiagnosticoEgreso::where('ID_DIAGNOSTICO_EGRESO', $rae->ID_DIAGNOSTICO_EGRESO)->first();
        $Cie10 = Cie10::where('ID_CIE10', $egreso->ID_CIE10)->first();

        $rae->diagnosticoCie10Eg = ($Cie10 == null) ? '' : $Cie10->DESCRIPCION;
        $rae->search_cie10_egreso = $egreso->ID_CIE10;

        $profEg = DatoProfesionalSalud::where('ID_PROFESIONAL', $egreso->ID_PROFESIONAL)->first();

        $rae->search_profesional_2 = ($profEg == null) ? '' : $profEg->NO_CEDULA;
        $rae->nombre_profesional_2 =  ($profEg == null) ? '' : $profEg->PRIMER_NOMBRE.' '.$profEg->APELLIDO_PATERNO;
        $rae->FRECUENCIA = $egreso->ID_FRECUENCIA;
        $rae->INFECCION = ($egreso->INFECCION_NOSOCOMIAL == null) ? 0 : $egreso->INFECCION_NOSOCOMIAL;
        $rae->CAUSA = $egreso->CAUSA_EXTERNA;
        $rae->OBSERVACION_EGRESO = $egreso->OBSERVACION;

        // Datos para evolucion del RAE, algunos campos ya son tomados del modelo RAE.
        $profEv = DatoProfesionalSalud::where('ID_PROFESIONAL', $rae->ID_PROFESIONAL)->first();

        $rae->nombre_profesional_3 = ($profEv == null) ? '' : $profEv->PRIMER_NOMBRE.' '.$profEv->APELLIDO_PATERNO;
        $rae->search_profesional_3 = ($profEv == null) ? '' : $profEv->NO_CEDULA;

        //Ciertos campos ya son tomados de la BD y permite poblar directamente los formularios con el mismo nombre de campo
        return $rae;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'ID_REFERIDO' => 'not_in:0',
            'ID_CAMA' => 'not_in:0',
            'search_cie10' => 'required',
            'search_profesional' => 'required',          
        ];

        $msjs = [
            'search_cie10.required' => 'El Diagnóstico/CIE-10 de la sección de Datos de Admisión es requerido',
            'search_profesional.required' => 'El Profesional de la sección de Datos de Admisión es requerido',
        ];

        $v = \Validator::make($request->all(), $rules, $msjs);
        $id_paciente = $request->input('paciente');
        $responsable = $request->input('responsable');
        if($v->fails()){
            //llamado a la funcion de redireccionamiento            
            return $this->redirectRoute($v, $id_paciente, $responsable);
        }
        
        $idTrazabilidad = Trazabilidad::getTrazabilidad($id_paciente);
        $idProfAd = DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional'))->first()->ID_PROFESIONAL;
        
        $paciente = DatoPaciente::where('ID_PACIENTE', $id_paciente)->select(\DB::raw('CONCAT(PRIMER_NOMBRE," ",APELLIDO_PATERNO) AS nombre'))->first();        
        $idSala = Cama::where('ID_CAMA', $request->input('ID_CAMA'))->first()->ID_SALA;

        $diag_adm = new DiagnosticoAdmision;
        $diag_adm->save();

        $det_diag_adm = new DetalleDiagnosticoAdmision;
        $det_diag_adm->ID_DIAGNOSTICO_ADMISION = $diag_adm->ID_DIAGNOSTICO_ADMISION;
        $det_diag_adm->ID_CIE10 = $request->input('search_cie10');
        $det_diag_adm->ID_PROFESIONAL = $idProfAd;
        $det_diag_adm->OBSERVACION = $request->input('OBSERVACION_ADMISION');
        $det_diag_adm->save();

        $diag_eg = new DiagnosticoEgreso;
        $diag_eg->save();

        $det_diag_eg = new DetalleDiagnosticoEgreso;        
        $det_diag_eg->ID_DIAGNOSTICO_EGRESO = $diag_eg->ID_DIAGNOSTICO_EGRESO;
        $det_diag_eg->ID_FRECUENCIA = $request->input('FRECUENCIA');
        $det_diag_eg->INFECCION_NOSOCOMIAL = $request->input('INFECCION');
        $det_diag_eg->CAUSA_EXTERNA = $request->input('CAUSA');
        $det_diag_eg->ID_CIE10 = $request->input('search_cie10_egreso');
        $det_diag_eg->ID_PROFESIONAL = $request->input('search_profesional_2');
        $det_diag_eg->OBSERVACION = $request->input('OBSERVACION_EGRESO');
        $det_diag_eg->save();

        $rae = new RegistroAdmisionEgreso;
        $rae->FECHA = dateNow();
        $rae->ID_PACIENTE = $id_paciente;
        $rae->ID_TRAZABILIDAD = $idTrazabilidad;
        $rae->ID_REFERIDO = $request->input('ID_REFERIDO');
        $rae->ID_DIAGNOSTICO_ADMISION = $diag_adm->ID_DIAGNOSTICO_ADMISION;
        $rae->ID_DIAGNOSTICO_EGRESO = $diag_eg->ID_DIAGNOSTICO_EGRESO;
        $rae->ID_SALA = $idSala;
        $rae->ID_CAMA = $request->input('ID_CAMA');
        $rae->ID_CONDICION_SALIDA = $request->input('CONDICION_SALIDA');        
        $rae->MUERTE_EN_SOP = $request->input('MUERTE_SOP');
        $rae->AUTOPSIA = $request->input('AUTOPSIA');
        $rae->FECHA_AUTOPSIA = $request->input('FECHA_AUTOPSIA');
        $rae->ID_MOTIVO_SALIDA = $request->input('MOTIVO');
        $rae->ID_PROFESIONAL = $request->input('search_profesional_3');
        $rae->TOTAL_DIAS_ESTANCIA = $request->input('DIAS_ESTANCIA');
        $rae->save();

        $request->session()->flash('msj_success', 'Se ha registrado correctamente el Registro de Admisión-Egreso del paciente '.$paciente->nombre);
        return redirect()->route('evolucion.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'search_cie10_egreso' => 'required',
            'search_profesional_2' => 'required',
            'search_profesional_3' => 'required',
            'FRECUENCIA' => ['required', 'not_in:0'],
            'FECHA_AUTOPSIA' => 'date_format:Y-m-d',
            'ID_MOTIVO_SALIDA' => ['required', 'not_in:0'],
            'ID_CONDICION_SALIDA' => ['required', 'not_in:0'],
            'TOTAL_DIAS_ESTANCIA' => ['required', 'numeric'],
        ];

        $msjs = [
            'search_cie10_egreso.required' => 'El Diagnóstico/CIE-10 de la sección de Datos de Egreso es requerido',
            'search_profesional_2.required' => 'El Profesional de la sección de Datos de Egreso es requerido',
            'search_profesional_3.required' => 'El Profesional de la sección de Datos de Evolución es requerido',
        ];

        $v = \Validator::make($request->all(), $rules, $msjs);
        $id_paciente = $request->input('paciente');
        $responsable = $request->input('responsable');
        if($v->fails()){
            //llamado a la funcion de redireccionamiento            
            //return $this->redirectRoute($v, $id_paciente, $responsable);
            return $this->redirectRoute($v, $id_paciente, $responsable);
        }

        $paciente = DatoPaciente::where('ID_PACIENTE', $id_paciente)->select(\DB::raw('CONCAT(PRIMER_NOMBRE," ",APELLIDO_PATERNO) AS nombre'))->first();
        $prof_eg = DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional_2'))->first();

        $rae = RegistroAdmisionEgreso::find($id);
        $det_diag_eg = DetalleDiagnosticoEgreso::where('ID_DIAGNOSTICO_EGRESO', $rae->ID_DIAGNOSTICO_EGRESO)->first();
        $det_diag_eg->ID_CIE10 = $request->input('search_cie10_egreso');
        $det_diag_eg->ID_PROFESIONAL = $prof_eg->ID_PROFESIONAL;
        $det_diag_eg->ID_FRECUENCIA = $request->input('FRECUENCIA');
        $det_diag_eg->INFECCION_NOSOCOMIAL = $request->input('INFECCION');
        $det_diag_eg->CAUSA_EXTERNA = $request->input('CAUSA');
        $det_diag_eg->OBSERVACION = $request->input('OBSERVACION_EGRESO');
        $det_diag_eg->save();

        $prof_ev = DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional_3'))->first();
        
        $rae->ID_CONDICION_SALIDA = $request->input('ID_CONDICION_SALIDA');
        $rae->MUERTE_EN_SOP = $request->input('MUERTE_EN_SOP');
        $rae->AUTOPSIA = $request->input('AUTOPSIA');
        $rae->FECHA_AUTOPSIA = $request->input('FECHA_AUTOPSIA');
        $rae->ID_MOTIVO_SALIDA = $request->input('ID_MOTIVO_SALIDA');
        $rae->ID_PROFESIONAL = $prof_ev->ID_PROFESIONAL;
        $rae->TOTAL_DIAS_ESTANCIA = $request->input('TOTAL_DIAS_ESTANCIA');
        $rae->save();

        $request->session()->flash('msj_success', 'Se ha actualizado correctamente el Registro de Admisión-Egreso del paciente '.$paciente->nombre);
        return redirect()->route('evolucion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
