<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InterconsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('interconsulta.index');
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
            return redirect()->route('interconsulta.index')->withErrors($v);
        }

        $datos = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
        if ($datos == null) {
            \Session::flash('msj_error', 'Solo puede ingresar una cédula del paciente');
            return redirect()->route('interconsulta.index');
        }

        return view('interconsulta.create')->with('datos', $datos);   
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
            'fecha_interconsulta' => ['required', 'date', 'date_format:Y/m/d'],
            'observaciones' => 'required',
        ];

        $v = \Validator::make($request->all(), $rules);
        if($v->fails()){
            return $this->show($request->input('paciente'))->withErrors($v);
        }

        $interconsulta = new \App\Interconsulta;
        $interconsulta->ID_PROFESIONAL = 6; //CAMBIARRR POR PROF LOGUEADO
        $interconsulta->ID_PACIENTE = $request->input('paciente');
        $interconsulta->FECHA = $request->input('fecha_interconsulta');
        $interconsulta->OBSERVACIONES = $request->input('observaciones');
        $interconsulta->save();

        $request->session()->flash('msj_success', 'La interconsulta se ha registrado correctamente.');
        return redirect()->route('interconsulta.show', ['id' => $request->input('paciente')]);
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
        return view('interconsulta.create')->with('datos', $datos);   
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
