<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SurcoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('surco.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $v = \Validator::make($request->all(), ['search_paciente' => 'required']);
        if($v->fails()){
            return redirect()->route('surco.index')->withErrors($v);
        }

        $datos = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();        
        if ($datos == null) {
            \Session::flash('msj_error', 'Solo puede ingresar una cédula del paciente');
            return redirect()->route('surco.index');
        }

        //Si el paciente no tiene registrado un SURCO envia al formulario para crear, sino carga el SURCO del mismo
        $surcoPaciente = \App\Surco::where('ID_PACIENTE', $datos->ID_PACIENTE)->first();        
        if($surcoPaciente == null){
            return view('surco.create')->with('datos', $datos);            
        }else{
            return $this->show($surcoPaciente->ID_SURCO);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $idPaciente = $data['ID'];        
        $idProf = \App\DatoProfesionalSalud::where('NO_CEDULA', $data['search_profesional'])->first()->ID_PROFESIONAL;
        $idTrazabilidad = \App\Trazabilidad::getTrazabilidad($idPaciente);

        $examenFisico = new \App\ExamenFisico;
        $examenFisico->ID_PACIENTE = $idPaciente;
        $examenFisico->HORA = $data['hora'];
        $examenFisico->PRESION_ARTERIAL = $data['presion_arterial'];
        $examenFisico->FRECUENCIA_CARDIACA = $data['frecuencia_cardiaca'];
        $examenFisico->FRECUENCIA_RESPIRATORIA = $data['frecuencia_respiratoria'];
        $examenFisico->FRECUENCIA_CARDIACA_FETAL = $data['frecuencia_cardiaca_fetal'];
        $examenFisico->TEMPERATURA = $data['temperatura'];
        $examenFisico->PESO = $data['peso'];
        $examenFisico->TALLA = $data['talla'];
        $examenFisico->save();

        $historiaPaciente = new \App\HistoriaPaciente;
        $historiaPaciente->ANAMNESIS = $data['anamnesis'];
        $historiaPaciente->ID_EXAMEN_FISICO = $examenFisico->ID_EXAMEN_FISICO;
        $historiaPaciente->OBSERVACIONES = $data['observaciones'];
        $historiaPaciente->save();

        $surco = new \App\Surco;
        $surco->ID_PACIENTE = $idPaciente;
        $surco->ID_TRAZABILIDAD = $idTrazabilidad;
        $surco->FECHA = dateNow();
        $surco->INSTALACION_REFIERE = $data['instalacion_refiere'];
        $surco->INSTALACION_RECEPTORA = $data['instalacion_receptora'];
        $surco->ID_MOTIVO_REFERENCIA = $data['motivo_referencia'];
        $surco->ID_CLASIFICACION_ATENCION_SOLICITADA = $data['clasificacion_solicitada'];
        $surco->ID_HISTORIA_PACIENTE = $historiaPaciente->ID_HISTORIA_PACIENTE;
        $surco->ID_PROFESIONAL = $idProf;
        $surco->ID_SERVICIO = $data['servicio_medico'];
        $surco->save();

        foreach (\App\TipoExamen::all() as $tipoExamen) {

            $idTipoExamen = $tipoExamen->ID_TIPO_EXAMEN;   
            if(!empty($data['search_cie10'.$idTipoExamen])){
                
                $diagnostico = new \App\Diagnostico;
                $diagnostico->save();

                $detDiag = new \App\DetalleDiagnostico;
                $detDiag->ID_DIAGNOSTICO = $diagnostico->ID_DIAGNOSTICO;
                $detDiag->ID_CIE10 = $data['search_cie10'.$idTipoExamen];
                $detDiag->ID_FRECUENCIA = $data['frecuencia'.$idTipoExamen];
                $detDiag->ID_PROFESIONAL = $idProf;
                $detDiag->OBSERVACION = $data['obser'.$idTipoExamen];
                $detDiag->save();

                $resultados = new \App\ResultadoExamenDiagnostico;
                $resultados->ID_TIPO_EXAMEN = $idTipoExamen;
                $resultados->ID_DIAGNOSTICO = $diagnostico->ID_DIAGNOSTICO;
                $resultados->TRATAMIENTO = $data['tratamiento'.$idTipoExamen];
                $resultados->FECHA = $data['fecha_examen'.$idTipoExamen];
                $resultados->ID_SURCO = $surco->ID_SURCO;
                $resultados->save();
            }
            
        }

        //Almacena en detalle soap el surco que se registro y retorna a soap
        if(!empty($data['id_soap'])){
            $det_soap = \App\DetalleSoap::where('ID_SOAP', $data['id_soap'])->first();
            $det_soap->ID_SURCO = $surco->ID_SURCO;
            $det_soap->save();

            $return = \Redirect::route('soapCategory', [$data['id_categoria'], $idPaciente, $data['id_soap']]);
        }else{

            $request->session()->flash('msj_success', 'Se ha registrado exitosamente.');
            $return = $this->show($surco->ID_SURCO);
        }
        return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {                
        $surco = \App\Surco::find($id);        
        $paciente = \App\DatoPaciente::where('ID_PACIENTE', $surco->ID_PACIENTE)->first();
        $history = \App\HistoriaPaciente::where('ID_HISTORIA_PACIENTE', $surco->ID_HISTORIA_PACIENTE)->first();
        $examen = \App\ExamenFisico::where('ID_EXAMEN_FISICO', $history->ID_EXAMEN_FISICO)->first();
        $respuestas = \App\RespuestaReferencia::where('ID_SURCO', $id)->get();
        //Si no contiene respuestas muestra el formulario para llear los datos, sino carga una tabla con las distintas respuestas
        if(count($respuestas) > 0){  
            
            return view('surco.show', compact(['surco', 'paciente', 'history', 'examen', 'respuestas']));
        }else{            
            return view('surco.show', compact(['surco', 'paciente', 'history', 'examen']));
        }
    }

    //Funcion para ver la respuesta que se selecciona
    public function verRespuesta($id_respuesta){

        $referencia = \App\RespuestaReferencia::find($id_respuesta);
        $detalleDiagnostico = \App\DetalleDiagnostico::where('ID_DIAGNOSTICO', $referencia->ID_DIAGNOSTICO)->first();
        $prof = \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $referencia->ID_PROFESIONAL)->first();
        $referencia->instalacion_responde = $referencia->INSTITUCION_RESPONDE;
        $referencia->instalacion_receptora = $referencia->INSTALACION_RECEPTORA;
        $referencia->search_cie10respuesta = $detalleDiagnostico->ID_CIE10;
        $referencia->hallazgos = $referencia->HALLAZGOS_CLINICOS;
        $referencia->frecuencia = $detalleDiagnostico->ID_FRECUENCIA;
        $referencia->tratamiento = $referencia->TRATAMIENTO;
        $referencia->observaciones = $detalleDiagnostico->OBSERVACION;
        $referencia->reev_especializada = $referencia->REEVALUACION_ESPECIALIZADA;
        $referencia->fecha_respuesta = $referencia->FECHA;
        $referencia->search_profesional = $prof->NO_CEDULA;

        $surco = \App\Surco::find($referencia->ID_SURCO);
        $paciente = \App\DatoPaciente::where('ID_PACIENTE', $surco->ID_PACIENTE)->first();
        $history = \App\HistoriaPaciente::where('ID_HISTORIA_PACIENTE', $surco->ID_HISTORIA_PACIENTE)->first();
        $examen = \App\ExamenFisico::where('ID_EXAMEN_FISICO', $history->ID_EXAMEN_FISICO)->first();
        $respuestas = \App\RespuestaReferencia::where('ID_SURCO', $referencia->ID_SURCO)->get();
        
        return view('surco.show', compact(['surco', 'paciente', 'history', 'examen', 'referencia', 'respuestas']));

    }

    //Funcion para registrar la respuesta a la referencia
    public function storeRespuesta(Request $request){
        
        $data = $request->all();

        $diagnostico = new \App\Diagnostico;
        $diagnostico->save();

        $idProfesional = \App\ProfesionalSalud::where('ID_USUARIO', \Auth::user()->ID_USUARIO)->first()->ID_PROFESIONAL;

        $detDiag = new \App\DetalleDiagnostico;
        $detDiag->ID_DIAGNOSTICO = $diagnostico->ID_DIAGNOSTICO;
        $detDiag->ID_CIE10 = $data['search_cie10respuesta'];
        $detDiag->ID_FRECUENCIA = $data['frecuencia'];
        $detDiag->ID_PROFESIONAL = $idProfesional; //Profesional que se encuentra logueado
        $detDiag->OBSERVACION = $data['observaciones'];
        $detDiag->save();

        $idProfesional = \App\DatoProfesionalSalud::where('NO_CEDULA', $data['search_profesional_respuesta'])->first()->ID_PROFESIONAL;
        $respuesta = new \App\RespuestaReferencia;
        $respuesta->FECHA = $data['fecha_respuesta'];
        $respuesta->ID_DIAGNOSTICO = $diagnostico->ID_DIAGNOSTICO;
        $respuesta->HALLAZGOS_CLINICOS = $data['hallazgos'];
        $respuesta->TRATAMIENTO = $data['tratamiento'];
        $respuesta->REEVALUACION_ESPECIALIZADA = $data['reev_especializada'];
        $respuesta->INSTITUCION_RESPONDE = $data['instalacion_responde'];
        $respuesta->INSTALACION_RECEPTORA = $data['instalacion_receptora'];
        $respuesta->ID_PROFESIONAL = $idProfesional;
        $respuesta->ID_SURCO = $data['id_surco'];
        $respuesta->save();

        $request->session()->flash('msj_success', 'Se ha registrado la respuesta a la referencia correctamente');
        return $this->show($data['id_surco']);
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
