<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProfesionalesController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('profesionales.create');
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
        //Funcion para validar datos antes de ser almacenados 
        $prof = new \App\DatoProfesionalSalud;
        $v = $prof->validar($request->all(), 'store');
        if($v){
            return redirect()->back()->withErrors($v)->withInput();
        }

        $Usuario = new \App\User;
        $Usuario->ID_GRUPO_USUARIO =  $request->input('ID_GRUPO_USUARIO');
        $Usuario->CLAVE_ACCESO = \Hash::make($request->input('CLAVE_ACCESO'));
        $Usuario->NO_IDENTIFICACION = $request->input('NO_IDENTIFICACION');
        $Usuario->CLAVE_ENCRYPT = \Crypt::encrypt($request->input('CLAVE_ACCESO'));
        $Usuario->TERMINOS = '0';
        $Usuario->save();
        $ID_USUARIO = \App\User::where('ID_USUARIO', '>', '0')->orderBy('ID_USUARIO', 'desc')->first()->ID_USUARIO;
        
        $ProfesionalSalud = new \App\ProfesionalSalud;
        $ProfesionalSalud->ID_ESPECIALIDAD_MEDICA = $request->input('ID_ESPECIALIDAD_MEDICA');
        $ProfesionalSalud->ID_USUARIO = $ID_USUARIO;
        $ProfesionalSalud->save();
        $ID_PROFESIONAL = \App\ProfesionalSalud::where('ID_PROFESIONAL', '>', '0')->orderBy('ID_PROFESIONAL', 'desc')->first()->ID_PROFESIONAL;

        $DatosProfesionales = new \App\DatoProfesionalSalud;
        $DatosProfesionales->ID_PROFESIONAL = $ID_PROFESIONAL;
        $DatosProfesionales->NO_CEDULA = $request->input('NO_CEDULA');
        $DatosProfesionales->PRIMER_NOMBRE = $request->input('PRIMER_NOMBRE');
        $DatosProfesionales->SEGUNDO_NOMBRE = $request->input('SEGUNDO_NOMBRE');
        $DatosProfesionales->APELLIDO_PATERNO = $request->input('APELLIDO_PATERNO');
        $DatosProfesionales->APELLIDO_MATERNO = $request->input('APELLIDO_MATERNO');
        $DatosProfesionales->NO_IDONEIDAD = $request->input('NO_IDONEIDAD');
        $DatosProfesionales->NO_REGISTRO = $request->input('NO_REGISTRO');
        $DatosProfesionales->TELEFONO_CASA = $request->input('TELEFONO_CASA');
        $DatosProfesionales->TELEFONO_CELULAR = $request->input('TELEFONO_CELULAR');
        $DatosProfesionales->E_MAIL = $request->input('E_MAIL');
        $DatosProfesionales->save();

        $DatosAutenticacion = new \App\DatoAutenticacionUsuario;
        $DatosAutenticacion->ID_USUARIO = $ID_USUARIO;
        $DatosAutenticacion->ID_PREGUNTA = $request->input('ID_PREGUNTA');
        $DatosAutenticacion->RESPUESTA = $request->input('RESPUESTA');
        $DatosAutenticacion->TELEFONO_PREFERENCIAL = $request->input('TELEFONO_CELULAR');
        $DatosAutenticacion->E_MAIL_PREFERENCIAL = $request->input('E_MAIL');
        $DatosAutenticacion->save();

        if($request->input('PREFERENCIA_RECUPERACION') == '1'){
            $pregunta = 1;
            $correo = 0;            
        }else{
            $pregunta = 0;
            $correo = 1;            
        }

        $PreferenciasRecuperacion = new \App\PreferenciaRecuperacionAcceso;
        $PreferenciasRecuperacion->ID_USUARIO = $ID_USUARIO;
        $PreferenciasRecuperacion->USAR_PREGUNTA_SEGURIDAD = $pregunta;
        $PreferenciasRecuperacion->USAR_TELEFONO_PREFERENCIAL = 0;
        $PreferenciasRecuperacion->USAR_EMAIL_PREFERENCIAL = $correo;
        $PreferenciasRecuperacion->save();

        \Session::flash('mensaje', 'Profesional "'. $request->input('PRIMER_NOMBRE').' '.$request->input('APELLIDO_PATERNO').'", se registró exitosamente');
        return redirect()->route('profesionales.index');
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

    public function editProfesional(Request $request){

        $v = \Validator::make($request->all(), ['search' => 'required']);
        if($v->fails()){
            return redirect()->route('profesionales.index')->withErrors($v);
        }

        $DatosProfesionales = \App\DatoProfesionalSalud::where('NO_CEDULA', $request->input('search'))->first();
        $ProfesionalSalud = \App\ProfesionalSalud::where('ID_PROFESIONAL', $DatosProfesionales->ID_PROFESIONAL)->first();
        $ID_USUARIO = $ProfesionalSalud->ID_USUARIO;
        $Usuario = \App\User::where('ID_USUARIO', $ID_USUARIO)->first();
        $PreferenciasRecuperacion = \App\PreferenciaRecuperacionAcceso::where('ID_USUARIO', $ID_USUARIO)->first();
        $DatosAutenticacion = \App\DatoAutenticacionUsuario::where('ID_USUARIO', $ID_USUARIO)->first();
        $DatosProfesionales->ID_ESPECIALIDAD_MEDICA = $ProfesionalSalud->ID_ESPECIALIDAD_MEDICA;
        $DatosProfesionales->ID_GRUPO_USUARIO = $Usuario->ID_GRUPO_USUARIO;
        $DatosProfesionales->NO_IDENTIFICACION = $Usuario->NO_IDENTIFICACION;
        if($PreferenciasRecuperacion->USAR_PREGUNTA_SEGURIDAD == 1){
            $PREFERENCIA_RECUPERACION = '1';
        }elseif($PreferenciasRecuperacion->USAR_EMAIL_PREFERENCIAL == 1){
            $PREFERENCIA_RECUPERACION = '3';
        }else{
            $PREFERENCIA_RECUPERACION = '0';
        }
        $DatosProfesionales->PREFERENCIA_RECUPERACION = $PREFERENCIA_RECUPERACION;
        $DatosProfesionales->ID_PREGUNTA = $DatosAutenticacion->ID_PREGUNTA;
        $DatosProfesionales->RESPUESTA = $DatosAutenticacion->RESPUESTA;
        return view('profesionales.edit')->with('datos', $DatosProfesionales);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    //Funcion para devolver a la vista con los datos solicitados y errores generados.
    public function errorUpdate($id, $errors)
    {
        $DatosProfesionales = \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $id)->first();
        $ProfesionalSalud = \App\ProfesionalSalud::where('ID_PROFESIONAL', $id)->first();
        $ID_USUARIO = $ProfesionalSalud->ID_USUARIO;
        $Usuario = \App\User::where('ID_USUARIO', $ID_USUARIO)->first();
        $PreferenciasRecuperacion = \App\PreferenciaRecuperacionAcceso::where('ID_USUARIO', $ID_USUARIO)->first();
        $DatosAutenticacion = \App\DatoAutenticacionUsuario::where('ID_USUARIO', $ID_USUARIO)->first();
        $DatosProfesionales->ID_ESPECIALIDAD_MEDICA = $ProfesionalSalud->ID_ESPECIALIDAD_MEDICA;
        $DatosProfesionales->ID_GRUPO_USUARIO = $Usuario->ID_GRUPO_USUARIO;
        $DatosProfesionales->NO_IDENTIFICACION = $Usuario->NO_IDENTIFICACION;
        if($PreferenciasRecuperacion->USAR_PREGUNTA_SEGURIDAD == 1){
            $PREFERENCIA_RECUPERACION = '1';
        }elseif($PreferenciasRecuperacion->USAR_EMAIL_PREFERENCIAL == 1){
            $PREFERENCIA_RECUPERACION = '3';
        }else{
            $PREFERENCIA_RECUPERACION = '0';
        }
        $DatosProfesionales->PREFERENCIA_RECUPERACION = $PREFERENCIA_RECUPERACION;
        $DatosProfesionales->ID_PREGUNTA = $DatosAutenticacion->ID_PREGUNTA;
        $DatosProfesionales->RESPUESTA = $DatosAutenticacion->RESPUESTA;

        return view('profesionales.edit')->with('datos', $DatosProfesionales)->with('errors', $errors);
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
        //Validamos los datos instanciando el modelo
        $prof = new \App\DatoProfesionalSalud;
        $v = $prof->validar($request->all(), 'update', $id);
        if($v){
            //llamamos la funcion errorUpdate enviando el $id y los errores obtenidos
            return $this->errorUpdate($id, $v->errors());
        }
        $DatosProfesionales = \App\DatoProfesionalSalud::find($id);
        $DatosProfesionales->NO_CEDULA = $request->input('NO_CEDULA');
        $DatosProfesionales->PRIMER_NOMBRE = $request->input('PRIMER_NOMBRE');
        $DatosProfesionales->SEGUNDO_NOMBRE = $request->input('SEGUNDO_NOMBRE');
        $DatosProfesionales->APELLIDO_PATERNO = $request->input('APELLIDO_PATERNO');
        $DatosProfesionales->APELLIDO_MATERNO = $request->input('APELLIDO_MATERNO');
        $DatosProfesionales->NO_IDONEIDAD = $request->input('NO_IDONEIDAD');
        $DatosProfesionales->NO_REGISTRO = $request->input('NO_REGISTRO');
        $DatosProfesionales->TELEFONO_CASA = $request->input('TELEFONO_CASA');
        $DatosProfesionales->TELEFONO_CELULAR = $request->input('TELEFONO_CELULAR');
        $DatosProfesionales->E_MAIL = $request->input('E_MAIL');
        $DatosProfesionales->save();

        $ProfesionalSalud = \App\ProfesionalSalud::find($id);
        $ProfesionalSalud->ID_ESPECIALIDAD_MEDICA = $request->input('ID_ESPECIALIDAD_MEDICA');
        $ProfesionalSalud->save();

        $ID_USUARIO = \App\ProfesionalSalud::where('ID_PROFESIONAL', $id)->first()->ID_USUARIO;
        $Usuario = \App\User::find($ID_USUARIO);
        $Usuario->NO_IDENTIFICACION = $request->input('NO_IDENTIFICACION');
        if(!empty($request->input('CLAVE_ACCESO'))){
            $Usuario->CLAVE_ACCESSO = \Hash::make($request->input('CLAVE_ACCESO'));
            $Usuario->CLAVE_ENCRYPT = \Crypt::encrypt($request->input('CLAVE_ACCESO'));
        }
        $Usuario->ID_GRUPO_USUARIO = $request->input('ID_GRUPO_USUARIO');
        $Usuario->save();

        if($request->input('PREFERENCIA_RECUPERACION') == '1'){
            $pregunta = 1;
            $correo = 0;            
        }else{
            $pregunta = 0;
            $correo = 1;            
        }

        $PreferenciasRecuperacion = \App\PreferenciaRecuperacionAcceso::find($ID_USUARIO);
        $PreferenciasRecuperacion->USAR_PREGUNTA_SEGURIDAD = $pregunta;
        $PreferenciasRecuperacion->USAR_TELEFONO_PREFERENCIAL = 0;
        $PreferenciasRecuperacion->USAR_EMAIL_PREFERENCIAL = $correo;
        $PreferenciasRecuperacion->save();

        $DatosAutenticacion = \App\DatoAutenticacionUsuario::find($ID_USUARIO);
        $DatosAutenticacion->ID_PREGUNTA = $request->input('ID_PREGUNTA');
        $DatosAutenticacion->RESPUESTA = $request->input('RESPUESTA');
        $DatosAutenticacion->TELEFONO_PREFERENCIAL = $request->input('TELEFONO_CELULAR');
        $DatosAutenticacion->E_MAIL_PREFERENCIAL = $request->input('E_MAIL');
        $DatosAutenticacion->save();

        \Session::flash('mensaje', 'Profesional "'. $request->input('PRIMER_NOMBRE').' '.$request->input('APELLIDO_PATERNO').'", se edito exitosamente');
        return redirect()->route('profesionales.index');
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
