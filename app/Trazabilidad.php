<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trazabilidad extends Model
{
    protected $primaryKey = 'ID_TRAZABILIDAD';
    public $timestamps = false;
    protected $table = 'trazabilidad';


 	public static function getTrazabilidad($id){
        $hora = new \Carbon;
        $ID_TRAZABILIDAD = $id.'_'.$hora->format('d-m-Y').'_'.$hora->toTimeString();

        return $ID_TRAZABILIDAD;
 	}
}

