<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleDiagnosticoEgreso extends Model
{
    protected $primaryKey = 'ID_DIAGNOSTICO_EGRESO';
    public $timestamps = false;
    protected $table = 'detalle_diagnostico_egreso';
}
