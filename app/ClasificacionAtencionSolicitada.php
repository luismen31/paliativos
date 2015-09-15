<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasificacionAtencionSolicitada extends Model
{
    protected $primaryKey = 'ID_CLASIFICACION_ATENCION_SOLICITADA';
    public $timestamps = false;
    protected $table = 'clasificacion_atencion_solicitada';
}
