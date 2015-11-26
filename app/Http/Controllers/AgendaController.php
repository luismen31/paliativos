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
        //obtiene el arreglo de horas del helper creado.
        $hora = horas();
        //Obtiene la hora respecto a la posicion del arreglo enviado por el form.
        $getHora = array_pull($hora, $request->input('HORA'));
        $paciente = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
        if( \App\CitaMedica::where('FECHA', $request->input('FECHA'))->where('ID_PACIENTE', $paciente->ID_PACIENTE)->where('RESERVADA', '1')->first() OR \App\CitaMedica::where('FECHA', $request->input('FECHA'))->where('HORA', $getHora)->where('ID_EQUIPO_MEDICO', $request->input('ID_EQUIPO_MEDICO'))->where('RESERVADA', '1')->first()){
            \Session::flash('msg_error', 'Ya existe este paciente para esta fecha o una cita para esta hora.');
            
            return redirect()->back();
        }else{
            
            $profesional = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional'))->first();
            $agenda = new \App\CitaMedica;
            $agenda->ID_PACIENTE = $paciente->ID_PACIENTE;
            $agenda->ID_PROFESIONAL = $profesional->ID_PROFESIONAL;
            $agenda->ID_SERVICIO = $request->input('ID_SERVICIO');
            $agenda->ID_EQUIPO_MEDICO = $request->ID_EQUIPO_MEDICO;
            $agenda->FECHA = $request->input('FECHA');
            $agenda->HORA = $getHora;
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

    //Funcion para ver la agenda de citas
    public function verAgenda(){
        return view('agenda.veragenda');
    }

    //Funcion para crear nueva cita.
    public function crearCita(Request $request){
        $rules = [
            'hora' => 'required',
            'fecha' => 'required'
        ];

        $v = \Validator::make($request->all(), $rules);        
        if($v->fails()){
            \Session::flash('msg_error', 'Envío de datos erróneo');
            return $this->verAgenda();
        }

        return view('agenda/create')->with('horaCita', $request->input('hora'))->with('fechaCita', $request->input('fecha'));
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
        $citas = \App\CitaMedica::where('FECHA', $datos->FECHA)->get();
        return view('agenda.edit')->with('datos', $datos)->with('citas', $citas);
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
        //obtiene el arreglo de horas del helper creado.
        $hora = horas();
        //Obtiene la hora respecto a la posicion del arreglo enviado por el form.
        $getHora = array_pull($hora, $request->input('HORA'));
        $agenda = \App\CitaMedica::find($id);
        
        if( \App\CitaMedica::where('FECHA', $request->input('FECHA'))->where('ID_EQUIPO_MEDICO', $request->input('ID_EQUIPO_MEDICO'))->where('HORA', $getHora)->where('ID_PACIENTE', '<>', $agenda->ID_PACIENTE)->where('RESERVADA', '1')->first() AND  $request->input('RESERVADA') == '1' ){
            \Session::flash('msg_error', 'Ya existe una cita para esta fecha y hora.');

            return redirect()->back();
        }else{
            $paciente = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
            $profesional = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional'))->first();
            $agenda->ID_PACIENTE = $paciente->ID_PACIENTE;
            $agenda->ID_PROFESIONAL = $profesional->ID_PROFESIONAL;
            $agenda->ID_SERVICIO = $request->input('ID_SERVICIO');
            $agenda->ID_EQUIPO_MEDICO = $request->ID_EQUIPO_MEDICO;
            $agenda->FECHA = $request->input('FECHA');
            $agenda->HORA = $getHora;
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
