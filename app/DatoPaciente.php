<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoPaciente extends Model
{
	protected $primaryKey = 'ID_PACIENTE';
	public $timestamps = false;
    protected $table = 'datos_pacientes';

    public function validar($request, $type, $id = null){
    	if($type == 'store'){
	    	$rules = [
	            'NO_CEDULA' => ['required', 'unique:datos_pacientes,NO_CEDULA'],
	            'PRIMER_NOMBRE' => 'required',
	            'APELLIDO_PATERNO' => 'required',
	            'FECHA_NACIMIENTO' => ['required', 'date_format:Y-m-d'],
	            'ID_SEXO' => ['required', 'in:1,2'],
	            'E_MAIL' => ['required', 'email'],
	            'NO_IDENTIFICACION' => ['required', 'unique:usuarios,NO_IDENTIFICACION'],
	            'CLAVE_ACCESO' => ['required', 'max:60'],
	            'PREFERENCIA_RECUPERACION' => 'required',
	            'CUIDADOR' => 'required',
	            'PARENTEZCO_CUIDADOR' => 'required',
	            'FECHA_INGRESO' => ['required', 'date_format:Y-m-d'],
	            'ID_PROVINCIA' => 'required',
	            'ID_DISTRITO' => 'required',
	            'ID_CORREGIMIENTO' => 'required',	            
	    	];    		
    	}else{
    		//Obtiene el id_usuario para el paciente que se edita
    		$ID_USUARIO = \App\Paciente::where('ID_PACIENTE', $id)->first()->ID_USUARIO;
    		
    		$rules = [
	            'NO_CEDULA' => ['required', 'unique:datos_pacientes,NO_CEDULA,'.$id.',ID_PACIENTE'],
	            'PRIMER_NOMBRE' => 'required',
	            'APELLIDO_PATERNO' => 'required',
	            'E_MAIL' => ['required', 'email'],
	            'FECHA_NACIMIENTO' => ['required', 'date_format:Y-m-d'],
	            'ID_SEXO' => ['required', 'in:1,2'],
	            'E_MAIL' => ['required', 'email'],
	            'NO_IDENTIFICACION' => ['required', 'unique:usuarios,NO_IDENTIFICACION,'.$ID_USUARIO.',ID_USUARIO'],
	            'PREFERENCIA_RECUPERACION' => 'required',
	            'CUIDADOR' => 'required',
	            'PARENTEZCO_CUIDADOR' => 'required',
	            'FECHA_INGRESO' => ['required', 'date_format:Y-m-d'],
	            'ID_PROVINCIA' => 'required',
	            'ID_DISTRITO' => 'required',
	            'ID_CORREGIMIENTO' => 'required',
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
