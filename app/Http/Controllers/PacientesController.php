<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SearchAutocompleteRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('pacientes.create');
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
        $fecha = explode('/', $request->input('FECHA_NACIMIENTO'));
        $Usuario = new \App\User;
        if(empty($request->input('NO_IDENTIFICACION'))){
            $Usuario->NO_IDENTIFICACION = $request->input('NO_CEDULA');
        }else{
            $Usuario->NO_IDENTIFICACION = $request->input('NO_IDENTIFICACION');
        }
        if(empty($request->input('CLAVE_ACCESO'))){
            $Usuario->CLAVE_ACCESO = \Hash::make($request->input('PRIMER_NOMBRE').'.'.$request->input('APELLIDO_PATERNO'));
            $Usuario->CLAVE_ENCRYPT = \Crypt::encrypt($request->input('PRIMER_NOMBRE').'.'.$request->input('APELLIDO_PATERNO'));
        }else{
            $Usuario->CLAVE_ACCESO = $request->input('CLAVE_ACCESO');
            $Usuario->CLAVE_ENCRYPT = \Crypt::encrypt($request->input('CLAVE_ACCESO'));
        }
        $Usuario->ID_GRUPO_USUARIO = '2';
        $Usuario->TERMINOS = '0';
        $Usuario->save();
        $ID_USUARIO = \App\User::where('ID_USUARIO', '>', '0')->orderBy('ID_USUARIO', 'desc')->first()->ID_USUARIO;

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

        $ResidenciaHabitual = new \App\ResidenciaHabitual;
        $ResidenciaHabitual->ID_PROVINCIA = $request->input('ID_PROVINCIA');
        $ResidenciaHabitual->ID_DISTRITO = $request->input('ID_DISTRITO');
        $ResidenciaHabitual->ID_CORREGIMIENTO = $request->input('ID_CORREGIMIENTO');
        $ResidenciaHabitual->ID_ZONA = $request->input('ID_ZONA');
        $ResidenciaHabitual->DETALLE = $request->input('DETALLE');
        $ResidenciaHabitual->save();
        $ID_RESIDENCIA_HABITUAL = \App\ResidenciaHabitual::where('ID_RESIDENCIA_HABITUAL', '>', '0')->orderBy('ID_RESIDENCIA_HABITUAL', 'desc')->first()->ID_RESIDENCIA_HABITUAL;


        $DatosPaciente = new \App\DatoPaciente;
        $DatosPaciente->NO_CEDULA = $request->input('NO_CEDULA');
        $DatosPaciente->SEGURO_SOCIAL = $request->input('NO_CEDULA');
        $DatosPaciente->PRIMER_NOMBRE = $request->input('PRIMER_NOMBRE');
        $DatosPaciente->SEGUNDO_NOMBRE = $request->input('SEGUNDO_NOMBRE');
        $DatosPaciente->APELLIDO_PATERNO = $request->input('APELLIDO_PATERNO');
        $DatosPaciente->APELLIDO_MATERNO = $request->input('APELLIDO_MATERNO');
        $DatosPaciente->ID_ESTADO_CIVIL = $request->input('ID_ESTADO_CIVIL');
        $DatosPaciente->ID_SEXO = $request->input('ID_SEXO');
        $DatosPaciente->FECHA_NACIMIENTO = $request->input('FECHA_NACIMIENTO');
        $DatosPaciente->LUGAR_NACIMIENTO = $request->input('LUGAR_NACIMIENTO');
        $DatosPaciente->EDAD_PACIENTE = Carbon::createFromDate($fecha[0], $fecha[1], $fecha[2])->age;
        $DatosPaciente->ID_ETNIA = $request->input('ID_ETNIA');
        $DatosPaciente->ID_TIPO_SANGUINEO = $request->input('ID_TIPO_SANGUINEO');
        $DatosPaciente->ID_NACIONALIDAD = $request->input('ID_NACIONALIDAD');
        $DatosPaciente->ID_TIPO_PACIENTE = $request->input('ID_TIPO_PACIENTE');
        $DatosPaciente->TELEFONO_CASA = $request->input('TELEFONO_CASA');
        $DatosPaciente->TELEFONO_CELULAR = $request->input('TELEFONO_CELULAR');
        $DatosPaciente->E_MAIL = $request->input('E_MAIL');
        $DatosPaciente->OCUPACION = $request->input('OCUPACION');
        $DatosPaciente->ID_RESIDENCIA_HABITUAL = $ID_RESIDENCIA_HABITUAL;
        $DatosPaciente->RESIDENCIA_TRANSITORIA = $request->input('RESIDENCIA_TRANSITORIA');
        $DatosPaciente->NOMBRE_PADRE = $request->input('NOMBRE_PADRE');
        $DatosPaciente->NOMBRE_MADRE = $request->input('NOMBRE_MADRE');
        $DatosPaciente->FECHA_INGRESO = $request->input('FECHA_INGRESO');
        $DatosPaciente->CUIDADOR = $request->input('CUIDADOR');
        $DatosPaciente->PARENTEZCO_CUIDADOR = $request->input('PARENTEZCO_CUIDADOR');
        $DatosPaciente->TIPO_SEGURO = $request->input('TIPO_SEGURO');
        $DatosPaciente->save();
        $ID_PACIENTE = \App\DatoPaciente::where('ID_PACIENTE', '>', '0')->orderBy('ID_PACIENTE', 'desc')->first()->ID_PACIENTE;

        $Paciente = new \App\Paciente;
        $Paciente->ID_USUARIO = $ID_USUARIO;
        $Paciente->ID_PACIENTE = $ID_PACIENTE;
        $Paciente->save();

        return redirect()->route('pacientes.index');

    }

    public function editPaciente(SearchAutocompleteRequest $request){
        if ($validator->fails()) {
            return redirect()->route('pacientes.index')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $DatosPaciente = \App\DatoPaciente::where('NO_CEDULA', $request->input('search'))->first();
        $ID_PACIENTE = $DatosPaciente->ID_PACIENTE;
        $Paciente = \App\Paciente::where('ID_PACIENTE', $DatosPaciente->ID_PACIENTE)->first();
        $ID_USUARIO = $Paciente->ID_USUARIO; 
        $Usuario = \App\User::where('ID_USUARIO', $ID_USUARIO)->first();
        $DatosPaciente->NO_IDENTIFICACION = $Usuario->NO_IDENTIFICACION;
        $PreferenciasRecuperacion = \App\PreferenciaRecuperacionAcceso::where('ID_USUARIO', $ID_USUARIO)->first();
        if($PreferenciasRecuperacion->USAR_PREGUNTA_SEGURIDAD == 1){
            $DatosPaciente->PREFERENCIA_RECUPERACION = 1;
        }else{
            $DatosPaciente->PREFERENCIA_RECUPERACION = 3;
        }
        $DatosAutenticacion = \App\DatoAutenticacionUsuario::where('ID_USUARIO', $ID_USUARIO)->first();
        $DatosPaciente->ID_PREGUNTA = $DatosAutenticacion->ID_PREGUNTA;
        $DatosPaciente->RESPUESTA = $DatosAutenticacion->RESPUESTA;
        $ResidenciaHabitual = \App\ResidenciaHabitual::where('ID_RESIDENCIA_HABITUAL', $DatosPaciente->ID_RESIDENCIA_HABITUAL)->first();
        $DatosPaciente->ID_PROVINCIA = $ResidenciaHabitual->ID_PROVINCIA;
        $DatosPaciente->ID_DISTRITO = $ResidenciaHabitual->ID_DISTRITO;
        $DatosPaciente->ID_CORREGIMIENTO = $ResidenciaHabitual->ID_CORREGIMIENTO;
        $DatosPaciente->ID_ZONA = $ResidenciaHabitual->ID_ZONA;
        $DatosPaciente->DETALLE = $ResidenciaHabitual->DETALLE;
        
        if($request->input('PREFERENCIA_RECUPERACION') == '1'){
            $pregunta = 1;
            $correo = 0;            
        }else{
            $pregunta = 0;
            $correo = 1;            
        }

        $PreferenciasRecuperacion =  \App\PreferenciaRecuperacionAcceso::where('ID_SEGURIDAD', $ID_USUARIO)->first();
        $PreferenciasRecuperacion->USAR_PREGUNTA_SEGURIDAD = $pregunta;
        $PreferenciasRecuperacion->USAR_TELEFONO_PREFERENCIAL = 0;
        $PreferenciasRecuperacion->USAR_EMAIL_PREFERENCIAL = $correo;
        $PreferenciasRecuperacion->save();

        return view('pacientes.edit')->with('datos', $DatosPaciente);
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
        //
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
        $fecha = explode('/', $request->input('FECHA_NACIMIENTO'));
        $DatosPaciente = \App\DatoPaciente::find($id);
        $DatosPaciente->NO_CEDULA = $request->input('NO_CEDULA');
        $DatosPaciente->SEGURO_SOCIAL = $request->input('NO_CEDULA');
        $DatosPaciente->PRIMER_NOMBRE = $request->input('PRIMER_NOMBRE');
        $DatosPaciente->SEGUNDO_NOMBRE = $request->input('SEGUNDO_NOMBRE');
        $DatosPaciente->APELLIDO_PATERNO = $request->input('APELLIDO_PATERNO');
        $DatosPaciente->APELLIDO_MATERNO = $request->input('APELLIDO_MATERNO');
        $DatosPaciente->ID_ESTADO_CIVIL = $request->input('ID_ESTADO_CIVIL');
        $DatosPaciente->ID_SEXO = $request->input('ID_SEXO');
        $DatosPaciente->FECHA_NACIMIENTO = $request->input('FECHA_NACIMIENTO');
        $DatosPaciente->LUGAR_NACIMIENTO = $request->input('LUGAR_NACIMIENTO');
        $DatosPaciente->EDAD_PACIENTE = Carbon::createFromDate($fecha[0], $fecha[1], $fecha[2])->age;
        $DatosPaciente->ID_ETNIA = $request->input('ID_ETNIA');
        $DatosPaciente->ID_TIPO_SANGUINEO = $request->input('ID_TIPO_SANGUINEO');
        $DatosPaciente->ID_NACIONALIDAD = $request->input('ID_NACIONALIDAD');
        $DatosPaciente->ID_TIPO_PACIENTE = $request->input('ID_TIPO_PACIENTE');
        $DatosPaciente->TELEFONO_CASA = $request->input('TELEFONO_CASA');
        $DatosPaciente->TELEFONO_CELULAR = $request->input('TELEFONO_CELULAR');
        $DatosPaciente->E_MAIL = $request->input('E_MAIL');
        $DatosPaciente->OCUPACION = $request->input('OCUPACION');
        $DatosPaciente->ID_RESIDENCIA_HABITUAL = $ID_RESIDENCIA_HABITUAL;
        $DatosPaciente->RESIDENCIA_TRANSITORIA = $request->input('RESIDENCIA_TRANSITORIA');
        $DatosPaciente->NOMBRE_PADRE = $request->input('NOMBRE_PADRE');
        $DatosPaciente->NOMBRE_MADRE = $request->input('NOMBRE_MADRE');
        $DatosPaciente->FECHA_INGRESO = $request->input('FECHA_INGRESO');
        $DatosPaciente->CUIDADOR = $request->input('CUIDADOR');
        $DatosPaciente->PARENTEZCO_CUIDADOR = $request->input('PARENTEZCO_CUIDADOR');
        $DatosPaciente->TIPO_SEGURO = $request->input('TIPO_SEGURO');
        $DatosPaciente->save();  

        $ID_USUARIO = \App\Paciente::where('ID_PACIENTE', $id)->first()->ID_USUARIO;
        $ID_RESIDENCIA_HABITUAL = \App\DatoPaciente::where('ID_PACIENTE', $id)->first()->ID_RESIDENCIA_HABITUAL;
        $Usuario = \App\User::find($ID_USUARIO);
        $Usuario->NO_IDENTIFICACION = $request->input('NO_IDENTIFICACION');
        if(!empty($request->input('CLAVE_ACCESO'))){
            $Usuario->CLAVE_ACCESO = \Hash::make($request->input('CLAVE_ACCESO'));
            $Usuario->CLAVE_ENCRYPT = \Crypt::encrypt($request->input('CLAVE_ACCESO'));
        }
        $Usuario->save();


        $DatosAutenticacion = \App\DatoAutenticacionUsuario::find($ID_USUARIO);
        $DatosAutenticacion->ID_PREGUNTA = $request->input('ID_PREGUNTA');
        $DatosAutenticacion->RESPUESTA = $request->input('RESPUESTA');
        $DatosAutenticacion->TELEFONO_PREFERENCIAL = $request->input('TELEFONO_CELULAR');
        $DatosAutenticacion->E_MAIL_PREFERENCIAL = $request->input('E_MAIL');
        $DatosAutenticacion->save();

        $ResidenciaHabitual = \App\ResidenciaHabitual::find($ID_RESIDENCIA_HABITUAL);
        $ResidenciaHabitual->ID_PROVINCIA = $request->input('ID_PROVINCIA');
        $ResidenciaHabitual->ID_DISTRITO = $request->input('ID_DISTRITO');
        $ResidenciaHabitual->ID_CORREGIMIENTO = $request->input('ID_CORREGIMIENTO');
        $ResidenciaHabitual->ID_ZONA = $request->input('ID_ZONA');
        $ResidenciaHabitual->DETALLE = $request->input('DETALLE');
        $ResidenciaHabitual->save();

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
