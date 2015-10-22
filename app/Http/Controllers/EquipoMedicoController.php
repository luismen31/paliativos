<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EquipoMedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('equipo-medico.create');
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
        //validar si el campo "search" va vacio
        $v = \Validator::make($request->all(), ['search_profesional' => 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar.');
            return redirect()->route('equipo-medico.index')->withErrors($v);
        }

        $DatosProfesionales = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional'))->first();
        //Si es nulo retorna un mensaje de error
        if($DatosProfesionales == null){
            \Session::flash('msj_error', 'Solo puede ingresar una cédula válida para el profesional');
            return redirect()->route('equipo-medico.index');
        }

        $id_especialidad = \App\ProfesionalSalud::where('ID_PROFESIONAL', $DatosProfesionales->ID_PROFESIONAL)->first()->ID_ESPECIALIDAD_MEDICA;

        $equipo = new \App\EquipoMedico;
        $equipo->save();

        $detalle_equipo = new \App\DetalleEquipoMedico;
        $detalle_equipo->ID_EQUIPO_MEDICO = $equipo->ID_EQUIPO_MEDICO;
        $detalle_equipo->ID_PROFESIONAL = $DatosProfesionales->ID_PROFESIONAL;
        $detalle_equipo->ID_ESPECIALIDAD_MEDICA = $id_especialidad;
        $detalle_equipo->save();

        \Session::flash('msj_success', 'Se ha registrado exitosamente el Equipo Medico: #'.$equipo->ID_EQUIPO_MEDICO);
        return redirect()->route('equipo-medico.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $equipos = \App\DetalleEquipoMedico::where('ID_EQUIPO_MEDICO', $id)->get();
        return view('equipo-medico.create')->with('equipos', $equipos);
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
        //validar si el campo "search_profesional" va vacio
        $v = \Validator::make($request->all(), ['search_profesional' => 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar.');
            return redirect()->route('equipo-medico.index')->withErrors($v);
        }

        $DatosProfesionales = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search_profesional'))->first();
        //Si es nulo retorna un mensaje de error
        if($DatosProfesionales == null){
            \Session::flash('msj_error', 'Solo puede ingresar una cédula válida para el profesional');
            return redirect()->route('equipo-medico.index');
        }

        //Verifica si ya existe el profesional en el equipo
        if(\App\DetalleEquipoMedico::where('ID_PROFESIONAL', $DatosProfesionales->ID_PROFESIONAL)->where('ID_EQUIPO_MEDICO', $id)->first()){
            \Session::flash('msj_error', 'Este profesional ya existe en el Equipo Medico #'.$id);
            return redirect()->route('equipo-medico.edit', $id);
        }

        $id_especialidad = \App\ProfesionalSalud::where('ID_PROFESIONAL', $DatosProfesionales->ID_PROFESIONAL)->first()->ID_ESPECIALIDAD_MEDICA;

        $detalle_equipo = new \App\DetalleEquipoMedico;
        $detalle_equipo->ID_EQUIPO_MEDICO = $id;
        $detalle_equipo->ID_PROFESIONAL = $DatosProfesionales->ID_PROFESIONAL;
        $detalle_equipo->ID_ESPECIALIDAD_MEDICA = $id_especialidad;
        $detalle_equipo->save();

        \Session::flash('msj_success', 'Se ha agregado exitosamente el profesional "'.$DatosProfesionales->PRIMER_NOMBRE.' '.$DatosProfesionales->APELLIDO_PATERNO.'" al Equipo Medico #'.$id);
        return redirect()->route('equipo-medico.edit', $id);
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
