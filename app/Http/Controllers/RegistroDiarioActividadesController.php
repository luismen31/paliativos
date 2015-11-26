<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RegistroDiarioActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return 'Entro';
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
        $rda = new \App\RegistroDiarioActividad;
        $rda->FECHA = $request->input('FECHA');
        $rda->ID_EQUIPO_MEDICO = $request->input('ID_EQUIPO_MEDICO');
        $rda->ID_INSTITUCION = $request->input('ID_INSTITUCION');
        $rda->TIPO_ATENCION = $request->input('TIPO_ATENCION');
        $rda->save();

         return redirect()->route('rda.edit', $rda->ID_RDA);
    }

    public function storeDetails(Request $request)
    {
        $data = $request->all();

        $diagnostico = new \App\Diagnostico;
        $diagnostico->save();

        $ID_DIAGNOSTICO = $diagnostico->ID_DIAGNOSTICO;   
        $ID_PROFESIONAL = \App\ProfesionalSalud::where('ID_USUARIO', \Auth::user()->ID_USUARIO)->first()->ID_PROFESIONAL;

        $detalle_diagnostico = new \App\DetalleDiagnostico;
        $detalle_diagnostico->ID_DIAGNOSTICO = $ID_DIAGNOSTICO;
        $detalle_diagnostico->ID_CIE10 = $data['search_cie10'];
        $detalle_diagnostico->ID_FRECUENCIA = $data['ID_FRECUENCIA_DIAG'];
        $detalle_diagnostico->ID_PROFESIONAL = $ID_PROFESIONAL;
        $detalle_diagnostico->OBSERVACION = $data['OBSERVACION'];
        $detalle_diagnostico->save();

        $actividad = new \App\Actividad;
        $actividad->ACTIVIDAD = $data['ACTIVIDAD'];
        $actividad->ID_FRECUENCIA = $data['ID_FRECUENCIA_OTRO'];
        $actividad->ID_PROFESIONAL = $ID_PROFESIONAL;
        $actividad->save();
        
        $ID_PACIENTE = \App\DatoPaciente::where('NO_CEDULA', $data['search_paciente'])->first()->ID_PACIENTE;
        $detalle_rda = new \App\DetalleRda;
        $detalle_rda->ID_RDA = $data['ID_RDA'];
        $detalle_rda->ID_ZONA = $data['ID_ZONA'];
        $detalle_rda->ID_PACIENTE = $ID_PACIENTE;
        $detalle_rda->ID_TRAZABILIDAD = \App\Trazabilidad::getTrazabilidad($ID_PACIENTE);
        $detalle_rda->ID_FRECUENCIA = $data['ID_FRECUENCIA'];
        $detalle_rda->ID_TIPO_ATENCION = $data['ID_TIPO_ATENCION'];
        $detalle_rda->ID_DIAGNOSTICO = $ID_DIAGNOSTICO;
        $detalle_rda->ID_ACTIVIDAD = $actividad->ID_ACTIVIDAD;
        $detalle_rda->ID_ESTADO_PACIENTE = $data['ID_ESTADO_PACIENTE'];
        $detalle_rda->REFERIDO_PACIENTE = $data['REFERIDO'];
        $detalle_rda->save();

        return redirect()->route('rda.edit', $data['ID_RDA']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('rda.create')->with('id', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rda = \App\RegistroDiarioActividad::find($id);
        return view('rda.create-details')->with('rda', $rda);
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
