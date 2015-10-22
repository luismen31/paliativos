<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CamasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('camas.create');
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
        $v = \Validator::make($request->all(), ['CAMA' => 'required', 'ID_SALA'=> 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar');
            return redirect()->route('camas.index')->withErrors($v)->withInput();
        }

        $Cama = new \App\Cama;
        $Cama->CAMA = $request->input('CAMA');
        $Cama->ID_SALA = $request->input('ID_SALA');
        $Cama->save();

        \Session::flash('msj_success', 'Se ha almacenado correctamente la cama: '.$request->input('CAMA'));
        return redirect()->route('camas.index');
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
        $Cama = \App\Cama::find($id);

        return view('camas.edit')->with('datos', $Cama);
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
        $v = \Validator::make($request->all(), ['CAMA' => 'required', 'ID_SALA'=> 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar');
            return redirect()->route('camas.edit', ['id' => $id])->withErrors($v);
        }

        $Cama = \App\Cama::find($id);
        $Cama->CAMA = $request->input('CAMA');
        $Cama->ID_SALA = $request->input('ID_SALA');
        $Cama->save();

        \Session::flash('msj_success', 'Se ha actualizado correctamente la cama: '.$request->input('CAMA'));
        return redirect()->route('camas.index');
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
