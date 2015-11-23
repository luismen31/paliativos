<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RegistroVisitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('rvd.create');
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
        $rvd = new \App\RegistroVisitaDomiciliaria;
        $rvd->FECHA = $request->input('FECHA');
        $rvd->ID_INSTITUCION = $request->input('ID_INSTITUCION');
        $rvd->ID_EQUIPO_MEDICO = $request->input('ID_EQUIPO_MEDICO');
        $rvd->save();

        return $this->edit($rvd->ID_RVD);

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
        $datos = \App\RegistroVisitaDomiciliaria::find($id);
        return view('rvd.create-details')->with('datos', $datos);
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
        $DatoPaciente = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
        if(\App\DetalleRegistroVisitaDomiciliaria::where('ID_RVD', $id)->where('ID_PACIENTE', $DatoPaciente->ID_PACIENTE)->first()){
            dd('Repetido');//return $this->show($id);
        }else{
            $hora = new \Carbon;
            $ID_TRAZABILIDAD = \App\Trazabilidad::getTrazabilidad($DatoPaciente->ID_PACIENTE);
            $trazabilidad = new \App\Trazabilidad;
            $trazabilidad->ID_TRAZABILIDAD = $ID_TRAZABILIDAD;
            $trazabilidad->ID_PACIENTE = $DatoPaciente->ID_PACIENTE;
            $trazabilidad->FECHA = $hora->format('Y-m-d');
            $trazabilidad->save();

            $ID_PROGRAMA = \App\Categoria::find($request->input('ID_CATEGORIA'))->ID_PROGRAMA;
            $DetalleRVD = new \App\DetalleRegistroVisitaDomiciliaria;
            $DetalleRVD->ID_RVD = $id;
            $DetalleRVD->ID_PACIENTE = $DatoPaciente->ID_PACIENTE;
            $DetalleRVD->ID_TRAZABILIDAD = $ID_TRAZABILIDAD;
            $DetalleRVD->ID_PROGRAMA = $ID_PROGRAMA;
            $DetalleRVD->ID_CATEGORIA = $request->input('ID_CATEGORIA');
            $DetalleRVD->OBSERVACIONES = $request->input('OBSERVACIONES');
            $DetalleRVD->save();

            return $this->edit($id);
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
