<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AtencionPacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('atencion_paciente.index');
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
            return redirect()->route('atencion_paciente.index')->withErrors($v);
        }

        $datos = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
        if ($datos == null) {
            \Session::flash('msj_error', 'Solo puede ingresar una cédula del paciente');
            return redirect()->route('atencion_paciente.index');
        }

        return view('atencion_paciente.create')->with('datos', $datos);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Almacena la atencion del paciente
    public function store(Request $request)
    {

        $atencion = new \App\AtencionPaciente;
        $atencion->ID_PROFESIONAL = 6;
        $atencion->ID_PACIENTE = $request->input('paciente');
        $atencion->FECHA = dateNow();
        $atencion->HORA_INICIO = $request->input('HORA_INICIO');
        $atencion->HORA_FIN = $request->input('HORA_FIN');
        $atencion->MINUTOS_UTILIZADOS = $request->input('MINUTOS_UTILIZADOS');
        $atencion->TIPO_CONTACTO = $request->input('TIPO_CONTACTO');
        $atencion->TELEFONO = $request->input('TELEFONO');
        $atencion->E_MAIL = $request->input('E_MAIL');
        $atencion->MOTIVO = $request->input('MOTIVO');
        $atencion->OBSERVACION = $request->input('OBSERVACION');
        $atencion->save();

        $request->session()->flash('msj_success', 'Se ha registrado correctamente la atención.');
        return redirect()->route('atencion_paciente.show', ['id' => $request->input('paciente')]);
    }

    //Almacena la respuesta a la interconsulta
    public function storeRespuestaInterconsulta(Request $request){
               
        $interconsulta = \App\Interconsulta::where('ID_INTERCONSULTA', $request->input('cod_interconsulta'))->first();
        
        if($interconsulta != null){
            $respuestaInterconsulta = new \App\RespuestaInterconsulta;
            $respuestaInterconsulta->ID_INTERCONSULTA = $request->input('cod_interconsulta');
            $respuestaInterconsulta->ID_PROFESIONAL = 6;
            $respuestaInterconsulta->FECHA = dateNow();
            $respuestaInterconsulta->ID_PACIENTE = $request->input('paciente');
            $respuestaInterconsulta->OBSERVACIONES = $request->input('observaciones');
            $respuestaInterconsulta->save();

            $request->session()->flash('msj_success', 'Respuesta de Interconsulta registrado correctamente.');
            return redirect()->route('atencion_paciente.show', ['id' => $request->input('paciente')]);
        }else{
            $request->session()->flash('msj_error', 'El Código de la Interconsulta no existe.');
            return redirect()->route('atencion_paciente.show', ['id' => $request->input('paciente')]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datos = \App\DatoPaciente::where('ID_PACIENTE', $id)->first();
        return view('atencion_paciente.create')->with('datos', $datos);   
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
