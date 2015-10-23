<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('salas.create');
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
        $v = \Validator::make($request->all(), ['SALA'=> 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar');
            return redirect()->route('salas.index')->withErrors($v)->withInput();
        }

        $Salas = new \App\Sala;
        $Salas->SALA = $request->input('SALA');
        $Salas->save();

        \Session::flash('msj_success', 'Se ha almacenado correctamente la sala: '.$request->input('SALA'));
        return redirect()->route('salas.index');
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
        $Salas = \App\Sala::find($id);

        return view('salas.edit')->with('datos', $Salas);
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
        $v = \Validator::make($request->all(), ['SALA'=> 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar');
            return redirect()->route('salas.edit', ['id' => $id])->withErrors($v);
        }

        $Salas = \App\Sala::find($id);
        $Salas->SALA = $request->input('SALA');
        $Salas->save();

        \Session::flash('msj_success', 'Se ha editado correctamente la sala: '.$request->input('SALA'));
        return redirect()->route('salas.index');
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
