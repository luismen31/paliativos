<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('agenda/create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {  
        $paciente = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
        if( \App\CitaMedica::where('FECHA', $request->input('FECHA'))->where('ID_PACIENTE', $paciente->ID_PACIENTE)->where('RESERVADA', '1')->first() OR \App\CitaMedica::where('FECHA', $request->input('FECHA'))->where('HORA', $request->input('HORA'))->where('ID_EQUIPO_MEDICO', $request->input('ID_EQUIPO_MEDICO'))->where('RESERVADA', '1')->first()){
            return 'Ya existe este paciente para esta fecha o una cita para esta hora.';
        }else{
            $profesional = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional'))->first();
            $agenda = new \App\CitaMedica;
            $agenda->ID_PACIENTE = $paciente->ID_PACIENTE;
            $agenda->ID_PROFESIONAL = $profesional->ID_PROFESIONAL;
            $agenda->ID_SERVICIO = $request->input('ID_SERVICIO');
            $agenda->ID_EQUIPO_MEDICO = $request->ID_EQUIPO_MEDICO;
            $agenda->FECHA = $request->input('FECHA');
            $agenda->HORA = $request->input('HORA');
            $agenda->RESERVADA = '1';
            $agenda->save();
            return $this->show($agenda->ID_CITA);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $fecha = \App\CitaMedica::find($id)->FECHA;
        $citas = \App\CitaMedica::where('FECHA', $fecha)->get();
        $datos = new \App\CitaMedica;
        return view('agenda.create')->with('citas', $citas);
    }

    public function verAgenda(){
        return view('agenda.veragenda');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $datos = \App\CitaMedica::find($id);
        $datos->search_profesional = \App\DatoProfesionalSalud::find($datos->ID_PROFESIONAL)->NO_CEDULA;
        $datos->search_paciente = \App\DatoPaciente::find($datos->ID_PACIENTE)->NO_CEDULA;
        return view('agenda.edit')->with('datos', $datos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $agenda = \App\CitaMedica::find($id);
        if( \App\CitaMedica::where('FECHA', $request->input('FECHA'))->where('ID_EQUIPO_MEDICO', $request->input('ID_EQUIPO_MEDICO'))->where('HORA', $request->input('HORA'))->where('ID_PACIENTE', '<>', $agenda->ID_PACIENTE)->where('RESERVADA', '1')->first() AND  $request->input('RESERVADA') == '1' ){
            return 'Ya existe una cita para esta fecha y hora.';
        }else{
            $paciente = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
            $profesional = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional'))->first();
            $agenda->ID_PACIENTE = $paciente->ID_PACIENTE;
            $agenda->ID_PROFESIONAL = $profesional->ID_PROFESIONAL;
            $agenda->ID_SERVICIO = $request->input('ID_SERVICIO');
            $agenda->ID_EQUIPO_MEDICO = $request->ID_EQUIPO_MEDICO;
            $agenda->FECHA = $request->input('FECHA');
            $agenda->HORA = $request->input('HORA');
            $agenda->RESERVADA = $request->input('RESERVADA');
            $agenda->save();
            return redirect()->route('agenda.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
