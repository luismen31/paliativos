<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaInterconsulta extends Model
{
    public $timestamps = false;
    protected $table = 'respuesta_interconsulta';
    protected $primaryKey = "ID_RESPUESTA_INTERCONSULTA";
}
