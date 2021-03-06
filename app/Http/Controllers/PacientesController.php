<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
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
        if(\Auth::user()->ID_GRUPO_USUARIO == 5){
            return view('pacientes.paciente-soap');
        }
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
        $PACIENTE = new \App\DatoPaciente;
        $v = $PACIENTE->validar($request->all(), 'store');        
        if($v){
            return redirect()->back()->withErrors($v)->withInput();
        }

        $fecha = explode('-', $request->input('FECHA_NACIMIENTO'));
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
            $Usuario->CLAVE_ACCESO = \Hash::make($request->input('CLAVE_ACCESO'));
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
        $DatosPaciente->EDAD_PACIENTE = calcular_edad($fecha);
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

        \Session::flash('mensaje', 'El paciente "'. $request->input('PRIMER_NOMBRE').' '.$request->input('APELLIDO_PATERNO').'", se registró exitosamente');
        return redirect()->route('pacientes.index');

    }

    public function editPaciente(Request $request){

        $v = \Validator::make($request->all(), ['search_paciente' => 'required']);
        if($v->fails()){
            return redirect()->route('pacientes.index')->withErrors($v);
        }

        $DatosPaciente = \App\DatoPaciente::where('NO_CEDULA', $request->input('search_paciente'))->first();
        if ($DatosPaciente == null) {
            \Session::flash('msj_error', 'Solo puede ingresar una cédula del paciente');
            return redirect()->route('pacientes.index');
        }
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

        return view('pacientes.edit')->with('datos', $DatosPaciente);
    }

    //Agregar paciente para SOAP
    public function addPacienteSoap(Request $request){
        $PACIENTE = new \App\DatoPaciente;
        $v = $PACIENTE->validar($request->all(), 'store');        
        if($v){
            return redirect()->back()->withErrors($v)->withInput();
        }

        $fecha = explode('-', $request->input('FECHA_NACIMIENTO'));
        $Usuario = new \App\User;
        if(empty($request->input('NO_IDENTIFICACION'))){
            $Usuario->NO_IDENTIFICACION = $request->input('NO_CEDULA');
        }else{
            $Usuario->NO_IDENTIFICACION = $request->input('NO_IDENTIFICACION');
        }

        //Si esta vacia la clave de acceso, colocara nombre.apellido como PASSWORD, EJ. juan.perez
        if(empty($request->input('CLAVE_ACCESO'))){
            $Usuario->CLAVE_ACCESO = \Hash::make($request->input('PRIMER_NOMBRE').'.'.$request->input('APELLIDO_PATERNO'));
            $Usuario->CLAVE_ENCRYPT = \Crypt::encrypt($request->input('PRIMER_NOMBRE').'.'.$request->input('APELLIDO_PATERNO'));
        }else{
            $Usuario->CLAVE_ACCESO = \Hash::make($request->input('CLAVE_ACCESO'));
            $Usuario->CLAVE_ENCRYPT = \Crypt::encrypt($request->input('CLAVE_ACCESO'));
        }
        $Usuario->ID_GRUPO_USUARIO = '2';
        $Usuario->TERMINOS = '0';
        $Usuario->save();
        $ID_USUARIO = $Usuario->ID_USUARIO;

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

        if($request->input('tipoResidencia') == 1){
            $resPermanente = $request->input('detalleResidencia');
            $resTransitoria = '';
        }else{
            $resPermanente = '';
            $resTransitoria = $request->input('detalleResidencia');
        }

        $ResidenciaHabitual = new \App\ResidenciaHabitual;
        $ResidenciaHabitual->ID_PROVINCIA = $request->input('ID_PROVINCIA');
        $ResidenciaHabitual->ID_DISTRITO = $request->input('ID_DISTRITO');
        $ResidenciaHabitual->ID_CORREGIMIENTO = $request->input('ID_CORREGIMIENTO');
        $ResidenciaHabitual->ID_ZONA = $request->input('ID_ZONA');
        $ResidenciaHabitual->DETALLE = $resPermanente;
        $ResidenciaHabitual->save();
        $ID_RESIDENCIA_HABITUAL = $ResidenciaHabitual->ID_RESIDENCIA_HABITUAL;

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
        $DatosPaciente->EDAD_PACIENTE = calcular_edad($fecha);
        $DatosPaciente->ID_ETNIA = $request->input('ID_ETNIA');
        $DatosPaciente->ID_TIPO_SANGUINEO = $request->input('ID_TIPO_SANGUINEO');
        $DatosPaciente->ID_NACIONALIDAD = $request->input('ID_NACIONALIDAD');
        $DatosPaciente->ID_TIPO_PACIENTE = $request->input('ID_TIPO_PACIENTE');
        $DatosPaciente->TELEFONO_CASA = $request->input('TELEFONO_CASA');
        $DatosPaciente->TELEFONO_CELULAR = $request->input('TELEFONO_CELULAR');
        $DatosPaciente->E_MAIL = $request->input('E_MAIL');
        $DatosPaciente->OCUPACION = $request->input('OCUPACION');
        $DatosPaciente->ID_RESIDENCIA_HABITUAL = $ID_RESIDENCIA_HABITUAL;
        $DatosPaciente->RESIDENCIA_TRANSITORIA = $resTransitoria;
        $DatosPaciente->NOMBRE_PADRE = $request->input('NOMBRE_PADRE');
        $DatosPaciente->NOMBRE_MADRE = $request->input('NOMBRE_MADRE');
        $DatosPaciente->FECHA_INGRESO = $request->input('FECHA_INGRESO');
        $DatosPaciente->CUIDADOR = $request->input('CUIDADOR');
        $DatosPaciente->PARENTEZCO_CUIDADOR = $request->input('PARENTEZCO_CUIDADOR');        
        $DatosPaciente->save();
        $ID_PACIENTE = $DatosPaciente->ID_PACIENTE;

        $Paciente = new \App\Paciente;
        $Paciente->ID_USUARIO = $ID_USUARIO;
        $Paciente->ID_PACIENTE = $ID_PACIENTE;
        $Paciente->save();

        $request->session()->flash('msj_success', 'El paciente '.$DatosPaciente->full_name.' se ha registrado Correctamente');
        return redirect()->to('/');
    }

    //SOAP: Cargar los datos del paciente para editarlo
    public function editPacienteSoap($id, $id_categoria = null){
        //Busca el paciente, sino lo encuentra enviara un error 404
        $paciente = \App\DatoPaciente::findOrFail($id);

        //Llenamos todos los campos extras del formulario con la misma variable $paciente.
        $Paciente = \App\Paciente::where('ID_PACIENTE', $paciente->ID_PACIENTE)->first();
        $ID_USUARIO = $Paciente->ID_USUARIO;
        $Usuario = \App\User::where('ID_USUARIO', $ID_USUARIO)->first();
        $paciente->NO_IDENTIFICACION = $Usuario->NO_IDENTIFICACION;
        $PreferenciasRecuperacion = \App\PreferenciaRecuperacionAcceso::where('ID_USUARIO', $ID_USUARIO)->first();
        if($PreferenciasRecuperacion->USAR_PREGUNTA_SEGURIDAD == 1){
            $paciente->PREFERENCIA_RECUPERACION = 1;
        }else{
            $paciente->PREFERENCIA_RECUPERACION = 3;
        }
        $DatosAutenticacion = \App\DatoAutenticacionUsuario::where('ID_USUARIO', $ID_USUARIO)->first();
        $paciente->ID_PREGUNTA = $DatosAutenticacion->ID_PREGUNTA;
        $paciente->RESPUESTA = $DatosAutenticacion->RESPUESTA;
        $ResidenciaHabitual = \App\ResidenciaHabitual::where('ID_RESIDENCIA_HABITUAL', $paciente->ID_RESIDENCIA_HABITUAL)->first();
        $paciente->ID_PROVINCIA = $ResidenciaHabitual->ID_PROVINCIA;
        $paciente->ID_DISTRITO = $ResidenciaHabitual->ID_DISTRITO;
        $paciente->ID_CORREGIMIENTO = $ResidenciaHabitual->ID_CORREGIMIENTO;
        $paciente->ID_ZONA = $ResidenciaHabitual->ID_ZONA;

        $paciente->detalleResidencia = $ResidenciaHabitual->DETALLE;

        if($id_categoria != null){
            $paciente->categoria = $id_categoria;
        }

        return view('pacientes.edit-paciente-soap', compact('paciente'));
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

    public function errorUpdate($id, $errors){

        $DatosPaciente = \App\DatoPaciente::where('ID_PACIENTE', $id)->first();
        $Paciente = \App\Paciente::where('ID_PACIENTE', $id)->first();
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

        return view('pacientes.edit')->with('datos', $DatosPaciente)->with('errors', $errors);
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
        $paciente = new \App\DatoPaciente;        
        $v = $paciente->validar($request->all(), 'update', $id);
        if($v){
            return $this->errorUpdate($id, $v->errors());
        }       

        $fecha = explode('-', $request->input('FECHA_NACIMIENTO'));        
        $ID_RESIDENCIA_HABITUAL = \App\DatoPaciente::where('ID_PACIENTE', $id)->first()->ID_RESIDENCIA_HABITUAL;

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
        $DatosPaciente->EDAD_PACIENTE = calcular_edad($fecha);
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

        \Session::flash('mensaje', 'El paciente "'. $DatosPaciente->full_name.'", se editó exitosamente');
        return redirect()->route('pacientes.index');

    }

    //SOAP: actualizar los datos del paciente
    public function updatePacienteSoap(Request $request, $id){
        $paciente = new \App\DatoPaciente;        
        $v = $paciente->validar($request->all(), 'update', $id);
        if($v){
            return redirect()->back()->withErrors($v)->withInput();
        }
        
        if($request->input('tipoResidencia') == 1){
            $resPermanente = $request->input('detalleResidencia');
            $resTransitoria = '';
        }else{
            $resPermanente = '';
            $resTransitoria = $request->input('detalleResidencia');
        }
        
        $fecha = explode('-', $request->input('FECHA_NACIMIENTO'));        
        $ID_RESIDENCIA_HABITUAL = \App\DatoPaciente::where('ID_PACIENTE', $id)->first()->ID_RESIDENCIA_HABITUAL;

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
        $DatosPaciente->EDAD_PACIENTE = calcular_edad($fecha);
        $DatosPaciente->ID_ETNIA = $request->input('ID_ETNIA');
        $DatosPaciente->ID_TIPO_SANGUINEO = $request->input('ID_TIPO_SANGUINEO');
        $DatosPaciente->ID_NACIONALIDAD = $request->input('ID_NACIONALIDAD');
        $DatosPaciente->ID_TIPO_PACIENTE = $request->input('ID_TIPO_PACIENTE');
        $DatosPaciente->TELEFONO_CASA = $request->input('TELEFONO_CASA');
        $DatosPaciente->TELEFONO_CELULAR = $request->input('TELEFONO_CELULAR');
        $DatosPaciente->E_MAIL = $request->input('E_MAIL');
        $DatosPaciente->OCUPACION = $request->input('OCUPACION');
        $DatosPaciente->ID_RESIDENCIA_HABITUAL = $ID_RESIDENCIA_HABITUAL;
        $DatosPaciente->RESIDENCIA_TRANSITORIA = $resTransitoria;
        $DatosPaciente->NOMBRE_PADRE = $request->input('NOMBRE_PADRE');
        $DatosPaciente->NOMBRE_MADRE = $request->input('NOMBRE_MADRE');
        $DatosPaciente->FECHA_INGRESO = $request->input('FECHA_INGRESO');
        $DatosPaciente->CUIDADOR = $request->input('CUIDADOR');
        $DatosPaciente->PARENTEZCO_CUIDADOR = $request->input('PARENTEZCO_CUIDADOR');
        $DatosPaciente->TIPO_SEGURO = $request->input('TIPO_SEGURO');
        $DatosPaciente->save();

        $ID_USUARIO = \App\Paciente::where('ID_PACIENTE', $id)->first()->ID_USUARIO;
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
        $ResidenciaHabitual->DETALLE = $resPermanente;
        $ResidenciaHabitual->save();

        $request->session()->flash('msj_success', 'Se ha actualizado correctamente el paciente '.$DatosPaciente->full_name);
        return redirect()->back();
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
