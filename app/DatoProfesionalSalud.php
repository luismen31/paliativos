<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoProfesionalSalud extends Model
{
    protected $primaryKey = 'ID_PROFESIONAL';
    public $timestamps = false;
    protected $table = 'datos_profesionales_salud';


    public function validar($request, $type, $id = null){
    	
    	if($type == 'store'){
	    	$rules = [
	            'NO_CEDULA' => ['required', 'unique:datos_profesionales_salud,NO_CEDULA'],
	            'PRIMER_NOMBRE' => 'required',
	            'APELLIDO_PATERNO' => 'required',
	            'NO_IDONEIDAD' => 'required',
	            'E_MAIL' => ['required', 'email'],
	            'ID_GRUPO_USUARIO' => ['required', 'in:3,4,5'],
	            'ID_ESPECIALIDAD_MEDICA' => 'required',
	            'NO_IDENTIFICACION' => ['required', 'unique:usuarios,NO_IDENTIFICACION'],
	            'CLAVE_ACCESO' => ['required', 'max:60'],
	    	];    		
    	}else{
    		//Obtiene el id_usuario para el profesional que se edita
    		$ID_USUARIO = \App\ProfesionalSalud::where('ID_PROFESIONAL', $id)->first()->ID_USUARIO;
    		
    		$rules = [
	            'NO_CEDULA' => ['required', 'unique:datos_profesionales_salud,NO_CEDULA,'.$id.',ID_PROFESIONAL'],
	            'PRIMER_NOMBRE' => 'required',
	            'APELLIDO_PATERNO' => 'required',
	            'NO_IDONEIDAD' => 'required',
	            'E_MAIL' => ['required', 'email'],
	            'ID_GRUPO_USUARIO' => ['required', 'in:3,4,5'],
	            'ID_ESPECIALIDAD_MEDICA' => 'required',
	            'NO_IDENTIFICACION' => ['required', 'unique:usuarios,NO_IDENTIFICACION,'.$ID_USUARIO.',ID_USUARIO'],
	    	];
    	}
     	$validator = \Validator::make($request, $rules);	    
	    if($validator->fails()){
	        return $validator;
	    }else{
	    	return false;
	    }
    }

}
