<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trazabilidad extends Model
{
    protected $primaryKey = 'ID_TRAZABILIDAD';
    public $timestamps = false;
    protected $table = 'trazabilidad';


 	public static function getTrazabilidad($id){

 		$trazabilidad = new \App\Trazabilidad;
        $hora = new \Carbon;
        $ID_TRAZABILIDAD = $id.'_'.$hora->format('d-m-Y').'_'.$hora->toTimeString();

        $trazabilidad->ID_TRAZABILIDAD = $ID_TRAZABILIDAD;
        $trazabilidad->ID_PACIENTE = $id;
        $trazabilidad->FECHA = dateNow();
        $trazabilidad->save();

        return $ID_TRAZABILIDAD;
 	}
}

