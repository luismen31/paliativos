<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaReferencia extends Model
{
    public $timestamps = false;
    protected $table = 'respuesta_referencia';
    protected $primaryKey = "ID_RESPUESTA_REFERENCIA";
}
