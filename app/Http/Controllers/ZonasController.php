<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {       
        return view('zonas.create');
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
        $v = \Validator::make($request->all(), ['ZONA'=> 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar');
            return redirect()->route('zona.index')->withErrors($v)->withInput();
        }

        $Zona = new \App\Zona;
        $Zona->ZONA = $request->input('ZONA');
        $Zona->save();

        \Session::flash('msj_success', 'Se ha agregado correctamente la zona: '.$request->input('ZONA'));
        return redirect()->route('zona.index');
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
        $Zona = \App\Zona::find($id);

        return view('zonas.edit')->with('datos', $Zona);
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
        $v = \Validator::make($request->all(), ['ZONA'=> 'required']);
        if($v->fails()){
            \Session::flash('msj_error', 'Ha ocurrido un error, proceda a verificar');
            return redirect()->route('zona.edit', ['id' => $id])->withErrors($v);
        }

        $Zona = \App\Zona::find($id);
        $Zona->ZONA = $request->input('ZONA');
        $Zona->save();

        \Session::flash('msj_success', 'Se ha editado correctamente la zona: '.$request->input('ZONA'));
        return redirect()->route('zona.index');
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
