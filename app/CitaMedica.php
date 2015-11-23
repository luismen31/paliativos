<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitaMedica extends Model
{
	protected $primaryKey = 'ID_CITA';
	public $timestamps = false;
    protected $table = 'citas_medicas';

    //Funcion para filtrar solo por fecha
    public function scopeFecha($query, $fecha){
    	if(!empty($fecha)){
    		return $query->where('FECHA', $fecha);
    	}
    }
    //Funcion para filtrar solo por equipo
    public function scopeEquipo($query, $equipo, $change){
    	if(!empty($equipo)){
    		return $query->where('ID_EQUIPO_MEDICO', $change, $equipo);
    	}
    }    
}
