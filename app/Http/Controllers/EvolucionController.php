<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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

        $datos = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
        if ($datos == null) {
            \Session::flash('msj_error', 'Solo puede ingresar una cédula del paciente o no existe el mismo');
            return redirect()->route('evolucion.index');
        }
        
        $responsable = \App\ResponsablePaciente::where('ID_PACIENTE', $datos->ID_PACIENTE)->first();        
        if($responsable == null){
            $request->session()->flash('msj_info', $datos->PRIMER_NOMBRE.' '.$datos->APELLIDO_PATERNO.' no tiene un responsable registrado en el sistema');
            return view('evolucion.responsable')->with('id_paciente', $datos->ID_PACIENTE);
        }else{
            //Carga vista para registrar el registro de admision-egreso
            return view('evolucion.create')->with('datos', $datos)->with('responsable', $responsable);
        }
    }

    //Permite registrar los datos del responsable del paciente
    public function registrarResponsable(Request $request, $id_paciente){

        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'parentezco' => 'required',
            'telefono' => 'required',
        ];

        $v = \Validator::make($request->all(), $rules);
        if($v->fails()){            
            return $this->redirectRoute($v, $id_paciente);
        }

        $responsable = new \App\ResponsablePaciente;
        $responsable->ID_PACIENTE = $id_paciente;
        $responsable->NOMBRE_CONTACTO = $request->input('nombre');
        $responsable->APELLIDO_CONTACTO = $request->input('apellido');
        $responsable->PARENTEZCO_CONTACTO = $request->input('parentezco');
        $responsable->DIRECCION_CONTACTO = $request->input('direccion');
        $responsable->TELEFONO_CONTACTO = $request->input('telefono');
        $responsable->save();

        $paciente = \App\DatoPaciente::where('ID_PACIENTE', $id_paciente)->first();
        $request->session()->flash('msj_success', 'Se ha registrado correctamente el responsable del paciente '.$paciente->PRIMER_NOMBRE.' '.$paciente->APELLIDO_PATERNO);
        return redirect()->route('evolucion.index');
    }

    //Redirige a la vista o ruta que tenga la validacion
    public function redirectRoute($v, $id_paciente = null, $responsable = null){
        //si no esta vacio el $id_paciente redirige a la vista del responsable o la vista de registro del RAE con los errores
        // sino redirige a la vista anterior procesada a la solicitud            
        if($id_paciente != null){
            if($responsable != null){
                $datos = \App\DatoPaciente::where('ID_PACIENTE', $id_paciente)->first();
                $responsable = \App\ResponsablePaciente::where('ID_PACIENTE', $id_paciente)->first();    
                //Carga vista para registrar el registro de admision-egreso con errores de validacion            
                return view('evolucion.create')->with('datos', $datos)->with('responsable', $responsable)->withErrors($v);
            }

            return view('evolucion.responsable')->with('id_paciente', $id_paciente)->withErrors($v);

        }else{
            return redirect()->back()->withErrors($v);
        }
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
            'search_cie10.required' => 'El Diagnóstico/CIE-10 de la sección de Datos de Admisión es obligatorio',
            'search_profesional.required' => 'El Profesional de la sección de Datos de Admisión es obligatorio',
        ];

        $v = \Validator::make($request->all(), $rules, $msjs);
        $id_paciente = $request->input('paciente');
        $responsable = $request->input('responsable');
        if($v->fails()){
            //llamado a la funcion de redireccionamiento            
            return $this->redirectRoute($v, $id_paciente, $responsable);
        }
        
        $idTrazabilidad = \App\Trazabilidad::getTrazabilidad($id_paciente);
        $idProfAd = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional'))->first()->ID_PROFESIONAL;
        
        if(trim($request->input('search_profesional_2')) != ''){
            $idProfEg = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional_2'))->first()->ID_PROFESIONAL;
        }else{
            $idProfEg = 0;
        }

        if(trim($request->input('search_profesional_3')) != ''){
            $idProfRae = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional_3'))->first()->ID_PROFESIONAL;
        }else{
            $idProfRae = 0;
        }
       
        $paciente = \App\DatoPaciente::where('ID_PACIENTE', $id_paciente)->select(\DB::raw('CONCAT(PRIMER_NOMBRE," ",APELLIDO_PATERNO)'))->first();
        $idSala = \App\Cama::where('ID_CAMA', $request->input('ID_CAMA'))->first()->ID_SALA;

        $diag_adm = new \App\DiagnosticoAdmision;
        $diag_adm->save();

        $det_diag_adm = new \App\DetalleDiagnosticoAdmision;
        $det_diag_adm->ID_DIAGNOSTICO_ADMISION = $diag_adm->ID_DIAGNOSTICO_ADMISION;
        $det_diag_adm->ID_CIE10 = $request->input('search_cie10');
        $det_diag_adm->ID_PROFESIONAL = $idProfAd;
        $det_diag_adm->OBSERVACION = $request->input('OBSERVACION_ADMISION');
        $det_diag_adm->save();

        $diag_eg = new \App\DiagnosticoEgreso;
        $diag_eg->save();

        $de_diag_eg = new \App\DetalleDiagnosticoEgreso;        
        $det_diag_eg->ID_DIAGNOSTICO_EGRESO = $diag_eg->ID_DIAGNOSTICO_EGRESO;
        $det_diag_eg->ID_FRECUENCIA = $request->input('FRECUENCIA');
        $det_diag_eg->INFECCION_NOSOCOMIAL = $request->input('INFECCION');
        $det_diag_eg->CAUSA_EXTERNA = $request->input('CAUSA');
        $det_diag_eg->ID_CIE10 = $request->input('search_cie10_egreso');
        $det_diag_eg->ID_PROFESIONAL = $idProfEg;
        $det_diag_eg->OBSERVACION = $request->input('OBSERVACION_EGRESO');
        $det_diag_eg->save();

        $rae = new \App\RegistroAdmisionEgreso;
        $rae->FECHA = \Carbon::now()->setTimezone('America/Panama')->format('Y/m/d');
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
        $rae->ID_PROFESIONAL = $idProfRae;
        $rae->TOTAL_DIAS_ESTANCIA = $request->input('DIAS_ESTANCIA');
        $rae->save();
        

        $request->session()->flash('msj_success', 'Se ha registrado correctamente el Registro de Admisión del paciente '.$paciente);
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
        //
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
