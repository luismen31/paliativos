<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServiciosMedicosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('servicios-medicos.create');
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
        //Si no envia nada envia un error.
        $v = \Validator::make($request->all(), ['DESCRIPCION'=> 'required', 'ID_TIEMPO_ATENCION' => 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar');
            return redirect()->route('servicios.index')->withErrors($v)->withInput();
        }

        $Servicios = new \App\ServicioMedico;
        $Servicios->DESCRIPCION = $request->input('DESCRIPCION');
        $Servicios->ID_TIEMPO_ATENCION = $request->input('ID_TIEMPO_ATENCION');
        $Servicios->save();

        \Session::flash('msj_success', 'Se ha agregado correctamente el servicio médico: '.$request->input('DESCRIPCION'));
        return redirect()->route('servicios.index');
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
        $Servicios = \App\ServicioMedico::find($id);

        return view('servicios-medicos.edit')->with('datos', $Servicios);
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
        //Si no envia nada envia un error.
        $v = \Validator::make($request->all(), ['DESCRIPCION'=> 'required', 'ID_TIEMPO_ATENCION' => 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar');
            return redirect()->route('servicios.edit', ['id' => $id])->withErrors($v);
        }
        $Servicios = \App\ServicioMedico::find($id);
        $Servicios->DESCRIPCION = $request->input('DESCRIPCION');
        $Servicios->ID_TIEMPO_ATENCION = $request->input('ID_TIEMPO_ATENCION');
        $Servicios->save();

        \Session::flash('msj_success', 'Se ha editado correctamente el servicio médico: '.$request->input('DESCRIPCION'));
        return redirect()->route('servicios.index');
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
